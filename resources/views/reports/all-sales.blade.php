@extends('layouts.master')
@section('title', 'All Sales Report')
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
							<input type="text" class="input-sm form-control" name="from_date" value="{{ old('from_date') ?? '' }}" autocomplete="off" placeholder="{{ __('translate.placeholder/start-date') }}" >
							<span class="input-group-addon">to</span>
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
				<span class="panel-title"><i class="panel-title-icon fa fa-list-ul"></i>All Sales Listing</span>
				@if($search)
					<span class="pull-right">{{ __('translate.message/record-found', ['number' => count($sales)])}}   <a href="{{ route('report.all-sales') }}">{{ __('translate.button/clear') }}</a></span>
				@endif
			</div>
		</div>
		<div class="panel-body">
			<div class="table-primary">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="all-sales-datatables">
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
				$("#uid").select2();
				$("#service").select2();
				$("#product").select2();

				$('#bs-datepicker-range').datepicker({
					todayBtn:'linked',
					format:'yyyy-mm-dd',
				});

				$('#all-sales-datatables').dataTable();
				$('#all-sales-datatables_wrapper .dataTables_filter input').attr('placeholder', 'Search...');
			});
		</script>
		<!-- / Javascript -->
	@endsection
@endsection