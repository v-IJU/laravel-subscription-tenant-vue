<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\BotmanController;
use App\Http\Controllers\Api\v1\CmsController;
use App\Http\Controllers\Api\v1\RazorpayController;
use cms\websitecms\Controllers\v1\ContactusController;
use GPBMetadata\Google\Api\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Middleware\ApiAi;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// routes for mobileapi auths
Route::post("/login", [AuthController::class, "vuelogin"]);
Route::post("/sendotp", [AuthController::class, "OtpSend"]);
Route::post("/verifyotp", [AuthController::class, "Verifyotp"]);
Route::post("/complete/registration", [
    AuthController::class,
    "ConfirmRegistration",
]);
Route::get("/get/schools", [AuthController::class, "GetSchools"]);

Route::get("/cms/{type?}", [CmsController::class, "cmsPages"]);

Route::middleware("auth:sanctum")->group(function () {
    Route::get("/user", [AuthController::class, "Getuser"]);
    Route::get("/logout", [AuthController::class, "logout"]);
});

//payment gateway
Route::middleware("auth:sanctum")->group(function () {
    Route::post("razorpay/createorder", [
        RazorpayController::class,
        "createOrder",
    ]);

    Route::post("razorpay/verifypay", [RazorpayController::class, "Verifypay"]);
});

Route::match(["get", "post"], "/botman", [BotmanController::class, "index"]);
