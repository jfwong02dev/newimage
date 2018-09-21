@extends('layouts.master')
@section('title', __('translate.pagetitle/salary-management'))
@section('content')

	<div class="panel" id="search-form" style="display:{{ $search ? 'block' : 'none' }}">
		<div class="panel-heading">
			<div class="row">
				<span class="panel-title"><i class="panel-title-icon fa fa-search"></i>{{ __('translate.general/search-panel') }}</span>
			</div>
		</div>
		<div class="panel-body">
			<form action="{{route('salaries.search')}}" method="post" name="search-form">
				@csrf
				<div class="form-group">
					<label class="col-sm-3 control-label">{{ __('translate.field/username') }}</label>
					<div class="col-sm-9">
						<div class="select2-primary">
							<select multiple="multiple" class="form-control" id="uid" name="uid[]">
								@foreach($users as $user)
								<option value="{{$user->uid}}" 
									{{ ( 
										in_array($user->uid, (is_array(old('uid')) ? old('uid') : []))
										) ? 'selected' : '' 
									}}>{{ $user->username }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">{{ __('translate.field/subject') }}</label>
					<div class="col-sm-9">
						<div class="select2-primary">
							<select multiple="multiple" class="form-control" id="subject" name="subject[]">
								@foreach($subjects as $type => $subject)
								<optgroup label="{{__('translate.amendment-type/' . $type)}}">
									@foreach($subject as $sub_code => $sub_name)
									<option value="{{$sub_code}}" 
									{{ ( 
										in_array($sub_code, (is_array(old('subject')) ? old('subject') : []))
										) ? 'selected' : '' 
									}}>{{ $sub_name }}</option>
									@endforeach
								</optgroup>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="daterange" class="col-sm-3 control-label">{{ __('translate.field/date') }}</label>
					<div class="col-sm-9">
						<div class="input-daterange input-group" id="bs-datepicker-range">
							<input type="text" class="input-sm form-control" name="from_date" value="{{ old('from_date') ?? '' }}" autocomplete="off" placeholder="{{ __('translate.placeholder/start-date') }}">
							<span class="input-group-addon">to</span>
							<input type="text" class="input-sm form-control" name="to_date" value="{{ old('to_date') ?? '' }}" autocomplete="off" placeholder="{{ __('translate.placeholder/end-date') }}">
						</div>
					</div>
				</div>
				<div class="form-group" style="margin-bottom: 0;">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary pull-right">{{ __('translate.button/search') }}</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="panel">
		<div class="panel-heading">
			<div class="row">
				<div class="pull-right col-xs-12 col-sm-auto btn btn-primary btn-labeled" id="search-btn"><span class="btn-label icon fa fa-search"></span>{{__('translate.button/show')}}</div>
				<div class="pull-right col-xs-12 col-sm-auto"><a href="{{ route('salaries.create') }}" class="btn btn-primary btn-labeled"><span class="btn-label icon fa fa-plus"></span>{{__('translate.pagetitle/new-adjustment')}}</a></div>
				@if($search)
					<span class="pull-right">{{ __('translate.message/record-found', ['number' => count($adjustments)])}}   <a href="{{ route('salaries.index') }}">{{ __('translate.button/clear') }}</a></span>
				@endif
				<span class="panel-title"><i class="panel-title-icon fa fa-list-ul"></i>{{__('translate.listing/salary-amendment')}}</span>
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
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="adjustment-datatables">
					<thead>
						<tr>
							<th>{{__('translate.field/id')}}</th>
							<th>{{__('translate.field/username')}}</th>
							<th>{{__('translate.field/subject')}}</th>
							<th>{{__('translate.field/amount')}}</th>
							<th>{{__('translate.field/date')}}</th>
							<th>{{__('translate.field/action')}}</th>
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
									@if($adjustment->user->deleted_at)
									<span class="label label-info">{{__('translate.notification/is-deleted-user', ['username' => $adjustment->user->username])}}</span>
										@if($adjustment->deleted_at)
										<span class="label label-danger">{{__('translate.status/deleted')}}</span>
										@endif
									@elseif($adjustment->deleted_at)
									<form style="display:inline-block;" name="restore-form" rel="{{ $adjustment }}" method="post" action="{{route('salaries.restore', $adjustment->id)}}">
										@csrf
										<button class="btn btn-warning btn-labeled btn-sm"><span class="btn-label icon fa fa-undo"></span>{{__('translate.button/restore')}}</button>
									</form>
									@else
									<a href="{{ route('salaries.edit', $adjustment->id) }}" class="btn btn-success btn-labeled btn-sm">
										<span class="btn-label icon fa fa-edit"></span>{{__('translate.button/edit')}}
									</a>
									<form style="display:inline-block;" name="delete-form" rel="{{ $adjustment }}" method="post" action="{{route('salaries.destroy', $adjustment->id)}}">
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
				$("#uid").select2();
				$("#subject").select2();

				$('#adjustment-datatables').dataTable();
				$('#adjustment-datatables_wrapper .dataTables_filter input').attr('placeholder', 'Search...');

				$('#adjustment-datatables').on('click', '[name=delete-form]', function () {
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

				$('#adjustment-datatables').on('click', '[name=restore-form]', function () {
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

				$('#bs-datepicker-range').datepicker({
					todayBtn:'linked',
					format:'yyyy-mm-dd',
				});

				$("#search-btn").click(function(){
					if($('#search-form').css('display') === 'none') {
						$('#search-btn').html("<span class='btn-label icon fa fa-search'></span>{{__('translate.button/hide')}}")
					}
					else {
						$('#search-btn').html("<span class='btn-label icon fa fa-search'></span>{{__('translate.button/show')}}")
					}
					$('#search-form').toggle();
				});
			});
		</script>
		<!-- / Javascript -->
	@endsection
@endsection