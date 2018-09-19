@extends('layouts.master')
@section('title', 'Payslip Generator')
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
					<span class="panel-title">Payslip</span>
				</div>
				<div class="panel-body">
					<form action="{{route('payslips.show')}}" method="post" class="form-horizontal">
					@csrf
						<div class="form-group{{ $errors->has('uid') ? ' has-error' : '' }}">
							<label for="uid" class="col-sm-3 control-label">Username</label>
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

						<div class="form-group{{ $errors->has('month') ? ' has-error' : '' }}">
							<label for="month" class="col-sm-3 control-label">Month</label>
							<div class="col-sm-9">
								<div id="month-select">
								<select class="form-control" name="month" id="month">
									<option></option>
								</select>
								</div>
								@if($errors->has('month'))
									<p class="help-block">{{$errors->first('month')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
								<button type="submit" class="btn btn-primary">Generate</button>
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
				
				$('#month').select2({ allowClear: true, placeholder: 'Select a month...' }).change(function(){
					$(this).valid();
				});
				
				var individual_months = $.parseJSON('<?php echo json_encode($individual_months); ?>');
				var selected_uid = '<?php echo old('uid') ?? $faker['uid'] ?? ''; ?>';

				if(typeof(individual_months[selected_uid]) != 'undefined') {
					display_month_options(selected_uid);
				}
				
				$('[name=uid]').change(function(){
					display_month_options($(this).val());
				});
				
				function display_month_options(uid){
					var mesg = '';
					
					if(typeof(individual_months[uid]) !== 'undefined'){
							mesg += '<select class="form-control" name="month" id="month" >';
							mesg += '<option></option>';
							$.each(individual_months[uid], function(key, value) {
								mesg += '<option value="'+ 
								value +
								'"' +
								' > '+ 
								value + '</option>';
							});
							mesg += '</select>';
					}
					
					if(mesg == ''){
						mesg = '<select class="form-control" name="month" id="month" >';
					}
					
					$('#month-select').html(mesg);
					
					$('#month').select2({ allowClear: true, placeholder: 'Select a month...' }).change(function(){
						$(this).valid();
					});
				}
			});
		</script>
		<!-- / Javascript -->
	@endsection
@endsection