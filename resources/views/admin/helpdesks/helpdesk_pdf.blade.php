<!DOCTYPE html>
<html>
<head>
	<title>Laporan Helpdesk Support Ticketing</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
		<h5>Laporan Helpdesk Support Ticketing</h4>
            
	</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Ticket ID</th>
				<th class="text-center">Subject</th>
				<th class="text-center">Email</th>
				<th class="text-center">Message</th>
				<th class="text-center">Priority</th>
				<th class="text-center">Eskalasi Waktu</th>
				<th class="text-center">Status</th>
				<th class="text-center">User</th>
				<th class="text-center">Create at</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($helpdesks as $p)
			<tr>
				<td class="text-center">{{ $i++ }}</td>
				<td class="text-center">{{$p->ticket_id}}</td>
				<td class="text-center">{{$p->subject}}</td>
				<td class="text-center">{{$p->email_address}}</td>
				<td class="text-center">{{$p->message}}</td>
				<td class="text-center">{{$p->priority->name}}</td>
				<td class="text-center">{{$p->priority->escalation_time . " jam"}}</td>
				<td class="text-center">{{$p->status->name}}</td>
				<td class="text-center">{{$p->user->name}}</td>
				<td class="text-center">{{\Carbon\Carbon::parse($p->created_at)->timezone('Asia/Jakarta')->locale('id')->isoFormat('LLLL')}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>
