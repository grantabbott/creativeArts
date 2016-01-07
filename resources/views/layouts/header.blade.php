
			<!-- BEGIN CONTENT HEADER -->
            <div class="header content rows-content-header">
			
				<!-- Button mobile view to collapse sidebar menu -->
				<button class="button-menu-mobile show-sidebar">
					<i class="fa fa-bars"></i>
				</button>
				
				<!-- BEGIN NAVBAR CONTENT-->				
				<div class="navbar navbar-default flip" role="navigation">
					<div class="container">
						<!-- Navbar header -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<i class="fa fa-angle-double-down"></i>
							</button>
							@if (in_array('hide_sidebar',$assets))
							<a href="/" class="navbar-brand" style="margin-left:5px;"><i class="fa fa-ticket fa-lg" style="margin-right:5px;"></i> <strong>{!! config('config.application_name') !!}</strong></a>
							@endif
						</div><!-- End div .navbar-header -->
						
						<!-- Navbar collapse -->	
						<div class="navbar-collapse collapse">
							<!-- Left navbar -->
							@if (in_array('hide_sidebar',$assets))
							<ul class="nav navbar-nav">
								@if(Auth::check() && !Entrust::hasRole('user'))
								<li><a href="/dashboard">Dashboard</a></li>
								@endif
								@if(config('config.show_business_hour'))
									<li><a href="/business-hour">Business Hour</a></li>
								@endif
							</ul>
							@endif

							@if(count($pages))
								<ul class="nav navbar-nav">
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">{!! trans('messages.Pages') !!} <i class="fa fa-chevron-down i-xs"></i></a>
									<ul class="dropdown-menu animated half flipInX">
										@foreach($pages as $page)
										<li><a href="{!! URL::to('/pages/'.$page->page_slug) !!}">{!! $page->page_title !!}</a></li>
										@endforeach
									</ul>
								</li>
								</ul>
							@endif

							<!-- Right navbar -->
							<ul class="nav navbar-nav navbar-right top-navbar">

								@if(config('config.facebook_page_link'))
									<li><a href="{!! URL::to(config('config.facebook_page_link')) !!}" data-toggle="tooltip" title="Facebook" target=_blank><i class="fa fa-facebook-official fa-lg " style="color:#3b5998;"></i></a></li>
								@endif
								@if(config('config.twitter_page_link'))
									<li><a href="{!! URL::to(config('config.twitter_page_link')) !!}" data-toggle="tooltip" title="Twitter" target=_blank><i class="fa fa-twitter-square fa-lg " style="color:#00aced;"></i></a></li>
								@endif


							@if (Auth::check())
								@if(!Entrust::hasRole('user'))

								<li>
									<a href="/todo" data-toggle='modal' data-target='#myTodoModal' ><i class="fa fa-list-ul"></i> To do</a>
								</li>
								
								<li class="dropdown">
									<a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown">Lang ({!! config('config.default_language') !!}) <i class="fa fa-chevron-down i-xs"></i></a>
									<ul class="dropdown-menu animated half flipInX">
										@if(Entrust::can('set_language'))
										@foreach($languages as $key => $language)
										<li><a href="{!! URL::to('/setLanguage/'.$key) !!}">{!! $language." (".$key.")" !!}</a></li>
										@endforeach
										@endif
										@if(Entrust::can('manage_language'))
										<li><a href="/language">Add More Language</a></li>
										@endif
									</ul>
								</li>

								@endif
																
								<!-- Dropdown User session -->
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">{!! trans('messages.Hello') !!}, <strong>{!! Auth::user()->name !!}</strong> <i class="fa fa-chevron-down i-xs"></i></a>
									<ul class="dropdown-menu animated half flipInX">
										@if(isset(Auth::user()->username))
											<li><a href="{!! URL::to('/change_password') !!}">Change Password</a></li>
										@endif
										<li><a href="{!! URL::to('/logout') !!}">Logout</a></li>
									</ul>
								</li>
							@endif
								
								<!-- End Dropdown User session -->
							</ul>
						</div><!-- End div .navbar-collapse -->
					</div><!-- End div .container -->
				</div>
				<!-- END NAVBAR CONTENT-->
            </div>
			<!-- END CONTENT HEADER -->
				