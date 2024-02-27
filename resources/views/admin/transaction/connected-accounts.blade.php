@include('admin.include.admin-header')
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<style>
@media (min-width: 992px) {
    .sub-body {
        padding: 0 12.5px;
    }
}
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-2 py-lg-12  subheader-transparent" id="kt_subheader"
        style="padding-bottom : 0px !important">
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom" data-card="true" id="kt_card_1">
                        <div class="card-header card-header-tabs-line">
                            <div class="card-title">
                                <h3 class="card-label">{{$page_name}}</h3>
                            </div>
                            <div class="card-toolbar">
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover table-checkable" id="kt_datatable">
                                <thead>
                                    <tr>
                                        <th>Account</th>
                                        <th>Status</th>
                                        <th>Balance</th>
                                        <th>Type</th>
                                        <th>Connectd</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($accounts as $key => $val)
                                        <tr>
                                            <?php
                                                $name = '';
                                                if(isset($val['business_profile']) && $val['business_profile']['name'] != '') {
                                                    $name = $val['business_profile']['name'];
                                                }
                                                else if(isset($val['individual'])) {
                                                    $name = $val['individual']['first_name'].' '.$val['individual']['last_name'];
                                                }
                                            ?>
                                            <td>{{$name}}</td>
                                            <td>{{isset($val['individual'])?ucfirst($val['individual']['verification']['status']):''}}</td>
                                            <?php
                                                $amount = 0;
                                                $amount = $val['balance']['instant_available'][0]['amount']!=0?$val['balance']['instant_available'][0]['amount']:$val['balance']['available'][0]['amount'];
                                            ?>
                                            <td>${{number_format($amount / 100, 2)}}</td>
                                            <td>{{ucfirst($val['type'])}}</td>
                                            <td>{{isset($val['individual'])?date('m-d-Y', $val['individual']['created']):''}}</td>
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

<script>
var HOST_URL = "https://keenthemes.com/metronic/tools/preview";
</script>
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
<script src="/assets/plugins/global/plugins.bundle.js"></script>
<script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
<script src="/js/suggest.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>
<script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="/assets/js/invoice.js"></script>
<script>
$(document).ready(function() {
})
</script>