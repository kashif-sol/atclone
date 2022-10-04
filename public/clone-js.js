var shopdomain = Shopify.shop;
var product_url = window.location.href;
product_url = product_url.replace(/(\?.*)|(#.*)/g, "");
var product_details = "";
var animation = '';
var FB_PIXEL_ID = "";
var GOOGLE_PIXEL_ID = "";
var SNAPCHAT_PIXEL_ID = "";
! function(f, b, e, v, n, t, s) {
    if (f.fbq) return;
    n = f.fbq = function() {
        n.callMethod ?
            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
    };
    if (!f._fbq) f._fbq = n;
    n.push = n;
    n.loaded = !0;
    n.version = '2.0';
    n.queue = [];
    t = b.createElement(e);
    t.async = !0;
    t.src = v;
    s = b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t, s)
}(window, document, 'script',
    'https://connect.facebook.net/en_US/fbevents.js');

(function(e, t, n) {
    if (e.snaptr) return;
    var a = e.snaptr = function() { a.handleRequest ? a.handleRequest.apply(a, arguments) : a.queue.push(arguments) };
    a.queue = [];
    var s = 'script';
    r = t.createElement(s);
    r.async = !0;
    r.src = n;
    var u = t.getElementsByTagName(s)[0];
    u.parentNode.insertBefore(r, u);
})(window, document,
    'https‍://sc-static.‍net/scevent.min.‍js');
(function(i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function() {
        (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date();
    a = s.createElement(o),
        m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');



async function getProduct() {

    const result = await fetch(product_url + ".json");

    if (result.status === 200) {
        return result.json();
    }

    throw new Error(`Failed to get request, Shopify returned ${result.status} ${result.statusText}`);
}

(async() => {
    const product = await getProduct();
    product_details = product.product;
    get_settings();
})();

function get_settings() {

    APP_URL = "https://second-button.app.prod.fuznet.com/api/get-settings?shop=" + shopdomain;

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        let responseObj = xhttp.response;
        var settings = JSON.parse(responseObj);
        var status = settings.active;
        FB_PIXEL_ID = settings.fb_id;
        GOOGLE_PIXEL_ID = settings.google_pxl_id;
        SNAPCHAT_PIXEL_ID = settings.snapchat_pxl_id;

        if (status != "" && status == 1) {

            create_html(settings);
        }

    }
    xhttp.open("GET", APP_URL);
    xhttp.send();

}



function create_html(settings) {
    var $images = '';
    var $skipCart = '';
    var $widthButton = 'style="width:auto;"';
    var $showVariant = '';
    var $showQty = '';

    if (settings.animation == 1) {
        animation = 'pulse';
    }
    if (settings.animation == 2) {
        animation = 'shake';
        setInterval(shake, 2000);
    }
    if (settings.skip_cart == 1) {
        $skipCart = '<input type="hidden" name="return_to" value="/checkout" />';
    }
    var cart_bg = "#000";
    if (settings.cart_background != null) {
        cart_bg = "" + settings.cart_background;
    }
    if (settings.width_button) {
        $widthButton = 'style="width:' + settings.width_button + ';background-color: ' + cart_bg + '"';
    }

    if (settings.width_button == 0) {
        $widthButton = 'style="width:auto;background-color: ' + cart_bg + ' "';
    }

    if (!settings.status_variant) {
        $showVariant = 'style="display:none;"';
    }

    if (!settings.status_qty) {
        $showQty = 'style="display:none;"';
    }
    $checkoutX = '';
    if (settings.checkoutx) {
        $checkoutX = "checkout-x-buy-now-btn";
    }

    if (settings.image != "") {
        $images = '<img src="' + settings.image + '">';
    }


    var variants = product_details.variants;
    var product_var_dropdown = "";
    if (variants.length == 1) {
        product_var_dropdown = '<input name="id" value="' + variants[0].id + '" type="hidden" />';
    } else {
        product_var_dropdown = '<select  name="id"  class="product-variants  form-ctl" ' + $showVariant + '>';
        variants.map(function(variant) {
            product_var_dropdown += '<option   value="' + variant.id + '">' + variant.title + '</option>';
        });
        product_var_dropdown += '</select>';

    }
    var formHtml = `
          <form action="/cart/add" class="clone-cart-btn" method="post" id="addToCartForm">` + $skipCart + `
			<div class="form-gr ">
				` + product_var_dropdown + `
			</div>
			<div class="form-gr">
                <div class="qty-form" ` + $showQty + `>
                    <span class="minus" onclick="minusFunction()">-</span>
                    <input type="text" id="quantity" name="quantity" value="1" min="1" class="quantity-selector" >
                    <span class="plus" onclick="plusFunction()">+</span>
                </div>
                <button type="button" name="add" id="addToCart" class="btn add-cart-secondary ` + animation + ` ` + $checkoutX + `" ` + $widthButton + `>
                    <span id="AddToCartText">` + settings.button_label + `</span>
                 </button>
                 </div>
		</form>
		<div class="clone-image">` + $images + `</div>
        `;

    var css_style = `
.form-gr {
  display: flex;
  align-items: center;
  justify-content: flex-start;
gap: 20px;
}
.clone-image img {
    width: 100%;
}
#clone-app-section {
    max-width: 100%;
    margin: auto;
}
select.product-variants.form-ctl {
    border-color: inherit;
    border-width: 1px;
    padding: 8px 14px;
    max-width: 182px;
    margin-bottom: 14px;
    width: 100%;
}
#clone-app-section #quantity {
  height: 48px;
  text-align: center;
  max-width: 100px;
}
.qty-form {
  position: relative;
  text-align: center;
}
span.minus {
  position: absolute;
  left: 7px;
  top: 2px;
  font-size: 24px;
  cursor: pointer;
}
span.plus {
    position: absolute;
    right: 7px;
    top: 2px;
    font-size: 24px;
    cursor: pointer;
}
.pulse {
  animation: pulse-animation 2s infinite;
}

@keyframes pulse-animation {
  0% {
    box-shadow: 0 0 0 0px rgba(0, 0, 0, 0.2);
  }
  100% {
    box-shadow: 0 0 0 20px rgba(0, 0, 0, 0);
  }
}
.clone-image {
    max-width: 100%;
    margin: auto;
    text-align: center;
    margin-top: 16px;
}
button#addToCart {
    background: #000;
    color: white;
    height: 48px;
    border: none;
    cursor: pointer;
}
.shake {

    -webkit-animation-name:              shake;    
    -webkit-animation-duration:          1.5s;
    -webkit-animation-iteration-count:   infinite;
    -webkit-animation-timing-function:   linear;
    -webkit-transform-origin:            50% 100%;
 
}
@-webkit-keyframes shake {
  0% { -webkit-transform: translate(2px, 1px) rotate(0deg); }
	10% { -webkit-transform: translate(-1px, -2px) rotate(-1deg); }
	20% { -webkit-transform: translate(-3px, 0px) rotate(1deg); }
	30% { -webkit-transform: translate(0px, 2px) rotate(0deg); }
	40% { -webkit-transform: translate(1px, -1px) rotate(1deg); }
	50% { -webkit-transform: translate(-1px, 2px) rotate(-1deg); }
	60% { -webkit-transform: translate(-3px, 1px) rotate(0deg); }
	70% { -webkit-transform: translate(2px, 1px) rotate(-1deg); }
	80% { -webkit-transform: translate(-1px, -1px) rotate(1deg); }
	90% { -webkit-transform: translate(2px, 2px) rotate(0deg); }
	100% { -webkit-transform: translate(1px, -2px) rotate(-1deg);}
 }
     `;
    var span = document.createElement('style');
    span.innerHTML = css_style;
    my_style = document.getElementById("clone-app-section");

    document.getElementById("clone-app-section").innerHTML = formHtml;
    my_style.parentNode.insertBefore(span, my_style);

    var form = document.getElementById("addToCartForm");


    document.getElementById("addToCart").addEventListener("click", function() {
        if (FB_PIXEL_ID != "") {
            fbq('init', FB_PIXEL_ID);
            fbq('track', 'ADD-TO-CART');
        }

        if (SNAPCHAT_PIXEL_ID != "") {
            snaptr('init', SNAPCHAT_PIXEL_ID);
            snaptr('track', 'ADD-TO-CART');
        }
        if (GOOGLE_PIXEL_ID != "") {
            ga('create', GOOGLE_PIXEL_ID, 'auto');
            ga('send', 'ADD-TO-CART');
        }

        APP_URL = "https://second-button.app.prod.fuznet.com/tracking-click?store=" + shopdomain;

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            let responseObj = xhttp.response;
            console.log("submitted");
            form.submit();
        }
        xhttp.open("GET", APP_URL);
        xhttp.send();



    });

}

function shake() {

    var element = document.getElementById("addToCart");
    element.classList.toggle("shake");
}




function plusFunction() {
    var qty = parseInt(document.getElementById("quantity").value);
    qty = qty + 1;
    document.getElementById("quantity").value = qty;

}

function minusFunction() {
    var qty = parseInt(document.getElementById("quantity").value);
    qty = qty - 1;
    document.getElementById("quantity").value = qty;

}