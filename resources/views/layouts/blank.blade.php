@include('layouts.head')

	<!-- BODY -->
	<body class="tooltips k-rtl">
	
	<!-- BEGIN PAGE -->
	<div class="container">
		<!-- Your logo goes here -->
		<div class="logo-brand header sidebar rows">
			<div class="logo">
				<a href="/" class="navbar-brand" style="margin-left:5px;"><i class="fa fa-ticket fa-lg" style="margin-right:5px;"></i> <strong>{!! config('config.application_name') !!}</strong></a>
			</div>
		</div><!-- End div .header .sidebar .rows -->
		
		<!-- BEGIN CONTENT -->
        <div class="content-page">
			
			<!-- ============================================================== -->
			<!-- START YOUR CONTENT HERE -->
			<!-- ============================================================== -->
            <div class="body content rows scroll-y">
				
				@yield('content')
			
				@include('layouts.footer')	
            </div>
			<!-- ============================================================== -->
			<!-- END YOUR CONTENT HERE -->
			<!-- ============================================================== -->
			
			
        </div>
		<!-- END CONTENT -->
		
	</div><!-- End div .container -->
	<!-- END PAGE -->

	@include('layouts.foot')	

		
	
	
	