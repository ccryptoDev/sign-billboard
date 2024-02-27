@include('admin.include.admin-header')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row m-0">
                <a href="/update_ad" class="col bg-danger d-flex align-items-center px-5 py-5 px-lg-15 py-lg-10 rounded-xl mr-7 mb-7">
                    <span class="svg-icon svg-icon-5x svg-icon-white d-block my-2 mr-5">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                <path d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z" fill="#000000" />
                            </g>
                        </svg>
                    </span>
                    <div>
                        <div class="text-white text-hover-white font-weight-bold font-size-h1">
                            1. Create New Ad
                        </div>
                        <div class="text-white text-hover-white font-weight-bold font-size-h4">
                            - Upload of Ads into your Playlist <br>
                            - Free <br>
                        </div>
                    </div>
                </a>
                <a href="/manage_playlist" class="col bg-primary d-flex align-items-center px-5 py-5 px-lg-15 py-lg-10 rounded-xl mr-7 mb-7">
                    <span class="svg-icon svg-icon-5x svg-icon-white d-block my-2 mr-5">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M4.5,6 L19.5,6 C20.8807119,6 22,6.97004971 22,8.16666667 L22,16.8333333 C22,18.0299503 20.8807119,19 19.5,19 L4.5,19 C3.11928813,19 2,18.0299503 2,16.8333333 L2,8.16666667 C2,6.97004971 3.11928813,6 4.5,6 Z M4,8 L4,17 L20,17 L20,8 L4,8 Z" fill="#000000" fill-rule="nonzero"/>
                                <polygon fill="#000000" opacity="0.3" points="4 8 4 17 20 17 20 8"/>
                                <rect fill="#000000" opacity="0.3" x="7" y="20" width="10" height="1" rx="0.5"/>
                            </g>
                        </svg>
                    </span>
                    <div>
                        <div class="text-white text-hover-white font-weight-bold font-size-h1 mt-2">
                            2. Manage Playlist
                        </div>
                        <div href="/manage_playlist" class="text-white text-hover-white font-weight-bold font-size-h4 mt-2">
                            - Choose which Ads are delivered to the billboard(s) <br>
                            - Free
                        </div>
                    </div>
                </a>
            </div>
            <div class="row m-0">
                <!-- <div class="col bg-success d-flex align-items-center px-5 py-5 px-lg-15 py-lg-10 rounded-xl mr-7 mb-7">
                    <span class="svg-icon svg-icon-3x svg-icon-white d-flex my-2 mr-5">
                        <i class="fab fa-twitter text-white text-hover-white icon-2x mr-5"></i>
                        <i class="fab fa-linkedin text-white text-hover-white icon-2x mr-5"></i>
                        <i class="fab fa-facebook text-white text-hover-white icon-2x"></i>
                    </span>
                    <div>
                        <a href="/social-posts" class="text-white text-hover-white font-weight-bold font-size-h1 mt-2">
                            3. Post to Social Media
                        </a><br>
                        <a href="/social-posts" class="text-white text-hover-white font-weight-bold font-size-h4 mt-2">
                            Pick an Ad, include some text, post to your social media accounts
                        </a>
                    </div>
                </div> -->
                <a href="/graphic-design" class="col bg-success d-flex align-items-center px-5 py-5 px-lg-15 py-lg-10 rounded-xl mr-7 mb-7">
                    <span class="svg-icon svg-icon-5x svg-icon-white d-block my-2 mr-5">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <rect fill="#000000" x="2" y="4" width="19" height="4" rx="1"/>
                                <path d="M3,10 L6,10 C6.55228475,10 7,10.4477153 7,11 L7,19 C7,19.5522847 6.55228475,20 6,20 L3,20 C2.44771525,20 2,19.5522847 2,19 L2,11 C2,10.4477153 2.44771525,10 3,10 Z M10,10 L13,10 C13.5522847,10 14,10.4477153 14,11 L14,19 C14,19.5522847 13.5522847,20 13,20 L10,20 C9.44771525,20 9,19.5522847 9,19 L9,11 C9,10.4477153 9.44771525,10 10,10 Z M17,10 L20,10 C20.5522847,10 21,10.4477153 21,11 L21,19 C21,19.5522847 20.5522847,20 20,20 L17,20 C16.4477153,20 16,19.5522847 16,19 L16,11 C16,10.4477153 16.4477153,10 17,10 Z" fill="#000000" opacity="0.3"/>
                            </g>
                        </svg>
                    </span>
                    <div>
                        <div class="text-white text-hover-white font-weight-bold font-size-h1 mt-2">
                            3. Advertising Tools
                        </div>
                        <div class="text-white text-hover-white font-weight-bold font-size-h4 mt-2">
                            - People you need to know who help advertise your company.<br>
                            - Articles about advertising your company.<br>
                            - Free
                        </div>
                    </div>
                </a>
                <a href="/manage-campaign" class="col bg-danger d-flex align-items-center px-5 py-5 px-lg-15 py-lg-10 rounded-xl mr-7 mb-7">
                    <span class="svg-icon svg-icon-5x svg-icon-white d-block my-2 mr-5">
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
                    <div>
                        <div class="text-white text-hover-white font-weight-bold font-size-h1 mt-2">
                            4. Campaign Manager
                        </div>
                        <div class="text-white text-hover-white font-weight-bold font-size-h4 mt-2">
                            - Choose When, Where, and How Much advertising<br>
                            - Switch/Stop your Campaigns <br>
                            - View your Invoices
                        </div>
                    </div>
                </a>
            </div>
            <!-- <div class="row m-0">
                <div class="col bg-primary d-flex align-items-center px-5 py-5 px-lg-15 py-lg-10 rounded-xl mr-7 mb-7">
                    <span class="svg-icon svg-icon-5x svg-icon-white d-block my-2 mr-5">
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
                    <div>
                        <a href="/manage-campaign" class="text-white text-hover-white font-weight-bold font-size-h1 mt-2">
                            4. Manage Campaigns
                        </a><br>
                        <a href="/manage-campaign" class="text-white text-hover-white font-weight-bold font-size-h4 mt-2">
                            Choose When, Where and How much advertising you want to do. Start and Stop your campaigns
                        </a>
                    </div>
                </div>
            </div> -->
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