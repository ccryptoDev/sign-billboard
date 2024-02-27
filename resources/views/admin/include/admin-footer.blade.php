        
        
			<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
				<div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
					<div class="text-dark order-2 order-md-1">
						<span class="text-muted font-weight-bold mr-2">{{date("Y")}}©</span>
						<a href="/" target="_blank" class="text-dark-75 text-hover-primary">INEX</a>
					</div>
					<div class="nav nav-dark order-1 order-md-2">
						<a href="/about_us" target="_blank" class="nav-link pr-3 pl-0">About</a>
						<a style="cursor:pointer" data-toggle="modal" data-target="#term_modal" class="nav-link pr-3 pl-0">Terms of Service</a>
						<!-- <a href="/contact" target="_blank" class="nav-link pl-3 pr-0">Contact</a> -->
						<!-- <a href="tel:405-415-3002" class="nav-link pl-3 pr-0" title="Call"><i class="fas fa-mobile-alt mr-2"></i>Call us 405-415-3002</a> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="kt_scrolltop" class="scrolltop">
	<span class="svg-icon">
		<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->
		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				<polygon points="0 0 24 0 24 24 0 24" />
				<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
				<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
			</g>
		</svg>
	</span>
</div>
<ul class="sticky-toolbar nav flex-column pl-2 pr-2 pt-3 pb-3 mt-4">
	<li class="nav-item" id="kt_demo_panel_toggle" data-toggle="tooltip" title="??? Call Us Now" data-placement="right">
		<a class="btn btn-sm btn-icon btn-bg-danger btn-icon-success" href="tel:405-415-3002">
			<i class="flaticon2-phone text-white"></i>
		</a>
	</li>
	<li class="nav-item mt-2" id="kt_demo_panel_toggle" data-toggle="tooltip" title="Google Review" data-placement="right">
		<a class="btn btn-sm btn-icon btn-bg-success btn-icon-success" target="_blank" href="https://g.page/r/CalqxUYJd-yuEA0/review">
			<i class="fab fa-google text-white"></i>
		</a>
	</li>
