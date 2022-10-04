// function checkValidProd(){var t=new XMLHttpRequest;t.onreadystatechange=function(){console.log(this.readyState),console.log(this.status),console.log(this.responseText);var t=document.getElementsByClassName("shopify-payment-button");if(4==this.readyState&&200==this.status){if(JSON.parse(this.responseText).status)return t.length>0&&(t[0].style.cssText="display:none !important"),!0;t.length>0&&(t[0].style.cssText="display:inline-block !important")}},t.open("GET","https://coverup.app.prod.fuznet.com/api/checkValid?shop="+Shopify.shop,!0),t.send()}checkValidProd();
// if(window.location.pathname.includes("cart") || window.location.pathname.includes("product")){
//     checkValid();
//     console.log('check');
// }
//
// function checkValid() {
//     var xhttp                = new XMLHttpRequest();
//     xhttp.onreadystatechange = function () {
//         var element = document.getElementsByClassName('shopify-payment-button');
//         if (this.readyState == 4 && this.status == 200 && element.length > 0) {
//             var data = JSON.parse(this.responseText);
//             // console.log(data, 'data');
//             if (data.status) {
//                 element[0].setAttribute("style", "display:none !important;");
//                 return true;
//             }
//             // exists.
//             element[0].setAttribute("style", "display:block !important;");
//         }
//     };
//     xhttp.open("GET", "https://coverup.app.prod.fuznet.com/api/checkValid?shop=" + Shopify.shop, true);
//     xhttp.send();
// }
//
