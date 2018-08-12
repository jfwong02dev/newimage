@extends('layouts.master')
@section('title', 'Edit Adjustment')
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
					<span class="panel-title">Edit Adjustment</span>
				</div>
				<div class="panel-body">
					<form action="{{route('salaries.update', $adjustment->id)}}" method="post" class="form-horizontal">
					@csrf
					@method('put')
						<div class="form-group{{ $errors->has('uid') ? ' has-error' : '' }}">
							<label for="uid" class="col-sm-3 control-label">Username</label>
							<div class="col-sm-9">
								<select class="form-control" name="uid" id="uid">
									<option></option>
									@foreach($users as $user)
										<option value="{{$user->uid}}" {{ (old('uid') ?? $adjustment->uid ?? '') == $user->uid ? 'selected' : '' }}>{{$user->username}}</option>
									@endforeach
								</select>
								@if($errors->has('uid'))
									<p class="help-block">{{$errors->first('uid')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
							<label class="col-sm-3 control-label">Type</label>
							<div class="col-sm-9">
								<div class="radio">
									<label>
										<input type="radio" name="type" value="c" class="px" {{ (old('type') ?? $adjustment->type ?? '') === 'c' ? 'checked' : '' }} />
										<span class="lbl">Credit</span>
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" name="type" value="d" class="px" {{ (old('type') ?? $adjustment->type ?? '') === 'd' ? 'checked' : '' }} />
										<span class="lbl">Debit</span>
									</label>
								</div>
								@if($errors->has('type'))
									<p class="help-block">{{$errors->first('type')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
							<label for="subject" class="col-sm-3 control-label">Subject</label>
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
							<label for="amount" class="col-sm-3 control-label">Amount</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') ?? $adjustment->amount ?? '' }}" placeholder="Amount">
								@if($errors->has('amount'))
									<p class="help-block">{{$errors->first('amount')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('remark') ? ' has-error' : '' }}">
							<label for="remark" class="col-sm-3 control-label">Remark</label>
							<div class="col-sm-9">
								<textarea class="form-control" id="remark" name="remark">{{ old('remark') ?? $adjustment->remark ?? '' }}</textarea>
								@if($errors->has('remark'))
									<p class="help-block">{{$errors->first('remark')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('cdate') ? ' has-error' : '' }}">
							<label for="cdate" class="col-sm-3 control-label">Date</label>
							<div class="col-sm-9">
								<div class="input-group date" id="cdate">
									<input type="text" name="cdate" class="form-control" value="{{ old('cdate') ?? $adjustment->cdate ?? '' }}"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
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
				var subject_options = $.parseJSON('<?php echo json_encode($subject_of_type); ?>');
				var selected_type = $('[name=type]:checked').val();
				var selected_subject = '<?php echo old('subject') ?? $adjustment->subject ?? ''; ?>';

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