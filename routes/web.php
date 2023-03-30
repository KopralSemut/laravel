<?php

use App\Http\Controllers\BookController;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;

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
    return view('auth.login');
})->middleware('guest');

Auth::routes();
Route::match (["GET", "POST"], "/register", function () {
    return redirect("/login");
})->name("register");

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource("users", UserController::class,)->middleware('auth');

Route::get('/categories/trash',[CategoryController::class,'trash'])->name('categories.trash')->middleware('auth');

Route::resource('categories', CategoryController::class)->middleware('auth');

Route::get('/categories/{id}/restore',[CategoryController::class,'restore'])->name('categories.restore')->middleware('auth');

Route::post('/books/{book}/restore',[BookController::class,'restore'])->name('books.restore')->middleware('auth');


Route::delete('/categories/{category}/delete-permanent',[CategoryController::class,'deletePemanent'])->name('categories.delete-permanent')->middleware('auth');
Route::get('/books/trash',[BookController::class,'trash'])->name('books.trash')->middleware('auth');
Route::delete('/books/{id}/delete-permanent',[BookController::class,'deletePermanent'])->name('books.delete-permanent')->middleware('auth');
Route::resource('books', BookController::class)->middleware('auth');

Route::get('ajax/categories/search',[CategoryController::class,'ajaxSearch']);

Route::resource('orders', OrderController::class)->middleware('auth');
