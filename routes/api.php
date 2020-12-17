<?php

Route::group(['namespace' => 'Api'] ,function (){
    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', 'AuthController@register')->name('api.register');
        Route::post('login', 'AuthController@login');
        Route::post('socialLogin', 'AuthController@socialLogin');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('reset-password', 'AuthController@reset');
        Route::post('check-code', 'AuthController@checkCode');
    });
    Route::group(['middleware'=>['auth:api']],function (){
        Route::group(['prefix' => 'account'], function () {
            Route::get('/me','ProfileController@me');
            Route::post('/update','ProfileController@update')->name('api.account.update');
            Route::post('/update-password','ProfileController@updatePassword');
            Route::post('/update-password-by-code','ProfileController@updatePasswordByCode');
            Route::post('/update-device-token','ProfileController@updateDeviceToken');
            Route::get('/my-favorites','ProfileController@myFavorites');
            Route::post('/favorite/{product}','ProfileController@favorite');

            Route::get('/my-orders','ProfileController@myOrders');
            Route::get('/my-orders/{order}','ProfileController@singleOrder');
            Route::post('/add-order/{product}','ProfileController@addOrder');

            Route::get('/my-utilizes','ProfileController@myUtilizes');
        });
        Route::get('/notifications','ProfileController@tipsNotifications');
        Route::get('/read-all-notifications','ProfileController@readAllNotifications');
        Route::get('/notifications/{id}','ProfileController@readNotification');

        Route::group(['prefix' => 'utilizes'], function () {
            Route::post('/add','UtilizeController@store');
            Route::post('/update/{utilize}','UtilizeController@update');
            Route::delete('/delete/{utilize}','UtilizeController@destroy');
        });
        
        Route::get('/available-services','UserServiceController@availableServices');
        Route::group(['prefix' => 'user-services'], function () {
            Route::get('/','UserServiceController@index');
            Route::post('/update','UserServiceController@update');
        });

        Route::group(['prefix' => 'user-works'], function () {
            Route::get('/','UserWorkController@index');
            Route::post('/create','UserWorkController@store');
            Route::post('/update/{work}','UserWorkController@update');
            Route::delete('/delete/{work}','UserWorkController@destroy');
        });
    });
    Route::get('/sliders','HomeController@sliders');
    Route::get('/last-products','HomeController@lastProducts');
    Route::get('/tips','HomeController@tips');
    Route::get('/about-us','AboutController@index');
    Route::get('/setting','HomeController@setting');
    Route::post('/insertToken','HomeController@insertToken');

    Route::get('/categories','StoreController@index');
    Route::get('/categories/{category}','StoreController@singleCategory');

    Route::get('/addresses','AddressController@index');
    Route::get('/addresses/{address}','AddressController@singleAddress');

    Route::get('/posters','PosterController@index');
    Route::get('/posters/{poster}','PosterController@singlePoster');

    Route::get('/products','StoreController@allProducts');
    Route::get('/products/getProductsByIds','StoreController@getProductsByIds');
    Route::get('/products/{product}','StoreController@singleProduct');
    Route::get('/product-search','StoreController@productsSearch');
    Route::get('/utilizes','UtilizeController@index');
    Route::get('/utilizes/{utilize}','UtilizeController@singleUtilize');
    Route::get('/utilize-search','UtilizeController@utilizesSearch');
    Route::get('/user/{user}/utilizes','UtilizeController@userUtilizes');

    Route::post('/contact-us','ContactController@store');
});
