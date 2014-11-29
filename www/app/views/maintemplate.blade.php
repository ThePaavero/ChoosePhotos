<!doctype html>
<html>
<head>
	<meta charset='utf-8'>
	<title>{{ $title }}</title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>
	<link rel='stylesheet' href='{{ URL::to('assets/css/all.min.css') }}'/>
	<script src='//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js'></script>
	<script src='{{ URL::to('assets/js/all.min.js') }}'></script>
</head>
<body>
<div class='main-container'>
    @include($page)
</div><!-- main-container -->
</body>
</html>