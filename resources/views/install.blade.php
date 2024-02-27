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
.image.margintop img {
    height: 390px;
}
</style>
<section id="main-banner-page" class="position-relative page-header service-header section-nav-smooth parallax" style="background-image:url('/assets/media/bg/bg-10.jpg');">
    <div class="overlay overlay-dark opacity-7 z-index-1"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="page-titles whitecolor text-center padding_top_half padding_bottom">
                    <h2 class="font-bold padding_top">Install</h2>
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
                <p class="bottom5 text-dark">We professionally ensure that your sign is displayed and installed to perfection. INEX’s team of professional installers will be on site for installation and to configure your new digital sign. </p>
                <p class="bottom5 text-dark">INEX helps you determine which kind of digital sign is right for your business or organization. We do both interior and exterior installation.  INEX helps you figure out the right design for the greatest effectiveness of your digital sign. Our materials are durable and long-lasting.  INEX signs are built for results and they are also built to last. Digital signs need careful and professional installation. We use professional installers to ensure your sign is installed professionally and on time. Our installation department guarantees your signs are installed to your exact specifications. INEX’s service crews are equipped with the latest maintenance and repair technology for every type of digital sign. INEX can install any sign, anywhere. INEX has the service expertise and logistics capabilities to meet your installation needs. INEX will deliver, install, program and train you on how to use your new digital system.</p>
			</div>
        </div>		
		<div class="row align-items-center">
            <div class="col-lg-6 col-md-6 padding_bottom_half">
            <div class="image margintop"><img alt="SEO" src="/img/install1.png"></div>
            </div>
            <div class="col-lg-6 col-md-6 padding_bottom_half">
            <div class="image margintop"><img alt="SEO" src="/img/install2.png"></div>
            </div>
            
        </div>
    </div>
</section>
@include('footer')
