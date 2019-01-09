@extends('master') @section('content')
<link href="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/datatables/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/datatables/dataTables.checkboxes.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-sm-6">
                <p>
                    <form class="form-horizontal"></form>
                    <button type="button" class="btn btn-primary" onclick="refresh()">
                        <i class="fa fa-refresh"></i>
                    </button>
                    <a class="btn btn-primary" href="{{route('slider.create')}}">
                        <i class="fa fa-plus"></i>&nbsp; New Slider
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-file-excel-o"></i>&nbsp; Export Slider  
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('slider.index') }}/export-data">All</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="selectedExport()">Selected</a>
                        </div>
                    </div>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Slider Table
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table _fordragclass="table-responsive-sm" class="table table-bordered table-striped table-sm display responsive datatable"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th id="datatables-th-checkbox"></th>
                                        <th class="text-nowrap">Image :</th>
                                        <th class="text-nowrap">Title :</th>
                                        <th class="text-nowrap">Redirect :</th>
                                        <th class="text-nowrap">Date created :</th>
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
        <form class="hidden" id="sendExport" method="GET" action="{{ route('slider.index') }}/export-selected">
        </form>
    </div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="{{ asset('fiture-style/datatables/dataTables.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.checkboxes.min.js') }}"></script>

<script>
    //DATATABLES
    var dataTable = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: '{{route("slider.index")}}/list-data',
        columns: [{
                data: '_id',
                name: '_id',
                orderable: false, 
                searchable: false,
                checkboxes: true,
                "width": "3%",
            },
            {
                data: "image",
                render: function (file_id) {
                    return file_id ?
                        '<center><img class="rounded" src="{{asset("img/sliders")}}/' + file_id +
                        '" style="width: 140px; height: 70px;"/></center>' :
                        null;
                },
                orderable: false,
                searchable: false,
            },
            {
                data: 'title',
                name: 'title',
            },
            {
                data: "url_link",
                render: function (file_id) {
                    return file_id ?
                        '<a href="' + file_id + '" target="_blank">' + file_id + '</a>' :
                        null;
                },
            },
            {
                data: 'created_at',
                name: 'created_at',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '20%',
            }
        ],
        columnDefs: [
            {
                responsivePriority: 2,
                targets: 0,
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
            }
        ],
        order: [
            [4, 'desc']
        ]
    });
    $('.datatable').attr('style', 'border-collapse: collapse !important');

    function selectedExport(){
        var rows_selected = dataTable.column(0).checkboxes.selected();
        
        if(rows_selected.length){
            $('#sendExport').html('');
            $.each(rows_selected, function(index, rowId){
                // Create a hidden element
                $('#sendExport').append(
                    $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'id[]')
                        .val(rowId)
                );
            });
            $('#sendExport').trigger('submit');
        }else{
            swal({
                title: "No column selected",
                icon: "warning",
                dangerMode: true,
            });
        }
    }
</script>

@endsection