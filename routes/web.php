<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', [\App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');

Route::redirect('/', '/home');

Route::prefix('articles')->group(function () {

    Route::get('/', [\App\Http\Controllers\Web\ArticleController::class, 'index'])->name('articles.index');

    Route::get('/{article}', [\App\Http\Controllers\Web\ArticleController::class, 'show'])->name('articles.show');

});

Route::prefix('messages')->group(function () {

    Route::get('/', [\App\Http\Controllers\Web\MessageController::class, 'index'])->name('messages.index');

    Route::get('/create', [\App\Http\Controllers\Web\MessageController::class, 'create'])->name('messages.create');
    Route::post('/', [\App\Http\Controllers\Web\MessageController::class, 'store'])->name('messages.store');

    Route::get('/{message}/edit', [\App\Http\Controllers\Web\MessageController::class, 'edit'])->name('messages.edit');
    Route::put('/{message}', [\App\Http\Controllers\Web\MessageController::class, 'update'])->name('messages.update');
    Route::delete('/{message}', [\App\Http\Controllers\Web\MessageController::class, 'destroy'])->name('messages.destroy');

    Route::post('/{message}/process', [\App\Http\Controllers\Web\MessageController::class, 'process'])->name('messages.process');
    Route::post('/{message}/publish', [\App\Http\Controllers\Web\MessageController::class, 'publish'])->name('messages.publish');

});

Route::prefix('authors')->group(function () {

    Route::get('/', [\App\Http\Controllers\Web\AuthorController::class, 'index'])->name('authors.index');

    Route::get('/{author}', [\App\Http\Controllers\Web\AuthorController::class, 'show'])->name('authors.show');

});