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
                    <a class="btn btn-primary" href="{{ route('courier.create') }}">
                        <i class="fa fa-plus"></i>&nbsp; New Courier
                    </a>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Courier Table
                    </div>
                    <div class="card-body">
                        <table _fordragclass="table-responsive-sm" class="table table-bordered table-striped table-sm display responsive datatable"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Courier :</th>
                                    <th>Type :</th>
                                    <th>Code :</th>
                                    <th>Location :</th>
                                    <th class="text-nowrap">Date registered :</th>
                                    <th class="text-nowrap">Status :</th>
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
        ajax: '{{ route("courier.index") }}/list-data',
        columns: [{
                data: 'courier',
                name: 'courier'
            },
            {
                data: 'type',
                name: 'type'
            },
            {
                data: 'slug',
                name: 'slug'
            },
            {
                data: 'location_set',
                name: 'location_set'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'status_set',
                name: 'status_set'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '18%'
            }
        ],
        columnDefs: [
            {
                responsivePriority: 1,
                targets: 0,
            },
            {
                targets: 5,
                className: "text-center"
            },
            {
                responsivePriority: 2,
                targets: 6,
                className: "text-center"
            }
        ],
        "order": [
            [4, 'desc']
        ]
    });
    $('.datatable').attr('style', 'border-collapse: collapse !important');

    function courierSetStatus(elm){
        swal({
            title: "Are you sure want to change status courier?",
            text: "Please make sure courier you want set..",
            buttons: true,
        }).then((confirm) => {
            if(confirm){
                var action = elm.is(":checked");
                var id = elm.attr('data-id');
                $.ajax({
                    url: '{{ route("courier.index")}}/set-status',
                    type: "POST",
                    data:{_token: '{{ csrf_token() }}', action:action, id:id},
                    success: function (response) {
                        if(response == 'success'){
                            swal({
                                title: "Courier set successfuly.",
                            });
                            toastr.success('Successful set courier status..', 'An courier has been set.');
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