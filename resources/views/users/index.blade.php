@extends('layouts.master')
@section('title', __('translate.pagetitle/user'))
@section('content')
	<div class="panel">
		<div class="panel-heading">
			<div class="row">
				<div class="pull-right col-xs-12 col-sm-auto"><a href="{{ route('users.create') }}" class="btn btn-primary btn-labeled"><span class="btn-label icon fa fa-plus"></span>{{__('translate.pagetitle/new-user')}}</a></div>
				<span class="panel-title"><i class="panel-title-icon fa fa-list-ul"></i>{{__('translate.listing/user')}}</span>
			</div>
		</div>
		@if(session()->has('added_user'))
		<div class="alert alert-page alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('added_user')}}
		</div> <!-- / .alert -->
		@endif
		@if(session()->has('updated_user'))
		<div class="alert alert-page alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('updated_user')}}
		</div> <!-- / .alert -->
		@endif
		@if(session()->has('deleted_user'))
		<div class="alert alert-page alert-danger">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('deleted_user')}}
		</div> <!-- / .alert -->
		@endif
		@if(session()->has('restored_user'))
		<div class="alert alert-page alert-warning">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('restored_user')}}
		</div> <!-- / .alert -->
		@endif
		<div class="panel-body">
			<div class="table-primary">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="user-datatables">
					<thead>
						<tr>
							<th>{{__('translate.field/id')}}</th>
							<th>{{__('translate.field/username')}}</th>
							<th>{{__('translate.field/position')}}</th>
							<th>{{__('translate.field/email')}}</th>
							<th>{{__('translate.field/mobile')}}</th>
							<th>{{__('translate.field/action')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $user)
							<tr>
								<td>{{ $user->id }}</td>
								<td>{{ $user->username }}</td>
								<td>{{ __($glob_position[$user->position]) }}</td>
								<td>{{ $user->email }}</td>
								<td>{{ $user->mobile }}</td>
								<td>
									@if($user->deleted_at)
									<form style="display:inline-block;" name="restore-form" rel="{{ $user }}" method="post" action="{{route('users.restore', $user->id)}}">
										@csrf
										<button class="btn btn-warning btn-labeled btn-sm"><span class="btn-label icon fa fa-undo"></span>{{__('translate.button/restore')}}</button>
									</form>
									@else
									<a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-labeled btn-sm">
										<span class="btn-label icon fa fa-info"></span>{{__('translate.button/view')}}
									</a>
									<a href="{{ route('users.edit', $user->id) }}" class="btn btn-success btn-labeled btn-sm">
										<span class="btn-label icon fa fa-edit"></span>{{__('translate.button/edit')}}
									</a>
									<form style="display:inline-block;" name="delete-form" rel="{{ $user }}" method="post" action="{{route('users.destroy', $user->id)}}">
										@csrf
										@method('delete')
										<button class="btn btn-danger btn-labeled btn-sm"><span class="btn-label icon fa fa-trash-o"></span>{{__('translate.button/delete')}}</button>
									</form>
									@endif
								</td>
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
				$('#user-datatables').dataTable();
				$('#user-datatables_wrapper .dataTables_filter input').attr('placeholder', 'Search...');

				$('#user-datatables').on('click', '[name=delete-form]', function () {
					event.preventDefault();
					var delete_form = $(this);
					var delete_user = JSON.parse(delete_form.attr('rel'));
					bootbox.confirm({
						message: "Are you sure to delete User: " + delete_user.username + " ?",
						callback: function(result) {
							if(result) {
								delete_form.submit();
							}
						},
						className: "bootbox-sm"
					});
				});

				$('#user-datatables').on('click', '[name=restore-form]', function () {
					event.preventDefault();
					var restore_form = $(this);
					var restore_user = JSON.parse(restore_form.attr('rel'));
					bootbox.confirm({
						message: "Are you sure to restore User: " + restore_user.username + " ?",
						callback: function(result) {
							if(result) {
								restore_form.submit();
							}
						},
						className: "bootbox-sm"
					});
				});
			});
		</script>
		<!-- / Javascript -->
	@endsection
@endsection