@extends('layouts.master')
@section('title', 'Add Service')
@section('content')
	<div class="row">
		<div class="col-sm-12">
			<form action="{{route('services.store')}}" method="post" class="panel form-horizontal">
				@csrf
				<div class="panel-heading">
					<span class="panel-title">New Service</span>
				</div>
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