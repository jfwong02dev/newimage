<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="gt-ie8 gt-ie9 not-ie">
<!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>{{ $user->fullname }} - {{ env('APP_NAME') }} - {{__('translate.pagetitle/payslip')}}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<!-- Open Sans font from Google CDN -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin"
	 rel="stylesheet" type="text/css">

	<!-- Pixel Admin's stylesheets -->
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/pixel-admin.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/pages.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/rtl.min.css') }}" rel="stylesheet" type="text/css">

	<!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('j-icon.png') }}">

	<!--[if lt IE 9]>
		<script src="assets/javascripts/ie.min.js"></script>
	<![endif]-->

</head>


<body class="page-invoice page-invoice-print">
	<script>
		window.onload = function () {
			window.print();
		};
	</script>

	<div class="invoice">
		<div class="invoice-header">
			<h3>
				<div class="invoice-logo demo-logo"><img src="{{ asset('demo/logo-big.png') }}" alt="" style="width:100%;height:100%;"></div>
				<div>
					<small><strong>{{ env('APP_NAME') }}</strong></small><br>
					{{ __('translate.pagetitle/payslip') }}
				</div>
			</h3>
			<address>
				{!! __('translate.company/address', ['br' => '<br/>']) !!}
			</address>
			<div class="invoice-date">
				<small><strong>{{ __('translate.field/date')}}</strong></small><br> {{ $date }}
			</div>
		</div> <!-- / .invoice-header -->
		<div class="invoice-info">
			<div class="invoice-recipient">
				<strong>{{ $user->fullname }}</strong><br> {{ $user->ic }}<br> {{ __($glob_position[$user->position]) }}
			</div> <!-- / .invoice-recipient -->
			<div class="invoice-total">
				<span>RM {{ number_format($net_total, 2) }}</span>
				{{__('translate.payslip/total')}}:
			</div> <!-- / .invoice-total -->
		</div> <!-- / .invoice-info -->
		<hr>
		<br/>
		<div class="row">
			<div class="col-sm-6">
				<div class="panel">
					<div class="panel-heading">
						<span class="panel-title">{{ __('translate.field/earning') }}</span>
					</div>
						<table class="table table-bordered">
							<tbody>
								<tr>
									<td colspan="2">{{ __('translate.field/basic-pay') }}</td>
									<td>RM <span class="pull-right">{{ number_format($user->salary, 2) }}</span></td>
								</tr>
								<tr>
									<td rowspan="2">{{ __('translate.field/commission') }}</td>
									<td>S</td>
									<td>RM <span class="pull-right">{{ number_format($comm->service_comm, 2) }}</span></td>
								</tr>
								<tr>
									<td>P</td>
									<td>RM <span class="pull-right">{{ number_format($comm->product_comm, 2) }}</span></td>
								</tr>
								<tr>
									<td colspan="2">{{ trans('translate.field/ot') }}</td>
									<td>RM <span class="pull-right">{{ number_format($adjustments[$subject_types['c']['ot']] ?? 0, 2) }}</span></td>
								</tr>
								<tr>
									<td colspan="2">{{ trans('translate.field/bonus') }}</td>
									<td>RM <span class="pull-right">{{ number_format($adjustments[$subject_types['c']['bonus']] ?? 0, 2) }}</span></td>
								</tr>
								<tr>
									<td colspan="2">{{ trans('translate.field/allowance') }}</td>
									<td>RM <span class="pull-right">{{ number_format($adjustments[$subject_types['c']['allowance']] ?? 0, 2) }}</span></td>
								</tr>
								<tr>
									<td colspan="3"></td>
								</tr>
								<tr>
									<td colspan="2">{{ trans('translate.field/gross-pay') }}</td>
									<td>RM <span class="pull-right">{{ number_format($gross_pay, 2) }}</span></td>
								</tr>
							</tbody>
						</table>
				</div>
			</div>
			<div class="col-sm-6">

				<div class="panel">
					<div class="panel-heading">
						<span class="panel-title">{{ trans('translate.field/deduction') }}</span>
					</div>
						<table class="table table-bordered">
							<tbody>
								<tr>
									<td>{{ trans('translate.field/employee-epf') }}</td>
									<td>RM <span class="pull-right">{{ number_format($epf_employee, 2) }}</span></td>
								</tr>
								<tr>
									<td>{{ trans('translate.field/socso') }}</td>
									<td>RM <span class="pull-right">{{ number_format($socso_employee, 2) }}</span></td>
								</tr>
								<tr>
									<td>{{ trans('translate.field/eis') }}</td>
									<td>RM <span class="pull-right">{{ number_format($eis_employee, 2) }}</span></td>
								</tr>
								<tr>
									<td>{{ trans('translate.field/advance-salary') }}</td>
									<td>RM <span class="pull-right">{{ number_format($adjustments[$subject_types['d']['advance']] ?? 0, 2) }}</span></td>
								</tr>
								<tr>
									<td>{{ trans('translate.field/consumption') }}</td>
									<td>RM <span class="pull-right">{{ number_format($adjustments[$subject_types['d']['consumption']] ?? 0, 2) }}</span></td>
								</tr>
								<tr>
									<td>{{ trans('translate.field/unpaid') }}</td>
									<td>RM <span class="pull-right">{{ number_format($adjustments[$subject_types['d']['unpaid']] ?? 0, 2) }}</span></td>
								</tr>
								<tr>
									<td colspan="2"></td>
								</tr>
								<tr>
									<td>{{ trans('translate.field/total-deduction') }}</td>
									<td>RM <span class="pull-right">{{ number_format($total_deduction, 2) }}</span></td>
								</tr>
							</tbody>
						</table>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="panel">
					<div class="panel-heading">
						<span class="panel-title">{{ trans('translate.field/employer-contribution') }}</span>
					</div>
						<table class="table table-bordered">
							<tbody>
								<tr>
									<td>{{ trans('translate.field/employer-epf') }}</td>
									<td>RM <span class="pull-right">{{ number_format($epf_employer, 2) }}</span></td>
								</tr>
								<tr>
									<td>{{ trans('translate.field/employer-socso') }}</td>
									<td>RM <span class="pull-right">{{ number_format($socso_employer, 2) }}</span></td>
								</tr>
								<tr>
									<td>{{ trans('translate.field/employer-eis') }}</td>
									<td>RM <span class="pull-right">{{ number_format($eis_employer, 2) }}</span></td>
								</tr>
								<tr>
									<td colspan="2"></td>
								</tr>
								<tr>
									<td>{{ trans('translate.field/total-contribution') }}</td>
									<td>RM <span class="pull-right">{{ number_format($epf_employer + $socso_employer + $eis_employer, 2) }}</span></td>
								</tr>
							</tbody>
						</table>
				</div>
			</div>
		</div>
		<div class="invoice-table">
			<table>
				<thead>
					<tr>
						<th>{{__('translate.payslip/date')}}</th>
						<th style="text-align:right">{{__('translate.payslip/service')}}</th>
						<th style="text-align:right">{{__('translate.payslip/product')}}</th>
						<th style="text-align:right">{{__('translate.payslip/ot')}}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($sale_summary as $date => $summary)
					<tr>
						<td>{{$date}} ({{ date('D', strtotime($date)) }})</td>
						<td style="text-align:right">{{$summary['total_service']}}</td>
						<td style="text-align:right">{{$summary['total_product']}}</td>
						<td style="text-align:right">{{$summary['total_ot']}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div> <!-- / .invoice-table -->
	</div> <!-- / .invoice -->

</body>

</html>