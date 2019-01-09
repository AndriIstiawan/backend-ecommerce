@extends('master') @section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('fiture-style/select2/select2.min.css') }}">
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <p>
                    <a href="{{ route('segments.index') }}" class="btn btn-primary">
                        <i class="fa fa-backward"></i>&nbsp; Back to List
                    </a>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Segments</div>
                    <form id="form" class="form-horizontal" action="{{ isset($segments) ? route('segments.update', ['id' => $segments->id]) : route('segments.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @isset ($segments)
                            {{ method_field('PUT') }}
                        @endisset
                        <input type="hidden" name="version" value="{{ isset($segments) ? $segments->type : $version }}">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="title">Title</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="title" type="text" name="title" placeholder="Enter Title.." aria-describedby="title-error" value="{{ isset($segments) ? $segments->title : '' }}">
                                    <em id="title-error" class="error invalid-feedback"></em>
                                    @if ($errors->has('title'))
                                        <em id="title-error" class="error invalid-feedback">{{ $errors->first('title') }}</em>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="order">Order</label>
                                <div class="col-md-3">
                                    <input class="form-control" id="order" type="number" name="order" placeholder="Enter Order.." min="1" aria-describedby="order-error" value="{{ isset($segments) ? $segments->order : '' }}">
                                    <em id="order-error" class="error invalid-feedback"></em>
                                    @if ($errors->has('order'))
                                        <em id="title-error" class="error invalid-feedback">{{ $errors->first('order') }}</em>
                                    @endif
                                </div>
                            </div>
                            @if ($version == 'v3')
                                {{-- expr --}}
                            @else
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="images">Images <small>({{ $version == 'v1' ? '350x220' : '1200x250' }})</small></label>
                                <div class="col-md-6">
                                    <img id="showImages" src="{{ isset($segments) && $segments->images != '' ? asset('img/segments-products/'.$segments->images) : ($version == 'v1' ? 'http://placehold.it/350x220' : 'http://placehold.it/1200x250') }}" class="img-thumbnail">
                                    <input class="form-control" id="images" type="file" name="images" style="margin-top: 10px;">
                                    @if ($errors->has('images'))
                                        <em id="title-error" class="error invalid-feedback">{{ $errors->first('images') }}</em>
                                    @endif
                                </div>
                            </div>
                            @endif
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="is_publish">Published</label>
                                <div class="col-md-3">
                                    <select class="form-control" id="is_publish" name="is_publish" aria-describedby="order-error">
                                        @foreach (['draft','published'] as $v)
                                            <option value="{{ $v }}" {{ (isset($segments) && $segments->is_publish == $v) ? 'selected' : '' }}>{{ ucwords($v) }}</option>
                                        @endforeach
                                    </select>
                                    <em id="is_publish-error" class="error invalid-feedback"></em>
                                    @if ($errors->has('is_publish'))
                                        <em id="title-error" class="error invalid-feedback">{{ $errors->first('is_publish') }}</em>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div id="products" ref="products" class="card" style="margin: -15px 15px 5px;">
                            <div class="card-header">Products</div>
                            <div class="card-body">
                                <div class="alert alert-primary" role="alert">please choose a product no less than 10, you have choose @{{ selected.length }} product</div>
                                <div class="table-responsive">
                                    <input type="text" v-model="filter" class="form-control" placeholder="Filter by name">
                                    <table _fordragclass="table-responsive-sm" class="table table-bordered table-striped table-sm display responsive datatable"
                                        cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th class="text-nowrap">Brand</th>
                                                <th class="text-nowrap">Product</th>
                                                <th class="text-nowrap">
                                                    <center>
                                                        <input type="checkbox" @change="selectAll" :checked="selected.length >= 10" data-toggle="tooltip" :data-title="selected.length == 0 ? 'Select 10 product' : 'Unselect 10 product'" :title="selected.length == 0 ? 'Select 10 product' : 'Unselect 10 product'">
                                                    </center>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(p, i) in filterProducts">
                                                <td>@{{ ++i }}</td>
                                                <td v-html="highlight(p.brand, filter)"></td>
                                                <td v-html="highlight(p.name, filter)"></td>
                                                <td>
                                                    <center><input type="checkbox" :checked="p.selected" :name="`product[]`" :value="p._id" v-model="selected"></center>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <ul class="pagination">
                                        <li class="page-item">
                                            <a class="page-link" 
                                                v-if="page == 0">Prev</a>
                                            <a class="page-link" 
                                                @click="page--" v-else>Prev</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" 
                                                @click="page++" v-if="page <= (pageCount - 1)">Next</a>
                                            <a class="page-link"
                                                v-else>Next</a>
                                        </li>
                                    </ul>
                                    Total Product: @{{ total_row }}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-primary" type="submit" :disabled="">
                            <i class="fa fa-save"></i> {{ !isset($segments) ? 'Save' : 'Update' }}</button>
                            <button class="btn btn-sm btn-danger" type="reset">
                            <i class="fa fa-refresh"></i> Reset</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="//cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
