@include('admin.include.admin-header')
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
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
                                <span class="svg-icon svg-icon-primary svg-icon-2x" data-toggle="modal" data-target="#FaqModal" title="FAQs">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                                            <path d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z" fill="#000000"/>
                                        </g>
                                    </svg>
                                </span>
                            </div>
                            <div class="card-toolbar">
                                <button class="btn btn-success" data-toggle="modal" data-target="#newModal">New PA</button>
                            </div>
                        </div>
                        <?php
                        $page_list = [
                            'Homepage',
                            'Become a Trusted Agent',
                            'Campaign Manager',
                            'Create New Ad',
                            'Manage Playlist',
                            'Resources',
                            'Why Use INEX Outdoor Digital Advertising?',
                            'Locations / Pricing',
                            'Initial Setup – Billing Contact',
                            'Initial Setup – Secondary TA',
                            'Initial Setup – Social Media Links',
                        ]
                        ?>
                        <div class="card-body">
                            <table class="table table-bordered table-hover table-checkable" id="kt_datatable">
                                <thead>
                                    <tr>
                                        <th>Page Title</th>
                                        <th>Content</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pa as $key => $val)
                                        <tr>
                                            <td>{{isset($page_list[$val->page_id])?$page_list[$val->page_id] : ""}}</td>
                                            <td>{{$val->attachment}}
                                            </td>
                                            <td>
                                                <?php
                                                $created = date_create($val->created_at);
                                                echo date_format($created, "m-d-Y");
                                                ?>
                                            </td>
                                            <td>
                                                <a href="/pdf/{{$val->attachment}}" target="_blank">
                                                    <i class="fa fa-eye text-info mr-5" title="View"></i>
                                                </a>
                                                <a onclick="update_pa('<?php echo $val->id?>')">
                                                    <i class="fa fa-edit text-success mr-5" title="Edit PA"></i>
                                                </a>
                                                <a onclick="delete_pa('<?php echo $val->id?>')">
                                                    <i class="fa fa-trash text-danger mr-5" title="Delete PA"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- New PA -->
<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newModalLabel">New Page Announcements</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="frmNew">
                <div class="modal-body">
                    <div class="form-group">
                        <label>PA Title:</label>
                        <select class="form-control" name="page_id" required>
                            <option value="0">Homepage</option>
                            <option value="1">Become a Trusted Agent</option>
                            <option value="2">Campaign Manager</option>
                            <option value="3">Create New Ad</option>
                            <option value="4">Manage Playlist</option>
                            <option value="5">Resources</option>
                            <option value="6">Why Use INEX Outdoor Digital Advertising?</option>
                            <option value="7">Locations / Pricing</option>
                            <option value="8">Initial Setup – Billing Contact</option>                        
                            <option value="9">Initial Setup – Secondary TA</option>
                            <option value="10">Initial Setup – Social Media Links</option>                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label>PA Content:</label>
                        <div></div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file" required/>
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<button style="display:none" data-toggle="modal" data-target="#editModal" id="btn_update_modal" ></button>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Update Page Announcements</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="frmUpdate">
                <div class="modal-body">
                    <div class="form-group">
                        <label>PA Title:</label>
                        <input type="hidden" name="id"/>
                        <select class="form-control" name="page_id" required>
                            <option value="0">Homepage</option>
                            <option value="1">Become a Trusted Agent</option>
                            <option value="2">Campaign Manager</option>
                            <option value="3">Create New Ad</option>
                            <option value="4">Manage Playlist</option>
                            <option value="6">Why Use INEX Outdoor Digital Advertising?</option>
                            <option value="7">Locations / Pricing</option>
                            <option value="8">Initial Setup – Billing Contact</option>                        
                            <option value="9">Initial Setup – Secondary TA</option>
                            <option value="10">Initial Setup – Social Media Links</option>
                            <option value="5">Initial Setup – Resources</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>PA Content:</label>
                        <div></div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file"/>
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
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
<script src="/assets/js/pa-table.js"></script>
<script>
    // function update_pa(id, title, content, attachment, page_id){
    //     $('#editModal input[name="id"]').val(id);
    //     $('#editModal input[name="title"]').val(title);
    //     $('#editModal textarea[name="content"]').val(content);
    //     $('#editModal select[name="page_id"]').val(page_id);
    //     $("#btn_update_modal").click();
    // }
    function update_pa(id){
        $.ajax({
            url : "/get_pa/"+id,
            type : "GET",
            success : function(res){
                if(res['success'] == true){
                    $('#editModal input[name="id"]').val(res['data']['id']);
                    $('#editModal select[name="page_id"]').val(res['data']['page_id']);
                    $("#btn_update_modal").click();
                }
                else{
                    toastr.error(res);
                }
            },
            error : function(err){
                toastr.error("Please refresh your browser");
            }
        })
    }
    function delete_pa(id){
        var id = id;
        Swal.fire({
            title: "Are you sure?",
            text: "You won\"t be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url : '/delete_pa/'+id,
                    type : "Get",
                    success : function(res){
                        if(res == 'success'){
                            location.reload()
                        }
                        else{
                            toastr.error(res)
                        }
                    },
                    error : function(err){
                        toastr.error("Pleas refresh your browser");
                    }
                })
            }
        });  
    }
    $(document).ready(function(){
        $("#frmNew").submit(function(event){
            KTApp.blockPage();
            event.preventDefault();
            var fs = new FormData(document.getElementById("frmNew"));
            $.ajax({
                url : "/new-pa",
                type : "POST",
                data : fs,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData : false,
                contentType : false,
                success : function(res){
                    KTApp.unblockPage();
                    if(res == 'success'){
                        location.reload();
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
            KTApp.blockPage();
            event.preventDefault();
            var fs = new FormData(document.getElementById("frmUpdate"));
            $.ajax({
                url : "/update-pa",
                type : "POST",
                data : fs,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData : false,
                contentType : false,
                success : function(res){
                    KTApp.unblockPage();
                    if(res == 'success'){
                        location.reload();
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
    })
</script>
