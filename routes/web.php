<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', action: [MainController::class, 'index']);
Route::get('/gallery/{img}/{name}', function ($img, $name) {
    return view('main.gallery', ['img' => $img, 'name' => $name]);
});
Route::get('/about', function () {
    return view('main.about');
});
Route::get('/contacts', function () {
    $data = [
        'city' => 'Moscow',
        'street' => 'Semenovskaya',
        'house' => 38,
    ];
    return view('main.contact', ['data' => $data]);
});

Route::resource('articles', ArticleController::class)->middleware('auth:sanctum');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show')->middleware('checkclick');


Route::controller(CommentController::class)->prefix('/comment')->middleware('auth:sanctum')->group( function() {
    Route::post('', 'store')->name('comment.store');
    Route::get('/{id}/edit', 'edit')->name('comment.edit');
    Route::post('/{comment}/update', 'update')->name('comment.update');
    Route::get('/{id}/delete','delete')->name('comment.delete');
    Route::get('/index', 'index')->name('comments.index');
    Route::get('/{comment}/accept', 'accept')->name('comment.accept');
    Route::get('/{comment}/reject', 'reject')->name('comment.reject');
});

Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/authenticate', [AuthController::class, 'authenticate']);
Route::get('/auth/logout', [AuthController::class, 'logout']);
Route::get('/auth/signup', action: [AuthController::class, 'signup']);
Route::post('/auth/register', action: [AuthController::class, 'register']);