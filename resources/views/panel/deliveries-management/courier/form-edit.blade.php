@extends('master') @section('content')
<link href="{{ asset('fiture-style/select2/select2.min.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <p>
                    <a class="btn btn-primary" href="{{route('courier.index')}}">
                        <i class="fa fa-backward"></i>&nbsp; Back to List
                    </a>
                </p>
                <!--start card -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Edit Courier
                        <small></small>
                    </div>
                    <div class="card-body">

                        <div class="tab-content" id="myTab1Content">
                            <!-- TAB CONTENT -->
                            <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id="jxForm1" method="POST" enctype="multipart/form-data" action="{{ route('courier.update',['id' => $courier->id]) }}">
                                            {{ csrf_field() }}
                                            {{ method_field('PUT') }}
                                            <input type="hidden" name="type" value="{{$courier->type}}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="courier">*Courier Name
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Name of courier"></i>
                                                        </label>
                                                        <input type="text" class="form-control" id="courier" name="courier" placeholder="name courier" aria-describedby="courier-error"
                                                        value="{{$courier->courier}}">
                                                        <em id="courier-error" class="error invalid-feedback"></em>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="code">*Code
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="code for courier"></i>
                                                        </label>
                                                        <input type="text" class="form-control" id="slug" name="slug" placeholder="code courier" aria-describedby="slug-error" 
                                                        value="{{$courier->slug}}" {{($courier->type=='default courier'?'readonly':'')}}>
                                                        <em id="slug-error" class="error invalid-feedback"></em>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="location">*Location
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Location of courier"></i>
                                                        </label>
                                                        <select class="form-control location" name="location" aria-describedby="location-error">
                                                            <option value=""></option>
                                                            @foreach($cities as $city)
                                                            <option value="{{$city['city_id']}}" {{($courier->location[0]['city_id']==$city['city_id']?'selected':'')}} >{{$city['type']}} {{$city['city_name']}}</option>
                                                            @endforeach
                                                        </select>
                                                        <em id="location-error" class="error invalid-feedback"></em>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="status">Status Active
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="status active for courier"></i>
                                                        </label>
                                                        <div class="form-group">
                                                            <label class="switch switch-text switch-pill switch-success">
                                                                <input type="checkbox" class="switch-input" id="status" name="status" {{($courier->status == 'on'? 'checked': '')}} tabindex="-1">
                                                                <span class="switch-label" data-on="On" data-off="Off"></span>
                                                                <span class="switch-handle"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!--start card -->
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <i class="fa fa-align-justify"></i> Service
                                                            @if($courier->type!='default courier')
                                                            <button type="button" class="btn btn-sm btn-success" onclick="addService()">
                                                                <i class="fa fa-plus"></i>&nbsp; Add
                                                            </button>
                                                            @endif
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="service-list">
                                                                        @if($courier->type!='default courier')
                                                                        <?php $i = 0; ?>
                                                                        @foreach($courier->service as $cs)
                                                                        <?php $i++; ?>
                                                                        <div class="row">
                                                                            <input type="hidden" name="serviceID[]" value="{{$i}}">
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" name="service{{$i}}" placeholder="courier service" aria-describedby="service{{$i}}-error"
                                                                                    value="{{$cs['name']}}">
                                                                                    <em id="service{{$i}}-error" class="error invalid-feedback"></em>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" name="description{{$i}}" placeholder="description service" aria-describedby="description{{$i}}-error"
                                                                                    value="{{$cs['description']}}">
                                                                                    <em id="description{{$i}}-error" class="error invalid-feedback"></em>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @endforeach
                                                                        @else
                                                                        <div class="row">
                                                                            <div class="col-md-12">Default service</div>
                                                                        </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end card -->
                                                </div>
                                            </div>
                                            <hr>
                                            <p>
                                                <button type="submit" class="btn btn-success"> &nbsp; Save</button>
                                                <a class="btn btn-secondary" href="{{route('courier.index')}}">
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
        <div class="row fade" style="display:none;">
            <div class="service-opt">
                <div class="row service-div">
                    <input type="hidden" class="serviceID" name="serviceID[]" value="">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control service" name="service" placeholder="courier service" aria-describedby="service-error">
                            <em id="service-error" class="error invalid-feedback service-feedback"></em>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input type="text" class="form-control description" name="description" placeholder="description service" aria-describedby="description-error">
                                    <em id="description-error" class="error invalid-feedback description-feedback"></em>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="button" class="btn btn-danger" onclick="">
                                        <i class="fa fa-remove"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
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
    var counter = 1;
    $('.location').select2({
        theme: "bootstrap",
        placeholder: 'Location'
    }).change(function () {
        $(this).valid();
    });

    function addService() {
        counter++;
        $('.service-opt .serviceID').val(counter);
        $('.service-opt .service').attr('name', 'service' + counter).attr('aria-describedby', 'service' + counter +
            '-error');
        $('.service-opt .service-feedback').attr('id', 'service' + counter + '-error');
        $('.service-opt .description').attr('name', 'description' + counter).attr('aria-describedby', 'description' +
            counter + '-error');
        $('.service-opt .description-feedback').attr('id', 'description' + counter + '-error');

        //add service
        $('.service-list').append($('.service-opt').html());

        //validate new service
        $('.service-list input[name="service' + counter + '"]').rules("add", {
            required: true,
            messages: {
                required: "Please enter service"
            }
        });
        $('.service-list input[name="description' + counter + '"]').rules("add", {
            required: true,
            messages: {
                required: "Please input description"
            }
        });
    }

    $("#jxForm1").validate({
        rules: {
            courier: {
                required: true,
                minlength: 1
            },
            slug: {
                required: true,
                remote: {
                    url: '{{ route("courier.index") }}/find',
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: '{{ $courier->id }}',
                        slug: function () {
                            return $('#jxForm1 :input[name="slug"]').val();
                        }
                    }
                }
            },
            location: {
                required: true
            },
        },
        messages: {
            courier: {
                required: 'Please enter a name of courier',
                minlength: 'fill the blank'
            },
            slug: {
                required: 'Please enter a code of courier',
                remote: 'Code already in use'
            },
            location: {
                required: 'Please select location'
            },
        },
        errorElement: 'em',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
            $(element).closest('div').find('.select2-selection').attr('style', 'border-color:#f86c6b');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass('is-valid').removeClass('is-invalid');
            $(element).closest('div').find('.select2-selection').attr('style', 'border-color:#4dbd74');
        }
    });

    @for($i = 1; $i <= count($courier->service); $i++)
        $('.service-list input[name="service{{$i}}"]').rules("add", {
            required: true,
            messages: {
                required: "Please enter service"
            }
        });
        $('.service-list input[name="description{{$i}}"]').rules("add", {
            required: true,
            messages: {
                required: "Please input description"
            }
        });
    @endfor

    $("#jxForm1").valid();
</script>
@endsection