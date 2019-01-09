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
                    <a class="btn btn-primary" href="{{route('payment-method.create')}}">
                        <i class="fa fa-plus"></i>&nbsp; New Payment Method
                    </a>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Payment Method Table
                    </div>
                    <div class="card-body">
                        <table _fordragclass="table-responsive-sm" class="table table-bordered table-striped table-sm display responsive datatable" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Image :</th>
                                    <th class="text-nowrap">Name :</th>
                                    <th class="text-nowrap">Account :</th>
                                    <th class="text-nowrap">Account Number :</th>
                                    <th class="text-nowrap">Status :</th>
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

        <div class="modal fade" id="primaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-primary" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <i class="fa fa-gear fa-spin"></i>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

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
        ajax: '{{ route("payment-method.index")}}/list-data',
        columns: [{
                data: "image",
                render: function (file_id) {
                    return file_id ?
                        '<center><img class="rounded" src="{{asset("img/payments")}}/' + file_id +
                        '" style="width: 70px; height: 30px;"/></center>' :
                        null;
                },
                orderable: false,
                searchable: false,
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'account',
                name: 'account'
            },
            {
                data: 'account_number',
                name: 'account_number'
            },
            {
                data: 'status_set',
                name: 'status_set',
                orderable: false,
                searchable: false,
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
                responsivePriority: 1,
                targets: 0,
            },
            {
                targets: 4,
                className: "text-center"
            },
            {
                responsivePriority: 2,
                targets: 6,
                className: "text-center"
            }
        ],
        "order": [
            [5, 'desc']
        ]
    });
    $('.datatable').attr('style', 'border-collapse: collapse !important');

    function paymentSetStatus(elm){
        swal({
            title: "Are you sure want to change status payment?",
            text: "Please make sure payment you want set..",
            buttons: true,
        }).then((confirm) => {
            if(confirm){
                var action = elm.is(":checked");
                var id = elm.attr('data-id');
                $.ajax({
                    url: '{{ route("payment-method.index")}}/set-status',
                    type: "POST",
                    data:{_token: '{{ csrf_token() }}', action:action, id:id},
                    success: function (response) {
                        if(response == 'success'){
                            swal({
                                title: "Payment set successfuly.",
                            });
                            toastr.success('Successful set payment status..', 'An payment has been set.');
                        }else{
                            swal({
                                title: "Process invalid",
                                text: "Please contact technical support.",
                                dangerMode: true,
                            });
                            refresh();
                        }
                    },
                    error: function (e) {
                        swal({
                            title: "Process invalid",
                            text: "Please contact technical support.",
                            dangerMode: true,
                        });
                        refresh();
                    }
                });
            }else{
                //refresh datatables
                refresh();
            }
        });
    }
</script>
@endsection