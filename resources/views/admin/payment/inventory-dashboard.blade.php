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
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <?php 
                    $private_locations = [];
                    foreach($location_type as $key => $val){
                        if($val->type == 1){
                            $private_locations[] = $val->location_id;
                        }
                    }
                ?>
                <div class="col-xl-12 col-lg-12">
                    <div class="card card-custom gutter-b card-stretch">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="card-label">
                                    <div class="font-weight-bolder">{{$page_name}}</div>
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <div>
                                    <span class="label label-xl label-dot label-success"></span> Used
                                    <span class="label label-xl label-dot label-danger"></span> Available
                                </div>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column px-0">
                            @foreach($locations as $key => $val)
                                @if(!in_array($val['id'], $private_locations))
                                    <?php
                                    $total = 12;
                                    $total = isset($val['max'])&&$val['max']!=null?$val['max']:12;
                                    ?>
                                    <div class="row pl-10 pr-10 mt-5">
                                        <div class="col-md-3">
                                            <span style="font-size:16px">{{$val['nickname']}}</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="progress" style="height: 40px;">
                                                <div class="progress-bar bg-success" role="progressbar" 
                                                    style="width: {{$val['cur_sub'] / $total *100}}%; font-weight:1000;font-size : 20px"
                                                    aria-valuenow="{{$val['cur_sub']}}" aria-valuemin="0" aria-valuemax="100"
                                                    title="{{$val['nickname']}}"
                                                >
                                                    {{$val['cur_sub']}}
                                                </div>
                                                <div class="progress-bar bg-danger" role="progressbar" 
                                                    style="width: {{($total - $val['cur_sub']) / $total *100}}%; font-weight:1000;font-size : 20px"
                                                    aria-valuenow="{{$total - $val['cur_sub']}}" aria-valuemin="0" aria-valuemax="100"
                                                    title="{{$val['nickname']}}"
                                                >
                                                    {{$total - $val['cur_sub']}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>                            
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12">
                    <div class="card card-custom gutter-b card-stretch">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="card-label">
                                    <div class="font-weight-bolder weeks">Week 1</div>
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <select class="form-control" id="weeks">
                                    @for($i = 0; $i < 12; $i++)
                                        @if($i === 0)
                                            <option value="{{$i + 1}}">This Week</option>
                                        @else
                                            <option value="{{$i + 1}}">Week {{$i}}</option>
                                        @endif
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column px-0" id="newChat">
                            
                        </div>                            
                    </div>
                </div>
            </div>
            <?php
                $col_code = [
                    "warning","success","danger","primary","info","warning","success","danger","primary","info"
                ];
            ?>
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
    $(document).ready(function(){
        get_weeks();
        $("#weeks").on('change', function(){
            $(".weeks").text(jQuery("#weeks option:selected").text());
            get_weeks();
        })
        function get_weeks(){
            KTApp.blockPage();
            $.ajax({
                url : '/get-weeks-inventory',
                type : 'POST',
                data : {
                    week : $("#weeks").val()
                },
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function(res){
                    KTApp.unblockPage();
                    if(res['success'] == true){
                        $("#newChat")[0].innerHTML = "";
                        $("#newChat").append(res['data']);
                    }
                },
                error : function(err){
                    KTApp.unblockPage();
                    toastr.error("Error, Please contact us!");
                }
            })
        }
    })
</script>
    