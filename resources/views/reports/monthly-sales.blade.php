@extends('layouts.master')
@section('title', 'Monthly Sales Report')
@section('content')
	<div class="panel">
		<div class="panel-heading">
			<div class="row">
				<span class="panel-title"><i class="panel-title-icon fa fa-list-ul"></i>Monthly Sales Listing</span>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-primary">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
					<thead>
						<tr>
							<th>Month</th>
							<th>Amount</th>
							<th>No of Services</th>
							<th>No of Products</th>
						</tr>
					</thead>
					<tbody>
						@foreach($monthly_sales as $sale)
							<tr>
								<td>{{ $sale->month }}</td>
								<td>{{ $sale->total_sales }}</td>
								<td>{{ $sale->total_services }}</td>
								<td>{{ $sale->total_products }}</td>
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
			});
		</script>
		<!-- / Javascript -->
	@endsection
@endsection