@extends('layouts.master')
@section('title', __('translate.pagetitle/all-sales'))
@section('content')

	<div class="panel">
		<div class="panel-heading">
			<div class="row">
				<span class="panel-title"><i class="panel-title-icon fa fa-search"></i>{{ __('translate.general/search-panel') }}</span>
			</div>
		</div>
		<div class="panel-body">
			<form action="{{route('report.all-sales-search')}}" method="post">
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
							@foreach($glob_comm as $comm)
							<label>
								<input type="checkbox" class="px" name="comm[]" value="{{$comm}}" {{in_array($comm, old('comm') ?? []) ? 'checked' : ''}}><span class="lbl">{{ $comm }}</span>
							</label>
							@endforeach
						</div> <!-- / .checkbox -->
					</div>
				</div>
				<div class="form-group">
					<label for="daterange" class="col-sm-3 control-label">{{ __('translate.field/date') }}</label>
					<div class="col-sm-9">
						<div class="input-daterange input-group" id="bs-datepicker-range">
							<input type="text" class="input-sm form-control" name="from_date" value="{{ old('from_date') ?? '' }}" autocomplete="off" placeholder="{{ __('translate.placeholder/start-date') }}" >
							<span class="input-group-addon">{{__('translate.field/daterange-to')}}</span>
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
				<span class="panel-title"><i class="panel-title-icon fa fa-list-ul"></i>{{__('translate.listing/all-sales')}}</span>
				@if($search)
					<span class="pull-right">{{ __('translate.message/record-found', ['number' => count($sales)])}}&nbsp;<a href="javascript:history.back()">{{ __('translate.button/clear') }}</a></span>
				@endif
			</div>
		</div>
		<div class="panel-body">
			<div class="table-primary">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="all-sales-datatables">
					<thead>
						<tr>
							<th>{{__('translate.field/id')}}</th>
							<th>{{__('translate.field/username')}}</th>
							<th>{{__('translate.field/sales')}}</th>
							<th>{{__('translate.field/amount')}}</th>
							<th>{{__('translate.field/commission')}}</th>
							<th>{{__('translate.field/date')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($sales as $sale)
							<tr>
								<td>{{ $sale->id }}</td>
								<td>{{ $sale->user->username }}</td>
								<td>
									@php
										$sum_of_sale = 0;
										$sum_of_each_service = [];
										$serviceArr = json_decode($sale->service);
									@endphp
									@foreach($serviceArr as $scode)
										@if(!in_array($scode, array_keys($sum_of_each_service)))
											@php
												$sum_of_each_service[$scode] = 1;
											@endphp
										@else
											@php
												$sum_of_each_service[$scode] += 1;
											@endphp
										@endif
									@endforeach
									@php
										$sum_of_sale += array_sum($sum_of_each_service);
									@endphp
										@foreach($sum_of_each_service as $scode => $sum)
											{{ $services[$scode] }}
											<span class="label label-primary">{{ $sum }}</span>
											<span style="color: #ccc">&nbsp;|&nbsp;</span>
										@endforeach

									@php
										$sum_of_each_product = [];
										$productArr = json_decode($sale->product);
									@endphp
										@foreach($productArr as $pcode)
											@if(!in_array($pcode, array_keys($sum_of_each_product)))
												@php
													$sum_of_each_product[$pcode] = 1;
												@endphp
											@else
												@php
													$sum_of_each_product[$pcode] += 1;
												@endphp
											@endif
										@endforeach
									@php
										$sum_of_sale += array_sum($sum_of_each_product);
									@endphp
										@foreach($sum_of_each_product as $pcode => $sum)
											{{ $products[$pcode] }} 
											<span class="label label-info">{{ $sum }}</span>
											<span style="color: #ccc">&nbsp;|&nbsp;</span>
										@endforeach
										<span class="label label-pa-purple">{{ $sum_of_sale }}</span>
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
				$("#uid").select2();
				$("#service").select2();
				$("#product").select2();

				$('#all-sales-datatables').on('draw.dt', function () {
					$('.sales-details').tooltip();	
				});
				
				$('.sales-details').tooltip();

				$('#bs-datepicker-range').datepicker({
					todayBtn:'linked',
					format:'yyyy-mm-dd',
				});

				$('#all-sales-datatables').dataTable({
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
				$('#all-sales-datatables_wrapper .dataTables_filter input').attr('placeholder', 'Search...');
			});
		</script>
		<!-- / Javascript -->
	@endsection
@endsection