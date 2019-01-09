@extends('master') @section('content')
<link href="{{ asset('fiture-style/select2/select2.min.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="animate fadeIn">
        <form id="jxForm" method="POST" action="{{route('footer.index')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <p>
                        <a class="btn btn-primary" href="{{route('footer.index')}}">
                            <i class="fa fa-backward"></i>&nbsp; Back to List
                        </a>
                        <button type="submit" class="btn btn-success">Save all and Exit</button>
                    </p>
                    <!--start card -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> left
                            <small>Footer</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="siteTitle">*Left Title
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Declaration of left title"></i>
                                        </label>
                                        <input type="text" class="form-control" id="leftTitle" name="leftTitle" aria-describedby="leftTitle-error" placeholder="HOKY"
                                            value="{{$footer['left'][0]['title']}}">
                                        <em id="leftTitle-error" class="error invalid-feedback"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label" for="siteTitle">*Type
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Type list"></i>
                                        </label>
                                        <select name="typeLeft" class="form-control typeLeft" aria-invalid="true">
                                            <option value=""></option>
                                            <option value="Title">Title</option>
                                            <option value="Link">Link</option>
                                            <option value="Text">Text</option>
                                            <option value="Icon Text">Icon Text</option>
                                        </select>
                                        <em id="typeLeft-error" class="error invalid-feedback">Please select type</em>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-form-label">&nbsp;</label>
                                        <button type="button" class="btn btn-success btn-block" onclick="add('Left')">
                                            <i class="fa fa-plus"></i>&nbsp; Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="border list-left">
                                        <br>
                                        <?php $i=0; ?>
                                        @foreach($footer['left'][0]['list'] as $left_list)
                                        <?php
                                            $i++;
                                            switch($left_list['type']){
                                                case "Link":
                                                ?>
                                                <div class="row-md">
                                                    <div class="col-md-12">
                                                        <input type="hidden" class="idListLeft[]" name="idListLeft[]" value="{{$i}}">
                                                        <input type="hidden" class="typeLeft{{$i}}" name="typeLeft{{$i}}" value="Link">
                                                        <div class="row">
                                                            <div class="input-group col-md-4">
                                                                <input type="text" class="form-control" id="linkLeft{{$i}}" name="linkLeft{{$i}}" placeholder="Link" value="{{$left_list['link']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Link ex: About Us"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="input-group col-md-7">
                                                                <input type="text" class="form-control" id="urlLeft{{$i}}" name="urlLeft{{$i}}" placeholder="Url" value="{{$left_list['url']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Url ex: http://hoky.com"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="input-group col-md-1">
                                                                <a class="btn btn-danger" onclick="$(this).closest('.row-md').remove()">
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                                <?php
                                                break;
                                                case "Text":
                                                ?>
                                                <div class="row-md">
                                                    <div class="col-md-12">
                                                        <input type="hidden" class="idListLeft[]" name="idListLeft[]" value="{{$i}}">
                                                        <input type="hidden" class="typeLeft{{$i}}" name="typeLeft{{$i}}" value="Text">
                                                        <div class="row">
                                                            <div class="input-group col-md-11">
                                                                <input type="text" class="form-control" id="textLeft{{$i}}" name="textLeft{{$i}}" placeholder="text" value="{{$left_list['text']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Text ex: Monday - Friday"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <a class="btn btn-danger" onclick="$(this).closest('.row-md').remove()">
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                                <?php
                                                break;
                                                case "Title":
                                                ?>
                                                <div class="row-md">
                                                    <div class="col-md-12">
                                                        <input type="hidden" class="idListLeft[]" name="idListLeft[]" value="{{$i}}">
                                                        <input type="hidden" class="typeLeft{{$i}}" name="typeLeft{{$i}}" value="Title">
                                                        <div class="row">
                                                            <div class="input-group col-md-11">
                                                                <input type="text" class="form-control" id="titleLeft{{$i}}" name="titleLeft{{$i}}" placeholder="Title" value="{{$left_list['title']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Title ex: Opening Hours"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <a class="btn btn-danger" onclick="$(this).closest('.row-md').remove()">
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                                <?php
                                                break;
                                                case "Icon Text":
                                                ?>
                                                <div class="row-md">
                                                    <div class="col-md-12">
                                                        <input type="hidden" class="idListLeft[]" name="idListLeft[]" value="{{$i}}">
                                                        <input type="hidden" class="typeLeft{{$i}}" name="typeLeft{{$i}}" value="Icon Text">
                                                        <div class="row">
                                                            <div class="input-group col-md-4">
                                                                <input type="text" class="form-control" id="iconLeft{{$i}}" name="iconLeft{{$i}}" placeholder="icon" value="{{$left_list['icon']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Icon ex: Opening Hours"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="input-group col-md-7">
                                                                <input type="text" class="form-control" id="textLeft{{$i}}" name="textLeft{{$i}}" placeholder="text" value="{{$left_list['text']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Text ex: (021) 2939123"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <a class="btn btn-danger" onclick="$(this).closest('.row-md').remove()">
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                                <?php
                                                break;
                                            }
                                        ?>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <!--start card -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> middle
                            <small>Footer</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="siteTitle">*Middle Title
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Declaration of middle title"></i>
                                        </label>
                                        <input type="text" class="form-control" id="middleTitle" name="middleTitle" aria-describedby="middleTitle-error" placeholder="Our Location"
                                            value="{{$footer['middle'][0]['title']}}">
                                        <em id="middleTitle-error" class="error invalid-feedback"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label" for="siteTitle">*Type
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Type list"></i>
                                        </label>
                                        <select name="typeMiddle" class="form-control typeMiddle">
                                            <option value=""></option>
                                            <option value="Title">Title</option>
                                            <option value="Link">Link</option>
                                            <option value="Text">Text</option>
                                            <option value="Icon Text">Icon Text</option>
                                        </select>
                                        <em id="typeMiddle-error" class="error invalid-feedback">Please select type</em>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-form-label">&nbsp;</label>
                                        <button type="button" class="btn btn-success btn-block" onclick="add('Middle')">
                                            <i class="fa fa-plus"></i>&nbsp; Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="border list-middle">
                                        <br>
                                        <?php $i=0; ?>
                                        @foreach($footer['middle'][0]['list'] as $middle_list)
                                        <?php
                                            $i++;
                                            switch($middle_list['type']){
                                                case "Link":
                                                ?>
                                                <div class="row-md">
                                                    <div class="col-md-12">
                                                        <input type="hidden" class="idListMiddle[]" name="idListMiddle[]" value="{{$i}}">
                                                        <input type="hidden" class="typeMiddle{{$i}}" name="typeMiddle{{$i}}" value="Link">
                                                        <div class="row">
                                                            <div class="input-group col-md-4">
                                                                <input type="text" class="form-control" id="linkMiddle{{$i}}" name="linkMiddle{{$i}}" placeholder="Link" value="{{$middle_list['link']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Link ex: About Us"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="input-group col-md-7">
                                                                <input type="text" class="form-control" id="urlMiddle{{$i}}" name="urlMiddle{{$i}}" placeholder="Url" value="{{$middle_list['url']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Url ex: http://hoky.com"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="input-group col-md-1">
                                                                <a class="btn btn-danger" onclick="$(this).closest('.row-md').remove()">
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                                <?php
                                                break;
                                                case "Text":
                                                ?>
                                                <div class="row-md">
                                                    <div class="col-md-12">
                                                        <input type="hidden" class="idListMiddle[]" name="idListMiddle[]" value="{{$i}}">
                                                        <input type="hidden" class="typeMiddle{{$i}}" name="typeMiddle{{$i}}" value="Text">
                                                        <div class="row">
                                                            <div class="input-group col-md-11">
                                                                <input type="text" class="form-control" id="textMiddle{{$i}}" name="textMiddle{{$i}}" placeholder="text" value="{{$middle_list['text']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Text ex: Monday - Friday"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <a class="btn btn-danger" onclick="$(this).closest('.row-md').remove()">
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                                <?php
                                                break;
                                                case "Title":
                                                ?>
                                                <div class="row-md">
                                                    <div class="col-md-12">
                                                        <input type="hidden" class="idListMiddle[]" name="idListMiddle[]" value="{{$i}}">
                                                        <input type="hidden" class="typeMiddle{{$i}}" name="typeMiddle{{$i}}" value="Title">
                                                        <div class="row">
                                                            <div class="input-group col-md-11">
                                                                <input type="text" class="form-control" id="titleMiddle{{$i}}" name="titleMiddle{{$i}}" placeholder="Title" value="{{$middle_list['title']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Title ex: Opening Hours"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <a class="btn btn-danger" onclick="$(this).closest('.row-md').remove()">
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                                <?php
                                                break;
                                                case "Icon Text":
                                                ?>
                                                <div class="row-md">
                                                    <div class="col-md-12">
                                                        <input type="hidden" class="idListMiddle[]" name="idListMiddle[]" value="{{$i}}">
                                                        <input type="hidden" class="typeMiddle{{$i}}" name="typeMiddle{{$i}}" value="Icon Text">
                                                        <div class="row">
                                                            <div class="input-group col-md-4">
                                                                <input type="text" class="form-control" id="iconMiddle{{$i}}" name="iconMiddle{{$i}}" placeholder="icon" value="{{$middle_list['icon']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Icon ex: fa fa-phone"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="input-group col-md-7">
                                                                <input type="text" class="form-control" id="textMiddle{{$i}}" name="textMiddle{{$i}}" placeholder="text" value="{{$middle_list['text']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Text ex: (021) 2939123"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <a class="btn btn-danger" onclick="$(this).closest('.row-md').remove()">
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                                <?php
                                                break;
                                            }
                                        ?>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <!--start card -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> right
                            <small>Footer</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="siteTitle">*Right Title
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Declaration of right title"></i>
                                        </label>
                                        <input type="text" class="form-control" id="rightTitle" name="rightTitle" aria-describedby="rightTitle-error" placeholder="Contact Us"
                                            value="{{$footer['right'][0]['title']}}">
                                        <em id="rightTitle-error" class="error invalid-feedback"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label" for="siteTitle">*Type
                                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Type list"></i>
                                        </label>
                                        <select name="typeRight" class="form-control typeRight">
                                            <option value=""></option>
                                            <option value="Title">Title</option>
                                            <option value="Link">Link</option>
                                            <option value="Text">Text</option>
                                            <option value="Icon Text">Icon Text</option>
                                        </select>
                                        <em id="typeRight-error" class="error invalid-feedback">Please select type</em>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-form-label">&nbsp;</label>
                                        <button type="button" class="btn btn-success btn-block" onclick="add('Right')">
                                            <i class="fa fa-plus"></i>&nbsp; Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="border list-right">
                                        <br>
                                        <?php $i=0; ?>
                                        @foreach($footer['right'][0]['list'] as $right_list)
                                        <?php
                                            $i++;
                                            switch($right_list['type']){
                                                case "Link":
                                                ?>
                                                <div class="row-md">
                                                    <div class="col-md-12">
                                                        <input type="hidden" class="idListRight[]" name="idListRight[]" value="{{$i}}">
                                                        <input type="hidden" class="typeRight{{$i}}" name="typeRight{{$i}}" value="Link">
                                                        <div class="row">
                                                            <div class="input-group col-md-4">
                                                                <input type="text" class="form-control" id="linkRight{{$i}}" name="linkRight{{$i}}" placeholder="Link" value="{{$right_list['link']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Link ex: About Us"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="input-group col-md-7">
                                                                <input type="text" class="form-control" id="urlRight{{$i}}" name="urlRight{{$i}}" placeholder="Url" value="{{$right_list['url']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Url ex: http://hoky.com"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="input-group col-md-1">
                                                                <a class="btn btn-danger" onclick="$(this).closest('.row-md').remove()">
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                                <?php
                                                break;
                                                case "Text":
                                                ?>
                                                <div class="row-md">
                                                    <div class="col-md-12">
                                                        <input type="hidden" class="idListRight[]" name="idListRight[]" value="{{$i}}">
                                                        <input type="hidden" class="typeRight{{$i}}" name="typeRight{{$i}}" value="Text">
                                                        <div class="row">
                                                            <div class="input-group col-md-11">
                                                                <input type="text" class="form-control" id="textRight{{$i}}" name="textRight{{$i}}" placeholder="text" value="{{$right_list['text']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Text ex: Monday - Friday"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <a class="btn btn-danger" onclick="$(this).closest('.row-md').remove()">
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                                <?php
                                                break;
                                                case "Title":
                                                ?>
                                                <div class="row-md">
                                                    <div class="col-md-12">
                                                        <input type="hidden" class="idListRight[]" name="idListRight[]" value="{{$i}}">
                                                        <input type="hidden" class="typeRight{{$i}}" name="typeRight{{$i}}" value="Title">
                                                        <div class="row">
                                                            <div class="input-group col-md-11">
                                                                <input type="text" class="form-control" id="titleRight{{$i}}" name="titleRight{{$i}}" placeholder="Title" value="{{$right_list['title']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Title ex: Opening Hours"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <a class="btn btn-danger" onclick="$(this).closest('.row-md').remove()">
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                                <?php
                                                break;
                                                case "Icon Text":
                                                ?>
                                                <div class="row-md">
                                                    <div class="col-md-12">
                                                        <input type="hidden" class="idListRight[]" name="idListRight[]" value="{{$i}}">
                                                        <input type="hidden" class="typeRight{{$i}}" name="typeRight{{$i}}" value="Icon Text">
                                                        <div class="row">
                                                            <div class="input-group col-md-4">
                                                                <input type="text" class="form-control" id="iconRight{{$i}}" name="iconRight{{$i}}" placeholder="icon" value="{{$right_list['icon']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Icon ex: fa fa-phone"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="input-group col-md-7">
                                                                <input type="text" class="form-control" id="textRight{{$i}}" name="textRight{{$i}}" placeholder="text" value="{{$right_list['text']}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="Text ex: (021) 2939123"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <a class="btn btn-danger" onclick="$(this).closest('.row-md').remove()">
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                                <?php
                                                break;
                                            }
                                        ?>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <!--start action -->
                    <div class="card">
                        <div class="card-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-success">Save all and Exit</button>
                                <a class="btn btn-secondary" href="{{route('footer.index')}}">
                                    <i class="fa fa-times-rectangle"></i>&nbsp; Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--end card action -->
                </div>
            </div>
        </form>
    </div>
