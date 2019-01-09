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
				<td>Product Name</td>
				<td>SKU</td>
				<td>Brand</td>
				<td>Category</td>
				<td>Price[min]</td>
				<td>Price[max]</td>
				<td>Product Stock</td>
				<td>Product Description</td>
				<td>Weight[unit]</td>
				<td>Weight[value]</td>
				<td>Main Image[URL]</td>
			</tr>
		</thead>
		<tbody>
			@foreach($products as $product)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $product->name }}</td>
				<td>{{ $product->sku }}</td>
				<td>
					@if($product->brand)
						@foreach($product->brand as $brand)
							{{ $brand['name'] }}
							@if($loop->last)
						    @elseif($loop->remaining == 1)
						        {{'|'}}
						    @endif
						@endforeach
					@endif
				</td>
				<td>
					@if($product->categories)
						@foreach($product->categories as $category)
							{{$category['name']}}
							@if($loop->last)
						    @elseif($loop->remaining == 1)
						        {{'|'}}
						    @endif
						@endforeach
					@endif
				</td>
				<td>
					@if($product->price)
						@foreach($product->price as $price)
							{{$price['min']}}
						@endforeach
					@endif
				</td>
				<td>
					@if($product->price)
						@foreach($product->price as $price)
							{{$price['max']}}
						@endforeach
					@endif
				</td>
				<td> {{ $product->stock ? $product->stock : '' }} </td>
				<td>{{ $product->description ? $product->description : '' }}</td>
				<td>
					@if($product->weight)
						@foreach($product->weight as $weight)
							{{$weight['unit']}}
						@endforeach
					@endif
				</td>
				<td>
					@if($product->weight)
						@foreach($product->weight as $weight)
							{{$weight['weight']}}
						@endforeach
					@endif
				</td>
				<td>
					@if($product->image)
						@foreach($product->image as $image)
							{{ url('/img/products/'.$image['filename']) }}

							@if($loop->last)
						    @elseif($loop->remaining == 1)
						        {{'|'}}
						    @endif
						@endforeach
						
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</body>
</html>