@extends('master') @section('content')
<link href="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/datatables/responsive.dataTables.min.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <p>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" onclick="refresh()">
                            <i class="fa fa-refresh"></i>
                        </button>
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                            <span class="fa fa-plus"></span> Add Segments
                        </button>

                        <div class="dropdown-menu" >
                            <a class="dropdown-item" href="{{ action('SpecialProduct\SegmentController@create') .'?version=v1' }}">V1</a>
                            <a class="dropdown-item" href="{{ action('SpecialProduct\SegmentController@create') .'?version=v2' }}">V2</a>
                            <a class="dropdown-item" href="{{ action('SpecialProduct\SegmentController@create') .'?version=v3' }}">V3</a>
                        </div>
                    </div>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Segments Table
                        <div class="card-actions">
                            <a href="#" target="_blank">
                                <small class="text-muted">docs</small>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table _fordragclass="table-responsive-sm" class="table table-bordered table-striped table-sm display responsive datatable"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-nowrap">Images :</th>
                                        <th class="text-nowrap">Type :</th>
                                        <th class="text-nowrap">Products</th>
                                        <th class="text-nowrap">Status</th>
                                        <th class="text-nowrap">Created</th>
                                        <th class="text-nowrap">Created by</th>
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

    </div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="{{ asset('fiture-style/datatables/dataTables.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.responsive.min.js') }}"></script>

<script>
    //DATATABLES
    var reqTable = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: "{{ route('segments.index') }}",
        columns: [
            {
                data: '_id', 
                name: '_id', 
                orderable: false, 
                searchable: false,
                "width": "4%",
            },
            {
                data: 'images',
                name: 'images'
            },
            {
                data: 'type',
                name: 'type'
            },
            {
                data: 'products',
                name: 'products'
            },
            {
                data: 'is_publish',
                name: 'is_publish'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'created_by',
                name: 'created_by'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '20%'
            }
        ],
        columnDefs: [{
                responsivePriority: 1,
                targets: 0,
                className: "text-center"
            },
            {
                responsivePriority: 1,
                targets: 1,
            },
            {
                targets: [1],
                className: "text-center"
            },
        ],
        "order": [
            [0, 'desc']
        ],
        fnCreatedRow: function (row, data, index) {
            $('td', row).eq(0).html(index + 1);
        },
    });
    $('.datatable').attr('style', 'border-collapse: collapse !important');
    
</script>

@endsection