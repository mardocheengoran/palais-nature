<?php

use App\Http\Controllers\SimpleQRcodeController;
use App\Http\Livewire\WireAllDetailsInvoice;
use App\Http\Livewire\WireStore;
use App\Mail\InvoiceMail;
use App\Http\Livewire\WireCart;
use App\Http\Livewire\WireDate;
use App\Http\Livewire\WireMode;
use App\Http\Livewire\WireSale;
use App\Http\Livewire\WireRelay;
use App\Http\Livewire\WireProfil;
use App\Http\Livewire\WireResume;
use App\Http\Livewire\WireAddress;
use App\Http\Livewire\WireCongrat;
use App\Http\Livewire\WirePayment;
use App\Http\Livewire\WireWelcome;
use App\Http\Livewire\WireWelcome2;
use App\Http\Livewire\WireWelcome3;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\WireArticleShow;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EcommercePaimentController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WelcomeController;
use App\Http\Livewire\WireAllInvoice;
use App\Http\Livewire\WireCategory;
use App\Http\Livewire\WireCheckout;
use App\Http\Livewire\WireContact;
use App\Http\Livewire\WireDevis;
use App\Http\Livewire\WireHistory;
use App\Http\Livewire\WireLogin;
use App\Http\Livewire\WireOnboarding;
use App\Http\Livewire\WireProduct;
use App\Http\Livewire\WireProfile;
use App\Http\Livewire\WireRegister;
use App\Http\Livewire\WireStoreShow;
use App\Http\Livewire\WireWishlist;
use App\Http\Middleware\AuthMiddleware;

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

Route::get('/', WireWelcome::class)->name('welcome');
Route::get('/login', WireLogin::class)->name('login')->middleware(AuthMiddleware::class);
Route::get('/register', WireRegister::class)->name('register')->middleware(AuthMiddleware::class);

Route::get('/products', WireProduct::class)->name('products');
//Route::get('/brand{slug}', WireProduct::class)->name('products');
Route::get('/signal', [WelcomeController::class, 'signal'])->name('signal');
Route::get('/search', [SearchController::class, 'index'])->name('search');


Route::get('/contact', WireContact::class)->name('contact');
Route::get('/devis', WireDevis::class)->name('devis');
Route::post('/contact', [WelcomeController::class, 'store'])->name('contact.store');
Route::get('/carting ', function () {
    //Cart::instance('shopping')->destroy();
    //return Cart::instance('shopping')->content();
    dd(Cart::instance('shopping')->content()->toArray());
});
Route::get('/category/{slug}', WireCategory::class)->name('article.index');
Route::get('/cart', WireCart::class)->name('checkout.cart');
Route::get('/boutiques', WireStore::class)->name('boutique.index');
Route::get('/boutiques/{users}', WireStoreShow::class)->name('boutique.show');


Route::get('/generate-facture/{code}', [PDFController::class, 'generatePDF'])->name('imprimer');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    //'role:super_admin|admin',
])->group(function () {
    Route::get('/onboarding', WireOnboarding::class)->name('onboarding');
    Route::get('/wishlist', WireWishlist::class)->name('wishlist');
    Route::get('/profil', WireProfil::class)->name('profil.index');
    Route::get('/history', WireHistory::class)->name('profil.history');
    Route::get('/invoices', WireAllInvoice::class)->name('invoice.all');
    Route::get('/invoice/{code}', WireAllDetailsInvoice::class)->name('invoice.all.details');


    Route::get('/qrcode', [SimpleQRcodeController::class, 'generateQRcode'])->name('qrcode');
    Route::get('/sale', WireSale::class)->name('checkout.sale');
    Route::get('/mode', WireMode::class)->name('checkout.mode');
    Route::get('/checkout', WireCheckout::class)->name('checkout.index');
    Route::get('/address', WireAddress::class)->name('checkout.address');
    Route::get('/relay', WireRelay::class)->name('checkout.relay');
    Route::get('/date', WireDate::class)->name('checkout.date');
    Route::get('/payment', WirePayment::class)->name('checkout.payment');
    Route::get('/resume', WireResume::class)->name('checkout.resume');
    Route::get('/congrat/{code}', WireCongrat::class)->name('checkout.congrat');

    // Paiement pro
    Route::match(['get','post'],'/return', [PaiementController::class, 'return'])->name('return');

    Route::get('routes', function () {
        $routeCollection = Route::getRoutes();

        echo "<table style='width:100%'>";
        echo "<tr>";
        echo "<td width='10%'><h4>HTTP Method</h4></td>";
        echo "<td width='10%'><h4>Route</h4></td>";
        echo "<td width='10%'><h4>Name</h4></td>";
        echo "<td width='70%'><h4>Corresponding Action</h4></td>";
        echo "</tr>";
        foreach ($routeCollection as $value) {
            echo "<tr>";
            echo "<td>" . $value->methods()[0] . "</td>";
            echo "<td>" . $value->uri() . "</td>";
            echo "<td>" . $value->getName() . "</td>";
            echo "<td>" . $value->getActionName() . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    });

    Route::get('testeur', [PaiementController::class, 'testeur'])->name('testeur');

    Route::get('/user/profile', WireProfile::class)->name('profile.show');

});

// Paiement pro
Route::match(['get','post'],'/notify', [PaiementController::class, 'notify'])->name('notify');

// Paiement boutique avec CinetPay
Route::match(['get','post'],'/notify-boutique', [EcommercePaimentController::class, 'notify_url'])->name('notify_boutique');
Route::match(['get','post'],'/return-boutique/{code}', [EcommercePaimentController::class, 'return_url'])->name('return_boutique');


// Lire un article avec son slug
Route::get('/{slug}', WireArticleShow::class)->name('article.show');

