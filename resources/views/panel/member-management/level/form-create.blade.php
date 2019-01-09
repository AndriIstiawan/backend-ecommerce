@extends('master') @section('content')
<link href="{{ asset('fiture-style/select2/select2.min.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            <a class="btn btn-primary" href="{{route('level.index')}}">
                                <i class="fa fa-backward"></i>&nbsp; Back to List
                            </a>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form id="jxForm" novalidate="novalidate" method="POST" action="{{ route('level.index') }}">
                            <!--start card -->
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> Create
                                    <small>Level</small>
                                </div>
                                <div class="card-body">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="col-form-label" for="name">*Order of Level
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Set Order of level"></i>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <input type="text" class="form-control input-number" id="order" name="order" placeholder="0" aria-describedby="order-error">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <em id="order-error" class="error invalid-feedback"></em>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label" for="name">*Key ID
                                                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Declaration key ID of level"></i>
                                                </label>
                                                <input type="text" class="form-control" id="key" name="key" placeholder="Key ID" aria-describedby="key-error">
                                                <em id="key-error" class="error invalid-feedback"></em>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label" for="name">*Name
                                                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Declaration name of level"></i>
                                                </label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" aria-describedby="name-error">
                                                <em id="name-error" class="error invalid-feedback"></em>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="point">Parent Level
                                                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Assign for sub level"></i>
                                                </label>
                                                <select id="parent" class="form-control" style="width: 100% !important;" name="parent">
                                                    <option value=""></option>
                                                    @foreach($levels as $level)
                                                    <option value="{{$level['_id']}}">{{$level['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label" for="point">*Loyalty Point
                                                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Declaration Loyalty point of level"></i>
                                                </label>
                                                <input type="text" class="form-control input-number" id="point" name="point" placeholder="Point" aria-describedby="point-error">
                                                <em id="point-error" class="error invalid-feedback">Please enter a point</em>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label" for="hutang">*Hutang
                                                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Declaration Hutang of level"></i>
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp. </span>
                                                    </div>
                                                    <input type="text" class="form-control idr-currency" id="hutang" name="hutang" placeholder="Hutang" aria-describedby="hutang-error">
                                                    <em id="hutang-error" class="error invalid-feedback">Please enter a hutang</em>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="form-group pull-right">
                                        <button type="submit" class="btn btn-primary" name="signup" value="Sign up">Add New</button>
                                        <a class="btn btn-secondary" href="{{route('level.index')}}">Close</a>
                                    </div> 
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="{{ asset('fiture-style/select2/select2.min.js') }}"></script>
<script>
    $('#parent').select2({
        theme: "bootstrap",
        placeholder: 'Please select',
        allowClear: true
    });
    $('#jxForm').validate({
        rules: {
            order: {
                required: true
            },
            key: {
                required: true,
                remote: {
                    url: '{{ route("level.index") }}/find',
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        key_id: function () {
                            return $('#jxForm :input[name="key"]').val();
                        }
                    }
                } 
            },
            name: {
                required: true
            },
            // point: {
            //     required: true
            // },
            // hutang: {
            //     required: true
            // },
        },
        messages: {
            order: {
                required: 'Please enter a order level'
            },
            key: {
                required: 'Please enter a key id level',
                remote: 'Key ID already in use. Please use other Key ID.'
            },
            name: {
                required: 'Please enter a name level'
            },
            // point: {
            //     required: 'Please enter a point'
            // },
            // hutang: {
            //     required: 'Please enter a hutang'
            // }
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
</script>
@endsection