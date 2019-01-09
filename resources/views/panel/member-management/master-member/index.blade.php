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
                    <form action="" method="post" id="list-form" class="form-horizontal">
                        {!! csrf_field() !!}
                        <div class="form-hide-list"></div>
                    </form>
                    <button type="button" class="btn btn-primary" onclick="refresh()">
                        <i class="fa fa-refresh"></i>
                    </button>
                    <!-- <button class="btn btn-primary fade" href="{{route('master-member.create')}}" disabled>
                        <i class="fa fa-plus"></i>&nbsp; New Member
                    </button> -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Export Members
                            <span class="fa fa-file-excel-o"></span>
                        </button>

                        <div class="dropdown-menu" >
                            <a class="dropdown-item" href="{{action('MemberManagement\MasterMemberController@export')}}">All</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="actionButtonExport('{{action('MemberManagement\MasterMemberController@export_selected')}}', '', 'post', '')">Selected</a>
                        </div>
                    </div>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Master Member Table
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table _fordragclass="table-responsive-sm" class="table table-bordered table-striped table-sm display responsive datatable"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-nowrap">Name :</th>
                                        <th class="text-nowrap">Email :</th>
                                        <th class="text-nowrap">Phone :</th>
                                        <th class="text-nowrap">Level :</th>
                                        <th class="text-nowrap">Type :</th>
                                        <th class="text-nowrap">Status :</th>
                                        <th class="text-nowrap">Date registered :</th>
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
<script>
    //DATATABLES
    var reqTable = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: '{{route("master-member.index")}}/list-data',
        columns: [
            {
                data: 'member_id', 
                name: 'member_id', 
                orderable: false, 
                searchable: false, 
                "width": "4%", 
                checkboxes: true,
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'phone',
                name: 'phone'
            },
            {
                data: 'level.[].name',
                name: 'level'
            },
            {
                data: 'type.[|].type',
                name: 'type'
            },
            {
                data: 'status',
                name: 'status'
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
                width: '25%'
            }
        ],
        columnDefs: [
            {
                responsivePriority: 1,
                targets: 0,
            },
            {
                responsivePriority: 2,
                targets: 7,
                className: "text-center"
            }
        ],
        "order": [
            [7, 'desc']
        ],
        select: true
    });
    $('.datatable').attr('style', 'border-collapse: collapse !important');

    //For Action Button
    function actionButtonExport(url, newTab, method, variable) {

        $('.form-hide-list').empty();

        var form = $('#list-form').closest('form');

        form.attr('action', url);

        if (newTab === true) {
            form.attr("target", "_blank");
        }

        if (method === 'get') {
            $('input[name="_token"]').remove();
            form.attr('method', 'get');
        }

        var rows_selected = reqTable.column(0).checkboxes.selected();

        if (rows_selected.length === 0 ) {
            alert('Please select at least one.');
        } else {


            //Empty The Input Form First
            $('.form-hide-list').append(
                $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', variable)
                    .val(variable)
            );

            
            // Iterate over all selected checkboxes
            $.each(rows_selected, function (index, rowId) {
                console.log(rowId);
                // Create a hidden element
                $('.form-hide-list').append(
                    $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'member_id[]')
                        .val(rowId)
                );

            });


            form.trigger('submit');
            
        }
    }
</script>
@endsection