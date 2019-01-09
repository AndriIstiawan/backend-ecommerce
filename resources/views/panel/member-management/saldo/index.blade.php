@extends('master') @section('content')
<link href="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/datatables/responsive.dataTables.min.css') }}" rel="stylesheet">
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
<style type="text/css">
    table.dataTable.table-sm>thead>tr>th {padding-right: 0 !important;}
</style>
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
                        <i class="fa fa-align-justify"></i> Saldo Member Table
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table _fordragclass="table-responsive-sm" class="table table-bordered table-striped table-sm display responsive datatable"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="text-nowrap">Member name :</th>
                                        <th class="text-nowrap">Description :</th>
                                        <th class="text-nowrap">Nominal :</th>
                                        <th class="text-nowrap">Status :</th>
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
    </div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="{{ asset('fiture-style/datatables/dataTables.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
<script type="text/javascript" src="{{ asset('js/vendor/axios.min.js') }}"></script>
<script>
    //DATATABLES
    var reqTable = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: '{{route("saldo-member.index")}}',
        columns: [
            {
                data: '_id', 
                name: '_id', 
                orderable: false, 
                searchable: false, 
                "width": "4%", 
                checkboxes: false,
            },
            {
                data: 'member',
                name: 'member'
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: 'nominal',
                name: 'nominal'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '25%'
            }
        ],
        columnDefs: [
            {
                responsivePriority: 1,
                targets: 0,
            },
            {
                responsivePriority: 3,
                targets: 6,
                className: "text-center"
            }
        ],
        "order": [
            [6, 'desc']
        ],
        select: true,
        "fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html('<center>'+(index + 1)+'</center>');
        },
    });
    $('.datatable').attr('style', 'border-collapse: collapse !important');
    $(document).off('click', '.approved').on('click', '.approved', function(){
        let _this = $(this)
            _this.prop('disabled', true)
            _this.html('<i class="fa fa-refresh fa-spin"></i>&nbsp;Processing')
        let id = _this.data('id')
        axios.put('/saldo-member/'+id, {
            status: 'approved'
        })
        .then((res) => {
            refresh()
        })
        .catch((e) => {
            _this.prop('disabled', false)
            _this.html('<i class="fa fa-check"></i>&nbsp;Approve')
        })
    })
</script>
@endsection