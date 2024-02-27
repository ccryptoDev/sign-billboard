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
th, td {border: 1px solid black;color: #000;padding:10px;}
.maptext {font-size: 24px;color: #000;margin-bottom: 10px;}
.form-check{
    display : inline-block;
}
.cus-table td{
    border : 0px;
}
.cus-scroll{
    overflow-y : scroll;
}
.cus-scroll::-webkit-scrollbar-track {
    background : white;
}
.cus-scroll::-webkit-scrollbar-thumb{
    background : white;
}
</style>
<section id="main-banner-page" class="position-relative page-header service-header section-nav-smooth parallax" style="background-image:url('/assets/media/bg/bg-10.jpg');">
    <div class="overlay overlay-dark opacity-7 z-index-1"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="page-titles whitecolor text-center padding_top_half padding_bottom">
                    <h2 class="font-bold  padding_top">Locations / Pricing</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Page Header ends -->
<section id="aboutus" class="padding_half">
    <div class="container aboutus">
        <div class="form-group row">
            <div class="col-form-label col-md-12 text-left maptext">
                Get a quote right now. 
            </div>
            <ul class="mt-3">
                <li><p>1. Each Ad is displayed for 8 seconds in its slot. It will be guaranteed to be seen between 900 to 5400 times a day (typically somewhere in the middle).   This means your Ads are seen about every 24 seconds to 56 seconds typically.</p></li>
                <li><p>2. You can display as many Ads as you want in your slot. (no cost difference).</p></li>
                <li><p>3. Select / Deselect billboards as you wish.</p></li>
                <li><p>4. Read your calculated weekly cost at the bottom</p></li>
            </ul>
            <!-- <div class="col-form-label col-md-12 text-left maptext">Days of the Week</div> -->
            <div class="col-md-12">
                <div class="checkbox-inline" id="days" style="display:none">
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
        </div>
        <div class="row align-items-top">
            <div class="col-lg-12 col-md-12 padding_bottom_half text-center text-md-left cus-scroll">
                <table style="width:100%;">
                    <tr>
                        <th style=""></th>
                        <th style="">City</th>
                        <th style="width:40%">Location</th> 
                        <th style="">Facing</th>
                        <th style="">Weekly Rate</th>
                        <th style="">Discount Cost</th>
                    </tr>
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
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="select-location" data-name="edmond" data-id="{{$val['id']}}">
                                </td>
                                <td>Edmond</td>
                                <td>{{$val['name']}}</td>
                                <td>{{$side}}</td>
                                <td class="init">${{number_format(0, 0)}}</td>
                                <td class="discount">${{number_format(0, 0)}}</td>
                            </tr>
                        @endif
                    @endforeach
                    <!-- <tr>
                        <td class="text-center">
                            <input type="checkbox" class="select-location" data-name="edmond" data-id="6">
                        </td>
                        <td>Edmond</td>
                        <td>195 E Waterloo Rd</td>
                        <td>East</td>
                        <td class="init">$165</td>
                        <td class="discount">$165</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="select-location" data-name="edmond" data-id="10">
                        </td>
                        <td>Edmond</td>
                        <td>195 E Waterloo Rd</td>
                        <td>West</td>
                        <td class="init">$165</td>
                        <td class="discount">$165</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="select-location" data-name="reno" data-id="7">
                        </td>
                        <td>El Reno</td>
                        <td>1171 S Country Club Rd</td>
                        <td>North</td>
                        <td class="init">$135</td>
                        <td class="discount">$135</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="select-location" data-name="reno" data-id="8">
                        </td>
                        <td>El Reno</td>
                        <td>1171 S Country Club Rd</td>
                        <td>South</td>
                        <td class="init">$135</td>
                        <td class="discount">$135</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="select-location" data-name="nicoma" data-id="14">
                        </td>
                        <td>Nicoma Park</td>
                        <td>2540 Liberty Blvd</td>
                        <td>East</td>
                        <td class="init">$160</td>
                        <td class="discount">$160</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="select-location" data-name="nicoma" data-id="15">
                        </td>
                        <td>Nicoma Park</td>
                        <td>2540 Liberty Blvd</td>
                        <td>West</td>
                        <td class="init">$160</td>
                        <td class="discount">$160</td>
                    </tr> -->
                </table>
			</div>
            <div class="offset-md-8 col-md-4">
                <table class="w-100 cus-table">
                    <tr>
                        <td>Standard Weekly Charges</td>
                        <td id="weeks"></td>
                    </tr>
                    <tr>
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
		
        <div class="row align-items-center cus-scroll">
            <div class="col-lg-6 col-md-6">
                <div class="align-items-center maptext">Edmond</div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3239.013960674772!2d-97.47840468504803!3d35.72587518018391!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x87b1f501f77acd33%3A0x7de290de78631ddf!2s195%20E%20Waterloo%20Rd%2C%20Edmond%2C%20OK%2073025%2C%20USA!5e0!3m2!1sen!2sin!4v1609855000367!5m2!1sen!2sin" width="550" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="align-items-center maptext">El Reno</div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3247.268042404507!2d-97.97482748474553!3d35.522373280231676!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x87ade4d87ec6d4a7%3A0x5dec02db235b1c01!2s1171%20S%20Country%20Club%20Rd%2C%20El%20Reno%2C%20OK%2073036%2C%20USA!5e0!3m2!1sen!2sin!4v1609855207255!5m2!1sen!2sin" width="550" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
        </div>
        <div class="row align-items-center cus-scroll">
            <div class="col-lg-6 col-md-6 padding_bottom_half">
                <div class="align-items-center maptext">Nicoma Park</div>
                <iframe src=https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3248.444453682711!2d-97.34611738467642!3d35.49328678023855!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x87b23baad0e9fddf%3A0x243a628a1282d1a8!2s2540%20Liberty%20Blvd%2C%20Nicoma%20Park%2C%20OK%2073066!5e0!3m2!1sen!2sus!4v1644334066822!5m2!1sen!2sus width="550" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>
@include('footer')

<script>
    $(document).ready(function(){
        calc_dis();
        $(".select-location, .days").on('change', function(){
            calc_dis();
        })
        function calc_dis(){
            var days = [];
            $("#days").find('input').each(function(){
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
                        $("#total").text("$" + res['total'][2])
                    }
                }
            })
        }
    })
</script>
