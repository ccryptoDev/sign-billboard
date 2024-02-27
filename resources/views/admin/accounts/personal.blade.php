@include('admin.include.admin-header')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="d-flex flex-row">
                <!--begin::Aside-->
                <div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
                    @include('admin.accounts.menu')
                </div>
                <div class="flex-row-fluid ml-lg-8">
                    <div class="card card-custom card-stretch">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label font-weight-bolder text-dark">General Information</h3>
                            </div>
                        </div>
                        <form action="{{route('account-personal')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-2"></div>
                                    <div class="col-xl-10 my-2">
                                        @if (Session::has('success'))
                                            <div class="alert alert-success">
                                                <span>Success</span>
                                            </div>
                                        @endif
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-2"></div>
                                    <div class="col-xl-7 my-2">
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <h6 class=" text-dark font-weight-bold mb-5">Customer Info:</h6>
                                            </div>
                                        </div>
                                        @if(session('level') != 4 && session('level') != 3)
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3 text-lg-right text-left">Business Name</label>
                                            <div class="col-md-9">
                                                <input class="form-control form-control-lg form-control-solid" disabled type="text" value="{{$user->business_name}}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3 text-lg-right text-left">My Primary TA</label>
                                            <div class="col-md-9">
                                                <?php
                                                    if(session("level") == "0"){
                                                ?>
                                                <input class="form-control form-control-lg form-control-solid" disabled type="text" value="{{$primary}}"/>
                                                <?php }
                                                else {?>
                                                <input class="form-control form-control-lg form-control-solid" disabled type="text" value="Myself"/>
                                                <?php }?>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <label class="col-form-label col-md-3 text-lg-right text-left"></label>
                                            <div class="col-md-9">
                                                <h6 class=" text-dark font-weight-bold mb-5">Personal Information:</h6>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3 text-lg-right text-left">User Name</label>
                                            <div class="col-md-9">
                                                <input class="form-control form-control-lg form-control-solid" name="user_name" type="text" value="{{$user->user_name}}" required/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3 text-lg-right text-left">Email</label>
                                            <div class="col-md-9">
                                                <input class="form-control form-control-lg form-control-solid" name="email" type="email" value="{{$user->email}}" required/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3 text-lg-right text-left">Real Name</label>
                                            <div class="col-md-9">
                                                <input class="form-control form-control-lg form-control-solid" name="real_name" type="text" value="{{$user->real_name}}" required/>
                                            </div>
                                        </div>
                                        @if(session('level') == 4)
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 text-lg-right text-left">Franchise</label>
                                                <div class="col-md-9">
                                                    <input class="form-control form-control-lg form-control-solid" type="text" value="{{$user->fran}}" disabled required/>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3 text-lg-right text-left">Contact Phone</label>
                                            <div class="col-md-9">
                                                <div class="input-group input-group-lg input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="la la-phone"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-lg form-control-solid" name="phone" id="phone" value="{{$user->phone}}" maxlength="13" required/>
                                                </div>
                                            </div>
                                        </div>
                                        @if(session('level') == 4)
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-3 text-lg-right text-left">Carrier</label>
                                                <div class="col-md-9">
                                                    <select class="form-control selectpicker" name='carrier' id='carrier'>
                                                        <option value="">Please select carrier</option>
                                                        <option value="@txt.att.net" {{$user->carrier=="@txt.att.net"?'selected':''}}>AT&T</option>
                                                        <option value="@tmomail.net" {{$user->carrier=="@tmomail.net"?'selected':''}}>T-Mobile</option>
                                                        <option value="@vzwpix.com" {{$user->carrier=="@vzwpix.com"?'selected':''}}>Verizon</option>
                                                        <option value="@pm.sprint.com" {{$user->carrier=="@pm.sprint.com"?'selected':''}}>Sprint</option>
                                                        <option value="@mypixmessages.com" {{$user->carrier=="@mypixmessages.com"?'selected':''}}>Xfinity Mobile</option>
                                                        <option value="@vmpix.com" {{$user->carrier=="@vmpix.com"?'selected':''}}>Virgin Mobile</option>
                                                        <option value="@mmst5.tracfone.com" {{$user->carrier=="@mmst5.tracfone.com"?'selected':''}}>Tracfone</option>
                                                        <option value="@smtext.com" {{$user->carrier=="@smtext.com"?'selected':''}}>Simple Mobile</option>
                                                        <option value="@mailmymobile.net" {{$user->carrier=="@mailmymobile.net"?'selected':''}}">Mint Mobile</option>
                                                        <option value="@vtext.com" {{$user->carrier=="@vtext.com"?'selected':''}}>Red Pocket</option>
                                                        <option value="@mymetropcs.com" {{$user->carrier=="@mymetropcs.com"?'selected':''}}>Metro PCS</option>
                                                        <option value="@myboostmobile.com" {{$user->carrier=="@myboostmobile.com"?'selected':''}}>Boost Mobile</option>
                                                        <option value="@mms.cricketwireless.net" {{$user->carrier=="@mms.cricketwireless.net"?'selected':''}}>Cricket</option>
                                                        <option value="@text.republicwireless.com" {{$user->carrier=="@text.republicwireless.com"?'selected':''}}>Republic Wireless</option>
                                                        <option value="@msg.fi.google.com" {{$user->carrier=="@msg.fi.google.com"?'selected':''}}>Google Fi (Project Fi)</option>
                                                        <option value="@mms.uscc.net" {{$user->carrier=="@mms.uscc.net"?'selected':''}}>U.S. Cellular</option>
                                                        <option value="@message.ting.com" {{$user->carrier=="@message.ting.com"?'selected':''}}>Ting</option>
                                                        <option value="@mailmymobile.net" {{$user->carrier=="@mailmymobile.net"?'selected':''}}>Consumer Cellular</option>
                                                        <option value="@cspire1.com" {{$user->carrier=="@cspire1.com"?'selected':''}}>C-Spire</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row mt-10">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <h6 class=" text-dark font-weight-bold mb-5">Please unsubscribe me from your newsletter:</h6>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3 text-lg-right text-left">Unsubscribe</label>
                                            <div class="col-md-9">
                                                <div class="checkbox-list">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="notification" id="notification" {{$user->notification == 0?'checked':''}}/>
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-danger" type="submit">Save Changes</button>
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
<script src="/assets/js/pages/custom/user/edit-user.js?v=7.0.4"></script>
<script>
    $(".phone").inputmask("mask", {
        "mask": "(999) 999-9999"
    });
</script>