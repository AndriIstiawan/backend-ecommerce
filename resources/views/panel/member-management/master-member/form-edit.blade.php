@extends('master') @section('content')
<link href="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/select2/select2.min.css') }}" rel="stylesheet">
<div class="container-fluid">
    <p>
        <button type="button" class="btn btn-primary" onclick="window.history.back()">
            <i class="fa fa-backward"></i>&nbsp; Back to List
        </button>
    </p>
</div>
<form id="jxForm1" novalidate="novalidate" method="POST" action="{{ route('master-member.update',['id' => $member->id]) }}"
    enctype="multipart/form-data">
    {{ method_field('PUT') }} {{ csrf_field() }}
    <div class="container-fluid">
        <div class="animate fadeIn">
            <div class="row">
                <div class="col-lg-7">
                    <!--start card -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Member
                            <small>edit management</small>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="myTab1Content">
                                <!-- TAB CONTENT -->

                                <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" class="id" name="id" value="{{$member->id}}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="name">*Member Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" aria-describedby="name-error" value="{{$member->name}}">
                                                        <em id="name-error" class="error invalid-feedback">Please enter a name site title</em>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="email">*Email</label>
                                                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{$member->email}}" aria-describedby="email-error">
                                                        <em id="email-error" class="error invalid-feedback">Please enter a valid email address</em>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="phone">*Phone</label>
                                                        <input type="number" class="form-control" id="phone" name="phone" placeholder="Phone" value="{{$member->phone}}" aria-describedby="phone-error">
                                                        <em id="phone-error" class="error invalid-feedback">Please enter a valid phone</em>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="point">*Loyalty Point</label>
                                                        @foreach ($member->level as $att)
                                                        <input type="number" class="form-control" id="point" name="point" placeholder="{{$member->point}}/{{$att['loyalty_point']}}" value="{{$member->point}}/{{$att['loyalty_point']}}"
                                                            aria-describedby="point-error" readonly>
                                                        <em id="point-error" class="error invalid-feedback">Please enter a valid point</em>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="level">*Level</label>
                                                        <input type="hidden" name="level" value="{{$att['_id']}}">
                                                        <input type="number" class="form-control" placeholder="{{$att['name']}}" readonly> @endforeach
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="type">*Type</label>
                                                        <select id="type" name="type[]" class="form-control" aria-describedby="type-error" multiple="" required>
                                                            <option value=""></option>
                                                            <option value="B2B" {{($b2b_status? 'selected': '')}}>B2B</option>
                                                            <option value="B2C" {{($b2c_status? 'selected': '')}}>B2C</option>
                                                        </select>
                                                        <em id="type-error" class="error invalid-feedback">Please select a type</em>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="status">*Status</label>
                                                        <p>
                                                            <label class="switch switch-text switch-pill switch-info">
                                                                <input type="checkbox" class="switch-input" id="status" name="status" {{($member->status? 'checked': '')}} tabindex="-1">
                                                                <span class="switch-label" data-on="On" data-off="Off"></span>
                                                                <span class="switch-handle"></span>
                                                            </label>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="text-center">
                                                        <img class="rounded picturePrev" src="{{(isset($member->picture)?asset('img/avatars/'.$member->picture):asset('img/fiture-logo.png'))}}"
                                                            style="width: 150px; height: 150px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="name">Picture (150x150)</label>
                                                        <input type="file" class="form-control" id="picture" name="picture" placeholder="picture" accept="image/jpg, image/jpeg">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label class="col-form-label" for="socialMedia">Social Media</label>
                                                    <p>
                                                        <label class="switch switch-text switch-pill switch-info">
                                                            <input type="checkbox" class="switch-input" id="socialMedia" name="socialMedia" onchange="$('#logSocialMedia').prop('disabled',!this.checked)"
                                                                {{ ($member->social_media[0]['status']?'checked':'') }}>
                                                            <span class="switch-label" data-on="on" data-off="off"></span>
                                                            <span class="switch-handle"></span>
                                                        </label>
                                                    </p>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <select id="logSocialMedia" name="logSocialMedia" class="form-control" {{ ($member->social_media[0]['status']?'':'disabled') }}>
                                                        <option value="Google" {{ ($member->social_media[0]['sosmed']=='Google'?'selected':'') }}>Google</option>
                                                        <option value="Facebook" {{ ($member->social_media[0]['sosmed']=='Facebook'?'selected':'') }}>Facebook</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end tab 1 -->

                            </div>
                        </div>
                    </div>
                    <!--end card -->
                </div>
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Saldo
                            <small>management </small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <i class="fa fa fa-money"></i>
                                    <label class="col-form-label" for="dompet">Dompet</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="dompet" name="dompet" placeholder="00.00" value="{{$member->dompet}}" aria-describedby="api-error"
                                            readonly="">
                                        <em id="dompet-error" class="error invalid-feedback">Please enter a api</em>
                                    </div>
                                    <i class="fa fa fa-copyright"></i>
                                    <label class="col-form-label" for="koin">Koin</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" value="{{$member->koin}}" id="koin" name="koin" placeholder="00.00" aria-describedby="koin-error"
                                            readonly="">
                                        <em id="koin-error" class="error invalid-feedback">Please enter a koin</em>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Sales Member
                            <small>Data</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="col-form-label" for="sales">*Sales</label>
                                    <select id="sales" name="sales[]" class="form-control" aria-describedby="sales-error" required>
                                        @if(isset($member->sales)) @foreach ($member->sales as $atts)
                                        <option data-name="{{$atts['name']}}" data-email="{{$atts['email']}}" value="{{$atts['_id']}}" selected>{{$atts['name']}}</option>
                                        @endforeach @endif @foreach ($modUser as $modUser)
                                        <option data-name="{{$modUser->name}}" data-email="{{$modUser->email}}" value="{{$modUser->id}}">{{$modUser->name}}</option>
                                        @endforeach
                                    </select>
                                    <em id="sales-error" class="error invalid-feedback">Please enter a new sales</em>
                                </div>
                                <div class="input-group col-md-12">
                                    <span class="input-group-text">
                                        <i class="fa fa-user-circle-o"></i>
                                    </span>
                                    <input type="text" class="form-control" value="{{$atts['name'] or ''}}" id="sales-name" readonly>
                                </div>
                                <div class="input-group col-md-12" style="padding-top: 16px">
                                    <span class="input-group-text">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input type="text" class="form-control" id="sales-email" value="{{$atts['email'] or ''}}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--/.row-->
            @if($b2b_status)
            <div class="B2B box">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-align-justify"></i> Business
                                <small>Account </small>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="business">*Business Name</label>
                                            <input type="text" class="form-control" id="business" name="business" placeholder="Business Name" aria-describedby="business-error"
                                                value="{{$b2b_detail['business'] or ''}}">
                                            <em id="business-error" class="error invalid-feedback">Please enter a business</em>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="department">*Department Name</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="department" name="department" placeholder="Department Name" aria-describedby="department-error"
                                                value="{{$b2b_detail['department'] or ''}}">
                                            <em id="department-error" class="error invalid-feedback">Please enter a department</em>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="businesstype">*Business Type</label>
                                        <?php $businesstype = (isset($b2b_detail[ 'businesstype'])?$b2b_detail[ 'businesstype']:''); ?>
                                        <select id="businesstype" name="businesstype" class="form-control" aria-describedby="businesstype-error" required>
                                            <option value=""></option>
                                            <option value="Telecomunication" {{($businesstype=='Telecomunication' ? 'selected': '')}}>Telecomunication</option>
                                            <option value="Distributor" {{($businesstype=='Distributor' ? 'selected': '')}}>Distributor</option>
                                            <option value="Others" {{($businesstype=='Others' ? 'selected': '')}}>Others</option>
                                        </select>
                                        <em id="businesstype-error" class="error invalid-feedback">Please select a business type</em>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="totalemployee">*Total Employee</label>
                                        <?php $totalemployee = (isset($b2b_detail[ 'totalemployee'])?$b2b_detail[ 'totalemployee']:''); ?>
                                        <select id="totalemployee" name="totalemployee" class="form-control" aria-describedby="totalemployee-error" required>
                                            <option value=""></option>
                                            <option value="0-20" {{($totalemployee=='0-20' ? 'selected': '')}}>0-20</option>
                                            <option value="21-100" {{($totalemployee=='21-100' ? 'selected': '')}}>21-100</option>
                                            <option value="101-500" {{($totalemployee=='101-500' ? 'selected': '')}}>101-500</option>
                                            <option value=">500" {{($totalemployee=='>500' ? 'selected': '')}}>>500</option>
                                        </select>
                                        <em id="totalemployee-error" class="error invalid-feedback">Please select a total employee</em>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="attr-multiselect attr-dropdown form-group col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- <button class="btn btn-primary add_field_btn-primary">Add Address</button> -->
                            <hr>
                            <div class="option-card row">
                                <div class="form-group col-md-3">
                                    <label class="col-form-label" for="address">*Address Alias</label>
                                    <div class="control-group input-group">
                                        <input type="text" name="addressAlias[]" class="form-control" placeholder="Address Alias" aria-describedby="addressAlias-error" 
                                            value="{{(isset($member->address[0]['address_alias'])?$member->address[0]['address_alias']:'')}}" required>
                                        <em id="addressAlias-error" class="error invalid-feedback">Please enter a address alias</em>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="col-form-label" for="address">*Receiver Name</label>
                                    <div class="control-group input-group">
                                        <input type="text" name="receiverName[]" class="form-control" placeholder="Receiver Name" aria-describedby="receiverName-error"
                                            value="{{(isset($member->address[0]['receiver_name'])?$member->address[0]['receiver_name']:'')}}" required>
                                        <em id="receiverName-error" class="error invalid-feedback">Please enter a receiver name</em>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="col-form-label" for="address">*Phone Number</label>
                                    <div class="control-group input-group">
                                        <input type="text" name="phoneNumber[]" class="form-control" placeholder="Phone Number" aria-describedby="phoneNumber-error"
                                            value="{{(isset($member->address[0]['phone_number'])?$member->address[0]['phone_number']:'')}}" required>
                                        <em id="phoneNumber-error" class="error invalid-feedback">Please enter a phone number</em>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="col-form-label" for="address">*City Name</label>
                                    <div class="control-group input-group">
                                        <input type="text" name="cityName[]" class="form-control" placeholder="City Name" aria-describedby="cityName-error"
                                            value="{{(isset($member->address[0]['city_name'])?$member->address[0]['city_name']:'')}}" required>
                                        <em id="cityName-error" class="error invalid-feedback">Please enter a city name</em>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="col-form-label" for="address">*Post Code</label>
                                    <div class="control-group input-group">
                                        <input type="text" name="postCode[]" class="form-control" placeholder="Post Code" aria-describedby="postCode-error"
                                            value="{{(isset($member->address[0]['postal_code'])?$member->address[0]['postal_code']:'')}}" required>
                                        <em id="postCode-error" class="error invalid-feedback">Please enter a post code</em>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-form-label" for="address">*Address</label>
                                    <div class="control-group input-group">
                                        <input type="text" name="address[]" class="form-control" placeholder="Address" aria-describedby="address-error"
                                            value="{{(isset($member->address[0]['address'])?$member->address[0]['address']:'')}}" required>
                                        <em id="address-error" class="error invalid-feedback">Please enter a address</em>
                                    </div>
                                </div>
                                <div class="form-group col-md-12"><hr></div>
                            </div>
                            <div class="form-group input_fields_wrap">
                                @for($i=1; $i < count($member->address); $i++)
                                <div class="option-card row">
                                    <div class="form-group col-md-3">
                                        <label class="col-form-label" for="address">*Address Alias</label>
                                        <div class="control-group input-group">
                                            <input type="text" name="addressAlias[]" class="form-control" placeholder="Address Alias" aria-describedby="addressAlias-error" 
                                                value="{{(isset($member->address[0]['address_alias'])?$member->address[$i]['address_alias']:'')}}" required>
                                            <em id="addressAlias-error" class="error invalid-feedback">Please enter a address alias</em>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="col-form-label" for="address">*Receiver Name</label>
                                        <div class="control-group input-group">
                                            <input type="text" name="receiverName[]" class="form-control" placeholder="Receiver Name" aria-describedby="receiverName-error"
                                                value="{{(isset($member->address[0]['receiver_name'])?$member->address[$i]['receiver_name']:'')}}" required>
                                            <em id="receiverName-error" class="error invalid-feedback">Please enter a receiver name</em>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label" for="address">*Phone Number</label>
                                        <div class="control-group input-group">
                                            <input type="text" name="phoneNumber[]" class="form-control" placeholder="Phone Number" aria-describedby="phoneNumber-error"
                                                value="{{(isset($member->address[0]['phone_number'])?$member->address[$i]['phone_number']:'')}}" required>
                                            <em id="phoneNumber-error" class="error invalid-feedback">Please enter a phone number</em>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label" for="address">*City Name</label>
                                        <div class="control-group input-group">
                                            <input type="text" name="cityName[]" class="form-control" placeholder="City Name" aria-describedby="cityName-error"
                                                value="{{(isset($member->address[0]['city_name'])?$member->address[$i]['city_name']:'')}}" required>
                                            <em id="cityName-error" class="error invalid-feedback">Please enter a city name</em>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label" for="address">*Post Code</label>
                                        <div class="control-group input-group">
                                            <input type="text" name="postCode[]" class="form-control" placeholder="Post Code" aria-describedby="postCode-error"
                                                value="{{(isset($member->address[0]['postal_code'])?$member->address[$i]['postal_code']:'')}}" required>
                                            <em id="postCode-error" class="error invalid-feedback">Please enter a post code</em>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="col-form-label" for="address">*Address</label>
                                        <div class="control-group input-group">
                                            <input type="text" name="address[]" class="form-control" placeholder="Address" aria-describedby="address-error"
                                                value="{{(isset($member->address[0]['address'])?$member->address[$i]['address']:'')}}" required>
                                            <div class="input-group-btn">
                                                <!-- <button class="btn btn-danger remove" type="button">
                                                    <i class="fa fa-close"></i>
                                                </button> -->
                                            </div>
                                            <em id="address-error" class="error invalid-feedback">Please enter a address</em>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12"><hr></div>
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="card">
                        <p>
                            <div class="btn-group">
                                <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <!-- <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check"></i>&nbsp;Save</button>&nbsp; -->
                                <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                                    <i class="fa fa-times-rectangle"></i>&nbsp; Close
                                </button>
                            </div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="{{ asset('fiture-style/select2/select2.min.js') }}"></script>
