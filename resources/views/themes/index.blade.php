@extends('shopify-app::layouts.default')

@section('styles')
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
          
    <style>
    .form-apps{
        max-width: 100% !Important;
    }
    .response_mail {
border: 1px solid;
padding: 5px;
margin-top: 10px;
margin-bottom: 0px;
text-align: center;
color: #008060;
display: none;
}
        img {
            max-width: 100%;
        }
        .learn-more {
            padding: 10px 0;
            background-color: #fff0;
            width: 300px;
            border-radius: 30px;
            margin: 0 auto;
            line-height: 51px;
            border: 1px solid #8a8a8a30;
            font-size: 13px;
        }
        .learn-more img {
            margin-bottom: 3px;
            height: 14px;
        }
        .learn-more a {
            color: #007bff;
        }
        .loader {
            margin: 0 auto;
            background: transparent;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }
        .modal-lg {
            top: calc( 50% - 120px );
        }
        .modal-content-loading{background: transparent;}
        /* Safari */
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .p_2t1TD {
            color: #fff;
        }
        .p_3iVHs {
            position: relative;
            display: flex;
            align-items: center;
            margin: .4rem;
        }
        .p_2-hnq {
            display: inline-block;
            height: 20px;
            width: 20px;
            max-height: 100%;
            max-width: 100%;
            margin: auto;
            margin-right: 5px;
            top: 5px;
        }
        .p_3yL9P:after {
            background-color: #fff;
        }

        .p_3iVHs:after {
            content: "";
            position: absolute;
            z-index: 1;
            top: -.4rem;
            bottom: -.4rem;
            left: -.4rem;
            right: -.4rem;
            border-radius: 50%;
        }
        .p_3yL9P svg {
            fill: #007bff;
        }
        .p_219ua, .p_v3ASA {
            position: relative;
            z-index: 2;
            display: block;
            width: 100%;
            max-width: 100%;
            max-height: 100%;
        }

h5.alert-heading {
    color: #000;
    font-size: 1rem;
}

.alert.alert-warning {
   display: flex;
    gap: 14px;
    padding: 30px;
}

.modal-dialog {
    max-width: 700px;
}
ul.nav.nav-tabs li a {
    text-align: center;
    background: #4071e9;
    color: #fff;
    border: 0;
    border-radius: 4px;
    text-decoration: none;
    width: 120px;
    /* height: 40px; */
    cursor: pointer;
    margin-right: 17px;
    padding: 9PX;
}
div#Analytics {
    margin-top: 20px;
}
ul.nav.nav-tabs li a {
    color: #fff;
}

.loader {
   margin: 0 auto;
    background: transparent !Important;
    border: 16px solid #f3f3f3 !Important;
    border-radius: 50% !Important;
    border-top: 16px solid #3498db !Important;
    width: 120px !Important;
    height: 120px !Important;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
}

.loader:after {
    content: unset !Important;

}
.update-btnn {
    /* float: right; */
    text-align: right;
}
a.upgrade-btn {
    text-align: center;
    background: #4071e9;
    color: #fff;
    border: 0;
    border-radius: 4px;
    text-decoration: none;
    width: 120px;
    /* height: 40px; */
    cursor: pointer;
    margin-right: 0px;
    padding: 9PX;
    /* margin-bottom: 27px; */
    /* bottom: 30px; */
}
a:hover {
    color: #fff !Important;
}

.close.close-poup-btn {
    position: absolute;
    right: 13px;
    top: 4px;
}

#pixelmodal a:hover {
    color: #206bc4 !important;
}
.main-app-content{
    display: flex;
    justify-content: space-between;
}
    </style>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ URL::asset('css/flags.css') }}" />
    <script type="text/javascript" src="{{ URL::asset('js/flags.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    
    <script>
        var ps_config = {
            productId : "159a468c-e785-402d-9aea-b3eedb47b490"
        };
    </script>

@endsection

@section('content')

@if(empty($shop->widget_status))
    <div class="alert alert-warning" role="alert">
    <i class="fa fa-exclamation-circle" style="font-size:24px"></i>
    <div class="alert-cpntent">
    <h5 class="alert-heading">Missing 1 step to display ATClone on your product page.</h5>
    Learn about <a href="#" style=" color: #206bc4 !important;" data-toggle="modal" data-target="#shopifyPopup">how to add ATClone into product page</a>
    </div>
    </div>
@endif

<!-- The Modal -->
<div class="modal" id="shopifyPopup">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Insert ATClone into product page using Shopify theme editor</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
       <img src="/images/alclone-block-00.png" >
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      <button type="button" class="btn btn-success widget-added">I’ve done it</button>
       <button type="button" class="btn btn-primary"><a style="color:#fff;" target="_blank" href="https://{{$shop->name}}/admin/themes/current/editor?context=section&template=product">Go to theme customize</a></button>
      </div>

    </div>
  </div>
