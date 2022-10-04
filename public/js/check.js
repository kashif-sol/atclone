// function checkValid() {
//     var t = new XMLHttpRequest;
//     t.onreadystatechange = function () {
//         var t = document.getElementsByClassName("additional-checkout-button--paypal");
//         if (4 == this.readyState && 200 == this.status) {
//             if (JSON.parse(this.responseText).status)return t.length > 0 && (t[0].style.cssText = "display:none !important"), !0;
//             t.length > 0 && (t[0].style.cssText = "display:inline-block !important")
//         }
//     }, t.open("GET", "https://coverup.app.prod.fuznet.com/api/checkValid?shop=" + Shopify.shop, !0), t.send()
// }
// checkValid();