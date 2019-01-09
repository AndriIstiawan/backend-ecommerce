<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   
</head>
<STYLE TYPE="text/css">
	table {
		  border-collapse:collapse;
		}
</STYLE>
<body>
	<table>
		<thead>
			<tr>
				<td>No</td>
				<td>Name</td>
				<td>Email</td>
				<td>Phone</td>
				<td>Level</td>
				<td>Type</td>
				<td>Status</td>
				<td>Date Registred</td>
			</tr>
		</thead>
		<tbody>
			@foreach($members as $member)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $member->name }}</td>
				<td>{{ $member->email }}</td>
				<td>{{ $member->phone }}</td>
				<td>
					@if($member->level)
						@foreach($member->level as $level)
							{{ $level['name'] }}
						@endforeach
					@endif
				</td>
				<td>
					@if($member->type)
						@foreach($member->type as $type)
							{{ $type['type'] }}
							@if($loop->last)
						    @elseif($loop->remaining == 1)
						        {{'|'}}
						    @endif
						@endforeach
					@endif
				</td>
				<td>{{ $member->status }}</td>
				<td>{{ \Carbon\Carbon::parse($member->created_at)->format("Y-m-d") }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</body>
</html>
