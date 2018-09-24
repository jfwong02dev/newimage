@extends('layouts.master')
@section('title', __('translate.pagetitle/yearly-sales'))
@section('content')
	<div class="panel">
		<div class="panel-heading">
			<div class="row">
				<span class="panel-title"><i class="panel-title-icon fa fa-list-ul"></i>{{ __('translate.listing/yearly-sales') }}</span>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-primary" id="yearly-sales-table">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="yearly-sales-datatables">
					<thead>
						<tr>
							<th>{{ __('translate.field/year') }}</th>
							<th>{{ __('translate.field/amount') }}</th>
							<th>{{ __('translate.field/noOfService') }}</th>
							<th>{{ __('translate.field/noOfProduct') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($yearly_sales as $sale)
							<tr>
								<td><a href="#" id="link-to-details" month="{{$sale->year}}">{{ $sale->year }}</a></td>
								<td>{{ $sale->total_sales }}</td>
								<td>{{ $sale->total_services }}</td>
								<td>{{ $sale->total_products }}</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th></th>
							<th style="text-align:right"></th>
							<th style="text-align:right"></th>
							<th style="text-align:right"></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		<form action="{{route('report.all-sales-search')}}" method="post" id="link-to-details-form">
			@csrf
			<input type="hidden" name="from_date" value="{{ old('from_date') ?? '' }}" />
			<input type="hidden" name="to_date" value="{{ old('to_date') ?? '' }}" />
		</form>
	</div>
	@section('script')
		<!-- Javascript -->
		
		<script>
			init.push(function () {
				$('#yearly-sales-datatables').dataTable({
					"order": [[ 0, "desc" ]],
					"footerCallback": function ( row, data, start, end, display ) {
						var api = this.api(), data;
 
						// Remove the formatting to get integer data for summation
						var intVal = function ( i ) {
							return typeof i === 'string' 
									? i.replace(/<[^>]*>/g, '')
									: typeof i === 'number'
										? i 
										: 0;
						};
			
						// Total over all pages
						amountTotal = api
							.column( 1 )
							.data()
							.reduce( function (a, b) {
								return parseFloat(intVal(a)) + parseFloat(intVal(b));
							}, 0 );
			
						// Total over this page
						amountPageTotal = api
							.column( 1, { page: 'current'} )
							.data()
							.reduce( function (a, b) {
								return parseFloat(intVal(a)) + parseFloat(intVal(b));
							}, 0 );
						
						// Update footer
						$( api.column( 1 ).footer() ).html(
							'Total : RM ' + amountPageTotal +' (RM '+ amountTotal +' ALL)'
						);

						// Total over all pages
						serviceTotal = api
							.column( 2 )
							.data()
							.reduce( function (a, b) {
								return parseInt(intVal(a)) + parseInt(intVal(b));
							}, 0 );
			
						// Total over this page
						servicePageTotal = api
							.column( 2, { page: 'current'} )
							.data()
							.reduce( function (a, b) {
								return parseInt(intVal(a)) + parseInt(intVal(b));
							}, 0 );
						
						// Update footer
						$( api.column( 2 ).footer() ).html(
							'Total : ' + servicePageTotal +' ('+ serviceTotal +' ALL)'
						);

						// Total over all pages
						productTotal = api
							.column( 3 )
							.data()
							.reduce( function (a, b) {
								return parseInt(intVal(a)) + parseInt(intVal(b));
							}, 0 );
			
						// Total over this page
						productPageTotal = api
							.column( 3, { page: 'current'} )
							.data()
							.reduce( function (a, b) {
								return parseInt(intVal(a)) + parseInt(intVal(b));
							}, 0 );
						
						// Update footer
						$( api.column( 3 ).footer() ).html(
							'Total : ' + productPageTotal +' ('+ productTotal +' ALL)'
						);
					}
				});
				$('#yearly-sales-datatables_wrapper .dataTables_filter input').attr('placeholder', 'Search...');

				$('#yearly-sales-table').on('click', '[id=link-to-details]', function () {
					event.preventDefault();
					var month = $(this).attr('month');
					var date = new Date(month);
					var firstDay = formatDate(new Date(date.getFullYear(), date.getMonth(), 1));
					var lastDay = formatDate(new Date(date.getFullYear(), date.getMonth() + 12, 0));
					
					$('input[name=from_date').val(firstDay);
					$('input[name=to_date').val(lastDay);
					$('#link-to-details-form').submit();
				});
			});

			function formatDate(date) {
				var d = new Date(date),
					month = '' + (d.getMonth() + 1),
					day = '' + d.getDate(),
					year = d.getFullYear();

				if (month.length < 2) month = '0' + month;
				if (day.length < 2) day = '0' + day;

				return [year, month, day].join('-');
			}
		</script>
		<!-- / Javascript -->
	@endsection
@endsection