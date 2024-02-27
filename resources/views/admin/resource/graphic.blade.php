@include('admin.include.admin-header')
<link type="text/css" rel="stylesheet" href="/assets/css/tips.css" />
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <!-- <div class="alert alert-custom alert-white alert-shadow fade show gutter-b tip-container" role="alert">
                <div class="alert-text">
                    <ul class="tip">
                        <a type="button" class="btn btn-text-white btn-success font-weight-bold btn-spec" data-toggle="modal" data-target="#specModal">Instructions</a>
                    </ul>
                </div>
                <div class="alert-icon d-block text-right tips">
                    <a href="/training" class="d-block btn mb-3 btn-text-white btn-success font-weight-bold">Marketing Articles</a>
                    <a type="button" class="d-block btn btn-text-white btn-success font-weight-bold" data-toggle="modal" data-target="#basicModal">Ad Requirements</a>
                </div>
            </div> -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-custom card-stretch gutter-b">
                        <div class="card-body d-flex align-items-center py-0 mt-3">
                            <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                                <!-- <a class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-2 text-hover-dark">We have created a list of marketing firms in multiple disciplines for you.   INEX has worked with these companies / people.  We highly recommend them. </a> -->
                                <a class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-2 text-hover-dark">
                                    @if(request()->route('id') == '')
                                        Trusted Partners
                                    @else
                                        @foreach($cate as $key => $val)
                                            @if(request()->route('id') == $val->id)
                                                {{$val->name}}
                                            @endif
                                        @endforeach
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="col-lg-3 col-xl-2">
                    <div class="card card-custom">
                        <div class="card-body p-0">
                            <ul class="navi navi-bold navi-hover my-5" role="tablist">
                                <li class="navi-item">
                                    <a class="navi-link active" href="/graphic-design">
                                        <span class="navi-text">Trusted Partners</span>
                                    </a>
                                </li>
                                @foreach($cate as $key => $val)
                                    @if(session('level') >= 2 || (session('level') < 2 && $val->private == 1))
                                        <li class="navi-item">
                                            <a class="navi-link" href="/training/{{$val->id}}">
                                                <span class="navi-text">{{$val->name}}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            <?php
                $cate = '';
                $types = $types;
                $data = [];
                foreach($types as $key => $type){
                    foreach($resource as $item){
                        $res_type = json_decode($item->cate_id, true);
                        if(is_array($res_type) && in_array($type->id, $res_type)){
                            $temp = [];
                            $temp['cate_id'] = $type->id;
                            $temp['title'] = $type->title;
                            $temp['extra'] = $type->extra;
                            $temp['type_file'] = $type->file;
                            $temp['data'] = $item;
                            array_push($data, $temp);
                        }
                    }
                }
            ?>
                <div class="col-lg-9 col-xl-10">
                    <div class="row">
                        @foreach($data as $key => $temp)
                            @if($cate != $temp['title'])
                            <?php $cate = $temp['title']?>
                            <div class="col-md-12">
                                <div class="card bg-success card-custom card-stretch gutter-b">
                                    <div class="card-body d-flex align-items-center p-0 mt-0">
                                        <div class="flex-shrink-0 mr-3">
                                            <div class="symbol symbol-50 symbol-lg-100 align-bottom">
                                                <img src="{{$temp['type_file'] != '' ? '/upload/'.$temp['type_file']:'/assets/media/svg/icons/Design/Image.svg'}}" alt="">
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column flex-grow-1 mr-3 mt-1 mb-1">
                                            <span class="card-title font-weight-bolder text-white font-size-h5 mb-2 text-hover-white">{{$temp['title']}}</span>
                                            <span class="font-weight-bold text-white font-size-lg">{!!$temp['extra']!!}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <?php
                                $item = $temp['data'];
                            ?>
                            <div class="col-md-4">
                                <div class="card card-custom card-stretch gutter-b">
                                    <div class="card-body d-flex align-items-center py-0 mt-3">
                                        <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                                            <a class="card-title font-weight-bolder text-dark-75 font-size-h5 text-hover-dark">{{$item->name}}</a>
                                            <a href="tel:{{$item->phone_number}}" class="font-weight-bold text-muted  font-size-lg">{{$item->phone_number}}</a>
                                            <a class="card-title font-weight-bolder text-dark-75 font-size-h5 text-hover-dark">{{$item->com_name}}</a>
                                            <!-- <a href="mailto:{{$item->email}}" class="font-weight-bold text-muted font-size-lg">{{$item->email}}</a>
                                            <a href="{{$item->email_1}}" target="_blank" class="font-weight-bold text-muted  font-size-lg">{{$item->email_1}}</a> -->
                                            <div class="d-inline">
                                                @if($item->email != '')
                                                <a href="mailto:{{$item->email}}" class="font-weight-bold text-success font-size-lg">
                                                    <i class="flaticon2-email icon-lg text-success mr-3"></i>
                                                </a>
                                                @endif
                                                @if($item->email_1 != '')
                                                <a href="{{$item->email_1}}" target="_blank" class="font-weight-bold text-success font-size-lg">
                                                    <i class="fas fa-globe icon-lg text-success"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ml-3">
                                            <div class="symbol symbol-50 symbol-lg-80">
                                                <img alt="Pic" src="{{$item->file === '' ? '/avatar.png' : '/upload/'.$item->file}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<button type="button" class="btn btn-primary btn-init" style="display:none" data-toggle="modal" data-target="#initModal"></button>
<div class="modal fade" id="initModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="initModal" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content bg-white">
            <div class="modal-header">
                <h5 class="modal-title text-white"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-left">
                    <h3 class="text-dark text-center">Congratulations!</h3>
                    <h4 class="text-dark fc-text">You have completed your account setup.  Now you can Advertise on your schedule and your budget.  The first item you must complete is getting professional looking ads created.  This page outlines requirements and some recommended designers</h4>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Close</button>
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
                <span class="mb-5">If you use your own Graphic Designer, please convey the following information</span>
				<ul class="mt-5">
                    <li>Aspect Ratio of 1.5:1</li>
                    <li>Create an image no smaller than 1200 pixels (w) x 800 pixels (h) (the signs are typically 576 x 384 pixels)</li>
                    <li>72 DPI</li>
                    <li>No particular format (PNG, GIF, JPG)</li>
				</ul>
                <span>If you already have your images completed, go to <a href="/update_ad">Create New Ad</a><span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="specModalLabel">Ad Requirements</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <a class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-dark">We have pre-negotiated a standard fee for you unless you have some unusual requirements.  This a great pricing deal.</a>
                <ul>
                    <li>1 x Ad = $75.00</li>
                    <li>2 or more Ads = $50.00 per image.</li>
                </ul>
                <a class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-dark">You get three revisions max.  Anymore revisions is a completely new charge.</a>
                <a class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-dark">You pay the Graphic Designer directly.</a>
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
<script>
    sessionStorage.setItem("graphic", 1);
    $(document).ready(function(){
        if(sessionStorage.getItem("graphic") == null){
            $(".btn-init").click();
        }
    })
</script>