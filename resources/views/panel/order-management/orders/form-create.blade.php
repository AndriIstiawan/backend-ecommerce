@extends('master') @section('content')
<link href="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/datatables/responsive.dataTables.min.css') }}" rel="stylesheet">
<div class="container-fluid">
    <p>
        <a class="btn btn-primary" href="{{route('orders.index')}}">
            <i class="fa fa-backward"></i>&nbsp; Back to List
        </a>
    </p>
</div>
<div class="container-fluid">
    <div class="animated fadeIn">
        <!--/.row-->
        <div class="row">
            <!--/.col-->
            <div class="col-md-12 mb-4">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#courier-tab" role="tab" aria-controls="messages">
                            @php $courier_set = false; @endphp 
                            @if($order['status'] == 'waiting courier cost') 
                            @php $courier_set = true; @endphp
                            <span class="badge badge-pill badge-danger">
                                <i class="fa fa-info"></i>
                            </span>
                            @else
                            <i class="fa fa-truck"></i>
                            @endif Courier
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#note-tab" role="tab" aria-controls="home">
                            <i class="fa fa-bars"></i> Note
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="courier-tab" role="tabpanel">
                        <div class="row-md">
                            <div class="col-md-12">
                                <div class="row-md">
                                    <div class="col-md-12">
                                        <i class="fa fa-align-justify"></i>&nbsp;{{(isset($order->courier[0]['name'])?$order->courier[0]['name']:'')}}
                                        <hr>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label">
                                                <strong>From</strong>
                                            </label>
                                            <div class="col-md-3">
                                                <input type="text" id="text-service" name="text-service" class="form-control" value="{{(isset($order->courier[0]['detail'][0]['location'][0]['city_name'])?$order->courier[0]['detail'][0]['location'][0]['city_name']:'')}}"
                                                    readonly>
                                            </div>
                                            <label class="col-md-2 col-form-label">
                                                <strong>To</strong>
                                            </label>
                                            <div class="col-md-3">
                                                <input type="text" id="text-service" name="text-service" class="form-control" value="{{(isset($order->cart[0]['address'][0]['city_name'])?$order->cart[0]['address'][0]['city_name']:'')}}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label">
                                                <strong>Receiver Name</strong>
                                            </label>
                                            <div class="col-md-3">
                                                <input type="text" id="text-service" name="text-service" class="form-control" value="{{(isset($order->cart[0]['address'][0]['receiver_name'])?$order->cart[0]['address'][0]['receiver_name']:'')}}"
                                                    readonly>
                                            </div>
                                            <label class="col-md-2 col-form-label">
                                                <strong>Phone Number</strong>
                                            </label>
                                            <div class="col-md-3">
                                                <input type="text" id="text-service" name="text-service" class="form-control" value="{{(isset($order->cart[0]['address'][0]['phone_number'])?$order->cart[0]['address'][0]['phone_number']:'')}}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label">
                                                <strong>Postal Code</strong>
                                            </label>
                                            <div class="col-md-3">
                                                <input type="text" id="text-service" name="text-service" class="form-control" value="{{(isset($order->cart[0]['address'][0]['postal_code'])?$order->cart[0]['address'][0]['postal_code']:'')}}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row-md">
                                            <label class="col-form-label" for="text-service">
                                                <strong>Address</strong>
                                            </label>
                                            <textarea class="form-control" readonly>{{(isset($order->cart[0]['address'][0]['address'])?$order->cart[0]['address'][0]['address']:'')}}</textarea>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <label class="col-md-1 col-form-label">
                                                <strong>*Service</strong>
                                            </label>
                                            <div class="col-md-3">
                                                <input type="text" id="text-service" name="text-service" class="form-control" value="{{(isset($order->courier[0]['costs'][0]['service'])?$order->courier[0]['costs'][0]['service']:'')}}"
                                                    readonly>
                                            </div>
                                            <label class="col-md-1 col-form-label">
                                                <strong>*Cost</strong>
                                            </label>
                                            <div class="col-md-3">
                                                <input type="text" id="text-cost" name="text-cost" class="form-control" value="Rp. {{str_replace(',00','',number_format((isset($order->courier[0]['costs'][0]['cost'][0]['value'])?$order->courier[0]['costs'][0]['cost'][0]['value']:0),2,',','.'))}}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-1 col-form-label">
                                                <strong>*ETD</strong>
                                            </label>
                                            <div class="col-md-3">
                                                <input type="text" id="text-etd" name="text-etd" class="form-control" value="{{(isset($order->courier[0]['costs'][0]['cost'][0]['etd'])?$order->courier[0]['costs'][0]['cost'][0]['etd']:'')}}"
                                                    readonly>
                                            </div>
                                            <label class="col-md-1 col-form-label">
                                                <strong>*Note</strong>
                                            </label>
                                            <div class="col-md-3">
                                                <input type="text" id="text-note" name="text-note" class="form-control" value="{{(isset($order->courier[0]['costs'][0]['cost'][0]['note'])?$order->courier[0]['costs'][0]['cost'][0]['note']:'')}}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-1 col-form-label">
                                                <strong>*Description</strong>
                                            </label>
                                            <div class="col-md-7">
                                                <input type="text" id="text-description" name="text-description" class="form-control" value="{{(isset($order->courier[0]['costs'][0]['description'])?$order->courier[0]['costs'][0]['description']:'')}}"
                                                    readonly>
                                            </div>
                                        </div>

                                        @if($courier_set)
                                        <div class="form-group row set-cost">
                                            <label class="col-md-5 col-form-label"></label>
                                            <div class="col-md-3">
                                                <button type="button" class="btn-block btn btn-warning" data-toggle="modal" data-target="#primaryModal">
                                                    <span class="badge badge-pill badge-danger">
                                                        <i class="fa fa-info"></i>
                                                    </span> Set Cost and detail
                                                </button>
                                            </div>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="note-tab" role="tabpanel">
                        {{($order->note != '' ? $order->note : 'Empty note')}}
                    </div>
                </div>
            </div>
        </div>
        <!--/.row-->

        <!--/.row-->
        <div class="row">
            <!--/.col-->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-user"></i> Data Member
                    </div>
                    <div class="card-body">
                        <table _fordragclass="table-responsive-sm" class="table table-striped table-sm display responsive datatable" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <i class="fa fa-user-circle-o"></i> Name</th>
                                    <th>
                                        <i class="fa fa-envelope"></i> Email</th>
                                    <th>
                                        <i class="fa fa-phone"></i> Phone Number</th>
                                    <th class="text-center">Level</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{(isset($order->member[0]['name'])?$order->member[0]['name']:'')}}</td>
                                    <td>{{(isset($order->member[0]['email'])?$order->member[0]['email']:'')}}</td>
                                    <td>{{(isset($order->member[0]['phone'])?$order->member[0]['phone']:'')}}</td>
                                    <td>{{(isset($order->member[0]['level'][0]['name'])?$order->member[0]['level'][0]['name']:'')}}</td>
                                    <td>
                                        <a class="btn btn-success btn-sm" href="{{route('master-member.edit',['id' => $order->member[0]['_id']])}}">
                                            <i class="fa fa-search"></i>&nbsp;View</a>
                                    </td>
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
                    <div class="card-header with-border">
                        <span>
                            <i class="fa fa-shopping-cart"></i> Products</span>
                    </div>
                    <div class="card-body">
                        <table _fordragclass="table-responsive-sm" class="table table-striped table-sm display responsive datatable2" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price Netto</th>
                                    <th>Price Gross</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->cart[0]['products'] as $prod_list)
                                <tr>
                                    <td class="vertical-align-middle">{{$prod_list['variant']}}</td>
                                    <td class="vertical-align-middle">Rp. {{str_replace(',00','',number_format($prod_list['price_netto'],2,',','.'))}}</td>
                                    <td class="vertical-align-middle">Rp. {{str_replace(',00','',number_format($prod_list['price_gross'],2,',','.'))}}</td>
                                    <td class="vertical-align-middle">{{$prod_list['quantity']}}</td>
                                    <td class="vertical-align-middle">Rp. {{str_replace(',00','',number_format($prod_list['total_price'],2,',','.'))}}</td>
                                    <td class="vertical-align-middle text-center">
                                        <a class="btn btn-success btn-sm" href="{{route('product.edit', ['id' => $prod_list['product_id']])}}">
                                            <i class="fa fa-search"></i>&nbsp;View</a>
                                    </td>
                                </tr>
                                @foreach($prod_list['discounts'] as $discount_list)
                                <tr>
                                    <td>
                                        <a href="{{route('discount.edit', ['id' => $discount_list['_id']])}}">*{{$discount_list['title']}}
                                            <span class="badge badge-warning">- 
                                                {{($discount_list['type']=='price'?'Rp.':'')}}{{str_replace(',00','',number_format($discount_list['value'],2,',','.'))}}
                                                {{($discount_list['type']=='percent'?'%':'')}}</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-right">Courier Cost :</th>
                                    <th>Rp. {{str_replace(',00','',number_format((isset($order->courier[0]['costs'][0]['cost'][0]['value'])?$order->courier[0]['costs'][0]['cost'][0]['value']:0),2,',','.'))}}</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-right">Total Price :</th>
                                    <th>{{(isset($order->total_price[0]['total'])?'Rp. '.str_replace(',00','',number_format($order->total_price[0]['total'],2,',','.')):'')}}</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!--/.col-->
        </div>

    </div>
