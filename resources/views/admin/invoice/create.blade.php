@include('admin.include.admin-header')
	<style>
        table thead{
            border : 2px solid #ddd;
            background : #ededed;
        }
        thead tr th{
            text-align : center;
        }
        table tbody{
            border : 2px solid #ddd;
        }
        .trash{
            vertical-align : middle !important;
        }
        .total-body td:first-child{
            width : 50%;
        }
    </style>
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader min-h-lg-15px pt-5 pb-7 subheader-transparent" id="kt_subheader">
		</div>
		<div class="d-flex flex-column-fluid">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="card card-custom overflow-hidden" data-card="true" id="kt_card_1">
							<div class="card-header">
								<div class="card-title">
									<h3 class="card-label">{{$page_name}}</h3>
								</div>
							</div>
							<div class="card-body p-0">
                                <form id="frmNew">
                                    <div class="row justify-content-center pt-8 px-md-0">
                                        <div class="col-md-9">
                                            <div class="d-flex justify-content-between pb-10 pb-md-5 flex-column flex-md-row">
                                                <div>
                                                    <h6 class="font-weight-boldest mb-3">Information Exchange Network, Inc.</h6>
                                                    <h6 class="mb-3">17021 Wales Green Avenue</h6>
                                                    <h6 class="mb-3">Edmond OK 73012</h6>
                                                    <h6 class="mb-3"><a href="tel:4054143002" class="text-dark">4054143002</a></h6>
                                                </div>
                                                <div>
                                                    <h1 class="display-4 font-weight-boldest mb-10" style="color:#a1a1a1">INVOICE</h1>
                                                </div>
                                                <div class="d-flex flex-column align-items-md-end px-0">
                                                    <a class="mb-10">
                                                        <img src="/logo.png" alt="" height="50"/>
                                                    </a>
                                                    <table class="border-0">
                                                        <tbody class="border-0">
                                                            <tr class="border-0" style="min-height:100px">
                                                                <td><span class="font-weight-boldest">Invoice #:</span></td>
                                                                <td style="padding:10px">{{$invoice->id + 1}}</td>
                                                            </tr>
                                                            <tr class="border-0">
                                                                <td><span class="font-weight-boldest">Today's Date:</span></td>
                                                                <td><input type="date" class="form-control" value="{{date('Y-m-d')}}"></td>
                                                            </tr>
                                                            <tr class="border-0" style="min-height:100px">
                                                                <td><span class="font-weight-boldest">Amount Due:</span></td>
                                                                <td class="total_sub" style="padding:10px"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center pb-8">
                                        <div class="col-md-3">
                                            <div class="">
                                                <h5 class="mt-3 mb-1">Bill To</h5>
                                                <select class='form-control select2' id="user" name="user" autocomplete="off">
                                                    <option value=""></option>
                                                    @foreach($users as $key => $val)
                                                        <option value="{{$val->id}}">{{$val->business_name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="dis-user mt-3"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>
                                    <div class="row justify-content-center py-8 px-8 py-md-3 px-md-0">
                                        <div class="col-md-9">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="pl-0 font-weight-bold text-muted  text-uppercase">Due Date</th>
                                                            <th class="font-weight-bold text-muted text-uppercase">Terms</th>
                                                            <th class="pr-0 font-weight-bold text-muted text-uppercase">Sales Rep</th>
                                                            <th class="pr-0 font-weight-bold text-muted text-uppercase">Account Number</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="font-weight-boldest">
                                                            <td><input class="form-control due_date" type="date" name="due_date" value="{{date('Y-m-d')}}"></td>
                                                            <td>
                                                                <select class="form-control terms" name="terms" autocomplete="off">
                                                                    <option value="0" data-init="{{date('Y-m-d')}}">Dues upon Receipt</option>
                                                                    <option value="1" data-init="{{date('Y-m-d', strtotime('today + 30 days'))}}">30 Days Net</option>
                                                                </select>
                                                            </td>
                                                            <td><input class="form-control" type="text" id="sales_rep" name="sales_rep" value=""></td>
                                                            <td><input class="form-control" type="text" id="account_number" name="account_number" value="<?php echo rand(10000, 999999)?>"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center py-8 px-8 py-md-3 px-md-0">
                                        <div class="col-md-9">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="pl-0 font-weight-bold text-muted  text-uppercase">Date</th>
                                                            <th class="font-weight-bold text-muted text-uppercase">Item</th>
                                                            <th class="font-weight-bold text-muted text-uppercase">Quantity</th>
                                                            <th class="font-weight-bold text-muted text-uppercase">Price</th>
                                                            <th class="pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                                                            <th class="pr-0 font-weight-bold text-muted text-uppercase">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="products">
                                                        <tr class="font-weight-boldest">
                                                            <td class="pl-0 pt-7 border-top-0">
                                                                <input type="date" class='form-control' name="date[]" value="<?php echo date("Y-m-d")?>">
                                                            </td>
                                                            <td class="text-left pt-7">
                                                                <input class="form-control item" name="item[]" type="text">
                                                            </td>
                                                            <td class="text-left pt-7">
                                                                <input class="form-control quantity" name="quantity[]" type="number" value="1" min="1">
                                                            </td>
                                                            <td class="text-left pt-7">
                                                                <input class="form-control price" name="price[]" data-inputmask-alias="currency" prefix="$ ">
                                                            </td>
                                                            <td class="text-danger pr-0 pt-7 text-left">
                                                                <input class="form-control subtotal" disabled data-inputmask-alias="currency" prefix="$ ">
                                                            </td>
                                                            <td class="text-danger pr-0 pt-7 text-center trash">
                                                                <i class='fa fa-trash text-danger'></i>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <button class="btn btn-light-success" type="button" id="newLine">New Line</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center pt-8 px-md-0">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-4">
                                            <table class="border-0 w-100">
                                                <tbody class="border-0 total-body">
                                                    <tr class="border-0" style="min-height:100px">
                                                        <td><span class="font-weight-boldest">Subtotal:</span></td>
                                                        <td style="padding:10px" class="total_sub">$0.00</td>
                                                    </tr>
                                                    <tr class="border-0">
                                                        <td><span class="font-weight-boldest">Tax Rate(%):</span></td>
                                                        <td style="padding:10px">
                                                            <input class="form-control tax" name="tax" data-inputmask-alias="currency" value="{{number_format(0,2)}}">
                                                        </td>
                                                    </tr>
                                                    <tr class="border-top" style="min-height:100px">
                                                        <td><span class="font-weight-boldest">Tax Amount($):</span></td>
                                                        <td style="padding:10px" class="tax_amount">$0.00</td>
                                                    </tr>
                                                    <tr class="border-top" style="min-height:100px">
                                                        <td><span class="font-weight-boldest">Total:</span></td>
                                                        <td style="padding:10px" class="total">$0.00</td>
                                                    </tr>
                                                    <tr class="border-0">
                                                        <td><span class="font-weight-boldest">Payments:</span></td>
                                                        <td style="padding:10px">$0.00</td>
                                                    </tr>
                                                    <tr class="border-top" style="min-height:100px">
                                                        <td><span class="font-weight-boldest">Amount Due:</span></td>
                                                        <td style="padding:10px" class="amount_due" data-inputmask-alias="currency" prefix="$ ">$0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                                        <div class="col-md-9 text-right">
                                            <button type="submit" class="btn btn-danger font-weight-bold" id="btn-save">Save Invoice</button>
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
        @include("admin.include.admin-footer")

		<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
		<script src="/assets/plugins/global/plugins.bundle.js"></script>
		<script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="/js/suggest.js"></script>
		<script src="/assets/js/scripts.bundle.js"></script>
        <script src="/assets/js/pages/crud/forms/widgets/select2.js"></script>
        <script src="/js/inputmask.js"></script>
        <script>
            $(".terms").on('change', function(){
                update_due();
            })
            update_due();
            function update_due(){
                var term = $(".terms").val();
                $(".due_date").val($(".terms").find(':selected').data('init'));
            }
            function change_format(data){
                data = data.replace(/\,/g, '');
                data = data.replace(/\$/g, '');
                data = data.replace(/\ /g, '');
                data = data.replace(/\%/g, '');
                return data;
            }
            function calc(){
                var total_sub = 0;
                $("#products").find('tr').each(function(){
                    var quantity = $(this).find('.quantity').val();
                    var price = change_format($(this).find('.price').val());
                    var sub_total = (quantity * price).toFixed(2);
                    total_sub += parseFloat(sub_total);
                    $(this).find('.subtotal').val(sub_total);
                });
                $(".total_sub").each(function(){
                    $(this).text("$ " + parseFloat(total_sub).toFixed(2));
                })
                // $(".tax").text("$ " + parseFloat(total_sub * 0.0885).toFixed(2))
                var tax = 0;
                tax = change_format($(".tax").val());
                tax = total_sub * tax / 100;
                $(".tax_amount").text("$ " + parseFloat(tax).toFixed(2))
                $(".total").text("$ " + parseFloat(total_sub + tax).toFixed(2))
                $(".amount_due").text("$ " + parseFloat(total_sub + tax).toFixed(2))
            }
            function calc_amount(){
                $(".price, .quantity, .tax").on('change', function(){
                    calc();
                })
            }
            $('#user').select2({
                placeholder: "Select a business name"
            });
            $(document).ready(function(){
                define_format();
                calc_amount();
                calc();
                function define_format(){
                    $(".subtotal").inputmask({reverse: true});
                    $(".price").inputmask({reverse: true});
                    $(".tax").inputmask({
                        reverse: true,
                        rightAlign: false,
                        prefix : "% "
                    });
                    // $(".total_sub").inputmask('decimal', {
                    //     reverse: true,
                    //     rightAlign: false,
                    //     prefix : "$ ",
                    // });
                }
                $("#newLine").on('click', function(){
                    var html = '<tr class="font-weight-boldest">'+
                        '<td class="pl-0 pt-7 border-top-0">'+
                            '<input type="date" class="form-control" value="<?php echo date("Y-m-d")?>" name="date[]"'+
                        '</td>'+
                        '<td class="text-left pt-7">'+
                            '<input class="form-control item" type="text" name="item[]">'+
                        '</td>'+
                        '<td class="text-left pt-7">'+
                            '<input class="form-control quantity" type="number" name="quantity[]" value="1" min="1">'+
                        '</td>'+
                        '<td class="text-left pt-7">'+
                            '<input class="form-control price" name="price[]" data-inputmask-alias="currency" prefix="$ ">'+
                        '</td>'+
                        '<td class="text-danger pr-0 pt-7 text-left">'+
                            '<input class="form-control subtotal" disabled data-inputmask-alias="currency" prefix="$ ">'+
                        '</td>'+
                        '<td class="text-danger pr-0 pt-7 text-center trash">'+
                            '<i class="fa fa-trash text-danger"></i>'+
                        '</td>'+
                    '</tr>';
                    $("#products").append(html);
                    define_format();
                    calc_amount();
                    $(".fa-trash").on('click', function(){
                        $(this).parent().parent().remove();
                        calc();
                    })
                })
                $(".fa-trash").on('click', function(){
                    $(this).parent().parent().remove();
                    calc();
                })
                $("#user").on('change', function(){
                    KTApp.blockPage();
                    $.ajax({
                        url : "/get_location/"+$(this).val(),
                        tyep : "get",
                        success : function(res){
                            KTApp.unblockPage();
                            if(res['success'] == true){
                                $(".dis-user")[0].innerHTML = "";
                                var html = "";
                                $(".dis-user")[0].innerHTML = res['user'];
                                $("#sales_rep").val(res['account_manager']);
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
                $("#frmNew").on('submit', function(event){
                    event.preventDefault();
                    var fs = new FormData(document.getElementById('frmNew'));
                    KTApp.blockPage();
                    $.ajax({
                        url : "save-manu-invoice",
                        type : "POST",
                        data : fs,
                        contentType : false,
                        processData : false,
                        headers : {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success : function(res){
                            KTApp.unblockPage();
                            if(res['success'] == true){
                                location.href="/manage-invoice";
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
	</body>
</html>
		