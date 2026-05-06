<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BodyController;
use App\Http\Controllers\JeansController;
use App\Http\Controllers\DetailBodyController;
use App\Http\Controllers\DetailJeansController;
use App\Http\Controllers\CarterasController;
use App\Http\Controllers\DetailCarterasController;
use App\Http\Controllers\LoginSiteController;
use App\Http\Controllers\PersonalDataController;
use App\Http\Controllers\Admin\LoginController; 
use App\Http\Controllers\Admin\BienvenidaController; 
use App\Http\Controllers\Admin\UserController; 

use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LoginGoogleController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\LinksController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\NosotrosController;



Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [HomeController::class, 'index'])->name('inicio');
Route::get('/nosotros', [NosotrosController::class, 'index'])->name('nosotros');

// Login
Route::get('/admin', [LoginController::class, 'showLoginForm'])->name('admin');
Route::post('/admin', [LoginController::class, 'login']);

Route::post('/admin-logout', [LoginController::class, 'logout'])->name('admin-logout'); 


// Bienvenida
Route::get('/bienvenida', [BienvenidaController::class, 'index'])->name('bienvenida')->middleware('isLoggedIn');
Route::get('/get_user_info', [BienvenidaController::class, 'getUserInfo']);
// Route::get('/get_bienvenida', [BienvenidaController::class, 'getBienvenida']);

// rutas sites
Route::get('/get_collections', [CollectionController::class, 'getCollections']);
Route::get('/get_collections_novias', [CollectionController::class, 'getCollectionsNovias']);
Route::get('/get_collections_carteras', [CollectionController::class, 'getCollectionsCarteras']);

// rutas bodys
Route::get('/glam', [BodyController::class, 'index'])->name('bodys');
Route::get('/novias', [JeansController::class, 'index'])->name('jeans');
Route::get('/carteras', [CarterasController::class, 'index'])->name('carteras');

Route::get('/libro-reclamaciones', [LinksController::class, 'indexClaimsBook']);
Route::get('/informacion', [LinksController::class, 'indexBusinessInfo']);

Route::get('/detail_glam', [DetailBodyController::class, 'index'])->name('detailbodys');
Route::get('/detail_novias', [DetailJeansController::class, 'index'])->name('detailjeans');
Route::get('/detail_carteras', [DetailCarterasController::class, 'index'])->name('detailcarteras');
Route::get('/load_data', [BodyController::class, 'loadData']);

// login
Route::get('/user', [LoginSiteController::class, 'index'])->name('login_sitio');
Route::post('/login', [LoginSiteController::class, 'login'])->name('login_session');
// register
Route::get('/register', [LoginSiteController::class, 'indexRegister'])->name('register_sitio');
Route::post('/register', [LoginSiteController::class, 'register']);
// personal data
Route::get('/personal-data', [PersonalDataController::class, 'index']);

// cerrar sesión
Route::post('/logout', [LoginSiteController::class, 'logout'])->name('logout');


