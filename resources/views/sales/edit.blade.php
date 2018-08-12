@extends('layouts.master')
@section('title', 'Edit Sale')
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
					<span class="panel-title">Edit Sale (ID: {{ $sale->id }})</span>
				</div>
				<div class="panel-body">
					<form action="{{route('sales.update', $sale->id)}}" method="post" class="form-horizontal">
					@csrf
					@method('put')
						<div class="form-group{{ $errors->has('uid') ? ' has-error' : '' }}">
							<label for="uid" class="col-sm-3 control-label">Username</label>
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
							<label class="col-sm-3 control-label">Service</label>
							<div class="col-sm-9">
								<div class="select2-primary">
									<select multiple="multiple" class="form-control" id="service" name="service[]">
										@foreach($services as $service)
										<option value="{{$service->code}}" 
											{{ ( 
												in_array($service->code, (is_array(old('service')) ? old('service') : [])) || 
												in_array($service->code, (json_decode($sale->service) ?? []))
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
							<label class="col-sm-3 control-label">Product</label>
							<div class="col-sm-9">
								<div class="select2-info">
									<select multiple="multiple" class="form-control" id="product" name="product[]">
										@foreach($products as $product)
										<option value="{{$product->code}}" 
											{{ ( 
												in_array($product->code, (old('product') ?? [])) || 
												in_array($product->code, (json_decode($sale->product) ?? []))
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

						<div class="form-group{{ $errors->has('comm') ? ' has-error' : '' }}">
							<label class="col-sm-3 control-label">Commission (%)</label>
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
							<label for="amount" class="col-sm-3 control-label">Amount</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') ?? $sale->amount ?? '' }}" placeholder="Amount">
								@if($errors->has('amount'))
									<p class="help-block">{{$errors->first('amount')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('remark') ? ' has-error' : '' }}">
							<label for="remark" class="col-sm-3 control-label">Remark</label>
							<div class="col-sm-9">
								<textarea class="form-control" id="remark" name="remark">{{ old('remark') ?? $sale->remark ?? '' }}</textarea>
								@if($errors->has('remark'))
									<p class="help-block">{{$errors->first('remark')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('cdate') ? ' has-error' : '' }}">
							<label for="cdate" class="col-sm-3 control-label">Date</label>
							<div class="col-sm-9">
								<div class="input-group date" id="cdate">
									<input type="text" name="cdate" class="form-control" value="{{ old('cdate') ?? $sale->cdate ?? '' }}"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
								@if($errors->has('cdate'))
									<p class="help-block">{{$errors->first('cdate')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
								<button type="submit" class="btn btn-primary">Update</button>
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
			});
		</script>
		<!-- / Javascript -->
	@endsection
@endsection