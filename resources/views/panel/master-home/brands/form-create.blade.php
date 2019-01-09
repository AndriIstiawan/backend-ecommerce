@extends('master') @section('content')
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <p>
                    <a class="btn btn-primary" href="{{route('brands.index')}}">
                        <i class="fa fa-backward"></i>&nbsp; Back to List
                    </a>
                </p>
                <!--start card -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> New Brand
                        <small></small>
                    </div>
                    <div class="card-body">

                        <div class="tab-content" id="myTab1Content">
                            <!-- TAB CONTENT -->
                            <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id="jxForm1" method="POST" enctype="multipart/form-data" action="{{route('brands.index')}}">
                                            {{ csrf_field() }}
                                            <input type="hidden" class="id" name="id">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="name">*Name
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Name of Brand"></i>
                                                        </label>
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="name brand" aria-describedby="name-error">
                                                        <em id="name-error" class="error invalid-feedback">Please enter a name of brand</em>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="name">*Key ID
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Key id for brand"></i>
                                                        </label>
                                                        <input type="text" class="form-control" id="slug" name="slug" placeholder="name slug" aria-describedby="slug-error">
                                                        <em id="slug-error" class="error invalid-feedback">Please enter a slug</em>
                                                    </div>
                                                    <div class="text-center">
                                                        <img class="rounded picturePrev" src="{{ asset('img/fiture-logo.png') }}" style="width: 150px; height: 70px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="name">*Image (150x70)
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Image view of Brand"></i>
                                                        </label>
                                                        <input type="file" class="form-control" id="picture" name="picture" accept="image/jpg, image/jpeg, image/png" aria-describedby="picture-error">
                                                        <em id="picture-error" class="error invalid-feedback">Please select image</em>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <p>
                                                <button type="submit" class="btn btn-success"> &nbsp; Save</button>
                                                <a class="btn btn-secondary" href="{{route('brands.index')}}">
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
            name: {
                required: true,
                minlength: 1
            },
            slug: {
                required: true,
                minlength: 1,
                remote: {
                    url: '{{ route("brands.index") }}/find',
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        slug: function () {
                            return $('#jxForm1 :input[name="slug"]').val();
                        }
                    }
                }
            },
            picture:{
                required: true,
            }
        },
        messages: {
            name: {
                required: 'Please enter a name of product',
                minlength: 'fill the blank'
            },
            slug: {
                required: 'Please enter a Key ID of brand',
                minlength: 'fill the blank',
                remote: 'Key ID already in use. Please use other Key ID.'
            },
            picture:{
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