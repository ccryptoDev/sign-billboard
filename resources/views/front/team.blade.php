@include('front.header')
@include('front.sub-header')
<style>
    .bg-success {
        background-color: #1BC5BD !important;
        box-shadow: 0px 0px 30px 0px rgb(82 63 105 / 5%);
    }
    .mr-3 {
        margin-right: 0.75rem !important;
    }
    .text-desc p{
        line-height: 1.2;
        margin-bottom: 0px;
    }
    .font-size-lg{
        font-size: 1.08rem;
    }
    .pr-0 {
        padding-right: 0;
    }
    .pl-0 { 
        padding-left: 0;
    }
</style>
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-lg-3 filters-group-wrap">
                <div class="filters-group">
                    <ul class="container-filter list-inline mb-0 filter-options">
                        <?php
                            $exist = false;
                            foreach($doc_cates as $key => $val){
                                if($val->num > 0 && $title == $val->cate_name){
                                    $exist = true;
                                }
                            }
                        ?>
                        <a href="/cases">
                            <li class="list-inline-item categories-name border text-dark rounded w-100" data-group="all">All</li>
                        </a>
                        <a href="{{ route('team' )}}">
                            <li class="list-inline-item categories-name border text-dark rounded w-100 active" data-group="all">Trusted Partners</li>
                        </a>
                        @foreach($doc_cates as $key => $val)
                            @if($val->num > 0 && $val->private == 1)
                                <a href="/cases/{{$val->cate_name}}">
                                    <li class="list-inline-item categories-name border text-dark rounded w-100 {{$exist&&$title==$val->cate_name?'active':''}}">{{$val->cate_name}}</li>
                                </a>
                            @endif
                        @endforeach
                    </ul>
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
            <div class="col-md-9 col-lg-9">
                <div class="row">
                    @foreach($data as $key => $temp)
                    <?php
                        $item = $temp['data'];
                    ?>
                    @if($cate != $temp['title'])
                        <?php $cate = $temp['title']?>
                        <div class="col-md-12">
                            <div class="card bg-success card-custom card-stretch gutter-b">
                                <div class="card-body d-flex align-items-center p-0 mt-0">
                                    <div class="flex-shrink-0 mr-3">
                                        <div class="symbol symbol-50 symbol-lg-100 align-bottom">
                                            <img src="{{$temp['type_file'] != '' ? '/upload/'.$temp['type_file']:'/assets/media/svg/icons/Design/Image.svg'}}" style="min-width:50px; max-width:100px; height:100%; width:100%" alt="{{$temp['title']}}">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-grow-1 mr-3 mt-1 mb-1">
                                        <span class="card-title font-weight-bolder text-white font-size-h6 mb-2 text-hover-white">{{$temp['title']}}</span>
                                        <span class="font-weight-bold text-white text-desc">{!!$temp['extra']!!}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-4 col-md-6 mt-4 pt-2 mb-4">
                        <div class="card public-profile border-0 rounded shadow" style="z-index: 1;">
                            <div class="card-body">
                                <div class="row align-items-center">    
                                    <div class="col-lg-7 col-md-7 pr-0">
                                        <div class="row align-items-end">
                                            <div class="col-md-12 pl-0 text-md-start text-center mt-4 mt-sm-0">
                                                <h6 class="mb-1">{{$item->name}}</h6>
                                                <span class="mb-1 font-size-lg">{{$item->phone_number}}</span>
                                                <small class="text-dark h6 me-2 font-size-lg">{{$temp['title']}}</small>
                                                <ul class="list-inline mb-0 mt-3">
                                                    @if($item->email != '')
                                                        <li class="list-inline-item"><a href="mailto:{{$item->email}}" class="rounded" title="Email"><i data-feather="mail" class="fea icon-sm"></i></a></li>
                                                    @endif
                                                    @if($item->phone_number != '')
                                                        <li class="list-inline-item"><a href="tel:{{$item->phone_number}}" class="rounded" title="Phone"><i data-feather="phone" class="fea icon-sm"></i></a></li>
                                                    @endif
                                                    @if($item->email_1 != '')
                                                        <li class="list-inline-item"><a href="{{$item->email_1}}" target="_blank" class="rounded" title="Website"><i data-feather="globe" class="fea icon-sm"></i></a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 pr-0 text-md-start text-center">
                                        <img src="{{$item->file === '' ? '/avatar.png' : '/upload/'.$item->file}}" class="avatar avatar-large rounded-circle shadow d-block mx-auto" style="min-width:80px; max-width:80px; height:100%; width:100%" alt="{{$item->name}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        @if($cate != $temp['title'])
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@include('front.footer')