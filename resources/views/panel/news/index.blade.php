@extends('master') @section('content')
<link href="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/datatables/responsive.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('fiture-style/select2/select2.min.css') }}">
<style type="text/css">
    table.dataTable.table-sm>thead>tr>th {padding-right: 0 !important;}
</style>
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-md-12">
                <p>
                    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh" onclick="refresh()">
                        <i class="fa fa-refresh"></i>
                    </button>
                    <a href="{{ route('news.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp; Create News
                    </a>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> News Table
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table _fordragclass="table-responsive-sm" class="table table-bordered table-striped table-sm display responsive datatable"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No :</th>
                                        <th class="text-nowrap">Image :</th>
                                        <th class="text-nowrap">Title :</th>
                                        <th class="text-nowrap">Keyword :</th>
                                        <th class="text-nowrap">Publish :</th>
                                        <th class="text-nowrap">Created :</th>
                                        <th class="text-nowrap">Date :</th>
                                        <th class="text-nowrap"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('panel.email-management.mail.new-blast.modal')
    </div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="{{ asset('fiture-style/datatables/dataTables.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('fiture-style/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/vendor//tinymce/tinymce.min.js') }}"></script>
<script>
    //DATATABLES
    var reqTable = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: {
            url: '{{route("news.index")}}'
        },
        columns: [
            {
                data: '_id',
                name: '_id',
                orderable: false,
                searchable: false,
                width: '5%'
            },
            {
                data: 'image',
                name: 'image'
            },
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'keyword',
                name: 'keyword'
            },
            {
                data: 'is_publish',
                name: 'is_publish'
            },
            {
                data: 'created_by',
                name: 'created_by'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'action',
                name: 'action'
            },
        ],
        columnDefs: [
            {
                responsivePriority: 2,
                targets: 4,
                className: "text-center",
            },
            {
                responsivePriority: 1,
                targets: 1,
                className: "text-center",
            },
            {
                responsivePriority: 3,
                targets: 5,
                className: "text-center",
            },
            {
                targets: 7,
                className: "text-center",
            }
        ],
        "order": [
            [1, 'asc'],
        ],
        select: true,
        fnCreatedRow: function (row, data, index) {
            $('td', row).eq(0).html(index + 1);
        },
    });
    $('.datatable').attr('style', 'border-collapse: collapse !important');

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