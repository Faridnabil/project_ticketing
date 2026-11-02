@echo off
echo =======================================================
echo MEMBUAT PAKET UPDATE APLIKASI TICKETING (update_package.tar.gz)
echo =======================================================

tar -czf update_package.tar.gz app config database resources routes .env.example deploy_with_backup.sh update_faq_schema.sql

if exist update_package.tar.gz (
    echo [SUKSES] File update_package.tar.gz berhasil dibuat!
    echo.
    echo Langkah selanjutnya:
    echo 1. Kirim ke server melalui SCP:
    echo    scp update_package.tar.gz deploy_with_backup.sh update_faq_schema.sql root@IP_SERVER:/var/www/project_ticketing/
    echo.
    echo 2. Login ke server via SSH lalu jalankan deploy script:
    echo    cd /var/www/project_ticketing
    echo    bash deploy_with_backup.sh
    echo =======================================================
) else (
    echo [ERROR] Gagal membuat file update_package.tar.gz!
)
