<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Adminpanel\NewsController;
use App\Http\Controllers\Adminpanel\EventsController;
use App\Http\Controllers\Adminpanel\GalleryController;
use App\Http\Controllers\Adminpanel\MemeberController;
use App\Http\Controllers\Adminpanel\ContactUsController;
use App\Http\Controllers\Adminpanel\AchivementsController;
use App\Http\Controllers\Adminpanel\TestermonialController;

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


Route::group([
    'prefix' => 'gallery',
    'as' => 'gallery.'
], function () {
    Route::get('/', [GalleryController::class, 'index'])->name('gallery');
    Route::get('/create', [GalleryController::class, 'create'])->name('create-gallery');
    Route::post('/store', [GalleryController::class, 'store'])->name('store-gallery');
    Route::get('/edit/{id}', [GalleryController::class, 'show'])->name('show-gallery');
    Route::get('/get-gallery', [GalleryController::class, 'getAjaxGalleryData'])->name('get-gallery');
    Route::put('/update-gallery/{id}', [GalleryController::class, 'update'])->name('update-gallery');
    Route::get('/change-status/{id}', [GalleryController::class, 'activation'])->name('change-status');
    Route::delete('/delete-gallery/{id}', [GalleryController::class, 'destroy'])->name('delete-gallery');
    Route::get('/get-gallery-json', [GalleryController::class, 'getgalleryJson'])->name('index.json');
});

Route::group([
    'prefix' => 'contact-us',
    'as' => 'contact-us.'
], function () {
     Route::get('/', [ContactUsController::class, 'index'])->name('contact-us');
    Route::get('/create', [ContactUsController::class, 'create'])->name('create');
    Route::post('/store', [ContactUsController::class, 'store'])->name('store-contact');
    Route::get('/{id}', [ContactUsController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [ContactUsController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ContactUsController::class, 'update'])->name('update');
    Route::delete('/{id}', [ContactUsController::class, 'destroy'])->name('destroy');


});


Route::group([
    'prefix' => 'event',
    'as' => 'event.'
], function () {
    Route::get('/', [EventsController::class, 'index'])->name('event');
    Route::get('/create', [EventsController::class, 'create'])->name('create-event');
    Route::post('/store', [EventsController::class, 'store'])->name('store-event');
    Route::get('/edit/{id}', [EventsController::class, 'show'])->name('show-event');
    Route::get('/get-event', [EventsController::class, 'getAjaxEventData'])->name('get-event');
    Route::put('/update-event/{id}', [EventsController::class, 'update'])->name('update-event');
    Route::get('/change-status/{id}', [EventsController::class, 'activation'])->name('change-status');
    Route::delete('/delete-event/{id}', [EventsController::class, 'destroy'])->name('delete-event');
    Route::get('/get-event-json', [EventsController::class, 'geteventJson'])->name('index.json');
});


Route::group([
    'prefix' => 'achivements',
    'as' => 'achivements.'
], function () {
    Route::get('/', [AchivementsController::class, 'index'])->name('achivements');
    Route::get('/create', [AchivementsController::class, 'create'])->name('create-achivements');
    Route::post('/store', [AchivementsController::class, 'store'])->name('store-achivements');
    Route::get('/edit/{id}', [AchivementsController::class, 'show'])->name('show-achivements');
    Route::get('/get-achivements', [AchivementsController::class, 'getAjaxAchievementData'])->name('get-achivements');
    Route::put('/update-achivements/{id}', [AchivementsController::class, 'update'])->name('update-achivements');
    Route::get('/change-status/{id}', [AchivementsController::class, 'activation'])->name('change-status');
    Route::delete('/delete-achivements/{id}', [AchivementsController::class, 'destroy'])->name('delete-achivements');
    Route::get('/get-achivements-json', [AchivementsController::class, 'geteventJson'])->name('index.json');
});

Route::group([
    'prefix' => 'testimonial',
    'as' => 'testimonial.'
], function () {
    Route::get('/', [TestermonialController::class, 'index'])->name('testimonial');
    Route::get('/create', [TestermonialController::class, 'create'])->name('create-testimonial');
    Route::post('/store', [TestermonialController::class, 'store'])->name('store-testimonial');
    Route::get('/edit/{id}', [TestermonialController::class, 'show'])->name('show-testimonial');
    Route::get('/get-testimonial', [TestermonialController::class, 'getAjaxTestimonialsData'])->name('get-testimonial');
    Route::put('/update-testimonial/{id}', [TestermonialController::class, 'update'])->name('update-testimonial');
    Route::get('/change-status/{id}', [TestermonialController::class, 'activation'])->name('change-status');
    Route::delete('/delete-testimonial/{id}', [TestermonialController::class, 'destroy'])->name('delete-testimonial');
});

require __DIR__.'/auth.php';
