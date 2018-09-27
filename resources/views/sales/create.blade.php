@extends('layouts.master')
@section('title', __('translate.pagetitle/new-sales'))
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
						<span class="panel-title"><i class="panel-title-icon fa fa-plus"></i>{{__('translate.pagetitle/new-sales')}}</span>
					</div>
				</div>
				@if(session()->has('added_sale'))
				<div class="alert alert-page alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>SUCCESS! </strong> {{session()->get('added_sale')}}
				</div> <!-- / .alert -->
				@endif
				<div class="panel-body">
					<div class="col-sm-6">
						<form action="{{route('sales.store')}}" method="post" class="form-horizontal" id="create-sale-form">
						@csrf
							<input type="hidden" name="bulkService" />
							<input type="hidden" name="bulkProduct" />
							<div class="form-group{{ $errors->has('service') ? ' has-error' : '' }}">
								<label class="col-sm-3 control-label">{{ __('translate.field/service') }}</label>
								<div class="col-sm-9">
									<div class="select2-primary">
										<select multiple="multiple" class="form-control" id="service" name="service[]">
											@foreach($services as $service)
											<option value="{{$service->code}}" 
												{{ ( 
													in_array($service->code, (is_array(old('service')) ? old('service') : ($faker['service'] ?? [])))
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

							<div class="form-group{{ $errors->has('uid') ? ' has-error' : '' }}">
								<label for="uid" class="col-sm-3 control-label">{{ __('translate.field/username') }}</label>
								<div class="col-sm-9">
									<select class="form-control" name="uid" id="uid">
										<option></option>
										@foreach($users as $user)
											<option value="{{$user->uid}}" {{ (old('uid') ?? $faker['uid'] ?? '') == $user->uid ? 'selected' : '' }}>{{$user->username}}</option>
										@endforeach
									</select>
									@if($errors->has('uid'))
										<p class="help-block">{{$errors->first('uid')}}</p>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('product') ? ' has-error' : '' }}">
								<label class="col-sm-3 control-label">{{ __('translate.field/product') }}</label>
								<div class="col-sm-9">
									<div class="select2-info">
										<select multiple="multiple" class="form-control" id="product" name="product[]">
											@foreach($products as $product)
											<option value="{{$product->code}}" 
												{{ ( 
													in_array($product->code, (is_array(old('product')) ? old('product') : ($faker['product'] ?? [])))
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
								<label for="pamount" class="col-sm-3 control-label">{{ __('translate.field/pamount') }}</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="pamount" name="pamount" value="{{ old('pamount') ?? $faker['pamount'] ?? '' }}" placeholder="{{ __('translate.placeholder/pamount') }}" autocomplete="off">
									@if($errors->has('pamount'))
										<p class="help-block">{{$errors->first('pamount')}}</p>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('comm') ? ' has-error' : '' }}">
								<label class="col-sm-3 control-label">{{ __('translate.field/commission') }}</label>
								<div class="col-sm-9">
									@foreach($comm_types as $comm)
									<div class="radio">
										<label>
											<input type="radio" name="comm" value="{{$comm}}" class="px" {{ ((old('comm') ?? $faker['comm'] ?? '') === $comm || $comm === 10) ? 'checked' : '' }} />
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
								<label for="amount" class="col-sm-3 control-label">{{ __('translate.field/amount') }}</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') ?? $faker['amount'] ?? '' }}" placeholder="{{ __('translate.placeholder/amount') }}" autocomplete="off">
									@if($errors->has('amount'))
										<p class="help-block">{{$errors->first('amount')}}</p>
									@endif
								</div>
							</div>
							<!-- <div class="form-group{{ $errors->has('remark') ? ' has-error' : '' }}">
								<label for="remark" class="col-sm-3 control-label">{{ __('translate.field/remark') }}</label>
								<div class="col-sm-9">
									<textarea class="form-control" id="remark" name="remark">{{ old('remark') ?? $faker['remark'] ?? '' }}</textarea>
									@if($errors->has('remark'))
										<p class="help-block">{{$errors->first('remark')}}</p>
									@endif
								</div>
							</div> -->

							<div class="form-group{{ $errors->has('cdate') ? ' has-error' : '' }}">
								<label for="cdate" class="col-sm-3 control-label">{{ __('translate.field/date') }}</label>
								<div class="col-sm-9">
									<div class="input-group date" id="cdate">
										<input type="text" name="cdate" class="form-control" value="{{ old('cdate') ?? $faker['cdate'] ?? '' }}" autocomplete="off"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
									@if($errors->has('cdate'))
										<p class="help-block">{{$errors->first('cdate')}}</p>
									@endif
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-9">
									<button id="create-btn" type="submit" class="btn btn-primary">{{ __('translate.button/create') }}</button>
								</div>
							</div>
						</form>
					</div>
					<div class="col-sm-6">
						<!-- Primary table -->
						<div class="table-primary col-sm-6">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>{{__('translate.field/service')}}</th>
										<th>{{__('translate.field/noOfService')}}</th>
									</tr>
								</thead>
								<tbody id="service-list">
								</tbody>
							</table>
						</div>
						<!-- / Primary table -->
						<!-- Primary table -->
						<div class="table-primary col-sm-6">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>{{__('translate.field/product')}}</th>
										<th>{{__('translate.field/noOfProduct')}}</th>
									</tr>
								</thead>
								<tbody id="product-list">
								</tbody>
							</table>
						</div>
						<!-- / Primary table -->
					</div>
				</div>
			</div>
		</div>
	</div>
	@section('script')
		<!-- Javascript -->
		<script>
			init.push(function () {
				var service_code_to_name = <?php echo json_encode($service_code_to_name); ?>;
				var product_code_to_name = <?php echo json_encode($product_code_to_name); ?>;
				var old_bulkService = <?php echo json_encode(old('bulkService')); ?>;
				var old_bulkProduct = <?php echo json_encode(old('bulkProduct')); ?>;
				var bulkServices = {}
				var bulkProducts = {}

				if(old_bulkService !== null) {
					$.each(old_bulkService.split(','), function(index, value) {
						if(bulkServices.hasOwnProperty(value)) {
							bulkServices[value] += 1;
						} else {
							bulkServices[value] = 1;
						}
					})
				}

				if(old_bulkProduct !== null) {
					$.each(old_bulkProduct.split(','), function(index, value) {
						if(bulkProducts.hasOwnProperty(value)) {
							bulkProducts[value] += 1;
						} else {
							bulkProducts[value] = 1;
						}
					})
				}

				$('#uid').select2({ allowClear: true, placeholder: 'Select a user...' }).change(function(){
					$(this).valid();
				});

				$("#service").select2({ placeholder: 'Select service...' });
				$("#product").select2({ placeholder: 'Select product...' });
				
				$('#cdate').datepicker({
					todayBtn:'linked',
					format:'yyyy-mm-dd',
				});
				
				var services = $("#service").val();
				var products = $("#product").val();
				var updatedSs = [];
				var updatedSp = [];

				if(services.length || products.length) {
					theChange();
				}

				$('#service, #product').change(theChange);

				function theChange() {
					var sService = $("#service").val();
					var sProduct = $("#product").val();
					var ssLength = sService.length;
					var spLength = sProduct.length;

					showPamount(sService, sProduct);

					// handle selected service
					if (ssLength > updatedSs.length) {
						var scode_added = sService.filter(function(value) {
							return updatedSs.indexOf(value) === -1;
						});

						if(scode_added.length > 0) {
							$.each(scode_added, function(index, value) {
								$('#service-list').append(
									'<tr>' +
									'<td>' + service_code_to_name[value] + '</td>' +
									'<td><input class=\"form-control\" name=\"serviceUnit\" value=\"\" id=\"' + value + '\"></td>' + 
									'</tr>'
								);

								$("#" + value).spinner({ min: 1 }).val(bulkServices[value] ? bulkServices[value] : 1);
								updatedSs.push(value);
							})
						}
					} else if (ssLength < updatedSs.length) {
						var scode_removed = updatedSs.filter(function(value) {
							return sService.indexOf(value) === -1;
						});
						scode_removed = scode_removed[0]
						updatedSs = updatedSs.filter(function(value){
							return value !== scode_removed;
						});

						$('#' + scode_removed).parent().parent().parent().remove();
					}

					// handle selected product
					if (spLength > updatedSp.length) {
						var pcode_added = sProduct.filter(function(value) {
							return updatedSp.indexOf(value) === -1;
						});
						if(pcode_added.length > 0) {
							$.each(pcode_added, function(index, value) {
								$('#product-list').append(
									'<tr>' +
									'<td>' + product_code_to_name[value] + '</td>' +
									'<td><input class=\"form-control\" name=\"productUnit\" value=\"\" id=\"' + value + '\"></td>' + 
									'</tr>'
								);

								$("#" + value).spinner({ min: 1 }).val(bulkProducts[value] ? bulkProducts[value] : 1);
								updatedSp.push(value);
							})
						}
					} else if (spLength < updatedSp.length) {
						var pcode_removed = updatedSp.filter(function(value) {
							return sProduct.indexOf(value) === -1;
						});
						pcode_removed = pcode_removed[0]
						updatedSp = updatedSp.filter(function(value){
							return value !== pcode_removed;
						});

						$('#' + pcode_removed).parent().parent().parent().remove();
					}
				}

				$('#create-btn').on('click', function(e){
					e.preventDefault();
					var bulk_selected_service = []
					var bulk_selected_product = []
					$("[name=serviceUnit]").each( function() {
						var scode = $(this).attr('id');
						var noOfScode = $(this).val();

						for (var i = 0; i < noOfScode; i++) {
							bulk_selected_service.push(scode)
						}
					})
					$('input:hidden[name=bulkService]').val(bulk_selected_service);

					$("[name=productUnit]").each( function() {
						var pcode = $(this).attr('id');
						var noOfPcode = $(this).val();

						for (var i = 0; i < noOfPcode; i++) {
							bulk_selected_product.push(pcode)
						}
					})
					$('input:hidden[name=bulkProduct]').val(bulk_selected_product);

					$('#create-sale-form').submit();
				})

				function showPamount(services, products) {
					if(services.length && products.length) {
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