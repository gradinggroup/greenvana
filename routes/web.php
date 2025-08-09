<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SocialiteController;

use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\ShippingAreaController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\UsersController;


use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\Frontend\CartController;

use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\CartPageController;
use App\Http\Controllers\User\CheckoutController;


use App\Models\User;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix'=> 'admin', 'middleware'=>['admin:admin']], function(){
	Route::get('/login', [AdminController::class, 'loginForm']);
	Route::post('/login',[AdminController::class, 'store'])->name('admin.login');
});


//all route admin

Route::middleware(['auth:admin'])->group(function(){

    Route::middleware(['auth:sanctum,admin', 'verified'])->get('/admin/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');

    Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');

    Route::get('/admin/profile', [AdminProfileController::class, 'adminProfile'])->name('admin.profile');

    Route::get('/admin/profile/edit', [AdminProfileController::class, 'adminProfileEdit'])->name('admin.profile.edit');

    Route::post('/admin/profile/update', [AdminProfileController::class, 'adminProfileUpdate'])->name('admin.profile.update');

    Route::get('/admin/change/password', [AdminProfileController::class, 'adminChangePassword'])->name('admin.change.password');

    Route::post('/admin/password/update', [AdminProfileController::class, 'adminUpdatePassword'])->name('admin.password.update');

    Route::prefix('admin')->group(function(){

        Route::prefix('brand')->group(function(){

            Route::get('/view', [BrandController::class, 'viewBrand'])->name('all.brand');

            Route::post('/store', [BrandController::class, 'brandStore'])->name('brand.store');

            Route::get('/edit/{id}', [BrandController::class, 'brandEdit'])->name('brand.edit');

            Route::post('/update', [BrandController::class, 'brandUpdate'])->name('brand.update');

            Route::get('/delete/{id}', [BrandController::class, 'brandDelete'])->name('brand.delete');

        });


        Route::prefix('category')->group(function(){

            Route::get('/view', [CategoryController::class, 'viewCategory'])->name('all.category');

            Route::post('/store', [CategoryController::class, 'categoryStore'])->name('category.store');

            Route::get('/edit/{id}', [CategoryController::class, 'categoryEdit'])->name('category.edit');

            Route::post('/update/{id}', [CategoryController::class, 'categoryUpdate'])->name('category.update');

            Route::get('/delete/{id}', [CategoryController::class, 'categoryDelete'])->name('category.delete');

            //sub category admin
            Route::get('/sub/view', [SubCategoryController::class, 'viewSubCategory'])->name('all.subcategory');

            Route::post('/sub/store', [SubCategoryController::class, 'subCategoryStore'])->name('subcategory.store');

            Route::get('/sub/edit/{id}', [SubCategoryController::class, 'subCategoryEdit'])->name('subcategory.edit');

            Route::post('/sub/update/{id}', [SubCategoryController::class, 'subCategoryUpdate'])->name('subcategory.update');

            Route::get('/sub/delete/{id}', [SubCategoryController::class, 'subCategoryDelete'])->name('subcategory.delete');

            //// route sub-subcategory admin
            Route::get('/sub/sub/view', [SubCategoryController::class, 'subSubCategoryView'])->name('all.subsubcategory');

            Route::get('/subcategory/ajax/{category_id}', [SubCategoryController::class, 'getSubcategoryAjax']);
            Route::get('/subsubcategory/ajax/{subcategory_id}', [SubCategoryController::class, 'getSubSubcategoryAjax']);

            Route::post('/sub/sub/store', [SubCategoryController::class, 'subSubCategoryStore'])->name('subsubcategory.store');

            Route::get('/sub/sub/edit/{id}', [SubCategoryController::class, 'subSubCategoryEdit'])->name('subsubcategory.edit');

            Route::post('/sub/sub/update/{id}', [SubCategoryController::class, 'subSubCategoryUpdate'])->name('subsubcategory.update');

            Route::get('/sub/sub/delete/{id}', [SubCategoryController::class, 'subSubCategoryDelete'])->name('subsubcategory.delete');


        });


        Route::prefix('products')->group(function(){

            Route::get('/add', [ProductController::class, 'addProduct'])->name('add-product');

            Route::get('/manage', [ProductController::class, 'manageProduct'])->name('manage-product');

            Route::post('/store', [ProductController::class, 'storeProduct'])->name('product-store');

            Route::get('/edit/{id}', [ProductController::class, 'editProduct'])->name('product.edit');

            Route::post('/update/data/{id}', [ProductController::class, 'updateDataProduct'])->name('product.data.update');

            Route::post('/update/images', [ProductController::class, 'updateDataImages'])->name('images.update');

            Route::post('/update/thambnail/{id}', [ProductController::class, 'updateThambnail'])->name('thambnail.update');

            Route::get('/imgs/delete/{id}', [ProductController::class, 'imgsDelete'])->name('product.imgs.delete');

            Route::get('/active/{id}', [ProductController::class, 'productActive'])->name('product.active');

            Route::get('/inactive/{id}', [ProductController::class, 'productInActive'])->name('product.inactive');

            Route::get('/delete/{id}', [ProductController::class, 'productDelete'])->name('product.delete');

        });

        Route::prefix('slider')->group(function(){

            Route::get('/view', [SliderController::class, 'viewSlider'])->name('manage.slider');

            Route::post('/store', [SliderController::class, 'sliderStore'])->name('slider.store');

            Route::get('/edit/{id}', [SliderController::class, 'sliderEdit'])->name('slider.edit');

            Route::post('/update/{id}', [SliderController::class, 'sliderUpdate'])->name('slider.update');

            Route::get('/active/{id}', [SliderController::class, 'sliderActive'])->name('slider.active');

            Route::get('/inactive/{id}', [SliderController::class, 'sliderInActive'])->name('slider.inactive');

            Route::get('/delete/{id}', [SliderController::class, 'sliderDelete'])->name('slider.delete');

        });

        Route::prefix('coupon')->group(function(){

            Route::get('/view', [CouponController::class, 'viewCoupon'])->name('manage.coupon');

            Route::post('/store', [CouponController::class, 'storeCoupon'])->name('coupon.store');

            Route::get('/edit/{id}', [CouponController::class, 'editCoupon'])->name('coupon.edit');

            Route::post('/update/{id}', [CouponController::class, 'updateCoupon'])->name('coupon.update');

            Route::get('/delete/{id}', [CouponController::class, 'deleteCoupon'])->name('coupon.delete');

        });


        Route::prefix('shipping')->group(function(){

            Route::get('/view', [ShippingAreaController::class, 'viewShipping'])->name('manage.area');

            Route::post('/get-regency', [ShippingAreaController::class, 'getRegency'])->name('get.regency');

            Route::post('/get-district', [ShippingAreaController::class, 'getDistrict'])->name('get.district');

            Route::post('/get-village', [ShippingAreaController::class, 'getVillage'])->name('get.village');

            Route::post('/store', [ShippingAreaController::class, 'shippingStore'])->name('shipping.store');  

            Route::get('/delete/{id}', [ShippingAreaController::class, 'deleteShipping'])->name('shipping.delete'); 

            Route::get('/edit/{id}', [ShippingAreaController::class, 'editShipping'])->name('shipping.edit'); 

            Route::post('/update/{id}', [ShippingAreaController::class, 'updateShipping'])->name('shipping.update');          

        });


        Route::prefix('order')->group(function(){

            Route::get('/', [OrderController::class, 'ordersView'])->name('manage.order');

            Route::get('/detail/{id}', [OrderController::class, 'ordersDetail'])->name('admin.detail.order'); 

            Route::get('/invoice/{id}', [OrderController::class, 'downloadInvoice'])->name('admin.invoice');     

        });


        Route::prefix('reports')->group(function(){

            Route::get('/', [ReportController::class, 'reportView'])->name('admin.reports'); 

            Route::post('/search-by-date', [ReportController::class, 'reportByDate'])->name('admin.search.by.date');

            Route::post('/search-by-month', [ReportController::class, 'reportByMonth'])->name('admin.search.by.month'); 

            Route::post('/search-by-year', [ReportController::class, 'reportByYear'])->name('admin.search.by.year');  

        });

        Route::prefix('users')->group(function(){

            Route::get('/', [UsersController::class, 'userView'])->name('admin.user'); 

        });

    });

}); //end group middleware admin













