#!/usr/bin/env bash
# ==============================================================================
# SCRIPT DEPLOY, BACKUP & UPDATE APLIKASI + DATABASE PROJECT TICKETING
# ==============================================================================
# Fitur Utama:
# 1. Backup Database Remote otomatis (mysqldump --single-transaction) tanpa lock.
# 2. Backup Source Code & .env ke direktori bertanggal (timestamp).
# 3. Ekstrak update kode terbaru otomatis (jika ada update_package.tar.gz).
# 4. Update Schema & Penambahan Tabel/Kolom Database secara AMAN (Zero Data Loss).
# 5. Eksekusi Laravel Migration & Reset Cache aplikasi.
# 6. Pembuatan script Rollback 1-klik otomatis jika terjadi kendala.
# ==============================================================================

set -e

# Warna Terminal untuk Output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
NC='\033[0m'

TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
PROJECT_ROOT=$(pwd)

# Lokasi backup: Utamakan /root/backup_project_ticketing jika root, atau ./backups jika non-root
if [ -w "/root" ]; then
    BACKUP_ROOT="/root/backup_project_ticketing"
else
    BACKUP_ROOT="$PROJECT_ROOT/backups"
fi
BACKUP_DIR="$BACKUP_ROOT/backup_$TIMESTAMP"

echo -e "${CYAN}======================================================================${NC}"
echo -e "${CYAN}   MEMULAI PROSES DEPLOYMENT & UPDATE AMAN (PROJECT TICKETING)         ${NC}"
echo -e "${CYAN}   Waktu: $(date)                                                     ${NC}"
echo -e "${CYAN}======================================================================${NC}"

# ------------------------------------------------------------------------------
# 1. Validasi Direktori & File Konfigurasi
# ------------------------------------------------------------------------------
echo -e "\n${YELLOW}[1/6] Memeriksa Lingkungan & Konfigurasi...${NC}"

if [ ! -f "artisan" ] || [ ! -f ".env" ]; then
    echo -e "${RED}[ERROR] Script harus dijalankan di direktori root Laravel project!${NC}"
    echo -e "${RED}Pastikan Anda berada di folder aplikasi (tempat file 'artisan' dan '.env' berada).${NC}"
    exit 1
fi

if ! command -v mysqldump &> /dev/null; then
    echo -e "${RED}[ERROR] Perintah 'mysqldump' tidak ditemukan di server ini!${NC}"
    echo -e "${YELLOW}Silakan install mysql/mariadb client terlebih dahulu (contoh: yum install -y mysql / apt-get install -y default-mysql-client).${NC}"
    exit 1
fi

# Parsing kredensial database dari .env
DB_CONNECTION=$(grep -E "^DB_CONNECTION=" .env | cut -d '=' -f2- | tr -d '"\r ')
DB_HOST=$(grep -E "^DB_HOST=" .env | cut -d '=' -f2- | tr -d '"\r ')
DB_PORT=$(grep -E "^DB_PORT=" .env | cut -d '=' -f2- | tr -d '"\r ')
DB_DATABASE=$(grep -E "^DB_DATABASE=" .env | cut -d '=' -f2- | tr -d '"\r ')
DB_USERNAME=$(grep -E "^DB_USERNAME=" .env | cut -d '=' -f2- | tr -d '"\r ')
DB_PASSWORD=$(grep -E "^DB_PASSWORD=" .env | cut -d '=' -f2- | tr -d '"\r ')

DB_PORT=${DB_PORT:-3306}
DB_HOST=${DB_HOST:-127.0.0.1}

if [ -n "$DB_PASSWORD" ]; then
    MYSQL_PWD_ARG="-p$DB_PASSWORD"
else
    MYSQL_PWD_ARG=""
fi

echo -e "  - Direktori Project : ${BLUE}$PROJECT_ROOT${NC}"
echo -e "  - Target DB Host    : ${BLUE}$DB_HOST:$DB_PORT${NC}"
echo -e "  - Nama Database     : ${BLUE}$DB_DATABASE${NC}"
echo -e "  - DB User           : ${BLUE}$DB_USERNAME${NC}"

# Tes koneksi ke database remote sebelum memulai
if ! mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" $MYSQL_PWD_ARG -e "SELECT 1;" "$DB_DATABASE" &> /dev/null; then
    echo -e "${RED}[ERROR] Gagal terhubung ke database $DB_DATABASE di $DB_HOST:$DB_PORT!${NC}"
    echo -e "${RED}Periksa kembali koneksi jaringan atau password DB di file .env.${NC}"
    exit 1
fi
echo -e "${GREEN}[OK] Koneksi ke database berhasil!${NC}"

# Buat folder backup
mkdir -p "$BACKUP_DIR"
echo -e "${GREEN}[OK] Folder backup siap: $BACKUP_DIR${NC}"