</div>
<div class="modal fade" id="primaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Set Cost</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="jxForm" action="return false">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$order->id}}">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">
                            <strong>*Service</strong>
                        </label>
                        <div class="col-md-4">
                            <input type="text" id="cartService" name="cartService" class="form-control" value="{{(isset($order->courier[0]['costs'][0]['service'])?$order->courier[0]['costs'][0]['service']:'')}}" aria-describedby="cartService-error">
                            <em id="cartService-error" class="error invalid-feedback"></em>
                        </div>
                        <label class="col-md-2 col-form-label">
                            <strong>*Cost</strong>
                        </label>
                        <div class="col-md-4">
                            <input type="text" id="cartCost" name="cartCost" class="form-control idr-currency" value="{{str_replace(',00','',number_format((isset($order->courier[0]['costs'][0]['cost'][0]['value'])?$order->courier[0]['costs'][0]['cost'][0]['value']:0),2,',','.'))}}" aria-describedby="cartCost-error">
                            <em id="cartCost-error" class="error invalid-feedback"></em>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">
                            <strong>*ETD</strong>
                        </label>
                        <div class="col-md-4">
                            <input type="text" id="cartEtd" name="cartEtd" class="form-control" value="{{(isset($order->courier[0]['costs'][0]['cost'][0]['etd'])?$order->courier[0]['costs'][0]['cost'][0]['etd']:'')}}" aria-describedby="cartEtd-error">
                            <em id="cartEtd-error" class="error invalid-feedback"></em>
                        </div>
                        <label class="col-md-2 col-form-label">
                            <strong>*Note</strong>
                        </label>
                        <div class="col-md-4">
                            <input type="text" id="cartNote" name="cartNote" class="form-control" value="{{(isset($order->courier[0]['costs'][0]['cost'][0]['note'])?$order->courier[0]['costs'][0]['cost'][0]['note']:'')}}" aria-describedby="cartNote-error">
                            <em id="cartNote-error" class="error invalid-feedback"></em>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">
                            <strong>*Description</strong>
                        </label>
                        <div class="col-md-10">
                            <input type="text" id="cartDescription" name="cartDescription" class="form-control" value="{{(isset($order->courier[0]['costs'][0]['description'])?$order->courier[0]['costs'][0]['description']:'')}}" aria-describedby="cartDescription-error">
                            <em id="cartDescription-error" class="error invalid-feedback"></em>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="save()">Save changes</button>
                <button type="button" class="btn btn-secondary dismiss-modal" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection @section('myscript')
