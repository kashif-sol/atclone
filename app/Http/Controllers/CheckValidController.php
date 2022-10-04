<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class CheckValidController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 1
        ], 200, [
            'Access-Control-Allow-Origin'  => '*',
            'Access-Control-Allow-Methods' => 'GET'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function uninstall(Request $request)
    {
        Log::debug($request);
        $shopModel = config('shopify-app.shop_model');
        $shopModel::firstOrCreate(['shopify_domain' => $request->server('HTTP_X_SHOPIFY_SHOP_DOMAIN')])->delete();
        return true;
    }
}
