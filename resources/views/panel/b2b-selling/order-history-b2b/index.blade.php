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
						<i class="fa fa-align-justify"></i> Order Table
					</div>
					<div class="card-body">
                        <table _fordragclass="table-responsive-sm" class="table table-bordered table-striped table-sm display responsive datatable"
                            cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Member Name</th>
									<th>Member Phone</th>
									<th>Member Email</th>
									<th>Order Type</th>
									<th>Total Product</th>
									<th>Total Price</th>
									<th>Date registered</th>
                                    <th>Status</th>
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
	        ajax: '{!! url()->current() !!}/data',
	        columns: [
	            {data: 'member[0].name', name: 'memberName'},
	            {data: 'member[0].phone', name: 'memberPhone'},
                {data: 'member[0].email', name: 'memberEmail'},
                {data: 'order_type', name: 'order_type'},
                {data: 'total_product', name: 'total_product'},
                {data: 'total_price', name: 'total_price'},
                {data: 'created_at', name: 'created_at'},
                {data: 'status', name: 'status'},
	            {data: 'action', name: 'action', orderable: false, searchable: false}
	        ],
			columnDefs: [
                {responsivePriority: 1,targets: 0},
                {targets: 4,className: "text-right"},
                {targets: 5,className: "text-right"},
				{responsivePriority: 2,targets: 8,className: "text-center"}
			],
			"order":[[6, 'desc']]
		});
		$('.datatable').attr('style','border-collapse: collapse !important');
		
</script>
@endsection