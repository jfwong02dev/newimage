@extends('layouts.master')
@section('title', __('translate.pagetitle/sales-summary'))
@section('content')

<div class="panel">
	<div class="panel-heading">
		<div class="row">
			<span class="panel-title"><i class="panel-title-icon fa fa-search"></i>{{ __('translate.general/search-panel') }}</span>
		</div>
	</div>
	<div class="panel-body">
		<form action="{{route('report.sales-details-search')}}" method="post">
			@csrf
			<div class="form-group">
				<label for="daterange" class="col-sm-2 control-label">{{ __('translate.field/date') }}</label>
				<div class="col-sm-10">
					<div class="input-daterange input-group" id="bs-datepicker-range">
						<input type="text" class="input-sm form-control" name="from_date" value="{{ old('from_date') ?? '' }}" autocomplete="off" placeholder="{{ __('translate.placeholder/start-date') }}" >
						<span class="input-group-addon">{{ __('translate.field/daterange-to') }}</span>
						<input type="text" class="input-sm form-control" name="to_date" value="{{ old('to_date') ?? '' }}" autocomplete="off" placeholder="{{ __('translate.placeholder/end-date') }}" >
					</div>
				</div>
			</div>
			<div class="form-group" style="margin-bottom: 0;">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary pull-right">{{ __('translate.button/search') }}</button>
				</div>
			</div>
		</form>
	</div>
</div>


<div class="panel">
	<div class="panel-heading">
		<div class="row">
			<span class="panel-title"><i class="panel-title-icon fa fa-list-ul"></i>{{ __('translate.listing/sales-summary') }}</span>
			@if($search)
				<span class="pull-right">{{ __('translate.message/record-found', ['number' => count($sales)])}}   <a href="{{ route('report.sales-details') }}">{{ __('translate.button/clear') }}</a></span>
			@endif
		</div>
	</div>
	<div class="panel-body">
		<div class="col-sm-6">
			<div class="table-primary" id="service-table">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="services-datatables">
					<thead>
						<tr>
							<th>{{ __('translate.field/service') }}</th>
							<th>{{ __('translate.field/noOfService') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($all_services as $service)
							<tr>
								<td>{{ $service->name }}</td>
								@if(in_array($service->code, array_keys($services_summary)))
									<td><a href="#" id="link-to-details" scode="{{$service->code}}">{{ $services_summary[$service->code] }}</a></td>
								@else
									<td>0</td>
								@endif
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th colspan="2" style="text-align:right"></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="table-primary" id="product-table">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="products-datatables">
					<thead>
						<tr>
							<th>{{ __('translate.field/product') }}</th>
							<th>{{ __('translate.field/noOfProduct') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($all_products as $product)
							<tr>
								<td>{{ $product->name }}</td>
								@if(in_array($product->code, array_keys($products_summary)))
									<td><a href="#" id="link-to-details" pcode="{{$product->code}}">{{ $products_summary[$product->code] }}</a></td>
								@else
									<td>0</td>
								@endif
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th colspan="2" style="text-align:right"></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		<form action="{{route('report.all-sales-search')}}" method="post" id="link-to-details-form">
			@csrf
			<input type="hidden" name="from_date" value="{{ old('from_date') ?? '' }}" />
			<input type="hidden" name="to_date" value="{{ old('to_date') ?? '' }}" />
			<input type="hidden" name="service[]" value="" />
			<input type="hidden" name="product[]" value="" />
		</form>
	</div>
</div>
	
	@section('script')
		<!-- Javascript -->
		
		<script>
			init.push(function () {
				$('#services-datatables').dataTable({
					"order": [[ 1, "desc" ]],
					"pageLength": 100,
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
						total = api
							.column( 1 )
							.data()
							.reduce( function (a, b) {
								return parseInt(intVal(a)) + parseInt(intVal(b));
							}, 0 );
			
						// Total over this page
						pageTotal = api
							.column( 1, { page: 'current'} )
							.data()
							.reduce( function (a, b) {
								return parseInt(intVal(a)) + parseInt(intVal(b));
							}, 0 );
						
						// Update footer
						$( api.column( 1 ).footer() ).html(
							'Total : ' + pageTotal +' ('+ total +' ALL)'
						);
					}
				});
				$('#services-datatables_wrapper .dataTables_filter input').attr('placeholder', 'Search...');

				$('#products-datatables').dataTable({
					"order": [[ 1, "desc" ]],
					"pageLength": 100,
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
						total = api
							.column( 1 )
							.data()
							.reduce( function (a, b) {
								return parseInt(intVal(a)) + parseInt(intVal(b));
							}, 0 );
			
						// Total over this page
						pageTotal = api
							.column( 1, { page: 'current'} )
							.data()
							.reduce( function (a, b) {
								return parseInt(intVal(a)) + parseInt(intVal(b));
							}, 0 );
						
						// Update footer
						$( api.column( 1 ).footer() ).html(
							'Total : ' + pageTotal +' ('+ total +' ALL)'
						);
					}
				});
				$('#products-datatables_wrapper .dataTables_filter input').attr('placeholder', 'Search...');

				$('#bs-datepicker-range').datepicker({
					todayBtn:'linked',
					format:'yyyy-mm-dd',
				});

				$('#service-table').on('click', '[id=link-to-details]', function () {
					event.preventDefault();
					const scodes = [];
					scodes.push($(this).attr('scode'))
					$('input[name=service\\[\\]]').val(scodes);
					$('#link-to-details-form').submit();
				});

				$('#product-table').on('click', '[id=link-to-details]', function () {
					event.preventDefault();
					const pcodes = [];
					pcodes.push($(this).attr('pcode'))
					$('input[name=product\\[\\]]').val(pcodes);
					$('#link-to-details-form').submit();
				});
			});
		</script>
		<!-- / Javascript -->
	@endsection
@endsection