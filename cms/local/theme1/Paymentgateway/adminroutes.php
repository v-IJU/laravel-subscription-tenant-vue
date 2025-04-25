<?php
/*
 * get countries data
 */
Route::post(
    "get-paymentgateway-data",
    "PaymentgatewayController@getData"
)->name("get_paymentgateway_data_from_admin");
/*
 * bulk action
 */
Route::post(
    "do-status-change-for-paymentgateway/{action?}",
    "PaymentgatewayController@statusChange"
)->name("paymentgateway_status_change_from_admin");
/*
 * resource controller
 */
Route::resource("paymentgateway", "PaymentgatewayController");
