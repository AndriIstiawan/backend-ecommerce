@extends('master') 
@section('content')
<div class="container-fluid">
    <p>
        <a class="btn btn-primary" href="{{route('cart.index')}}">
            <i class="fa fa-backward"></i>&nbsp; Back to List
        </a>
    </p>
</div>
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <!--/.col-->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-user"></i> Data Member
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive-sm">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-user-circle-o"></i> IP</th>
                                    <th><i class="fa fa-user-circle-o"></i> Name</th>
                                    <th><i class="fa fa-envelope"></i> Email</th>
                                    <th><i class="fa fa-status"></i> Cart Status</th>
                                    <th><i class="fa fa-status"></i> Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{(isset($cart->IP)?$cart->IP:'')}}</td>
                                    <td>{{(isset($cart->member[0]['name'])?$cart->member[0]['name']:'')}}</td>
                                    <td>{{(isset($cart->member[0]['email'])?$cart->member[0]['email']:'')}}</td>
                                    <td>{{(isset($cart->status)?$cart->status:'')}}</td>
                                    <td>{{(isset($cart->total_price)?'Rp. '.str_replace(',00','',number_format($cart->total_price,2,',','.')):'')}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/.row-->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header with-border"><span><i class="fa fa-shopping-cart"></i> Products</span>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart->products as $prod_list)
                                    <tr>
                                        <td class="vertical-align-middle">{{$prod_list['variant']}}</td>
                                        <td class="vertical-align-middle">Rp. {{str_replace(',00','',number_format($prod_list['price'],2,',','.'))}}</td>
                                        <td class="vertical-align-middle">{{$prod_list['quantity']}}</td>
                                        <td class="vertical-align-middle text-right">Rp. {{str_replace(',00','',number_format($prod_list['totalPrice'],2,',','.'))}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-condensed">
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <strong>Total:</strong>
                                        </td>
                                        <td class="text-right">
                                            <strong>{{(isset($cart->total_price)?'Rp. '.str_replace(',00','',number_format($cart->total_price,2,',','.')):'')}}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->
        @if(isset($inquiry['id']))
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header with-border"><span><i class="fa fa-shopping-cart"></i> Custom Inquiry</span>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap">Product Image</th>
                                        <th class="text-nowrap">Product Name</th>
                                        <th class="text-nowrap">Product Detail</th>
                                        <th class="text-nowrap">Status</th>
                                        <th class="text-nowrap">Price</th>
                                        <th class="text-nowrap">Quantity</th>
                                        <th class="text-nowrap text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inquiry->inquiries as $inq)
                                    <tr>
                                        <td class="vertical-align-middle">
                                            <a href="{{$inq['productImage']}}" target="_blank">
                                                <img class="rounded" src="{{$inq['productImage']}}" style="width: 60px; height: 60px;">
                                            </a>
                                        </td>
                                        <td class="vertical-align-middle">{{$inq['productName']}}</td>
                                        <td class="vertical-align-middle">{{$inq['description']}}</td>
                                        <td class="vertical-align-middle">
                                            @foreach($inq['status'] as $statusInq)
                                            <div class="list-group">
                                                <div class="list-group-item list-group-item-action flex-column align-items-start">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h6 class="mb-1">{{$statusInq['statusType']}}</h6>
                                                    </div>
                                                    @if($statusInq['statusNote'] != '')
                                                    <p class="mb-1">Note : {{$statusInq['statusNote']}}</p>
                                                    @endif
                                                    @if(isset($statusInq['statusApproved']))
                                                    <small>Approve by Admin</small>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                        </td>
                                        <td class="vertical-align-middle">Rp. {{str_replace(',00','',number_format($inq['price'],2,',','.'))}}</td>
                                        <td class="vertical-align-middle">{{$inq['quantity']}}</td>
                                        <td class="vertical-align-middle text-right">Rp. {{str_replace(',00','',number_format($inq['totalPrice'],2,',','.'))}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-condensed">
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->
        @endif
    </div>

</div>
@endsection