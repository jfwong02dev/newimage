@extends('layouts.master')
@section('title', __('translate.pagetitle/edit-sale'))
@section('content')
	@if($errors->all())
		@foreach($errors->all() as $error)
			<p>{{$error}}</p>
		@endforeach
	@endif
	<div class="row">
		<div class="col-sm-12">
			<div class="panel">
				<div class="panel-heading">
					<div class="row">
						<div class="pull-right col-xs-12 col-sm-auto"><a href="{{ route('sales.index') }}" class="btn btn-primary btn-labeled"><span class="btn-label icon fa fa-list-ul"></span>{{__('translate.listing/sales')}}</a></div>
						<span class="panel-title"><i class="panel-title-icon fa fa-plus"></i>{{__('translate.pagetitle/edit-sales')}} (ID: {{ $sale->id }})</span>
					</div>
				</div>
				<div class="panel-body">
					<form action="{{route('sales.update', $sale->id)}}" method="post" class="form-horizontal">
					@csrf
					@method('put')
						<div class="form-group{{ $errors->has('uid') ? ' has-error' : '' }}">
							<label for="uid" class="col-sm-3 control-label">{{__('translate.field/username')}}</label>
							<div class="col-sm-9">
								<select class="form-control" name="uid" id="uid">
									<option></option>
									@foreach($users as $user)
										<option value="{{$user->uid}}" {{ (old('uid') ?? $sale->uid ?? '') == $user->uid ? 'selected' : '' }}>{{$user->username}}</option>
									@endforeach
								</select>
								@if($errors->has('uid'))
									<p class="help-block">{{$errors->first('uid')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('service') ? ' has-error' : '' }}">
							<label class="col-sm-3 control-label">{{__('translate.field/service')}}</label>
							<div class="col-sm-9">
								<div class="select2-primary">
									<select multiple="multiple" class="form-control" id="service" name="service[]">
										@foreach($services as $service)
										<option value="{{$service->code}}" 
											{{ ( 
												in_array($service->code, (is_array(old('service')) ? old('service') : (json_decode($sale->service) ?? [])))
												) ? 'selected' : '' 
											}}>{{ $service->name }}</option>
										@endforeach
									</select>
									@if($errors->has('service'))
										<p class="help-block">{{$errors->first('service')}}</p>
									@endif
								</div>
							</div>
						</div>

						<div class="form-group{{ $errors->has('product') ? ' has-error' : '' }}">
							<label class="col-sm-3 control-label">{{__('translate.field/product')}}</label>
							<div class="col-sm-9">
								<div class="select2-info">
									<select multiple="multiple" class="form-control" id="product" name="product[]">
										@foreach($products as $product)
										<option value="{{$product->code}}" 
											{{ ( 
												in_array($product->code, (is_array(old('product')) ? old('product') : (json_decode($sale->product) ?? [])))
												) ? 'selected' : '' 
											}}>{{ $product->name }}</option>
										@endforeach
									</select>
									@if($errors->has('product'))
										<p class="help-block">{{$errors->first('product')}}</p>
									@endif
								</div>
							</div>
						</div>

						<div class="form-group{{ $errors->has('pamount') ? ' has-error' : '' }}" id="pamount-field">
							<label for="pamount" class="col-sm-3 control-label">{{__('translate.field/pamount')}}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="pamount" name="pamount" value="{{ old('pamount') ?? $sale->pamount ?? '' }}" placeholder="{{__('translate.placeholder/pamount')}}" autocomplete="off">
								@if($errors->has('pamount'))
									<p class="help-block">{{$errors->first('pamount')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('comm') ? ' has-error' : '' }}">
							<label class="col-sm-3 control-label">{{__('translate.field/commission')}}</label>
							<div class="col-sm-9">
								@foreach($comm_types as $comm)
								<div class="radio">
									<label>
										<input type="radio" name="comm" value="{{$comm}}" class="px" {{ (old('comm') ?? $sale->comm ?? '') == $comm ? 'checked' : '' }} />
										<span class="lbl">{{$comm}}</span>
									</label>
								</div>
								@endforeach
								@if($errors->has('comm'))
									<p class="help-block">{{$errors->first('comm')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
							<label for="amount" class="col-sm-3 control-label">{{__('translate.field/amount')}}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') ?? $sale->amount ?? '' }}" placeholder="{{__('translate.placeholder/amount')}}" autocomplete="off">
								@if($errors->has('amount'))
									<p class="help-block">{{$errors->first('amount')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('remark') ? ' has-error' : '' }}">
							<label for="remark" class="col-sm-3 control-label">{{__('translate.field/remark')}}</label>
							<div class="col-sm-9">
								<textarea class="form-control" id="remark" name="remark">{{ old('remark') ?? $sale->remark ?? '' }}</textarea>
								@if($errors->has('remark'))
									<p class="help-block">{{$errors->first('remark')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('cdate') ? ' has-error' : '' }}">
							<label for="cdate" class="col-sm-3 control-label">{{__('translate.field/date')}}</label>
							<div class="col-sm-9">
								<div class="input-group date" id="cdate">
									<input type="text" name="cdate" class="form-control" value="{{ old('cdate') ?? $sale->cdate ?? '' }}" autocomplete="off"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
								@if($errors->has('cdate'))
									<p class="help-block">{{$errors->first('cdate')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
								<button type="submit" class="btn btn-primary">{{__('translate.button/update')}}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	@section('script')
		<!-- Javascript -->
		<script>
			init.push(function () {
				$('#uid').select2({ allowClear: true, placeholder: 'Select a user...' }).change(function(){
					$(this).valid();
				});

				$("#service").select2();
				$("#product").select2();

				$('#cdate').datepicker({
					todayBtn:'linked',
					format:'yyyy-mm-dd',
				});

				var services = $("#service").val();
				var products = $("#product").val();

				showPamount(services, products);

				$('#service, #product').change(function(){
					showPamount($("#service").val(), $("#product").val());
				});

				function showPamount(services, products) {
					if(services && products) {
						$('#pamount-field').show();
					}
					else {
						$('#pamount-field').hide();
						$('#pamount').val(0);
					}
				}
			});
		</script>
		<!-- / Javascript -->
	@endsection
@endsection