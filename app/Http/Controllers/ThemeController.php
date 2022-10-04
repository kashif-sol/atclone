<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AddButtonCartService;
use Illuminate\Support\Facades\Storage;
use Osiset\ShopifyApp\Objects\Values\ShopDomain;
use Session;
use App;
use Validator;
use Input;
use Illuminate\Support\Facades\Log;
use Osiset\ShopifyApp\Services\ChargeHelper;
use Carbon\Carbon;
use App\Models\Tracking;
use Illuminate\Support\Facades\Mail;
use App\Mail\InstallEmail;
use Illuminate\Support\Facades\DB;
use App\Pixels;

class ThemeController extends Controller
{
    protected $_addButtonCartService;
    public function __construct(
        AddButtonCartService $_addButtonCartService
    ) {
        $this->_addButtonCartService = $_addButtonCartService;
    }


    public function save_pixels(Request $request)
    {
       
        $shop = User::where("name", $request->shop)->first();
        $shop_id = $shop->id;
        $Pixels = Pixels::where("shop_id" , $shop_id)->first();
        if(empty($Pixels))
            $Pixels = new Pixels();
        $Pixels->fb_id = $request->fb_pxl_id;
        $Pixels->google_id = $request->google_pxl_id;
        $Pixels->snapchat_id = $request->snapchat_pxl_id;
        $Pixels->shop_id = $shop_id;
        $Pixels->save();
        return redirect()->route('home')->with('alert-success', 'Saved changes!');
    }

    public function installrequest(Request $request)
    {
        $shop = User::where("name", $request->shop)->first();
        $shop_url = $shop->name;
        $shopApi = $shop->api()->rest('GET', '/admin/shop.json')['body']['shop']; 
        $shop_email = $shopApi->email;
        $to_email = "contact@fuznet.com";
        $data = array(
            'shop_name' => $shop_url,
            'shop_email' => $shop_email
        );
        Mail::to($to_email)->send(new InstallEmail($data));
        if(Mail::failures() != 0) {
            return "<p>We have received your request and will act quickly. Watch your emails because you will soon receive an invitation request to access your store.</p>";
        }
        else {
            return "<p> Failed! Your E-mail has not sent.</p>";
        }
        return response()->json(
            [
            'success' => true,
            'message' => 'Message has been sent successfully'


            ]
        );
    }

    public function widget_added(Request $request)
    {
        $shop = User::where("name", $request->shop)->first();
        $shop->widget_status = 1;
        $shop->save();
        return response()->json(
            [
            'success' => true,
            'message' => 'Message has been sent successfully'


            ]
            );
    }

    public function plans()
    {
        $plans['plans'] = DB::table('plans')->get();
        return view('plan', $plans);
    }

    function get_settings(Request $request)
    {
        $settings = [];
        $fb_id = "";
        $google_pxl_id = "";
        $snapchat_pxl_id = "";
        $shop = User::where("name", $request->shop)->first();
        $Pixels = Pixels::where("shop_id" , $shop->id)->first();
        if(isset($Pixels) && !empty($Pixels))
        {
            $fb_id = $Pixels->fb_id;
            $google_pxl_id = $Pixels->google_pxl_id;
            $snapchat_pxl_id = $Pixels->snapchat_pxl_id;
        }
        if(!empty($shop))
        {
            $settings["active"] = $shop->active;
            $settings["button_label"] = $shop->button_label;
            $settings["status_qty"] = $shop->status_qty;
            $settings["width_button"] = $shop->width_button;
            $settings["status_variant"] = $shop->status_variant;
            $settings["skip_cart"] = $shop->skip_cart;
            $settings["checkoutx"] = $shop->checkoutx;
            $settings["fb_id"] = $fb_id ;
            $settings["google_pxl_id"] = $google_pxl_id;
            $settings["snapchat_pxl_id"] =  $snapchat_pxl_id;
            $settings["animation"] = $shop->animation;
            if(isset($shop->images) && !empty($shop->images))
                $settings["image"] = "https://second-button.app.prod.fuznet.com/" . $shop->images;
            else
             $settings["image"] = "";
            $settings["cart_background"] = $shop->cart_background;
        }

        return $settings;
    }
    public function index()
    {
        $shop = Auth::user();
        $charge = $shop->charges();
        if(is_null($charge->first())){
            return redirect('/billing/');
        }
        $pixels = Pixels::where("shop_id" , $shop->id)->first();
        
        return view('themes.index', compact('shop' , 'pixels'));
    }

    public function install(Request $request)
    {
        $data = $request->all();
    	dd($data);
        $redirectUrl = $this->_addButtonCartService->getInstallUrl($data['shop_url']);

        return redirect($redirectUrl);

    }

    public function removeImage()
    {
        $shop = \App\User::find(Auth::id());
        $shop->images =  '';
        $shop->save();

        return redirect()->route('home')->with('alert-success', 'Removed image!');
    }