// Route All Frontend

Route::middleware(['auth:sanctum,web', 'verified'])->get('/dashboard', function () {
    $id = Auth::user()->id;
    $user = User::find($id);
    return view('dashboard',compact('user'));
})->name('dashboard');



Route::get('/auth/redirect', [SocialiteController::class, 'redirect']);

Route::get('/callback', [SocialiteController::class, 'callback']);



Route::get('/', [IndexController::class, 'index']);

Route::get('/user/logout', [IndexController::class, 'userLogout'])->name('user.logout');

Route::get('/user/profile/edit', [IndexController::class, 'userProfileEdit'])->name('user.profile.edit');

Route::post('/user/profile/update', [IndexController::class, 'userProfileUpdate'])->name('user.profile.update');

Route::get('/user/change/password', [IndexController::class, 'changePassword'])->name('change.password');

Route::post('/user/update/password', [IndexController::class, 'userUpdatePassword'])->name('user.update.password');


Route::get('/language/ind', [LanguageController::class, 'ind'])->name('language.ind');

Route::get('/language/en', [LanguageController::class, 'en'])->name('language.en');

Route::get('/detail/{id}/{slug}', [IndexController::class, 'detail']);

//frontend route tags
Route::get('/product/tag/{tag}', [IndexController::class, 'tagProduct']);

