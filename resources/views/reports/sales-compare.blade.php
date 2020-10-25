<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="gt-ie8 gt-ie9 not-ie">
<!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>{{__('translate.pagetitle/sales-compare')}} - {{ env('APP_NAME') }}</title>
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

	<!-- favicon -->
	<link rel="shortcut icon" href="{{ asset('j-icon.png') }}">

	<!--[if lt IE 9]>
		<script src="assets/javascripts/ie.min.js"></script>
	<![endif]-->

</head>

<body class="theme-default main-menu-animated page-invoice">

	<script>
		var init = [];
	</script>

	<div id="main-wrapper">
		@include('layouts.inc.topbar')
		@include('layouts.inc.menu')
		<div id="content-wrapper">
			<div class="page-header">
				<h1><i class="fa fa-file-text-o page-header-icon"></i>&nbsp;&nbsp;{{__('translate.pagetitle/sales-compare')}}</h1>
			</div> <!-- / .page-header -->

			<div class="panel invoice">
				<div class="invoice-header">
					<h3>
						<div class="invoice-logo demo-logo"><img src="{{ asset('demo/logo-big.png') }}" alt="" style="width:100%;height:100%;"></div>
						<div>
							<small><strong>{{env('APP_NAME')}}</strong></small><br>
							{{ __('translate.pagetitle/sales-compare') }}
						</div>
					</h3>
					<address>
						{!! __('translate.company/address', ['br' => '<br />']) !!}
					</address>
					<div class="invoice-date">
					</div>
				</div> <!-- / .invoice-header -->

				<br />

				<div class="row">
					<form action="{{route('report.sales-compare')}}" id="sales-compare-form" method="get" class="form-horizontal">
						<div class="col-sm-6">
							<div class="form-group">
								<div class="col-sm-12">
									<select class="form-control" name="first_month" id="first-month">
										<option></option>
										@foreach($all_months as $month)
										<option value="{{$month}}">{{$month}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div id="first-month-table"></div>

						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<div class="col-sm-12">
									<select class="form-control" name="second_month" id="second-month">
										<option></option>
										@foreach($all_months as $month)
										<option value="{{$month}}">{{$month}}</option>
										@endforeach
									</select>
								</div>

							</div>
							<div id="second-month-table"></div>
						</div>
					</form>

				</div>
			</div> <!-- / .invoice -->
			<!-- /5. $INVOICE_PAGE -->

		</div> <!-- / #content-wrapper -->
		<div id="main-menu-bg"></div>
	</div> <!-- / #main-wrapper -->

	<!-- Get jQuery from Google CDN -->
	<!--[if !IE]> -->
	<script type="text/javascript">
		window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js">' + "<" + "/script>");
	</script>
	<!-- <![endif]-->
	<!--[if lte IE 9]>
	<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
<![endif]-->


	<!-- Pixel Admin's javascripts -->
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/pixel-admin.min.js') }}"></script>

	<script type="text/javascript">
		let first_month, second_month, variance
		var sales_by_month = <?php echo json_encode($sales_by_month); ?>;
		init.push(function() {
			$('#first-month').select2({
				allowClear: true,
				placeholder: 'Select'
			}).change(function() {
				first_month = $(this).val();
				generate_dom();
			});
			$('#second-month').select2({
				allowClear: true,
				placeholder: 'Select'
			}).change(function() {
				second_month = $(this).val();
				generate_dom();
			});
		});

		function generate_dom() {

			var mesg1 = '';
			if (typeof(sales_by_month[first_month]) !== 'undefined') {
				mesg1 += '<table class="table table-bordered">';
				mesg1 += '<tbody>';
				mesg1 += '<tr>';
				mesg1 += '<td>Sales</td>';
				mesg1 += '<td>RM <span class="pull-right">' + Number(sales_by_month[first_month]).toFixed(2) + '</span></td>';
				mesg1 += '</tr>';
				mesg1 += '<tr>';
				mesg1 += '<td>Net Sales</td>';
				mesg1 += '<td>RM <span class="pull-right">' + Number(sales_by_month[first_month]).toFixed(2) + '</span></td>';
				mesg1 += '</tr>';
				mesg1 += '</tbody>';
				mesg1 += '</table>';
			}

			var mesg2 = '';
			if (typeof(sales_by_month[second_month]) !== 'undefined') {
				mesg2 += '<table class="table table-bordered">';
				mesg2 += '<tbody>';
				mesg2 += '<tr>';
				mesg2 += '<td>Sales</td>';
				mesg2 += '<td>RM <span class="pull-right">' + Number(sales_by_month[second_month]).toFixed(2) + '</span></td>';
				mesg2 += '</tr>';
				mesg2 += '<tr>';
				mesg2 += '<td>Net Sales</td>';
				mesg2 += '<td>RM <span class="pull-right">' + Number(sales_by_month[second_month]).toFixed(2) + '</span></td>';
				mesg2 += '</tr>';

				if (typeof sales_by_month[first_month] !== 'undefined') {
					let variance = (sales_by_month[second_month] - sales_by_month[first_month]) / sales_by_month[first_month] * 100

					mesg2 += '<tr>';
					mesg2 += '<td colspan="2"></td>';
					mesg2 += '</tr>';
					mesg2 += '<tr>';
					mesg2 += '<td>Variance</td>';
					mesg2 += '<td><span class="pull-right">' + Number(variance).toFixed(0) + '%</span></td>';
					mesg2 += '</tr>';
				}

				mesg2 += '</tbody>';
				mesg2 += '</table>';
			}

			$('#first-month-table').html(mesg1);
			$('#second-month-table').html(mesg2);
		}

		window.PixelAdmin.start(init);
	</script>

</body>

</html>