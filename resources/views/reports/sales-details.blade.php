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
		<form action="{{route('report.search')}}" method="post">
			@csrf
			<div class="form-group">
				<label for="daterange" class="col-sm-2 control-label">{{ __('translate.field/date') }}</label>
				<div class="col-sm-10">
					<div class="input-daterange input-group" id="bs-datepicker-range">
						<input type="text" class="input-sm form-control" name="from_date" value="{{ old('from_date') ?? '' }}" autocomplete="off" placeholder="{{ __('translate.placeholder/start-date') }}" required>
						<span class="input-group-addon">to</span>
						<input type="text" class="input-sm form-control" name="to_date" value="{{ old('to_date') ?? '' }}" autocomplete="off" placeholder="{{ __('translate.placeholder/end-date') }}" required>
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
			<div class="table-primary">
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
								<td>{{ in_array($service->code, array_keys($services_summary)) ? $services_summary[$service->code] : 0 }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="table-primary">
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
								<td>{{ in_array($product->code, array_keys($products_summary)) ? $products_summary[$product->code] : 0 }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
	
	@section('script')
		<!-- Javascript -->
		
		<script>
			init.push(function () {
				$('#services-datatables').dataTable();
				$('#services-datatables_wrapper .dataTables_filter input').attr('placeholder', 'Search...');
				$('#products-datatables').dataTable();
				$('#products-datatables_wrapper .dataTables_filter input').attr('placeholder', 'Search...');

				$('#bs-datepicker-range').datepicker({
					todayBtn:'linked',
					format:'yyyy-mm-dd',
				});
			});
		</script>
		<!-- / Javascript -->
	@endsection
@endsection