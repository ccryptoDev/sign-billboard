<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
	<meta charset="utf-8" />
	<title>Set your Password - Inex</title>
	<meta name="description" content="Login page">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
	
	<link href="/dist/assets/css/pages/login/login-2.css" rel="stylesheet" type="text/css" />
	<link href="/dist/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="/dist/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<link href="/dist/assets/css/skins/header/base/light.css" rel="stylesheet" type="text/css" />
	<link href="/dist/assets/css/skins/header/menu/light.css" rel="stylesheet" type="text/css" />
	<link href="/dist/assets/css/skins/brand/dark.css" rel="stylesheet" type="text/css" />
	<link href="/dist/assets/css/skins/aside/dark.css" rel="stylesheet" type="text/css" />

	<link rel="shortcut icon" href="/favicon.png" />
</head>
<!-- end::Head -->
<!-- begin::Body -->

<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
	<!-- begin:: Page -->
	<div class="kt-grid kt-grid--ver kt-grid--root">
		<div class="kt-grid kt-grid--hor kt-grid--root kt-login kt-login--v2 kt-login--signin" id="kt_login">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url(/assets/media/bg/bg-11.jpg);background-size:100%100%">
				<div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
					<div class="kt-login__container">
						<div class="kt-login__logo">
							<a href="#">
								<img src="/logo.png" style="width:100%">
							</a>
						</div>
						<div class="kt-login__signin" style='background-color:rgba(0,0,0,0.2);padding:20px'>
							<div class="kt-login__head">
								<h3 class="kt-login__title">{{$page_name}} YOUR PASSWORD</h3>
							</div>
							@if(request()->route()->getName() == 'setadmin-password')
							<form class="kt-form" id="login-form" action="/user-reset" method="POST">
							@else
							<form class="kt-form" id="login-form" action="/reset" method="POST">
							@endif
								@csrf
								@if ($errors->any())
									<div class="alert alert-danger">
										<ul class="mt-3 list-disc list-inside text-sm text-red-600 text-white" style="color:black">
											@foreach ($errors->all() as $error)
												<li><span>{{$error}}</span></li>
											@endforeach
										</ul>
									</div>
								@enderror
								<div class="input-group">
                                    <input class="form-control" type="hidden" placeholder="" name="id" autocomplete="off" required value='{{$user_id}}'>
									<input class="form-control" type="password" placeholder="Password" name="password" autocomplete="off" required id="pass">
								</div>
								<div class="input-group">
									<input class="form-control" type="password" placeholder="Confirm password" name="password_confirmation" required id="con_pass">
								</div>
								<div class="kt-login__actions">
									<button id="kt_login_signin_submit" class="btn btn-pill kt-login__btn-primary" type="submit">{{$page_name}}</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end:: Page -->
	<!-- begin::Global Config(global config for global JS sciprts) -->
	<script>

		var KTAppOptions = {
		    "colors": {
		        "state": {
		            "brand": "#5d78ff",
		            "dark": "#282a3c",
		            "light": "#ffffff",
		            "primary": "#5867dd",
		            "success": "#34bfa3",
		            "info": "#36a3f7",
		            "warning": "#ffb822",
		            "danger": "#fd3995"
		        },
		        "base": {
		            "label": [
		                "#c5cbe3",
		                "#a1a8c3",
		                "#3d4465",
		                "#3e4466"
		            ],
		            "shape": [
		                "#f0f3ff",
		                "#d9dffa",
		                "#afb4d4",
		                "#646c9a"
		            ]
		        }
		    }
		};
	</script>
	<script src="/dist/assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
	<script src="/dist/assets/js/scripts.bundle.js" type="text/javascript"></script>
	<script src="/dist/assets/js/pages/custom/login/login-general.js" type="text/javascript"></script>
    <script>
        var login = $('#kt_login');
        var showErrorMsg = function(form, type, msg) {
            var alert = $('<div class="alert alert-' + type + ' alert-dismissible" role="alert">\
                <div class="alert-text">'+msg+'</div>\
                <div class="alert-close">\
                    <i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>\
                </div>\
            </div>');

            form.find('.alert').remove();
            alert.prependTo(form);
            //alert.animateClass('fadeIn animated');
            KTUtil.animateClass(alert[0], 'fadeIn animated');
            alert.find('span').html(msg);
        }
    </script>
</body>


</html>