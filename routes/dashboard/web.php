<?php

// use Illuminate\Routing\Route;

use Illuminate\Support\Facades\Route;
 use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
        [
            'prefix' => LaravelLocalization::setLocale(),
            'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
        ], function(){
             Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {

                Route::get('/index', 'DashboardController@index')->name('index');

                //category Routes
                Route::resource('categories', 'CategoryController')->except(['show']);

                //products Routes
                Route::resource('products', 'ProductController')->except(['show']);

                //client Routes
                Route::resource('clients', 'ClientController')->except(['show']);
                Route::resource('client.orders', 'client\OrderController')->except(['show']);


                //order Routes
                Route::resource('orders', 'OrderControllers');
                Route::get('/orders/{order}/products', 'OrderControllers@products')->name('orders.products');

                    //user Routes
                Route::resource('users', 'UserController')->except(['show']);


            });

        });