# ------------------------------------------------------------------------------
# 2. Backup Database Remote Secara Aman (Single Transaction / No Table Locking)
# ------------------------------------------------------------------------------
echo -e "\n${YELLOW}[2/6] Membackup Database '$DB_DATABASE' dari $DB_HOST...${NC}"
DB_DUMP_FILE="$BACKUP_DIR/db_${DB_DATABASE}_$TIMESTAMP.sql"

mysqldump -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" $MYSQL_PWD_ARG \
    --single-transaction \
    --quick \
    --routines \
    --triggers \
    --no-tablespaces \
    "$DB_DATABASE" > "$DB_DUMP_FILE"

if [ -s "$DB_DUMP_FILE" ]; then
    DB_RAW_SIZE=$(du -h "$DB_DUMP_FILE" | cut -f1)
    # Kompres dump SQL agar hemat ruang disk
    gzip -k "$DB_DUMP_FILE"
    DB_GZ_SIZE=$(du -h "$DB_DUMP_FILE.gz" | cut -f1)
    echo -e "${GREEN}[OK] Database berhasil dibackup!${NC}"
    echo -e "     Ukuran file: $DB_RAW_SIZE (terkompresi: $DB_GZ_SIZE)"
else
    echo -e "${RED}[ERROR] File backup database kosong atau gagal dibuat!${NC}"
    echo -e "${RED}Membatalkan proses update untuk mencegah risiko kehilangan data.${NC}"
    exit 1
fi

# ------------------------------------------------------------------------------
# 3. Backup Source Code & Konfigurasi .env
# ------------------------------------------------------------------------------
echo -e "\n${YELLOW}[3/6] Membackup File Aplikasi & Konfigurasi (.env)...${NC}"
APP_BACKUP_TAR="$BACKUP_DIR/app_files_$TIMESTAMP.tar.gz"

# Salin juga .env secara mandiri
cp .env "$BACKUP_DIR/.env.backup"

tar -czf "$APP_BACKUP_TAR" \
    --exclude='./storage/framework/cache/*' \
    --exclude='./storage/framework/sessions/*' \
    --exclude='./storage/framework/views/*' \
    --exclude='./storage/logs/*' \
    --exclude='./node_modules' \
    --exclude='./backups' \
    .

if [ -s "$APP_BACKUP_TAR" ]; then
    APP_SIZE=$(du -h "$APP_BACKUP_TAR" | cut -f1)
    echo -e "${GREEN}[OK] File aplikasi berhasil dibackup ($APP_SIZE)!${NC}"
else
    echo -e "${RED}[ERROR] File backup aplikasi gagal dibuat!${NC}"
    exit 1
fi

# Buat script Rollback otomatis di dalam folder backup
cat << 'EOF' > "$BACKUP_DIR/rollback.sh"
#!/usr/bin/env bash
set -e
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${YELLOW}=====================================================${NC}"
echo -e "${YELLOW}       PROSES RESTORE / ROLLBACK DATABASE & APP      ${NC}"
echo -e "${YELLOW}=====================================================${NC}"
read -p "Apakah Anda yakin ingin mengembalikan sistem ke kondisi backup ini? (y/N): " CONFIRM
if [[ "$CONFIRM" != "y" && "$CONFIRM" != "Y" ]]; then
    echo "Rollback dibatalkan."
    exit 0
fi

DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_PATH="$(cd "$DIR/../../" && pwd)"
cd "$PROJECT_PATH"

# Ambil kredensial DB
DB_HOST=$(grep -E "^DB_HOST=" .env | cut -d '=' -f2- | tr -d '"\r ')
DB_PORT=$(grep -E "^DB_PORT=" .env | cut -d '=' -f2- | tr -d '"\r ')
DB_DATABASE=$(grep -E "^DB_DATABASE=" .env | cut -d '=' -f2- | tr -d '"\r ')
DB_USERNAME=$(grep -E "^DB_USERNAME=" .env | cut -d '=' -f2- | tr -d '"\r ')
DB_PASSWORD=$(grep -E "^DB_PASSWORD=" .env | cut -d '=' -f2- | tr -d '"\r ')

if [ -n "$DB_PASSWORD" ]; then
    MYSQL_PWD_ARG="-p$DB_PASSWORD"
else
    MYSQL_PWD_ARG=""
fi

# 1. Restore Database
SQL_GZ=$(ls "$DIR"/db_*.sql.gz 2>/dev/null | head -n 1)
SQL_RAW=$(ls "$DIR"/db_*.sql 2>/dev/null | head -n 1)

if [ -f "$SQL_GZ" ]; then
    echo "Restoring database dari $SQL_GZ..."
    gunzip -c "$SQL_GZ" | mysql -h "$DB_HOST" -P "${DB_PORT:-3306}" -u "$DB_USERNAME" $MYSQL_PWD_ARG "$DB_DATABASE"
elif [ -f "$SQL_RAW" ]; then
    echo "Restoring database dari $SQL_RAW..."
    mysql -h "$DB_HOST" -P "${DB_PORT:-3306}" -u "$DB_USERNAME" $MYSQL_PWD_ARG "$DB_DATABASE" < "$SQL_RAW"
fi
echo -e "${GREEN}[OK] Database berhasil dipulihkan!${NC}"

