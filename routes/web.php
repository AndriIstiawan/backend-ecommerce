<?php

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
$path = public_path('/img');

if (!file_exists($path)) {
    #create directory
    File::copyDirectory(public_path('/img-asset'), $path);
}

Auth::routes();
/* CoreUI templates */

Route::middleware('auth')->group(function() {
    Route::get('/', 'DashboardController@index');
    Route::resource('master-setting', 'SettingManagement\MasterSettingController');
	
	Route::get('profile/reset-password', 'ProfileController@resetPass');
    Route::post('profile/change-password', 'ProfileController@changePassword');
    
    /* Master home */
    Route::resource('slider', 'MasterhomeManagement\SliderController');
    Route::post('slider/import-data', 'MasterhomeManagement\SliderController@importData');
    Route::resource('brands', 'MasterhomeManagement\BrandController');
    Route::post('brands/find', 'MasterhomeManagement\BrandController@find');
    Route::post('brands/import-data', 'MasterhomeManagement\BrandController@importData');
	/* END Master home */

	/* Master User */
	Route::resource('permission', 'UserManagement\PermissionController');
	Route::post('permission/find', 'UserManagement\PermissionController@find');

	Route::resource('role', 'UserManagement\RoleController');
	Route::post('role/find', 'UserManagement\RoleController@find');
		
	Route::resource('master-user', 'UserManagement\MasterUserController');
	Route::post('master-user/find', 'UserManagement\MasterUserController@find');
	/* END Master User */
	
    /* Master deal */
    Route::get('discount/export-data', 'DiscountManagement\ExportDiscountController@index');
    Route::post('discount/export-selected', 'DiscountManagement\ExportDiscountController@export_selected');
    Route::get('discount/import', 'DiscountManagement\ImportDiscountController@index');
    Route::get('discount/download-import-form', 'DiscountManagement\ImportDiscountController@downloadImportForm');
    Route::post('discount/import-data', 'DiscountManagement\ImportDiscountController@importData');
	Route::resource('discount', 'DiscountManagement\DiscountController');
    Route::post('discount/find', 'DiscountManagement\DiscountController@find');

    Route::get('promo/export-data', 'DiscountManagement\ExportPromoController@index');
    Route::get('promo/export-selected', 'DiscountManagement\ExportPromoController@export_selected');
    Route::get('promo/import', 'DiscountManagement\ExportPromoController@index');
    Route::get('promo/download-import-form', 'DiscountManagement\ExportPromoController@downloadImportForm');
    Route::post('promo/import-form', 'DiscountManagement\ExportPromoController@importData');
	Route::resource('promo', 'DiscountManagement\PromoController');
	Route::post('promo/find', 'DiscountManagement\PromoController@find');
	/* END Master deal */

	/* Custom PO */
	Route::resource('custom-po', 'OrderManagement\CustomPoController');
	Route::post('custom-po/find', 'OrderManagement\CustomPoController@find');
	/* END Custom PO */

	/* List Email Blast */
	Route::resource('mail', 'MailManagement\MailController');
	Route::post('mail/find', 'MailManagement\mailController@find');
	/* END List Email Blast */

	/* Product Management */
	Route::resource('attributes', 'ProductManagement\AttributesController');
    Route::post('attributes/find', 'ProductManagement\AttributesController@find');
    
    Route::post('product/export-selected', 'ProductManagement\ExportProductController@export_selected');
    Route::get('product/export', 'ProductManagement\ExportProductController@index');
    Route::get('product/import', 'ProductManagement\ImportProductController@index');
    Route::post('product/import', 'ProductManagement\ImportProductController@importData');
	Route::resource('product', 'ProductManagement\ProductController');
    Route::post('product/find', 'ProductManagement\ProductController@find');

	Route::resource('taxes', 'ProductManagement\TaxesController');
	Route::post('taxes/find', 'ProductManagement\TaxesController@find');

	Route::resource('category', 'ProductManagement\CategoriesController');
    Route::post('category/find', 'ProductManagement\CategoriesController@find');
    Route::post('category/import-data', 'ProductManagement\CategoriesController@importData');

	Route::resource('attribute-sets', 'ProductManagement\AttributeSetsController');
	Route::post('attribute-sets/find', 'ProductManagement\AttributeSetsController@find');

	Route::resource('variant', 'ProductManagement\VariantController');
	Route::post('variant/find', 'ProductManagement\VariantController@find');
    /* END Product Management */
    
    /* B2B Selling */
    Route::resource('pending-po', 'B2BSelling\PendingPOController');
    Route::resource('orders-b2b', 'B2BSelling\OrdersB2BController');
    /* END B2B Selling */

	Route::resource('orderstatuses', 'OrderManagement\OrderStatusController');
	Route::post('orderstatuses/find', 'OrderManagement\OrderStatusController@find');

	Route::resource('courier', 'DeliveriesManagement\CourierController');
    Route::post('courier/find', 'DeliveriesManagement\CourierController@find');
    Route::post('courier/set-status', 'DeliveriesManagement\CourierController@set_status');

	Route::resource('deliveries', 'DeliveriesManagement\DeliveriesController');
	Route::post('deliveries/find', 'DeliveriesManagement\DeliveriesController@find');

	Route::resource('payment-method', 'PaymentManagement\PaymentMethodController');
    Route::post('payment-method/find', 'PaymentManagement\PaymentMethodController@find');
    Route::post('payment-method/set-status', 'PaymentManagement\PaymentMethodController@set_status');

	Route::resource('payment', 'PaymentManagement\PaymentController');
    Route::post('payment/find', 'PaymentManagement\PaymentController@find');

	Route::resource('paymentpo', 'PaymentManagement\PaymentPOController');
	Route::post('paymentpo/find', 'PaymentManagement\PaymentPOController@find');


	Route::namespace('MemberManagement')->group(function(){
           Route::post('/master-member/export-selected', 'MasterMemberController@export_selected')
           ->name('master-member.export');
           Route::get('/master-member/export', 'MasterMemberController@export')
           ->name('master-member.export');
           
           Route::get('/master-member/ajax-select2', 'MasterMemberController@ajaxSelect2')
           ->name('master-member.ajax-select2');
           
           Route::resource('master-member', 'MasterMemberController');
           Route::get('master-member/{id}/detail', 'MasterMemberController@detail')->name('master-member.detail');
           Route::post('master-member/find', 'MasterMemberController@find');
           
           Route::resource('level', 'LevelController');
           Route::post('level/find', 'LevelController@find');
           
           Route::resource('archievement', 'ArchievementController');
           Route::post('archievement/find', 'ArchievementController@find');
           Route::resource('saldo-member', 'MemberSaldoController', [
                'only' => ['index', 'update']
           ]);
           Route::get('company-member', 'MemberCompanyController')->name('company-member.index');
    });

	Route::resource('orders', 'OrderManagement\OrdersController');
	Route::post('orders/find', 'OrderManagement\OrdersController@find');

	Route::resource('segment', 'FooterManagement\SegmentController');
	Route::post('segment/find', 'FooterManagement\SegmentController@find');

	Route::resource('segment-attributes', 'FooterManagement\SegmentAttributesController');
	Route::post('segment-attributes/find', 'FooterManagement\SegmentAttributesController@find');

	Route::resource('footer', 'FooterManagement\FooterController');
	Route::post('footer/find', 'FooterManagement\FooterController@find');	

	Route::get('/image-upload/export', 'ImageManagement\ImageUploadController@export')
		   ->name('image-upload.export');

	Route::post('/image-upload/export-selected', 'ImageManagement\ImageUploadController@export_selected')
		   ->name('image-upload.export_selected');

    Route::resource('image-upload', 'ImageManagement\ImageUploadController');

	Route::resource('cart', 'OrderManagement\CartsController');
	Route::post('cart/set-cost', 'OrderManagement\CartsController@set_cost');

	Route::resource('point', 'ProductManagement\PointsController');
    Route::post('point/find', 'ProductManagement\PointsController@find');

    // News
    Route::resource('/news', 'News\NewsController');
    Route::post('/news/validate', 'News\NewsController@validation')->name('news.validate');

    // Special Product
    Route::group([
        'namespace' => 'SpecialProduct', 
        'prefix' => 'special-product'
    ], function(){
        // Route::resource('hot-deals', 'HotDealsController', [
        //     'except' => ['create','show']
        // ]);
        // Route::resource('best-choice', 'BestChoiceController', [
        //     'only' => ['index','store','destroy']
        // ]);
        Route::resource('segments', 'SegmentController', [
            'except' => ['show']
        ]);
        Route::post('/segments/validate', 'SegmentController@validation');
        Route::get('/segments/product', 'SegmentController@getProduct');
    });
    
    //notif-change-route
    Route::get('notif-b2b', function () {
        return response()->json([
            [
                'div' => 'cart',
                'counter' => Auth::user()->countCartPendingCost(), //for cart
            ],
            [
                'div' => 'pending-po',
                'counter' => Auth::user()->countPOPending() //for pending po
            ]
        ]);
    });

    //download file from storage
    Route::get('download-storage/{filename}', function () {
        $filename = Route::current()->filename;
        if(file_exists(storage_path('exports/'.$filename))){
            return response()->download(storage_path('exports/'.$filename))->deleteFileAfterSend(true);
        }else{
            return redirect('/');
        }
    });
});

//notification {midtrans}
Route::post('notification/midtrans','NotificationController@midtrans');

// Section Pages
Route::view('/sample/charts','samples.charts')->name('charts');
Route::view('/sample/error404','errors.404')->name('error404');
Route::view('/sample/error500','errors.500')->name('error500');