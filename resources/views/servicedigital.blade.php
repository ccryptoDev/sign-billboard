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

</style>
<section id="main-banner-page" class="position-relative page-header service-header section-nav-smooth parallax" style="background-image:url('/assets/media/bg/bg-10.jpg');">
    <div class="overlay overlay-dark opacity-7 z-index-1"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="page-titles whitecolor text-center padding_top_half padding_bottom">
                    <h2 class="font-bold  padding_top">Service</h2>
                    <h4 class="whitecolor font-xlight text-center"></h4>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Page Header ends -->
<section id="aboutus" class="padding_half">
    <div class="container aboutus">
        <div class="row align-items-top">            
            <div class="col-lg-12 col-md-12 padding_bottom_half text-center text-md-left">
                <p class="bottom5 text-dark">We service digital signs that we install in the state of Oklahoma. INEX signs are built for results and they
				are also built to last. INEX’s service personnel are equipped with the latest maintenance and repair
				technology for every type of digital sign. INEX’s service team is available to help you to configure your
				digital sign. </p>
			</div>
        </div>		
		<div class="row align-items-top">            
            <div class="col-lg-12 col-md-12 padding_bottom_half text-center text-md-left">
                 <div class="image margintop"><img alt="SEO" src="/img/service.png"></div>	
			</div>
        </div>
		
    </div>
</section>
@include('footer')