<script>
    $('#logSocialMedia').select2({
        theme: "bootstrap",
        placeholder: 'Please select'
    });
    $('#level').select2({
        theme: "bootstrap",
        placeholder: 'Please select'
    });
    $('#sales').select2({
            theme: "bootstrap",
            placeholder: 'Please select'
        })
        .change(function () {
            var element = $(this).find('option:selected');
            $('#sales-name').val(element.attr('data-name'));
            $('#sales-email').val(element.attr('data-email'));
        });

    $('#type').select2({
        theme: "bootstrap",
        placeholder: 'Please select'
    });
    $('#businesstype').select2({
        theme: "bootstrap",
        placeholder: 'Please select'
    });
    $('#totalemployee').select2({
        theme: "bootstrap",
        placeholder: 'Please select'
    });

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

    $('#type').on('change', function () {
        $(this).addClass('is-valid').removeClass('is-invalid');
    });

    $('#businesstype').on('change', function () {
        $(this).addClass('is-valid').removeClass('is-invalid');
    });

    $('#totalemployee').on('change', function () {
        $(this).addClass('is-valid').removeClass('is-invalid');
    });

    $('#status').on('change', function () {
        $(this).addClass('is-valid').removeClass('is-invalid');
    });

    $('#sales').on('change', function () {
        $(this).addClass('is-valid').removeClass('is-invalid');
    });

    $(document).ready(function () {
        $('#type').change(function () {
            if ($.inArray("B2B", $(this).val())) {
                $(".box").hide();
            } else {
                $(".box").not(".B2B").hide();
                $(".B2B").show();
            }
        });
    });

    $("#jxForm1").validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            address: {
                required: true,
                minlength: 2
            },
            business: {
                required: true,
                minlength: 2
            },
            businesstype: {
                required: true
            },
            department: {
                required: true,
                minlength: 2
            },
            totalemployee: {
                required: true
            },
            sales: {
                required: true
            },
            type: {
                required: true
            },
            phone: {
                required: true
            },
            level: {
                required: true
            },
            password: {
                required: true,
                minlength: 5
            },
            confirm_password: {
                required: true,
                equalTo: '#password'
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: '{{ route("master-member.index") }}/find',
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: $('.id').val(),
                        email: function () {
                            return $('#jxForm1 :input[name="email"]').val();
                        }
                    }
                }
            }
        },
        messages: {
            name: {
                required: 'Please enter a name site',
                minlength: 'Name must consist of at least 2 characters'
            },
            address: {
                required: 'Please enter a name site',
                minlength: 'Name must consist of at least 2 characters'
            },
            business: {
                required: 'Please enter a name business',
                minlength: 'Name must consist of at least 2 characters'
            },
            department: {
                required: 'Please enter a name department',
                minlength: 'Name must consist of at least 2 characters'
            },
            businesstype: {
                required: 'Please select a business type'
            },
            totalemployee: {
                required: 'Please select a total employee'
            },
            type: {
                required: 'Please select a type'
            },
            phone: {
                required: 'Please enter a phone number'
            },
            sales: {
                required: 'Please select sales'
            },
            level: {
                required: 'Please select level'
            },
            password: {
                required: 'Please provide a password',
                minlength: 'Password must be at least 5 characters long'
            },
            confirm_password: {
                required: 'Please provide a password',
                minlength: 'Password must be at least 5 characters long',
                equalTo: 'Please enter the same password'
            },
            email: {
                email: 'Please enter a valid email address',
                remote: 'Email address already in use. Please use other email.'
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

    $(document).ready(function () {
        var max_fields = 10; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_btn-primary"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function (e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append(
                    '<div class="option-card"><div class="form-group"><label class="col-form-label" for="address">*Address</label><div id="address" class="control-group input-group"><input type="text" name="address[]" class="form-control" placeholder="Address" aria-describedby="address-error" required><div class="input-group-btn"><button class="btn btn-danger remove" type="button"><i class="fa fa-close"></i></button></div><em id="address-error" class="error invalid-feedback">Please enter a address</em></div></div></div>'
                ); //add input box
            }
        });

        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });
        $("#jxForm1").valid();
    });
    $(document).ready(function () {
        //here it will remove the current value of the remove button which has been pressed
        $("body").on("click", ".remove", function () {
            $(this).closest('.option-card').remove();
        });
        $("#jxForm1").valid();
    });
</script>
@endsection