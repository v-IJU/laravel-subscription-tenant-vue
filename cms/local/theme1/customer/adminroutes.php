<?php
/*
 * get countries data
 */
Route::post('get-customer-data','CustomerController@getData')->name('get_customer_data_from_admin');
/*
 * bulk action
 */
Route::post('do-status-change-for-customer/{action}','CustomerController@statusChange')->name('customer_action_from_admin');
/*
* resource controller
*/
Route::resource('customer','CustomerController');
