@extends('master') @section('content')
<!-- add material icons -->
<link href="{{ asset('googleapis/material-icons/material-icons.css') }}" rel="stylesheet">
<style>
    .card-body a{color: #fff}
</style>
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-sm-6">
                <p>
                    <a href="{{route('footer.create')}}" class="btn btn-primary ladda-button" data-style="zoom-in">
                        <span class="ladda-label">
                            <i class="fa fa-edit">
                            </i>&nbsp; Setting Footer
                        </span>
                    </a>
                </p>
                
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card text-white bg-secondary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <h5 id="list-item-1">{{$footer['left'][0]['title']}}</h5>
                                @foreach($footer['left'][0]['list'] as $left_list)
                                <?php
                                switch($left_list['type']){
                                    case "Link":
                                    echo '<a href="'.$left_list['url'].'" target="_blank">'.$left_list['link'].'</a><br>';
                                    break;
                                    case "Text":
                                    echo $left_list['text'].'<br>';
                                    break;
                                    case "Title":
                                    echo '<b>'.$left_list['title'].'</b><br>';
                                    break;
                                    case "Icon Text":
                                    echo '<a href="#"><i class="'.$left_list['icon'].'"></i>&nbsp;&nbsp;&nbsp;'.$left_list['text'].'</a><br>';
                                    break;
                                }
                                ?>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                <h5 id="list-item-1">{{$footer['middle'][0]['title']}}</h5>
                                @foreach($footer['middle'][0]['list'] as $middle_list)
                                <?php
                                switch($middle_list['type']){
                                    case "Link":
                                    echo '<a href="'.$middle_list['url'].'" target="_blank">'.$middle_list['link'].'</a><br>';
                                    break;
                                    case "Text":
                                    echo $middle_list['text'].'<br>';
                                    break;
                                    case "Title":
                                    echo '<b>'.$middle_list['title'].'</b><br>';
                                    break;
                                    case "Icon Text":
                                    echo '<a href="#"><i class="'.$middle_list['icon'].'"></i>&nbsp;&nbsp;&nbsp;'.$middle_list['text'].'</a><br>';
                                    break;
                                }
                                ?>
                                @endforeach
                            </div>
                            <div class="col-md-3">
                                <h5 id="list-item-1">{{$footer['right'][0]['title']}}</h5>
                                @foreach($footer['right'][0]['list'] as $right_list)
                                <?php
                                switch($right_list['type']){
                                    case "Link":
                                    echo '<a href="'.$right_list['url'].'" target="_blank">'.$right_list['link'].'</a><br>';
                                    break;
                                    case "Text":
                                    echo $right_list['text'].'<br>';
                                    break;
                                    case "Title":
                                    echo '<b>'.$right_list['title'].'</b><br>';
                                    break;
                                    case "Icon Text":
                                    echo '<a href="#"><i class="'.$right_list['icon'].'"></i>&nbsp;&nbsp;&nbsp;'.$right_list['text'].'</a><br>';
                                    break;
                                }
                                ?>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->

    </div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript') @endsection