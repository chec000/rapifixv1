<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
         <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css">
        <title>Gym</title>
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
         <link rel="stylesheet" href="{!! asset('assets/css/main.min.css') !!}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
      
    </head>
    <body class="mobile-shift">
        <header>

	<div class="fixed-navbar">

		<div class="navbar-lockup">

			<div class="logo">

				<a href=""><img src="{!! asset('assets/img/logo.png') !!}" alt="Fitness"></a>

			</div>

			<ul class="nav">

				<li><a href="">About</a></li>
				<li><a href="">How It Works</a></li>
				<li><a href="">Services</a></li>
				<li><a href="">FAQ</a></li>
				<li><a href="">Contact</a></li>
                                    @if (Route::has('login'))
              
                    @auth
                    <li>
                                                <a href="{{ url('/home') }}">Home</a>

                    </li>
                    @else
                    <li>
                                                <a href="{{ route('login') }}">Login</a>

                    </li>
                    <li>
                                                <a href="{{ route('register') }}">Register</a>

                    </li>
                    @endauth
               
            @endif
<!--
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Idioma</a>
    <div class="dropdown-menu">
        <span class="dropdown-item" href="#">Action</span>
        <span class="dropdown-item" href="#">Action</span>
        <span class="dropdown-item" href="#">Action</span>

    </div>
  </li>-->
                                    
                                    
                                    

			</ul>

		</div>

	</div>

	<div class="claim-lockup">

		<div class="claim">

			<p class="headline">Fitness In A Can<span>/</span></p>
			<p class="kicker">Yes You Can<span>/</span></p>

		</div>

	</div>

	<div class="angled-overlay"></div>

	<div class="slide-out-nav">

		<ul class="mobile-nav">

			<li><a href="">About</a></li>
			<li><a href="">How It Works</a></li>
			<li><a href="">Services</a></li>
			<li><a href="">FAQ</a></li>
			<li><a href="">Contact</a></li>

		</ul>

		<div class="mobile-nav-slice"></div>

	</div>

	<div class="mobile-nav-toggle">

		<span></span>
		<span></span>
		<span></span>

	</div>

</header>