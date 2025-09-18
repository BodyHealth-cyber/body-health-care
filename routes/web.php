<?php

use Illuminate\Support\Facades\Route;

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
    return file_get_contents(resource_path('views/index.html'));
});

// Сторінки послуг
Route::get('services/healthcare.html', function () {
    return file_get_contents(resource_path('views/services/healthcare.html'));
});

Route::get('services/ambulance.html', function () {
    return file_get_contents(resource_path('views/services/ambulance.html'));
});

Route::get('services/checkup.html', function () {
    return file_get_contents(resource_path('views/services/checkup.html'));
});

// Інші сторінки
Route::get('for-companies.html', function () {
    return file_get_contents(resource_path('views/for-companies.html'));
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
    return file_get_contents(resource_path('views/blog.html'));
});

Route::get('blog/{article}.html', function ($article) {
    $path = resource_path('views/blog/' . $article . '.html');

    if (file_exists($path)) {
        return file_get_contents($path);
    }

    // Якщо файл не знайдено, повертаємо 404
    abort(404);
});

Route::get('pricing.html', function () {
    abort(404);
});

Route::get('contact.html', function () {
    abort(404);
});
