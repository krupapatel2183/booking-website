<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Login Page</title>
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
	@include('includes.css-links')
</head>

<body>
	<div class="main-wrapper login-body">
		@yield('content')
	</div>
	@include('includes.javascripts')
    @stack('custom-scripts')
</body>

</html>