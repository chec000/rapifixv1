<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="{!! asset('/css/login.css') !!}" media="all" type="text/css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>


<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a href="#" class="navbar-brand">Logo</a>
			<button class="navbar-toggler" data-target="#navigation" data-control="navigation" data-toggle="collapse">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navigation">
				<ul class="nav navbar-nav">
					<li class="nav-item active">
						<a href="#" class="nav-link">Home</a>
					</li>					
					<li class="nav-item">
						<a href="#" class="nav-link">Feature</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" id="preview" href="#" role="button" aria-haspopup="true" aria-expanded="false">Products</a>
						<div class="dropdown-menu" aria-lableledby="preview">
							<a class="dropdown-item" href="#">Product1</a>
							<a class="dropdown-item" href="#">Product2</a>
							<a class="dropdown-item" href="#">Product3</a>
							<a class="dropdown-item" href="#">Product4</a>
						</div>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">Service</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">Contact Us</a>
					</li>
				</ul>
			</div>
		</nav>