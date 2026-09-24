<?php

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
Route::group(['prefix' => LaravelLocalization::setLocale(),
'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ],['TrackPageActivity']],
function(){
Route::group(['prefix' => 'dashboard','as' => 'dashboard.'],
function(){

    Route::group(['namespace' => 'Auth'], function () {
        // Authentication Routes...
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register')->name('register');
        Route::post('login', 'LoginController@login')->name('login');
        Route::post('logout', 'LoginController@logout')->name('logout');
    });

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', 'DashboardController@index')->name('index');
        // admins routes
        Route::get('/admins/{admin}/permissions', 'AdminController@editPermissions')->name('admins.permissions.edit');
        Route::post('/admins/{admin}/permissions', 'AdminController@updatePermissions')->name('admins.permissions.update');
        Route::resource('admins', 'AdminController');
        // routes settings
        Route::resource('settings', 'SettingController')->only(['index','update']);
        //routes suppliers
        Route::resource('suppliers', 'SupplierController')->except(['show']);
        //routes purchases
        Route::resource('purchases', 'PurchaseController');
        Route::get('/report-purchases','PurchaseReportController@index')->name('report-purchases');
        Route::get('/export-purchases','PurchaseController@exportPurchases')->name('export-purchases');
        Route::post('/purchases/{purchase}/active','PurchaseController@active')->name('purchases.active');
        Route::get('/export-invoice-purchase/{id}','PurchaseController@exportInvoicePurchase')->name('export-invoice-purchase');
        //routes users
        Route::resource('clients', 'ClientController');   //->only(['index','show'])
        // routes orders
        Route::resource('orders', 'OrderController');

        Route::post('/orders/{order}/active','OrderController@active')->name('orders.active');
        Route::get('/export-orders','OrderController@exportOrders')->name('export-orders');
        Route::get('/report-orders','OrderReportController@index')->name('report-orders');
        Route::get('/export-invoice-order/{id}','OrderController@exportInvoiceOrder')->name('export-invoice-order');
        // factory cars routes
        Route::resource('factory-cars', 'FactoryCarController')->except('show');
        Route::post('/import-factoryCars','FactoryCarController@import')->name('import-factoryCars');
        Route::get('/export-factoryCars','FactoryCarController@exportfactoryCars')->name('export-factoryCars');
        // categories routes
        Route::resource('categories', 'CategoryController')->except('show');
        Route::post('/import-categories','CategoryController@import')->name('import-categories');
        Route::get('/export-categories','CategoryController@exportCategories')->name('export-categories');
        Route::post('/cars/ajax', 'CarController@ajaxIndex')->name('cars.ajax');
        // cars routes
        Route::resource('cars', 'CarController')->except('show');
        Route::post('/import-cars','CarController@import')->name('import-cars');
        Route::get('/export-cars','CarController@exportCars')->name('export-cars');
        // brands routes
        Route::resource('brands', 'BrandController')->except('show');
        Route::post('/import-brands','BrandController@import')->name('import-brands');
        Route::get('/export-brands','BrandController@exportBrands')->name('export-brands');
        // products routes
        Route::resource('products', 'ProductController');
        Route::get('/product/{product}/stock', [ProductController::class, 'checkStock'])
        ->name('product.stock');
        Route::post('/import-products','ProductController@import')->name('import-products');
        Route::get('/export-products','ProductController@exportProducts')->name('export-products');

//notifications

        Route::get('/notifications', 'NotificationController@index')->name('notifications.index');
        Route::get('/notifications/{id}/read','NotificationController@markAsRead')->name('notification.read');
        Route::post('/notifications/read-all','NotificationController@readAll')->name('notifications.readAll');
        // Route::post('/notifications/{id}/unread', 'NotificationController@markAsUnread')->name('notifications.unread');
        Route::get('/notifications/latest', function () {
            return response()->json([
                'count' => auth()->user()->unreadNotifications()->count(),
                'notifications' => auth()->user()
                    ->notifications()
                    ->latest()
                    ->limit(10)
                    ->get()
                    ->map(function ($notification) {
                        return [
                            'id' => $notification->id,
                            'title' => $notification->data['title'] ?? 'Notification',
                            'message' => $notification->data['message'] ?? '',
                            'url' => $notification->data['url'] ?? '#',
                            'read' => $notification->read_at !== null,
                            'time' => $notification->created_at->diffForHumans(),
                        ];
                    })
            ]);
        })->name('notifications.latest');

        // Route::post('/notifications/{id}/read', function ($id) {
        // dd($id);
        //     $notification = auth()->user()
        //         ->notifications()
        //         ->where('id', $id)
        //         ->first();

        //     if ($notification) {
        //         $notification->markAsRead();
        //     }

        //     return response()->json([
        //         'success' => true
        //     ]);

        // });

        Route::get('/dashboard/my-history','VisitorHistoryController@history')->name('dashboard.my-history');
        Route::post('/dashboard/visitor/navigation','VisitorHistoryController@navigation')->name('visitor.navigation');
    });

});
});
