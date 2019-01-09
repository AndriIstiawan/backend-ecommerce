@extends('master') @section('content')
<link href="{{ asset('fiture-style/select2/select2.min.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <p>
                    <a class="btn btn-primary" href="{{route('slider.index')}}">
                        <i class="fa fa-backward"></i>&nbsp; Back to List
                    </a>
                </p>
                <!--start card -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Create
                        <small>Slider</small>
                    </div>
                    <div class="card-body">
                        <form id="jxForm" method="POST" action="{{route('slider.index')}}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" class="id" name="id">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">*Title
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Declaration of title"></i>
                                        </label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Title" aria-describedby="title-error">
                                        <em id="title-error" class="error invalid-feedback"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <img class="rounded picturePrev" src="{{ asset('img/fiture-logo.png') }}" style="width: 600px; height: 328px;">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">*Image (600x328)
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Image best resolution 600x328 pixel"></i>
                                        </label>
                                        <input type="file" class="form-control" id="image" name="image" accept="image/jpg, image/jpeg, image/png" aria-describedby="image-error">
                                        <em id="image-error" class="error invalid-feedback"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">Redirect
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Redirect status"></i>
                                        </label>
                                        <div class="form-group">
                                            <label class="switch switch-text switch-pill switch-success">
                                                <input type="checkbox" class="switch-input" id="redirect" name="redirect" tabindex="-1">
                                                <span class="switch-label" data-on="On" data-off="Off"></span>
                                                <span class="switch-handle"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">Url
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Declaration of url target"></i>
                                        </label>
                                        <input type="text" class="form-control" id="url" name="url" placeholder="http://103.82.241.18/" aria-describedby="url-error">
                                        <em id="url-error" class="error invalid-feedback"></em>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                                <i class="fa fa-times-rectangle"></i>Cancel
                            </button>
                        </form>
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
    $("#image").change(function () {
        readURL(this);
        $(this).valid();
    });

    $("#jxForm").validate({
        rules: {
            title: {
                required: true,
                minlength: 4
            },
            image:{
                required: true,
            }
        },
        messages: {
            title: {
                required: 'Please enter title',
                minlength: 'Min length 4 character'
            },
            image:{
                required: 'Please select image',
            }
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