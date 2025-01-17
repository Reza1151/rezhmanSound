<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SlideController;

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
Route::prefix('admin')->group(function (){
    Route::get('/login',[LoginController::class,'Index'])->name('login-form');
    Route::get('/register',[RegisterController::class,'Register'])->name('register-form');
    Route::post('/login/owner',[LoginController::class,'Login'])->name('admin.login');
    Route::get('/dashboard',[AdminController::class,'Dashboard'])->name('admin.dashboard')->middleware('admin');
    Route::post('logout', [LoginController::class, 'Logout'])->name('admin-logout');
    Route::post('/register/owner', [RegisterController::class, 'Registertion'])->name('registertion');

    Route::get('/categories/add',[CategoryController::class,'create'])->name('add.category');
    Route::post('/categories/store',[CategoryController::class,'store'])->name('store.category');
    Route::get('/categories/{id}/edit',[CategoryController::class,'edit'])->name('edit.category');
    Route::Patch('/categories/update/{id}',[CategoryController::class,'update'])->name('update.category');
    Route::get('/categories/index',[CategoryController::class,'index'])->name('index.category');
    Route::get('/categories/delete/{id}',[CategoryController::class,'delete'])->name('delete.category');

    Route::get('/slides/index',[SlideController::class,'index'])->name('index.slide');
    Route::post('/slides/{id}/destroy',[SlideController::class,'destroy'])->name('delete.slide');


    Route::get('/password/forgot',[LoginController::class,'showForgotForm'])->name('forgot-password-form');
    Route::get('/password/reset/{token}',[LoginController::class,'showResetForm'])->name('reset-password-form');
    Route::post('/link/reset',[LoginController::class,'sendLink'])->name('send-link-reset');




});
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
});

require __DIR__.'/auth.php';
