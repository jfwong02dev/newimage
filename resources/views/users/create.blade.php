@extends('layouts.master')
@section('title', 'New User')
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
					<span class="panel-title">New User</span>
				</div>
				<div class="panel-body">
					<form action="{{route('users.store')}}" method="post" class="form-horizontal">
					@csrf
						<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
							<label for="username" class="col-sm-3 control-label">Username</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="username" name="username" value="{{ old('username') ?? $faker['username'] ?? '' }}" placeholder="Username">
								@if($errors->has('username'))
									<p class="help-block">{{$errors->first('username')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('fullname') ? ' has-error' : '' }}">
							<label for="fullname" class="col-sm-3 control-label">Full Name</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname') ?? $faker['fullname'] ?? '' }}" placeholder="Full Name">
								@if($errors->has('fullname'))
									<p class="help-block">{{$errors->first('fullname')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
							<label class="col-sm-3 control-label">Gender</label>
							<div class="col-sm-9">
								<div class="radio">
									<label>
										<input type="radio" name="gender" value="m" class="px" {{ (old('gender') ?? $faker['gender'] ?? '') === 'm' ? 'checked' : '' }} />
										<span class="lbl">Male</span>
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" name="gender" value="f" class="px" {{ (old('gender') ?? $faker['gender'] ?? '') === 'f' ? 'checked' : '' }} />
										<span class="lbl">Female</span>
									</label>
								</div>
								@if($errors->has('gender'))
									<p class="help-block">{{$errors->first('gender')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('ic') ? ' has-error' : '' }}">
							<label for="ic" class="col-sm-3 control-label">IC No</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="ic" name="ic" value="{{ old('ic') ?? $faker['ic'] ?? ''}}" placeholder="IC No">
								@if($errors->has('ic'))
									<p class="help-block">{{$errors->first('ic')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							<label for="email" class="col-sm-3 control-label">Email</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="email" name="email" value="{{ old('email') ?? $faker['email'] ?? '' }}" placeholder="Email">
								@if($errors->has('email'))
									<p class="help-block">{{$errors->first('email')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
							<label for="mobile" class="col-sm-3 control-label">Mobile</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') ?? $faker['mobile'] ?? '' }}" placeholder="Mobile">
								@if($errors->has('mobile'))
									<p class="help-block">{{$errors->first('mobile')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
							<label for="address" class="col-sm-3 control-label">Address</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="address" name="address" value="{{ old('address') ?? $faker['address'] ?? '' }}" placeholder="Address">
								@if($errors->has('address'))
									<p class="help-block">{{$errors->first('address')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
							<label for="position" class="col-sm-3 control-label">Position</label>
							<div class="col-sm-9">
								<select class="form-control" name="position" id="position">
									<option></option>
									@foreach($position as $code => $text)
										<option value="{{$code}}" {{ (old('position') ?? $faker['position'] ?? '') == $code ? 'selected' : '' }}>{{__($text)}}</option>
									@endforeach
								</select>
								@if($errors->has('position'))
									<p class="help-block">{{$errors->first('position')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('salary') ? ' has-error' : '' }}">
							<label for="salary" class="col-sm-3 control-label">Salary</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="salary" name="salary" value="{{ old('salary') ?? $faker['salary'] ?? '' }}" placeholder="Salary">
								@if($errors->has('salary'))
									<p class="help-block">{{$errors->first('salary')}}</p>
								@endif
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
								<button type="submit" class="btn btn-primary">Create</button>
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
				$('#position').select2({ allowClear: true, placeholder: 'Select a position...' }).change(function(){
					$(this).valid();
				});
			});
		</script>
		<!-- / Javascript -->
	@endsection
@endsection