</div>
    @php
        $shop =  \App\User::find(Auth::id());
        $weekDate = \Carbon\Carbon::today()->subDays(7);
        $trackingSum = DB::table("tracking")->where('shopify_domain', $shop->name)->whereDate('created_at',  '>=', $weekDate)->sum('clicks');

        $tracking = DB::table("tracking")->where('shopify_domain', $shop->name)->whereDate('created_at',  '>=', $weekDate)->get();
        
    @endphp
    <div class="jumbotron">
        <div id="toast-container" class="md-toast-top-right alert-close" aria-live="polite" role="alert">
            @if (session('alert-success'))<div class="md-toast md-toast-success" style=""><div class="md-toast-message"> {{session('alert-success')}}</div></div> @endif
        </div>
        <div id="toast-containerx" class="md-toast-top-right" aria-live="polite" role="alert">
            @if (session('alert-error'))<div class="md-toast md-toast-error" style=""><div class="md-toast-message">{{ session('alert-error') }} <br> {!!  session('link-error') !!}</div></div>@endif
        </div>
         <div class="container main-app-content">
            <ul class="nav nav-tabs" style="border-bottom: 0px;">
                <li class="active"><a data-toggle="tab" href="#Settings"><i class="fa fa-cog" aria-hidden="true"></i>  Settings</a></li>
                <li><a data-toggle="tab" href="#Analytics"><i class="fa fa-bar-chart"></i> Analytics</a></li>
                <li><a style="color: #fff;" @if(Auth::user()->plan_id == 3)data-toggle="tab" href="#Pixels" @else onclick="openPixelmodal()" @endif> <i class="fa-solid fa fa-code"></i> Pixels & Tracking</a></li>
            </ul>
            
                <div class="update-btnn">
                    <a href="/plans" class="upgrade-btn">Pricing Plans</a>
                </div>
            
        </div>
        <div class="tab-content">
            <div id="Analytics" class="tab-pane fade">
                <div class="container" style="padding: 0;">
                    <div class="form-apps" style=" background: transparent; padding: 0; margin: 0 auto; border: none; ">
                        <div class="form-group" style=" padding: 0; margin: 0; border: none; ">
                            <div class="row" style="margin-left: 0;margin-right: 0;">
                                <div class="col-md-12 text-center">Last 7 days: <b> {{$trackingSum}}</b> clicks</div>
                                <br>
                                <canvas id="myChart" style="width:100%;height:340px;"></canvas>
                                    <script>
                                        var yValues = [];
                                        var xValues = [];
                                        @foreach($tracking as $itemTrack)
                                        yValues.push({{$itemTrack->clicks}});
                                            xValues.push("{{$itemTrack->date_click}}");
                                        @endforeach

                                        new Chart("myChart", {
                                        type: "line",
                                        data: {
                                        labels: xValues,
                                        datasets: [{
                                            fill: false,
                                            lineTension: 0,
                                            backgroundColor: "rgba(0,0,255,1.0)",
                                            borderColor: "rgba(0,0,255,0.1)",
                                            data: yValues
                                        }]
                                        },
                                        options: {
                                        legend: {display: false},
                                        scales: {
                                            yAxes: [{ticks: {min: 1, max:100}}],
                                        }
                                        }
                                        });
                                        </script>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="Settings" class="tab-pane fade in active show">
                <div class="container">
                    <form action="{{ route('app.submit') }}" method="post" id="form-submit" class="form-apps" enctype="multipart/form-data">
                        @csrf
   
                        <input type="hidden" id="shop_name" name="shop" value="{{$shop->name}}">
                        <div class="form-group header-form">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                    <label>Enable</label>
                                </div>

                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                    <div class="right">
                                        <label class="switch style-v1">
                                            <input type='checkbox' name="active" @if($shop->active) checked @endif value="1"/>
                                            <span class="slider">
                                                <span class="yes">{{ __('app.yes')  }}</span>
                                                <span class="no">{{ __('app.no')  }}</span>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="border-left col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <label>{{ __('app.Label')  }}</label>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control" id="button_label" name="button_label"
                                        placeholder="Add to cart" value="{{ $shop->button_label }}">
                                </div>

                            

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class=" col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <label>Button Background</label>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <input type="color" class="form-control" id="cart_background" name="cart_background"
                                        placeholder="Background color" value="{{ $shop->cart_background }}">
                                </div>

                                <div class="border-left col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <label>{{ __('app.active_width_button') }}</label>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control" id="width_button" name="width_button"
                                        placeholder="" @if(!$shop->width_button) value="0"
                                        @else value="{{ $shop->width_button }}" @endif>
                                </div>

                            </div>
                            </div>
                

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-xs-12"><label>Quantity selector</label></div>
                                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-6">
                                    <div class="right">
                                        <label class="switch">
                                            <input type="checkbox" class="onoffswitch-checkbox" id="status_qty"
                                                name="status_qty" @if($shop->status_qty) checked="checked" @endif value="1">
                                            <span class="slider">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xl-2 border-left col-lg-2 col-md-4 col-sm-6 col-xs-12"><label>Variant selector</label></div>
                                <div class="col-xl-2 col-lg-2 col-md-1 col-sm-6 col-xs-6">
                                    <div class="right">
                                        <label class="switch">
                                            <input type="checkbox" class="onoffswitch-checkbox" id="status_variant"
                                                name="status_variant" @if($shop->status_variant) checked="checked"
                                                @endif value="1">
                                            <span class="slider">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xl-2 border-left col-lg-2 col-md-5 col-sm-6 col-xs-12"><label>Skip to Checkout</label></div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                    <div class="right">
                                        <label class="switch">
                                            <input type="checkbox" class="onoffswitch-checkbox" id="skip_cart"
                                                name="skip_cart" @if($shop->skip_cart) checked="checked" @endif value="1">
                                            <span class="slider">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xl-3 col-lg-5 col-md-5 col-sm-6 col-xs-12"><label>Animation</label></div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                    <div class="right">
                                        <select id="animation" name="animation" class="form-control">
                                            <option value="0" @if($shop->animation == null || $shop->animation == 0) selected @endif>None</option>
                                            <option value="1" @if($shop->animation == 1) selected @endif>Pulse</option>
                                            <option value="2" @if($shop->animation == 2) selected @endif>Shake</option>
                                        </select>
                                    </div>
                                </div>

                                    <div class="border-left col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <label>Trust Badges below the button</label>
                                </div>
                                <div class="col-xl-4 col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <div class="right">
                                        <input type="file" name="images" class="form-control">
                                        @if($shop->images)
                                            <p style="margin-top: 10px;text-align: left;"><img src="{{ asset($shop->images) }}" width="100">
                                                <a href="{{ route('app.remove-image') }}" style="font-weight: bold; font-size: 14px; text-decoration: none;">x</a>
                                            </p>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            </div>
                            
                        
                {{-- 
                        <div class="form-group">
                            <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Add this line of code where you want the widget to appear.</label>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="right">
                                    <input type="text"  class="form-control" value="<div id='clone-app-section'></div>" disabled>
                                    <br>
                                    <button style="width:100%" class="btn-submit btn-install-app" type="button" onclick="RequestInstal()">Request free installation</button>
                                        <div class="response_mail"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        --}}

                    

                        <div class="button-action">
                            <button class="btn-submit" type="submit"
                                    onclick="submitForm()">{{ __('app.save') }}</button>
                        </div>
                        <div class="learn-more text-center">
                            <span class="p_2-hnq p_3yL9P p_2t1TD p_3iVHs"><svg viewBox="0 0 20 20" class="p_v3ASA"
                                                                            focusable="false" aria-hidden="true"><circle
                                            cx="10" cy="10" r="9" fill="currentColor"></circle><path
                                            d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8m0-4a1 1 0 1 0 0 2 1 1 0 1 0 0-2m0-10C8.346 4 7 5.346 7 7a1 1 0 1 0 2 0 1.001 1.001 0 1 1 1.591.808C9.58 8.548 9 9.616 9 10.737V11a1 1 0 1 0 2 0v-.263c0-.653.484-1.105.773-1.317A3.013 3.013 0 0 0 13 7c0-1.654-1.346-3-3-3"></path></svg></span>
                            {{ __('app.learn_more') }} <b> <a href="https://help.fuznet.com/en/category/atclone-xi9m6m/"
                                                            target="_blank">ATClone</a>.</b>
                        </div>
                    </form>
                </div>
            </div>

            <div id="Pixels" class="tab-pane fade">
                <div class="container">
                    <form action="{{ route('app.pixels') }}" method="post" id="form-pixel" class="form-apps" >
                        @csrf
                        <input type="hidden" id="shop_name" name="shop" value="{{$shop->name}}">

                        <div class="form-group ">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                    <label>Facebook Pixel ID</label>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control" id="fb_pxl_id" name="fb_pxl_id"
                                        placeholder="" value="{{ $pixels->fb_id ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                    <label>Google Analytics ID</label>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control" id="google_pxl_id" name="google_pxl_id"
                                        placeholder="" value="{{ $pixels->google_id ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                    <label>Snapchat Pixel ID</label>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control" id="snapchat_pxl_id" name="snapchat_pxl_id"
                                        placeholder="" value="{{ $pixels->snapchat_id ?? '' }}">
                                </div>
                            </div>
                        </div>

                         
                

                        <div class="button-action">
                            <button class="btn-submit" onclick="submitFormPixel()" type="submit"
                                    >{{ __('app.save') }}</button>
                        </div>
                       
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- The Modal -->
        <div class="modal" id="contactModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content-loading">
                    <div class="loader"></div>
                </div>
            </div>
        </div>

        

        <div class="modal fade" id="pixelmodal" tabindex="-1" role="dialog" aria-labelledby="pixelmodal" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-body text-center">
                    <button type="button" class="close close-poup-btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    Pro Member Only. <a href="/plans">Please Upgrade</a>.
                </div>
                
              </div>
            </div>
          </div>


    </div>
    <script type="text/javascript">

        function openPixelmodal()
        {
            $('#pixelmodal').modal('show');
        }
        function openContactModal()
        {
            $('#contactModal').modal('show');
        }
        function submitForm() {
            $( "#form-submit" ).submit();
            openContactModal();
            setTimeout(function() {
                $('#contactModal').modal('hide');
            }, 3000);
        }

        
        function submitFormPixel() {
            $( "#form-pixel" ).submit();
            openContactModal();
            setTimeout(function() {
                $('#contactModal').modal('hide');
            }, 3000);
        }

        $('.btn-submit-contact').click(function(){
            var $myForm = $('#form-app-contact');

            if(! $myForm[0].checkValidity()) {
                $('<input type="submit">').hide().appendTo($myForm).click().remove();
                return;
            }

            $(this).prop('disabled', true);
            $(this).html('submitting...');
            $( "#form-app-contact" ).submit();
        });

    function RequestInstal(){
        var shop = "{{$shop->name}}";
        $.ajax({
        url: "/install-request?shop=" + shop,
        type: 'GET',
        success: function(res) {
            $(".response_mail").empty().html(res).show();
           
        }
    });
    }

        $(function() {

            $(".widget-added").click(function(){
                var shop = "{{$shop->name}}";
                $.ajax({
                    url: "/widget-added?shop=" + shop,
                    type: 'GET',
                    success: function(res) {
                       $("#shopifyPopup").modal("hide"); 
                    
                    }
                });
            });

            var alert = $('div.alert-close');
            alert.each(function() {
                var that = $(this);
                var time_period = 4000;
                setTimeout(function() {
                    that.hide();
                }, time_period);
            });
            $("#countries").msDropdown();
        });
        // partnerdrift
        /*  var XMLReq = new XMLHttpRequest();
          var navigator_info = window.navigator;
          var screen_info = window.screen;
          var uid = navigator_info.mimeTypes.length;
          uid += navigator_info.userAgent.replace(/\D+/g, '');
          uid += navigator_info.plugins.length;
          uid += screen_info.height || '';
          uid += screen_info.width || '';
          uid += screen_info.pixelDepth || '';

          const app_name ="second-add-to-cart-button";         //Enter slug name here which you have created while adding the app.
          const app_price ="3.99";        //app price
          const app_plan ="Base Plan";         //app plan
          const trial_days ="3";//app trial days
          const shop_name ="{{ $shop->shopify_domain }}";    //shop name
        const shop_plan ="recurring";     //shop plan
        const recurring ="monthly"; //app recurring type e.g monthly or yearly, usagebased

        XMLReq.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                var response = this.responseText;
                var responsedata =  JSON.parse( response); //responsedata.type, responsedata.shop_name, responsedata.app_name, responsedata.status
                // If in response you get responsedata.type= referral and responsedata.status= 200 then only you need to save this shop as a referral in your record.
            }
        }
        XMLReq.open('POST', 'https://partnerdrift.com/referral/AddReferral',false);
        XMLReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        var respon = XMLReq.send("u="+uid+"&p="+shop_name+"&a="+app_name+"&r="+app_price+"&t="+app_plan+"&n="+shop_plan+"&e="+trial_days+"&d="+recurring);
        console.log(respon);
        console.log(XMLReq);*/
    </script>
@endsection

@section('scripts')
    @parent

    <script type="text/javascript">
        window.mainPageTitle = 'Main Page';
        /*ShopifyApp.ready(function () {
            ShopifyApp.Bar.setIcon('https://second-button.app.prod.fuznet.com/second_ico.ico');
        });*/
    </script>
    <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="e502d533-2d6c-40d2-abf1-9f6bcc781e77";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
@endsection