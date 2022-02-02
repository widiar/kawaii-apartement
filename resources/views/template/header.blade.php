<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Kawaii Apartement</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Kawaii Apartement" />
	<meta name="keywords" content="kawaii, kawaii apartement, jimbaran" />
	<meta name="author" content="Ari Widiarsana" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

	<!-- Stylesheets -->
	<!-- Dropdown Menu -->
	<link rel="stylesheet" href="{{ asset('css/superfish.css') }}">
	<!-- Owl Slider -->
	<!-- <link rel="stylesheet" href="css/owl.carousel.css"> -->
	<!-- <link rel="stylesheet" href="css/owl.theme.default.min.css"> -->
	<!-- Date Picker -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
	<!-- CS Select -->
	<link rel="stylesheet" href="{{ asset('css/cs-select.css') }}">
	<link rel="stylesheet" href="{{ asset('css/cs-skin-border.css') }}">

	<!-- Themify Icons -->
	<link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}">
	<!-- Flat Icon -->
	<link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
	<!-- Icomoon -->
	<link rel="stylesheet" href="{{ asset('css/icomoon.css') }}">
	<!-- Flexslider  -->
	<link rel="stylesheet" href="{{ asset('css/flexslider.css') }}">

	<link rel="stylesheet" href="{{ asset('plugins/venobox/venobox.min.css') }}">
	
	<!-- Style -->
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">

	<!-- Modernizr JS -->
	<script src="{{ asset('js/modernizr-2.6.2.min.js') }}"></script>
    @yield('css')
</head>