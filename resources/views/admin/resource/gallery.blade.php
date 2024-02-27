@include('admin.include.admin-header')
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
<style>
  .action i{
      cursor : pointer
  }
  .select2-container{
      width: 100% !important;
  }
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom" data-card="true" id="kt_card_1">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">{{$page_name}}</h3>
                            </div>
                            <div class="card-toolbar">
                                <a class="btn btn-success mr-5" data-toggle="modal" data-target="#newModal">Upload image</a>
                                <a class="btn btn-success mr-5 btn-update" data-toggle="modal" data-target="#updateModal" style="display:none">New</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </div>
                            @endif
                            <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                              <thead>
                                <tr>
                                  <th>Image</th>
                                  <th>Text</th>
                                  <th>Date</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Upload Gallery</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i aria-hidden="true" class="ki ki-close"></i>
              </button>
          </div>
          <form id="frmNew">
              <div class="modal-body">
                  <div class="form-group">
                      <label>Image<span class="text-danger">*</span></label>
                      <div class="custom-file">
                          <input type="file" class="custom-file-input" name="file" id="customFile" require/>
                          <label class="custom-file-label" for="customFile">Image</label>
                      </div>
                  </div>
                  <div class="form-group">
                      <label>Text</label>
                      <input class="form-control" name="text">
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-light-primary font-weight-bold cc-modal" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
              </div>
          </form>
      </div>
  </div>
</div>
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Update Gallery</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i aria-hidden="true" class="ki ki-close"></i>
              </button>
          </div>
          <form id="frmUpdate">
              <div class="modal-body">
                <div class="form-group">
                    <label>Image<span class="text-danger">*</span></label>
                    <input class="form-control" name="id" id="u_id" type="hidden">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="file" id="customFile" require/>
                        <label class="custom-file-label" for="customFile">Image</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Text</label>
                    <input class="form-control" name="text">
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-light-primary font-weight-bold c-modal" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
              </div>
          </form>
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
<script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="/assets/js/gallery-table.js"></script>
<!-- <script src="/assets/js/pages/crud/file-upload/dropzonejs.js"></script> -->
<script>
    $(document).ready(function(){
      $("#btn-upload").click(function(){
        $("#upload-container").toggle();
      })
      $("#frmNew").submit(function(event){
        event.preventDefault();
        KTApp.blockPage();
        var fs = new FormData(document.getElementById('frmNew'));
        $.ajax({
            url : "/upload-gallery",
            type : "POST",
            data : fs,
            processData : false,
            contentType : false,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function (res){
                KTApp.unblockPage();
                if(res == "success"){
                  $('.cc-modal').click();
                  refreshTable();
                }
                else{
                    toastr.error(res);
                }
            },
            error : function(err){
                KTApp.unblockPage();
                toastr.error("Please refresh your browser");
            }
        })
      })
      $("#frmUpdate").submit(function(event){
        event.preventDefault();
        KTApp.blockPage();
        var fs = new FormData(document.getElementById('frmUpdate'));
        $.ajax({
            url : "/update-gallery",
            type : "POST",
            data : fs,
            processData : false,
            contentType : false,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function (res){
                KTApp.unblockPage();
                if(res == "success"){
                  $('.c-modal').click();
                  refreshTable();
                }
                else{
                    toastr.error(res);
                }
            },
            error : function(err){
                KTApp.unblockPage();
                toastr.error("Please refresh your browser");
            }
        })
      })
      function refreshTable() {
        $('#kt_datatable').DataTable().ajax.reload();
      }
    })
</script>	