</ul>
<div class="modal fade" id="FaqModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{$page_name}} FAQs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				@if($page_name == 'Campaign Manager' || $page_name == 'Create Campaign')
				<div class="tab-content">
					<div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle" id="faq">
						<div class="card">
							<div class="card-header" id="faqHeading1">
								<a class="card-title text-dark" data-toggle="collapse" href="#faq1" aria-expanded="true" aria-controls="faq1"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">What is a Campaign?</div>
								</a>
							</div>
							<div id="faq1" class="collapse show" aria-labelledby="faqHeading1" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									A Campaign controls
									<ul>
										<li>when you advertise,</li>
										<li>how long you advertise,</li>
										<li>the days of the week you want to advertise, and</li>
										<li>where you want to advertise.</li>
									</ul>
									You Create New Ads by uploading images. Each Ad can have its own personal schedule. These Ads are then all listed under Manage Playlist. Only Ads you have checked under Manage Playlist will go to the billboard. But the campaign you create here controls when they are actually displayed as a group.
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading2">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq2" aria-expanded="true" aria-controls="faq2"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">Do I need to create a Campaign?</div>
								</a>
							</div>
							<div id="faq2" class="collapse" aria-labelledby="faqHeading2" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									You MUST have a Campaign to get your advertisements displayed on a billboard.
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading3">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq3" aria-expanded="true" aria-controls="faq3"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">Can I have more than 1 Campaign?</div>
								</a>
							</div>
							<div id="faq3" class="collapse" aria-labelledby="faqHeading3" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									Yes, there is no limit to the number of campaigns you can create.
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading4">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq4" aria-expanded="true" aria-controls="faq4"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">Am I charged for advertising before or after a campaign ends?</div>
								</a>
							</div>
							<div id="faq4" class="collapse" aria-labelledby="faqHeading4" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									No. You are only charged for the time period you chose to run your campaign(s). This approach allows you to start and stop advertising. For example, you could run a campaign for 4 weeks and then stop. You then could create a second campaign to start 2 weeks after the first campaign ended. You do not get charged for the two weeks in which you did not advertise.
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading5">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq5" aria-expanded="true" aria-controls="faq5"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">Can I stop a Campaign early?</div>
								</a>
							</div>
							<div id="faq5" class="collapse" aria-labelledby="faqHeading5" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									Maybe.
									<ul>
										<li>Yes, but only if there is enough time left in the campaign. If you created a 12-week campaign, and pay Weekly or every Four Weeks, you can stop getting charged again by hitting the square Stop button beside your campaign. The program will complete the time that you purchased. You cannot ever eliminate the current week or the balance of a Four Week purchase since it is already underway.</li>
										<li>No. If you are not programmed to pay again, you cannot shorten the time left.</li>
										<li>You can remove an ad or ads from the Manage Playlist and republish if you want a particular ad to not show. </li>
									</ul>
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading6">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq6" aria-expanded="true" aria-controls="faq6"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">Can I modify a Campaign before it starts?</div>
								</a>
							</div>
							<div id="faq6" class="collapse" aria-labelledby="faqHeading6" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									<ul>
                                        <li>If you have not paid for the Campaign yet, you can change anything you want prior to its start date.</li>
                                    </ul>
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading7">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq7" aria-expanded="true" aria-controls="faq7"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">Can I modify the Campaign after it has started?</div>
								</a>
							</div>
							<div id="faq7" class="collapse" aria-labelledby="faqHeading7" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									No. Your only option is to create a new Campaign.
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading8">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq8" aria-expanded="true" aria-controls="faq8"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">What is the difference between paying by credit card and being invoiced?</div>
								</a>
							</div>
							<div id="faq8" class="collapse" aria-labelledby="faqHeading8" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									When you pay by credit card, you are paying immediately. If you choose Invoicing, an email is delivered to your billing email address on record. You will either need to pay by delivering a check before the campaign start date or return here to pay by credit card. You can always switch between getting an invoice or using a credit card.
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading9">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq9" aria-expanded="true" aria-controls="faq9"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">What is the difference between Pay In-Full, 4 Week billing, and Weekly billing?</div>
								</a>
							</div>
							<div id="faq9" class="collapse" aria-labelledby="faqHeading9" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									<ul>
                                        <li>If you chose to Pay In-Full, we will add up the entire amount for the entire length of the campaign. You will not get charged again.</li>
                                        <li>If you chose 4 Week billing, we calculate the cost for a four-week period. If your campaign is longer than the initial four weeks, we will automatically charge your credit card for the next four-week period (or remaining number of weeks if there are less than four remaining at that point. If you requested an invoice, you automatically receive an emailed invoice every four weeks. You will have to pay it prior to that next four week start date.</li>
                                        <li>If you chose 1 week billing, we calculate the cost for one week. We will automatically charge your credit card every week for the amount displayed. Invoicing is not available for weekly billing, only credit card.</li>
                                    </ul>
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading10">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq10" aria-expanded="true" aria-controls="faq10"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">Why does my Campaign Status show Overdue?</div>
								</a>
							</div>
							<div id="faq10" class="collapse" aria-labelledby="faqHeading10" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									If you chose to be invoiced and have not delivered a check to us by 3 days prior to the Campaign Start Date, the status changes to overdue. You should also have received an email reminder.
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading11">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq11" aria-expanded="true" aria-controls="faq11"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">Why does my Campaign Status shows Suspended?</div>
								</a>
							</div>
							<div id="faq11" class="collapse" aria-labelledby="faqHeading11" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									If you have not paid for your advertising by the Start Date, the Campaign is locked from delivering Ads to the billboards and it gets marked as Suspended. Paying by credit card will immediately remove the Suspended status and allow your ads to be delivered to the signs.
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading12">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq12" aria-expanded="true" aria-controls="faq12"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">How do I get a copy of a Campaign Invoice?</div>
								</a>
							</div>
							<div id="faq12" class="collapse" aria-labelledby="faqHeading12" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									Click on the $ icon in the Action Column. You will see your Invoice. Use the Print button if you wish to have a hardcopy of the invoice.
								</div>
							</div>
						</div>
					</div>
				</div>
				@endif
				@if($page_name == 'Create New Ad')
				<div class="tab-content">
					<div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle" id="faq">
						<div class="card">
							<div class="card-header" id="faqHeading1">
								<a class="card-title text-dark" data-toggle="collapse" href="#faq1" aria-expanded="true" aria-controls="faq1"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">Create New Ad</div>
								</a>
							</div>
							<div id="faq1" class="collapse show" aria-labelledby="faqHeading1" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									You Create New Ads by uploading images. Each Ad can have its own personal schedule. These Ads are then all listed under Manage Playlist. Only Ads you have Checked under Manager Playlist will go to the billboard. But the campaign you create here controls the Start and End date when they are actually displayed.
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading2">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq2" aria-expanded="true" aria-controls="faq2"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">Why does my image look distorted?</div>
								</a>
							</div>
							<div id="faq2" class="collapse" aria-labelledby="faqHeading2" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									The image you are uploading must have the same Aspect Ratio as the Billboard sign. Most of our signs are 1:5 to 1 Aspect Ratio. This means the image must be 1 1⁄2 times wide as it is tall.
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading3">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq3" aria-expanded="true" aria-controls="faq3"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">Why do I set a Schedule for an Ad?</div>
								</a>
							</div>
							<div id="faq3" class="collapse" aria-labelledby="faqHeading3" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									Even though you set the dates for a Campaign, each Ad can have its own schedule. A Campaign can further restricts its display with its own time restrictions.
									</br>
									“Display Continuously” is the default choice. This option means it can be shown any time within the campaign’s options that you selected.
									</br>
									“Selected specific Dates and Times” allows you to set a specific day of the week, a very specific
									time of the day, and even its own End Date. For example, you can set a Campaign to run
									st th
									between November 1 and January 15 . Within that campaign, you can set an Ad to end on
									th
									December 25 . It will not be displayed on the billboard after that date. Or you can set the Ad
									for every Thursday. If the campaign is not set to show on Thursday, it will not be seen.
									</br>
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading4">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq4" aria-expanded="true" aria-controls="faq4"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">What happens when I Save the Ad?</div>
								</a>
							</div>
							<div id="faq4" class="collapse" aria-labelledby="faqHeading4" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									You save the schedule and deposit it into the Playlist Manager. It is not set to display on a billboard yet. It is merely part of the list of potential Ads you can set as part of your Playlist.
								</div>
							</div>
						</div>
					</div>
				</div>
				@endif
				@if($page_name == 'Manage Playlist')
				<div class="tab-content">
					<div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle" id="faq">
						<div class="card">
							<div class="card-header" id="faqHeading1">
								<a class="card-title text-dark" data-toggle="collapse" href="#faq1" aria-expanded="true" aria-controls="faq1"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">Can I edit an individual Ad’s schedule?</div>
								</a>
							</div>
							<div id="faq1" class="collapse show" aria-labelledby="faqHeading1" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									Yes. Just click on the Edit button.
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading2">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq2" aria-expanded="true" aria-controls="faq2"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">How do I ensure my Ad is displayed on a billboard?</div>
								</a>
							</div>
							<div id="faq2" class="collapse" aria-labelledby="faqHeading2" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									Just check the box beside each Ad you want seen, then click Publish Playlist.
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading3">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq3" aria-expanded="true" aria-controls="faq3"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">How do I remove my Ad from a billboard?</div>
								</a>
							</div>
							<div id="faq3" class="collapse" aria-labelledby="faqHeading3" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									Just uncheck the box beside each Ad you don’t want seen, then click Publish Playlist.
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading4">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq4" aria-expanded="true" aria-controls="faq4"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">How does the Social Media link work?</div>
								</a>
							</div>
							<div id="faq4" class="collapse" aria-labelledby="faqHeading4" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									After you Publish Playlist, a social media popup offers to deliver any image or Ad to your social media accounts.
									<ul>
										<li>You must have previously set your social media links (see Social Media Links).</li>
										<li>Check one or more of the images.</li>
										<li>Write any additional text you want delivered.</li>
										<li>Select one or more social media that you use.</li>
										<li>Send</li>
									</ul>
									Your images and text will be sent to all of your followers and all our other client’s social media.
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading5">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq5" aria-expanded="true" aria-controls="faq5"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">Can I modify where an Ad is displayed?</div>
								</a>
							</div>
							<div id="faq5" class="collapse" aria-labelledby="faqHeading5" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									No. You choose where an Ad is displayed by using the Campaign Manager to set the location.
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading6">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq6" aria-expanded="true" aria-controls="faq6"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">Why did my Ad not get displayed on a billboard?</div>
								</a>
							</div>
							<div id="faq6" class="collapse" aria-labelledby="faqHeading6" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									The Ad media will be delivered to a billboard and displayed unless you did not perform the following:
									<ul>
                                        <li>You never checked the box in the left-hand column AND clicked Publish Playlist at the bottom of the screen. Any unchecked Ad will not be delivered to a billboard.</li>
                                        <li>You limited the Ad’s display to a specific day of the week, but you did not choose the same day in the Campaign Manager.</li>
                                        <li>You set the Ad to expire before or inside the time frame of your Campaign. For
											example, you could have set the Ad to expire on July 4th (it runs until midnight of that
											st st day). You may also have set the campaign to run from April 1 through August 31 .
											The Ad will not show after the 4th of July.</li>
                                        <li>You did not pay the bill for advertising.</li>
                                    </ul>
								</div>
							</div>
						</div>
						<div class="card border-top-0">
							<div class="card-header" id="faqHeading7">
								<a class="card-title collapsed text-dark" data-toggle="collapse" href="#faq7" aria-expanded="true" aria-controls="faq7"  role="button">
									<span class="svg-icon svg-icon-primary">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"/>
												<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
												<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
											</g>
										</svg>
									</span>
									<div class="card-label text-dark pl-4">What is the difference between Removing an Ad from the Playlist and deleting an Ad?</div>
								</a>
							</div>
							<div id="faq7" class="collapse" aria-labelledby="faqHeading7" data-parent="#faq">
								<div class="card-body text-dark-50 font-size-lg pl-12">
									If you remove an Ad from the playlist, all you have done is unchecked it. You can return at a later date and include it again in the Playlist. If you deleted an Ad, it is forever gone. You will have to Create a New Ad and reset its schedule to get it listed in the Playlist Manager page.
								</div>
							</div>
						</div>
					</div>
				</div>
				@endif
            </div>
            <div class="modal-footer">
				@if($page_name == 'Campaign Manager' || $page_name == 'Create Campaign')
					<a href='/guide/FAQs.pdf' target='_blank' class="d-block text-left btn btn-text-danger btn-light-danger btn-hover-danger font-weight-bold">Download</a>
				@endif
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="term_modal" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<h5 class='text-center'>Terms of Service</h5>
						<div>    
							<h6>1. Our Services</h6>
							<span>INEX believes we provide a unique Product. Our objective is to simplify and automate the process of advertising. In addition, we want you to be able to control your advertising and your budget. Our service allows you to focus on getting your business’ sales, promotions, etc. presented to potential customers in a very timely manner. All that while automatically delivering your Ads simultaneously to your social media (plus all our networked client social media accounts).</span>
						</div>
						<div>    
							<h6 class='mt-2'>Your commitments to INEX:</h6>
							<span>You agree to:</span>
							<ul>
								<li>Use our platform to advertise your products and services as a bona fide business.</li>
								<li>Register your company information correctly.</li>
								<li>Agree to our Terms of Service, our Community Standards, and any other terms and policies that apply.</li>
							</ul>
							<span>You agree not to:</span>
							<ul>
								<li>Use this advertising vehicle for personal usage. If you wish to deliver personal messages, please use <a href="https://www.bostmoments.com" target="_blank">www.bostmoments.com</a></li>
								<li>Post anything that is unlawful, misleading, discriminatory, or fraudulent.</li>
								<li>Use anything infringes or violates someone else's rights, including their intellectual property rights.</li>
								<li>Access or collect data from our Products and Services using automated means.</li>
							</ul>
							<span>We can restrict content that violates these provisions for any reason. We may inform you if we choose to remove any content displayed on our billboards. We will not refund your money for Ads you have placed that violate our rules. We do not grant any review process. We encourage you to report content that you believe violates your rights (including intellectual property rights) or our terms and policies. Contact us at <a href='mailto:support@inex.net'>support@inex.net.</a></span></br></br>
							<span>Permissions you give us:</span>
							<ul>
								<li>You grant us a non-exclusive, transferable, sub-licensable, royalty-free, and worldwide license to use, distribute, modify, run, copy, publicly perform or display, translate, and create derivative works of your content (consistent with your privacy and application settings). This license will end when your content is deleted from our systems. Your content will be deleted from our servers if you choose to delete it within your account. The exception would be where immediate deletion would restrict our ability to: investigate or identify illegal activity or violations of our terms and policies (for example, to identify or investigate misuse of our products or systems); comply with a legal obligation, such as the preservation of evidence; or comply with a request of a judicial or administrative authority, law enforcement or a government agency; In each of the above cases, this license will continue until the content has been fully deleted.
								</li>
								<li>You own the intellectual property rights in any such content that you upload to INEX. Nothing in these Terms takes away your rights. You are free to share your images with anyone else, wherever you want.</li>
								<li>If you use content covered by our intellectual property rights (for example, images, designs, videos, we retain all rights to that content (but not yours). You can only use our copyrights or trademarks (or any similar marks) with our prior written permission.</li>
							</ul>
						</div>
						<div>    
							<h6>3. Additional Provisions</h6>
							<ul>
								<li>Updating our Terms</li>
								<span>We may update these Terms anytime to reflect our services and practices. Once any updated Terms are in effect, you will be bound by them if you continue to use our Products. If you do not agree to our updated Terms, you may delete your account at any time.</span>
								<li>Account suspension or termination</li>
								<span> If we determine that you have breached our Terms or Policies, we may suspend or permanently disable access to your account. We may also suspend or disable your account when we are required to do so for legal reasons.</span>
								<li>Limits on liability</li>
								<span>Our Products, however, are provided "as is," and we make no guarantees that they always will be safe, secure, or error-free, or that they will function without disruptions, delays, or imperfections. To the extent permitted by law, we also DISCLAIM ALL WARRANTIES, WHETHER EXPRESS OR IMPLIED, INCLUDING THE IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, TITLE, AND NON- INFRINGEMENT. We do not control or direct what people and others do or say, and we are not responsible for their actions or conduct (whether online or offline) or any content they share (including offensive, inappropriate, obscene, unlawful, and other objectionable content). We cannot predict when issues might arise with our Products. Accordingly, our liability shall be limited to the fullest extent permitted by applicable law, and under no circumstance will we be liable to you for any lost profits, revenues, information, or data, or consequential, special, indirect, exemplary, punitive, or incidental damages arising out of or related to these Terms or INEX Products, even if we have been advised of the possibility of such damages. Our aggregate liability arising out of or relating to these Terms or the INEX Products will not exceed the greater of $100 or the amount you have paid us in the past three months.</span>
								<li>Disputes</li>
								<span>For any claim, cause of action, or dispute you have against us that arises out of or relates to these Terms or the INEX Products ("claim"), you agree that it will be resolved exclusively in the U.S. District Court for the Oklahoma, or a state court located in Oklahoma. You also agree to submit to the personal jurisdiction of either of these courts for the purpose of litigating any such claim, and that the laws of the State of Oklahoma will govern these Terms and any claim, without regard to conflict of law provisions.</span>
								<li>These Terms make up the entire agreement between you and INEX regarding your use of our Products. They supersede any prior agreements.</li>
								<li>If any portion of these Terms is found to be unenforceable, the remaining portion will remain in full force and effect. If we fail to enforce any of these Terms, it will not be considered a waiver. Any amendment to or waiver of these Terms must be made in writing and signed by us.</li>
								<li>You will not transfer any of your rights or obligations under these Terms to anyone else without our consent.</li>
								<li>These Terms do not confer any third-party beneficiary rights. Our rights and obligations under these Terms are freely assignable by us in connection with a merger, acquisition, or sale of assets, or by operation of law or otherwise.</li>
								<li>We always appreciate your feedback and other suggestions about our products and services. But you should know that we may use them without any restriction or obligation to compensate you, and we are under no obligation to keep them confidential.</li>
								<li>We reserve all rights not expressly granted to you.</li>
								<li>Other terms and policies that apply to you:</li>
								<ul>
									<li>Community Standards: These guidelines outline our standards regarding the content you post to INEX and your activity on INEX and other INEX Products.</li>
									<li>Advertising Policies: These policies specify what types of ad content are allowed by partners who advertise across the INEX Products.</li>
									<li>Payment Terms: These terms apply to payments made for using INEX.</li>
								</ul>
								<span>Date of Last Revision: December 26, 2020</span>

							</ul>
						</div>

						<h5 class='text-center'>Community Standards</h5>
						<span> Expression that threatens people has the potential to intimidate, exclude or silence others is not allowed on INEX. We are committed to protecting personal privacy and information. We expect that people will respect the dignity of others and not harass or degrade others.</span>
						<br><span>Report potentially violating content at <a href='mailto:support@inex.net'>support@inex.net</a> or <a href='tel:405-415-3002'>405-415-3002.</a></span>
						<br><span> The consequences for violating our Community Standards vary. We may just deny publishing content to our signs, warn someone regarding their violation, or just disable their account. We also may notify law enforcement when we believe there is a genuine risk of physical harm or a direct threat to public safety.</span>
						<div>    
							<h6 class="mt-2">Violence and Criminal Behavior</h6>
							<ul>
								<li>Violence and Incitement</li>
								<span>Threatening or calling for violence in non-serious ways may result in INEX denying content, disable accounts, and work with law enforcement (when we believe there is a genuine risk of physical harm or direct threats to public safety). We also try to consider the language and context to distinguish casual statements from content that constitutes a credible threat to public or personal safety.</span>
								<li>Dangerous Individuals and Organizations</li>
								<span> We do not allow any organizations or individuals that proclaim a violent mission or are engaged in violence to have a presence on INEX and its billboards. We also prevent content that expresses support or praise for groups, leaders, or individuals involved in these activities.</span>
								<li>Coordinating Harm and Publicizing Crime</li>
								<span>To prevent and disrupt harm and copycat behavior, we prohibit people from promoting or admitting to certain criminal or harmful activities targeted at people, businesses, property, or animals.</span>
								<li>Fraud and Deception</li>
								<span>To prevent and disrupt harmful or fraudulent activity, we deny content aimed at deliberately deceiving people to gain an unfair advantage or deprive another of money, property, or legal right.</span>
							</ul>
						</div>
						<div>    
							<h6>Safety</h6>
							<ul>
								<li>Child Sexual Exploitation, Abuse and Nudity</li>
								<span>We refuse to publish content that sexually exploits or endangers children.</span>
								<li>Sexual Exploitation of Adults</li>
								<span>We do not allow content that depicts, threatens, or promotes sexual violence, sexual assault, or sexual exploitation. We do not allow content that displays, advocates, or coordinates sexual acts.</span>
								<li>Privacy Violations and Image Privacy Rights</li>
								<span>You should not post personal or confidential information about others without first getting their consent. We also encourage people ways to report imagery that they believe to be in violation of their privacy rights.</span>
							</ul>
						</div>
						<div>    
							<h6>Objectionable Content</h6>
							<ul>
								<li>Violent and Graphic Content</li>
								<span>We will not display content that glorifies violence or celebrates the suffering or humiliation of others.</span>
								<li>Adult Nudity and Sexual Activity</li>
								<span>We restrict the display of nudity or sexual activity.</span>
							</ul>
						</div>
						<div>    
							<h6>Respecting Intellectual Property</h6>
							<ul>
								<li>Intellectual Property</li>
								<span>INEXs Terms of Service do not allow people to post content that violates someone else’s intellectual property rights, including copyright and trademark. You must own all the content and information you post on INEX. You must comply with other people’s copyrights, trademarks, and other legal rights.</span>
							</ul>
						</div>
						<h5 class='text-center'>Ad Policies</h5>
						<span><strong>The INEX Process</strong></span><br>
						<span>Before you can publish to any INEX signs, you must initially be established as a bona fide business by INEX. Once your account has been activated, your Primary Trusted Agent will be notified by email. Your Primary Trusted Agent or a Secondary Trusted Agent (designated by the Primary Trusted Agent) may post your images as long as they meet our Policies.</span>
						<ul>
							<li>Prohibited Content</li>
							<ul>
								<li>Illegal Products or Services. Your Products or Services must not constitute, facilitate, or promote illegal products, services, or activities. Ads targeting minors must not promote products, services, or content that are inappropriate, illegal, or unsafe, or that exploit, mislead, or exert undue pressure on the age groups targeted.</li>
								<li>Discriminatory Practices. Ads must not discriminate or encourage discrimination against people based on personal attributes such as race, ethnicity, color, national origin, religion, age, sex, sexual orientation, gender identity, family status, disability, medical or genetic condition.</li>
								<li>Tobacco and Related Products. Ads must not promote the sale or use of tobacco products and related paraphernalia. Advertisements must not promote electronic cigarettes, vaporizers, or any other products that simulate smoking.</li>
								<li>Unsafe Supplements. Ads must not promote the sale or use of unsafe supplements, as determined by INEX in its sole discretion.</li>
								<li>Weapons, Ammunition, or Explosives. Ads must not promote the sale or use of weapons, ammunition, or explosives. This includes advertisements for weapon modification accessories.</li>
								<li>Adult Products or Services. Ads must not promote the sale or use of adult products or services, except for ads regarding family planning and contraception. Ads for contraceptives must focus on the contraceptive features of the product, and not on sexual pleasure or sexual enhancement, and must be targeted to people 18 years or older.</li>
								<li>Adult Content. Ads must not contain adult content. This includes nudity, depictions of people in explicit or suggestive positions, or activities that are overly suggestive or sexually provocative. Ads that assert or imply the ability to meet someone, connect with them or view content created by them must not be positioned in a sexual way or with an intent to sexualize the person featured in the ad.</li>
								<li>Third-Party Infringement. Ads must not contain content that infringes upon or violates the rights of any third party, including copyright, trademark, privacy, publicity, or other personal or proprietary rights. To report content that you feel may infringe upon or violate your rights, please Contact Us at <a href='mailto:violation@inex.net'>violation@inex.net.</a></li>
								<li>Sensational Content. Ads must not contain shocking, sensational, inflammatory, or excessively violent content.</li>
								<li>Personal Attributes. Ads must not contain content that asserts or implies personal attributes. This includes direct or indirect assertions or implications about a person’s race, ethnic origin, religion, beliefs, age, sexual orientation or practices, gender identity, disability, medical condition (including physical or mental health), financial status, membership in a trade union, criminal record, or name.</li>
								<li>Controversial Content. Ads must not contain content that exploits crises or controversial political or social issues</li>
								<li>Cheating and Deceitful Practices. Ads may not promote products or services that are designed to enable a user to engage in cheating or deceitful practices.</li>
								<li>Grammar & Profanity. Ads must not contain profanity or bad grammar and punctuation. Symbols, numbers, and letters must be used properly without the intention of circumventing our ad review process or other enforcement systems.</li>
								<li>Multilevel Marketing. Ads promoting income opportunities must fully describe the associated product or business model. It must not promote business models offering quick compensation for little investment, including multilevel marketing opportunities.</li>
								<li>Penny Auctions. Ads may not promote penny auctions, bidding fee auctions, or other similar business models</li>
								<li>Misleading Claims. Ads must not contain deceptive, false, or misleading claims like those relating to the effectiveness or characteristics of a product or service or claims setting unrealistic expectations for users such as misleading health, employment, or weight-loss claims.</li>
								<li>Unacceptable Business Practices. Ads must not promote products, services, or offers using deceptive or misleading practices, including those meant to swindle people out of money or personal information.</li>
								<li>Prohibited Financial Products and Services. Ads must not promote financial products and services that are frequently associated with misleading or deceptive promotional practices.</li>
								<li>Dating. No online dating services Ads.</li>
							</ul>
							<li>Use of Our Brand Assets</li>
							<li>Ads must not imply a INEX endorsement or partnership of any kind or use our Brand in ads or our Copyrights & Trademarks without our written permission.</li>
							<li>Advertisers are responsible for understanding and complying with all applicable laws and regulations. Failure to comply may result in a variety of consequences, including the cancellation of Ads you have placed and termination of your account.</li>
							<li>We reserve the right to reject, approve or remove any ad for any reason, in our sole discretion, including Ads that negatively affect our relationship with our users or that promote content, services, or activities, contrary to our competitive position, interests, or advertising philosophy.</li>
							<li>These policies are subject to change at any time without notice.</li>
						</ul>
						<h5 class='text-center'>Payment Terms:</h5>
						<ul>
							<li>Making Payments</li>
								<ul>
									<li>When you make a payment through the INEX Products, you agree to provide valid payment credentials. When you have successfully added your payment credential, we will allow you to initiate a transaction using the payments features through the INEX Products.</li>
									<li>Our Terms of Service (Terms) apply to your use of payments features through the INEX Products. In the event of any conflict between these Payments Terms and the Terms, the Payments Terms shall prevail.</li>
								</ul>
							<li>Payment Methods</li>
								<ul>
									<li>You may fund your transactions using credit cards or debit cards.</li>
									<li>When you provide a payment credential to us, you confirm that you are permitted to use that payment credential. When you fund a transaction, you authorize us (and our designated payment processor) to charge the full amount to the payment credential you designate for the transaction. You also authorize us to collect and store that payment credential, along with other related transaction information. We may also use certain payment card updater services, whose availability varies by issuer, to ensure we have the most up-to-date information about payment credential we may store.</li>
									<li>If your transaction results in an overdraft or other fee from your bank, you alone are responsible for that fee.</li>
								</ul>
							<li>Actions We May Take</li>
								<ul>
									<li>We may cancel any transaction if we believe the transaction violates any Terms, or if we believe doing so may prevent financial loss.</li>
									<li>To prevent financial loss to you or to us, we may contact your payment credential issuer, law enforcement, or affected third parties (including other users) and share details of any payments you are associated with if we believe doing so may prevent financial loss or a violation of law.</li>
								</ul>
							<li>Disputes and Reversals</li>
								<ul>
									<li>If you believe that an unauthorized or otherwise problematic transaction has taken place under your account, you agree to notify us immediately, so that we may take action to prevent financial loss. Unless you submit the claim to us within 30 days after the charge, you will have waived, to the fullest extent permitted by law, all claims against us arising out of or otherwise related to the transaction.</li>
									<li>If you experience a technical failure or interruption of service that causes your payment to fail, you may request that your transaction be completed later.</li>
								</ul>
							<li>Notices and Amendments to Payments Terms</li>
								<ul>
									<li>By using payments features through the INEX Products, you agree that we may communicate with you electronically any important information regarding your payment(s) or your account. We may also provide notices to you by posting them on our website, or by sending them to a telephone number that you may have previously provided to us. Notices shall be considered received by you within 24 hours of the time posted or sent; notices by postal mail shall be considered received within three (3) business days of the time sent.</li>
									<li>Except as otherwise stated, you must send notices to us relating to payments through the INEX and these Payments Terms by postal mail to: INEX, Attn: Information Exchange Network, Inc., 17021 Wales Green Avenue, Edmond OK 73012.</li>
									<li>We may update these Payments Terms at any time without notice as we deem necessary to the full extent permitted by law. The Payments Terms in place at the time you confirm a transaction will govern that transaction.</li>
								</ul>
						</ul>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- FA -->
<?php 
$fc_content = [
	"Campaign Manager" => "Campaigns control where, when, how often, and how long your Ads are displayed.
		The number of days you select controls the cost.",
	"Create New Ad" => "You start here first once you have your Ads created.
		Upload as many Ads as you like.  There is no additional cost.",
	"Manage Playlist" => "This page controls what Ads will be displayed on the billboard(s).
		Change your Playlist anytime.  It delivers your changes to the signs within minutes.",
	"Resources" => "Use this page to get your Ads created and understand what Ads are effective."
];
$fc_list = [
	"Campaign Manager" => 2,
	"Create New Ad" => 3,
	"Manage Playlist" => 4,
	"Resources" => 5,
]
?>
@if(in_array($page_name, array_keys($fc_content)))
<button type="button" class="btn btn-primary btn-trust" data-toggle="modal" data-target="#fcModal" style="display:none"></button>
<!-- Modal-->
<div class="modal fade" id="fcModal" tabindex="-1" role="dialog" aria-labelledby="trustModal" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content bg-white">
			<?php
				$exist_pa = false;
				$pa_attach = "";
				if(isset($pa)){
					foreach($pa as $item){
						if($item->page_id ==$fc_list[$page_name]){
							$exist_pa = true;
							$pa_attach = $item->attachment;
						}
					}
				}
			?>
			@if($exist_pa == true)
				<div class="modal-header border-0">
				</div>
				<div class="modal-body border-0 pt-0">
					@if($pa_attach != "" || $pa_attach != null)
						<img src="/pdf/{{$pa_attach}}" style="max-width : 100%;width : 100%; max-height : 400px"/>
					@endif
				</div>
				<div class="modal-footer border-0">
					<button type="button" class="btn btn-primary font-weight-bold" data-dismiss="modal">Got It</button>
				</div>
			@else
				<div class="modal-header border-0">
					<h2 class="modal-title font-size-h2 text-dark" id="trustModal">{{$page_name}}</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i aria-hidden="true" class="ki ki-close"></i>
					</button>
				</div>
				<div class="modal-body border-0 pt-0 pb-0">
					<span class="text-dark font-size-h3" style="white-space:pre-line">
						{{isset($fc_content[$page_name])?$fc_content[$page_name]:''}}
					</span>
				</div>
				<div class="modal-footer border-0">
					<button type="button" class="btn btn-primary font-weight-bold" data-dismiss="modal">Got It</button>
				</div>
			@endif
        </div>
    </div>
</div>
@endif