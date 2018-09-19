@extends('layouts.master')
@section('title', __('translate.pagetitle/user-info'))
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
						<div class="pull-right col-xs-12 col-sm-auto"><a href="{{ route('users.index') }}" class="btn btn-primary btn-labeled"><span class="btn-label icon fa fa-list-ul"></span>{{__('translate.listing/user')}}</a></div>
						<span class="panel-title"><i class="panel-title-icon fa fa-user"></i>{{__('translate.pagetitle/user-info')}}</span>
					</div>
				</div>
				<table class="table table-bordered">
					<tbody>
						<tr>
							<td class="panel-padding">{{__('translate.field/username')}}</td>
							<td class="panel-padding">{{$user->username}}</td>
						</tr>
						<tr>
							<td class="panel-padding">{{__('translate.field/fullname')}}</td>
							<td class="panel-padding">{{$user->fullname}}</td>
						</tr>
						<tr>
							<td class="panel-padding">{{__('translate.field/gender')}}</td>
							<td class="panel-padding">{{__($glob_gender[$user->gender])}}</td>
						</tr>
						<tr>
							<td class="panel-padding">{{__('translate.field/ic')}}</td>
							<td class="panel-padding">{{$user->ic}}</td>
						</tr>
						<tr>
							<td class="panel-padding">{{__('translate.field/email')}}</td>
							<td class="panel-padding">{{$user->email}}</td>
						</tr>
						<tr>
							<td class="panel-padding">{{__('translate.field/mobile')}}</td>
							<td class="panel-padding">{{$user->mobile}}</td>
						</tr>
						<tr>
							<td class="panel-padding">{{__('translate.field/address')}}</td>
							<td class="panel-padding">{{$user->address}}</td>
						</tr>
						<tr>
							<td class="panel-padding">{{__('translate.field/position')}}</td>
							<td class="panel-padding">{{__($glob_position[$user->position])}}</td>
						</tr>
						<tr>
							<td class="panel-padding">{{__('translate.field/salary')}} (RM)</td>
							<td class="panel-padding">{{$user->salary}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	@section('script')
		<!-- Javascript -->
		<script>
			init.push(function () {
				
			});
		</script>
		<!-- / Javascript -->
	@endsection
@endsection