    public function submit(Request $request)
    {
        
        try {
            $shop = \App\User::find(Auth::id());
            $animation = 0;
           /// $shop = User::where("name", $request->shop)->first();
            $shop->button_label = $request->button_label;
            if($request->active){
                $shop->active  = $request->active;
            }else{
                $shop->active  = 0;
            }
            if($request->status_qty){
                $statusQty = $request->status_qty;
            }else{
                $statusQty = 0;
            }
            if($request->status_variant){
                $statusVariant = $request->status_variant;
            }else{
                $statusVariant = 0;
            }
            if($request->skip_cart){
                $statusCart = $request->skip_cart;
            }else{
                $statusCart = 0;
            }
            if($request->width_button){
                $widthButton = $request->width_button;
            }else{
                $widthButton = 0;
            }
            if($request->checkoutx){
                $checkoutx = $request->checkoutx;
            }else{
                $checkoutx = 0;
            }

            if($request->cart_background){
                $cart_bg = $request->cart_background;
            }else{
                $cart_bg = "#000000";
            }
            if($request->animation){
                $animation = $request->animation;
            }else{
                $animation = 0;
            }
            
            $shop->status_qty = $statusQty;
            $shop->width_button = $widthButton;
            $shop->status_variant = $statusVariant;
            $shop->checkoutx = $checkoutx;
            $shop->skip_cart = $statusCart;
            $shop->cart_background = $cart_bg;
            $shop->animation = $animation;
            $shop->template_product = "NEW";

            if ($request->hasFile('images')) {
                $images = $request->images;
                $dataValidate = [
                    'images' => 'image|mimes:jpeg,png,jpg,gif,svg',
                ];
                $validator = Validator::make(['images' => $images], $dataValidate);
                if ($validator->fails()) {
                    return redirect()->back()->with('alert-error', 'Image only allows file types of jpeg, png, jpg, gif and svg!');
                }
                $path = 'public/upload/' . $shop->name . '/';
                \Storage::makeDirectory($path);
                $filename =  time() . '_' . $images->getClientOriginalName();
                $images->move($path, $filename);

                $shop->images =  $path . $filename;
                // dd($images->getClientOriginalName());
            }
            $shop->widget_status = $shop->widget_status;
            $shop->save();
            /*
            $execute = $this->_addButtonCartService->execute();
            if (!$execute) {
                return redirect()->back()
                    ->with('alert-error', 'Template does not exist!')
                    ->with('link-error', '<a target="_blank" href="https://help.fuznet.com/en/article/template-does-not-exist-error-what-to-do-19vclqd/">Follow this guide.</a>');
            }
            */
            if (!$request->active) {
                $result = $this->_addButtonCartService->updateSnippetButton(true);
                return redirect()->route('home')->with('alert-success', 'Saved changes!');
            }

            $result = $this->_addButtonCartService->updateSnippetButton();
            $result = $this->_addButtonCartService->updateJsUninstall();

            return redirect()->route('home')->with('alert-success', 'Saved changes!');
        } catch (\Exception $e) {
            return redirect()->back()->with('alert-error', $e->getMessage());
        }

    }
    public function trackClick(Request $request)
    {
        try {
            $date = Carbon::now()->format('Y-m-d');
            $tracking = Tracking::where('shopify_domain', $request->input('store'))->whereDate('date_click', Carbon::now()->format('Y-m-d'))->first();
            if(is_null($tracking)){
                $tracking = new Tracking();
                $tracking->shopify_domain = $request->input('store');
                $tracking->clicks = 1;
                $tracking->date_click = $date;
                $tracking->save();
            }else{
                $tracking->clicks = $tracking->clicks + 1;
                $tracking->save();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('alert-error', $e->getMessage());
        }
    }

    public function submitClick(Request $request)
    {
        try {
            $shop = \App\User::find(Auth::id());
            if ($request->click) {
                $shop->click = $request->click;
            }
            $shop->save();
            return 'ok';
        } catch (\Exception $e) {
            return 'error';
        }
    }
    public function storeRedact(Request $request)
    {
        try {
            $data=$request->all();
            Log::info('storeRedact: '.$data['shop_domain']);
            User::where('name',$data['shop_domain'])->delete();
        }catch (\Exception $e)
        {
            Log::info(print_r($e->getMessage(),1));

        }
        return true;
    }

    public function AppUninstall(Request $request)
    {
        User::where('name',$request['shop_domain'])->delete();
    }

    public function PublicTheme(Request $request)
    {
        try {
            $shop = Shop::where(['name' => $request['shop_domain']])->first();
            Log::info('shopDomain: '.$request['shop_domain']);
            // Convert domain
            if (!$shop) {
                return false;
            }
            $themes = $shop->api()->rest('GET', '/admin/themes.json');
            $theme = $this->_addButtonCartService->getMainTheme($themes);
            $this->_addButtonCartService->createSnippet($shop, $theme, 'hide-paypal-button-cart', 'check');
            $this->_addButtonCartService->createSnippet($shop, $theme, 'hide-paypal-button-prod', 'check-prod');
            $this->_addButtonCartService->updateThemeLiquidCode($shop->status_flag, $shop->active, $shop, $theme);
        }catch (\Exception $e)
        {
            Log::info(print_r($e->getMessage(),1));
            return true;
        }
        return true;
    }
}
