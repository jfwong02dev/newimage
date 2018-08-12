<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Profile - {{ env('APP_NAME') }}</title>
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
    <link rel="shortcut icon" href="{{{ asset('j-icon.png') }}}">

    <!--[if lt IE 9]>
		<script src="assets/javascripts/ie.min.js"></script>
	<![endif]-->

</head>

<body class="theme-default main-menu-animated page-profile">

<script>var init = [];</script>

<div id="main-wrapper">
    @include('layouts.inc.topbar')
    @include('layouts.inc.menu')

	<div id="content-wrapper">
<!-- 5. $PROFILE ===================================================================================

		Profile
-->
		<div class="profile-full-name">
			<span class="text-semibold">{{$user->fullname}}</span>'s profile
		</div>
	 	<div class="profile-row">
			<div class="left-col">
				<div class="profile-block">
					<div class="panel profile-photo">
						<img src="{{ asset('demo/avatars/5.jpg') }}" alt="">
					</div><br>
					<div class="btn btn-success"><i class="fa fa-user"></i>&nbsp;&nbsp;{{__($position[$user->position])}}</div>
				</div>
				
				<div class="panel panel-transparent">
					<div class="panel-heading">
						<span class="panel-title">About me</span>
					</div>
					<div class="list-group">
						<a href="#" class="list-group-item"><i class="profile-list-icon fa fa-angle-double-right"></i> {{$user->uid}}</a>
						<a href="#" class="list-group-item"><i class="profile-list-icon fa fa-angle-double-right"></i> {{$user->username}}</a>
						<a href="#" class="list-group-item"><i class="profile-list-icon fa fa-angle-double-right"></i> {{$user->gender}}</a>
						<a href="#" class="list-group-item"><i class="profile-list-icon fa fa-angle-double-right"></i> {{$user->ic}}</a>
						<a href="#" class="list-group-item"><i class="profile-list-icon fa fa-angle-double-right"></i> {{$user->email}}</a>
						<a href="#" class="list-group-item"><i class="profile-list-icon fa fa-angle-double-right"></i> {{$user->mobile}}</a>
						<a href="#" class="list-group-item"><i class="profile-list-icon fa fa-angle-double-right"></i> {{$user->address}}</a>
					</div>
				</div>
			</div>
			<div class="right-col">

				<hr class="profile-content-hr no-grid-gutter-h">
				
				<div class="profile-content">

					<ul id="profile-tabs" class="nav nav-tabs">
						<li class="active">
							<a href="#profile-tabs-board" data-toggle="tab">Board</a>
						</li>
						<li>
							<a href="#profile-tabs-activity" data-toggle="tab">Timeline</a>
						</li>
						<li>
							<a href="#profile-tabs-followers" data-toggle="tab">Followers</a>
						</li>
						<li>
							<a href="#profile-tabs-following" data-toggle="tab">Following</a>
						</li>
					</ul>

					<div class="tab-content tab-content-bordered panel-padding">
						<div class="widget-article-comments tab-pane panel no-padding no-border fade in active" id="profile-tabs-board">

							<div class="comment">
								<img src="assets/demo/avatars/1.jpg" alt="" class="comment-avatar">
								<div class="comment-body">
									<form action="" id="leave-comment-form" class="comment-text no-padding no-border">
										<textarea class="form-control" rows="1"></textarea>
										<div class="expanding-input-hidden" style="margin-top: 10px;">
											<label class="checkbox-inline pull-left">
												<input type="checkbox" class="px">
												<span class="lbl">Private message</span>
											</label>
											<button class="btn btn-primary pull-right">Leave Message</button>
										</div>
									</form>
								</div> <!-- / .comment-body -->
							</div>

							<hr class="no-panel-padding-h panel-wide">

							<div class="comment">
								<img src="assets/demo/avatars/2.jpg" alt="" class="comment-avatar">
								<div class="comment-body">
									<div class="comment-text">
										<div class="comment-heading">
											<a href="#" title="">Robert Jang</a><span>14 hours ago</span>
										</div>
										Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.
									</div>
									<div class="comment-footer">
										<a href="#"><i class="fa fa-thumbs-o-up"></i></a>&nbsp;&nbsp;
										<a href="#"><i class="fa fa-thumbs-o-down"></i></a>
										&nbsp;&nbsp;·&nbsp;&nbsp;
										<a href="#">Reply</a>
									</div>
								</div> <!-- / .comment-body -->

								<div class="comment">
									<img src="assets/demo/avatars/4.jpg" alt="" class="comment-avatar">
									<div class="comment-body">
										<div class="comment-text">
											<div class="comment-heading">
												<a href="#" title="">Timothy Owens</a><span>14 hours ago</span>
											</div>
											Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.
										</div>
										<div class="comment-footer">
											<a href="#"><i class="fa fa-thumbs-o-up"></i></a>&nbsp;&nbsp;
											<a href="#"><i class="fa fa-thumbs-o-down"></i></a>
											&nbsp;&nbsp;·&nbsp;&nbsp;
											<a href="#">Reply</a>
										</div>
									</div> <!-- / .comment-body -->
								</div> <!-- / .comment -->

								<div class="comment">
									<img src="assets/demo/avatars/5.jpg" alt="" class="comment-avatar">
									<div class="comment-body">
										<div class="comment-text">
											<div class="comment-heading">
												<a href="#" title="">Denise Steiner</a><span>14 hours ago</span>
											</div>
											Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.
										</div>
										<div class="comment-footer">
											<a href="#"><i class="fa fa-thumbs-o-up"></i></a>&nbsp;&nbsp;
											<a href="#"><i class="fa fa-thumbs-o-down"></i></a>
											&nbsp;&nbsp;·&nbsp;&nbsp;
											<a href="#">Reply</a>
										</div>
									</div> <!-- / .comment-body -->

									<div class="comment">
										<img src="assets/demo/avatars/1.jpg" alt="" class="comment-avatar">
										<div class="comment-body">
											<div class="comment-text">
												<div class="comment-heading">
													<a href="#" title="">John Doe</a><span>14 hours ago</span>
												</div>
												Lorem ipsum dolor sit amet, consectetur adipisicing elit.
											</div>
											<div class="comment-footer">
												<a href="#"><i class="fa fa-thumbs-o-up"></i></a>&nbsp;&nbsp;
												<a href="#"><i class="fa fa-thumbs-o-down"></i></a>
												&nbsp;&nbsp;·&nbsp;&nbsp;
												<a href="#">Reply</a>
											</div>
										</div> <!-- / .comment-body -->
									</div> <!-- / .comment -->
								</div> <!-- / .comment -->
							</div> <!-- / .comment -->

							<div class="comment">
								<img src="assets/demo/avatars/3.jpg" alt="" class="comment-avatar">
								<div class="comment-body">
									<div class="comment-text">
										<div class="comment-heading">
											<a href="#" title="">Michelle Bortz</a><span>14 hours ago</span>
										</div>
										Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.
									</div>
									<div class="comment-footer">
										<a href="#"><i class="fa fa-thumbs-o-up"></i></a>&nbsp;&nbsp;
										<a href="#"><i class="fa fa-thumbs-o-down"></i></a>
										&nbsp;&nbsp;·&nbsp;&nbsp;
										<a href="#">Reply</a>
									</div>
								</div> <!-- / .comment-body -->
							</div> <!-- / .comment -->

							<div class="comment">
								<img src="assets/demo/avatars/2.jpg" alt="" class="comment-avatar">
								<div class="comment-body">
									<div class="comment-text">
										<div class="comment-heading">
											<a href="#" title="">Robert Jang</a><span>14 hours ago</span>
										</div>
										Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.
									</div>
									<div class="comment-footer">
										<a href="#"><i class="fa fa-thumbs-o-up"></i></a>&nbsp;&nbsp;
										<a href="#"><i class="fa fa-thumbs-o-down"></i></a>
										&nbsp;&nbsp;·&nbsp;&nbsp;
										<a href="#">Reply</a>
									</div>
								</div> <!-- / .comment-body -->

								<div class="comment">
									<img src="assets/demo/avatars/4.jpg" alt="" class="comment-avatar">
									<div class="comment-body">
										<div class="comment-text">
											<div class="comment-heading">
												<a href="#" title="">Timothy Owens</a><span>14 hours ago</span>
											</div>
											Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.
										</div>
										<div class="comment-footer">
											<a href="#"><i class="fa fa-thumbs-o-up"></i></a>&nbsp;&nbsp;
											<a href="#"><i class="fa fa-thumbs-o-down"></i></a>
											&nbsp;&nbsp;·&nbsp;&nbsp;
											<a href="#">Reply</a>
										</div>
									</div> <!-- / .comment-body -->
								</div> <!-- / .comment -->

								<div class="comment">
									<img src="assets/demo/avatars/5.jpg" alt="" class="comment-avatar">
									<div class="comment-body">
										<div class="comment-text">
											<div class="comment-heading">
												<a href="#" title="">Denise Steiner</a><span>14 hours ago</span>
											</div>
											Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.
										</div>
										<div class="comment-footer">
											<a href="#"><i class="fa fa-thumbs-o-up"></i></a>&nbsp;&nbsp;
											<a href="#"><i class="fa fa-thumbs-o-down"></i></a>
											&nbsp;&nbsp;·&nbsp;&nbsp;
											<a href="#">Reply</a>
										</div>
									</div> <!-- / .comment-body -->

									<div class="comment">
										<img src="assets/demo/avatars/1.jpg" alt="" class="comment-avatar">
										<div class="comment-body">
											<div class="comment-text">
												<div class="comment-heading">
													<a href="#" title="">John Doe</a><span>14 hours ago</span>
												</div>
												Lorem ipsum dolor sit amet, consectetur adipisicing elit.
											</div>
											<div class="comment-footer">
												<a href="#"><i class="fa fa-thumbs-o-up"></i></a>&nbsp;&nbsp;
												<a href="#"><i class="fa fa-thumbs-o-down"></i></a>
												&nbsp;&nbsp;·&nbsp;&nbsp;
												<a href="#">Reply</a>
											</div>
										</div> <!-- / .comment-body -->
									</div> <!-- / .comment -->
								</div> <!-- / .comment -->
							</div> <!-- / .comment -->

							<div class="comment">
								<img src="assets/demo/avatars/3.jpg" alt="" class="comment-avatar">
								<div class="comment-body">
									<div class="comment-text">
										<div class="comment-heading">
											<a href="#" title="">Michelle Bortz</a><span>14 hours ago</span>
										</div>
										Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.
									</div>
									<div class="comment-footer">
										<a href="#"><i class="fa fa-thumbs-o-up"></i></a>&nbsp;&nbsp;
										<a href="#"><i class="fa fa-thumbs-o-down"></i></a>
										&nbsp;&nbsp;·&nbsp;&nbsp;
										<a href="#">Reply</a>
									</div>
								</div> <!-- / .comment-body -->
							</div> <!-- / .comment -->

						</div> <!-- / .tab-pane -->
						<div class="tab-pane fade" id="profile-tabs-activity">
							<div class="timeline">
								<!-- Timeline header -->
								<div class="tl-header now">Now</div>

								<div class="tl-entry">
									<div class="tl-time">
										1h ago
									</div>
									<div class="tl-icon bg-warning"><i class="fa fa-envelope"></i></div>
									<div class="panel tl-body">
										<h4 class="text-warning">Lorem ipsum dolor sit amet</h4>
										Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
									</div> <!-- / .tl-body -->
								</div> <!-- / .tl-entry -->

								<div class="tl-entry left">
									<div class="tl-time">
										2h ago
									</div>
									<div class="tl-icon bg-success"><i class="fa fa-picture-o"></i></div>
									<div class="panel tl-body">
										<a href="#">Denise Steiner</a> shared an image on <a href="#">The Gallery</a>
										<div class="tl-wide text-center" style="padding: 10px;margin-top:15px;margin-bottom: 15px;background: #f1f1f1">
											<img src="assets/demo/signin-bg-5.jpg" alt="" style="max-height: 150px;max-width: 100%;">
										</div>
										<i class="text-muted text-sm">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</i>
									</div> <!-- / .tl-body -->
								</div> <!-- / .tl-entry -->

								<div class="tl-entry">
									<div class="tl-time">
										3h ago
									</div>
									<div class="tl-icon bg-success"><img src="assets/demo/avatars/2.jpg" alt=""></div>
									<div class="panel tl-body">
										<a href="#">Robert Jang</a> commented on <a href="#">The Article</a>
										<div class="well well-sm" style="margin: 10px 0 0 0;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
									</div> <!-- / .tl-body -->
								</div> <!-- / .tl-entry -->

								<div class="tl-entry left">
									<div class="tl-time">
										4h ago
									</div>
									<div class="tl-icon bg-dark-gray"><i class="fa fa-check"></i></div>
									<div class="panel tl-body">
										<img src="assets/demo/avatars/5.jpg" alt="" class="rounded" style=" width: 20px;height: 20px;margin-top: -2px;">&nbsp;&nbsp;<a href="#">Denise Steiner</a> followed <a href="#">Johg Doe</a>
									</div> <!-- / .tl-body -->
								</div> <!-- / .tl-entry -->

								<!-- Timeline header -->
								<div class="tl-header">Yesterday</div>

								<div class="tl-entry">
									<div class="tl-time">
										9:02 pm
									</div>
									<div class="tl-icon bg-info"><i class="fa fa-comment"></i></div>
									<div class="panel tl-body">
										<a href="#">Denise Steiner</a> liked a comment on <a href="#">Some Article</a>
										<div style="margin-top: 10px;" class="text-sm">
											<img src="assets/demo/avatars/3.jpg" alt="" class="rounded" style=" width: 20px;height: 20px;margin-top: -2px;">&nbsp;&nbsp;<a href="#">Michelle Bortz</a> commented 2 days ago
											<div class="well well-sm" style="margin: 6px 0 0 0;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
										</div>
									</div> <!-- / .tl-body -->
								</div> <!-- / .tl-entry -->

								<div class="tl-entry left">
									<div class="tl-time">
										5:47 pm
									</div>
									<div class="panel tl-body">
										Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
									</div> <!-- / .tl-body -->
								</div> <!-- / .tl-entry -->

								<div class="tl-entry">
									<div class="tl-time">
										2:35 pm
									</div>
									<div class="tl-icon bg-danger"><i class="fa fa-heart"></i></div>
									<div class="panel tl-body">
										<a href="#">Denise Steiner</a> liked <a href="#">Shop Item</a>
									</div> <!-- / .tl-body -->
								</div> <!-- / .tl-entry -->

								<div class="tl-entry left">
									<div class="tl-time">
										11:21 am
									</div>
									<div class="panel tl-body">
										<h4 class="text-danger">Lorem ipsum dolor sit amet</h4>
										Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
									</div> <!-- / .tl-body -->
								</div> <!-- / .tl-entry -->

							</div> <!-- / .timeline -->
						</div> <!-- / .tab-pane -->
						<div class="tab-pane fade widget-followers" id="profile-tabs-followers">
							<div class="follower">
								<img src="assets/demo/avatars/1.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-success"><i class="fa fa-check"></i><span>&nbsp;&nbsp;Following</span></a>
									</div>
									<a href="#" class="follower-name">John Doe</a><br>
									<a href="#" class="follower-username">@jdoe</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/3.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Michelle Bortz</a><br>
									<a href="#" class="follower-username">@mbortz</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/4.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Timothy Owens</a><br>
									<a href="#" class="follower-username">@towens</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/5.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Denise Steiner</a><br>
									<a href="#" class="follower-username">@dsteiner</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/1.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-success"><i class="fa fa-check"></i><span>&nbsp;&nbsp;Following</span></a>
									</div>
									<a href="#" class="follower-name">John Doe</a><br>
									<a href="#" class="follower-username">@jdoe</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/3.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Michelle Bortz</a><br>
									<a href="#" class="follower-username">@mbortz</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/4.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Timothy Owens</a><br>
									<a href="#" class="follower-username">@towens</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/5.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Denise Steiner</a><br>
									<a href="#" class="follower-username">@dsteiner</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/1.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-success"><i class="fa fa-check"></i><span>&nbsp;&nbsp;Following</span></a>
									</div>
									<a href="#" class="follower-name">John Doe</a><br>
									<a href="#" class="follower-username">@jdoe</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/3.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Michelle Bortz</a><br>
									<a href="#" class="follower-username">@mbortz</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/4.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Timothy Owens</a><br>
									<a href="#" class="follower-username">@towens</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/5.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Denise Steiner</a><br>
									<a href="#" class="follower-username">@dsteiner</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/1.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-success"><i class="fa fa-check"></i><span>&nbsp;&nbsp;Following</span></a>
									</div>
									<a href="#" class="follower-name">John Doe</a><br>
									<a href="#" class="follower-username">@jdoe</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/3.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Michelle Bortz</a><br>
									<a href="#" class="follower-username">@mbortz</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/4.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Timothy Owens</a><br>
									<a href="#" class="follower-username">@towens</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/5.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Denise Steiner</a><br>
									<a href="#" class="follower-username">@dsteiner</a>
								</div>
							</div>
						</div> <!-- / .tab-pane -->
						<div class="tab-pane fade widget-followers" id="profile-tabs-following">
							<div class="follower">
								<img src="assets/demo/avatars/1.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-success"><i class="fa fa-check"></i><span>&nbsp;&nbsp;Following</span></a>
									</div>
									<a href="#" class="follower-name">John Doe</a><br>
									<a href="#" class="follower-username">@jdoe</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/3.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Michelle Bortz</a><br>
									<a href="#" class="follower-username">@mbortz</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/4.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Timothy Owens</a><br>
									<a href="#" class="follower-username">@towens</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/5.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Denise Steiner</a><br>
									<a href="#" class="follower-username">@dsteiner</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/1.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-success"><i class="fa fa-check"></i><span>&nbsp;&nbsp;Following</span></a>
									</div>
									<a href="#" class="follower-name">John Doe</a><br>
									<a href="#" class="follower-username">@jdoe</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/3.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Michelle Bortz</a><br>
									<a href="#" class="follower-username">@mbortz</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/4.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Timothy Owens</a><br>
									<a href="#" class="follower-username">@towens</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/5.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Denise Steiner</a><br>
									<a href="#" class="follower-username">@dsteiner</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/1.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-success"><i class="fa fa-check"></i><span>&nbsp;&nbsp;Following</span></a>
									</div>
									<a href="#" class="follower-name">John Doe</a><br>
									<a href="#" class="follower-username">@jdoe</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/3.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Michelle Bortz</a><br>
									<a href="#" class="follower-username">@mbortz</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/4.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Timothy Owens</a><br>
									<a href="#" class="follower-username">@towens</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/5.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Denise Steiner</a><br>
									<a href="#" class="follower-username">@dsteiner</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/1.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-success"><i class="fa fa-check"></i><span>&nbsp;&nbsp;Following</span></a>
									</div>
									<a href="#" class="follower-name">John Doe</a><br>
									<a href="#" class="follower-username">@jdoe</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/3.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Michelle Bortz</a><br>
									<a href="#" class="follower-username">@mbortz</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/4.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Timothy Owens</a><br>
									<a href="#" class="follower-username">@towens</a>
								</div>
							</div>

							<div class="follower">
								<img src="assets/demo/avatars/5.jpg" alt="" class="follower-avatar">
								<div class="body">
									<div class="follower-controls">
										<a href="#" class="btn btn-sm btn-outline">Follow</a>
									</div>
									<a href="#" class="follower-name">Denise Steiner</a><br>
									<a href="#" class="follower-username">@dsteiner</a>
								</div>
							</div>
						</div> <!-- / .tab-pane -->
					</div> <!-- / .tab-content -->
				</div>
			</div>
		</div>
		

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
		$('#profile-tabs').tabdrop();

		$("#leave-comment-form").expandingInput({
			target: 'textarea',
			hidden_content: '> div',
			placeholder: 'Write message',
			onAfterExpand: function () {
				$('#leave-comment-form textarea').attr('rows', '3').autosize();
			}
		});
	})
	window.PixelAdmin.start(init);
</script>

</body>
</html>