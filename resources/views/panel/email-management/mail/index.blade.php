@extends('master')
@section('content')
<link href="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/datatables/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/toastr/toastr.min.css') }}" rel="stylesheet">
<div class="container-fluid">
	<div class="animate fadeIn">
		<div class="row">
			<div class="col-sm-6">
				<p>
					<button type="button" class="btn btn-primary" onclick="refresh()">
						<i class="fa fa-refresh"></i>
					</button>
				<a class="btn btn-primary" href="{{route('mail.create')}}">
					 <i class="fa fa-user-plus"></i>&nbsp; Select Member
				</a>
				</p>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<i class="fa fa-align-justify"></i> Blast Table
					</div>
					<div class="card-body">
                        <div class="table-responsive">
                            <table _fordragclass="table-responsive-sm" class="table table-bordered table-striped table-sm display responsive datatable"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
										<th>Admin</th>
										<th>Subject</th>
										<th>Content</th>
										<th>Comment</th>
										<th>Date registered</th>
										<th>Success</th>
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
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="{{ asset('fiture-style/datatables/dataTables.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('fiture-style/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('fiture-style/validation/jquery.validate.min.js') }}"></script>

<script>
	//DATATABLES
		$('.datatable').DataTable({
			processing: true,
			serverSide: true,
			responsive: true,
			autoWidth: false,
	        ajax: '{{ route('mail.index')}}/list-data',
	        columns: [
	            {data: 'admin_email', name: 'adminId'},
	            {data: 'subject', name: 'subject'},
	            {data: 'content', name: 'content'},
	            {data: 'comment', name: 'comment'},
	            {data: 'created_at', name: 'created_at'},
	            {data: 'success', name: 'success'},
		        {
		            data: 'action',
		            name: 'action',
		            orderable: false,
		            searchable: false,
		            width: '20%'
		        }
	        ],
	        "columnDefs": [
	            {
	                responsivePriority: 1,
	                targets: 0,
	                className: "text-center",
	            },
	            {
	                responsivePriority: 2,
	                targets: 5,
	                className: "text-center",
	            }
	        ],
	        "order": [
	            [4, 'desc']
	        ]
		});
		$('.datatable').attr('style','border-collapse: collapse !important');
		
</script>

@endsection

