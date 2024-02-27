<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>INEX</title>
	<!-- Favicon -->
	<link rel="shortcut icon" href="/favicon.png" />
	<!-- bootstrap -->
	<link href="/dating1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- mega menu -->
	<link href="/dating1/css/mega-menu/mega_menu.css" rel="stylesheet" type="text/css" />
	<!-- font-awesome -->
	<link href="/dating1/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- Flaticon -->
	<link href="/dating1/css/flaticon.css" rel="stylesheet" type="text/css" />
	<!-- General style -->
	<link href="/dating1/css/general.css" rel="stylesheet" type="text/css" />
	<!-- main style -->
	<link href="/dating1/css/style.css" rel="stylesheet" type="text/css" />
	<!-- Style customizer -->
	<link rel="stylesheet" type="text/css" href="/dating1/css/skins/skin-default.css" data-style="styles" />
	<link rel="stylesheet" type="text/css" href="/dating1/css/style-customizer.css" /> 
	<style>
		.bg-overlay-red:before{
			background : linear-gradient(29deg, #a4a4a466, #00000021)
		}
	</style>
</head>

<body>
	<!--=================================
 preloader -->
	<div id="preloader">
		<div class="clear-loading loading-effect"><img src="/logo.png" alt="" /></div>
	</div>
	<!--=================================
 Page Section -->
	<section class="coming-soon page-section-ptb bg-1 bg-overlay-red fixed text-white" style="background:url('/assets/media/error/bg6.jpg') no-repeat 0 0; background-size: cover; height: 100vh;">
		<div class="coming-soon-text">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-12 mt-3 text-right"> <img src="/logo.png" alt="" width="100%" />
						@if(isset($error))
						<h1 class="title text-uppercase mb-1" style="font-family:none; font-size:30px">
							<a href="/">{{$error}}</a>
						</h1>
						@else
						<h1 class="title text-uppercase mb-1">
							<a href="/">404</a>
						</h1>
						@endif
					</div>
				</div>
			</div>
		</div>
	</section>
	<script type="text/javascript" src="/dating1/js/jquery.min.js"></script>
	<script type="text/javascript" src="/dating1/js/popper.min.js"></script>
	<!-- bootstrap -->
	<script type="text/javascript" src="/dating1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/dating1/js/bootstrap-select.min.js"></script>
	<!-- appear -->
	<script type="text/javascript" src="/dating1/js/jquery.appear.js"></script>
	<!-- bootstrap -->
	<script type="text/javascript" src="/dating1/js/mega-menu/mega_menu.js"></script>
	<!-- counter -->
	<script type="text/javascript" src="/dating1/js/countdown/jquery.downCount.js"></script>
	<!-- style customizer  -->
	<script type="text/javascript" src="/dating1/js/style-customizer.js"></script>
	<!-- custom -->
	<script type="text/javascript" src="/dating1/js/custom.js"></script>
</body>

</html>