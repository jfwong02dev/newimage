@extends('layouts.master')
@section('title', __('translate.pagetitle/service'))
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<form action="{{route('services.store')}}" method="post" class="panel form-horizontal">
				@csrf
				<div class="panel-heading">
					<span class="panel-title"><i class="panel-title-icon fa fa-plus"></i>{{__('translate.pagetitle/new-service')}}</span>
				</div>

				@if(session()->has('added_service'))
				<div class="alert alert-page alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>SUCCESS! </strong>{{session()->get('added_service')}}
				</div> <!-- / .alert -->
				@endif
				@if($errors->has('serviceName'))
				<div class="alert alert-page alert-danger">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>ERROR! </strong>{{$errors->first('serviceName')}}
				</div> <!-- / .alert -->
				@endif

				<div class="panel-body">
					<div class="form-group">
						<label for="serviceName" class="col-sm-2 control-label">{{__('translate.field/service-name')}}</label>
						<div class="col-sm-10{{$errors->has('serviceName') ? ' has-error' : ''}}">
							<input type="text" class="form-control" id="serviceName" name="serviceName" placeholder="{{__('translate.placeholder/service-name')}}" autocomplete="off">
						</div>
					</div> <!-- / .form-group -->
					<div class="form-group" style="margin-bottom: 0;">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-primary">{{__('translate.button/create')}}</button>
						</div>
					</div> <!-- / .form-group -->
				</div>
			</form>
		</div>
	</div>

	<div class="panel">
		<div class="panel-heading">
			<span class="panel-title"><i class="panel-title-icon fa fa-list-ul"></i>{{__('translate.listing/service')}}</span>
		</div>
		@if(session()->has('updated_service'))
		<div class="alert alert-page alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('updated_service')}}
		</div> <!-- / .alert -->
		@endif
		@if(session()->has('deleted_service'))
		<div class="alert alert-page alert-danger">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('deleted_service')}}
		</div> <!-- / .alert -->
		@endif
		@if(session()->has('restored_service'))
		<div class="alert alert-page alert-warning">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('restored_service')}}
		</div> <!-- / .alert -->
		@endif
		@if($errors->has('editServiceName'))
		<div class="alert alert-page alert-danger">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>ERROR! </strong> {{$errors->first('editServiceName')}}
		</div> <!-- / .alert -->
		@endif
		<div class="panel-body">
			<div class="table-primary">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="service-datatables">
					<thead>
						<tr>
							<th>{{__('translate.field/id')}}</th>
							<th>{{__('translate.field/service-name')}}</th>
							<th>{{__('translate.field/cdate')}}</th>
							<th>{{__('translate.field/status')}}</th>
							<th>{{__('translate.field/action')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($services as $service)
							<tr>
								<td>{{ $service->id }}</td>
								<td>{{ $service->name }}</td>
								<td>{{ $service->created_at }}</td>
								<td>{{ $service->deleted_at ? __('translate.status/abandoned') : __('translate.status/active') }}</td>
								<td>
									@if($service->deleted_at)
									<form style="display:inline-block;" name="restore-form" rel="{{ $service }}" method="post" action="{{route('services.restore', $service->id)}}">
										@csrf
										<button class="btn btn-warning btn-labeled btn-sm"><span class="btn-label icon fa fa-undo"></span>{{__('translate.button/restore')}}</button>
									</form>
									@else
									<form style="display:inline-block;" name="edit-form" rel="{{ $service }}" method="post" action="{{route('services.update', $service->id)}}">
										@csrf
										@method('put')
										<input type="hidden" id="edit-form-{{$service->id}}" name="editServiceName" value="{{ $service->name }}"/>
										<button class="btn btn-success btn-labeled btn-sm"><span class="btn-label icon fa fa-edit"></span>{{__('translate.button/edit')}}</button>
									</form>
									<form style="display:inline-block;" name="delete-form" rel="{{ $service }}" method="post" action="{{route('services.destroy', $service->id)}}">
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
				$('#service-datatables').dataTable();
				$('#service-datatables_wrapper .dataTables_filter input').attr('placeholder', 'Search...');

				$('#service-datatables').on('click', '[name=edit-form]', function () {
					event.preventDefault();
					var edit_form = $(this);
					var edit_service = JSON.parse(edit_form.attr('rel'));
					bootbox.prompt({
						title: "Service ID: " + edit_service.id,
						inputType: 'text',
						value: edit_service.name,
						callback: function(result) {
							if (result) {
								$('#edit-form-'+edit_service.id).val(result);
								edit_form.submit();
							}
						},
						className: "bootbox-sm"
					});
				});

				$('#service-datatables').on('click', '[name=delete-form]', function () {
					event.preventDefault();
					var delete_form = $(this);
					var delete_service = JSON.parse(delete_form.attr('rel'));
					bootbox.confirm({
						message: "Are you sure to delete Service: " + delete_service.name + " ?",
						callback: function(result) {
							if(result) {
								delete_form.submit();
							}
						},
						className: "bootbox-sm"
					});
				});

				$('#service-datatables').on('click', '[name=restore-form]', function () {
					event.preventDefault();
					var restore_form = $(this);
					var restore_service = JSON.parse(restore_form.attr('rel'));
					bootbox.confirm({
						message: "Are you sure to restore Service: " + restore_service.name + " ?",
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