<!DOCTYPE html>
<html>
<head>
	@Include('layouts.partials.cpanel._head')

</head>
<body>
<div class="display-table">	
	<div class="display-table-row">
		<!-- Side bar -->
		<div id="side-bar" class="display-table-cell padding-0">
			<div class="navbar">
				<small class="text-muted">Beta 1.0</small>
			</div>
			@Include('layouts.partials.cpanel._sidebar-menu')
		</div>

		<!-- content bar -->
		<div id="content-bar" class="display-table-cell padding-0">
			@Include('layouts.partials.cpanel._nav')

			<!-- page main content -->

			<div  id="content-body">
				<div id="content-body-page" class="section">
					<div class="container">
						@Include('layouts.partials._messages')
						@yield('content')
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@Include('layouts.partials._footer_scripts')

</body>
</html>