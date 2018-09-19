@extends('layouts.master')
@section('title', __('translate.pagetitle/new-adjustment'))
@section('content')
	<!-- @if($errors->all())
		@foreach($errors->all() as $error)
			<p>{{$error}}</p>
		@endforeach
	@endif -->
	<div class="row">
		<div class="col-sm-12">
			<div class="panel">
				<div class="panel-heading">
					<div class="row">
						<div class="pull-right col-xs-12 col-sm-auto"><a href="{{ route('salaries.index') }}" class="btn btn-primary btn-labeled"><span class="btn-label icon fa fa-list-ul"></span>{{__('translate.listing/salary-amendment')}}</a></div>
						<span class="panel-title"><i class="panel-title-icon fa fa-plus"></i>{{__('translate.pagetitle/new-adjustment')}}</span>
					</div>
				</div>
				@if(session()->has('added_adjustment'))
				<div class="alert alert-page alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>SUCCESS! </strong> {{session()->get('added_adjustment')}}
				</div> <!-- / .alert -->
				@endif
				<div class="panel-body">
					<form action="{{route('salaries.store')}}" method="post" class="form-horizontal">
					@csrf
						<div class="form-group{{ $errors->has('uid') ? ' has-error' : '' }}">
							<label for="uid" class="col-sm-3 control-label">{{__('translate.field/username')}}</label>
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

						<div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
							<label class="col-sm-3 control-label">{{__('translate.field/type')}}</label>
							<div class="col-sm-9">
								<div class="radio">
									<label>
										<input type="radio" name="type" value="c" class="px" {{ (old('type') ?? $faker['type'] ?? '') === 'c' ? 'checked' : '' }} />
										<span class="lbl">{{__('translate.field/credit')}}</span>
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" name="type" value="d" class="px" {{ (old('type') ?? $faker['type'] ?? '') === 'd' ? 'checked' : '' }} />
										<span class="lbl">{{__('translate.field/debit')}}</span>
									</label>
								</div>
								@if($errors->has('type'))
									<p class="help-block">{{$errors->first('type')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
							<label for="subject" class="col-sm-3 control-label">{{__('translate.field/subject')}}</label>
							<div class="col-sm-9">
								<div id="subject-select">
								<select class="form-control" name="subject" id="subject">
									<option></option>
								</select>
								</div>
								@if($errors->has('subject'))
									<p class="help-block">{{$errors->first('subject')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
							<label for="amount" class="col-sm-3 control-label">{{__('translate.field/amount')}}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') ?? $faker['amount'] ?? '' }}" placeholder="{{__('translate.placeholder/amount')}}" autocomplete="off">
								@if($errors->has('amount'))
									<p class="help-block">{{$errors->first('amount')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('remark') ? ' has-error' : '' }}">
							<label for="remark" class="col-sm-3 control-label">{{__('translate.field/remark')}}</label>
							<div class="col-sm-9">
								<textarea class="form-control" id="remark" name="remark">{{ old('remark') ?? $faker['remark'] ?? '' }}</textarea>
								@if($errors->has('remark'))
									<p class="help-block">{{$errors->first('remark')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('cdate') ? ' has-error' : '' }}">
							<label for="cdate" class="col-sm-3 control-label">{{__('translate.field/date')}}</label>
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
								<button type="submit" class="btn btn-primary">{{__('translate.button/create')}}</button>
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
				var subject_options = $.parseJSON('<?php echo json_encode($subject_of_type); ?>');
				var selected_type = $('[name=type]:checked').val();
				var selected_subject = '<?php echo old('subject') ?? $faker['subject'] ?? ''; ?>';

				if(typeof(subject_options[selected_type]) != 'undefined') {
					display_subject_options(selected_type);
				}

				$('#uid').select2({ allowClear: true, placeholder: 'Select a user...' }).change(function(){
					$(this).valid();
				});
				$('#subject').select2({ allowClear: true, placeholder: 'Select a subject...' }).change(function(){
					$(this).valid();
				});
				$('#cdate').datepicker({
					todayBtn:'linked',
					format:'yyyy-mm-dd',
				});
				$('[name=type]').change(function(){
					display_subject_options($(this).val());
				});

				function display_subject_options(sub_option){
					var mesg = '';
					
					if(typeof(subject_options[sub_option]) !== 'undefined'){
							mesg += '<select class="form-control" name="subject" id="subject" >';
							mesg += '<option></option>';
							$.each(subject_options[sub_option], function(code, text) {
								mesg += '<option value="'+ 
								code +
								'"' +
								(code == selected_subject ? ' selected' : '') + 
								' > '+ 
								text + '</option>';
							});
							mesg += '</select>';
					}
					
					if(mesg == ''){
						mesg = '<select class="form-control" name="subject" id="subject" >';
					}
					
					$('#subject-select').html(mesg);
					
					$('#subject').select2({ allowClear: true, placeholder: 'Select a subject...' }).change(function(){
						$(this).valid();
					});
				}
			});
		</script>
		<!-- / Javascript -->
	@endsection
@endsection