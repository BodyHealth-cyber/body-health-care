<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\PolicyController;

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
//
//Route::get('/', function () {
//    return view('welcome');
//});

// Головна сторінка
Route::get('/', function () {
    return view('index');
});

Route::get('/lang/{locale}', function (string $locale) {
    $supported = ['ru', 'en', 'uk'];
    if (in_array($locale, $supported, true)) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('locale.switch');

// Сторінки послуг
Route::get('services/healthcare.html', function () {
    return view('services.healthcare');
});

Route::get('services/ambulance.html', function () {
    return view('services.ambulance');
});

Route::get('services/checkup.html', function () {
    return view('services.checkup');
});

// Інші сторінки
Route::get('for-companies.html', function () {
    return view('for-companies');
});

Route::get('for-clinics.html', function () {
    abort(404);
});

Route::get('about.html', function () {
    abort(404);
});

Route::get('evidence.html', function () {
    abort(404);
});

Route::get('blog.html', function () {
    return view('blog');
});

Route::get('login.html', function () {
    return view('login');
});

Route::get('contacts.html', function () {
    return view('contacts');
});

Route::get('blog/{article}.html', function ($article) {
    if (view()->exists('blog.' . $article)) {
        return view('blog.' . $article);
    }

    $htmlPath = resource_path('views/blog/' . $article . '.html');
    if (file_exists($htmlPath)) {
        return file_get_contents($htmlPath);
    }

    // Якщо файл не знайдено, повертаємо 404
    abort(404);
});

Route::get('pricing.html', function () {
    abort(404);
});

Route::get('contact.html', function () {
    return redirect('/contacts.html');
});

Route::get('/privacy', [PolicyController::class, 'show'])
    ->name('privacy.policy');

Route::get('/terms-and-conditions', [LegalController::class, 'termsIndex'])
    ->name('legal.terms');

Route::get('/terms-and-conditions/{locale}', [LegalController::class, 'termsVersion'])
    ->whereIn('locale', ['en', 'uk', 'ru'])
    ->name('legal.terms.version');

Route::get('/refund-policy', [LegalController::class, 'show'])
    ->defaults('slug', 'refund-policy')
    ->name('legal.refund');

Route::get('/contact-information', [LegalController::class, 'show'])
    ->defaults('slug', 'contact-information')
    ->name('legal.contact_info');
