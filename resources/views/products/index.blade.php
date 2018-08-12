@extends('layouts.master')
@section('title', 'Products')
@section('content')

	<div class="row">
		<div class="col-sm-12">
			<form action="{{route('products.store')}}" method="post" class="panel form-horizontal">
				@csrf
				<div class="panel-heading">
					<span class="panel-title"><i class="panel-title-icon fa fa-plus"></i>New Product</span>
				</div>

				@if(session()->has('added_product'))
				<div class="alert alert-page alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>SUCCESS! </strong>{{session()->get('added_product')}}
				</div> <!-- / .alert -->
				@endif
				@if($errors->has('productName'))
				<div class="alert alert-page alert-danger">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>ERROR! </strong>{{$errors->first('productName')}}
				</div> <!-- / .alert -->
				@endif

				<div class="panel-body">
					<div class="form-group">
						<label for="productName" class="col-sm-2 control-label">Product Name</label>
						<div class="col-sm-10{{$errors->has('productName') ? ' has-error' : ''}}">
							<input type="text" class="form-control" id="productName" name="productName" placeholder="Product Name">
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
			<span class="panel-title"><i class="panel-title-icon fa fa-list-ul"></i>Product Listing</span>
		</div>
		@if(session()->has('updated_product'))
		<div class="alert alert-page alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('updated_product')}}
		</div> <!-- / .alert -->
		@endif
		@if(session()->has('deleted_product'))
		<div class="alert alert-page alert-danger">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('deleted_product')}}
		</div> <!-- / .alert -->
		@endif
		@if(session()->has('restored_product'))
		<div class="alert alert-page alert-warning">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>SUCCESS! </strong> {{session()->get('restored_product')}}
		</div> <!-- / .alert -->
		@endif
		@if($errors->has('editProductName'))
		<div class="alert alert-page alert-danger">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>ERROR! </strong> {{$errors->first('editProductName')}}
		</div> <!-- / .alert -->
		@endif
		<div class="panel-body">
			<div class="table-primary">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
					<thead>
						<tr>
							<th>ID</th>
							<th>Product Name</th>
							<th>Created Date</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($products as $product)
							<tr>
								<td>{{ $product->id }}</td>
								<td>{{ $product->name }}</td>
								<td>{{ $product->created_at }}</td>
								<td>{{ $product->deleted_at ? 'Abandoned' : 'Active' }}</td>
								<td>
									@if($product->deleted_at)
									<form style="display:inline-block;" name="restore-form" rel="{{ $product }}" method="post" action="{{route('products.restore', $product->id)}}">
										@csrf
										<button class="btn btn-warning btn-labeled btn-sm"><span class="btn-label icon fa fa-undo"></span>Restore</button>
									</form>
									@else
									<form style="display:inline-block;" name="edit-form" rel="{{ $product }}" method="post" action="{{route('products.update', $product->id)}}">
										@csrf
										@method('put')
										<input type="hidden" id="edit-form-{{$product->id}}" name="editProductName" value="{{ $product->name }}"/>
										<button class="btn btn-success btn-labeled btn-sm"><span class="btn-label icon fa fa-edit"></span>Edit</button>
									</form>
									<form style="display:inline-block;" name="delete-form" rel="{{ $product }}" method="post" action="{{route('products.destroy', $product->id)}}">
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
					var edit_product = JSON.parse(edit_form.attr('rel'));
					bootbox.prompt({
						title: "Product ID: " + edit_product.id,
						inputType: 'text',
						value: edit_product.name,
						callback: function(result) {
							if (result) {
								$('#edit-form-'+edit_product.id).val(result);
								edit_form.submit();
							}
						},
						className: "bootbox-sm"
					});
				});

				$('#jq-datatables-example').on('click', '[name=delete-form]', function () {
					event.preventDefault();
					var delete_form = $(this);
					var delete_product = JSON.parse(delete_form.attr('rel'));
					bootbox.confirm({
						message: "Are you sure to delete Product: " + delete_product.name + " ?",
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
					var restore_product = JSON.parse(restore_form.attr('rel'));
					bootbox.confirm({
						message: "Are you sure to restore Product: " + restore_product.name + " ?",
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