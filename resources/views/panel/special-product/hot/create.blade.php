@extends('master') 
@section('content')
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-md-12">
                <p>
                    <a href="{{ route('hot-deals.index') }}" class="btn btn-primary">
                        <i class="fa fa-backward"></i>&nbsp; Back to List
                    </a>
                </p>
            </div>
        </div>

        <form id="jxForm" novalidate="novalidate" method="POST" action="{{ isset($deals) ? route('hot-deals.update', ['id' => $deals->id]) : route('hot-deals.store') }}" enctype="multipart/form-data">
            @isset ($deals)
                {{ method_field('PUT') }}
            @endisset
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> 
                            @isset ($deals)
                                Edit 
                            @else
                                Create 
                            @endisset
                                Hot deals
                        </div>
                        <div class="card-body">
                            <fieldset class="form-group">
                                <label>Hot deals images</label>
                                <div class="input-group">
                                    @isset ($deals)
                                        <img id="showgambar" src="{{ is_null($deals->hot_images) ? 'https://via.placeholder.com/350x150' : asset('img/hot-deals/'.$deals->hot_images) }}" class="img-responsive" width="350" height="150">
                                    @else
                                        <img id="showgambar" src="http://placehold.it/350x150" class="img-responsive">
                                    @endisset
                                    <input type="file" class="form-control" id="image" name="image" value="{{ $deals->hot_images }}">
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
                <div class="col-md-2"></div>
            </div>
        </form>
    </div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script>
    $('#jxForm').validate({
        rules: {
            image: {
                required: true, 
            },
        },
        messages: {
            image: {
                required: 'Title is required.',
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
                    'height': '150px',
                    'width': '350px',
                })
                $('#showgambar').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        }
    })
</script>
@endsection