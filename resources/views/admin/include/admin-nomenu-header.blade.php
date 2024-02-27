
<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="../../">
		<meta charset="utf-8" />
		<title>{{$page_name}}</title>
		<meta name="description" content="Card tools examples" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="/favicon.png" />
		<style>
			.svg-icon-primary{
				cursor : pointer;
			}
			.card.card-custom > .card-header .card-title .card-label{
				font-size : 1.5rem
			}
		</style>
	</head>
	<body id="kt_body" style="background-image: url(/assets/media/bg/bg-11.jpg)" class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading">
		<div id="kt_header_mobile" class="header-mobile">
			<a href="/">
				<img alt="Logo" src="/logo.png" class="logo-default max-h-30px" />
			</a>
			<div class="d-flex align-items-center">
				<button class="btn p-0 burger-icon burger-icon-left ml-4" id="kt_header_mobile_toggle">
					<span></span>
				</button>
				<button class="btn btn-icon btn-hover-transparent-white p-0 ml-3" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-xl">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
							</g>
						</svg>
					</span>
				</button>
			</div>
        </div>
        <div class="d-flex flex-column flex-root">
			<div class="d-flex flex-row flex-column-fluid page">
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					<div id="kt_header" class="header header-fixed">
						<div class="container d-flex align-items-stretch justify-content-between">
							<div class="d-flex align-items-stretch mr-3">
								<div class="header-logo">
									<a href="/">
										<img alt="Logo" src="/logo.png" class="logo-default max-h-40px" />
										<img alt="Logo" src="/logo.png" class="logo-sticky max-h-40px" />
									</a>
								</div>
								<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
									<div id="kt_header_menu" class="header-menu header-menu-left header-menu-mobile header-menu-layout-default">
									</div>
								</div>
							</div>
							<div class="topbar">
								<div class="topbar-item" data-toggle="tooltip" data-placement="left" title="Suggestion Box - Make a suggestion or point out an error">
									<div class="btn btn-icon btn-hover-transparent-white btn-lg mr-1 pulse pulse-danger" 
										data-toggle="modal" data-target="#suggest_modal">
										<span class="svg-icon svg-icon-xl" 
										>
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,13 C19,13.5522847 18.5522847,14 18,14 L6,14 C5.44771525,14 5,13.5522847 5,13 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M13.8,4 C13.1562,4 12.4033,4.72985286 12,5.2 C11.5967,4.72985286 10.8438,4 10.2,4 C9.0604,4 8.4,4.88887193 8.4,6.02016349 C8.4,7.27338783 9.6,8.6 12,10 C14.4,8.6 15.6,7.3 15.6,6.1 C15.6,4.96870845 14.9396,4 13.8,4 Z" fill="#000000" opacity="0.3"/>
													<path d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z" fill="#000000"/>
												</g>
											</svg>
										</span>
										<span class="pulse-ring"></span>
									</div>
								</div>
								<div class="dropdown">
									<div class="topbar-item" data-toggle="dropdown" data-offset="0px,0px">
										<div class="btn btn-icon btn-hover-transparent-white d-flex align-items-center btn-lg px-md-2 w-md-auto" style="background:rgba(255, 255, 255, 0.12) !important">
											<span class="text-white opacity-70 font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
											<span class="text-white opacity-90 font-weight-bolder font-size-base d-none d-md-inline mr-4">{{session("user_name")}}</span>
										</div>
									</div>
									<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg p-0">
										<div class="d-flex align-items-center p-8 rounded-top">
											<div class="text-dark m-0 flex-grow-1 mr-3 font-size-h5">{{session("user_name")}}</div>
										</div>
										<div class="navi navi-spacer-x-0">
											<div class="navi-separator mt-3"></div>
											<div class="navi-footer px-8 py-5">
												<a href="sign_out" class="btn btn-light-primary font-weight-bold">Sign Out</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--end::Header-->

					<div class="modal fade" id="suggest_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Suggestion or Critiques</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true" class="ki ki-close"></i>
									</button>
								</div>
								<form id="suggest_form">
									<div class="modal-body">
										<textarea class="form-control" name="content" id="sug_content" rows="6" required></textarea>
									</div>
									<div class="modal-footer">
										<button type="button" id="cs_mo" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary font-weight-bold">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
    