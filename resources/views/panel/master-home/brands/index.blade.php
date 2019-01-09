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
                    <a class="btn btn-primary" href="{{route('brands.create')}}">
                        <i class="fa fa-plus"></i>&nbsp; New Brands
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-file-excel-o"></i>&nbsp; Export Brands  
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('brands.index') }}/export-data">All</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="selectedExport()">Selected</a>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#primaryModal" data-link="{{route('brands.index')}}/import-form"
                        onclick="funcModal($(this))" data-backdrop="static" data-keyboard="false">
                        <i class="fa fa-cloud-download"></i>&nbsp; Import Brands
                    </button>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Brand Table
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table _fordragclass="table-responsive-sm" class="table table-bordered table-striped table-sm display responsive datatable" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th id="datatables-th-checkbox"></th>
                                        <th class="text-nowrap">Brand :</th>
                                        <th class="text-nowrap">Key ID :</th>
                                        <th class="text-nowrap">Date Registered :</th>
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
        <form class="hidden" id="sendExport" method="GET" action="{{ route('brands.index') }}/export-selected">
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
        ajax: '{{ route("brands.index")}}/list-data',
        columns: [{
                data: '_id',
                name: '_id',
                orderable: false, 
                searchable: false,
                checkboxes: true,
                "width": "3%",
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'slug',
                name: 'slug'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '20%'
            }
        ],
        columnDefs: [
            {
                responsivePriority: 3,
                targets: 0,
            },
            {
                responsivePriority: 1,
                targets: 1,
            },
            {
                responsivePriority: 2,
                targets: 4,
                className: "text-center"
            }
        ],
        "order": [
            [3, 'desc']
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