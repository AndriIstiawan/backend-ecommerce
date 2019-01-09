@extends('master')
@section('content')
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
						<i class="fa fa-align-justify"></i> Edit Brand
						<small></small>
					</div>
					<div class="card-body">
						<ul class="nav nav-tabs" id="myTab1" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" id="general-tab" data-toggle="tab" href="#general" 
									role="tab" aria-controls="home" aria-selected="false">General Setting</a>
							</li>
						</ul>
						<div class="tab-content" id="myTab1Content">
						<!-- TAB CONTENT -->
							
							<div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
								<div class="row">
									<div class="col-md-12">
										<form id="jxForm1" enctype="multipart/form-data" method="POST" action="{{route('brands.update',['id' => $brand->id])}}">
											{{ method_field('PUT') }}
											{{ csrf_field() }}
											<input type="hidden" class="id" name="id" value="{{ $brand->id }}">
											<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-form-label" for="name">*Name
                                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Name of Brand"></i>
                                                    </label>
													<input type="text" class="form-control" id="name" name="name" placeholder="name brand" aria-describedby="name-error" value="{{ $brand->name }}">
													<em id="name-error" class="error invalid-feedback">Please enter a name of brand</em>
												</div>
												<div class="form-group">
													<label class="col-form-label" for="name">*Key ID
                                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Name of Brand"></i>
                                                    </label>
													<input type="text" class="form-control" id="slug" name="slug" placeholder="code product" aria-describedby="slug-error" value="{{ $brand->slug }}">
													<em id="slug-error" class="error invalid-feedback">Please enter a slug of brand</em>
												</div>
												<div class="text-center">
													<img class="rounded picturePrev" 
														src="{{(isset($brand->picture)?asset('img/brands/'.$brand->picture):asset('img/fiture-logo.png'))}}" 
														style="width: 150px; height: 70px;">
												</div>
												<div class="form-group">
													<label class="col-form-label" for="name">Image (150x70)
                                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-original-title="Name of Brand"></i>
                                                    </label>
													<input type="file" class="form-control" id="picture" name="picture">
												</div>
											</div></div>
											<hr>
											<p>
												<div class="btn-group"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
													<button type="submit" class="btn btn-success">Save and Continue</button>
												</div>
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
			reader.onload = function (e){ $('.picturePrev').attr('src', e.target.result); }
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#picture").change(function (){ readURL(this); });
	
	$("#jxForm1").validate({
		rules:{
			name:{required:true},
			slug:{
                required:true,
                remote: {
                    url: '{{ route("brands.index") }}/find',
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: $('.id').val(),
                        slug: function () {
                            return $('#jxForm1 :input[name="slug"]').val();
                        }
                    }
                }
            },
		},
		messages:{
			name:{
				required:'Please enter a name'
			},
			slug:{
				required:'Please enter a slug',
                remote:'Slug already in use. Please use other slug.'
			}
		},
		errorElement:'em',
		errorPlacement:function(error,element){
			error.addClass('invalid-feedback');
		},
		highlight:function(element,errorClass,validClass){
			$(element).addClass('is-invalid').removeClass('is-valid');
		},
		unhighlight:function(element,errorClass,validClass){
			$(element).addClass('is-valid').removeClass('is-invalid');
		}
	});
</script>
@endsection