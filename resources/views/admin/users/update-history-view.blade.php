@include('admin.include.admin-header')
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>                    
	<style>
		@media(max-width:768px){
			#f_comp{
				margin-top:0px !important;
			}
		}
        .action i{
            cursor : pointer;
        }
        .content-text{
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 400px;
        }
	</style>
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader min-h-lg-75px pt-5 pb-7 subheader-transparent" id="kt_subheader">
            
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-header h-auto">
                                <div class="card-title py-5">
                                    <h3 class="card-label">
                                        <span class="d-block text-dark font-weight-bolder">History of INEX Updates</span>
                                        <span class="d-block text-muted mt-2 font-size-sm"></span>
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>User Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($history as $key => $val)
                                            <tr>
                                                <td>
                                                    <?php
                                                        $created = date_create($val->created_at);
                                                        echo date_format($created, "m-d-Y H:i");
                                                    ?>
                                                </td>
                                                <td>
                                                    {{$val->user_name}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>   
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
        <script src="/assets/js/pages/widgets.js"></script>
        <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
        <script src="/js/dashboard.js"></script>
        <script>
        </script>
	</body>
</html>
		