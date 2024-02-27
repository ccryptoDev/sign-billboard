@include('front.header')
@include('front.sub-header')
<section class="section pt-0">
    
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-7 col-md-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <div class="section-title ms-lg-1">
                    <h4 class="title mb-4">Get a quote right now. </h4>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-0 text-dark"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Each Ad is displayed for 8 seconds in its slot. It will be guaranteed to be seen between 900 to 5400 times a day (typically somewhere in the middle).   This means your Ads are seen about every 24 seconds to 56 seconds typically.</li>
                        <li class="mb-0 text-dark"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>You can display as many Ads as you want in your slot. (no cost difference).</li>
                        <li class="mb-0 text-dark"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Select / Deselect billboards as you wish.</li>
                        <li class="mb-0 text-dark"><span class="text-primary h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Read your calculated weekly cost at the bottom.</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 order-1 order-md-2">
                <div class="card border-0">
                    <div class="card-body p-0">
                        <img src="/img/72022AC8FDA145BFACFAF095B8A6842A.png" class="img-fluid" alt="Billboard Calculator">
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-items-center mt-5">
            <div class="col-md-12">
                <div class="checkbox-inline" id="listDays" style="display:none">
                    <label class="checkbox checkbox-primary">
                        <input type="checkbox" checked="checked" class="days" value="Mon"> M
                        <span></span>
                    </label>
                    <label class="checkbox checkbox-primary">
                        <input type="checkbox" checked="checked" class="days" value="Tue"> T
                        <span></span>
                    </label>
                    <label class="checkbox checkbox-primary">
                        <input type="checkbox" checked="checked" class="days" value="Wed"> W
                        <span></span>
                    </label>
                    <label class="checkbox checkbox-primary">
                        <input type="checkbox" checked="checked" class="days" value="Thu"> T
                        <span></span>
                    </label>
                    <label class="checkbox checkbox-primary">
                        <input type="checkbox" checked="checked" class="days" value="Fri"> F
                        <span></span>
                    </label>
                    <label class="checkbox checkbox-primary">
                        <input type="checkbox" checked="checked" class="days" value="Sat"> S
                        <span></span>
                    </label>
                    <label class="checkbox checkbox-primary">
                        <input type="checkbox" checked="checked" class="days" value="Sun"> S
                        <span></span>
                    </label>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 mt-4">
                <div class="table-responsive bg-white shadow rounded">
                    <table class="table mb-0 table-center">
                        <thead>
                            <tr>
                                <th scope="col" class="border-bottom"></th>
                                <th scope="col" class="border-bottom">City</th>
                                <th scope="col" class="border-bottom">Location</th> 
                                <th scope="col" class="border-bottom">Facing</th>
                                <th scope="col" class="border-bottom">Weekly Rate</th>
                                <!-- <th scope="col" class="border-bottom">Discount Cost</th>     -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locations as $key => $val)
                                @if($val['price'] != null)
                                    <?php
                                        $side = 'East';
                                        if(str_contains(strtolower($val['name']),'east')){
                                            $side = "East";
                                        }
                                        if(str_contains(strtolower($val['name']),'west')){
                                            $side = "West";
                                        }
                                        if(str_contains(strtolower($val['name']),'south')){
                                            $side = "South";
                                        }
                                        if(str_contains(strtolower($val['name']),'north')){
                                            $side = "North";
                                        }
                                        $prices = explode(",",$val['price']);
                                        $init = 0;
                                        $num = 0;
                                        foreach($prices as $item){
                                            if($item != ''){
                                                $init += $item;
                                                $num++;
                                            }
                                        }
                                        $init = $init / $num;
                                    ?>
                                    <tr class="locationTr">
                                        <td class="text-center">
                                            <input type="checkbox" class="select-location" data-name="edmond" data-id="{{$val['id']}}">
                                        </td>
                                        <td>Edmond</td>
                                        <td>{{$val['name']}}</td>
                                        <td>{{$side}}</td>
                                        <td class="init">${{number_format(0, 0)}}</td>
                                        <!-- <td class="discount">${{number_format(0, 0)}}</td> -->
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="offset-md-8 col-md-4 mt-5">
                    <table class="w-100 cus-table">
                        <tr>
                            <td>Standard Weekly Charges</td>
                            <td id="weeks"></td>
                        </tr>
                        <tr class="d-none">
                            <td>Discounts</td>
                            <td id="total_discount"></td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td id="total"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
@include('front.footer')
<script>
    $(document).ready(function(){
        calc_dis();
        $(".select-location, .days").on('change', function(){
            calc_dis();
        })
        // $(".locationTr").on('click', function(){
        //     $(this).find('input').prop('checked') == true ? $(this).find('input').prop('checked', false) : $(this).find('input').prop('checked', true);
        //     calc_dis();
        // })
        function calc_dis(){
            var days = [];
            $("#listDays").find('input').each(function(){
                if($(this).prop('checked') == true){
                    days.push($(this).val());
                }
            })
            var locations = [];
            $(".select-location").each(function(){
                locations.push($(this).prop('checked')==true?$(this).data('id'):"")
            })
            $.ajax({
                url : '/get-price',
                type : 'GET',
                data : {
                    days : days,
                    locations : locations,
                },
                success : function(res){
                    if(res['discounts']){
                        for(var i = 0; i < res['init'].length; i++){
                            $($(".init")[i]).text("$ "+res['init'][i])
                            $($(".discount")[i]).text("$ "+res['discounts'][i])
                        }
                        $("#weeks").text("$" + res['total'][0])
                        $("#total_discount").text("$" + res['total'][1])
                        $("#total").text("$" + res['total'][0])
                        // $("#total").text("$" + res['total'][2])
                    }
                }
            })
        }
    })
</script>