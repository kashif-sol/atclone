<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AddButtonCartService
{
    public function published($shop)
    {
        $this->execute($shop);
        $this->updateJsUninstall($shop);
        if ($shop->active) {
            $this->updateSnippetButton(false, $shop);
        } else {
            $this->updateSnippetButton(true, $shop);
        }

        return true;
    }

    public function execute($shop = false)
    {
        if (!$shop) {
            $shop = \App\User::find(Auth::id());
        }
        $template = $this->getProductTemplateLiquid($shop);
        if (!$template) {
            return false;
        }

        $value = $template->value;


        if($shop->skip_cart){
            $value = str_replace("</form>", "<input type=\"hidden\" name=\"return_to\" value=\"/checkout\" /></form>", $value);
        }else{
            $value = str_replace("<input type=\"hidden\" name=\"return_to\" value=\"/checkout\" />", "", $value);
        }

        if (strpos($value, "{% include 'second-button-cart' %}") === false) {
            $value = str_replace("{{ product.description }}", "{{ product.description }}{% include 'second-button-cart' %}", $value);
        }


        $init = $this->initRequest($template, $value, $shop);

        return $init;
    }

    public function remove($shop)
    {
        $template = $this->getProductTemplateLiquid($shop);
        if (!$template) {
            return false;
        }

        $value = $template->value;
        $html = $this->_htmlReplace();
        $value = str_replace("{% include 'second-button-cart' %}", "", $value);

        $init = $this->initRequest($template, $value);
        if (!$init) {
            return false;
        }

        $shop = \App\User::find(Auth::id());
        $shop->install_app = 0;
        $shop->save();

        return $shop;
    }

    /**
     * init request
     * @param  string $template
     * @param  string $value
     * @param  object $shop
     * @return object|false
     */
    protected function initRequest($template, $value, $shop)
    {
        $themeId = $template->theme_id;
        $key = $template->key;
        $data = [
            'asset' => [
                'key' => $key,
                'value' => $value
            ]
        ];
        $url = '/admin/themes/'.$themeId.'/assets.json';
        $result = $shop->api()->request('PUT', $url, $data);


        if (!$result['body']) {
            return false;
        }

        return $result['body'];
    }
    /**
     * get themes
     * @param  object $shop
     * @return object|false
     */
    public function updateSnippetButton($empty = false, $shop = false)
    {
        if (!$shop) {
            $shop = \App\User::find(Auth::id());
        }

        $mainTheme = $this->getMainTheme($shop);

        if (!$mainTheme) {
            return false;
        }

        $value = '';
        if (!$empty) {
            $value = $this->_htmlReplace($shop);
            \Log::debug($value);
        }

        $data = [
            'asset' => [
                'key' => 'snippets/second-button-cart.liquid',
                'value' => $value
            ]
        ];

        $url = '/admin/themes/'.$mainTheme->id.'/assets.json';
        $result = $shop->api()->request('PUT', $url, $data);

        return $result['body'] ? $result['body']['asset'] : false;
    }

    /**
     * update js file to theme
     * @param  boolean $shop
     * @return object|false
     */
    public function updateJsUninstall($shop = false)
    {
        if (!$shop) {
            $shop = \App\User::find(Auth::id());
        }
        $mainTheme = $this->getMainTheme($shop);

        $value = $shop->api()->rest('GET', '/admin/themes/'. $mainTheme->id  .'/assets.json', ['asset' => ['key' => 'layout/theme.liquid']]);
        $value = $value['body']['asset']['value'];
        $jsLink  = '<script type="text/javascript" src="' . config('app.url'). '/clone-js.js"></script>';
        $jsCheckLink  = '{% if template contains \'product\' %}<script type="text/javascript" src="' .  config('app.url').'/clone-js.js"></script>{% endif %}';
        $url = '/admin/themes/' . $mainTheme->id . '/assets.json';

        if (strpos($value, $jsLink) === false) {
            $value = str_replace('</body>', $jsCheckLink . '</body>', $value);
        }

        if (strpos($value, $jsCheckLink) === false) {
            $value = str_replace('</body>', $jsCheckLink . '</body>', $value);
        }

        $data = [
            'asset' => [
                'key' => 'layout/theme.liquid',
                'value' => $value
            ]
        ];

        $result = $shop->api()->request('PUT', $url, $data);

        return $result;
    }

    /**
     * get product-template.liquid of main theme
     * @param  object $shop
     * @return object|false
     */
    protected function getProductTemplateLiquid($shop)
    {
        $mainTheme = $this->getMainTheme($shop);

        if (!$mainTheme) {
            return false;
        }
        try {
            $result = $shop->api()->rest('GET', '/admin/themes/'. $mainTheme->id  .'/assets.json', ['asset' => ['key' => $shop->template_product]]);
            return $result['body'] ? $result['body']['asset'] : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * get main theme of shop
     * @param  object $shop
     * @return object|false
     */
    public function getMainTheme($shop)
    {
        $themes = $this->getTheme($shop);
        foreach ($themes as $theme) {
            if ($theme->role === "main") {
                return $theme;
            }
        }

        return false;
    }

    /**
     * get themes of shop
     * @param  object $shop
     * @return object|false
     */
    protected function getTheme($shop)
    {
        try {
            $result = $shop->api()->request('GET', '/admin/themes.json');
            return $result['body']['themes'];
        } catch (\Exception $e) {
            return false;
        }

    }

    /**
     * template second-button-cart.liquid
     * @param  object $shop
     * @return string
     */
    protected function _htmlReplace($shop)
    {
        $scriptHTml= "<script src='https://second-button.app.prod.fuznet.com/clone-js.js'></script>";
        return $scriptHTml;
        $images = $shop->images ? '<img src="'. asset($shop->images) .'">' : '';
        $skipCart = '';
        $widthButton = 'style="width:auto;"';
        $showVariant = '';
        $showQty = '';
        if($shop->skip_cart){
            $skipCart = '<input type="hidden" name="return_to" value="/checkout" />';
        }
        if($shop->width_button){
            $widthButton = 'style="width:'.$shop->width_button.';"';
        }
        if (str_replace(" ","",$shop->width_button) == "100%"){
            $widthButton = 'style="width:'.$shop->width_button.'; margin-top:10px;"';
        }

        if ($shop->width_button == 0){
            $widthButton = 'style="width:auto"';
        }
        if(!$shop->status_variant){
            $showVariant= 'style="display:none;"';
        }

        if(!$shop->status_qty){
            $showQty = 'style="display:none;"';
        }

        $checkoutX = '';
        if($shop->checkoutx){
            $checkoutX = "checkout-x-buy-now-btn";
        }
        $formHtml = '<form action="/cart/add" method="post" id="addToCartForm">'.$skipCart.'
            <div class="form-gr '.$shop->shopify_domain.'">
                {% if product.variants.size == 1 %}
                <input name="id" value="{{ product.variants.first.id }}" type="hidden" />
                {% else %}
                <select  name="id" id="productSelect-{{ section.id }}" class="product-variants product-variants-{{ section.id }} form-ctl" '.$showVariant.'>
                 {% for variant in product.variants %}
                 {% if variant.available %}
                 <option {% if variant == product.selected_or_first_available_variant %} selected="selected" {% endif %} data-sku="{{ variant.sku }}" value="{{ variant.id }}">{{ variant.title }} - {{ variant.price | money_with_currency }}</option>
                 {% else %}
                 <option disabled="disabled">
                 {{ variant.title }} - {{ \'products.product.sold_out\' | t }}
                 </option>
                 {% endif %}
                 {% endfor %}
                 </select>
                 {% endif %}
            </div>
            <div class="form-gr">
                <label for="quantity" class="quantity-selector quantity-selector-{{ section.id }}" '.$showQty.'>{{ \'products.product.quantity\' | t }}</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1" class="quantity-selector" '.$showQty.'>
                <button type="submit" name="add" id="addToCart" class="btn add-cart-secondary '.$checkoutX.'" '.$widthButton.'>
                    <span id="AddToCartText-{{ section.id }}">'. $shop->button_label .'</span>
                 </button>
                 <p>'.$images.'</p>
         </div>
         </form>';
        if($shop->shopify_domain == 'like-luke.myshopify.com'){
            $formHtml = '<form action="/cart/add" method="post" id="addToCartForm">'.$skipCart.'
            <div class="form-gr">
                {% if product.variants.size == 1 %}
                <input name="id" value="{{ product.variants.first.id }}" type="hidden" />
                {% else %}
                {% for variant in product.variants %}
                     {% if variant.available %}
                        <p id="price-{{ variant.id }}" class="price-second {% if variant == product.selected_or_first_available_variant %} show {% else %} hide {% endif %}">{{ variant.title }} - {{ variant.price | money_with_currency }}</p>
                     {% endif %}
                 {% endfor %}
                <select  name="id" id="productSelect-{{ section.id }}" class="product-variants product-variants-{{ section.id }} form-ctl" '.$showVariant.' onchange="showHideLabel()">
                 {% for variant in product.variants %}
                 {% if variant.available %}
                 <option {% if variant == product.selected_or_first_available_variant %} selected="selected" {% endif %} data-sku="{{ variant.sku }}" value="{{ variant.id }}">{{ variant.title }}</option>
                 {% else %}
                 <option disabled="disabled">
                 {{ variant.title }} - {{ \'products.product.sold_out\' | t }}
                 </option>
                 {% endif %}
                 {% endfor %}
                 </select>
                 {% endif %}
            </div>
            <div class="form-gr">
                <label for="quantity" class="quantity-selector quantity-selector-{{ section.id }}" '.$showQty.'>{{ \'products.product.quantity\' | t }}</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1" class="quantity-selector" '.$showQty.'>
                <button type="submit" name="add" id="addToCart" class="btn add-cart-secondary '.$checkoutX.'" '.$widthButton.'>
                    <span id="AddToCartText-{{ section.id }}">'. $shop->button_label .'</span>
                 </button>
                 <p>'.$images.'</p>
         </div>
         </form>
         <script>
            function showHideLabel(){
                var y = document.getElementById("price-"+document.getElementById("productSelect-{{ section.id }}").value);
                var z = document.getElementsByClassName("price-second");
                var i;
                for (i = 0; i < z.length; i++) {
                    z[i].style.cssText = "display:none !important";
                }
                y.style.cssText = "display:block !important";
            }
        </script>
         ';
        }


        $scriptHTml= '<script>
  var productSelect = document.getElementById("productSelect-product-template");
    if (typeof productSelect !== "undefined" && productSelect)  {
            if (typeof productSelect.options !== "undefined" && productSelect.options) {
                var option = productSelect.options;
                if (option.length > 1) {
                  for (i = 0; i < option.length; i++) {
                      var text = option[i].text;
                      text = text.replace("Default Title", "Prix");
                      option[i].text = text;
                  }
                }
            }
        }
</script>';

        $html = '<div class="add-second-button" style="display: none;">
         <style>
             .add-second-button .product-variants {
                margin-top:15px;
             }
            .add-second-button .form-gr input, .add-second-button .js-qty, .ajaxcart__qty {
                max-width:100px;
                min-width: 75px;
                display: inline-block;
                margin-right: 7px;
                min-height: 45px;
                height: auto;
            }
            .add-second-button .form-gr {
                width: 100%;
                margin-bottom: 10px;
            }
            .add-second-button .form-gr button, .add-second-button .form-gr select {
                display:inline-block;
                min-height: 45px;
                height: auto;
              
           }
           .add-second-button .form-gr button {
            margin-top:-4px;
           }
       
            .add-second-button .form-gr label {
                width: 100%;
                margin-bottom: 5px;
                display: block;
            }
            .add-second-button .form-gr img {
                max-width: 100%;
                margin-top:5px;
            }
            .show{ display: block;}
            .hide{ display: none;}
    .add-second-button .form-gr .form-gr-half {
        display: inline-block;
    }
    </style>'.$formHtml.$scriptHTml.'</div>';

        return $html;
    }
}
