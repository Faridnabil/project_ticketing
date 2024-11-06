<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f7;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #1E1E2D;
            text-align: center;
        }

        .header {
            padding: 10px;
        }

        .content {
            padding: 20px;
        }

        .content h1 {
            font-size: 26px;
            margin-bottom: 20px;
            color: #333;
        }

        .content p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 30px;
        }

        .button {
            background-color: #1E1E2D;
            color: #ffffff !important;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
            display: inline-block;
        }

        .button:hover {
            background-color: #2A2A3A;
        }

        .footer {
            margin-top: 30px;
            color: #888;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Bagian Logo Kustom -->
        <div class="header">
            <img src="{{ $message->embed(public_path('template/dist/assets/media/logos/logo.png')) }}" alt="Logo Perusahaan" width="100%">
        </div>

        <!-- Bagian Konten -->
        <div class="content">
            <h1>Anda Menerima Tiket Baru!</h1>
            <p>Halo, Anda telah menerima tiket baru yang memerlukan perhatian Anda. Silakan klik tombol di bawah ini
                untuk melihat detail tiket dan melakukan tindakan yang diperlukan.</p>
            <a href="{{ $data['Url'] }}" class="button">{{ $data['Text'] ?: 'Cek Tiket Sekarang' }}</a>
        </div>

        <br><br><br>
        <hr>
        <!-- Bagian Footer -->
        <div class="footer">
            {{-- <p>Terima kasih,</p> --}}
            <p>Direktorat Jenderal Kependudukan dan Pencatatan Sipil Kementerian Dalam Negeri.</p>
        </div>
    </div>
</body>

</html>
