<?php

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


Route::group(['namespace' => 'Admin' ,'prefix' => 'admin'] ,function (){

    Route::group(['namespace' => 'Auth'] ,function (){
        Route::get('login','AuthController@getLogin')->name('admin.login');
        Route::post('login','AuthController@postLogin')->name('admin.login');
        Route::get('logout','AuthController@getLogout')->name('admin.logout');
    });

    Route::group(['middleware'=>['auth:admin'],'as'=>'admin.'],function (){
        Route::get('/','HomeController@index')->name('home');

        Route::get('/settings','SettingController@index')->name('settings.index');
        Route::put('/setting/{setting}','SettingController@update')->name('settings.update');

        Route::get('/profile','ProfileController@index')->name('profile');
        Route::put('/profile/{user}','ProfileController@update')->name('profile.update');

        Route::resource('sliders','SliderController');
        Route::get('/sliders/{slider}/delete','SliderController@destroy')->name('sliders.destroy');

        Route::resource('addresses','AddressController');
        Route::get('/addresses/{address}/delete','AddressController@destroy')->name('addresses.destroy');

        Route::resource('categories','CategoryController');
        Route::get('/categories/{category}/delete','CategoryController@destroy')->name('categories.destroy');

        Route::resource('products','ProductController');
        Route::get('/products/{product}/delete','ProductController@destroy')->name('products.destroy');
        Route::get('/products/delete/image/{image}','ProductController@deleteImage')->name('products.delete-image');
        Route::get('/get/sub-category/{category}','ProductController@getSubCategory')->name('products.getSubCategory');

        Route::resource('tips','TipController');
        Route::get('/tips/{tip}/delete','TipController@destroy')->name('tips.destroy');
        Route::get('/tips/send-live/notification','TipController@getLiveTip')->name('tips.getLiveTip');
        Route::post('/tips/send-live/notification','TipController@sendLiveTip')->name('tips.sendLiveTip');

        Route::get('abouts','AboutController@index')->name('abouts.index');
        Route::put('/abouts/{about}','AboutController@update')->name('abouts.update');

        Route::get('orders','OrderController@index')->name('orders.index');
        Route::get('/orders/{order}/delete','OrderController@destroy')->name('orders.destroy');

        Route::get('utilizes','UtilizeController@index')->name('utilizes.index');
        Route::get('/utilizes/{utilize}/delete','UtilizeController@destroy')->name('utilizes.destroy');

        Route::get('users','UserController@index')->name('users.index');
        Route::get('/users/{user}/delete','UserController@destroy')->name('users.destroy');

        Route::get('contacts','ContactController@index')->name('contacts.index');
        Route::get('/contacts/{contact}/delete','ContactController@destroy')->name('contacts.destroy');
       
        Route::resource('posters','PosterController');
        Route::get('/posters/{poster}/delete','PosterController@destroy')->name('posters.destroy');

        Route::get('/services/users','ServiceController@users')->name('services.users');
        Route::resource('services','ServiceController');
        Route::get('/services/{service}/delete','ServiceController@destroy')->name('services.destroy');
    });

});

