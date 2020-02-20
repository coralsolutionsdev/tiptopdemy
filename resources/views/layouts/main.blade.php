<!DOCTYPE html>
<html lang="en">
  <head>
  	<!-- Head begain-->
	@Include('layouts.partials._head')	
	<!-- head end -->
  </head>
  <body>
  	<div id="warpper">
  		<!--Navbar begain -->
	 	@Include('layouts.partials._nav')
		<!--Navbar end -->
		<!--container -->
	    @yield('content')
		<!--end of container-->
		<!--Offline msg-->
		@Include('layouts.partials._offline')
		<!--Offline msg end-->
    </div>
    <div id="footer">
    	<!-- footer began -->
		@Include('layouts.partials._footer')
		<!--Reloading page-->
    </div>
    	@Include('layouts.partials._loading')
		<!--Reloading page end-->

		@Include('layouts.partials._footer_scripts')
		<!-- footer end -->
  </body>
</html>