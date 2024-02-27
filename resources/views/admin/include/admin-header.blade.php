
<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="../../">
		<meta charset="utf-8" />
		<title>{{$page_name}}</title>
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link href="{{ asset('/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('/assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="/favicon.png" />
		<style>
			.svg-icon-primary{
				cursor : pointer;
			}
			.card.card-custom > .card-header .card-title .card-label{
				font-size : 1.5rem
			}
			#kt_subheader{
				padding: 0px !important;
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
										<ul class="menu-nav">
											<?php
												if(session("level") == 2){
												?>
												<li class="menu-item <?php if(
													( $page_name =='Advertising Tools' || $page_name == "Post Social Media" || $page_name == 'History of Process Socials' && session('level') == 2) ||
													$page_name == "Campaign Manager" || $page_name=='Edit Campaign' || $page_name=='Create Campaign' || $page_name =='Manage Playlist' ||
													$page_name =='Create New Ad'){
														echo 'menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here';
													}
													else{
														echo 'menu-item-submenu menu-item-rel';
													}?>" data-menu-toggle="click" aria-haspopup="true">
													<a href="javascript:;" class="menu-link menu-toggle">
														<span class="menu-text">Client Advertising</span>
														<span class="menu-desc"></span>
														<i class="menu-arrow"></i>
													</a>
													<div class="menu-submenu menu-submenu-classic menu-submenu-left">
														<ul class="menu-subnav">
															<li class="menu-item menu-item-submenu <?= $page_name =='Campaign Manager'||$page_name=='Edit Campaign'||$page_name=='Create Campaign'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																<a href="/manage-campaign" class="menu-link">
																	<span class="svg-icon menu-icon">
																		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24"/>
																				<rect fill="#000000" opacity="0.3" x="4" y="4" width="4" height="4" rx="2"/>
																				<rect fill="#000000" x="4" y="10" width="4" height="4" rx="2"/>
																				<rect fill="#000000" x="10" y="4" width="4" height="4" rx="2"/>
																				<rect fill="#000000" x="10" y="10" width="4" height="4" rx="2"/>
																				<rect fill="#000000" x="16" y="4" width="4" height="4" rx="2"/>
																				<rect fill="#000000" x="16" y="10" width="4" height="4" rx="2"/>
																				<rect fill="#000000" x="4" y="16" width="4" height="4" rx="2"/>
																				<rect fill="#000000" x="10" y="16" width="4" height="4" rx="2"/>
																				<rect fill="#000000" x="16" y="16" width="4" height="4" rx="2"/>
																			</g>
																		</svg>
																	</span>
																	<span class="menu-text">Manage Campaign</span>
																</a>
															</li>
															<li class="menu-item menu-item-submenu <?= $page_name =='Create New Ad'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																<a href="/update_ad" class="menu-link">
																	<span class="svg-icon menu-icon">
																		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24" />
																				<path d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																				<path d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z" fill="#000000" />
																			</g>
																		</svg>																	
																	</span>
																	<span class="menu-text">Create New Ad</span>
																</a>
															</li>
															<li class="menu-item <?= $page_name =='Manage Playlist'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																<a href="/manage_playlist" class="menu-link">
																	<span class="svg-icon menu-icon">
																		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24"/>
																				<path d="M4.5,6 L19.5,6 C20.8807119,6 22,6.97004971 22,8.16666667 L22,16.8333333 C22,18.0299503 20.8807119,19 19.5,19 L4.5,19 C3.11928813,19 2,18.0299503 2,16.8333333 L2,8.16666667 C2,6.97004971 3.11928813,6 4.5,6 Z M4,8 L4,17 L20,17 L20,8 L4,8 Z" fill="#000000" fill-rule="nonzero"/>
																				<polygon fill="#000000" opacity="0.3" points="4 8 4 17 20 17 20 8"/>
																				<rect fill="#000000" opacity="0.3" x="7" y="20" width="10" height="1" rx="0.5"/>
																			</g>
																		</svg>
																		
																	</span>
																	<span class="menu-text">Manage Playlist</span>
																</a>
															</li>
															<li class="menu-item <?= $page_name =='Advertising Tools' || $page_name == 'History of Process Socials' ?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																<a href="/graphic-design" class="menu-link">
																	<span class="svg-icon menu-icon">
																		<i class="la la-ad"></i>
																	</span>
																	<span class="menu-text">Advertising Tools</span>
																</a>
															</li>
															<!-- <li class="menu-item <?= $page_name =='Post Social Media' || $page_name == 'History of Process Socials' ?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																<a href="/social-posts" class="menu-link">
																	<span class="svg-icon menu-icon">
																		<i class="fab fa-twitter"></i>
																	</span>
																	<span class="menu-text">Post Social Media</span>
																</a>
															</li> -->
															<!-- <li class="menu-item <?= $page_name =='My Personal Account'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																<a href="/account" class="menu-link">
																	<span class="svg-icon menu-icon">
																		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24" />
																				<path d="M18,2 L20,2 C21.6568542,2 23,3.34314575 23,5 L23,19 C23,20.6568542 21.6568542,22 20,22 L18,22 L18,2 Z" fill="#000000" opacity="0.3" />
																				<path d="M5,2 L17,2 C18.6568542,2 20,3.34314575 20,5 L20,19 C20,20.6568542 18.6568542,22 17,22 L5,22 C4.44771525,22 4,21.5522847 4,21 L4,3 C4,2.44771525 4.44771525,2 5,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z" fill="#000000" />
																			</g>
																		</svg>
																	</span>
																	<span class="menu-text">My Personal Account</span>
																</a>
															</li> -->
														</ul>
													</div>
												</li>
												<li class="menu-item <?php if(
													($page_name == "Transfer Detail" || $page_name == "Transfer History" || $page_name == "Manage Gallery" 
                          |  $page_name == "Manage Page Announcements" || $page_name == "Manage Partner Types" || $page_name == 'Manage Subscribers'
													|| $page_name == "View Newsletter" || $page_name == "Manage Newsletter" || $page_name == "Manage Partner"
													|| $page_name == "Manage SEO Operation" || $page_name == "Manage Document Categories" || $page_name == "Manage Documents" || $page_name == "Manage Partner" || $page_name == "Manage Newsletter" || $page_name == "System Transaction Records" || $page_name == "Transaction" || $page_name == "Income" || $page_name == "Invoice" || $page_name == "Ads Sold" || $page_name == 'Inventory Availability' || $page_name == "Revenue Distribution Settings" || $page_name == 'Coupon Manager' || $page_name == 'Invoice Management' && session('level') == 2) 
													|| $page_name == 'Public / Private Locations' || $page_name == 'New Accounts' || $page_name == 'Client Pay Options' || $page_name == 'Update Business Account'
													|| $page_name == 'Current Revenue' || $page_name == 'Connected Accounts'  || $page_name == 'Revenue By User'
													|| $page_name == 'Dashboard' || $page_name == 'Manage Business Account' || $page_name == 'Create Business Account' || $page_name== 'Update Business Account'|| $page_name == 'Manage User' || $page_name == 'Manage CM' || $page_name == 'Manage Sales' || $page_name =='Manage Templates' || $page_name =='Suggestions' || $page_name == 'Manage SIC' || $page_name =='Manage Master Playlists' || $page_name =='Master Playlist Client Load' || $page_name == "Business Locations"){
														echo 'menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here';
													}
													else{
														echo 'menu-item-submenu menu-item-rel';
													}?>" data-menu-toggle="click" aria-haspopup="true">
													<a href="javascript:;" class="menu-link menu-toggle">
														<span class="menu-text">Admin Pages</span>
														<span class="menu-desc"></span>
														<i class="menu-arrow"></i>
													</a>
													<div class="menu-submenu menu-submenu-classic menu-submenu-left">
														<ul class="menu-subnav">														
															<li class="menu-item menu-item-submenu <?= $page_name =='Dashboard'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																<a href="/dashboard" class="menu-link">
																	<span class="svg-icon menu-icon">
																		<i class="fab fa-slideshare"></i>
																	</span>
																	<span class="menu-text">Dashboard</span>
																</a>
															</li>
															<li class="menu-item  menu-item-submenu 
																<?= $page_name =='Revenue Distribution Settings' || $page_name =='Manage SIC' || $page_name =='Manage CM' || $page_name == 'Master Playlist Client Load' || $page_name == 'Manage Master Playlists'?'menu-item-open menu-item-here':''?>"  data-menu-toggle="hover" aria-haspopup="true">
																<a  href="javascript:;" class="menu-link menu-toggle">
																	<span class="svg-icon menu-icon">
																		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24"/>
																				<path d="M4.5,6 L19.5,6 C20.8807119,6 22,6.97004971 22,8.16666667 L22,16.8333333 C22,18.0299503 20.8807119,19 19.5,19 L4.5,19 C3.11928813,19 2,18.0299503 2,16.8333333 L2,8.16666667 C2,6.97004971 3.11928813,6 4.5,6 Z M4,8 L4,17 L20,17 L20,8 L4,8 Z" fill="#000000" fill-rule="nonzero"/>
																				<polygon fill="#000000" opacity="0.3" points="4 8 4 17 20 17 20 8"/>
																				<rect fill="#000000" opacity="0.3" x="7" y="20" width="10" height="1" rx="0.5"/>
																			</g>
																		</svg>
																	</span>
																	<span class="menu-text">Billboard Management</span><i class="menu-arrow"></i>
																</a>
																<div class="menu-submenu menu-submenu-classic menu-submenu-right" >
																	<ul class="menu-subnav">
																		<li class="menu-item  <?= $page_name =='Manage Master Playlists'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="/add_playlist" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Manage Master Playlists</span></a></li>
																		<li class="menu-item  <?= $page_name =='Master Playlist Client Load'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="/manage_locations" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Master Playlist Client Load</span></a></li>
																		<li class="menu-item  <?= $page_name =='Manage CM'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="/manage_cm" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Manage CM</span></a></li>
																		<li class="menu-item  <?= $page_name =='Manage SIC'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="/manage_sic" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Manage SIC</span></a></li>
																		<li class="menu-item  <?= $page_name =='Revenue Distribution Settings'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a href="{{route('revenue-dist')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Revenue Distribution Settings</span></a></li>
																	</ul>
																</div>
															</li>
															<li class="menu-item  menu-item-submenu 
																<?= $page_name == 'Update Business Account' || $page_name == "Public / Private Locations" || $page_name == 'New Accounts' || $page_name =='Coupon Manager' || $page_name =='Business Locations' || $page_name == "Client Pay Options" || $page_name =='Manage Templates' || $page_name =='Manage User' || $page_name =='Manage Business Account' ?'menu-item-open menu-item-here':''?>"  data-menu-toggle="hover" aria-haspopup="true">
																<a  href="javascript:;" class="menu-link menu-toggle">
																	<span class="svg-icon menu-icon">
																		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<polygon points="0 0 24 0 24 24 0 24"/>
																				<path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																				<path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
																			</g>
																		</svg>
																	</span>
																	<span class="menu-text">Account Management</span><i class="menu-arrow"></i>
																</a>
																<div class="menu-submenu menu-submenu-classic menu-submenu-right" >
																	<ul class="menu-subnav">
																		<li class="menu-item  <?= $page_name =='Manage Business Account'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('business-account')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Manage Business Account</span></a></li>
																		<li class="menu-item  <?= $page_name =='Coupon Manager'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('manage-coupon')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Coupon Manager</span></a></li>
																		<li class="menu-item  <?= $page_name =='New Accounts'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('new-accounts')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">New Accounts</span></a></li>
																		<li class="menu-item  <?= $page_name =='Client Pay Options'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('manage-payment-method')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Client Pay Options</span></a></li>
																		<li class="menu-item  <?= $page_name =='Business Locations'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="/manage_locations_by" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Business Locations</span></a></li>
																		<li class="menu-item  <?= $page_name =='Public / Private Locations'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true">
																			<a href="{{route('public_location')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Public / Private Locations</span></a>
																		</li>
																		<li class="menu-item  <?= $page_name =='Manage User'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="/manage-user" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Manage User</span></a></li>
																		<li class="menu-item  <?= $page_name =='Manage Templates'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="/manage_temp" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Manage Templates</span></a></li>
																	</ul>
																</div>
															</li>
															<li class="menu-item  menu-item-submenu 
																<?= $page_name == "Transfer Detail" || $page_name == "Transfer History" || $page_name == "System Transaction Records" || $page_name == "Transaction" || $page_name =='Invoice' || $page_name =='Invoice Management' 
																	|| $page_name =='Current Revenue' || $page_name == 'Connected Accounts' || $page_name == 'Revenue By User'
																	|| $page_name =='Income' || $page_name =='Ads Sold' || $page_name == 'Inventory Availability'?'menu-item-open menu-item-here':''?>" 
																	data-menu-toggle="hover" aria-haspopup="true">
																<a  href="javascript:;" class="menu-link menu-toggle">
																	<span class="svg-icon menu-icon">
																		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24"/>
																				<path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero"/>
																				<path d="M8.7295372,14.6839411 C8.35180695,15.0868534 7.71897114,15.1072675 7.31605887,14.7295372 C6.9131466,14.3518069 6.89273254,13.7189711 7.2704628,13.3160589 L11.0204628,9.31605887 C11.3857725,8.92639521 11.9928179,8.89260288 12.3991193,9.23931335 L15.358855,11.7649545 L19.2151172,6.88035571 C19.5573373,6.44687693 20.1861655,6.37289714 20.6196443,6.71511723 C21.0531231,7.05733733 21.1271029,7.68616551 20.7848828,8.11964429 L16.2848828,13.8196443 C15.9333973,14.2648593 15.2823707,14.3288915 14.8508807,13.9606866 L11.8268294,11.3801628 L8.7295372,14.6839411 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																			</g>
																		</svg>
																	</span>
																	<span class="menu-text">Reports</span><i class="menu-arrow"></i>
																</a>
																<div class="menu-submenu menu-submenu-classic menu-submenu-right" >
																	<ul class="menu-subnav">
																		<li class="menu-item  <?= $page_name =='Invoice' || $page_name =='Invoice Management'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('manage-invoice')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Invoice Management</span></a></li>
																		<li class="menu-item <?= $page_name =='System Transaction Records'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('transaction-records')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">System Transaction Records</span></a></li>
																		<li class="menu-item <?= $page_name =='Transaction'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('transaction')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Transaction - Stripe</span></a></li>
																		<li class="menu-item <?= $page_name =='Ads Sold'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('ads-sold')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Ads Sold</span></a></li>
																		<li class="menu-item <?= $page_name =='Inventory Availability'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('inventory')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Inventory Availability</span></a></li>
																		<li class="menu-item <?= $page_name =='Income'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('view-income')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Income</span></a></li>
																		<li class="menu-item <?= $page_name =='Current Revenue'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('current-revenue')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Current Revenue</span></a></li>
																		<li class="menu-item <?= $page_name =='Connected Accounts'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('connected-accounts')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Connected Accounts</span></a></li>
																		<li class="menu-item <?= $page_name =='Revenue By User'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('revenue-view')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Revenue By User</span></a></li>
																	</ul>
																</div>
															</li>
															<li class="menu-item  menu-item-submenu 
																<?= $page_name == "Manage Page Announcements" || $page_name == "Manage Partner Types" || $page_name == 'Manage Subscribers' ||
                                  $page_name == "Manage Gallery" ||
																	$page_name == "View Newsletter" || $page_name == "Manage Newsletter" || $page_name == "Manage Partner" || 
																	$page_name == "Manage SEO Operation" || $page_name == "Manage Document Categories" || $page_name == "Manage Documents"?'menu-item-open menu-item-here':''?>" 
																	data-menu-toggle="hover" aria-haspopup="true">
																<a  href="javascript:;" class="menu-link menu-toggle">
																	<span class="svg-icon menu-icon">
																		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24"/>
																				<rect fill="#000000" opacity="0.3" x="4" y="5" width="16" height="6" rx="1.5"/>
																				<rect fill="#000000" x="4" y="13" width="16" height="6" rx="1.5"/>
																			</g>
																		</svg>
																	</span>
																	<span class="menu-text">Site Management</span><i class="menu-arrow"></i>
																</a>
																<div class="menu-submenu menu-submenu-classic menu-submenu-right" >
																	<ul class="menu-subnav">
																		<li class="menu-item <?= $page_name =='Manage Newsletter'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('newsletter')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Manage Newsletter</span></a></li>
																		<li class="menu-item <?= $page_name =='View Newsletter'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('newsletter')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">View Newsletter</span></a></li>
																		<li class="menu-item <?= $page_name =='Manage Subscribers'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('manage-subscribers')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Manage Subscribers</span></a></li>
																		<li class="menu-item <?= $page_name =='Manage Document Categories'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('training-category')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Manage Document Categories</span></a></li>
																		<li class="menu-item <?= $page_name =='Manage Documents'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('manage-training')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Manage Documents</span></a></li>
																		<li class="menu-item <?= $page_name =='Manage Partner Types'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('resource-type')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Manage Partner Types</span></a></li>
																		<li class="menu-item <?= $page_name =='Manage Partner'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('manage-resource')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Manage Partner</span></a></li>
																		<li class="menu-item <?= $page_name =='Manage SEO Operation'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('seo-operation')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Manage SEO Operation</span></a></li>
																		<li class="menu-item <?= $page_name =='Manage Page Announcements'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('manage-pa')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Manage Page Announcements</span></a></li>
																		<li class="menu-item <?= $page_name =='Manage Gallery'?'menu-item-open menu-item-here':''?>"  aria-haspopup="true"><a  href="{{route('manage-gallery')}}" class="menu-link "><i class="menu-bullet menu-bullet-dot"><span></span></i><span class="menu-text">Manage Gallery</span></a></li>
																	</ul>
																</div>
															</li>
															<!-- <li class="menu-item  <?= $page_name =='Manage Sales'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																<a href="/manage_sales" class="menu-link">
																	<span class="svg-icon menu-icon">
																		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24"/>
																				<path d="M18,2 L20,2 C21.6568542,2 23,3.34314575 23,5 L23,19 C23,20.6568542 21.6568542,22 20,22 L18,22 L18,2 Z" fill="#000000" opacity="0.3"/>
																				<path d="M5,2 L17,2 C18.6568542,2 20,3.34314575 20,5 L20,19 C20,20.6568542 18.6568542,22 17,22 L5,22 C4.44771525,22 4,21.5522847 4,21 L4,3 C4,2.44771525 4.44771525,2 5,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z" fill="#000000"/>
																			</g>
																		</svg>
																	</span>
																	<span class="menu-text">Manage Sales</span>
																</a>
															</li> -->
															<li class="menu-item <?= $page_name =='Suggestions'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																<a href="/suggest" class="menu-link">
																	<span class="svg-icon menu-icon">
																		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24" />
																				<rect fill="#000000" opacity="0.3" x="4" y="4" width="4" height="4" rx="2" />
																				<rect fill="#000000" x="4" y="10" width="4" height="4" rx="2" />
																				<rect fill="#000000" x="10" y="4" width="4" height="4" rx="2" />
																				<rect fill="#000000" x="10" y="10" width="4" height="4" rx="2" />
																				<rect fill="#000000" x="16" y="4" width="4" height="4" rx="2" />
																				<rect fill="#000000" x="16" y="10" width="4" height="4" rx="2" />
																				<rect fill="#000000" x="4" y="16" width="4" height="4" rx="2" />
																				<rect fill="#000000" x="10" y="16" width="4" height="4" rx="2" />
																				<rect fill="#000000" x="16" y="16" width="4" height="4" rx="2" />
																			</g>
																		</svg>																	
																	</span>
																	<span class="menu-text">Suggestions</span>
																</a>
															</li>
														</ul>
													</div>
												</li>
											<?php }?>
											<?php
												if(session("level") < 2){
											?>
												<li class="menu-item <?= $page_name =='Dashboard'?'menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here':''?>" >
													<a href="/dashboard" class="menu-link">
														<span class="menu-text">Dashboard</span>
														<span class="menu-desc"></span>
														<i class="menu-arrow"></i>
													</a>
												</li>
												<li class="menu-item <?= $page_name =='Invoice' || $page_name =='Campaign Manager' || $page_name =='Create Campaign' || $page_name =='Edit Campaign'?'menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here':''?>" >
													<a href="/manage-campaign" class="menu-link">
														<span class="menu-text">Campaign Manager</span>
														<span class="menu-desc"></span>
														<i class="menu-arrow"></i>
													</a>
												</li>
												<li class="menu-item <?= $page_name =='Create New Ad'?'menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here':''?>" >
													<a href="/update_ad" class="menu-link">
														<span class="menu-text">Create New Ad</span>
														<span class="menu-desc"></span>
														<i class="menu-arrow"></i>
													</a>
												</li>
												<li class="menu-item <?= $page_name =='Manage Playlist'?'menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here':''?>" >
													<a href="/manage_playlist" class="menu-link">
														<span class="menu-text">Manage Playlist</span>
														<span class="menu-desc"></span>
														<i class="menu-arrow"></i>
													</a>
												</li>
												<li class="menu-item <?= $page_name =='Advertising Tools'?'menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here':''?>" >
													<a href="/graphic-design" class="menu-link">
														<span class="menu-text">Advertising Tools</span>
														<span class="menu-desc"></span>
														<i class="menu-arrow"></i>
													</a>
												</li>
											<?php }?>
											<!-- Account Manager -->
											@if(session('level') == 3)
												@include('admin.include.account-menu')
											@elseif(session('level') == 4)
												@include('admin.include.account-menu')
											@else
												@if(session('level') >= 3)
													<li class="menu-item <?php if($page_name == "Campaign Manager" || $page_name=='Edit Campaign' || $page_name=='Create Campaign' || $page_name =='Manage Playlist' ||$page_name =='Create New Ad' || $page_name =='My Personal Account'){
														echo 'menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here';
													}
													else{
															echo 'menu-item-submenu menu-item-rel';
														}?>" data-menu-toggle="click" aria-haspopup="true">
														<a href="javascript:;" class="menu-link menu-toggle">
															<span class="menu-text">Client Advertising</span>
															<span class="menu-desc"></span>
															<i class="menu-arrow"></i>
														</a>
														<div class="menu-submenu menu-submenu-classic menu-submenu-left">
															<ul class="menu-subnav">
																<li class="menu-item menu-item-submenu <?= $page_name =='Campaign Manager'|| $page_name=='Edit Campaign' || $page_name=='Create Campaign'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																	<a href="/manage-campaign" class="menu-link">
																		<span class="svg-icon menu-icon">
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<rect x="0" y="0" width="24" height="24"/>
																					<rect fill="#000000" opacity="0.3" x="4" y="4" width="4" height="4" rx="2"/>
																					<rect fill="#000000" x="4" y="10" width="4" height="4" rx="2"/>
																					<rect fill="#000000" x="10" y="4" width="4" height="4" rx="2"/>
																					<rect fill="#000000" x="10" y="10" width="4" height="4" rx="2"/>
																					<rect fill="#000000" x="16" y="4" width="4" height="4" rx="2"/>
																					<rect fill="#000000" x="16" y="10" width="4" height="4" rx="2"/>
																					<rect fill="#000000" x="4" y="16" width="4" height="4" rx="2"/>
																					<rect fill="#000000" x="10" y="16" width="4" height="4" rx="2"/>
																					<rect fill="#000000" x="16" y="16" width="4" height="4" rx="2"/>
																				</g>
																			</svg>
																		</span>
																		<span class="menu-text">Manage Campaign</span>
																	</a>
																</li>
																<li class="menu-item menu-item-submenu <?= $page_name =='Create New Ad'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																	<a href="/update_ad" class="menu-link">
																		<span class="svg-icon menu-icon">
																			<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Chat-check.svg-->
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<rect x="0" y="0" width="24" height="24" />
																					<path d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																					<path d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z" fill="#000000" />
																				</g>
																			</svg>
																			
																		</span>
																		<span class="menu-text">Create New Ad</span>
																	</a>
																</li>
																<li class="menu-item <?= $page_name =='Manage Playlist'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																	<a href="/manage_playlist" class="menu-link">
																		<span class="svg-icon menu-icon">
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<rect x="0" y="0" width="24" height="24"/>
																					<path d="M4.5,6 L19.5,6 C20.8807119,6 22,6.97004971 22,8.16666667 L22,16.8333333 C22,18.0299503 20.8807119,19 19.5,19 L4.5,19 C3.11928813,19 2,18.0299503 2,16.8333333 L2,8.16666667 C2,6.97004971 3.11928813,6 4.5,6 Z M4,8 L4,17 L20,17 L20,8 L4,8 Z" fill="#000000" fill-rule="nonzero"/>
																					<polygon fill="#000000" opacity="0.3" points="4 8 4 17 20 17 20 8"/>
																					<rect fill="#000000" opacity="0.3" x="7" y="20" width="10" height="1" rx="0.5"/>
																				</g>
																			</svg>
																			
																		</span>
																		<span class="menu-text">Manage Playlist</span>
																	</a>
																</li>
																<li class="menu-item <?= $page_name =='My Personal Account'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																	<a href="/account" class="menu-link">
																		<span class="svg-icon menu-icon">
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<rect x="0" y="0" width="24" height="24" />
																					<path d="M18,2 L20,2 C21.6568542,2 23,3.34314575 23,5 L23,19 C23,20.6568542 21.6568542,22 20,22 L18,22 L18,2 Z" fill="#000000" opacity="0.3" />
																					<path d="M5,2 L17,2 C18.6568542,2 20,3.34314575 20,5 L20,19 C20,20.6568542 18.6568542,22 17,22 L5,22 C4.44771525,22 4,21.5522847 4,21 L4,3 C4,2.44771525 4.44771525,2 5,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z" fill="#000000" />
																				</g>
																			</svg>
																		</span>
																		<span class="menu-text">My Personal Account</span>
																	</a>
																</li>
															</ul>
														</div>
													</li>
													@if(session('level') >= 2 || session('level') < 5)
													<li class="menu-item <?php echo $page_name =='Manage Business Account' || $page_name == 'Update Business Account'?'menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here':''?>" >
														<a href="{{route('business-account')}}" class="menu-link">
															<span class="menu-text">Manage Business Account</span>
															<span class="menu-desc"></span>
															<i class="menu-arrow"></i>
														</a>
													</li>
													@endif
												@endif
												@if(session('level') != 5 && session('level') != 2)
												<!-- <li class="menu-item <?= $page_name == 'History of Process Socials' || $page_name =='Post Social Media'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
													<a href="/social-posts" class="menu-link">
														<span class="menu-text">Post Social Media</span>
													</a>
												</li> -->
												@endif
												<li class="menu-item <?php if( $page_name =='Account Administration' || $page_name == "Our Business Information" || $page_name == "My Statements" || $page_name == "Manage Subscription" || $page_name =='My Personal Account' || $page_name == "My Trusted Agents" || $page_name == "Link to Social Media"){
														echo 'menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here';
													}
													else{
														echo 'menu-item-submenu menu-item-rel';
													}?>" data-menu-toggle="click" aria-haspopup="true">
													<a href="javascript:;" class="menu-link menu-toggle">
														<span class="menu-text">My Profile</span>
														<span class="menu-desc"></span>
														<i class="menu-arrow"></i>
													</a>
													<div class="menu-submenu menu-submenu-classic menu-submenu-left">
														<ul class="menu-subnav">
															<li class="menu-item menu-item-submenu <?= $page_name =='My Personal Account'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																<a href="/account" class="menu-link">
																	<span class="svg-icon menu-icon">
																		<i class='far fa-user'></i>
																	</span>
																	<span class="menu-text">My Personal Account</span>
																</a>
															</li>
															@if(session('level') == 1)
															<li class="menu-item menu-item-submenu <?= $page_name =='Our Business Information'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																<a href="/edit-business/{{base64_encode(session('user_id'))}}" class="menu-link">
																	<span class="svg-icon menu-icon">
																		<i class="fas fa-briefcase"></i>
																	</span>
																	<span class="menu-text">Our Business Information</span>
																</a>
															</li>
															@endif
															@if(session('level') > 0)
															<li class="menu-item menu-item-submenu <?= $page_name =='My Trusted Agents'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																<a href="/trust" class="menu-link">
																	<span class="svg-icon menu-icon">
																		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24" />
																				<path d="M22,17 L22,21 C22,22.1045695 21.1045695,23 20,23 L4,23 C2.8954305,23 2,22.1045695 2,21 L2,17 L6.27924078,17 L6.82339262,18.6324555 C7.09562072,19.4491398 7.8598984,20 8.72075922,20 L15.381966,20 C16.1395101,20 16.8320364,19.5719952 17.1708204,18.8944272 L18.118034,17 L22,17 Z" fill="#000000" />
																				<path d="M2.5625,15 L5.92654389,9.01947752 C6.2807805,8.38972356 6.94714834,8 7.66969497,8 L16.330305,8 C17.0528517,8 17.7192195,8.38972356 18.0734561,9.01947752 L21.4375,15 L18.118034,15 C17.3604899,15 16.6679636,15.4280048 16.3291796,16.1055728 L15.381966,18 L8.72075922,18 L8.17660738,16.3675445 C7.90437928,15.5508602 7.1401016,15 6.27924078,15 L2.5625,15 Z" fill="#000000" opacity="0.3" />
																				<path d="M11.1288761,0.733697713 L11.1288761,2.69017121 L9.12120481,2.69017121 C8.84506244,2.69017121 8.62120481,2.91402884 8.62120481,3.19017121 L8.62120481,4.21346991 C8.62120481,4.48961229 8.84506244,4.71346991 9.12120481,4.71346991 L11.1288761,4.71346991 L11.1288761,6.66994341 C11.1288761,6.94608579 11.3527337,7.16994341 11.6288761,7.16994341 C11.7471877,7.16994341 11.8616664,7.12798964 11.951961,7.05154023 L15.4576222,4.08341738 C15.6683723,3.90498251 15.6945689,3.58948575 15.5161341,3.37873564 C15.4982803,3.35764848 15.4787093,3.33807751 15.4576222,3.32022374 L11.951961,0.352100892 C11.7412109,0.173666017 11.4257142,0.199862688 11.2472793,0.410612793 C11.1708299,0.500907473 11.1288761,0.615386087 11.1288761,0.733697713 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.959697, 3.661508) rotate(-270.000000) translate(-11.959697, -3.661508)" />
																			</g>
																		</svg>
																	</span>
																	<span class="menu-text">My Trusted Agents</span>
																</a>
															</li>
															@endif
															<!-- <li class="menu-item menu-item-submenu <?= $page_name =='Link to Social Media'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																<a href="/socials" class="menu-link">
																	<span class="svg-icon menu-icon">
																		<i class="fab fa-twitter"></i>
																	</span>
																	<span class="menu-text">Link to Social Media</span>
																</a>
															</li> -->
															@if(session('level') == 2)
															<li class="menu-item <?= $page_name =='Account Administration'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																<a href="/add-bank" class="menu-link">
																	<span class="svg-icon menu-icon">
																		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24"/>
																				<path d="M13.5,21 L13.5,18 C13.5,17.4477153 13.0522847,17 12.5,17 L11.5,17 C10.9477153,17 10.5,17.4477153 10.5,18 L10.5,21 L5,21 L5,4 C5,2.8954305 5.8954305,2 7,2 L17,2 C18.1045695,2 19,2.8954305 19,4 L19,21 L13.5,21 Z M9,4 C8.44771525,4 8,4.44771525 8,5 L8,6 C8,6.55228475 8.44771525,7 9,7 L10,7 C10.5522847,7 11,6.55228475 11,6 L11,5 C11,4.44771525 10.5522847,4 10,4 L9,4 Z M14,4 C13.4477153,4 13,4.44771525 13,5 L13,6 C13,6.55228475 13.4477153,7 14,7 L15,7 C15.5522847,7 16,6.55228475 16,6 L16,5 C16,4.44771525 15.5522847,4 15,4 L14,4 Z M9,8 C8.44771525,8 8,8.44771525 8,9 L8,10 C8,10.5522847 8.44771525,11 9,11 L10,11 C10.5522847,11 11,10.5522847 11,10 L11,9 C11,8.44771525 10.5522847,8 10,8 L9,8 Z M9,12 C8.44771525,12 8,12.4477153 8,13 L8,14 C8,14.5522847 8.44771525,15 9,15 L10,15 C10.5522847,15 11,14.5522847 11,14 L11,13 C11,12.4477153 10.5522847,12 10,12 L9,12 Z M14,12 C13.4477153,12 13,12.4477153 13,13 L13,14 C13,14.5522847 13.4477153,15 14,15 L15,15 C15.5522847,15 16,14.5522847 16,14 L16,13 C16,12.4477153 15.5522847,12 15,12 L14,12 Z" fill="#000000"/>
																				<rect fill="#FFFFFF" x="13" y="8" width="3" height="3" rx="1"/>
																				<path d="M4,21 L20,21 C20.5522847,21 21,21.4477153 21,22 L21,22.4 C21,22.7313708 20.7313708,23 20.4,23 L3.6,23 C3.26862915,23 3,22.7313708 3,22.4 L3,22 C3,21.4477153 3.44771525,21 4,21 Z" fill="#000000" opacity="0.3"/>
																			</g>
																		</svg>
																	</span>
																	<span class="menu-text">Account Administration</span>
																</a>
															</li>
															@endif
															<!-- <li class="menu-item menu-item-submenu <?= $page_name =='Snap-Shot Subscription'?'menu-item-open menu-item-here':''?> menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
																<a href="/manage-campaign" class="menu-link">
																	<span class="svg-icon menu-icon">
																		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24"/>
																				<rect fill="#000000" opacity="0.3" x="4" y="4" width="4" height="4" rx="2"/>
																				<rect fill="#000000" x="4" y="10" width="4" height="4" rx="2"/>
																				<rect fill="#000000" x="10" y="4" width="4" height="4" rx="2"/>
																				<rect fill="#000000" x="10" y="10" width="4" height="4" rx="2"/>
																				<rect fill="#000000" x="16" y="4" width="4" height="4" rx="2"/>
																				<rect fill="#000000" x="16" y="10" width="4" height="4" rx="2"/>
																				<rect fill="#000000" x="4" y="16" width="4" height="4" rx="2"/>
																				<rect fill="#000000" x="10" y="16" width="4" height="4" rx="2"/>
																				<rect fill="#000000" x="16" y="16" width="4" height="4" rx="2"/>
																			</g>
																		</svg>
																	</span>
																	<span class="menu-text">Snap-Shot Subscription</span>
																</a>
															</li> -->
														</ul>
													</div>
												</li>
											@endif
										</ul>
									</div>
								</div>
							</div>
							<div class="topbar">
								<!-- <div class="dropdown">
                                    <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                                        <div class="btn btn-icon btn-hover-transparent-white btn-dropdown btn-lg mr-1 pulse pulse-primary">
                                            <span class="svg-icon svg-icon-xl">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3" />
                                                        <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000" />
                                                    </g>
                                                </svg>
                                            </span>
                                            <span class="pulse-ring"></span>
                                        </div>
                                    </div>
                                    <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
                                        <form>
                                            <div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: url(/assets/media/misc/bg-1.jpg)">
                                                <h4 class="d-flex flex-center rounded-top">
                                                    <span class="text-white">Newsletter</span>
                                                </h4>
                                                <ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-line-transparent-white nav-tabs-line-active-border-success mt-3 px-8" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active show" data-toggle="tab" href="#topbar_notifications_notifications">All</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#topbar_notifications_events">Unread</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#topbar_notifications_logs">Read</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-content">
                                                <div class="tab-pane active show p-8" id="topbar_notifications_notifications" role="tabpanel">
                                                    <div class="scroll pr-7 mr-n7 all-news" data-scroll="true" data-height="300" data-mobile-height="200">
                                                        
                                                    </div>
                                                    <div class="d-flex flex-center pt-7">
                                                        <a href="/newsletter" class="btn btn-light-primary font-weight-bold text-center">See All</a>
                                                    </div>
                                                </div>
                                                <div class="tab-pane p-8" id="topbar_notifications_events" role="tabpanel">
													<div class="scroll pr-7 mr-n7 unread-news" data-scroll="true" data-height="300" data-mobile-height="200">
                                                        
                                                    </div>
                                                </div>
                                                <div class="tab-pane p-8" id="topbar_notifications_logs" role="tabpanel">
                                                    <div class="scroll pr-7 mr-n7 read-news" data-scroll="true" data-height="300" data-mobile-height="200">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div> -->
								<div class="topbar-item" data-toggle="tooltip" data-placement="left" title="Suggestion Box - Make a suggestion or point out an error">
									<div class="btn btn-icon btn-hover-transparent-white btn-lg mr-1 pulse pulse-danger" 
										data-toggle="modal" data-target="#suggest_modal">
										<span class="svg-icon svg-icon-xl">
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
											<span class="text-white opacity-70 font-weight-bold font-size-base d-none d-md-inline mr-1">
												<i class="fas fa-user"></i>
											</span>
											<span class="text-white opacity-90 font-weight-bolder font-size-base d-none d-md-inline mr-4">{{session("user_name")}}</span>
										</div>
									</div>
									<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg p-0">
										<div class="d-flex align-items-center p-8 rounded-top">
											<!-- <div class="symbol symbol-md bg-light-primary mr-3 flex-shrink-0"> -->
												<!-- <img src="assets/media/users/300_21.jpg" alt="" /> -->
											<!-- </div> -->
											<div class="text-dark m-0 flex-grow-1 mr-3 font-size-h5">{{session("user_name")}}</div>
											<!-- <span class="label label-light-success label-lg font-weight-bold label-inline">3 messages</span> -->
										</div>
										<div class="separator separator-solid"></div>
										<div class="navi navi-spacer-x-0 pt-5">
											<a href="/account" class="navi-item px-8">
												<div class="navi-link">
													<div class="navi-icon mr-2">
														<span class="svg-icon svg-icon-success svg-icon-2x">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24"/>
																	<path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																	<path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
																</g>
															</svg>
														</span>
													</div>
													<div class="navi-text">
														<div class="font-weight-bold">My Profile</div>
													</div>
												</div>
											</a>
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
					<div class="subheader pt-5 pb-5 top-transparent " id="kt_topheader">
						<div class=" container  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
							<div class="d-flex align-items-center flex-wrap mr-1">
								<div class="d-flex flex-column">
									<h2 class="text-white font-weight-bold my-2 mr-5">
										{{$page_name}}
									</h2>
								</div>
							</div>
							<div class="d-flex align-items-center">
								<div class="d-flex flex-column">
									<h2 class="text-white font-weight-bold my-2 mr-5 top-business">
										{{session('business_name')}}
									</h2>
								</div>
                            </div>
                        </div>
					</div>
    