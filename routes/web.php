<?php

use App\Http\Controllers\BackEnd\AuthController;
use App\Http\Controllers\BackEnd\BanniereController;
use App\Http\Controllers\BackEnd\CategoryController;
use App\Http\Controllers\BackEnd\CouleurController;
use App\Http\Controllers\BackEnd\MarqueController;
use App\Http\Controllers\BackEnd\ProduitController;
use App\Http\Controllers\BackEnd\SliderController;
use App\Http\Controllers\BackEnd\SousCategorieController;
use App\Http\Controllers\BackEnd\TailleController;
use App\Http\Controllers\FrontEnd\HomeController;
use App\Http\Controllers\FrontEnd\AccountController;
use App\Http\Controllers\FrontEnd\AuthClientController;
use App\Http\Controllers\FrontEnd\CartController;
use App\Http\Controllers\FrontEnd\CheckoutController;
use App\Http\Controllers\FrontEnd\OrderController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\FrontEnd\ShopController;
use App\Http\Controllers\FrontEnd\WishlistController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index']);

Route::get('/test', function () {
    return view('back-end.test');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/recherche', [SearchController::class, 'search'])->name('frontend.search');

// Routes d'authentification frontend
Route::prefix('frontend/auth')->group(function () {
    Route::get('/login', [AuthClientController::class, 'showLoginForm'])->name('frontend.login');
    Route::post('/login', [AuthClientController::class, 'login'])->name('frontend.login.post');
    Route::get('/register', [AuthClientController::class, 'showRegisterForm'])->name('frontend.register');
    Route::post('/register', [AuthClientController::class, 'register'])->name('frontend.register.post');
    Route::post('/logout', [AuthClientController::class, 'logout'])->name('frontend.logout');
});


Route::middleware(['auth'])->group(function () {

    Route::resource('sliders', SliderController::class);
    Route::put('sliders/{slider}/toggle-status', [SliderController::class, 'toggleStatus'])->name('sliders.toggle-status');
    Route::post('sliders/update-order', [SliderController::class, 'updateOrder'])->name('sliders.update-order');

    Route::resource('bannieres', BanniereController::class);
    Route::put('bannieres/{banniere}/toggle-status', [BanniereController::class, 'toggleStatus'])->name('bannieres.toggle-status');

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });


    Route::prefix('sous-categories')->group(function () {
        Route::get('/', [SousCategorieController::class, 'index'])->name('souscategories.index');
        Route::get('/create', [SousCategorieController::class, 'create'])->name('souscategories.create');
        Route::post('/store', [SousCategorieController::class, 'store'])->name('souscategories.store');
        Route::get('/{sousCategorie}/edit', [SousCategorieController::class, 'edit'])->name('souscategories.edit');
        Route::put('/{sousCategorie}', [SousCategorieController::class, 'update'])->name('souscategories.update');
        Route::delete('/{sousCategorie}', [SousCategorieController::class, 'destroy'])->name('souscategories.destroy');
    });

    Route::prefix('couleurs')->group(function () {
        Route::get('/', [CouleurController::class, 'index'])->name('couleurs.index');
        Route::get('/create', [CouleurController::class, 'create'])->name('couleurs.create');
        Route::post('/store', [CouleurController::class, 'store'])->name('couleurs.store');
        Route::get('/{couleur}/edit', [CouleurController::class, 'edit'])->name('couleurs.edit');
        Route::put('/{couleur}', [CouleurController::class, 'update'])->name('couleurs.update');
        Route::delete('/{couleur}', [CouleurController::class, 'destroy'])->name('couleurs.destroy');
    });

    Route::prefix('tailles')->group(function () {
        Route::get('/', [TailleController::class, 'index'])->name('tailles.index');
        Route::get('/create', [TailleController::class, 'create'])->name('tailles.create');
        Route::post('/store', [TailleController::class, 'store'])->name('tailles.store');
        Route::get('/{taille}/edit', [TailleController::class, 'edit'])->name('tailles.edit');
        Route::put('/{taille}', [TailleController::class, 'update'])->name('tailles.update');
        Route::delete('/{taille}', [TailleController::class, 'destroy'])->name('tailles.destroy');
    });


    // Routes corrigées
    Route::get('produits', [ProduitController::class, 'index'])->name('produits.index');
    Route::get('produits/create', [ProduitController::class, 'create'])->name('produits.create');
    Route::post('produits', [ProduitController::class, 'store'])->name('produits.store'); // ← CORRIGÉ
    Route::get('produits/{produit}/edit', [ProduitController::class, 'edit'])->name('produits.edit');
    Route::put('produits/{produit}', [ProduitController::class, 'update'])->name('produits.update');
    Route::delete('produits/{produit}', [ProduitController::class, 'destroy'])->name('produits.destroy');
    Route::delete('produits/images/{image}', [ProduitController::class, 'deleteImage'])->name('produits.images.destroy');


    Route::resource('marques', MarqueController::class);

});







// Front / back shop
Route::get('produits/shop', [ShopController::class, 'index'])->name('produits.shop');
Route::get('produits/shop/{produit}', [ShopController::class, 'show'])->name('produits.shop.show');


// Front / back shop
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{produit}', [ShopController::class, 'show'])->name('shop.show');

// Routes du panier
// Routes du panier
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/{id}/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/{id}/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/count', [CartController::class, 'getCount'])->name('cart.count');
    Route::get('/total', [CartController::class, 'getTotal'])->name('cart.total');
});

// Wishlist
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/wishlist/add/{produit}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{produit}', [WishlistController::class, 'remove'])->name('wishlist.remove');

    // Checkout / orders
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/create-payment-intent', [CheckoutController::class, 'createPaymentIntent'])->name('checkout.createPaymentIntent');
    Route::post('/checkout/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');

    // Account
    Route::get('/account', [AccountController::class, 'profile'])->name('account.profile');
    Route::post('/account/profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
    Route::post('/account/password', [AccountController::class, 'changePassword'])->name('account.changePassword');
    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
});

// Orders admin/customer
Route::resource('orders', OrderController::class)->only(['index', 'show']);
