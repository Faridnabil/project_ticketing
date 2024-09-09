<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4CAF50;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .ticket-details {
            margin-bottom: 20px;
        }

        .ticket-details span {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        .ticket-details span strong {
            color: #333;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Ticket Report: {{ $ticket->category->category_name }}</h1>
        <hr>
        <p>Dear {{ $ticket->name }},</p>
        <p>Terima kasih untuk laporan yang Anda berikan. Mohon tunggu, laporan Anda akan segera diproses oleh tim
            terkait.</p>
        <hr>
        <div class="ticket-details">
            <span><strong>Nomor Tiket:</strong> {{ $ticket->no_ticket }}</span><br>
            <span><strong>Judul:</strong> {{ $ticket->title }}</span><br>
            <span><strong>Ditugaskan ke:</strong> {{ $ticket->assignTo->name }}</span><br>
            <span><strong>Prioritas:</strong> {{ $ticket->priority->priority_name }}</span><br>
            <span><strong>Service:</strong> {{ $ticket->service->service_name }}</span><br>
            {{-- <span><strong>Kategori:</strong> {{ $ticket->category->category_name }}</span><br> --}}
            <span><strong>Deskripsi:</strong> {{ strip_tags($ticket->description) }}</span><br>
            <span><strong>Dibuat:</strong> {{ date('d F Y H:i', strtotime($ticket->created_at)) }}</span>
        </div>
        <hr>
        <div class="footer">
            <p>Terima kasih</p>
            <p>&copy; {{ date('Y') }} PLN Icon Plus. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
