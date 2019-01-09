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
				<td>Image Url</td>
				<td>Size</td>
				<td>Date Registered</td>
			</tr>
		</thead>
		<tbody>
			@foreach($images as $image)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ url('/img/storage/'.$image->filename) }}</td>
				<td>{{ $image->size }}</td>
				
				<td>{{ \Carbon\Carbon::parse($image->created_at)->format("Y-m-d") }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</body>
</html>
