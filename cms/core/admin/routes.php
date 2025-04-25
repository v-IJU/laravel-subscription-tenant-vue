<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        "prefix" => "administrator",
        "middleware" => ["web"],
        "namespace" => "cms\core\admin\Controllers",
    ],
    function () {
        /*
         * backend login
         */
        Route::get("login", "AdminAuth@login")->name("backendlogin");
        /*
         * do back end login
         */
        Route::post("dologin", "AdminAuth@dologin")->name("dobackendlogin");

        //vuew js components routes
        Route::get(
            "getdashboarddata/{type?}",
            "AdminAuth@getdashboarddata"
        )->name("DashboardData");
    }
);

Route::get("/", "AdminAuth@dashboard")->name("backenddashboard");
