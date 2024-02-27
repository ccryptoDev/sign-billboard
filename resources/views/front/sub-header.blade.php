<section class="bg-half-170 bg-white d-table w-100">
    <div class="container">
        <div class="row mt-0 justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="pages-heading">
                    <h4 class="title mb-0"> {{$page_name}} </h4>
                    <?php
                    $route_name = request()->route()->getName();
                    ?>
                    @if($route_name == 'financing')
                        <h6 class="mb-0"> (With Approved Credit) </h6>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- <div class="position-relative">
    <div class="shape overflow-hidden text-white">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
        </svg>
    </div>
</div> -->