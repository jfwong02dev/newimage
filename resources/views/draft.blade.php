<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Sign Up - {{ env('APP_NAME') }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<!-- Open Sans font from Google CDN -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">

	<!-- Pixel Admin's stylesheets -->
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/pixel-admin.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/pages.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/rtl.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/themes.min.css') }}" rel="stylesheet" type="text/css">

	<!--[if lt IE 9]>
		<script src="assets/javascripts/ie.min.js"></script>
	<![endif]-->


<!-- $DEMO =========================================================================================

	Remove this section on production
-->
	<style>
		#signup-demo {
			position: fixed;
			right: 0;
			bottom: 0;
			z-index: 10000;
			background: rgba(0,0,0,.6);
			padding: 6px;
			border-radius: 3px;
		}
		#signup-demo img { cursor: pointer; height: 40px; }
		#signup-demo img:hover { opacity: .5; }
		#signup-demo div {
			color: #fff;
			font-size: 10px;
			font-weight: 600;
			padding-bottom: 6px;
		}
	</style>
<!-- / $DEMO -->

</head>


<!-- 1. $BODY ======================================================================================
	
	Body

	Classes:
	* 'theme-{THEME NAME}'
	* 'right-to-left'     - Sets text direction to right-to-left
-->
<body class="theme-default page-signup">

<script>
	var init = [];
</script>

	<!-- Page background -->
	<div id="page-signup-bg">
		<!-- Background overlay -->
		<div class="overlay"></div>
		<!-- Replace this with your bg image -->
		<img src="{{ asset('wooden.jpg') }}" alt="">
	</div>
	<!-- / Page background -->

	<!-- Container -->
	<div class="signup-container">
		<!-- Header -->
		<div class="signup-header">
			<a href="{{ URL::to('/') }}" class="logo">
				<img src="{{ asset('demo/logo-big.png') }}" alt="" style="margin-top: -5px;">&nbsp;
				{{ env('APP_NAME') }}
			</a> <!-- / .logo -->
			<div class="slogan">
				Simple. Flexible. Powerful.
			</div> <!-- / .slogan -->
		</div>
		<!-- / Header -->

		<!-- Form -->
		<div class="signup-form">
            <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}" id="signup-form_id">
                @csrf
				
				<div class="signup-text">
					<span>Create an account</span>
				</div>

				<div class="form-group w-icon">
					<input type="text" name="name" id="name" class="form-control input-lg{{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Username" autocomplete="off">
					<span class="fa fa-user signup-form-icon"></span>
				</div>

				<div class="form-group w-icon">
					<input type="text" name="email" id="email" class="form-control input-lg{{ $errors->has('email') ? ' has-error' : '' }}" placeholder="E-mail" autocomplete="off">
					<span class="fa fa-envelope signup-form-icon"></span>
				</div>

				<div class="form-group w-icon">
					<input type="password" name="password" id="password" class="form-control input-lg{{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Password">
					<span class="fa fa-lock signup-form-icon"></span>
				</div>

				<div class="form-group w-icon">
					<input type="password" name="password_confirmation" id="password-confirm" class="form-control input-lg" placeholder="Confirm Password">
					<span class="fa fa-lock signup-form-icon"></span>
				</div>

				<div class="form-actions">
					<input type="submit" value="SIGN UP" class="signup-btn bg-primary">
				</div>
			</form>
			<!-- / Form -->
		</div>
		<!-- Right side -->
	</div>

		<div class="have-account">
		Already have an account? <a href="{{ URL::to('/') }}">Sign In</a>
	</div>


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
	// Resize BG
	init.push(function () {
		var $ph  = $('#page-signup-bg'),
		    $img = $ph.find('> img');

		$(window).on('resize', function () {
			$img.attr('style', '');
			if ($img.height() < $ph.height()) {
				$img.css({
					height: '100%',
					width: 'auto'
				});
			}
		});

		$("#signup-form_id").validate({ focusInvalid: true, errorPlacement: function () {} });

		// Validate name
		$("#name").rules("add", {
			required: true,
			minlength: 1
		});

		// Validate email
		$("#email").rules("add", {
			required: true,
			email: true
		});

		// Validate password
		$("#password").rules("add", {
			required: true,
			minlength: 6
		});

        // Validate password
		$("#password-confirm").rules("add", {
			required: true,
			minlength: 6
		});
	});

	window.PixelAdmin.start(init);
</script>

</body>
</html>
