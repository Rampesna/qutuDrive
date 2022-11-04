<?php

use Illuminate\Support\Facades\Route;

Route::prefix('form')->group(function () {
    Route::get('getById', [\App\Http\Controllers\Api\Home\FormController::class, 'getById'])->name('home.api.form.getById');
});

Route::prefix('formQuestion')->group(function () {
    Route::get('getByFormIdWithAnswers', [\App\Http\Controllers\Api\Home\FormQuestionController::class, 'getByFormIdWithAnswers'])->name('home.api.formQuestion.getByFormIdWithAnswers');
});

Route::prefix('formSubmit')->group(function () {
    Route::post('submit', [\App\Http\Controllers\Api\Home\FormSubmitController::class, 'submit'])->name('home.api.formSubmit.submit');
});