# 2. Restore File Aplikasi
APP_TAR=$(ls "$DIR"/app_files_*.tar.gz 2>/dev/null | head -n 1)
if [ -f "$APP_TAR" ]; then
    echo "Restoring file aplikasi dari $APP_TAR..."
    tar -xzf "$APP_TAR" -C "$PROJECT_PATH"
    echo -e "${GREEN}[OK] File aplikasi berhasil dipulihkan!${NC}"
fi

# 3. Clear Cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo -e "\n${GREEN}=====================================================${NC}"
echo -e "${GREEN} Rollback Sukses! Sistem kembali ke kondisi semula.  ${NC}"
echo -e "${GREEN}=====================================================${NC}"
EOF
chmod +x "$BACKUP_DIR/rollback.sh"
echo -e "${GREEN}[OK] Script rollback 1-klik siap di: $BACKUP_DIR/rollback.sh${NC}"

# ------------------------------------------------------------------------------
# 4. Menerapkan Update Kode Terbaru (Jika Tersedia Paket Update)
# ------------------------------------------------------------------------------
echo -e "\n${YELLOW}[4/6] Memeriksa & Menerapkan Update Kode Terbaru...${NC}"
PACKAGE_APPLIED=0

if [ -f "$PROJECT_ROOT/update_package.tar.gz" ]; then
    echo -e "${CYAN}Ditemukan file update_package.tar.gz di direktori project. Mengekstrak...${NC}"
    tar -xzf "$PROJECT_ROOT/update_package.tar.gz" -C "$PROJECT_ROOT"
    rm -f "$PROJECT_ROOT/update_package.tar.gz"
    PACKAGE_APPLIED=1
    echo -e "${GREEN}[OK] Kode terbaru dari update_package.tar.gz berhasil diterapkan!${NC}"
elif [ -f "/tmp/update_package.tar.gz" ]; then
    echo -e "${CYAN}Ditemukan file /tmp/update_package.tar.gz. Mengekstrak...${NC}"
    tar -xzf "/tmp/update_package.tar.gz" -C "$PROJECT_ROOT"
    rm -f "/tmp/update_package.tar.gz"
    PACKAGE_APPLIED=1
    echo -e "${GREEN}[OK] Kode terbaru dari /tmp/update_package.tar.gz berhasil diterapkan!${NC}"
else
    echo -e "${BLUE}[INFO] Tidak ditemukan file archive update_package.tar.gz.${NC}"
    echo -e "${BLUE}       Menggunakan file source code yang sudah ditransfer (via scp/git).${NC}"
fi

# Pastikan permission folder storage & cache tetap dapat ditulis oleh web server
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# ------------------------------------------------------------------------------
# 5. Eksekusi Update Schema & Migrasi Database Tanpa Menghilangkan Data
# ------------------------------------------------------------------------------
echo -e "\n${YELLOW}[5/6] Memperbarui Database (Tabel & Kolom Baru Secara Aman)...${NC}"

# A. Jalankan update_faq_schema.sql jika ada (Idempotent DDL: CREATE TABLE IF NOT EXISTS & AddColumnIfNotExists)
if [ -f "$PROJECT_ROOT/update_faq_schema.sql" ]; then
    echo -e "Menjalankan patch schema FAQ (update_faq_schema.sql)..."
    mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" $MYSQL_PWD_ARG "$DB_DATABASE" < "$PROJECT_ROOT/update_faq_schema.sql"
    echo -e "${GREEN}[OK] Tabel & kolom FAQ (faqs, logs, api_keys, unsolved) berhasil dipastikan ada!${NC}"
fi

# B. Jalankan Laravel Migration bawaan
echo -e "Menjalankan 'php artisan migrate --force'..."
php artisan migrate --force
echo -e "${GREEN}[OK] Migrasi Laravel selesai tanpa menghapus data yang ada!${NC}"

# ------------------------------------------------------------------------------
# 6. Pembersihan & Regenerasi Cache Laravel
# ------------------------------------------------------------------------------
echo -e "\n${YELLOW}[6/6] Membersihkan dan Memperbarui Cache Aplikasi...${NC}"
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Opsional: cache config & view untuk performa maksimal di production
php artisan config:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true

echo -e "\n${GREEN}======================================================================${NC}"
echo -e "${GREEN}   SELURUH PROSES DEPLOYMENT & UPDATE BERHASIL SUKSES!               ${NC}"
echo -e "${GREEN}======================================================================${NC}"
echo -e " Lokasi Folder Backup: ${CYAN}$BACKUP_DIR${NC}"
echo -e "   - Database Dump   : db_${DB_DATABASE}_$TIMESTAMP.sql.gz"
echo -e "   - File Aplikasi   : app_files_$TIMESTAMP.tar.gz"
echo -e "   - Konfigurasi .env: .env.backup"
echo -e "   - Script Rollback : ${YELLOW}$BACKUP_DIR/rollback.sh${NC}"
echo -e "${GREEN}======================================================================${NC}\n"
