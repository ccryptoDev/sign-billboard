@include('front.header')
<section class="bg-half-170 d-table w-100 bg-light">
    <div class="container">
        <div class="row mt-5 mt-sm-0 align-items-center">
            <div class="col-lg-6 col-md-6">
                <div class="title-heading me-lg-4">
                    <h4 class="display-4 fw-bold mb-3"> {{$name}} </h4>
                    <p class="text-muted para-desc mb-0"> {{$extra}} </p>
                    <div class="mt-4 pt-2">
                        <a href="javascript:void(0)" class="btn btn-soft-primary m-1 case-detail" data-id="{{$id}}">Download Now For Free</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <div class="bg-white p-5 rounded-md">
                    <img src="{{$img != '' ? '/doc/'.$img : '/assets/media/svg/files/pdf.svg'}}" class="img-fluid mx-auto d-block" alt="Subscribe">
                </div>
            </div>
        </div>
    </div>
</section>
<button id="btnSub" data-bs-toggle="modal" data-bs-target="#login-popup" class="btn btn-primary m-1 d-none">Top Offcanvas</button>
<div class="modal fade" id="login-popup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog  modal-lg modal-dialog-centered">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-body p-0">
                <div class="container-fluid px-0">
                    <div class="row align-items-center g-0">
                        <div class="col-lg-6 col-md-5">
                            <img src="/layouts/images/course/online/ab02.jpg" class="img-fluid" alt="Subscribe">
                        </div>
                        <div class="col-lg-6 col-md-7">
                            <form id="subDoc" class="login-form p-4">
                                <div class="row">
                                    <div id="alert-body"></div>
                                    <div class="col-lg-12">
                                        <label class="form-label title"></label>
                                        <div class="mb-3">
                                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="user" class="fea icon-sm icons"></i>
                                                <input type="hidden" class="form-control ps-5" placeholder="First Name" name="id" required="">
                                                <input type="text" class="form-control ps-5" placeholder="First Name" name="firstName" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="user" class="fea icon-sm icons"></i>
                                                <input type="text" class="form-control ps-5" placeholder="Last Name" name="lastName" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="user" class="fea icon-sm icons"></i>
                                                <input type="email" class="form-control ps-5" placeholder="Email" name="email" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <div class="d-grid">
                                            <button type="button" class="btn btn-secondary d-none c-modal" data-bs-dismiss="modal">Close</button>
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('front.footer')

<script src="https://code.jquery.com/jquery-3.6.3.js"></script>
<script>
    $(document).ready(function(){
        $(".case-detail").on('click', function(){
            var id = $(this).data('id');
            $.ajax({
                url: '/get-case',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(res){
                    if(res != 'fail'){
                        if(res['file']){
                            const link = document.createElement('a');
                            link.href = res['file'];
                            link.target = '_blank';
                            document.body.appendChild(link);
                            link.click();
                            link.remove();
                            return;
                        }
                        $("#login-popup").find('input[name="id"]').val(id);
                        $("#login-popup").find('img').attr('src', '/doc/' + res['img']);
                        $("#login-popup").find('.title').text(res['name']);
                        $("#btnSub").click();
                    }
                }
            })
        })
        $("#subDoc").submit(function(event){
            event.preventDefault();
            var fs = new FormData(document.getElementById('subDoc'));
            $("#alert-body")[0].innerHTML = '';
            $.ajax({
                url: '/subscribe-event',
                type: 'POST',
                data: fs,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res){
                    if(res == 'success'){
                        $("#alert-body").append('<div class="alert alert-success" role="alert"> Please check your email to verify your account and download the file.   Once verification is completed, you can download all our other documents directly. </div>');
                    }
                    // $(".c-modal").click();
                },
                error: function(res){

                }
            })
        })
    })
</script>