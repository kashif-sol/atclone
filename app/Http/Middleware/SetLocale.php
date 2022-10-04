<?php

namespace App\Http\Middleware;

use App\Helpers\ShopifyApi;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\User;
use App;
use Session;
use Propaganistas\LaravelIntl\Facades\Language;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Session::has('locale')) {
            if(
                $this->getDefaultLanguage() == "EN" &&
                $this->getDefaultLanguage() != "FR" &&
                $this->getDefaultLanguage() != "IT" &&
                $this->getDefaultLanguage() != "JP" &&
                $this->getDefaultLanguage() != "ES" &&
                $this->getDefaultLanguage() != "DE"

            ){
                Session::put('locale', 'en');
            }else{
                Session::put('locale', $this->getDefaultLanguage());
            }
        }
        App::setLocale(Session::get('locale'));
        return $next($request);
    }
    /**
     * get Countries of shop
     * @param  object $shop
     * @return object|false
     */
    public function getCountrieCode()
    {
        $shop=Auth::user();
        try {
            $result = $shop->api()->request('GET', '/admin/api/2019-04/shop.json');
            return $result->body->shop;
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            return false;
        }

    }
    public function getDefaultLanguage() {
        if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]))
            return $this->parseDefaultLanguage($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
        else
            return $this->parseDefaultLanguage(NULL);
    }

    public function parseDefaultLanguage($http_accept, $deflang = "en") {
        if(isset($http_accept) && strlen($http_accept) > 1)  {
            # Split possible languages into array
            $x = explode(",",$http_accept);
            foreach ($x as $val) {
                #check for q-value and create associative array. No q-value means 1 by rule
                if(preg_match("/(.*);q=([0-1]{0,1}.\d{0,4})/i",$val,$matches))
                    $lang[$matches[1]] = (float)$matches[2];
                else
                    $lang[$val] = 1.0;
            }

            #return default language (highest q-value)
            $qval = 0.0;
            foreach ($lang as $key => $value) {
                if ($value > $qval) {
                    $qval = (float)$value;
                    $deflang = $key;
                }
            }
        }
        return strtoupper(mb_substr($deflang, 0, 2));
    }
}
