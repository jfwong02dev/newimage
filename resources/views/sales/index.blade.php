@extends('layouts.master')
@section('title', 'Sales Management')
@section('content')
	<div class="panel">
		<div class="panel-heading">
			<div class="row">
				<div class="pull-right col-xs-12 col-sm-auto"><a href="{{ route('sales.create') }}" class="btn btn-primary btn-labeled"><span class="btn-label icon fa fa-plus"></span>New Sale</a></div>
				<span class="panel-title"><i class="panel-title-icon fa fa-list-ul"></i>Sales Listing</span>
			</div>
		</div>
		@if(session()->has('added_sale'))
		<div class="alert alert-page alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('added_sale')}}
		</div> <!-- / .alert -->
		@endif
		@if(session()->has('updated_sale'))
		<div class="alert alert-page alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('updated_sale')}}
		</div> <!-- / .alert -->
		@endif
		@if(session()->has('deleted_sale'))
		<div class="alert alert-page alert-danger">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('deleted_sale')}}
		</div> <!-- / .alert -->
		@endif
		@if(session()->has('restored_sale'))
		<div class="alert alert-page alert-warning">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('restored_sale')}}
		</div> <!-- / .alert -->
		@endif
		<div class="panel-body">
			<div class="table-primary">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
					<thead>
						<tr>
							<th>ID</th>
							<th>Username</th>
							<th>Sales</th>
							<th>Amount</th>
							<th>Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($sales as $sale)
							<tr>
								<td>{{ $sale->id }}</td>
								<td>{{ $sale->user->username }}</td>
								<td>
									@for($i = 0, $serviceArr = json_decode($sale->service), $length = count($serviceArr); $i < $length; $i++)
										{{ $services[$serviceArr[$i]] }}
										<span style="color: #ccc">&nbsp;|&nbsp;</span>
										<!-- @if ($i < $length -1)
										@endif -->
									@endfor
									@for($i = 0, $productArr = json_decode($sale->product), $length = count($productArr); $i < $length; $i++)
										{{ $products[$productArr[$i]] }}
										<span style="color: #ccc">&nbsp;|&nbsp;</span>
										<!-- @if ($i < $length -1)
										@endif -->
									@endfor
								</td>
								<td>{{ $sale->amount }}</td>
								<td>{{ $sale->cdate }}</td>
								<td>
									@if($sale->deleted_at)
									<form style="display:inline-block;" name="restore-form" rel="{{ $sale }}" method="post" action="{{route('sales.restore', $sale->id)}}">
										@csrf
										<button class="btn btn-warning btn-labeled btn-sm"><span class="btn-label icon fa fa-undo"></span>Restore</button>
									</form>
									@else
									<a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-success btn-labeled btn-sm">
										<span class="btn-label icon fa fa-edit"></span>Edit
									</a>
									<form style="display:inline-block;" name="delete-form" rel="{{ $sale }}" method="post" action="{{route('sales.destroy', $sale->id)}}">
										@csrf
										@method('delete')
										<button class="btn btn-danger btn-labeled btn-sm"><span class="btn-label icon fa fa-trash-o"></span>Delete</button>
									</form>
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	@section('script')
		<!-- Javascript -->
		
		<script>
			init.push(function () {
				$('#jq-datatables-example').dataTable();
				// $('#jq-datatables-example_wrapper .table-caption').text('Some header text');
				$('#jq-datatables-example_wrapper .dataTables_filter input').attr('placeholder', 'Search...');

				$('#jq-datatables-example').on('click', '[name=delete-form]', function () {
					event.preventDefault();
					var delete_form = $(this);
					var delete_sale = JSON.parse(delete_form.attr('rel'));
					bootbox.confirm({
						message: "Are you sure to delete Sale: " + delete_sale.id + " ?",
						callback: function(result) {
							if(result) {
								delete_form.submit();
							}
						},
						className: "bootbox-sm"
					});
				});

				$('#jq-datatables-example').on('click', '[name=restore-form]', function () {
					event.preventDefault();
					var restore_form = $(this);
					var restore_sale = JSON.parse(restore_form.attr('rel'));
					bootbox.confirm({
						message: "Are you sure to restore Sale: " + restore_sale.id + " ?",
						callback: function(result) {
							if(result) {
								restore_form.submit();
							}
						},
						className: "bootbox-sm"
					});
				});
			});
		</script>
		<!-- / Javascript -->
	@endsection
@endsection