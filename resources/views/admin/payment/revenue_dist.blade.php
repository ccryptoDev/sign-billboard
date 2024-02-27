@include('admin.include.admin-header')
<style>
    i{
        cursor :pointer
    }
</style>
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
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
                                <div class="card-toolbar">
                                </div>
							</div>
                            <form id="frmRevenue" method="post" action="/update-revenue">
                                <div class="card-body">
                                    @csrf
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <!-- <ul> -->
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            <!-- </ul> -->
                                        </div>
                                    @endif
                                    @if(Session::has('success'))
                                        <div class="alert alert-success" role="alert">
                                            {{Session::get('success')}}
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label>Enter Account Manager(%)</label>
                                        <input class="form-control percentage" value="{{isset($revenue->account)?$revenue->account:0}}" name="account">
                                    </div>
                                    <div class="form-group">
                                        <label>Enter Franchise(%)</label>
                                        <input class="form-control percentage" value="{{isset($revenue->franch)?$revenue->franch:0}}" name="franch">
                                    </div>
                                    <div class="form-group">
                                        <label>Enter INEX(%)</label>
                                        <input class="form-control percentage" value="{{isset($revenue->inex)?$revenue->inex:0}}" name="inex">
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-danger" type="submit">Save Change</button>
                                </div>
                            </form>
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
	<script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<script src="/assets/js/invoice.js"></script>
    <script src="/js/inputmask.js"></script>
	<script>
        $(document).ready(function(){
            $(".percentage").inputmask('decimal', {
                reverse: true,
                rightAlign: false,
                prefix : "% ",
            });
        })
	</script>