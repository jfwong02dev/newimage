@extends('layouts.master')
@section('title', 'Salary Management')
@section('content')
	<div class="panel">
		<div class="panel-heading">
			<div class="row">
				<div class="pull-right col-xs-12 col-sm-auto"><a href="{{ route('salaries.create') }}" class="btn btn-primary btn-labeled"><span class="btn-label icon fa fa-plus"></span>New Adjustment</a></div>
				<span class="panel-title"><i class="panel-title-icon fa fa-list-ul"></i>Salary Adjustment Listing</span>
			</div>
		</div>
		@if(session()->has('added_adjustment'))
		<div class="alert alert-page alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('added_adjustment')}}
		</div> <!-- / .alert -->
		@endif
		@if(session()->has('updated_adjustment'))
		<div class="alert alert-page alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('updated_adjustment')}}
		</div> <!-- / .alert -->
		@endif
		@if(session()->has('deleted_adjustment'))
		<div class="alert alert-page alert-danger">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('deleted_adjustment')}}
		</div> <!-- / .alert -->
		@endif
		@if(session()->has('restored_adjustment'))
		<div class="alert alert-page alert-warning">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('restored_adjustment')}}
		</div> <!-- / .alert -->
		@endif
		<div class="panel-body">
			<div class="table-primary">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
					<thead>
						<tr>
							<th>ID</th>
							<th>Username</th>
							<th>Subject</th>
							<th>Amount</th>
							<th>Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($adjustments as $adjustment)
							<tr>
								<td>{{ $adjustment->id }}</td>
								<td>{{ $adjustment->user->username }}</td>
								<td>{{ __($glob_subject[$adjustment->subject]) }}</td>
								<td>
									<i class="fa fa-{{ $adjustment->type === 'c' ? 'plus' : 'minus' }}-square" style="color: {{ $adjustment->type === 'c' ? '#71c73e' : '#d54848' }}"></i>
									{{ $adjustment->amount }}
								</td>
								<td>{{ $adjustment->cdate }}</td>
								<td>
									@if($adjustment->deleted_at)
									<form style="display:inline-block;" name="restore-form" rel="{{ $adjustment }}" method="post" action="{{route('salaries.restore', $adjustment->id)}}">
										@csrf
										<button class="btn btn-warning btn-labeled btn-sm"><span class="btn-label icon fa fa-undo"></span>Restore</button>
									</form>
									@else
									<a href="{{ route('salaries.edit', $adjustment->id) }}" class="btn btn-success btn-labeled btn-sm">
										<span class="btn-label icon fa fa-edit"></span>Edit
									</a>
									<form style="display:inline-block;" name="delete-form" rel="{{ $adjustment }}" method="post" action="{{route('salaries.destroy', $adjustment->id)}}">
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

				$('#jq-datatables-example').on('click', '[name=delete-form]', function () {
					event.preventDefault();
					var delete_form = $(this);
					var delete_adjustment = JSON.parse(delete_form.attr('rel'));
					bootbox.confirm({
						message: "Are you sure to delete Adjustment: " + delete_adjustment.id + " ?",
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
					var restore_adjustment = JSON.parse(restore_form.attr('rel'));
					bootbox.confirm({
						message: "Are you sure to restore Adjustment: " + restore_adjustment.id + " ?",
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