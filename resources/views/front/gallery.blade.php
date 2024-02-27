@include('front.header')
@include('front.sub-header')
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div id="grid" class="row shuffle" style="position: relative; overflow: hidden; height: 1462.22px; transition: height 250ms cubic-bezier(0.4, 0, 0.2, 1) 0s;">
                    @foreach($gallery as $key => $val)
                      <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2 picture-item shuffle-item shuffle-item--visible">
                          <div class="card blog border-0 work-container work-primary work-classic shadow rounded-md overflow-hidden">
                              <a class="m-auto" style="max-height:350px; overflow:hidden">
                                  <img src="{{$val->url != '' ? '/gallery/'.$val->url : '/assets/media/svg/files/pdf.svg' }}" class="img-fluid work-image" alt="{{$val->name}}">
                              </a>
                              <div class="card-body">
                                  <div class="content">
                                      <!-- <a class="badge badge-link bg-primary">{{$val->cate_name}}</a> -->
                                      <h5 class="mt-3" style="text-overflow: hidden;
                                          overflow:hidden;
                                          display: -webkit-box;
                                          -webkit-line-clamp: 1; /* number of lines to show */
                                                  line-clamp: 1; 
                                          -webkit-box-orient: vertical;"><a class="text-dark title">{{$val->name}}</a></h5>
                                  </div>
                              </div>
                          </div>
                      </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@include('front.footer')