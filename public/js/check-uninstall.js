function checkValid() {
    var t = new XMLHttpRequest;
    t.onreadystatechange = function () {
        var t = document.getElementsByClassName("add-second-button");
        if (4 == this.readyState && 200 == this.status) {
            if (JSON.parse(this.responseText).status)return t[0].setAttribute("style", "display:block"), !0;
            t.length > 0 && (t[0].innerHTML = "")
        }
    }, t.open("GET", "https://second-button.app.prod.fuznet.com/api/checkValid?shop=" + Shopify.shop, !0), t.send()
}
if(window.location.pathname.includes("product")){
    checkValid();
    console.log('check');
}
document.getElementById("addToCart").addEventListener("touchstart", click);
document.getElementById("addToCart").addEventListener("click", click);
function click(){
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", 'https://second-button.app.prod.fuznet.com/tracking-click?store='+Shopify.shop, true);
    xhttp.send();
}