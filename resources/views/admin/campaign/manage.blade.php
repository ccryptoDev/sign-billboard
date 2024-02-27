@include('admin.include.admin-header')
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
<link type="text/css" rel="stylesheet" href="/assets/css/tips.css" />
<style>
    @media(max-width:768px){
        .card.card-custom > .card-body{
            padding: 0.5rem;
        }
        .logo-symbol{
            width: 30px;
        }
    }
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="alert alert-custom alert-white alert-shadow fade show gutter-b tip-container" role="alert">
                <div class="alert-text">
                    <ul class="tip">
                        <a type="button" class="btn btn-text-white btn-success font-weight-bold btn-spec" data-toggle="modal" data-target="#specModal">Instructions</a>
                    </ul>
                </div>
                <div class="alert-icon d-block text-right tips">
                    <a data-toggle="modal" data-target="#FaqModal" class="btn btn-text-white btn-success font-weight-bold">What is a Campaign?</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    @if(session('level') >= 2)
                    <a href="{{route('user-campaign')}}" class="card card-custom gutter-b bg-light-danger">
                    @else
                    <a href="{{route('client-campaign')}}" class="card card-custom gutter-b bg-light-danger">
                    @endif
                        <div class="card-body">
                            <div class="d-flex align-items-center p-5">
                                <div class="mr-6">
                                    <span class="svg-icon svg-icon-success svg-icon-4x">
                                        <img src="/img/Symbol.png" width="60" class="logo-symbol"/>
                                    </span>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="text-dark text-hover-primary font-weight-bold font-size-h3 font-size-h1-lg mb-3">
                                        Create New Campaign
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6">
                    <a href="{{route('list-camp')}}" class="card card-custom gutter-b bg-light-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center p-5">
                                <div class="mr-6">
                                    <span class="svg-icon svg-icon-success svg-icon-4x">
                                        <img src="/img/Symbol.png" width="60" class="logo-symbol"/>
                                    </span>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="text-dark text-hover-primary font-weight-bold font-size-h3 font-size-h1-lg mb-3">
                                        Current Campaigns
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Instruction Modal -->
<div class="modal fade" id="specModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Instruction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<ul class="mt-5">
                    <li>You must have a Campaign for your Ad Playlist to be delivered to a billboard.</li>
                    <li>The minimum length is one week (we highly advise your campaigns to be 12 weeks to gain advertising traction (unless you are advertising a one-time Event).</li>
                    <li>You get charged only for the weeks you chose to advertise.</li>
                    <li>You can always stop a long running advertising campaign.</li>
                    <li>You may modify an unpaid Campaign anytime.  Paid Campaigns cannot be modified.</li>
				</ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
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