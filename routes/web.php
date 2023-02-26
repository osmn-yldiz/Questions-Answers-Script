<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::group(['namespace' => 'front'], function () {

    Route::get("/", [App\Http\Controllers\front\indexController::class, 'index'])->name('index');
    Route::get('/cevaplanmis', [App\Http\Controllers\front\indexController::class, 'cevaplanmis'])->name('cevaplanmis');
    Route::get('/cozumlenmis', [App\Http\Controllers\front\indexController::class, 'cozumlenmis'])->name('cozumlenmis');

    Route::group(['namespace' => 'question', 'as' => 'question.', 'prefix' => 'soru', 'middleware' => ['auth']], function () {
        Route::get("/sor", [App\Http\Controllers\front\question\indexController::class, 'create'])->name("create");
        Route::post("/sor", [App\Http\Controllers\front\question\indexController::class, 'store'])->name("store");

        Route::get("/duzenle/{id}", [App\Http\Controllers\front\question\indexController::class, 'edit'])->name('edit');
        Route::post("/duzenle/{id}", [App\Http\Controllers\front\question\indexController::class, 'update'])->name('update');

        Route::get("/sil/{id}", [App\Http\Controllers\front\question\indexController::class, 'delete'])->name("delete");
    });

    Route::get("/{id}/{selflink}", [App\Http\Controllers\front\indexController::class, 'view'])->name("view")->middleware(['VisitorUser']);

    Route::group(['namespace' => 'comment', 'as' => 'comment.', 'prefix' => 'comment', 'middleware' => ['auth']], function () {
        Route::post("/store/{id}", [App\Http\Controllers\front\comment\indexController::class, 'store'])->name("store");
        Route::get("/like/{id}", [App\Http\Controllers\front\comment\indexController::class, 'likeOrDislike'])->name("likeordislike");
        Route::get("/delete/{id}", [App\Http\Controllers\front\comment\indexController::class, 'delete'])->name("delete");
        Route::get("/correct/{id}", [App\Http\Controllers\front\comment\indexController::class, 'correct'])->name("correct");
    });

    Route::group(['namespace' => 'category', 'as' => 'category.', 'prefix' => 'kategori'], function () {
        Route::get("/{selflink}", [App\Http\Controllers\front\category\indexController::class, 'index'])->name("index");
    });

    Route::group(['namespace' => 'settings', 'as' => 'settings.', 'prefix' => 'ayarlar', 'middleware' => ['auth']], function () {
        Route::get('/', [App\Http\Controllers\front\settings\indexController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\front\settings\indexController::class, 'store'])->name('store');

        Route::get('/bildirimler', [App\Http\Controllers\front\settings\indexController::class, 'notifications'])->name('notifications');

        Route::get('/password', [App\Http\Controllers\front\settings\indexController::class, 'password'])->name('password');
        Route::post('/password', [App\Http\Controllers\front\settings\indexController::class, 'passwordStore'])->name('passwordStore');
    });

    Route::group(['namespace' => 'user', 'as' => 'user.', 'prefix' => 'kullanici'], function () {
        Route::get('/hepsi', [App\Http\Controllers\front\user\indexController::class, 'all'])->name('all');
        Route::get('/{id}', [App\Http\Controllers\front\user\indexController::class, 'index'])->name('index');

    });

    Route::group(['namespace' => 'search', 'as' => 'search.', 'prefix' => 'ara'], function () {
        Route::get('/', [App\Http\Controllers\front\search\indexController::class, 'index'])->name('index');
    });

    Route::group(['namespace' => 'save', 'as' => 'save.', 'prefix' => 'kaydet', 'middleware' => ['auth']], function () {
        Route::get('/', [App\Http\Controllers\front\save\indexController::class, 'index'])->name('index');
        Route::get('/soru/{id}', [App\Http\Controllers\front\save\indexController::class, 'store'])->name('store');
    });

    Route::group(['namespace' => 'tags', 'as' => 'tags.', 'prefix' => 'etiket'], function () {
        Route::get('/', [App\Http\Controllers\front\tags\indexController::class, 'index'])->name('index');
        Route::get('/goruntule/{selflink}', [App\Http\Controllers\front\tags\indexController::class, 'view'])->name('view');
    });

});
