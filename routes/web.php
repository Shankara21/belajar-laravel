<?php

use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardPostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/', function () {
    return view('welcome', [
        "title" => "Home",
        "active" => 'home',
    ]);
});
Route::get('/about', [PostController::class, 'about']);
Route::get('/blog', [PostController::class, 'index']);

Route::get('/categories', [PostController::class, 'categories']);

// Halaman Single Post
// ! contoh penggunaan route model binding dimana dalam route dibawah ini kita menggunakan slug 
Route::get('/post/{post:slug}', [PostController::class, 'show']);


// ! untuk melihat middleware bisa di lihat di file kernel
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');

Route::post('/register', [RegisterController::class, 'store']);

Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth');

Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth');

Route::get('/dashboard/categories/checkSlug', [AdminCategoryController::class, 'checkSlug'])->middleware('auth');

Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');

Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show');

Route::resource('/dashboard/users', AdminUserController::class)->middleware('auth');
