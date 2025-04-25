<?php
/*
 * get countries data
 */
Route::post('get-subscription-data','SubscriptionController@getData')->name('get_subscription_data_from_admin');
/*
 * bulk action
 */
Route::post('do-status-change-for-subscription/{action}','SubscriptionController@statusChange')->name('subscription_action_from_admin');
/*
* resource controller
*/
Route::resource('subscription','SubscriptionController');
