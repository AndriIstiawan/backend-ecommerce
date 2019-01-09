@extends('master')
@section('content')
<link href="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/toastr/toastr.min.css') }}" rel="stylesheet">
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
						<i class="fa fa-cart-plus"></i> Pending Table
					</div>
					<div class="card-body">
                        <ul class="nav nav-tabs" id="myTab1" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" id="general-tab" data-toggle="tab" href="#unresolve" 
									role="tab" aria-controls="home" aria-selected="false" onclick="InquiryRefresh('unresolve')">On Review</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="rp-tab" data-toggle="tab" href="#resolve" 
                                    role="tab" aria-controls="home" aria-selected="false" onclick="InquiryRefresh('resolve')">Resolved</a>
							</li>
						</ul>
						<div class="tab-content" id="myTab1Content">
                            <div class="tab-pane fade active show" id="unresolve" role="tabpanel" aria-labelledby="unresolve-tab">
								<div class="row">
									<div class="col-md-12">
                                        <table class="table table-responsive-sm table-bordered table-striped table-sm datatable-unresolve">
                                            <thead>
                                                <tr>
                                                    <th>IP Address</th>
                                                    <th>Member</th>
                                                    <th>Info Status Inquiries</th>
                                                    <th>Total Product Cart</th>
                                                    <th>Total Price Cart</th>
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
                            <div class="tab-pane fade" id="resolve" role="tabpanel" aria-labelledby="resolve-tab">
								<div class="row">
									<div class="col-md-12">
                                        <table class="table table-responsive-sm table-bordered table-striped table-sm datatable-resolve">
                                            <thead>
                                                <tr>
                                                    <th>IP Address</th>
                                                    <th>Member</th>
                                                    <th>Info Status Inquiries</th>
                                                    <th>Total Product Cart</th>
                                                    <th>Total Price Cart</th>
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
			</div>
		</div>
	</div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="{{ asset('fiture-style/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('fiture-style/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('fiture-style/validation/jquery.validate.min.js') }}"></script>

<script>
	//DATATABLES
    function InquiryRefresh(key){
        $('.datatable-'+key).DataTable().destroy();
        $('.datatable-'+key).DataTable({
			processing: true,
	        serverSide: true,
	        ajax: '{{route("pending-po.index")}}/list-'+key,
	        columns: [
	            {data: 'IP', name: 'IP'},
	            {data: 'member_detail', name: 'member_detail'},
                {data: 'inquiries_status', name: 'inquiries_status', orderable: false, searchable: false},
                {data: 'total_product_cart', name: 'total_product_cart'},
                {data: 'total_price_cart', name: 'total_price_cart'},
	            {data: 'updated_at', name: 'updated_at'},
	            {data: 'action', name: 'action', orderable: false, searchable: false}
	        ],
			"columnDefs": [
				{"targets": 6,"className": "text-center"}
			],
			"order":[[5, 'desc']]
        });
        setTimeout(() => {
            $('.datatable-'+key).attr('style','border-collapse: collapse !important; width=100%;');
        }, 200);
    }
	InquiryRefresh('unresolve');	
</script>
@endsection