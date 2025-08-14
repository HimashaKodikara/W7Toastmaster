<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Adminpanel\NewsController;
use App\Http\Controllers\Adminpanel\MemeberController;

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
], function () {
    Route::get('/', [NewsController::class, 'index'])->name('news');
    Route::get('/create', [NewsController::class, 'create'])->name('create-news');
    Route::post('/store', [NewsController::class, 'store'])->name('store-news');
    Route::get('/edit/{id}', [NewsController::class, 'show'])->name('show-news');
    Route::get('/get-news', [NewsController::class, 'getAjaxNewsData'])->name('get-news');
    Route::put('/update-news/{id}', [NewsController::class, 'update'])->name('update-news');
    Route::get('/change-status/{id}', [NewsController::class, 'activation'])->name('change-status');
    Route::delete('/delete-news/{id}', [NewsController::class, 'destroy'])->name('delete-news');
    Route::get('/get-news-json', [NewsController::class, 'getNewsJson'])->name('index.json');
});

Route::group([
    'prefix' => 'member',
    'as' => 'member.'
], function () {
    Route::get('/', [MemeberController::class, 'index'])->name('member');
    Route::get('/create', [MemeberController::class, 'create'])->name('create-member');
    Route::post('/store', [MemeberController::class, 'store'])->name('store-member');
    Route::get('/edit/{id}', [MemeberController::class, 'show'])->name('show-member');
    Route::get('/get-member', [MemeberController::class, 'getAjaxMembersData'])->name('get-member');
    Route::put('/update-member/{id}', [MemeberController::class, 'update'])->name('update-member');
    Route::get('/change-status/{id}', [MemeberController::class, 'activation'])->name('change-status');
    Route::delete('/delete-member/{id}', [MemeberController::class, 'destroy'])->name('delete-member');
    Route::get('/get-member-json', [MemeberController::class, 'getmemberJson'])->name('index.json');
});

require __DIR__.'/auth.php';