<script src="{{ asset('fiture-style/select2/select2.min.js') }}"></script>
<script>
    $('#is_publishs').select2({
        allowClear: true,
        theme: 'bootstrap',
        placeholder: 'please choose an option'
    });
    $('#form').validate({
        ignore: 'input[type=hidden]',
        rules: {
            title: {
                required: true,
                remote: {
                    url: '{{ action("SpecialProduct\SegmentController@validation") }}',
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        @isset ($segments)
                            id: '{{ $segments->id }}',
                        @endisset
                        title: function () {
                            return $('#form :input[name="title"]').val();
                        }
                    }
                } 
            },
            order: {
                required: true,
            },
            is_publish:{
                required: true,
            },
            'product[]': {
                required: true,
                minlength: 10
            }
        },
        messages: {
            title: {
                required: 'Title is required.',
                remote: 'Title already exist.'
            },
            order: {
                required: 'Title is required.',
            },
            is_publish:{
                required: 'Please choose an option.',
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
        },
    });
    $('#images').change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#showImages').attr('src', e.target.result);
            };

            reader.readAsDataURL(this.files[0]);
        }
    });
    let id = '';
    @isset ($segments)
        id = '&id={{  $segments->id }}';
    @endisset
    @if (app()->environment() != 'local' || env('APP_DEBUG') == false)
        let production = false;
    @else 
        let production = true;
    @endif
    Vue.config.productionTip = production;
    Vue.config.debug = production;
    Vue.config.silent = true; // disabled warning
    Vue.config.devtools = production;
    new Vue({
        el: '#products',
        data:{
            products: [],
            page: 0,
            perPage: 25,
            filter: '',
            selected: [],
            skip: {
                type: Number
            },
            total_row: 0,
            loading: false
        },
        mounted(){
            this.fetchData(0);
        },
        computed:{
            filterProducts(){
                const start = this.page * this.perPage,
                end = start + this.perPage;
                return this.products.slice(start, end).filter(p => {
                    return p.name.toLowerCase().includes(this.filter.toLowerCase()) || p.brand.toLowerCase().includes(this.filter.toLowerCase());
                });
            },
            pageCount(){
                let l = this.products.length,
                    s = this.perPage;
                return Math.floor(l/s);
            }
        },
        methods:{
            fetchData(skip){
                axios.get("{{ action('SpecialProduct\SegmentController@getProduct') }}?skip="+skip+id)
                .then((r) => {
                    this.products = r.data.products;
                    this.total_row = r.data.total_row;
                    this.skip = parseInt(r.data.skip);
                    this.selected = r.data.selected;
                })
            },
            highlight(words, query){
                function pregQuote(str){
                    return (str.trim() + '').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, "\\$1");
                }
                var iQuery = new RegExp(pregQuote(query), 'ig');
                return words.toString().replace(iQuery, function (matchedTxt, a, b) {
                    return ('<span style=\'color: #007BFF;\'>' + matchedTxt + '</span>');
                });
            },
            selectAll(){
                if(this.selected.length < 10){
                    let products = [];
                    for(let i = 0; i <= 9; i++){
                        products.push(this.filterProducts[i]._id);
                    }
                    this.selected = products;
                }else{
                    this.selected = [];
                }
            }
        }
    });
</script>

@endsection