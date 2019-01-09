@extends('master') @section('content')
<link href="{{ asset('fiture-style/select2/select2.min.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <p>
                    <a class="btn btn-primary" href="{{ route('master-user.index') }}">
                        <i class="fa fa-backward"></i>&nbsp; Back to List
                    </a>
                    <button type="button" class="btn btn-success" onclick="save('#jxForm1','#jxForm2','exit')">
                        &nbsp; Save all and Exit
                    </button>
                </p>
                <!--start card -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> User
                        <small>new management and setting</small>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="home" aria-selected="false">General Setting</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="rp-tab" data-toggle="tab" href="#rp" role="tab" aria-controls="home" aria-selected="false">Permissions</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTab1Content">
                            <!-- TAB CONTENT -->

                            <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id="jxForm1" onsubmit="return false;" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" class="id" name="id">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="name">*Name
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Name user"></i>
                                                        </label>
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" aria-describedby="name-error">
                                                        <em id="name-error" class="error invalid-feedback">Please enter a name user</em>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="username">*Username
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Username"></i>
                                                        </label>
                                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" aria-describedby="username-error">
                                                        <em id="username-error" class="error invalid-feedback">Please enter a username</em>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="email">*Email
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Unique email for each user"></i>
                                                        </label>
                                                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" aria-describedby="email-error">
                                                        <em id="email-error" class="error invalid-feedback">Please enter a valid email address</em>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="role">*Role
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Declare role for user"></i>
                                                        </label>
                                                        <select id="role" class="form-control" style="width: 100% !important;" name="role" aria-describedby="role-error">
                                                            <option value=""></option>
                                                            @foreach($roles as $role)
                                                            <option value="{{$role->id}}" data-description="{{$role->description}}">{{$role->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <em id="role-error" class="error invalid-feedback">Please select role</em>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="text-center">
                                                        <img class="rounded picturePrev" src="{{ asset('img/fiture-logo.png') }}" style="width: 150px; height: 150px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="name">Picture (150x150)
                                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Picture for user"></i>
                                                        </label>
                                                        <input type="file" class="form-control" id="picture" name="picture" placeholder="picture">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="col-form-label" for="password">*Password
                                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Minimun 5 character password for user"></i>
                                                    </label>
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" aria-describedby="password-error">
                                                    <em id="password-error" class="error invalid-feedback">Please provide a password</em>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-form-label" for="confirm_password">*Confirm password
                                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Minimun 5 character password for user"></i>
                                                    </label>
                                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password"
                                                        aria-describedby="confirm_password-error">
                                                    <em id="confirm_password-error" class="error invalid-feedback">Please provide a password</em>
                                                </div>
                                            </div>
                                            <hr>
                                            <p>
                                                <div class="btn-group">
                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                    <button type="button" class="btn btn-success" onclick="save('#jxForm1','#jxForm2','continue')">Save and Continue</button>
                                                    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"></button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="save('#jxForm1','#jxForm2','new')">Save and Add New</a>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="save('#jxForm1','#jxForm2','exit')">Save and Exit</a>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                                                    <i class="fa fa-times-rectangle"></i>&nbsp; Cancel
                                                </button>
                                            </p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab 1 -->

                            <div class="tab-pane fade" id="rp" role="tabpanel" aria-labelledby="rp-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id="jxForm2" onsubmit="return false;">
                                            {{ csrf_field() }}
                                            <input type="hidden" class="id" name="id">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-success btn-sm" onclick="checkAll(true)">
                                                    <i class="fa fa-check-square-o"></i>&nbsp;Check All
                                                </button>
                                                <button type="button" class="btn btn-secondary btn-sm" onclick="checkAll(false)">
                                                    <i class="fa fa-square-o"></i>&nbsp;Uncheck All
                                                </button>
                                                <div class="col-md-12 validate-access" style="display:none;">
                                                    <center><span class="badge badge-pill badge-danger">Please check min 1 access.</span></center>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label" for="email">Access Permission
                                                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Access Permission for user"></i>
                                                </label>
                                                <div class="col-md-12 col-form-label">
                                                    @foreach ($list_ap as $lap)
                                                    <div class="form-check form-check-inline mr-1">
                                                        <input class="form-check-input" type="checkbox" value="{{$lap['_id']}}" name="access[]">
                                                        <label class="form-check-label" for="inline-checkbox1">{{$lap['name']}}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label" for="email">Menu Permission
                                                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Menu Permission for user"></i>
                                                </label>
                                                <div class="col-md-12 col-form-label">

                                                    <div class="row">
                                                        @foreach ($list_mp as $lmp)
                                                        <div class="col-md-6">
                                                            <div class="form-check form-check-inline mr-1">
                                                                <input class="form-check-input pm-{{$lmp['_id']}}" type="checkbox" value="{{$lmp['_id']}}" name="module[]" data-count="0" onchange="checklistParent($(this))">
                                                                <label class="form-check-label" for="inline-checkbox1">{{$lmp['name']}}</label>
                                                            </div>
                                                            <div class="col-md-12 col-form-label">
                                                                @foreach($lmp['child'] as $lmp2)
                                                                <div class="form-check form-check-inline mr-1">
                                                                    <input class="form-check-input" type="checkbox" value="{{$lmp2['_id']}}" name="module[]" data-parent="{{$lmp['_id']}}" onchange="checklist($(this))">
                                                                    <label class="form-check-label" for="inline-checkbox1">{{$lmp2['name']}}</label>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>

                                                </div>
                                            </div>
                                            <hr>
                                            <p>
                                                <div class="btn-group">
                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                    <button type="button" class="btn btn-success" onclick="save('#jxForm1','#jxForm2','continue')">Save and Continue</button>
                                                    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"></button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="save('#jxForm1','#jxForm2','new')">Save and Add New</a>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="save('#jxForm1','#jxForm2','exit')">Save and Exit</a>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                                                    <i class="fa fa-times-rectangle"></i>&nbsp; Cancel
                                                </button>
                                            </p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab 2 -->

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
<script src="{{ asset('fiture-style/select2/select2.min.js') }}"></script>
<script>
    var saveClick = false;

    $('#role').select2({
        theme: "bootstrap",
        placeholder: 'Please select'
    });
    $('#role').on('change', function () {
        $(this).addClass('is-valid').removeClass('is-invalid');
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

    function checkAll(status) {
        $('input[name="access[]"]').prop('checked', status);
        $('input[name="module[]"]').prop('checked', status);
    }
    
    //module access parent child checkbox
    //
    function checklistParent(elm){
    	var pmChild = $('input[data-parent="'+elm.val()+'"]');

    	if(elm.is(':checked')){
    		elm.attr('data-count',pmChild.length);
    		pmChild.prop('checked', true);
    	}else{
    		elm.attr('data-count',0);
    		pmChild.prop('checked', false);
    	}
    }

    function checklist(elm){
    	var pmParent = $('.pm-' + elm.attr('data-parent'));
    	var pmCounter =  parseInt(pmParent.attr('data-count'));

    	if(elm.is(':checked')){
    		pmCounter++;
    	}else{
    		pmCounter--;
    	}

    	if(pmCounter > 0){
    		pmParent.prop('checked', true);
    	}else{
    		pmParent.prop('checked', false);
    	}
    	pmParent.attr('data-count',pmCounter);
    }

    function validateAccess(){
        var status = false;
        if($('.form-check-input:checked').length > 0){
            status = true;
        }

        if(status){
            $('.validate-access').css('display','none');
            $('.form-check-input').addClass('is-valid');
            $('.form-check-input').removeClass('is-invalid');
        }else{
            $('.validate-access').css('display','block');
            $('.form-check-input').addClass('is-invalid');
            $('.form-check-input').removeClass('is-valid');
        }
        return status;
    }

    $('.form-check-input').change(function(){
        if(saveClick){
            validateAccess();
        }
    });

    $("#jxForm1").validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            username: {
                required: true,
                minlength: 2
            },
            role: {
                required: true
            },
            password: {
                required: true,
                minlength: 5
            },
            confirm_password: {
                equalTo: '#password'
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: '{{ route("master-user.index") }}/find',
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
                required: 'Please enter a name user',
                minlength: 'Name must consist of at least 2 characters'
            },
            username: {
                required: 'Please enter a username',
                minlength: 'Username must consist of at least 2 characters'
            },
            role: {
                required: 'Please select role'
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

    function save(formAct1, formAct2, action) {
        var sendForm = (formAct1 != '' ? formAct1 : formAct2);
        saveClick = true;

        //check form Tab 1 GENERAL
        if (formAct1 != '') {
            $('#general-tab').click();
            setTimeout(function () {
                if ($("#jxForm1").valid() && validateAccess()) {
                    postData(formAct1, formAct2, action, sendForm);
                }else{
                    if($("#jxForm1").valid() && !validateAccess()){
                        toastr.warning('Please check user access..', '');
                        $('#rp-tab').click();
                    }
                }
            }, @php echo env('SET_TIMEOUT', '500'); @endphp);
        }

        //check form Tab 2 Permisssion
        if (formAct2 != '' && formAct1 == '') {
            $('#rp-tab').click();
            if ($('.id').val() == '') {
                $('#general-tab').click();
            } else {
                postData(formAct1, formAct2, action, sendForm);
            }
        }
    }

    function postData(formAct1, formAct2, action, sendForm) {
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
            url: "{{ route('master-user.index') }}",
            type: 'POST',
            processData: false,
            contentType: false,
            data: new FormData($(sendForm)[0]),
            success: function (response) {
                if ($('.id').val() == '') {
                    $('.id').val(response);
                }

                if (formAct1 != '' && formAct2 != '') {
                    save('', formAct2, action);
                } else {
                    setTimeout(function () {
                        progressStat = false;
                        $('#progressModal').modal('toggle');
                        act(action);
                    }, @php echo env('SET_TIMEOUT', '500'); @endphp);
                }
            },
            error: function (e) {
                setTimeout(function () {
                    progressStat = false;
                    $('#progressModal').modal('toggle');
                    alert(' Error : ' + e.statusText);
                }, @php echo env('SET_TIMEOUT', '500'); @endphp);
            }
        });
    }

    function act(action) {
        switch (action) {
            case 'continue':
                toastr.success('Successfully saved..', '');
                break;
            case 'new':
                window.open("{{ route('master-user.create') }}/?new=user", "_self");
                break;
            case 'exit':
                window.open("{{ route('master-user.index') }}/?new=user", "_self");
                break;
        }
    }
</script>
@endsection