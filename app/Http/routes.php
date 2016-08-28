<?php

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix'=> 'admin', 'middleware' => 'auth.checkrole' , 'as' => 'admin.'], function(){

    Route::group(['prefix' => 'categories', 'as' => 'categories'], function(){
        Route::get('', ['as' => '', 'uses' => 'CategoriesController@index']);
        Route::get('create', ['as'=>'.create', 'uses' => 'CategoriesController@create']);
        Route::post('store', ['as'=>'.store', 'uses' => 'CategoriesController@store']);
        Route::get('edit/{id}', ['as'=>'.edit', 'uses' => 'CategoriesController@edit']);
        Route::post('update/{id}', ['as'=>'.update', 'uses' => 'CategoriesController@update']);
    });

    Route::group(['prefix' => 'products', 'as' => 'products'], function() {
        Route::get('', ['as' => '', 'uses' => 'ProductsController@index']);
        Route::get('create', ['as' => '.create', 'uses' => 'ProductsController@create']);
        Route::post('store', ['as' => '.store', 'uses' => 'ProductsController@store']);
        Route::get('edit/{id}', ['as' => '.edit', 'uses' => 'ProductsController@edit']);
        Route::post('update/{id}', ['as' => '.update', 'uses' => 'ProductsController@update']);
        Route::get('destroy/{id}', ['as' => '.destroy', 'uses' => 'ProductsController@destroy']);
    });

    Route::group(['prefix' => 'clients', 'as' => 'clients'], function() {
        Route::get('', ['as' => '', 'uses' => 'ClientsController@index']);
        Route::get('create', ['as' => '.create', 'uses' => 'ClientsController@create']);
        Route::post('store', ['as' => '.store', 'uses' => 'ClientsController@store']);
        Route::get('edit/{id}', ['as' => '.edit', 'uses' => 'ClientsController@edit']);
        Route::post('update/{id}', ['as' => '.update', 'uses' => 'ClientsController@update']);
        Route::get('destroy/{id}', ['as' => '.destroy', 'uses' => 'ClientsController@destroy']);
    });

    Route::group(['prefix' => 'orders', 'as' => 'orders'], function() {
        Route::get('', ['as' => '', 'uses' => 'OrdersController@index']);
        Route::get('edit/{id}', ['as' => '.edit', 'uses' => 'OrdersController@edit']);
        Route::post('update/{id}', ['as' => '.update', 'uses' => 'OrdersController@update']);
    });

});