</div>
@include('panel.footer-management.footer.fade-form')
<!-- attribute type -->
@endsection

<!-- /.container-fluid -->
@section('myscript')
<script src="{{ asset('fiture-style/select2/select2.min.js') }}"></script>
<script>
    //
    var leftCount = {{ count($footer['left'][0]['list']) }};
    var middleCount = {{ count($footer['middle'][0]['list']) }};
    var rightCount = {{ count($footer['right'][0]['list']) }};

    //weight select2
    $('.typeLeft').select2({
        theme: "bootstrap",
        placeholder: 'Please select'
    }).change(function(){
        $(this).addClass('is-valid').removeClass('is-invalid');
        $(this).parent('.form-group').find('.select2-selection').attr('style','border-color:#4dbd74');
    });
    $('.typeMiddle').select2({
        theme: "bootstrap",
        placeholder: 'Please select'
    }).change(function(){
        $(this).addClass('is-valid').removeClass('is-invalid');
        $(this).parent('.form-group').find('.select2-selection').attr('style','border-color:#4dbd74');
    });
    $('.typeRight').select2({
        theme: "bootstrap",
        placeholder: 'Please select'
    }).change(function(){
        $(this).addClass('is-valid').removeClass('is-invalid');
        $(this).parent('.form-group').find('.select2-selection').attr('style','border-color:#4dbd74');
    });

    $('#jxForm').validate({
        rules: {
            leftTitle: {
                required: true
            },
            middleTitle: {
                required: true
            },
            rightTitle: {
                required: true
            },
        },
        messages: {
            leftTitle: {
                required: 'Please enter title'
            },
            middleTitle: {
                required: 'Please enter title'
            },
            rightTitle: {
                required: 'Please enter title'
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

    //
    function add(position){
        switch(position){
            case "Left":
                if($('.typeLeft').val() == ""){
                    $('.typeLeft').addClass('is-invalid').removeClass('is-valid');
                    $('.typeLeft').parent('.form-group').find('.select2-selection').attr('style','border-color:#f86c6b');
                }else{
                    leftCount++;
                    addList($('.typeLeft').val(), position, ".list-left", leftCount);
                }
            break;
            case "Middle":
                if($('.typeMiddle').val() == ""){
                    $('.typeMiddle').addClass('is-invalid').removeClass('is-valid');
                    $('.typeMiddle').parent('.form-group').find('.select2-selection').attr('style','border-color:#f86c6b');
                }else{
                    middleCount++;
                    addList($('.typeMiddle').val(), position, ".list-middle", middleCount);
                }
            break;
            case "Right":
                if($('.typeRight').val() == ""){
                    $('.typeRight').addClass('is-invalid').removeClass('is-valid');
                    $('.typeRight').parent('.form-group').find('.select2-selection').attr('style','border-color:#f86c6b');
                }else{
                    rightCount++;
                    addList($('.typeRight').val(), position, ".list-right", rightCount);
                }
            break;
        }
    }

    //
    function addList(type, position, list, counter){
        switch(type){
            case "Link":
                $('.fade .link-div').find('.idList').attr('name', 'idList'+position+'[]').val(counter);
                $('.fade .link-div').find('.listType').attr('name', 'type'+position+counter);
                $('.fade .link-div').find('.link').attr('id', 'link'+position+counter).attr('name', 'link'+position+counter);
                $('.fade .link-div').find('.url').attr('id', 'url'+position+counter).attr('name', 'url'+position+counter);
                $(list).append($('.fade .link-div').html());
            break;
            case "Text":
                $('.fade .text-div').find('.idList').attr('name', 'idList'+position+'[]');
                $('.fade .text-div').find('.listType').attr('name', 'type'+position+counter);
                $('.fade .text-div').find('.text').attr('id', 'text'+position+counter).attr('name', 'text'+position+counter);
                $(list).append($('.fade .text-div').html());
            break;
            case "Title":
                $('.fade .title-div').find('.idList').attr('name', 'idList'+position+'[]');
                $('.fade .title-div').find('.listType').attr('name', 'type'+position+counter);
                $('.fade .title-div').find('.title').attr('id', 'title'+position+counter).attr('name', 'title'+position+counter);
                $(list).append($('.fade .title-div').html());
            break;
            case "Icon Text":
                $('.fade .icon-text-div').find('.idList').attr('name', 'idList'+position+'[]').val(counter);
                $('.fade .icon-text-div').find('.listType').attr('name', 'type'+position+counter);
                $('.fade .icon-text-div').find('.icon').attr('id', 'icon'+position+counter).attr('name', 'icon'+position+counter);
                $('.fade .icon-text-div').find('.text').attr('id', 'text'+position+counter).attr('name', 'text'+position+counter);
                $(list).append($('.fade .icon-text-div').html());
            break;
        }
        $('.fa-info-circle').tooltip();
    }
</script>
@endsection