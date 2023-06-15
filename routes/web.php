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

Route::get('/', [\App\Http\Controllers\Home\HomeController::class, 'index'])->name('home');

Route::get('share/form/{id?}', [\App\Http\Controllers\Home\FormController::class, 'form'])->name('share.form');

Route::get('deneme', function () {
    $user = \App\Models\Eloquent\Kullanicilar::find(5692);
    $user->permissions()->sync([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18]);
});
