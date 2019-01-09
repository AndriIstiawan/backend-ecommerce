@extends('master') @section('content')
<link href="{{ asset('fiture-style/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/quill-text-editor/quill.snow.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <p>
                    <a class="btn btn-primary" href="{{route('promo.index')}}">
                        <i class="fa fa-backward"></i>&nbsp; Back to List
                    </a>
                </p>
                <form id="jxForm" method="POST" action="{{route('promo.update',['id' => $promo->id])}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }} 
                    <!--start card -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Edit
                            <small>Promo</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <img class="rounded picturePrev" src="{{ asset('img/promos/'.$promo->image) }}" style="width: 600px; height: 328px;">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">*Promo Title
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Declaration of title promo"></i>
                                        </label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Title" aria-describedby="title-error" value="{{$promo->title}}">
                                        <em id="title-error" class="error invalid-feedback"></em>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">*Code
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Setting unique promo code"></i>
                                        </label>
                                        <input type="text" class="form-control" id="code" name="code" placeholder="Hoky-Promo-2019" aria-describedby="code-error"
                                        value="{{$promo->code}}">
                                        <em id="code-error" class="error invalid-feedback"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">*Value
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Set value discount"></i>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" id="value" name="value" class="form-control text-right input-number" placeholder="00" aria-describedby="value-error"
                                            value="{{$promo->value}}">
                                            <div class="input-group-append">
                                                <input type="hidden" name="type" value="{{$promo->type}}">
                                                <button type="button" class="btn btn-secondary dropdown-toggle type-btn" data-toggle="dropdown">{{($promo->type=='price'?'.00':' % ')}}
                                                    <span class="caret"></span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" onclick="changeType('price')">.00</a>
                                                    <a class="dropdown-item" onclick="changeType('percent')"> % </a>
                                                </div>
                                            </div>
                                            <em id="value-error" class="error invalid-feedback"></em>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">*Expired Date
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Set expired date"></i>
                                        </label>
                                        <input type="text" class="form-control" id="expiredDate" name="expiredDate" placeholder="" aria-describedby="expiredDate-error"
                                        value="{{$promo->expired_date}}">
                                        <em id="expiredDate-error" class="error invalid-feedback"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="col-form-label">*Target Promo
                                                <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Set target promo"></i>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12 col-form-label">
                                            <div class="form-check form-check-inline mr-1">
                                                <input class="form-check-input radio-target" type="radio" id="inline-radio1" value="total price" name="target" aria-describedby="target-error"
                                                {{($promo->target[0]['target']=='total price'?'checked':'')}}>
                                                <label class="form-check-label radio-target" for="inline-radio1">Total Price</label>
                                            </div>
                                            <div class="form-check form-check-inline mr-1">
                                                <input class="form-check-input radio-target" type="radio" id="inline-radio2" value="product" name="target"
                                                {{($promo->target[0]['target']=='product'?'checked':'')}}>
                                                <label class="form-check-label radio-target" for="inline-radio2">Product</label>
                                            </div>
                                            <div class="form-check form-check-inline mr-1">
                                                <input class="form-check-input radio-target" type="radio" id="inline-radio3" value="courier" name="target"
                                                {{($promo->target[0]['target']=='courier'?'checked':'')}}>
                                                <label class="form-check-label radio-target" for="inline-radio3">Courier</label>
                                            </div>
                                            <em id="target-error" class="error invalid-feedback"></em>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <!--start card -->
                                    <div class="card radio-header" {{($promo->target[0]['target']=='total price'?'style=display:none;':'')}}>
                                        <div class="card-header">
                                            <i class="fa fa-align-justify"></i> Unique
                                            <small>Modifier</small>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="radio-list">
                                                    <?php if($promo->target[0]['target']!='total price'){ ?>
                                                    <?php if($promo->target[0]['target']=='product'){ ?>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="name">Brand
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Brand of promo"></i>
                                                        </label>
                                                        <select class="form-control brand" name="brand[]" multiple>
                                                            <option value=""></option>
                                                            @foreach($brands as $brand)
                                                            <option value="{{$brand->id}}" <?php print((in_array($brand->id, array_column($promo->target[0]['brands'], '_id'))?'selected':'')); ?> >{{$brand->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="name">Category
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Category of promo"></i>
                                                        </label>
                                                        <select class="form-control category" name="category[]" multiple>
                                                            <option value=""></option>
                                                            @foreach($categories as $category)
                                                            <option value="{{$category->id}}" <?php print((in_array($category->id, array_column($promo->target[0]['categories'], '_id'))?'selected':'')); ?> >{{$category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="name">Product
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Product of promo"></i>
                                                        </label>
                                                        <select class="form-control product" name="product[]" multiple>
                                                            <option value=""></option>
                                                            @foreach($products as $product)
                                                            <option value="{{$product->id}}" <?php print((in_array($product->id, array_column($promo->target[0]['products'], '_id'))?'selected':'')); ?> >{{$product->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <?php }else{ ?>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="name">Courier
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="promo courier"></i>
                                                        </label>
                                                        <select class="form-control courier" name="courier[]" multiple>
                                                            <option value=""></option>
                                                            @foreach($couriers as $courier)
                                                            <option value="{{$courier->id}}" <?php print((in_array($courier->id, array_column($promo->target[0]['couriers'], '_id'))?'selected':'')); ?> >{{$courier->courier}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <?php } ?>
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end card -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">Content HTML
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Declaration of limit promo"></i>
                                        </label>
                                        <?php
                                        echo '<div id="editor">';
                                        echo $promo->content_html;
                                        echo '</div>';
                                        ?>
                                        <input type="hidden" id="contentHTML" name="contentHTML" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card -->

                    <!--start card -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Unique
                            <small>Modifier</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">Level
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Level of member"></i>
                                        </label>
                                        <select id="level" class="form-control" name="level[]" multiple>
                                            <option value=""></option>
                                            @foreach($levels as $level)
                                            <option value="{{$level->id}}" <?php print((in_array($level->id, array_column($promo->levels, '_id'))?'selected':'')); ?> >{{$level->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">Member
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Target specific member"></i>
                                        </label>
                                        <select id="member" class="form-control" name="member[]" multiple>
                                            <option value=""></option>
                                            @foreach($members as $member)
                                            <option value="{{$member->id}}" <?php print((in_array($member->id, array_column($promo->members, '_id'))?'selected':'')); ?> >{{$member->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card -->

                    <!--start card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a class="btn btn-secondary" href="{{route('promo.index')}}">
                                        <i class="fa fa-times-rectangle"></i>&nbsp; Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card -->
                </form>
            </div>
        </div>
        <div class="row fade" style="display:none;">
            <div class="product-col">
                <div class="form-group">
                    <label class="col-form-label" for="name">Brand
                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Brand of promo"></i>
                    </label>
                    <select class="form-control brand" name="brand[]" multiple>
                        <option value=""></option>
                        @foreach($brands as $brand)
                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="name">Category
                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Category of promo"></i>
                    </label>
                    <select class="form-control category" name="category[]" multiple>
                        <option value=""></option>
                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="name">Product
                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Product of promo"></i>
                    </label>
                    <select class="form-control product" name="product[]" multiple>
                        <option value=""></option>
                        @foreach($products as $product)
                        <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="courier-col">
                <div class="form-group">
                    <label class="col-form-label" for="name">Courier
                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="promo courier"></i>
                    </label>
                    <select class="form-control courier" name="courier[]" multiple>
                        <option value=""></option>
                        @foreach($couriers as $courier)
                        <option value="{{$courier->id}}">{{$courier->courier}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="{{ asset('fiture-style/select2/select2.min.js') }}"></script>
<script src="{{ asset('fiture-style/quill-text-editor/quill.js') }}"></script>
<script src="{{ asset('fiture-style/quill-text-editor/toolbarOptions.js') }}"></script>
<script src="{{ asset('fiture-style/datetimepicker/build/js/moment.min.js') }}"></script>
<script src="{{ asset('fiture-style/datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
    function changeType(typeValue){
        $("input[name='type']").val(typeValue);
        if(typeValue == 'price'){
            $(".type-btn").html('.00');
        }else{
            $(".type-btn").html('&nbsp;%&nbsp;');
        }
    }
    
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

    var editor = new Quill('#editor', {
        modules: {
            toolbar: toolbarOptions
        },
        theme: 'snow'
    });

    editor.on('editor-change', function () {
        $("#contentHTML").val(editor.root.innerHTML);
    });

    $('#level').select2({
        theme: "bootstrap",
        placeholder: 'Level'
    }).change(function () {
        $(this).parent('.form-group').find('.select2-selection').css('height', '55px');
    });

    $('#member').select2({
        theme: "bootstrap",
        placeholder: 'Member'
    }).change(function () {
        $(this).parent('.form-group').find('.select2-selection').css('height', '55px');
    });

    $('#level').change();
    $('#member').change();
    $('#expiredDate').datetimepicker({
        format: 'YYYY-MM-DD H:mm:ss',
    });

    //function for target change radio
    function targetChange(target) {
        switch (target) {
            case 'total price':
                $('.radio-header').css('display', 'none');
                break;
            case 'product':
                $('.radio-header').css('display', 'block');
                $('.radio-list').html($('.fade .product-col').html());
                $('.radio-list .brand').select2({
                    theme: "bootstrap",
                    placeholder: 'Brand'
                }).change(function () {
                    $(this).parent('.form-group').find('.select2-selection').css('height', '55px');
                });

                $('.radio-list .category').select2({
                    theme: "bootstrap",
                    placeholder: 'Category'
                }).change(function () {
                    $(this).parent('.form-group').find('.select2-selection').css('height', '55px');
                });

                $('.radio-list .product').select2({
                    theme: "bootstrap",
                    placeholder: 'Product'
                }).change(function () {
                    $(this).parent('.form-group').find('.select2-selection').css('height', '55px');
                });

                $('.radio-list .brand').change();
                $('.radio-list .category').change();
                $('.radio-list .product').change();
                break;
            case 'courier':
                $('.radio-header').css('display', 'block');
                $('.radio-list').html($('.fade .courier-col').html());
                $('.radio-list .courier').select2({
                    theme: "bootstrap",
                    placeholder: 'Courier'
                }).change(function () {
                    $(this).parent('.form-group').find('.select2-selection').css('height', '55px');
                });
                $('.radio-list .courier').change();
                break;
            default:
                break;
        }
        $('.fa-question-circle').tooltip();
    }

    //triger for target radio
    $('input[name="target"]').change(function () {
        targetChange($(this).val());
    });

    $("#jxForm").validate({
        rules: {
            title: {
                required: true,
            },
            code: {
                required: true,
                remote: {
                    url: '{{ route("promo.index") }}/find',
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: '{{$promo->id}}',
                        code: function () {
                            return $('#jxForm1 :input[name="code"]').val();
                        }
                    }
                }
            },
            value: {
                required: true,
            },
            expiredDate: {
                required: true,
            },
            target: {
                required: true,
            }
        },
        messages: {
            title: {
                required: 'Please enter title',
            },
            code: {
                required: 'Please set code',
                remote: 'Code already in use',
            },
            value: {
                required: 'Please set value',
            },
            expiredDate: {
                required: 'Please set expired date',
            },
            target: {
                required: 'Please select target promo',
            }
        },
        errorElement: 'em',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
            if ($(element).attr('name') == 'target') {
                $('.radio-target').css('color', '#f86c6b');
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass('is-valid').removeClass('is-invalid');
            if ($(element).attr('name') == 'target') {
                $('.radio-target').css('color', '#4dbd74');
            }
        },
        ignore: "#editor *"
    });

</script>
<script>
    <?php if($promo->target[0]['target']!='total price'){ ?>
    <?php if($promo->target[0]['target']=='product'){ ?>
        $('.radio-list .brand').select2({
            theme: "bootstrap",
            placeholder: 'Brand'
        }).change(function () {
            $(this).parent('.form-group').find('.select2-selection').css('height', '55px');
        });

        $('.radio-list .category').select2({
            theme: "bootstrap",
            placeholder: 'Category'
        }).change(function () {
            $(this).parent('.form-group').find('.select2-selection').css('height', '55px');
        });

        $('.radio-list .product').select2({
            theme: "bootstrap",
            placeholder: 'Product'
        }).change(function () {
            $(this).parent('.form-group').find('.select2-selection').css('height', '55px');
        });

        $('.radio-list .brand').change();
        $('.radio-list .category').change();
        $('.radio-list .product').change();
    <?php }else{ ?>
        $('.radio-list .courier').select2({
            theme: "bootstrap",
            placeholder: 'Courier'
        }).change(function () {
            $(this).parent('.form-group').find('.select2-selection').css('height', '55px');
        });
        $('.radio-list .courier').change();
    <?php } ?>
    <?php } ?>
</script>
@endsection