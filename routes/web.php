<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Adminpanel\NewsController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/news', function (){
    return view('admin.news.list');
});

Route::group([
    'prefix' => 'news',
    'as' => 'news.'
],function(){
    Route::get('/',[NewsController::class,'index'])->name('news');
    Route::get('/create',[NewsController::class,'create'])->name('create-news');
    Route::post('/store',[NewsController::class,'store'])->name('store-news');
    

});

require __DIR__.'/auth.php';
