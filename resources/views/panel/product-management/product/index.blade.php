@extends('master') @section('content')
<link href="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/datatables/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/datatables/dataTables.checkboxes.css') }}" rel="stylesheet" />
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <p>
                    <form action="" method="post" id="list-form" class="form-horizontal">
                        {!! csrf_field() !!}
                        <div class="form-hide-list"></div>
                    </form>
                    <button type="button" class="btn btn-primary" onclick="refresh()">
                        <i class="fa fa-refresh"></i>
                    </button>
                    <a href="{{ route('product.create') }}" class="btn btn-primary ladda-button" data-style="zoom-in">
                        <span class="ladda-label">
                            <i class="fa fa-plus">
                            </i>
                            New Products
                        </span>
                    </a>
                    <a href="{{ route('product.index') }}/import" class="btn btn-success ladda-button" data-style="zoom-in">
                        <span class="ladda-label">
                            <i class="fa fa-cloud-download">
                            </i>
                            Import Products
                        </span>
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Export Products
                            <span class="fa fa-file-excel-o"></span>
                        </button>

                        <div class="dropdown-menu" >
                            <a class="dropdown-item" href="{{action('ProductManagement\ExportProductController@index')}}">All</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="actionButtonExport('{{action('ProductManagement\ExportProductController@export_selected')}}', '', 'post', '')">Selected</a>
                        </div>
                    </div>

                    {{-- <a href="{{ route('product.index') }}/export?filter=" class="btn btn-success ladda-button" data-style="zoom-in">
                        <span class="ladda-label">
                            <i class="fa fa-file-excel-o">
                            </i>
                            Export Products
                        </span>
                    </a> --}}
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Products Table
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
                                        <th id="datatables-th-checkbox"></th>
                                        <th class="text-nowrap">Name :</th>
                                        <th class="text-nowrap">SKU :</th>
                                        <th class="text-nowrap">Categories :</th>
                                        <th class="text-nowrap">Price :</th>
                                        <th class="text-nowrap">Stok :</th>
                                        <th class="text-nowrap">Variant :</th>
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
<script src="{{ asset('fiture-style/datatables/dataTables.checkboxes.min.js') }}"></script>

<script>
    //DATATABLES
    var reqTable = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: "{{ route('product.index') }}/list-data",
        columns: [
            {
                data: 'product_id', 
                name: 'product_id', 
                orderable: false, 
                searchable: false,
                checkboxes: true,
                "width": "4%",
            },

            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'sku',
                name: 'sku'
            },
            {
                data: 'categories_name',
                name: 'categories_name'
            },
            {
                data: 'priceCol',
                name: 'priceCol'
            },
            {
                data: 'stock',
                name: 'stock'
            },
            {
                data: 'variants',
                name: 'variants'
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
        columnDefs: [{
                responsivePriority: 1,
                targets: 0,
            },
            {
                responsivePriority: 1,
                targets: 8,
            },{
                targets: [5,6,8],
                className: "text-center"
            },
            {
                targets: [4],
                className: "text-nowrap"
            },
        ],
        "order": [
            [7, 'desc']
        ],
        select: true,
        stateSave: true,
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
            toastr.warning('Please select at least one product.', 'Warning');
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
                        .attr('name', 'product_id[]')
                        .val(rowId)
                );
            });
            form.trigger('submit');
        }
    }
    
</script>

@endsection