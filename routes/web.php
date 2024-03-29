<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SubCategoryController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::controller(HomeController::class)->group(function (){
    Route::get('/','Index')->name('Home');
});

Route::controller(ClientController::class)->group(function (){
    Route::get('/category/{id}/{slug}','CategoryPage')->name('category');
    Route::get('/product-details/{id}/{slug}','SingleProduct')->name('singleproduct');
    Route::get('/new-release','NewRelease')->name('newrelease');
});

//route for otp verify start
Route::get('/verify', function () {
    return view('auth.verifyotp');
})->name('verifyotp');


// Route::post('/verify', [AuthController::class, 'verify'])->name('verifyotp');
////route for otp verify end

Route::middleware(['auth','role:user','verified','isVerified'])->group(function(){
    Route::controller(ClientController::class)->group(function (){
    Route::get('/add-to-cart','AddToCart')->name('addtocart');
    Route::post('/add-product-to-cart','AddProductToCart')->name('addproducttocart');
    Route::get('/shipping-address','GetShippingAddress')->name('shippingaddress');
    Route::post('/add-shipping-address','AddShippingAddress')->name('addshippingaddress');
    Route::post('/place-order','PlaceOrder')->name('placeorder');
    Route::get('/checkout','Checkout')->name('checkout');
    Route::get('/user-profile','UserProfile')->name('userprofile');
    Route::get('/user-profile/pending-orders','PendingOrders')->name('pendingorders');
    Route::get('/user-profile/history','History')->name('history');
    Route::get('/todays-deal','TodaysDeal')->name('todaysdeal');
    Route::get('/custom-service','CustomerService')->name('customerservice');
    Route::get('/remove-cart-item/{id}','RemoveCartItem')->name('removeitem');
    //wallet route
    Route::get('/wallet', [WalletController::class, 'show'])->name('wallet');
    Route::post('/wallet/topup', [WalletController::class, 'topup'])->name('topup');
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth','verified', 'role:user'])->name('dashboard');


Route::middleware('auth','role:admin')->group(function () {
    Route::controller(DashboardController::class)->group(function(){
        Route::get('/admin/dashboard', 'Index')->name('admindashboard');
        
    });

    Route::controller(CategoryController::class)->group(function(){
        Route::get('/admin/all-category', 'Index')->name('allcategory');
        Route::get('/admin/add-category', 'AddCategory')->name('addcategory');
        Route::post('/admin/store-category','StoreCategory')->name('storecategory');
        Route::get('/admin/edit-category/{id}','EditCategory')->name('editcategory');
        Route::post('/admin/update-category','UpdateCategory')->name('updatecategory');
        Route::get('/admin/delete-category/{id}','DeleteCategory')->name('deletecategory');
    });

    Route::controller(SubCategoryController::class)->group(function(){
        Route::get('/admin/all-subcategory', 'Index')->name('allsubcategory');
        Route::get('/admin/add-subcategory', 'AddsubCategory')->name('addsubcategory');
        Route::post('/admin/store-subcategory','StoreSubCategory')->name('storesubcategory');
        Route::get('/admin/edit-subcategory/{id}','EditSubCat')->name('editsubcat');
        Route::get('/admin/delete-subcategory/{id}','DeleteSubCat')->name('deletesubcat');
        Route::post('/admin/update-subcategory','UpdateSubCat')->name('updatesubcat');
    });

    Route::controller(ProductController::class)->group(function(){
        Route::get('/admin/all-products', 'Index')->name('allproducts');
        Route::get('/admin/add-product', 'AddProduct')->name('addproduct');
        Route::post('/admin/store-product','StoreProduct')->name('storeproduct');
        Route::post('/admin/update-product-details','UpdateProductDetails')->name('updateproductdetails');
        Route::get('/admin/edit-product-img/{id}','EditProductImg')->name('editproductimg');
        Route::post('/admin/update-product-img','UpdateProductImage')->name('updateproductimg');
        Route::get('/admin/edit-product/{id}','EditProduct')->name('editproduct');
        Route::get('/admin/delete-product/{id}','DeleteProduct')->name('deleteproduct');
    });

    Route::controller(OrderController::class)->group(function(){
        Route::get('/admin/pending-order', 'Index')->name('pendingorder');
    });
    
});

require __DIR__.'/auth.php';
