@include('layouts.head')


	<!-- BODY -->
	<body class="tooltips k-rtl">
	
	<!-- BEGIN PAGE -->
	<div class="container">
	
		<!-- BEGIN CONTENT -->
        <div class="right-full content-page">

			@include('layouts.header')	
			
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

	<div class="modal fade" id="myTodoModal" role="basic" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			</div>
		</div>
	</div>
	
	@include('layouts.foot')	

		
	
	
	