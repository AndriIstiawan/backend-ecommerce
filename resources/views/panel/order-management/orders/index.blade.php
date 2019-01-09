@extends('master')
@section('content')
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
                        <i class="fa fa-align-justify"></i> Transaction Table
                    </div>
                    <div class="card-body">
                        <table _fordragclass="table-responsive-sm" class="table table-bordered table-striped table-sm display responsive datatable"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Order ID</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Total Price</th>
                                    <th>Date registered</th>
                                    <th></th>
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
        ajax: '{!! url()->current() !!}/data',
        columns: [{
                data: 'member_name',
                name: 'member_name'
            },
            {
                data: 'order_id',
                name: 'order_id'
            },
            {
                data: 'payment_name',
                name: 'payment_name'
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
                data: 'total_price',
                name: 'deliveries'
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
            }
        ],
        "columnDefs": [{
                responsivePriority: 1,
                targets: 0,
            },
            {
                responsivePriority: 2,
                targets: 7,
                className: "text-center"
            },
        ],
        "order":[[6, 'desc']]
    });
    $('.datatable').attr('style', 'border-collapse: collapse !important');
</script>
@endsection