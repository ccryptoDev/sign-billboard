@include('front.header')
@include('front.sub-header')
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-lg-3 filters-group-wrap">
                <div class="filters-group mt-4 pt-2">
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
                            <li class="list-inline-item categories-name border text-dark rounded w-100 {{!$exist?'active':''}}" data-group="all">All</li>
                        </a>
                        <a href="{{ route('team' )}}">
                            <li class="list-inline-item categories-name border text-dark rounded w-100" data-group="all">Trusted Partners</li>
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
            <div class="col-md-9 col-lg-9">
                <div id="grid" class="row shuffle" style="position: relative; overflow: hidden; height: 1462.22px; transition: height 250ms cubic-bezier(0.4, 0, 0.2, 1) 0s;">
                    @foreach($docs as $key => $val)
                        @if($val->cate_pri == 1)
                            <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2 picture-item shuffle-item {{$exist&&$title==$val->cate_name?'shuffle-item--visible':''}}" data-groups='["{{$val->cate_name}}"]' style="position: absolute; top: 0px; visibility: {{$exist&&$title==$val->cate_name?'visible':'hidden'}}; will-change: transform; left: 0px; opacity: {{$exist&&$title==$val->cate_name?1:0}}; transition-duration: 250ms; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-property: transform, opacity;">
                                <div class="card blog border-0 work-container work-classic shadow rounded-md overflow-hidden">
                                    <a class="m-auto" style="height:150px; overflow:hidden">
                                        <img src="{{$val->img != '' ? '/doc/'.$val->img : '/assets/media/svg/files/pdf.svg' }}" class="img-fluid work-image" style="max-width:100%" alt="{{$val->name}}">
                                    </a>
                                    <div class="card-body">
                                        <div class="content">
                                            <a class="badge badge-link bg-primary">{{$val->cate_name}}</a>
                                            <h5 class="mt-3" style="text-overflow: hidden;
                                                overflow:hidden;
                                                display: -webkit-box;
                                                -webkit-line-clamp: 1; /* number of lines to show */
                                                        line-clamp: 1; 
                                                -webkit-box-orient: vertical;"><a class="text-dark title">{{$val->name}}</a></h5>
                                            <p class="text-muted" style="height:4.8em;overflow:hidden;">{{$val->extra}}</p>
                                            <a href="/subscribe/{{base64_encode($val->id)}}" class="text-primary h6" data-id="{{base64_encode($val->id)}}" style="cursor:pointer">Download <i class="uil uil-angle-right-b align-middle"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@include('front.footer')