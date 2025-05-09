<?php
/*
 * get countries data
 */
Route::post("get-institute-data", "InstituteController@getData")->name(
    "get_institute_data_from_admin"
);
/*
 * bulk action
 */
Route::post(
    "do-status-change-for-institute/{action?}",
    "InstituteController@statusChange"
)->name("institute_action_from_admin");
/*
 * resource controller
 */
Route::resource("institute", "InstituteController");

Route::post("institute/onboard/{id}", "InstituteController@onboard")->name(
    "institute_onboard_from_admin"
);
