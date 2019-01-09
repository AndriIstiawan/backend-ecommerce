@extends('master') @section('content')
<link href="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/datatables/responsive.dataTables.min.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-sm-6">
                <p>
                    <button type="button" class="btn btn-primary" onclick="refresh()">
                        <i class="fa fa-refresh"></i>
                    </button>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-cart-plus"></i> Cart Table
                    </div>
                    <div class="card-body">
                        <table _fordragclass="table-responsive-sm" class="table table-bordered table-striped table-sm display responsive datatable"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Total Product</th>
                                    <th>Total Price</th>
                                    <th>IP Address</th>
                                    <th>Payment Status</th>
                                    <th>Cart Status</th>
                                    <th>Type</th>
                                    <th>Date updated</th>
                                    <th>Action</th>
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
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="{{ asset('fiture-style/datatables/dataTables.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.responsive.min.js') }}"></script>

<script>
    //DATATABLES
    $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: '{!! url()->current() !!}/list-data',
        columns: [{
                data: 'member_detail',
                name: 'member_detail'
            },
            {
                data: 'product_count',
                name: 'product_count'
            },
            {
                data: 'total_cart',
                name: 'total_cart'
            },
            {
                data: 'IP',
                name: 'IP'
            },
            {
                data: 'payment_notes',
                name: 'payment_notes'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'type',
                name: 'type'
            },
            {
                data: 'updated_at',
                name: 'updated_at'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
        columnDefs: [{
                responsivePriority: 1,
                targets: 0,
            },
            {
                targets: 1,
                className: "text-center"
            },
            {
                responsivePriority: 2,
                targets: 8,
                className: "text-center"
            },
        ],
        "order": [
            [7, 'desc']
        ]
    });
    $('.datatable').attr('style', 'border-collapse: collapse !important');
</script>
@endsection