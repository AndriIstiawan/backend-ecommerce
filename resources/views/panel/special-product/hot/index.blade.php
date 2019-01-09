@extends('master') @section('content')
<link href="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/datatables/responsive.dataTables.min.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <p>
                    <button type="button" class="btn btn-primary" onclick="refresh()">
                        <i class="fa fa-refresh"></i>
                    </button>
                    <a class="btn btn-success" href="{{ route('product.index') }}">
                        <i class="fa fa-plus"></i> Add other product
                    </a>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Hot deals Table
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
                                        <th class="text-nowrap">Product</th>
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
        ajax: "{{ route('hot-deals.index') }}",
        columns: [
            {
                data: 'product_id', 
                name: 'product_id', 
                orderable: false, 
                searchable: false,
                "width": "4%",
            },
            {
                data: 'images',
                name: 'images'
            },
            {
                data: 'product',
                name: 'product'
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