Route::middleware(['isLoggedIn'])->group(function () {
    Route::prefix('admin')->group(function () {
        
        // Listado y Filtros

        Route::get('/orders', [AdminOrderController::class, 'index']);
        
        // Actualizar Estado
        Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus']);
        
        // Exportar a Excel/CSV
        Route::get('/orders/export', [AdminOrderController::class, 'export']);

        Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy']);
        
    });
    // Pedidos/Compras
    Route::get('/admin-orders', [AdminOrderController::class, 'indexAdmin']);
    // Colors Routes
    Route::get('/colores', [ColorController::class, 'indexAdmin']);
    Route::get('/colors', [ColorController::class, 'index']);
    Route::post('/colors', [ColorController::class, 'store']);
    Route::get('/colors/{id}', [ColorController::class, 'show']);
    Route::post('/colors/{id}', [ColorController::class, 'update']);
    Route::delete('/colors/{id}', [ColorController::class, 'destroy']);

    // Sizes Routes
    Route::get('/tallas', [SizeController::class, 'indexAdmin']);
    Route::get('/sizes', [SizeController::class, 'index']);
    Route::post('/sizes', [SizeController::class, 'store']);
    Route::get('/sizes/{id}', [SizeController::class, 'show']);
    Route::post('/sizes/{id}', [SizeController::class, 'update']);
    Route::delete('/sizes/{id}', [SizeController::class, 'destroy']);

    // Collections Routes
    Route::get('/colecciones', [CollectionController::class, 'indexAdmin']);
    Route::get('/collections', [CollectionController::class, 'index']);
    Route::post('/collections', [CollectionController::class, 'store']);
    Route::get('/collections/{id}', [CollectionController::class, 'show']);
    Route::put('/collections/{id}', [CollectionController::class, 'update']);
    Route::delete('/collections/{id}', [CollectionController::class, 'destroy']);

    // Products Routes
    Route::get('/productos', [ProductController::class, 'indexAdmin']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::post('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::delete('/product-images/{id}', [ProductController::class, 'destroyImage']);

    // ProductColors Routes
    Route::get('/product-colors', [ProductColorController::class, 'index']);
    Route::post('/product-colors', [ProductColorController::class, 'store']);
    Route::get('/product-colors/{id}', [ProductColorController::class, 'show']);
    Route::post('/product-colors/{id}', [ProductColorController::class, 'update']);
    Route::delete('/product-colors/{id}', [ProductColorController::class, 'destroy']);

    // ProductSizes Routes
    Route::get('/product-sizes', [ProductSizeController::class, 'index']);
    Route::post('/product-sizes', [ProductSizeController::class, 'store']);
    Route::get('/product-sizes/{id}', [ProductSizeController::class, 'show']);
    Route::post('/product-sizes/{id}', [ProductSizeController::class, 'update']);
    Route::delete('/product-sizes/{id}', [ProductSizeController::class, 'destroy']);

    // ProductDetails Routes
    Route::get('/product-details', [ProductDetailController::class, 'index']);
    Route::post('/product-details', [ProductDetailController::class, 'store']);
    Route::get('/product-details/{id}', [ProductDetailController::class, 'show']);
    Route::post('/product-details/{id}', [ProductDetailController::class, 'update']);
    Route::delete('/product-details/{id}', [ProductDetailController::class, 'destroy']);

    // ProductSettings Routes
    Route::get('/product-settings', [ProductSettingController::class, 'index']);
    Route::post('/product-settings', [ProductSettingController::class, 'store']);
    Route::get('/product-settings/{id}', [ProductSettingController::class, 'show']);
    Route::post('/product-settings/{id}', [ProductSettingController::class, 'update']);
    Route::delete('/product-settings/{id}', [ProductSettingController::class, 'destroy']);

    // ProductPolicies Routes
    Route::get('/product-policies', [ProductPolicyController::class, 'index']);
    Route::post('/product-policies', [ProductPolicyController::class, 'store']);
    Route::get('/product-policies/{id}', [ProductPolicyController::class, 'show']);
    Route::post('/product-policies/{id}', [ProductPolicyController::class, 'update']);
    Route::delete('/product-policies/{id}', [ProductPolicyController::class, 'destroy']);

    // Datos del perfil
    Route::put('/user/profile', [PersonalDataController::class, 'updateProfile']);
    Route::put('/user/password', [PersonalDataController::class, 'updatePassword']);
    
    // Direcciones
    Route::get('/user/addresses', [PersonalDataController::class, 'getAddresses']);
    Route::post('/user/addresses', [PersonalDataController::class, 'storeAddress']);
    Route::put('/user/addresses/{id}', [PersonalDataController::class, 'updateAddress']);
    Route::delete('/user/addresses/{id}', [PersonalDataController::class, 'deleteAddress']);

    // Rutas API para usuarios
    Route::get('/users_admin', [UserController::class, 'indexAdmin']);
    Route::get('/users_admin_get', [UserController::class, 'index']);
    Route::post('/users_admin', [UserController::class, 'store']);
    Route::get('/users_admin/{id}', [UserController::class, 'show']);
    Route::post('/users_admin/{id}', [UserController::class, 'update']);
    Route::delete('/users_admin/{id}', [UserController::class, 'destroy']);
    
    // Ruta para obtener roles
    Route::get('/roles', [UserController::class, 'getRoles']);

    // Rutas para el carrito y ordenes
    Route::post('/checkout/process', [CheckoutController::class, 'processOrder']);
    Route::post('/checkout/confirm-payment', [CheckoutController::class, 'confirmOnlinePayment']);
    Route::get('/checkout', [CheckoutController::class, 'viewCheckout'])->name('site.checkout');
    Route::get('/thank-you', [CheckoutController::class, 'viewThankYou']);

    Route::get('/user/orders', [OrderController::class, 'getUserOrders']);

    Route::post('/admin/order-details/{id}/certificates', [AdminOrderController::class, 'syncCertificates']);
});

Route::get('/pasarela', [MercadoPagoController::class, 'indexPasarela']);


// Rutas para reviews
Route::prefix('reviews')->group(function () {
    // Crear nueva reseña
    Route::post('/', [ReviewController::class, 'store']);
    
    // Obtener reseñas de un producto específico
    Route::get('/product/{productId}', [ReviewController::class, 'getProductReviews']);
    
    // Actualizar reseña existente
    Route::put('/{id}', [ReviewController::class, 'update']);
    
    // Eliminar reseña
    Route::delete('/{id}', [ReviewController::class, 'destroy']);
});

    
Route::prefix('reviews')->group(function () {
    // Obtener todas las reseñas de un usuario
    Route::get('/user/{userId}', [ReviewController::class, 'getUserReviews']);
    
    // Verificar si un usuario ya calificó un producto
    Route::get('/check/{userId}/{productId}', [ReviewController::class, 'checkUserReview']);
    
    // Obtener estadísticas generales de reseñas
    Route::get('/statistics', [ReviewController::class, 'getStatistics']);
});



Route::get('/auth/google', [LoginGoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [LoginGoogleController::class, 'handleGoogleCallback']);


Route::get('/auth/google/login', [LoginGoogleController::class, 'redirectToGoogleForLogin'])->name('auth.google.login');


Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');


Route::prefix('mercadopago')->group(function () {
    Route::post('/create-preference', [MercadoPagoController::class, 'createPreference']);
    Route::post('/webhook', [MercadoPagoController::class, 'webhook']);
    Route::post('/save-order', [MercadoPagoController::class, 'saveOrder']);
    Route::get('/order-status/{externalReference}', [MercadoPagoController::class, 'getOrderStatus']);
});

Route::get('/test-mercadopago-connection', [MercadoPagoController::class, 'testConnection']);
Route::post('/mercadopago/debug', [MercadoPagoController::class, 'debugRequest']);

Route::post('/verify-certificate', [OrderController::class, 'verifyCertificate']);