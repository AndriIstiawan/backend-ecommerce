@extends('master') @section('content')
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <p>
                    <a class="btn btn-primary" href="{{route('payment-method.index')}}">
                        <i class="fa fa-backward"></i>&nbsp; Back to List
                    </a>
                </p>
                <!--start card -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> New Payment Method
                        <small></small>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTab1Content">
                            <!-- TAB CONTENT -->
                            <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id="jxForm1" method="POST" enctype="multipart/form-data" action="{{route('payment-method.index')}}">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="text-center">
                                                        <img class="rounded picturePrev" src="{{ asset('img/fiture-logo.png') }}" style="width: 150px; height: 70px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="name">*Image (150x70)
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Image view of Payment"></i>
                                                        </label>
                                                        <input type="file" class="form-control" id="picture" name="picture" accept="image/jpg, image/jpeg, image/png" aria-describedby="picture-error">
                                                        <em id="picture-error" class="error invalid-feedback">Please select image</em>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="name">*Name
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Name of Payment or Bank"></i>
                                                        </label>
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name of Payment or Bank" aria-describedby="name-error">
                                                        <em id="name-error" class="error invalid-feedback">Please enter a name of payment</em>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label" for="status">Status Active
                                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="status active for payment method"></i>
                                                    </label>
                                                    <div class="form-group">
                                                        <label class="switch switch-text switch-pill switch-success">
                                                            <input type="checkbox" class="switch-input" id="status" name="status" tabindex="-1">
                                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                                            <span class="switch-handle"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="name">*Account
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Account bank"></i>
                                                        </label>
                                                        <input type="text" class="form-control" id="account" name="account" placeholder="Account" aria-describedby="account-error">
                                                        <em id="account-error" class="error invalid-feedback">Please enter a Account</em>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="name">*Account Number
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Account number bank"></i>
                                                        </label>
                                                        <input type="text" class="form-control" id="accountNumber" name="accountNumber" placeholder="Account Number" aria-describedby="accountNumber-error">
                                                        <em id="accountNumber-error" class="error invalid-feedback">Please enter a account number</em>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <p>
                                                <button type="submit" class="btn btn-success"> &nbsp; Save</button>
                                                <a class="btn btn-secondary" href="{{route('payment-method.index')}}">
                                                    <i class="fa fa-times-rectangle"></i>&nbsp; Cancel
                                                </a>
                                            </p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab 1 -->

                        </div>
                    </div>
                </div>
                <!--end card -->
            </div>
        </div>
    </div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.picturePrev').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#picture").change(function () {
        readURL(this);
    });

    $("#jxForm1").validate({
        rules: {
            picture:{
                required: true,
            },
            name: {
                required: true,
            },
            account: {
                required: true,
            },
            accountNumber: {
                required: true,
            },
        },
        messages: {
            picture:{
                required: 'Please select image',
            },
            name: {
                required: 'Please enter a name of payment',
            },
            account: {
                required: 'Please enter a account of payment',
            },
            accountNumber: {
                required: 'Please enter a account number of payment',
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
</script>
@endsection