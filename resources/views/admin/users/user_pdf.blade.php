<!DOCTYPE html>
<html>

<head>
    <title>Laporan Helpdesk Support Ticketing</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
    <center>
        <h4>Laporan Data User Support Ticketing</h4>
    </center>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Email</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            
            @foreach ($users as $p)

                <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td class="text-center">{{ $p->name }}</td>
                    <td class="text-center">{{ $p->email }}</td>
                </tr>

            @endforeach

        </tbody>
    </table>
</body>

</html>
