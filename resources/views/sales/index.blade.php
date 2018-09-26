@extends('layouts.master')
@section('title', __('translate.pagetitle/sales'))
@section('content')
	<div class="panel" id="search-form" style="display:{{ $search ? 'block' : 'none' }}">
		<div class="panel-heading">
			<div class="row">
				<span class="panel-title"><i class="panel-title-icon fa fa-search"></i>{{ __('translate.general/search-panel') }}</span>
			</div>
		</div>
		<div class="panel-body">
			<form action="{{route('sales.search')}}" method="post" name="search-form">
				@csrf
				<div class="form-group">
					<label class="col-sm-3 control-label">{{ __('translate.field/username') }}</label>
					<div class="col-sm-9">
						<div class="select2-primary">
							<select multiple="multiple" class="form-control" id="uid" name="uid[]">
								@foreach($users as $user)
								<option value="{{$user->uid}}" 
									{{ ( 
										in_array($user->uid, (is_array(old('uid')) ? old('uid') : []))
										) ? 'selected' : '' 
									}}>{{ $user->username }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">{{ __('translate.field/service') }}</label>
					<div class="col-sm-9">
						<div class="select2-primary">
							<select multiple="multiple" class="form-control" id="service" name="service[]">
								@foreach($services as $scode => $sname)
									<option value="{{$scode}}" 
									{{ ( 
										in_array($scode, (is_array(old('service')) ? old('service') : []))
										) ? 'selected' : '' 
									}}>{{ $sname }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">{{ __('translate.field/product') }}</label>
					<div class="col-sm-9">
						<div class="select2-primary">
							<select multiple="multiple" class="form-control" id="product" name="product[]">
								@foreach($products as $pcode => $pname)
									<option value="{{$pcode}}" 
									{{ ( 
										in_array($pcode, (is_array(old('product')) ? old('product') : []))
										) ? 'selected' : '' 
									}}>{{ $pname }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">{{ __('translate.field/commission') }}</label>
					<div class="col-sm-9">
						<div class="checkbox" style="margin: 0;">
							<label>
								<input type="checkbox" name="comm[]" value="10" {{in_array(10, old('comm') ?? []) ? 'checked' : ''}}> 10
							</label>
							<label>
								<input type="checkbox" name="comm[]" value="20" {{in_array(20, old('comm') ?? []) ? 'checked' : ''}}> 20
							</label>
						</div> <!-- / .checkbox -->
					</div>
				</div>
				<div class="form-group">
					<label for="daterange" class="col-sm-3 control-label">{{ __('translate.field/date') }}</label>
					<div class="col-sm-9">
						<div class="input-daterange input-group" id="bs-datepicker-range">
							<input type="text" class="input-sm form-control" name="from_date" value="{{ old('from_date') ?? '' }}" autocomplete="off" placeholder="{{ __('translate.placeholder/start-date') }}">
							<span class="input-group-addon">to</span>
							<input type="text" class="input-sm form-control" name="to_date" value="{{ old('to_date') ?? '' }}" autocomplete="off" placeholder="{{ __('translate.placeholder/end-date') }}">
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
				<div class="pull-right col-xs-12 col-sm-auto btn btn-primary btn-labeled" id="search-btn"><span class="btn-label icon fa fa-search"></span>{{__('translate.button/show')}}</div>
				<div class="pull-right col-xs-12 col-sm-auto"><a href="{{ route('sales.create') }}" class="btn btn-primary btn-labeled"><span class="btn-label icon fa fa-plus"></span>{{__('translate.pagetitle/new-sales')}}</a></div>
				@if($search)
					<span class="pull-right">{{ __('translate.message/record-found', ['number' => count($sales)])}}   <a href="{{ route('sales.index') }}">{{ __('translate.button/clear') }}</a></span>
				@endif
				<span class="panel-title"><i class="panel-title-icon fa fa-list-ul"></i>{{__('translate.listing/sales')}}</span>
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
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="sales-datatables">
					<thead>
						<tr>
							<th>{{__('translate.field/id')}}</th>
							<th>{{__('translate.field/username')}}</th>
							<th>{{__('translate.field/sales')}}</th>
							<th>{{__('translate.field/amount')}}</th>
							<th>{{__('translate.field/commission')}}</th>
							<th>{{__('translate.field/date')}}</th>
							<th>{{__('translate.field/action')}}</th>
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
								<td>{{ $sale->amount }}
									@if($sale->pamount > 0)
									<i class="fa fa-info-circle sales-details" data-toggle="tooltip" data-html="true" data-placement="right" title="{{__('translate.tooltip/sales-details', [
										'br' => '<br/>',
										'service_amount' => $sale->amount - $sale->pamount,
										'product_amount' => $sale->pamount
									])}}"></i>
									@endif
								</td>
								<td>{{ $sale->comm }}</td>
								<td>{{ $sale->cdate }}</td>
								<td>
									@if($sale->deleted_at)
									<form style="display:inline-block;" name="restore-form" rel="{{ $sale }}" method="post" action="{{route('sales.restore', $sale->id)}}">
										@csrf
										<button class="btn btn-warning btn-labeled btn-sm"><span class="btn-label icon fa fa-undo"></span>{{__('translate.button/restore')}}</button>
									</form>
									@else
									<a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-success btn-labeled btn-sm">
										<span class="btn-label icon fa fa-edit"></span>{{__('translate.button/edit')}}
									</a>
									<form style="display:inline-block;" name="delete-form" rel="{{ $sale }}" method="post" action="{{route('sales.destroy', $sale->id)}}">
										@csrf
										@method('delete')
										<button class="btn btn-danger btn-labeled btn-sm"><span class="btn-label icon fa fa-trash-o"></span>{{__('translate.button/delete')}}</button>
									</form>
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th style="text-align:right"></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	@section('script')
		<!-- Javascript -->
		
		<script>
			init.push(function () {
				$('#sales-datatables').dataTable({
					"order": [[ 5, "desc" ]],
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
							.column( 3 )
							.data()
							.reduce( function (a, b) {
								return parseFloat(intVal(a)) + parseFloat(intVal(b));
							}, 0 );
			
						// Total over this page
						amountPageTotal = api
							.column( 3, { page: 'current'} )
							.data()
							.reduce( function (a, b) {
								return parseFloat(intVal(a)) + parseFloat(intVal(b));
							}, 0 );
						
						// Update footer
						$( api.column( 3 ).footer() ).html(
							'Total : RM ' + amountPageTotal +' (RM '+ amountTotal +' ALL)'
						);
					}
				});
				$('#sales-datatables_wrapper .dataTables_filter input').attr('placeholder', 'Search...');

				$('#sales-datatables').on('click', '[name=delete-form]', function () {
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

				$('#sales-datatables').on('click', '[name=restore-form]', function () {
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

				$('.sales-details').tooltip();
				$("#uid").select2();
				$("#service").select2();
				$("#product").select2();
				$('#bs-datepicker-range').datepicker({
					todayBtn:'linked',
					format:'yyyy-mm-dd',
				});

				$("#search-btn").click(function(){
					if($('#search-form').css('display') === 'none') {
						$('#search-btn').html("<span class='btn-label icon fa fa-search'></span>{{__('translate.button/hide')}}")
					}
					else {
						$('#search-btn').html("<span class='btn-label icon fa fa-search'></span>{{__('translate.button/show')}}")
					}
					$('#search-form').toggle();
				});
			});
		</script>
		<!-- / Javascript -->
	@endsection
@endsection