@include('admin.include.admin-header')
<link href="/css/stripe.css" rel="stylesheet" type="text/css"/>
<script src="https://js.stripe.com/v3/"></script>
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
        @page {
            size: A4 portrait;
            margin: 0%;
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
							<div class="card-body p-0" id="print_div">
                                <div class="row m-0">
                                <?php
                                    $free_plan = 0;
                                    $paid_amount = 0;
                                    $paid_week = $invoice->paid;
                                    $today = date("Y-m-d");
                                    $paid_flag = false;
                                    foreach($checkout as $paid){
                                        $paid_amount += $paid->amount;
                                    }
                                    if($paid_amount > $invoice->amount){
                                        $paid_amount = $invoice->amount;
                                    }
                                ?>
                                @if($invoice->free_plan == 1)
                                    <?php 
                                    $free_plan = 1;
                                    ?>
                                    <a class="ml-auto">
                                        <img src="{{ asset('/inv/free.png')}}" alt="" height="100"/>
                                    </a>
                                @elseif($invoice->free_plan == 2)
                                    <?php 
                                    $free_plan = 2;
                                    ?>
                                    <a class="ml-auto">
                                        <img src="{{ asset('/inv/contract.png')}}" alt="" height="100"/>
                                    </a>
                                @elseif($invoice->free_plan == 3)
                                    <?php 
                                    $paid_flag = false;
                                    ?>
                                    <a class="ml-auto">
                                        <img src="{{ asset('/inv/unpaid.png')}}" alt="" height="100"/>
                                    </a>
                                @else
                                    @if($invoice->status == 0)
                                        @if($invoice->paid > 0 && $invoice->invoice_date > $today)
                                            <?php $paid_flag = true?>
                                            <a class="ml-auto">
                                                <img src="{{ asset('/inv/paid.png')}}" alt="" height="100"/>
                                            </a>
                                        @else
                                        <a class="ml-auto">
                                            <img src="{{ asset('/inv/unpaid.png')}}" alt="" height="100"/>
                                        </a>
                                        @endif
                                    @endif
                                    @if($invoice->status == 1)
                                        <?php $paid_flag = true?>
                                        <a class="ml-auto">
                                            <img src="{{ asset('/inv/paid.png')}}" alt="" height="100"/>
                                        </a>
                                    @endif
                                    @if($invoice->status == 2)
                                        <a class="ml-auto">
                                            <img src="{{ asset('/inv/reject.png')}}" alt="" height="100"/>
                                        </a>
                                    @endif
                                    @if($invoice->status == 3)
                                        <a class="ml-auto">
                                            <img src="{{ asset('/inv/incomplete.png')}}" alt="" height="100"/>
                                        </a>
                                    @endif
                                @endif
                                </div>
                                <div class="row justify-content-center py-8 px-8 py-md-3 px-md-0">
                                    <div class="col-md-9">                                        
                                        <div class="row m-0">
                                            <div class="col-4">
                                                <h6 class="font-weight-boldest mb-3">Information Exchange Network, Inc.</h6>
                                                <h6 class="mb-3">17021 Wales Green Avenue</h6>
                                                <h6 class="mb-3">Edmond OK 73012</h6>
                                                <h6 class="mb-3"><a href="tel:4054143002" class="text-dark">(405)415-3002</a></h6>
                                            </div>
                                            <div class="col-4 text-center sm:text-left">
                                                <h1 class="display-4 font-weight-boldest mb-10" style="color:#a1a1a1">INVOICE</h1>
                                            </div>
                                            <div class="col-4 d-flex flex-column align-items-md-end px-0">
                                                <a class="mb-10">
                                                    <img src="/logo.png" alt="" height="50"/>
                                                </a>
                                                <table class="border-0">
                                                    <tbody class="border-0">
                                                        <tr class="border-0" style="min-height:100px">
                                                            <td><span class="font-weight-boldest">Invoice #:</span></td>
                                                            <td style="padding:10px">{{$invoice->id}}</td>
                                                        </tr>
                                                        <tr class="border-0">
                                                            <td><span class="font-weight-boldest">Invoice Date:</span></td>
                                                            <td><input type="date" class="form-control" value="{{$invoice->invoice_date}}" disabled></td>
                                                        </tr>
                                                        <tr class="border-0" style="min-height:100px">
                                                            <td><span class="font-weight-boldest">Amount Due:</span></td>
                                                            <td class="total_sub" style="padding:10px">${{$paid_flag==true||$free_plan==1||$invoice->status==1?number_format(0,2):number_format($invoice->part_amount, 2)}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center py-8 px-8 py-md-3 px-md-0">
                                    <div class="col-sm-3">
                                        <h5 class="mt-3 mb-1">Bill To</h5>
                                            <span>{{isset($business->id)?$business->company_name:session('business_name')}}</span><br>
                                            <span>ATTN: {{isset($business->id)?$business->bill_name:""}}</span><br>
                                            <span>{{isset($business->id)?$business->address:''}}</span><br>
                                            <span>{{isset($business->id)?$business->city.", ".$business->state." ".$business->zip:''}}</span>
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
                                                        <th class="font-weight-bold text-muted text-uppercase">Sales Rep</th>
                                                        <th class="pr-0 font-weight-bold text-muted text-uppercase">Account Number</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $inv_desc = json_decode($invoice->description);
                                                ?>
                                                <tbody>
                                                    <tr class="font-weight-boldest">
                                                        <td><input class="form-control" type="date" disabled value="{{$inv_desc->due}}"></td>
                                                        <td><input class="form-control" type="text" disabled value="{{$inv_desc->terms}}"></td>
                                                        <td><input class="form-control" type="text" disabled value="{{$inv_desc->sales}}"></td>
                                                        <td><input class="form-control" type="text" disabled value="{{$inv_desc->account_number}}"></td>
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
                                                    </tr>
                                                </thead>
                                                <tbody id="products">
                                                    <?php
                                                        $inv_data = json_decode($invoice->data);
                                                        $weeks = 0;
                                                        $total_amount = 0;
                                                    ?>
                                                    @foreach($inv_data as $key => $val)
                                                    <tr class="font-weight-boldest">
                                                        <td class="pt-7 border-top-0">
                                                            <input type="date" class='form-control' value="{{$val->due}}" disabled>
                                                        </td>
                                                        <td class="text-left pt-7">
                                                            {{$val->item}}
                                                        </td>
                                                        <td class="text-left pt-7">
                                                            <input class="form-control quantity" type="number" value="{{$val->quantity}}" disabled min="1">
                                                        </td>
                                                        <td class="text-left pt-7">
                                                            <input class="form-control price" style="color:red !important" value="${{$val->price}}" disabled data-inputmask-alias="currency" prefix="$ ">
                                                        </td>
                                                        <td class="text-danger pr-0 pt-7 text-left">
                                                            <?php
                                                            $total_amount += $val->sub_total;
                                                            ?>
                                                            <input class="form-control subtotal" value="${{$val->sub_total}}" disabled data-inputmask-alias="currency" prefix="$ ">
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center py-8 px-8 py-md-3 px-md-0">
                                    <div class="col-6"></div>
                                    <div class="col-3">
                                        <table class="border-0 w-100">
                                            <tbody class="border-0">
                                                <tr class="border-0" style="min-height:100px">
                                                    <td><span class="font-weight-boldest">Subtotal :</span></td>
                                                    <td style="padding:10px" class="total_sub text-right">${{number_format($total_amount,2)}}</td>
                                                </tr>
                                                <tr class="border-0" style="min-height:100px">
                                                    <td><span class="font-weight-boldest">Tax Rate :</span></td>
                                                    <td style="padding:10px" class="text-right">{{$invoice->extra}}%</td>
                                                </tr>
                                                <tr class="border-0" style="min-height:100px">
                                                    <td><span class="font-weight-boldest">Tax Amount :</span></td>
                                                    <?php
                                                    $tax_amount = $invoice->extra / 100 * $total_amount;
                                                    ?>
                                                    <td style="padding:10px" class="text-right">${{number_format($tax_amount,2)}}</td>
                                                </tr>
                                                <tr class="border-top" style="min-height:100px">
                                                    <td><span class="font-weight-boldest">Total :</span></td>
                                                    <td style="padding:10px" class="total_sub text-right">${{number_format($total_amount + $tax_amount,2)}}</td>
                                                </tr>
                                                <tr class="border-0">
                                                    <td><span class="font-weight-boldest">Payments :</span></td>
                                                    <td style="padding:10px" class="text-right">${{number_format($paid_amount, 2)}}</td>
                                                </tr>
                                                <tr class="border-top" style="min-height:100px">
                                                    <td><span class="font-weight-boldest">Amount Due :</span></td>
                                                    <td style="padding:10px" class="total_sub  text-right" data-inputmask-alias="currency" prefix="$ ">${{$paid_flag==true||$free_plan==1||$invoice->status==1?number_format(0,2):number_format($invoice->part_amount, 2)}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
							</div>
                            <div class="card-footer">
                                <div class="row justify-content-center">
                                    <div class="col-md-9">
                                        <?php
                                        $payment_method = [];
                                        ?>
                                        @if(session('level') >= 2 && $paid_flag == false)
                                            <button type="button" class="btn btn-success font-weight-bold float-right" onclick="send_payment_link({{$invoice->id}})">Send Payment Link</button>
                                        @endif
                                        @if($invoice->status != 1 && session('level') < 2)
                                            <?php
                                                $payment_method = isset($p_method->payment_method)?json_decode($p_method->payment_method, true):[];
                                            ?>
                                            @if(in_array('0', $payment_method))
                                                <button type="button" class="btn btn-danger font-weight-bold float-right" id="no_charge">No Charge</button>
                                            @else
                                                @if($paid_flag === false)
                                                    <button type="button" class="btn btn-danger font-weight-bold float-right" data-toggle="modal" data-target="#payModal">Pay</button>
                                                @endif
                                            @endif
                                        @endif
                                        <button type="button" class="btn btn-primary float-right mr-5" id="print">Print</button>
                                        <a type="button" class="btn btn-info float-right mr-5" href="{{ url()->previous() }}">Back</a>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form id="payment-form">
                    <div class="modal-body">
                        <?php
                        $remain = $invoice->part_amount;
                        ?>
                        @if(session('level') < 2 && $invoice->status != 1)
                        <div class="form-group" id="pay_method">
                            <h5>Payment Method Chosen</h5>
                            <input id="init_total" value="{{$invoice->part_amount}}" class="form-control" type="hidden">
                            <div class="radio-inline">
                                @if(in_array('2', $payment_method) && $campaign->pay_method == 0)
                                <label class="radio">
                                    <input type="radio" checked name="method" value="0"/>
                                    <span></span>
                                    Credit Card
                                </label>
                                @endif
                                @if(in_array('1', $payment_method) && $campaign->pay_method == 1)
                                <label class="radio">
                                    <input type="radio" checked name="method" value="1"/>
                                    <span></span>
                                    Send Invoice
                                </label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Amount</label>
                            <input id="total" value="{{number_format($remain, 2)}}" class="form-control" disabled>
                        </div>
                        <div class="credit-card">
                            @if(session('business_name') != "1 Demo")
                                <label for="card-element">
                                    Credit or debit card
                                </label>
                                <div class="form-group">
                                    <input class="form-control" name="user_name" value="{{session('user_name')}}" placeholder="User Name" required>
                                </div>
                                <div id="card-element"></div>
                                <div id="card-errors" role="alert" class="mt-2"></div>
                                <div class="form-group">
                                    <input class="form-control" name="zip" value="{{$user->zip}}" placeholder="Zip code" required>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Name on Card</label>
                                            <input type="text" class="form-control form-control-solid form-control-lg" name="ccname" placeholder="Card Name" value="{{session('user_name')}}" />
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Card Number</label>
                                            <input type="text" class="form-control form-control-solid form-control-lg" name="ccnumber" placeholder="Card Number" value="4242 4242 4242 4242" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="form-group">
                                            <label>Card Expiry Month</label>
                                            <input type="number" class="form-control form-control-solid form-control-lg" name="ccmonth" placeholder="Card Expiry Month" value="01" />
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="form-group">
                                            <label>Card Expiry Year</label>
                                            <input type="number" class="form-control form-control-solid form-control-lg" name="ccyear" placeholder="Card Expire Year" value="21" />
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="form-group">
                                            <label>Card CVV Number</label>
                                            <input type="password" class="form-control form-control-solid form-control-lg" name="cccvv" placeholder="Card CVV Number" value="123" />
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary font-weight-bold btn-submit">Pay - ${{number_format($remain,2)}}</button>
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        @include("admin.include.admin-footer")

		<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
		<script src="{{ asset('/assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{ asset('/assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
		<script src="{{ asset('/js/suggest.js')}}"></script>
		<script src="{{ asset('/assets/js/scripts.bundle.js')}}"></script>
        <script src="{{ asset('/assets/js/pages/crud/forms/widgets/select2.js')}}"></script>
        <script type="text/JavaScript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.js"></script>
        <script src="{{ asset('/js/inputmask.js')}}"></script>
        <script>
            // Print
            // $("#pay_method").find('input').on('change', function(){
            //     if($(this).val() == 0){
            //         $(".credit-card").css('display', 'block');
            //     }
            //     else{
            //         $(".credit-card").css('display', 'none');
            //     }
            // })
            function send_payment_link(id){
                var id = id;
                KTApp.blockPage();
                $.ajax({
                    url : '/send-link-manual/'+id,
                    type : "Get",
                    success : function(res){
                        KTApp.unblockPage();
                        if(res == 'success'){
                            toastr.success("Success");
                        }
                        else{
                            toastr.error(res)
                        }
                    },
                    error : function(err){
                        KTApp.unblockPage();
                        toastr.error("Pleas refresh your browser");
                    }
                })
            }
            $("#print").click(function(){
                $("#print_div").print();
            })
            // Stripe           
            <?php
            if(session('business_name') != "1 Demo"){
            ?>
            var stripe = Stripe("{{config('app.st_pub')}}");
            var elements = stripe.elements();
            var style = {
                base: {
                    color: "#32325d",
                }
            };

            var card = elements.create("card", { style: style, hidePostalCode : true});
            card.mount("#card-element");
            card.on('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.complete) {
                    // enable payment button
                    displayError.textContent = '';
                } else if (event.error) {
                    // show validation to customer
                    displayError.textContent = event.error.message;
                }
            });
            function stripeTokenHandler(token) {
                var form = new FormData(document.getElementById('payment-form'));
                form.append('token',token.id);
                form.append('type',token.type);
                form.append('amount', $("#total").val());
                form.append('inv_id', "<?php echo $invoice->id?>");
                KTApp.blockPage();
                $.ajax({
                    url : "/checkout-manual",
                    type : "POST",
                    data : form,
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData : false,
                    success : function(res){
                        KTApp.unblockPage();
                        if(res == 'success'){
                            // toastr.success("Thanks for your payment");
                            location.href = '/manage-campaign';
                        }
                        else{
                            Swal.fire(res, "", "error");
                        }
                    },
                    error : function(err){
                        KTApp.unblockPage();
                        toastr.error("Please refresh your browser.");
                    }
                })
            }
            function createToken() {
                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                    } else {
                        stripeTokenHandler(result.token);
                    }
                });
            };

            // Create a token when the form is submitted.
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                createToken();
            });
            <?php }
            else{
            ?>
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(e){
                e.preventDefault();
                var fs = new FormData(document.getElementById('payment-form'));
                fs.append('amount', $("#total").val());
                fs.append('inv_id', "<?php echo $invoice->id?>");
                $.ajax({
                    url : "/checkout-demo",
                    type : "POST",
                    data : fs,
                    processData : false,
                    contentType : false,
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function(res){
                        if(res == "success"){
                            location.href = '/manage-campaign';
                        }
                        else{
                            toastr.error(res);
                        }
                    },
                    error : function(err){
                        toastr.error("Please refresh your browser");
                    }
                })
            })
            <?php }?>
            // End of Stripe
            $(document).ready(function(){
                define_format();
                function define_format(){
                    $(".subtotal").inputmask({reverse: true, rightAlign : false});
                    $(".price").inputmask({reverse: true, rightAlign : false});
                }
            })
            // Free
            <?php
            if(session('level') < 2){
                if(in_array('0', $payment_method)){
            ?>
                $("#no_charge").click(function(){
                    $.ajax({
                        url : "/no-charge/<?php echo $invoice->id?>",
                        type : "POST",
                        headers : {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success : function(res){
                            if(res == 'success'){
                                location.href = '/manage-campaign';
                            }
                            else{
                                toastr.error(res);
                            }
                        },
                        error : function(err){
                            toastr.error("Please refresh your browser");
                        }

                    })
                })
            <?
                }
            }
            ?>
        </script>
	</body>
</html>
		