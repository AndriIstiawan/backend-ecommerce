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
<form id="jxForm1" novalidate="novalidate" method="POST" action="{{ route('master-member.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="container-fluid">
        <div class="animate fadeIn">
            <div class="row">
                <div class="col-md-7">
                    <!--start card -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Member
                            <small>new management </small>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="myTab1Content">
                                <!-- TAB CONTENT -->

                                <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" class="id" name="id">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="name">*Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" aria-describedby="name-error">
                                                        <em id="name-error" class="error invalid-feedback">Please enter a name site</em>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label" for="email">*Email</label>
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" aria-describedby="email-error">
                                                    <em id="email-error" class="error invalid-feedback">Please enter a valid email address</em>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="phone">*Phone</label>
                                                        <input type="number" class="form-control" id="phone" name="phone" placeholder="Phone" aria-describedby="phone-error">
                                                        <em id="phone-error" class="error invalid-feedback">Please enter a valid phone</em>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="point">*Point</label>
                                                        <input type="number" class="form-control" name="point" placeholder="0" aria-describedby="point-error" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="level">*Level</label>
                                                        <input type="hidden" name="level" value="{{$level['_id']}}">
                                                        <input type="number" class="form-control" placeholder="{{$level['name']}}" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="type">*Type</label>
                                                        <select id="type" name="type[]" class="form-control" aria-describedby="type-error" multiple="" required>
                                                            <option value=""></option>
                                                            <option value="B2B">B2B</option>
                                                            <option value="B2C">B2C</option>
                                                        </select>
                                                        <em id="type-error" class="error invalid-feedback">Please select a type</em>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="status">*Status</label>
                                                        <p>
                                                            <label class="switch switch-text switch-pill switch-info">
                                                                <input type="checkbox" class="switch-input" id="status" name="status">
                                                                <span class="switch-label" data-on="On" data-off="Off"></span>
                                                                <span class="switch-handle"></span>
                                                            </label>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="text-center">
                                                        <img class="rounded picturePrev" src="{{ asset('img/fiture-logo.png') }}" style="width: 150px; height: 150px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="name">Picture (150x150)</label>
                                                        <input type="file" class="form-control" id="picture" name="picture" placeholder="picture" accept="image/jpg, image/jpeg">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="col-form-label" for="password">*Password</label>
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" aria-describedby="password-error">
                                                    <em id="password-error" class="error invalid-feedback">Please provide a password</em>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-form-label" for="confirm_password">*Confirm password</label>
                                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password"
                                                        aria-describedby="confirm_password-error">
                                                    <em id="confirm_password-error" class="error invalid-feedback">Please provide a password</em>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label class="col-form-label" for="socialMedia">Social Media</label>
                                                    <p>
                                                        <label class="switch switch-text switch-pill switch-info">
                                                            <input type="checkbox" class="switch-input" id="socialMedia" name="socialMedia"
                                                                onchange="$('#logSocialMedia').prop('disabled',!this.checked)">
                                                            <span class="switch-label" data-on="on" data-off="off"></span>
                                                            <span class="switch-handle"></span>
                                                        </label>
                                                    </p>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <select id="logSocialMedia" name="logSocialMedia" class="form-control" disabled>
                                                        <option value="Google">Google</option>
                                                        <option value="Facebook">Facebook</option>
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
                <div class="col-md-5">
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
                                        <span class="input-group-text">Rp.</span>
                                        <input type="number" class="form-control idr-currency" id="dompet" name="dompet" placeholder="00" aria-describedby="dompet-error">
                                        <em id="dompet-error" class="error invalid-feedback">Please enter a dompet</em>
                                    </div>
                                    <i class="fa fa fa-copyright"></i>
                                    <label class="col-form-label" for="koin">Koin</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp.</span>
                                        <input type="number" class="form-control idr-currency" id="koin" name="koin" placeholder="00" aria-describedby="koin-error">
                                        <em id="koin-error" class="error invalid-feedback">Please enter a koin</em>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Sales
                            <small>management </small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="col-form-label" for="sales">*Sales</label>
                                    <select id="sales" name="sales[]" class="form-control" aria-describedby="sales-error" required>
                                        <option value=""></option>
                                        @foreach ($modUser as $modUser)
                                        <option data-name="{{$modUser->name}}" data-email="{{$modUser->email}}" value="{{$modUser->id}}">{{$modUser->name}}</option>
                                        @endforeach
                                    </select>
                                    <em id="sales-error" class="error invalid-feedback">Please enter a new sales</em>
                                </div>
                                <div class="input-group col-md-12">
                                    <span class="input-group-text">
                                        <i class="fa fa-user-circle-o"></i>
                                    </span>
                                    <input type="text" class="form-control" id="sales-name" readonly>
                                </div>
                                <div class="input-group col-md-12" style="padding-top: 16px">
                                    <span class="input-group-text">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input type="text" class="form-control" id="sales-email" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.row-->
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
                                            <input type="text" class="form-control" id="business" name="business" placeholder="Business Name" aria-describedby="business-error">
                                            <em id="business-error" class="error invalid-feedback">Please enter a business</em>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="department">*Department Name</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="department" name="department" placeholder="Department Name" aria-describedby="department-error">
                                            <em id="department-error" class="error invalid-feedback">Please enter a department</em>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="businesstype">*Business Type</label>
                                        <select id="businesstype" name="businesstype" class="form-control" aria-describedby="businesstype-error" required>
                                            <option value=""></option>
                                            <option value="Telecomunication">Telecomunication</option>
                                            <option value="Distributor">Distributor</option>
                                            <option value="Others">Others</option>
                                        </select>
                                        <em id="businesstype-error" class="error invalid-feedback">Please select a business type</em>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="totalemployee">*Total Employee</label>
                                        <select id="totalemployee" name="totalemployee" class="form-control" aria-describedby="totalemployee-error" required>
                                            <option value=""></option>
                                            <option value="0-20">0-20</option>
                                            <option value="21-100">21-100</option>
                                            <option value="101-500">101-500</option>
                                            <option value=">500">>500</option>
                                        </select>
                                        <em id="totalemployee-error" class="error invalid-feedback">Please select a total employee</em>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="attr-multiselect attr-dropdown form-group col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-primary add_field_btn-primary">Add Address</button>
                            <hr>
                            <div class="option-card">
                                <div class="form-group input_fields_wrap">
                                    <div class="option-card">
                                        <div class="form-group">
                                            <label class="col-form-label" for="address">*Address</label>
                                            <div id="address" class="control-group input-group" style="margin-top:10px">
                                                <input type="text" name="address[]" class="form-control" placeholder="Address" aria-describedby="address-error" required>
                                                <em id="address-error" class="error invalid-feedback">Please enter a address</em>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check"></i>&nbsp;Save</button>&nbsp;
                                <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                                    <i class="fa fa-times-rectangle"></i>&nbsp; Cancel
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
            dompet: {
                required: 'Please enter a dompet'
            },
            koin: {
                required: 'Please enter a koin'
            },
            sales: {
                required: 'Please select sales'
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
                    '<div class="option-card"><div class="form-group"><label class="col-form-label" for="address">*Address</label><div id="address" class="control-group input-group" style="margin-top:10px"><input type="text" name="address[]" class="form-control" placeholder="Address" aria-describedby="address-error" required><div class="input-group-btn"><button class="btn btn-danger remove" type="button"><i class="fa fa-close"></i></button></div><em id="address-error" class="error invalid-feedback">Please enter a address</em></div></div></div>'
                ); //add input box
            }
        });

        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });
    $(document).ready(function () {
        //here it will remove the current value of the remove button which has been pressed
        $("body").on("click", ".remove", function () {
            $(this).closest('.form-group').remove();
        });
    });
</script>
@endsection