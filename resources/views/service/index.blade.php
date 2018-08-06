@extends('layouts.master')
@section('title', 'Service Listing')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<form action="{{route('services.store')}}" method="post" class="panel form-horizontal">
				@csrf
				<div class="panel-heading">
					<span class="panel-title"><i class="panel-title-icon fa fa-plus"></i>New Service</span>
				</div>

				@if(session()->has('added_service'))
				<div class="alert alert-page alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>SUCCESS! </strong>{{session()->get('added_service')}}
				</div> <!-- / .alert -->
				@endif

				<div class="panel-body">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Service Name</label>
						<div class="col-sm-10{{$errors->has('name') ? ' has-error' : ''}}">
							<input type="text" class="form-control" id="name" name="name" placeholder="Service Name">
							@if ($errors->has('name'))
							<p class="help-block">{{$errors->first('name')}}</p>
							@endif
						</div>
					</div> <!-- / .form-group -->
					<div class="form-group" style="margin-bottom: 0;">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-primary">Create</button>
						</div>
					</div> <!-- / .form-group -->
				</div>
			</form>
		</div>
	</div>

	<div class="panel">
		<div class="panel-heading">
			<span class="panel-title"><i class="panel-title-icon fa fa-list-ul"></i>Service Listing</span>
		</div>
		@if(session()->has('updated_service'))
		<div class="alert alert-page alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('updated_service')}}
		</div> <!-- / .alert -->
		@endif
		@if(session()->has('deleted_service'))
		<div class="alert alert-page alert-warning">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('deleted_service')}}
		</div> <!-- / .alert -->
		@endif
		<div class="panel-body">
			<div class="table-primary">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
					<thead>
						<tr>
							<th>ID</th>
							<th>Job Title</th>
							<th>Created Date</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($services as $service)
							<tr>
								<td>{{ $service->id }}</td>
								<td>{{ $service->name }}</td>
								<td>{{ $service->created_at }}</td>
								<td>{{ $service->deleted_at ? 'Abandoned' : 'Active' }}</td>
								<td>
									<!-- <a href="{{route('services.show', $service->id)}}" class="btn btn-info btn-sm">View</a>&nbsp; -->
									<a href="{{route('services.edit', $service->id)}}" class="btn btn-success btn-sm">Edit</a>&nbsp;
									<form style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this post?')" method="post" action="{{route('services.destroy', $service->id)}}">
										@csrf
										@method('delete')
										<button type="submit" class="btn btn-danger btn-sm">Delete</button>
									</form>
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
			});
		</script>
		<!-- / Javascript -->
	@endsection
@endsection