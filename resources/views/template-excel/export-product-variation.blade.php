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
				<td>Product SKU</td>
				<td>Variant Key Name</td>
				<td>Image Variant Url</td>
				<td>Price</td>
				<td>SKU</td>
				<td>Stock</td>
			</tr>
		</thead>
		<tbody>
			@foreach($products as $product)
				@if($product->variant)
					@foreach($product->variant as $variant)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $product->sku }}</td>
							<td>{{ $variant['key'] }}</td>
							<td>
                            <?php
                            $image_url = ($variant['image']!=''||$variant['image']!=null?$variant['image']:'');
                            if(strpos($variant['image'], 'https://') === false && strpos($variant['image'], 'http://') === false ){
                                $image_url = ($variant['image']!=''||$variant['image']!=null?url('/img/products/'.$variant['image']):'');
                            }
                            ?>
                            {{ $image_url }}
                            </td>
							<td>{{ $variant['price'] }}</td>
							<td>{{ $variant['sku'] }}</td>
							<td>{{ $variant['stock'] }}</td>
						</tr>
					@endforeach
					@endif
			@endforeach
		</tbody>
	</table>

</body>
</html>
