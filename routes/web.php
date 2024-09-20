<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('category/search',[CategoryController::class,'search'])->name('category.search');
    Route::resource('category',CategoryController::class);

    Route::get('item/search-detail',[ItemController::class,'searchDetail'])->name('item.searchDetail');
    Route::get('item/search',[ItemController::class,'search'])->name('item.search');
    Route::resource('item',ItemController::class);
});

require __DIR__.'/auth.php';
