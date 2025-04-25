<?php
/*
 * get countries data
 */
Route::post("get-product-data", "ProductController@getData")->name(
    "get_product_data_from_admin"
);
/*
 * bulk action
 */
Route::post(
    "do-status-change-for-product/{action}",
    "ProductController@statusChange"
)->name("product_status_change_action_from_admin");

Route::any("action/{action?}", "ProductController@statusChange")->name(
    "get_statuschange_action_from_admin"
);

Route::post(
    "do-status-change-for-product/{action?}",
    "ProductController@statusChange"
)->name("product_action_from_admin");
/*
 * resource controller
 */
Route::resource("product", "ProductController");

//Route::resource('product', 'ProductController')->only(['index', 'create', 'show', 'edit', 'update', 'destroy']);

Route::post(
    "/filter-sizecategory",
    "ProductController@filterCategoryList"
)->name("product.filtercategorylist");

Route::post("/filter-size", "ProductController@filterSizeList")->name(
    "product.filtersizelist"
);

Route::post("/filter-color", "ProductController@filterColorList")->name(
    "product.filtercolorlist"
);

// ajax call to register new product
Route::post("/product-new/create", "ProductController@store")->name(
    "product.newproduct"
);

// load clone edit page
Route::get("/product/create/{id}", "ProductController@cloneEdit")->name(
    "product.clone"
);

// ajax call to register duplicate product
Route::post("/product-duplicate/create", "ProductController@cloneStore")->name(
    "product.duplicateproduct"
);

Route::get("/filemanager/store", "ProductController@fileManagerStore")->name(
    "product.filemanager"
);
Route::any("import/product", "ProductController@import")->name(
    "product.import"
);
