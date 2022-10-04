<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('shopify-app.app_name') }}</title>

    @yield('styles')
</head>

<body>
<div class="app-wrapper">
    <div class="app-content">
        <main role="main">
            @yield('content')
        </main>
    </div>
</div>
{{--
<script src="https://unpkg.com/@shopify/app-bridge@0.8.2/index.js"></script>
--}}
<script src="https://unpkg.com/@shopify/app-bridge@2"></script>
<script>
    var AppBridge = window['app-bridge'];
    var createApp = AppBridge.default;
    var actions = window['app-bridge']['actions'];
    var Button = actions.Button;
    var TitleBar = actions.TitleBar;

    var app = createApp({
        apiKey: '{{ config('shopify-app.api_key') }}',
        shopOrigin: '{{ \Illuminate\Support\Facades\Auth::user()->name }}',
        forceRedirect: true,
        });
    var button = Button.create(app, {label: "{{ __('app.help')  }}"});
    var review = Button.create(app, {label: "{{ __('app.leave_review')  }} ❤︎"});
    var ourApps = Button.create(app, {label: "{{ __('app.our_apps')  }}"});
    var ourThemes = Button.create(app, {label: "{{ __('app.our_themes') }}"});

    TitleBar.create(app, {
        buttons: {
            primary: button,
            secondary: [review,ourApps,ourThemes]
        },
    });

    ourApps.subscribe(Button.Action.CLICK, data => {
        window.open('https://apps.shopify.com/partners/fuznet','_blank');
    });

    ourThemes.subscribe(Button.Action.CLICK, data => {
        window.open('https://1.envato.market/rPmjR','_blank');
    });

    review.subscribe(Button.Action.CLICK, data => {
        window.open('https://apps.shopify.com/second-add-to-cart-button?reveal_new_review=true','_blank');
    });
    button.subscribe(Button.Action.CLICK, data => {
        window.open('https://help.fuznet.com/en/category/atclone-xi9m6m/','_blank');
    });
    $(function() {
        var alert = $('div.alert-close');
        alert.each(function() {
            var that = $(this);
            var time_period = 4000;
            setTimeout(function() {
                that.hide();
            }, time_period);
        });
        $("#countries").msDropdown();
        $("#status_flag").change(function(){
            if($('#status_flag:checkbox:checked').length){
                $('.direct-checkout').show();
            }else{
                $('.direct-checkout').hide();
            }
        });
    });
</script>
<script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="e502d533-2d6c-40d2-abf1-9f6bcc781e77";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>

{{--@include('shopify-app::partials.flash_messages')--}}

@yield('scripts')
</body>

</html>
