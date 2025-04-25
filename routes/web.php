<?php

use App\Http\Controllers\Frontend\WebsiteController;
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

//for frontend routes

// customers route

//Language Translation
Route::get("index/{locale}", [
    App\Http\Controllers\HomeController::class,
    "lang",
]);

Route::get("/{any}", [WebsiteController::class, "index"]);
Route::get("/", [WebsiteController::class, "index"])->name("home");

Route::group(
    ["prefix" => "laravel-filemanager", "middleware" => ["web", "auth"]],
    function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    }
);