<script src="{{ asset('fiture-style/datatables/dataTables.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.responsive.min.js') }}"></script>

<script>
    //DATATABLES
    $('.datatable').DataTable({
        searching: false,
        ordering: false,
        bInfo: false,
        paging: false,
        responsive: true,
        autoWidth: false,
    });
    $('.datatable').attr('style', 'border-collapse: collapse !important');

    //DATATABLES
    $('.datatable2').DataTable({
        searching: false,
        ordering: false,
        bInfo: false,
        paging: false,
        responsive: true,
        autoWidth: false,
    });
    $('.datatable2').attr('style', 'border-collapse: collapse !important');

    $('#jxForm').validate({
        rules: {
            cartService: {
                required: true
            },
            cartCost: {
                required: true
            },
            cartEtd: {
                required: true
            },
            cartNote: {
                required: true
            },
            cartDescription: {
                required: true
            },
        },
        messages: {
            cartService: {
                required: 'Please input service name'
            },
            cartCost: {
                required: 'Please input cost'
            },
            cartEtd: {
                required: 'Please info time destination'
            },
            cartNote: {
                required: 'Please input note'
            },
            cartDescription: {
                required: 'Please input description'
            },
        },
        errorElement: 'em',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        }
    });

    function save(){
        $('.dismiss-modal').click();
        if($('#jxForm').valid()){
            $('.showProgress').click();
            $.ajax({
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            $('.progress-bar').css({
                                width: percentComplete * 100 + '%'
                            });
                            if (percentComplete === 1) {}
                        }
                    }, false);
                    xhr.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            $('.progress-bar').css({
                                width: percentComplete * 100 + '%'
                            });
                        }
                    }, false);
                    return xhr;
                },
                url: "{{ route('cart.index') }}/set-cost",
                type: 'POST',
                processData: false,
                contentType: false,
                data: new FormData($('#jxForm')[0]),
                success: function (response) {
                    setTimeout(function () {
                        setCost(); //set view cost
                        $('.progress-bar').css({
                                width: '100%'
                        });
                        $('#progressModal').modal('toggle');
                        toastr.success('successfully saved..', 'Cart');
                    }, <?php echo env('SET_TIMEOUT', '500'); ?>);
                },
                error: function (e) {
                    toastr.warning('problem setting cost..', 'Cart');
                }
            });
        } 
    }

    function setCost(){
        $('.set-cost').remove(); //remove button set cost
        $('#text-service').val($('#cartService').val());
        $('#text-cost').val($('#cartCost').val());
        $('#text-etd').val($('#cartEtd').val());
        $('#text-note').val($('#cartNote').val());
        $('#text-description').val($('#cartDescription').val());
    }

</script>
@endsection