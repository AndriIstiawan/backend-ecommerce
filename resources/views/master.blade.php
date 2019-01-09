<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Fiture - E-Commerce B2B">
    <meta name="author" content="fiture-dev">
    <meta name="keyword" content="fiture,e-commerce,e-commerce b2b">
    <link rel="shortcut icon" href="{{ asset('img/fiture-favicon.png') }}">
    <title>{{env('SITE_TITLE','FE-B2B-Backend-WEB')}}</title>

    <!-- Icons -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simple-line-icons.css') }}" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="{{ asset('fiture-style/css/'.env('STYLE_CSS','style').'.css') }}" rel="stylesheet">
    <!-- Styles required by this views -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="{{ asset('fiture-style/toastr/toastr.min.css') }}" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-117999644-1"></script> -->
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-117999644-1');
    </script>
    <style type="text/css">
        #datatables-th-checkbox {
            padding-left: 20px;
        }
    </style>
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    @include('panel.navbar')

    <div class="app-body">
        @include('panel.sidebar')
        <!-- Main content -->
        <?php
            $uriLists = Route::current()->getName();
            $uriLists = explode(".", $uriLists);
        ?>
            <main class="main">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{url('/')}}">Home</a></li>
                    <?php
                        if(count($uriLists) > 1){
                            for($countUri=0; $countUri < count($uriLists); $countUri++){
                                $valUrl = '<a href="'.url($uriLists[$countUri]).'">'.$uriLists[$countUri].'</a>';
                                $statusUrl = "";
                                if($countUri == count($uriLists)-1){
                                    $valUrl = $uriLists[$countUri];
                                    $statusUrl = "active";
                                }
                                ?>
                                <li class="breadcrumb-item {{$statusUrl}}"><?php echo $valUrl; ?></li>
                                <?php
                            }
                        }
                    ?>
                    <li class="breadcrumb-menu d-md-down-none">
                        <div class="btn-group" role="group" aria-label="Button group">
                            <a class="btn" href="#">
                                <i class="icon-speech"></i>
                            </a>
                            <a class="btn" href="{{url('/')}}">
                                <i class="icon-graph"></i> &nbsp;Dashboard</a>
                            @if(Auth::user()->hasAcc('master-setting'))
                            <a class="btn" href="{{route('master-setting.index')}}">
                                <i class="icon-settings"></i> &nbsp;Settings</a>
                            @endif
                        </div>
                    </li>
                </ol>
                <!-- Breadcrumb -->
                @include('panel.breadcrumb') @yield('content')
                <!-- /.container-fluid -->
                @include('panel.modal')
            </main>
    </div>

    @include('panel.footer') @include('panel.scripts') @yield('myscript')

</body>

</html>