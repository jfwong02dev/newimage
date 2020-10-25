<!-- 4. $MAIN_MENU =================================================================================

		Main menu
		
		Notes:
		* to make the menu item active, add a class 'active' to the <li>
		  example: <li class="active">...</li>
		* multilevel submenu example:
			<li class="mm-dropdown">
			  <a href="#"><span class="mm-text">Submenu item text 1</span></a>
			  <ul>
				<li>...</li>
				<li class="mm-dropdown">
				  <a href="#"><span class="mm-text">Submenu item text 2</span></a>
				  <ul>
					<li>...</li>
					...
				  </ul>
				</li>
				...
			  </ul>
			</li>
-->
<div id="main-menu" role="navigation">
	<div id="main-menu-inner">
		<div class="menu-content top" id="menu-content-demo">
			<!-- Menu custom content demo
					 CSS:        styles/pixel-admin-less/demo.less or styles/pixel-admin-scss/_demo.scss
					 Javascript: html/assets/demo/demo.js
				 -->
			<div>
				<div class="text-bg"><span class="text-slim">Welcome,</span> <span class="text-semibold">{{Auth::user()->username}}</span></div>

				<img src="{{ asset('demo/avatars/1.jpg') }}" alt="" class="">
				<div class="btn-group">
					<a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-envelope"></i></a>
					<a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-user"></i></a>
					<a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-cog"></i></a>
					<a href="" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-xs btn-danger btn-outline dark"><i class="fa fa-power-off"></i></a>
				</div>
			</div>
		</div>
		<ul class="navigation">
			<li>
				<a href="{{ URL::to('/dashboard') }}"><i class="menu-icon fa fa-dashboard"></i><span class="mm-text">{{__('translate.menu/dashboard')}}</span></a>
			</li>
			<li>
				<a href="{{ route('sales.index') }}"><i class="menu-icon fa fa-tasks"></i><span class="mm-text">{{__('translate.menu/sales')}}</span></a>
			</li>
			<li class="mm-dropdown">
				<a href="#"><i class="menu-icon fa fa-file-text-o"></i><span class="mm-text">{{__('translate.menu/report')}}</span></a>
				<ul>
					<li>
						<a tabindex="-1" href="{{ route('report.sales-details') }}"><span class="mm-text">{{__('translate.menu/report/sales-details')}}</span></a>
					</li>
					<li>
						<a tabindex="-1" href="{{ route('report.sales-compare') }}"><span class="mm-text">{{__('translate.menu/report/sales-compare')}}</span></a>
					</li>
					<li>
						<a tabindex="-1" href="{{ route('report.monthly-sales') }}"><span class="mm-text">{{__('translate.menu/report/monthly-sales')}}</span></a>
					</li>
					<li>
						<a tabindex="-1" href="{{ route('report.yearly-sales') }}"><span class="mm-text">{{__('translate.menu/report/yearly-sales')}}</span></a>
					</li>
					<li>
						<a tabindex="-1" href="{{ route('report.all-sales') }}"><span class="mm-text">{{__('translate.menu/report/all-sales')}}</span></a>
					</li>
				</ul>
			</li>
			<li class="mm-dropdown">
				<a href="#"><i class="menu-icon fa fa-cogs"></i><span class="mm-text">{{__('translate.menu/management')}}</span></a>
				<ul>
					<li>
						<a tabindex="-1" href="{{ route('users.index') }}"><span class="mm-text">{{__('translate.menu/management/user')}}</span></a>
					</li>
					<li>
						<a tabindex="-1" href="{{ route('payslips.index') }}"><span class="mm-text">{{__('translate.menu/management/payslip')}}</span></a>
					</li>
					<li>
						<a tabindex="-1" href="{{ route('salaries.index') }}"><span class="mm-text">{{__('translate.menu/management/adjustment')}}</span></a>
					</li>
					<li>
						<a tabindex="-1" href="{{ route('services.index') }}"><span class="mm-text">{{__('translate.menu/management/service')}}</span></a>
					</li>
					<li>
						<a tabindex="-1" href="{{ route('products.index') }}"><span class="mm-text">{{__('translate.menu/management/product')}}</span></a>
					</li>
				</ul>
			</li>
		</ul> <!-- / .navigation -->
		<div class="menu-content">
			<a href="{{ route('sales.create') }}" class="btn btn-primary btn-block btn-outline dark">{{__('translate.button/sales')}}</a>
		</div>
	</div> <!-- / #main-menu-inner -->
</div> <!-- / #main-menu -->
<!-- /4. $MAIN_MENU -->