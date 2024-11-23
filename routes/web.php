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
Route::get('/auth/signup', action: [AuthController::class, 'signup']);
Route::post('/auth/register', action: [AuthController::class, 'register']);
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

Route::resource('articles', ArticleController::class);

Route::post('/comment', [CommentController::class, 'store']);
Route::get('/comment/{id}/edit', [CommentController::class, 'edit']);
Route::post('/comment/{comment}/update', [CommentController::class, 'update']);
Route::get('/comment/{id}/delete', [CommentController::class, 'delete']);

Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/authenticate', [AuthController::class, 'authenticate']);
Route::get('/auth/logout', [AuthController::class, 'logout']);