<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Satisfy&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style>

		html, body{
			padding: 0px;
			margin: 0px;

		}
		body{
			font-family: 'Cairo', sans-serif;
			margin: auto;
			background-color: #F3F5F9;
			font-size: 13px;
		}
		p{
			padding: 0px;
			margin: 2px;
			font-size: 14px;
			opacity: 0.7;
		}
		.content{
			margin-top: 90px;
			font-family: 'Oswald', sans-serif;
		}
		.card-body{
			padding: 80px 60px;
		}
		.background-icon {
			position:relative;
		}
		.background-icon:before {
			font-family: 'Font Awesome 5 Free';
			position: absolute;
			content: "\f1da";
			font-weight: 600;
			font-size: 220px;
			opacity: 0.05;
			/*background-color: white;*/
			bottom: -80px;
			left: -50px;
		}
		.card{
			overflow: hidden;
		}
		.char_1{
			position: absolute;
			bottom: -50px;
			right: -10px;
			width: 130px;
		}
		.navbar{
			background-color: white;
		}
		.navbar-brand{
			color: #2196F3 !important;
			font-family: 'Barlow Condensed', sans-serif;
		}

	</style>
	<title>Coral Solutions</title>
</head>
<body>
<section>
	<nav class="navbar navbar-expand-lg navbar-light">
		<div class="container">
			<a class="navbar-brand" href="#">CORAL SOLUTIONS</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" href="{{route('login')}}">Log in</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{route('register')}}">Register</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container content d-flex justify-content-center">
		<div class="col-lg-6 col-sm-12">
			<div class="card" style="border-color: #F3F5F9">
				<div class="card-body background-icon">
					<h3 style="color: #2196F3; z-index: 15">WE ARE COMING SOON!</h3>
					<br>
					<p>The site is under maintenance</p>
					<p>For more info, contact us on:</p>
					<p>support@coral4host.com</p>
				</div>
			</div>
			<img class="char_1" src="{{asset_image('temp/char_1.png')}}" alt="">
		</div>
	</div>
</section>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
