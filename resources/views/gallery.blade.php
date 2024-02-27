@include('header')
<style>
@media(min-width:1200px){
    .image img{
        min-height : 250px;
    }
}
#main-banner-page {
    /* background-position : center !important; */
    background-size : 100%100%!important;
}
.aboutus h2 {
    font-size: 2rem;
}
.photo-gallery {
  color:#313437;
  background-color:#fff;
}

.photo-gallery p {
  color:#7d8285;
}

.photo-gallery h2 {
  font-weight:bold;
  margin-bottom:40px;
  padding-top:40px;
  color:inherit;
}

@media (max-width:767px) {
  .photo-gallery h2 {
    margin-bottom:25px;
    padding-top:25px;
    font-size:24px;
  }
}

.photo-gallery .intro {
  font-size:16px;
  max-width:500px;
  margin:0 auto 40px;
}

.photo-gallery .intro p {
  margin-bottom:0;
}

.photo-gallery .photos {
  padding-bottom:20px;
}

.photo-gallery .item {
  padding-bottom:30px;
}


</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
<section id="main-banner-page" class="position-relative page-header service-header section-nav-smooth parallax" style="background-image:url('/assets/media/bg/bg-10.jpg');">
    <div class="overlay overlay-dark opacity-7 z-index-1"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="page-titles whitecolor text-center padding_top padding_bottom">
                    <h2 class="font-bold  padding_top">Gallery</h2>
                    <!-- <h3 class="font-bold pb-4 pt-2">Each will be linked to their individual section. The section will be collapsed until selected or opened.</h3> -->
                    <h4 class="whitecolor font-xlight text-center"></h4>
                </div>
            </div>
        </div>
      
    </div>
</section>
<!--Page Header ends -->
<section id="aboutus" class="padding_top padding_bottom">
    <div class="container aboutus">
    <div class="row">
            <div class="col-md-12 text-center heading_space wow fadeIn" data-wow-delay="300ms">
                <h2 class="heading bottom30 darkcolor font-light2"><span class="font-weight-light">INEX Digital billboards</span>
                    <span class="divider-center"></span>
                </h2>
				
            </div>
        </div>
      <div class="photo-gallery">
        <div class="container">
            
            <div class="row photos">
                <div class="col-sm-6 col-md-4 col-lg-4 item"><a href="/img/gpic1.jpg" data-lightbox="photos"><img class="img-fluid" src="/img/gpic1.jpg"></a></div>
                <div class="col-sm-6 col-md-4 col-lg-4 item"><a href="/img/gpic2.jpg" data-lightbox="photos"><img class="img-fluid" src="/img/gpic2.jpg"></a></div>
                <div class="col-sm-6 col-md-4 col-lg-4 item"><a href="/img/gpic3.jpg" data-lightbox="photos"><img class="img-fluid" src="/img/gpic3.jpg"></a></div>
                <div class="col-sm-6 col-md-4 col-lg-4 item"><a href="/img/gpic4.jpg" data-lightbox="photos"><img class="img-fluid" src="/img/gpic4.jpg"></a></div>
                <div class="col-sm-6 col-md-4 col-lg-4 item"><a href="/img/gpic5.jpg" data-lightbox="photos"><img class="img-fluid" src="/img/gpic5.jpg"></a></div>
                <div class="col-sm-6 col-md-4 col-lg-4 item"><a href="/img/gpic6.jpg" data-lightbox="photos"><img class="img-fluid" src="/img/gpic6.jpg"></a></div>
                <div class="col-sm-6 col-md-4 col-lg-4 item"><a href="/img/gpic7.jpg" data-lightbox="photos"><img class="img-fluid" src="/img/gpic7.jpg"></a></div>
                <div class="col-sm-6 col-md-4 col-lg-4 item"><a href="/img/gpic8.jpg" data-lightbox="photos"><img class="img-fluid" src="/img/gpic8.jpg"></a></div>
                <div class="col-sm-6 col-md-4 col-lg-4 item"><a href="/img/gpic9.jpg" data-lightbox="photos"><img class="img-fluid" src="/img/gpic9.jpg"></a></div>
	        </div>  	
		</div>
    </div>  
    </div>
</section>

@include('footer')
