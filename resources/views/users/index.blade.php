@extends('layouts.master')
@section('title', 'User Listing')
@section('content')
	<div class="panel">
		<div class="panel-heading">
			<div class="row">
				<div class="pull-right col-xs-12 col-sm-auto"><a href="{{ route('users.create') }}" class="btn btn-primary btn-labeled"><span class="btn-label icon fa fa-plus"></span>New User</a></div>
				<span class="panel-title"><i class="panel-title-icon fa fa-list-ul"></i>User Listing</span>
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
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
					<thead>
						<tr>
							<th>ID</th>
							<th>Username</th>
							<th>Email</th>
							<th>Mobile</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $user)
							<tr>
								<td>{{ $user->id }}</td>
								<td>{{ $user->username }}</td>
								<td>{{ $user->email }}</td>
								<td>{{ $user->mobile }}</td>
								<td>
									@if($user->deleted_at)
									<form style="display:inline-block;" name="restore-form" rel="{{ $user }}" method="post" action="{{route('users.restore', $user->id)}}">
										@csrf
										<button class="btn btn-warning btn-labeled btn-sm"><span class="btn-label icon fa fa-undo"></span>Restore</button>
									</form>
									@else
									<form style="display:inline-block;" name="edit-form" rel="{{ $user }}" method="post" action="{{route('users.update', $user->id)}}">
										@csrf
										@method('put')
										<input type="hidden" id="edit-form-{{$user->id}}" name="editProductName" value="{{ $user->name }}"/>
										<button class="btn btn-success btn-labeled btn-sm"><span class="btn-label icon fa fa-edit"></span>Edit</button>
									</form>
									<form style="display:inline-block;" name="delete-form" rel="{{ $user }}" method="post" action="{{route('users.destroy', $user->id)}}">
										@csrf
										@method('delete')
										<button class="btn btn-danger btn-labeled btn-sm"><span class="btn-label icon fa fa-trash-o"></span>Delete</button>
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
				$('#jq-datatables-example').dataTable();
				// $('#jq-datatables-example_wrapper .table-caption').text('Some header text');
				$('#jq-datatables-example_wrapper .dataTables_filter input').attr('placeholder', 'Search...');

				$('#jq-datatables-example').on('click', '[name=edit-form]', function () {
					event.preventDefault();
					var edit_form = $(this);
					var edit_user = JSON.parse(edit_form.attr('rel'));
					bootbox.prompt({
						title: "User ID: " + edit_user.id,
						inputType: 'text',
						value: edit_user.name,
						callback: function(result) {
							if (result) {
								$('#edit-form-'+edit_user.id).val(result);
								edit_form.submit();
							}
						},
						className: "bootbox-sm"
					});
				});

				$('#jq-datatables-example').on('click', '[name=delete-form]', function () {
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

				$('#jq-datatables-example').on('click', '[name=restore-form]', function () {
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