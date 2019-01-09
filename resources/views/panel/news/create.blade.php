@extends('master') @section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('fiture-style/select2/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<style>
    .bootstrap-tagsinput{
        width: 100%;
    }
    .bootstrap-tagsinput .label{
        background: #20a8d8;
        padding: 0px 5px;
        border-radius: 4px;
    }
    .bootstrap-tagsinput .label span{
        border-left: 1px solid #eaeaea
    }
    #showgambar{
        width: 100px;
        height: 100px;
    }
</style>
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-md-12">
                <p>
                    <a href="{{ route('news.index') }}" class="btn btn-primary">
                        <i class="fa fa-backward"></i>&nbsp; Back to List
                    </a>
                </p>
            </div>
        </div>

        <form id="jxForm" novalidate="novalidate" method="POST" action="{{ isset($news) ? route('news.update', ['id' => $news->id]) : route('news.store') }}" enctype="multipart/form-data">
            @isset ($news)
                {{ method_field('PUT') }}
            @endisset
            {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> 
                            @isset ($news)
                                Edit 
                            @else
                                Create 
                            @endisset
                                News
                        </div>
                        <div class="card-body">
                            <fieldset class="form-group">
                                <label>Title</label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </span>
                                    <input class="form-control" id="title" name="title" type="text" placeholder="Title" autocomplete="off" autofocus="true" value="{{ isset($news) ? $news->title : old('title') }}">
                                </div>
                                @if ($errors->has('title'))
                                    <small class="text-muted">{{ $errors->first('title') }}</small>
                                @endif
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Description</label>
                                <div class="input-group">
                                    <textarea class="form-control" id="description" name="description" placeholder="Description"> {{ isset($news) ? $news->description : old('description') }}</textarea>
                                </div>
                                @if ($errors->has('description'))
                                    <small class="text-muted">{{ $errors->first('description') }}</small>
                                @endif
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> 
                            @isset ($news)
                                <a href="{{ route('news.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i>&nbsp; Create News
                                </a>
                            @endisset
                        </div>
                        <div class="card-body">
                            <fieldset class="form-group">
                                <label>Keyword</label>
                                <div class="input-group">
                                    <input class="form-control" id="keyword" name="keyword" type="text" placeholder="Type enter" autocomplete="off" data-role="tagsinput" value="{{ isset($news) ? $news->keyword : old('keyword') }}">
                                </div>
                                @if ($errors->has('keyword'))
                                    <small class="text-muted">{{ $errors->first('keyword') }}</small>
                                @endif
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Publish</label>
                                <div class="input-group">
                                    <select class="form-control" id="publish" name="is_publish">
                                        <option></option>
                                        <option value="0" {{ isset($news) ? $news->is_publish == '0' ? 'selected' : '' : '' }}>Draft</option>
                                        <option value="1" {{ isset($news) ? $news->is_publish == '1' ? 'selected' : '' : '' }}>Publish</option>
                                    </select>
                                </div>
                                @if ($errors->has('is_publish'))
                                    <small class="text-muted">{{ $errors->first('is_publish') }}</small>
                                @endif
                            </fieldset>
                            <fieldset class="form-group">
                                <label>Image</label>
                                <div class="input-group">
                                    @isset ($news)
                                        <img id="showgambar" src="{{ asset('img/news/'.$news->image) }}" class="img-responsive">
                                    @else
                                        <img id="showgambar" src="http://placehold.it/100x100" class="img-responsive">
                                    @endisset
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>
                                @if ($errors->has('image'))
                                    <small class="text-muted">{{ $errors->first('image') }}</small>
                                @endif
                            </fieldset>
                            <div class="form-actions">
                                <button class="btn btn-primary pull-right" type="submit">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="{{ asset('fiture-style/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/vendor//tinymce/tinymce.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
<script>
    $('#publish').select2({
        placeholder: 'Please choose',
        theme: 'bootstrap',
        allowClear: true
    });
    $('#jxForm').validate({
        rules: {
            title: {
                required: true,
                remote: {
                    url: '{{ route("news.validate") }}',
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        @isset ($news)
                            id: '{{ $news->id }}',
                        @endisset
                        title: function () {
                            return $('#jxForm :input[name="title"]').val();
                        }
                    }
                } 
            },
        },
        messages: {
            title: {
                required: 'Title is required.',
                remote: 'Title already exist.'
            },
        },
        errorElement: 'small',
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
    $('#image').change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#showgambar').css({
                    'height': '100px',
                    'width': '100px',
                })
                $('#showgambar').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        }
    })
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
@endsection