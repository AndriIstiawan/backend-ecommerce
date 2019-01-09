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
                <td>Include Tax</td>
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
						{{$product->brand[0]['slug']}}
					@endif
				</td>
				<td>
					<?php
                    $categories = $product->categories;
                    $parent = [];
                    for ($i=0; $i < count($categories); $i++) { 
                        if(count($categories[$i]['parent']) == 0){
                            $parent = $categories[$i];
                        }
                    }
                    $category = $parent;
                    $next = false;
                    $slug = $category['slug'];
                    $key = array_map(function ($x) use ($slug){
                        $key2 = array_map(function ($y) use ($slug){
                            return ($y['slug']==$slug?$y['slug']:'');
                        },$x['parent']);
                        return array_filter($key2);
                    },$categories);
                    $key = array_filter($key);

                    if(empty($key)){
                        print_r($slug);
                    }else{
                        if(isset($key[1])){
                            foreach ($key[1] as $obj) {
                                print_r($obj);
                            }
                        }else{
                            foreach ($key[0] as $obj) {
                                print_r($obj);
                            }
                        }
                    }
                    ?>
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
                <td>{{ isset($product->price[0]['tax_include']) ? $product->price[0]['tax_include'] : 'yes' }}</td>
				<td>{{ $product->stock ? $product->stock : '' }}</td>
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
                            <?php
                            $image_url = $image['filename'];
                            if(strpos($image['filename'], 'https://') === false && strpos($image['filename'], 'http://') === false ){
                                $image_url = url('/img/products/'.$image['filename']);
                            }
                            ?>
							{{ $image_url }}
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
