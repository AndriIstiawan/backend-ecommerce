<form id="jxForm" novalidate="novalidate" enctype="multipart/form-data">
    <div class="modal-header">
        <h4 class="modal-title">Import Form</h4>
    </div>
    <div class="modal-body">
        {{ csrf_field() }}
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Import brands!</h4>
            <p>Before import the brand, make sure the brand is in accordance with {{env('APP_NAME','FITURE')}} terms and conditions.
            </p>
        </div>
        <div class="form-group">
            <label class="col-form-label" for="name">*Files
                <br>
                <small class="text-muted">Please download form file before import brand data.</small>
            </label>
        </div>
        <div class="form-group">
            <input type="file" name="import" class="form-control" aria-describedby="import-error" accept=".xls, .xlsx">
            <em id="import-error" class="error invalid-feedback"></em>
        </div>
        <div class="form-group progress-modal d-none">
            <i class="fa fa-gear fa-spin"></i>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width:0%"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="form-group">
            <a class="btn btn-primary" href="{{route('brands.index')}}/download-import-form">
                <i class="fa fa-download"></i>&nbsp; Download Form
            </a>
            <button type="button" class="btn btn-primary" name="signup" value="Sign up" onclick="save()">Import Data</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</form>

<script>
    $('#jxForm').validate({
        rules: {
            import: {
                required: true
            },
        },
        messages: {
            import: {
                required: 'Please input form',
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
    
    function save() {
        if ($('#jxForm').valid()){
            $('.progress-modal').removeClass('d-none');
            $('#jxForm button').prop('disabled', true);
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
                url: "{{ route('brands.index') }}/import-data",
                type: 'POST',
                processData: false,
                contentType: false,
                data: new FormData($('#jxForm')[0]),
                success: function (response) {
                    $('#jxForm button').prop('disabled', false);
                    toastr.success('Please check download file for detail data input', 'Import file success..');
                    window.open("{{url('/download-storage')}}/"+response, "_blank");
                    $('.btn-secondary').click();
                },
                error: function (e) { 
                    $('#jxForm button').prop('disabled', false); 
                    toastr.warning('Please check download file for detail data input', 'Import file failed..');
                    $('.btn-secondary').click();
                }
            });
        }
    }
</script>