//frontend category
Route::get('/category/product/{subcat_id}/{slug}', [IndexController::class, 'subcatProduct']);

Route::get('/subsubcategory/product/{subsubcat_id}/{slug}', [IndexController::class, 'subsubcatProduct']);

//routing get data by ajax
Route::get('/product/view/modal/{id}', [IndexController::class, 'getProductModal']);

Route::post('/cart/data/store/{id}', [CartController::class, 'addToCart']);

Route::get('/product/mini/cart', [CartController::class, 'addMiniCart']);

Route::get('/minicart/product-remove/{rowId}', [CartController::class, 'removeMiniCart']);

// routing wishlist product
Route::post('/add-to-wishlist/{product_id}', [CartController::class, 'addToWishlist']);


Route::group(['prefix' => 'user', 'middleware' => ['user','auth'],'namespace'=>'User'], function(){

    Route::get('/wishlist', [WishlistController::class, 'viewWishlist'])->name('wishlist');

    Route::get('/get-wishlist-product', [WishlistController::class, 'getWishlist']);

    Route::get('/remove-wishlist/{id}', [WishlistController::class, 'removeWishlist']);

    Route::get('/my-order', [CheckoutController::class, 'myOrders'])->name('my.order');

    Route::get('/order-detil/{id}', [CheckoutController::class, 'orderDetil'])->name('order.detil');

    Route::get('/invoice/{id}', [CheckoutController::class, 'downloadInvoice'])->name('invoice');


});


Route::get('/mycart', [CartPageController::class, 'myCart'])->name('mycart');

Route::get('/get-mycart-product', [CartPageController::class, 'getMyCart']);

Route::get('/remove-mycart/{rowId}', [CartPageController::class, 'removeMyCart']);

Route::get('/cart-increment/{rowId}', [CartPageController::class, 'incrementMyCart']);

Route::get('/cart-decrement/{rowId}', [CartPageController::class, 'decrementMyCart']);

//route coupon
Route::post('/coupon-apply', [CartController::class, 'couponApply']);

Route::get('/coupon-calculation', [CartController::class, 'couponCalculation']);

Route::get('/coupon-remove', [CartController::class, 'couponRemove']);

//end route coupon

// checkout routes
Route::get('/checkout', [CartController::class, 'checkoutCreate'])->name('checkout');

Route::post('/checkout-detil', [CheckoutController::class, 'checkoutDetil'])->name('checkout.detil');

Route::post('/checkout-store', [CheckoutController::class, 'checkoutStore'])->name('checkout.store');


//end checkout routes


