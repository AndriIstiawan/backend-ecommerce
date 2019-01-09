@extends('master')
@section('content')
<link href="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
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
					<a class="btn btn-primary" href="{{route('image-upload.create')}}">
						 <i class="fa fa-object-group"></i>&nbsp; New Upload Image
					</a>

	                <div class="btn-group">
	                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Export Images
	                        <span class="fa fa-file-excel-o"></span>
	                    </button>

	                    <div class="dropdown-menu" >
	                        <a class="dropdown-item" href="{{action('ImageManagement\ImageUploadController@export')}}">All</a>
	                        <a class="dropdown-item" href="javascript:void(0)" onclick="actionButtonExport('{{action('ImageManagement\ImageUploadController@export_selected')}}', '', 'post', '')">Selected</a>
	                    </div>
	                </div>
				</p>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<i class="fa fa-align-justify"></i> Image Table
					</div>
					<div class="card-body">
						<table class="table table-responsive-sm table-bordered table-striped table-sm datatable">
							<thead>
								<tr>
									<th></th>
									<th class="text-center">Image</th>
									<th>filename</th>
									<th>size</th>
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
		
	    <div class="modal fade" id="primaryModal">
			<div class="modal-dialog modal-primary" role="document">
				<div class="modal-content">
					<div class="modal-body"><i class="fa fa-gear fa-spin"></i></div>
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
<script src="{{ asset('fiture-style/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
<script>
	//$('#select2-1, .select2-2, #select2-4').select2({theme:"bootstrap"});
	//DATATABLES
	var reqTable =  $('.datatable').DataTable({
		processing: true,
	    serverSide: true,
		ajax: '{{route('image-upload.index')}}/list-data',
		columns: [
            {
                data: 'image_id', 
                name: 'image_id', 
                orderable: false, 
                searchable: false, 
                "width": "4%", 
                checkboxes: true,
            },
            {
                data: "filename",
                render: function ( file_id ) {
                    return file_id ?
                        '<center><img class="rounded" src="{{asset("img/storage")}}/'+file_id+'" style="width: 80px; height: 75px;"/></center>' :
                        null;
                },
                defaultContent: "No image",
                title: "Image",
                orderable: false, 
                searchable: false
            },
			{
                data: "filename",
                render: function ( file_id ) {
                    return file_id ?
                        '<a target="_blank" href="{{asset("img/storage")}}/'+file_id+'">'+file_id+'</a>' :
                        null;
                },
                defaultContent: "No image",
                title: "ImageLink"
            },
			{data: 'fileSize', name: 'fileSize'},
			{data: 'created_at', name: 'created_at'},
			{data: 'action', name: 'action', orderable: false, searchable: false}
		],
		"columnDefs": [
			{"targets": 4,"className": "text-center"}
		],
		"order":[[4, 'desc']],
		select: true
	});
	$('.datatable').attr('style','border-collapse: collapse !important');
	
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
                // Create a hidden element
                $('.form-hide-list').append(
                    $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'image_id[]')
                        .val(rowId)
                );

            });


            form.trigger('submit');
            
        }
    }
</script>
@endsection