@extends('master')
@section('content')
<link href="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/select2/select2.min.css') }}" rel="stylesheet">
<div class="container-fluid">
	<div class="animate fadeIn">
		<div class="row">
			<div class="col-lg-2"></div>
			<div class="col-lg-8">
				<p>
				<button type="button" class="btn btn-primary" onclick="window.history.back()">
					<i class="fa fa-backward"></i>&nbsp; Back to List
				</button>
				</p>
				<!--start card -->
				<div class="card">
					<div class="card-header">
						<i class="fa fa-align-justify"></i> Email
						<small></small>
					</div>
					<div class="card-body">
						<div class="tab-content" id="myTab1Content">
						<!-- TAB CONTENT -->
							<div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
								<div class="row">
									<div class="col-md-12">
										<form  method="POST" action="{{route('mail.store')}}">
											{!! csrf_field() !!}
											<input type="hidden" class="id" name="id">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="col-form-label" for="name">*Admin ID</label>
														<input type="text" class="form-control" id="adminId" name="adminId" placeholder="adminId" aria-describedby="adminId-error" value="{{Auth::user()->email}}" readonly>
													</div>
													<div class="form-group">
														<label class="col-form-label" for="name">*To</label>
                                                        <div class="controls">
                                                                <select name="memberEmail[]" class="form-control select_2_search_paging" id="memberEmail" multiple ></select>
                                                                <span class="input-group-append">
                                                        </div>

														{!! $errors->first('memberEmail', '<p class="text-danger">:message</p>') !!}
														
													</div>
													<div class="form-group">
														<label class="col-form-label" for="name">*Subject</label>
														<input type="text" class="form-control" id="subject" name="subject" placeholder="subject"
															aria-describedby="name-error"
															value="{{ old('subject') ? old('subject') : '' }}" 
															>
														{!! $errors->first('subject', '<p class="text-danger">:message</p>') !!}
													</div>
													<div class="form-group">
														<label class="col-form-label" for="name">*Message</label>
														<textarea type="text" class="form-control" id="content" name="content" placeholder="content" aria-describedby="content-error">
															{!! old('content') !!}
														</textarea>
														{!! $errors->first('content', '<p class="text-danger">:message</p>') !!}
													</div>
													<div class="form-group">
														<label class="col-form-label" for="name">*Comment</label>
														<input type="text" class="form-control" id="comment" name="comment" placeholder="comment" aria-describedby="comment-error" value="{{ old('comment') ? old('comment') : '' }}">

														{!! $errors->first('comment', '<p class="text-danger">:message</p>') !!}
													</div>
												</div>
											</div>
											<hr>
											<p>
												<div class="modal-footer">
													<div class="form-group">
														<button type="submit" class="btn btn-primary"  value="Sign up">Save</button>
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
													</div>
												</div>
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

@section('myscript')
<script src="{{ asset('fiture-style/select2/select2.min.js') }}"></script>
<script src="{{ URL::to('js/vendor//tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('fiture-style/bootstrap-fileinput/js/plugins/sortable.js') }}" type="text/javascript"></script>
<script src="{{ asset('fiture-style/bootstrap-fileinput/js/fileinput.js') }}" type="text/javascript"></script>
<script src="{{ asset('fiture-style/bootstrap-fileinput/themes/fa/theme.js') }}" type="text/javascript"></script>

<script>
 var editor_config = {
      path_absolute : "{{ URL::to('/') }}/",
      selector : "textarea",
      plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
      relative_urls: false,
      file_browser_callback : function(field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.grtElementByTagName('body')[0].clientHeight;
        var cmsURL = editor_config.path_absolute+'laravel-filemanager?field_name'+field_name;
        if (type = 'image') {
          cmsURL = cmsURL+'&type=Images';
        } else {
          cmsUrl = cmsURL+'&type=Files';
        }

        tinyMCE.activeEditor.windowManager.open({
          file : cmsURL,
          title : 'Filemanager',
          width : x * 0.8,
          height : y * 0.8,
          resizeble : 'yes',
          close_previous : 'no'
        });
      }
    };

    tinymce.init(editor_config);
</script>

<script>
$(document).ready(function () {
       

        var mySelect2 = $('.select_2_search_paging');

        mySelect2.select2({
            theme: "bootstrap",
            placeholder: "Select",
            width: '100%',
            allowClear: true,
            ajax: {
                url: '{{ route('master-member.ajax-select2') }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {

                    return {
                        term: params.term,
                		page: params.page
                    };
                },
                processResults: function (data, params) {
                   
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;


                    return {
                        results: $.map(data.results.data, function (item) {
                        	return  {
                        		id: item.email,
                        		text: item.name
                        	}
                        }),
                        pagination: {
                            more : (params.page  * data.results.per_page) < data.results.total
                        }
                    };
                },
                cache: true,
            }
        });

        mySelect2.on("change", function () {
            // var select2Data = mySelect2.select2("data");

            // $('#xcontact_id').val(select2Data[0].id);
            // $('#xcontact_option').val(select2Data[0].text);

            //console.log(select2Data[0]);

        });
    });

</script>

@endsection