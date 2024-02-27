@include('admin.include.admin-header')
                    
	
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
						<div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
						</div>
						<!--end::Subheader-->
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
								<!--begin::Row-->
								<div class="row">
									<div class="col-lg-12">
										<!--begin::Example-->
										<!--begin::Card-->
										<div class="card card-custom" data-card="true" id="kt_card_1">
											<div class="card-header">
												<div class="card-title">
													<h3 class="card-label">{{$page_name}} - {{session("business_name")}}</h3>
												</div>
												<div class="card-toolbar">
													<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Toggle Card">
														<i class="ki ki-arrow-down icon-nm"></i>
													</a>
												</div>
                                            </div>
                                            <div class="card-body">
                                                <form id="send_email">
                                                    <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-2">
                                                        <div class="col-xl-12 col-xxl-7">
                                                            <div class="form-group">
                                                                <label>User Name</label>
                                                                <input type="text" class="form-control" placeholder="" required value="{{$user->user_name}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Email address</label>
                                                                <input type="email" class="form-control" placeholder="" required value="{{$user->email}}">
                                                                <!-- <span class="form-text text-muted">Please user a REAL email address so that we can get back to you</span> -->
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Subject</label>
                                                                <input type="text" class="form-control" placeholder="" required>
                                                            </div>
                                                            <div class="form-group mb-1">
                                                                <label for="exampleTextarea">Message</label>
                                                                <textarea class="form-control" id="exampleTextarea" rows="3" required></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="checkbox-inline">
                                                                    <label class="checkbox checkbox-danger">
                                                                    <input type="checkbox" required>Send me a copied Email
                                                                    <span></span></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary mr-2" style="float:right">SEND EMAIL</button>
                                                </div>
                                            </form>
										</div>
									</div>
								</div>
								<!--end::Row-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
                    </div>
        @include("admin.include.admin-footer")
		
		<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
		<script src="/assets/plugins/global/plugins.bundle.js"></script>
		<script src="/js/suggest.js"></script>
		<script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="/assets/js/scripts.bundle.js"></script>
	</body>
</html>
		