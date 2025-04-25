<?php
/*
 * get countries data
 */
Route::post("get-websitecms-data", "WebsitecmsController@getData")->name(
    "get_websitecms_data_from_admin"
);
/*
 * bulk action
 */
Route::post(
    "do-status-change-for-websitecms/{action?}",
    "WebsitecmsController@statusChange"
)->name("websitecms_action_from_admin");

/*
 * get countries data
 */
Route::post("get-websitecms-service-data", "ServiceController@getData")->name(
    "get_websitecms_service_data_from_admin"
);
/*
 * bulk action
 */
Route::post(
    "do-status-change-for-websitecms-service/{action?}",
    "ServiceController@statusChange"
)->name("websitecms_service_action_from_admin");

Route::post(
    "get-websitecms-industries-data",
    "IndustriesController@getData"
)->name("get_websitecms_industries_data_from_admin");
/*
 * bulk action
 */
Route::post(
    "do-status-change-for-websitecms-industries/{action?}",
    "IndustriesController@statusChange"
)->name("websitecms_industries_action_from_admin");
/*
 * resource controller
 */
Route::resource("websitecms", "WebsitecmsController");
Route::resource("service", "ServiceController");
Route::resource("industries", "IndustriesController");
Route::resource("feedback", "FeedbackController");
Route::resource("associator", "AssociatorController");
Route::resource("aboutusshop", "AboutusShopController");
Route::resource("contactus", "ContactusController");
Route::resource("address", "ContactusController");


Route::post("update_feedback", "FeedbackController@update")->name(
    "update_feedback"
);

Route::post("update_industry", "IndustriesController@update")->name(
    "update_industry"
);

Route::post(
    "get-websitecms-feedback-data",
    "FeedbackController@getData"
)->name("get_websitecms_feedback_data_from_admin");
/*
 * bulk action
 */
Route::post(
    "do-status-change-for-websitecms-feedback/{action?}",
    "FeedbackController@statusChange"
)->name("websitecms_feedback_action_from_admin");

Route::post("update_feedback", "FeedbackController@update")->name(
    "update_feedback"
);


Route::post(
    "get-websitecms-associator-data",
    "AssociatorController@getData"
)->name("get_websitecms_associator_data_from_admin");
/*
 * bulk action
 */
Route::post(
    "do-status-change-for-websitecms-associator/{action?}",
    "AssociatorController@statusChange"
)->name("websitecms_associator_action_from_admin");

Route::post("update_associator", "AssociatorController@update")->name(
    "update_associator"
);


Route::post(
    "get-websitecms-aboutusshop-data",
    "AboutusShopController@getData"
)->name("get_websitecms_aboutusshop_data_from_admin");
/*
 * bulk action
 */
Route::post(
    "do-status-change-for-websitecms-aboutusshop/{action?}",
    "AboutusShopController@statusChange"
)->name("websitecms_aboutusshop_action_from_admin");

Route::post("update_aboutusshop", "AboutusShopController@update")->name(
    "update_aboutusshop"
);

Route::post(
    "get-websitecms-contactus-data",
    "ContactusController@getData"
)->name("get_contact_us_data_from_admin");




