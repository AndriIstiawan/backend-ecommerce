@extends('master') @section('content')
<link href="{{ asset('fiture-style/select2/select2.min.css') }}" rel="stylesheet">
<div class="container-fluid">
    <p>
        <a class="btn btn-primary" href="{{route('pending-po.index')}}">
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
                    <div class="card-header"><i class="fa fa-user"></i> Data Member</div>
                    <div class="card-body">
                        <table class="table table-responsive-sm">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-user-circle-o"></i> IP</th>
                                    <th><i class="fa fa-user-circle-o"></i> Name</th>
                                    <th><i class="fa fa-envelope"></i> Email</th>
                                    <th><i class="fa fa-status"></i> Inquiry Status</th>
                                    <th><i class="fa fa-status"></i> Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{(isset($inquiry->IP)?$inquiry->IP:'')}}</td>
                                    <td>{{(isset($inquiry->member[0]['name'])?$inquiry->member[0]['name']:'')}}</td>
                                    <td>{{(isset($inquiry->member[0]['email'])?$inquiry->member[0]['email']:'')}}</td>
                                    <td>{{(isset($inquiry->status)?$inquiry->status:'')}}</td>
                                    <td><input type="hidden" name="totalPrice" value="{{$inquiry->total_price_cart}}">
                                    {{(isset($inquiry->total_price_cart)?'Rp. '.str_replace(',00','',number_format($inquiry->total_price_cart,2,',','.')):'')}}
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
                    <form id="jxForm" method="POST" action="{{ route('pending-po.update',['id' => $inquiry->id]) }}">
                        <div class="card-header with-border">
                            <span><i class="fa fa-shopping-cart"></i> Custom Inquiry</span>
                        </div>
                        <div class="card-body">
                            {{ method_field('PUT') }} {{ csrf_field() }}
                            @foreach($inquiry->inquiries as $inqs)
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="title">Product</div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a href="{{$inqs['productImage']}}" style="margin:0 auto; padding-left:0;" target="blank_">
                                                <img class="rounded picturePrev" src="{{$inqs['productImage']}}" style="width: 70px; height: 70px;">
                                            </a>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="hidden" name="id[]" value="{{$inqs['id']}}">
                                            <div class="form-group">
                                                <div class="small text-muted">*Product Image</div>
                                                <input type="text" class="form-control image-val" name="image{{$inqs['id']}}" value="{{$inqs['productImage']}}" aria-describedby="image{{$inqs['id']}}-error">
                                                <em id="image{{$inqs['id']}}-error" class="error invalid-feedback"></em>
                                            </div>
                                            <div class="form-group">
                                                <div class="small text-muted">*Product Name</div>
                                                <input type="text" class="form-control" name="name{{$inqs['id']}}" value="{{$inqs['productName']}}" aria-describedby="name{{$inqs['id']}}-error">
                                                <em id="name{{$inqs['id']}}-error" class="error invalid-feedback"></em>
                                            </div>
                                            <div class="form-group">
                                                <div class="small text-muted">description</div>
                                                <textarea rows="2" name="description{{$inqs['id']}}" class="form-control">{{$inqs['description']}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="title">Status</div>
                                    <div class="row">
                                        <?php $sts = $inqs['status'][count($inqs['status'])-1]['statusType']; ?>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="small text-muted">&nbsp;</div>
                                                <select class="form-control status-class" name="status{{$inqs['id']}}" aria-describedby="status{{$inqs['id']}}-error">
                                                    <option value="" {{($sts=="Pending" ? 'selected': '')}}>Pending</option>
                                                    <option value="Approved" {{($sts=="Approved" ? 'selected': '')}}>Approved</option>
                                                    <option value="Rejected" {{($sts=="Rejected" ? 'selected': '')}}>Rejected</option>
                                                </select>
                                                <em id="status{{$inqs['id']}}-error" class="error invalid-feedback"></em>
                                            </div>
                                            <div class="form-group">
                                                <div class="small text-muted">note</div>
                                                <textarea rows="2" name="note{{$inqs['id']}}" class="form-control">{{$inqs['status'][count($inqs['status'])-1]['statusNote']}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="title">Price</div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="small text-muted">&nbsp;</div>
                                                <input type="text" class="form-control idr-currency" name="price{{$inqs['id']}}" aria-describedby="price{{$inqs['id']}}-error"
                                                    value="{{str_replace(',00','',number_format($inqs['price'],2,',','.'))}}">
                                                <em id="price{{$inqs['id']}}-error" class="error invalid-feedback"></em>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="title">Qty</div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="small text-muted">&nbsp;</div>
                                                <input type="text" class="form-control input-number" name="quantity{{$inqs['id']}}" value="{{$inqs['quantity']}}" aria-describedby="quantity{{$inqs['id']}}-error">
                                                <em id="quantity{{$inqs['id']}}-error" class="error invalid-feedback"></em>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="title">Total Price</div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="small text-muted">&nbsp;</div>
                                                <input type="text" class="form-control" name="total{{$inqs['id']}}" 
                                                    value="{{str_replace(',00','',number_format($inqs['totalPrice'],2,',','.'))}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <a class="btn btn-primary" href="{{route('pending-po.index')}}">
                                    <i class="fa fa-backward"></i>&nbsp; Back to List
                                </a>
                                <button type="submit" class="btn btn-success" name="submit" value="Sign up">Save Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

    </div>
</div>
@endsection @section('myscript')
<script src="{{ asset('fiture-style/select2/select2.min.js') }}"></script>
<script>
    $('.status-class').select2({
        theme: "bootstrap",
        placeholder: 'Please select'
    });
    $('.idr-currency').change();
    $('.input-number').change();
    $('.image-val').change(function(){
        //nearest a
        $(this).parent().parent().parent().find('a').attr('href',$(this).val());
        //nearest img
        $(this).parent().parent().parent().find('img').attr('src',$(this).val());
    });

    //
    //validation
    $('#jxForm').validate({
        rules: {
        },
        messages: {
        },
        errorElement: 'em',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
            $(element).closest('div').find('.select2-selection').attr('style',
                'border-color:#f86c6b');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass('is-valid').removeClass('is-invalid');
            $(element).closest('div').find('.select2-selection').attr('style',
                'border-color:#4dbd74');
        }
    });

    @foreach($inquiry->inquiries as $inqs)
    $('input[name="image{{$inqs["id"]}}"]').rules("add", {
        required: true,
        messages: {
            required: "Mohon input image product"
        }
    });
    $('input[name="image{{$inqs["id"]}}"]').change(function () {
        $(this).valid();
    });
    $('input[name="name{{$inqs["id"]}}"]').rules("add", {
        required: true,
        messages: {
            required: "Mohon input name product"
        }
    });
    $('input[name="name{{$inqs["id"]}}"]').change(function () {
        $(this).valid();
    });
    $('select[name="status{{$inqs["id"]}}"]').rules("add", {
        required: true,
        messages: {
            required: "Mohon pilih status product"
        }
    });
    $('select[name="status{{$inqs["id"]}}"]').change(function () {
        $(this).valid();
    });
    $('input[name="price{{$inqs["id"]}}"]').change(function () {
        var elmQty = $('input[name="quantity{{$inqs["id"]}}"]').val();
        var elmPrice = $('input[name="price{{$inqs["id"]}}"]').val().replace(/\./g,'').replace(/\,/g,'.');
        var total = 0;

        if(parseInt(elmQty) && parseFloat(elmPrice)){
            elmQty = parseInt(elmQty);
            elmPrice = parseFloat(elmPrice);
            total = elmPrice*elmQty;
        }
        $('input[name="total{{$inqs["id"]}}"]').val(total.toLocaleString('id-ID'));
    });
    $('input[name="quantity{{$inqs["id"]}}"]').change(function () {
        var elmQty = $('input[name="quantity{{$inqs["id"]}}"]').val();
        var elmPrice = $('input[name="price{{$inqs["id"]}}"]').val().replace(/\./g,'').replace(/\,/g,'.');
        var total = 0;

        if(parseInt(elmQty) && parseFloat(elmPrice)){
            elmQty = parseInt(elmQty);
            elmPrice = parseFloat(elmPrice);
            total = elmPrice*elmQty;
        }
        $('input[name="total{{$inqs["id"]}}"]').val(total.toLocaleString('id-ID'));
    });
    @endforeach
</script>
@endsection