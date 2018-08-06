@extends('layouts.master')
@section('title', 'Service Listing')
@section('content')
	<div class="panel">
		<div class="panel-heading">
			<span class="panel-title">Service Listing</span>
		</div>
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
									<a href="{{route('services.show', $service->id)}}" class="btn btn-info btn-sm">View</a>&nbsp;
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