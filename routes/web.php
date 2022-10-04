<?php
header("Access-Control-Allow-Origin: *");
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    if (Auth::user()) {
        return redirect()->route('home');
    }
    return view('login');
})->name('login');

/*Route::middleware(['auth.shopify', 'billable'])->group(function () {
    Route::get('/','ThemeController@index')->name('home');
    Route::post('/submit','ThemeController@submit')->name('app.submit');
    Route::post('/switchLang', 'ThemeController@switchLang')->name('app.switchLang');
    // Other routes that need the shop user
});*/
//Route::get( '/', 'ThemeController@index' ) ->middleware(['auth.shopify', 'billable'])->name('home');
//Route::get( '/submit', 'ThemeController@submit' ) ->middleware(['auth.shopify', 'billable'])->name('app.submit');
//Route::get( '/switchLang', 'ThemeController@switchLang' ) ->middleware(['auth.shopify', 'billable'])->name('app.switchLang');

Route::middleware(['auth.shopify','billable'])->group(function(){
    Route::get( '/', 'ThemeController@index' )->name('home');
    Route::post('/submit','ThemeController@submit')->name('app.submit');
    Route::get('/remove-image','ThemeController@removeImage')->name('app.remove-image');
    Route::post( '/switchLang', 'ThemeController@switchLang' )->name('app.switchLang');
    Route::post('/pixels','ThemeController@save_pixels')->name('app.pixels');
});
Route::get('/plans','ThemeController@plans')->name('plans')->middleware('auth.shopify');
//Route::post('/submit','ThemeController@submit')->name('app.submit'); //update
//Route::post('/switchLang', 'ThemeController@switchLang')->name('app.switchLang');
Route::get('/tracking-click','ThemeController@trackClick')->name('app.tracking');
Route::post('/shops/redact','ThemeController@storeRedact');
Route::get('/api/checkValid','CheckValidController@index');
Route::post('/webhook/app-uninstalled','ThemeController@AppUninstall')->name('app-uninstall')->middleware('auth.webhook');
//Route::post('/webhook/themes-publish','ThemeController@PublicTheme')->middleware('auth.webhook')->name('public-theme');
//Route::post('/webhook/public-theme','PublicThemeController')->middleware('auth.webhook');
Route::get('/api/get-settings','ThemeController@get_settings');

Route::get('/install-request','ThemeController@installrequest');
Route::get('/widget-added','ThemeController@widget_added');

Route::get('/clear-cache', function() {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
});
