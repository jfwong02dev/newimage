@extends('layouts.master')
@section('title', 'All Sales Report')
@section('content')
	<div class="panel">
		<div class="panel-heading">
			<div class="row">
				<span class="panel-title"><i class="panel-title-icon fa fa-list-ul"></i>All Sales Listing</span>
			</div>
		</div>
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