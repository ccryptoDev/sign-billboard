@include('admin.include.admin-header')
	<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
		</div>
		<div class="d-flex flex-column-fluid">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="card card-custom" data-card="true" id="kt_card_1">
							<div class="card-header">
								<div class="card-title">
									<h3 class="card-label">{{$page_name}}</h3>
								</div>
							</div>
                            <?php                        
                                $location = explode(",", $location);
                            ?>
							<div class="card-body">
                                <div class="row justify-content-center py-8 px-8 px-md-0">
                                    <div class="col-md-9">
                                        <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                                            <h1 class="display-4 font-weight-boldest mb-10">INVOICE</h1>
                                            <div class="d-flex flex-column align-items-md-end px-0">
                                                <a class="mb-5">
                                                    <img src="/logo.png" alt="" height="50"/>
                                                </a>
                                                <span class=" d-flex flex-column align-items-md-end opacity-70">
                                                <span>Edmond OK 73025</span>
                                                <span><a href="mailto:billing@inex.net" class="text-dark">billing@inex.net</a></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="border-bottom w-100"></div>
                                        <div class="d-flex justify-content-between pt-6">
                                            <div class="d-flex flex-column flex-root">
                                                <span class="font-weight-bolder mb-2">DATE</span>
                                                <input type="date" class='form-control' value="{{date('Y-m-d')}}" style="max-width:150px">
                                            </div>
                                            <div class="d-flex flex-column flex-root">
                                                <span class="font-weight-bolder mb-2">INVOICE NO.</span>
                                                <span class="opacity-70">#1</span>
                                            </div>
                                            <div class="d-flex flex-column flex-root">
                                                <span class="font-weight-bolder mb-2">INVOICE TO.</span>
                                                <span class="opacity-70">{{$user->user_name}}<br/>{{$user->business_name}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                                    <div class="col-md-9">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="pl-0 font-weight-bold text-muted  text-uppercase">Item</th>
                                                        <th class="text-left font-weight-bold text-muted text-uppercase">Location</th>
                                                        <th class="text-left font-weight-bold text-muted text-uppercase">Rate</th>
                                                        <th class="text-left pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                                                        <th class="text-left pr-0 font-weight-bold text-muted text-uppercase">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="font-weight-boldest">
                                                        <td class="pl-0 pt-7 border-top-0">
                                                            @if(count($ads) > 0)
                                                            <img src="/upload/{{$ads[0]->img_url}}" style="max-width:100px">
                                                            @endif
                                                        </td>
                                                        <td class="text-left pt-7">
                                                            <select class="form-control select2" multiple="multiple" autocomplete="off">
                                                                @foreach($location as $key => $val)
                                                                    <option value="{{$val}}">{{$val}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="text-left pt-7">
                                                            <input class="form-control">
                                                        </td>
                                                        <td class="text-danger pr-0 pt-7 text-left">$3200.00</td>
                                                        <td class="text-danger pr-0 pt-7 text-left">
                                                            <i class='fa fa-trash text-danger'></i>
                                                        </td>
                                                    </tr>
                                                    <tr class="font-weight-boldest">
                                                        <td class="pl-0 pt-7 border-top-0">
                                                            <button class="btn btn-light-success">New Line</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                                    <div class="col-md-9">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="font-weight-bold text-muted  text-uppercase">BANK</th>
                                                        <th class="font-weight-bold text-muted  text-uppercase">ACC.NO.</th>
                                                        <th class="font-weight-bold text-muted  text-uppercase">DUE DATE</th>
                                                        <th class="font-weight-bold text-muted  text-uppercase">TOTAL AMOUNT</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="font-weight-bolder">
                                                        <td>BARCLAYS UK</td>
                                                        <td>12345678909</td>
                                                        <td>Jan 07, 2018</td>
                                                        <td class="text-danger font-size-h3 font-weight-boldest">20,600.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                                    <div class="col-md-9">
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-light-primary font-weight-bold" onclick="window.print();">Download Invoice</button>
                                            <button type="button" class="btn btn-primary font-weight-bold" onclick="window.print();">Print Invoice</button>
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
        @include("admin.include.admin-footer")

		<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
		<script src="/assets/plugins/global/plugins.bundle.js"></script>
		<script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="/js/suggest.js"></script>
		<script src="/assets/js/scripts.bundle.js"></script>
        <script src="/assets/js/pages/crud/forms/widgets/select2.js"></script>
        <script>
            $(document).ready(function(){
                $('.select2').select2({
                    placeholder: "Select a location"
                });
            })
        </script>
	</body>
</html>
		