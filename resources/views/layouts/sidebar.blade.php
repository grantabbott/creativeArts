
		<!-- BEGIN SIDEBAR -->
		<div class="left side-menu">
			
			
            <div class="body rows scroll-y">
				
				<!-- Scrolling sidebar -->
                <div class="sidebar-inner slimscroller">
				
				@include('auth.user_detail',['user' => Auth::user(),'edit_profile' => 1, 'role' => 1,'welcome' => '1', 'logout' => '1', 'last_login' => '1'])

				@if(config('constants.MODE') == 0)
					<center><a href="http://codecanyon.net/item/x/{!! config('constants.ITEM_CODE') !!}?ref=wmlabs" class="btn btn-success btn-md" role="button">Buy Now</a></center>
				@endif
					<!-- Sidebar menu -->				
					<div id="sidebar-menu">
						<ul>
							<li><a href="{!! URL::to('/dashboard') !!}"><i class="fa fa-home icon"></i> {!! trans('messages.Dashboard') !!}</a></li>
							@if(Entrust::can('manage_user'))
							<li><a href=""><i class="fa fa-users icon"></i><i class="fa fa-angle-double-down i-right"></i> {!! trans('messages.User') !!}</a>
								<ul>
									@if(Entrust::can('create_user'))
									<li><a href="{!! URL::to('/user/create') !!}"><i class="fa fa-angle-right"></i> {!! trans('messages.Add New') !!} </a></li>
									@endif
									<li><a href="/user"><i class="fa fa-angle-right"></i> {!! trans('messages.List All Users') !!}</a></li>
									@foreach(\App\Role::get() as $role)
									<li><a href="{!! URL::to('/user/list/'.$role->name) !!}"><i class="fa fa-angle-right"></i> List {!! $role->display_name !!} </a></li>
									@endforeach
								</ul>
							</li>
							@endif
							@if(Entrust::can('manage_kb_article'))
							<li><a href=""><i class="fa fa-sitemap icon"></i><i class="fa fa-angle-double-down i-right"></i> {!! trans('messages.Article') !!}</a>
								<ul>
									@if(Entrust::can('create_kb_article'))
									<li><a href="{!! URL::to('/kb_article/create') !!}"><i class="fa fa-angle-right"></i> {!! trans('messages.Add New') !!} </a></li>
									@endif
									<li><a href="{!! URL::to('/kb_article') !!}"><i class="fa fa-angle-right"></i> {!! trans('messages.List Articles') !!} </a></li>
								</ul>
							</li>
							@endif
							@if(Entrust::can('manage_ticket'))
							<li><a href=""><i class="fa fa-ticket icon"></i><i class="fa fa-angle-double-down i-right"></i> {!! trans('messages.Ticket') !!}</a>
								<ul>
									@if(Entrust::can('create_ticket'))
									<li><a href="{!! URL::to('/ticket/create') !!}"><i class="fa fa-angle-right"></i> {!! trans('messages.Add New') !!} </a></li>
									@endif
									<li><a href="{!! URL::to('/ticket') !!}"><i class="fa fa-angle-right"></i>{!! trans('messages.List Tickets') !!}</a></li>
								</ul>
							</li>
							@endif
							@if(Entrust::can('manage_annoucement'))
							<li><a href=""><i class="fa fa-sitemap icon"></i><i class="fa fa-angle-double-down i-right"></i> {!! trans('messages.Annoucement') !!}</a>
								<ul>
									@if(Entrust::can('create_annoucement'))
									<li><a href="{!! URL::to('/annoucement/create') !!}"><i class="fa fa-angle-right"></i> {!! trans('messages.Add New') !!} </a></li>
									@endif
									<li><a href="{!! URL::to('/annoucement') !!}"><i class="fa fa-angle-right"></i> {!! trans('messages.List Annoucements') !!} </a></li>
								</ul>
							</li>
							@endif
							@if(Entrust::can('manage_page'))
							<li><a href=""><i class="fa fa-file icon"></i><i class="fa fa-angle-double-down i-right"></i> {!! trans('messages.Page') !!}</a>
								<ul>
									@if(Entrust::can('create_page'))
									<li><a href="{!! URL::to('/page/create') !!}"><i class="fa fa-angle-right"></i> {!! trans('messages.Add New') !!} </a></li>
									@endif
									<li><a href="{!! URL::to('/page') !!}"><i class="fa fa-angle-right"></i> {!! trans('messages.List Pages') !!} </a></li>
									@if(Entrust::can('manage_default_pages'))
									<li><a href="{!! URL::to('/default_page') !!}"><i class="fa fa-angle-right"></i> {!! trans('messages.Default Pages') !!} </a></li>
									@endif
								</ul>
							</li>
							@endif
							@if(Entrust::can('manage_holiday'))
							<li><a href="{!! URL::to('/holiday') !!}"><i class="fa fa-fighter-jet icon"></i> {!! trans('messages.Holiday') !!}</a></li>
							@endif
							@if(Entrust::can('manage_message'))
							<li><a href="{!! URL::to('/message') !!}"><i class="fa fa-envelope icon"></i> {!! trans('messages.Message') !!}</a></li>
							@endif

							@if(Entrust::hasRole('admin'))
							<li><a href="{!! URL::to('/configuration') !!}"><i class="fa fa-cogs icon"></i> {!! trans('messages.Configuration') !!}</a></li>
							<li><a href="{!! URL::to('/custom_field') !!}"><i class="fa fa-pie-chart icon"></i> {!! trans('messages.Custom Fields') !!}</a></li>
							<li><a href="{!! URL::to('/template') !!}"><i class="fa fa-envelope-o icon"></i> {!! trans('messages.Email Template') !!}</a></li>
							@endif

						</ul>
						<div class="clear"></div>
					</div><!-- End div #sidebar-menu -->
				</div><!-- End div .sidebar-inner .slimscroller -->
            </div><!-- End div .body .rows .scroll-y -->
			
			<!-- Sidebar footer -->
            <div class="footer rows animated fadeInUpBig">
				<div class="logo-brand header sidebar rows">
					<div class="logo">
						<h1><a href="{!! URL::to('/') !!}"><i class="fa fa-ticket fa-lg"></i> {!! config('config.application_name').' '.config('constants.VERSION') !!}</a> </h1>
						<button class="sidebar-toggle">toggle</button>
					</div>
				</div>
            </div><!-- End div .footer .rows -->
        </div>
		<!-- END SIDEBAR -->