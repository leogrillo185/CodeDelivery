<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=> 'admin', 'middleware' => 'auth.checkrole:admin' , 'as' => 'admin.'], function(){

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

    Route::group(['prefix' => 'cupoms', 'as' => 'cupoms'], function() {
        Route::get('', ['as' => '', 'uses' => 'CupomsController@index']);
        Route::get('create', ['as' => '.create', 'uses' => 'CupomsController@create']);
        Route::post('store', ['as' => '.store', 'uses' => 'CupomsController@store']);
        Route::get('edit/{id}', ['as' => '.edit', 'uses' => 'CupomsController@edit']);
        Route::post('update/{id}', ['as' => '.update', 'uses' => 'CupomsController@update']);
        Route::get('destroy/{id}', ['as' => '.destroy', 'uses' => 'CupomsController@destroy']);
    });

});

Route::group(['prefix' => 'customers', 'middleware' => 'auth.checkrole:client', 'as' => 'customers.'], function(){
    Route::get('orders', ['as' => 'orders.index', 'uses' => 'CheckoutController@index']);
    Route::get('orders/create', ['as' => 'orders.create', 'uses' => 'CheckoutController@create']);
    Route::post('orders/store', ['as' => 'orders.store', 'uses' => 'CheckoutController@store']);
});

Route::group(['middleware' => 'cors'], function(){

    Route::post('oauth/access_token', function() {
        return Response::json(Authorizer::issueAccessToken());
    });

    Route::group(['prefix' => 'api', 'middleware' => 'oauth', 'as' => 'api.'], function(){


        Route::get('authenticated', ['as' => 'authenticated', 'uses' => 'UsersController@authenticated']);

        Route::group(['prefix' => 'client', 'middleware' => 'oauth.checkrole:client', 'as' => 'client.'], function(){
            Route::resource(
                'order',
                'Api\Client\ClientCheckoutController',
                ['except'=> ['create', 'edit', 'destroy']
                ]);
            Route::get('products', 'Api\Client\ClientProductController@index');
        });

        Route::group(['prefix' => 'deliveryman', 'middleware' => 'oauth.checkrole:deliveryman', 'as' => 'deliveryman.'], function(){
            Route::resource(
                'order',
                'Api\Deliveryman\DeliverymanCheckoutController',
                ['except'=> ['create', 'edit', 'destroy', 'store']
                ]);

            Route::patch(
                'order/{id}/update-status',[
                    'uses' => 'Api\Deliveryman\DeliverymanCheckoutController@updateStatus',
                    'as' => 'orders.update_status'
                ]
            );

            Route::post('order/{id}/geo', [
                'as' => 'orders.geo',
                'uses' => 'Api\Deliveryman\DeliverymanCheckoutController@geo'
            ]);
        });

        Route::get('cupom/{code}', 'Api\CupomController@show');

    });
});

