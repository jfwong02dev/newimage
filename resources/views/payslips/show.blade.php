<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Payslip - {{ env('APP_NAME') }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<!-- Open Sans font from Google CDN -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">

	<!-- Pixel Admin's stylesheets -->
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/pixel-admin.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/widgets.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/pages.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/rtl.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/themes.min.css') }}" rel="stylesheet" type="text/css">

	<!--[if lt IE 9]>
		<script src="assets/javascripts/ie.min.js"></script>
	<![endif]-->

</head>
<body class="theme-default main-menu-animated page-invoice">

<script>var init = [];</script>

<div id="main-wrapper">
    @include('layouts.inc.topbar')
    @include('layouts.inc.menu')
	<div id="content-wrapper">
		<div class="page-header">
            <h1><i class="fa fa-file-text-o page-header-icon"></i>&nbsp;&nbsp;Payslip</h1>
            <form style="display:none;" name="print-payslip" method="post" action="{{route('payslips.print')}}">
                @csrf
                <input type="hidden" name="subject_types" value="{{ json_encode($subject_types) }}"/>
                <input type="hidden" name="user" value="{{ json_encode($user) }}"/>
                <input type="hidden" name="adjustments" value="{{ json_encode($adjustments) }}"/>
                <input type="hidden" name="epf_employer" value="{{ json_encode($epf_employer) }}"/>
                <input type="hidden" name="epf_employee" value="{{ json_encode($epf_employee) }}"/>
                <input type="hidden" name="total_addition" value="{{ json_encode($total_addition) }}"/>
                <input type="hidden" name="total_deduction" value="{{ json_encode($total_deduction) }}"/>
                <input type="hidden" name="gross_pay" value="{{ json_encode($gross_pay) }}"/>
                <input type="hidden" name="net_total" value="{{ json_encode($net_total) }}"/>
                <input type="hidden" name="comm" value="{{ json_encode($comm) }}"/>
                <input type="hidden" name="sale_summary" value="{{ json_encode($sale_summary) }}"/>
                <input type="hidden" name="date" value="{{ json_encode($date) }}"/>
			</form>
            <a href="#" id="print-btn" class="pull-right btn btn-primary" style="display: block;"><i class="fa fa-print"></i>&nbsp;&nbsp;Print version</a>
		</div> <!-- / .page-header -->
		
		<div class="panel invoice">
			<div class="invoice-header">
				<h3>
					<div class="invoice-logo demo-logo"><img src="{{ asset('demo/logo-big.png') }}" alt="" style="width:100%;height:100%;"></div>
					<div>
						<small><strong>WJ NEW IMAGE</strong></small><br>
						{{ __('translate.pagetitle/salary-voucher') }}
					</div>
				</h3>
				<address>
                    Wj New Image Hair Studio<br>
                    No.17, Pusat Perniagaan Raub,<br>
                    27600 Raub, Pahang.
				</address>
				<div class="invoice-date">
                    <small><strong>Date</strong></small><br> {{ $date }}
				</div>
			</div> <!-- / .invoice-header -->
			<div class="invoice-info">
				<div class="invoice-recipient">
                    <strong>{{ $user->fullname }}</strong><br> {{ $user->ic }}<br> {{ __($glob_position[$user->position]) }}
				</div> <!-- / .invoice-recipient -->
				<div class="invoice-total">
                    <span>RM {{ number_format($net_total, 2) }}</span>
                    TOTAL:
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
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td colspan="2">{{ __('translate.field/basic-pay') }}</td>
                                        <td>RM <span class="pull-right">{{ number_format($user->salary, 2) }}</span></td>
                                    </tr>
                                    <tr>
                                        <td rowspan="5">{{ __('translate.field/commission') }}</td>
                                        <td>O</td>
                                        <td>RM <span class="pull-right">{{ number_format($adjustments[$subject_types['c']['ot']] ?? 0, 2) }}</span></td>
                                    </tr>
                                    <tr>
                                        <td>S</td>
                                        <td>RM <span class="pull-right">{{ number_format($comm->service_comm, 2) }}</span></td>
                                    </tr>
                                    <tr>
                                        <td>P</td>
                                        <td>RM <span class="pull-right">{{ number_format($comm->product_comm, 2) }}</span></td>
                                    </tr>
                                    <tr>
                                        <td>B</td>
                                        <td>RM <span class="pull-right">{{ number_format($adjustments[$subject_types['c']['bonus']] ?? 0, 2) }}</span></td>
                                    </tr>
                                    <tr>
                                        <td>A</td>
                                        <td>RM <span class="pull-right">{{ number_format($adjustments[$subject_types['c']['allowance']] ?? 0, 2) }}</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">{{ trans('translate.field/gross-pay') }}</td>
                                        <td>RM <span class="pull-right">{{ number_format($gross_pay, 2) }}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">

                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title">{{ trans('translate.field/deduction') }}</span>
                        </div>
                        <div class="panel-body">
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
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title">{{ trans('translate.field/employer-contribution') }}</span>
                        </div>
                        <div class="panel-body">
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
			<div class="invoice-table">
				<table>
					<thead>
						<tr>
							<th>{{__('translate.payslip/date')}}</th>
							<th>{{__('translate.payslip/service')}}</th>
							<th>{{__('translate.payslip/product')}}</th>
							<th>{{__('translate.payslip/ot')}}</th>
						</tr>
					</thead>
					<tbody>
                        @foreach($sale_summary as $date => $summary)
						<tr>
							<td>{{$date}} ({{ date('D', strtotime($date)) }})</td>
							<td>{{$summary['total_service']}}</td>
							<td>{{$summary['total_product']}}</td>
							<td>{{$summary['total_ot']}}</td>
                        </tr>
                        @endforeach
					</tbody>
				</table>
			</div> <!-- / .invoice-table -->
		</div> <!-- / .invoice -->
<!-- /5. $INVOICE_PAGE -->

	</div> <!-- / #content-wrapper -->
	<div id="main-menu-bg"></div>
</div> <!-- / #main-wrapper -->

<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
	<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js">'+"<"+"/script>"); </script>
<!-- <![endif]-->
<!--[if lte IE 9]>
	<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
<![endif]-->


<!-- Pixel Admin's javascripts -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/pixel-admin.min.js') }}"></script>

<script type="text/javascript">
    init.push(function () {
        $('#print-btn').click(function(e){
            e.preventDefault();
            $('form[name="print-payslip"]').submit();
        })
    });
	window.PixelAdmin.start(init);
</script>

</body>
</html>