<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'UsersController@getIndex');


Route::post('form', array('before'=>'csrf', 'as' => 'form',
    'uses' => 'UsersController@Record'
));

Route::get('admin/self/regstr/here/auth', 'UsersController@admin');
Route::post('my', array('before'=>'csrf', 'as' => 'my',
    'uses' => 'UsersController@postLogin'
));


Route::group(array('before' => 'manager'), function () {
    Route::get('users/newManager', 'UsersController@newManager');

    Route::get('users/showManagers', 'UsersController@showManagers');
    Route::group(array('before' => 'csrf'), function () {
    Route::post('manager', array('as' => 'manager',
        'uses' => 'UsersController@managerRecord'
    ));
    Route::get('users/shadow{id}', array('as' => 'shadow', 'uses' => 'UsersController@shadow'));

    Route::get('users/showManagers{manager}', array('as' => 'managerDelete', 'uses' => 'UsersController@managerDelete'));
    Route::post('users/managerChange', array('as' => 'managerChange', 'uses' => 'UsersController@managerChange'));
    Route::post('users/showManagers{modelManager}', array('as' => 'users/showManagers',
        'uses' => 'UsersController@useManagerChange'
    ));
    Route::get('searchManager', array('uses' => 'UsersController@ajaxSearchManagers'));
    });
});

Route::group(array('before' => 'users'), function ()
{
   Route::get('users/indexDelete{client}', array('as' => 'clientDelete', 'uses' => 'UsersController@clientDestroy'));

    Route::get('users/index', array('as' => 'users/index',
        'uses' => 'UsersController@clients'));
    Route::get('orders/index', array('as' => 'orders/index',
        'uses' => 'OrdersController@orders'));
    Route::get('services/index', 'ServicesController@create');
    Route::get('cities/index', 'CitiesController@create');
    Route::get('orders/index', array('as' => 'sortOrder', 'uses' => 'OrdersController@Orders'));
    Route::get('users/index{id}', array('as' => 'sortClient', 'uses' => 'UsersController@Clients'));
    Route::get('orders/statistics', array('as' => 'orders/statistics', 'uses' => 'OrdersController@statistics'));
    Route::get('users/clientRecord', 'UsersController@newClientCreate');
    Route::get('orders/orderRecord', 'OrdersController@newOrderCreate');

    Route::group(['as' => 'su', 'domain' => '{city}.public'], function ()
    {
        Route::get('admin', 'UsersController@admin');
    });

    Route::group(array('before' => 'csrf'), function ()
    {

    Route::get('shadow', array('as' => 'shadowDelete', 'uses' => 'UsersController@shadowDelete'));

     Route::post('services/index', array('as' => 'services/index',
        'uses' => 'ServicesController@store'
    ));

    Route::post('cities/index', array('as' => 'cities/index',
        'uses' => 'CitiesController@store'
    ));

    Route::post('record', array('as' => 'record',
        'uses' => 'UsersController@clientRecord'
    ));
    Route::post('recorder', array('as' => 'recorder',
        'uses' => 'OrdersController@orderRecord'
    ));

    Route::get('orders/delete', array('as' => 'orderDelete', 'uses' => 'OrdersController@orderDestroy'));

    Route::post('orders/orderChange', array('as' => 'orderChange', 'uses' => 'OrdersController@orderChange'));
    Route::post('users/clientChange', array('as' => 'clientChange', 'uses' => 'UsersController@clientChange'));

    Route::post('orders/index{modelOrder}', array('as' => 'orders/index',
        'uses' => 'OrdersController@useOrderChange'
    ));
    Route::post('users/index{model}', array('as' => 'users/index',
        'uses' => 'UsersController@useClientChange'
    ));

    Route::get('search', array('uses' => 'OrdersController@ajaxSearchClientsOrOrders'));

    Route::any('orders/chart', array('as' => 'chart', 'uses' => 'OrdersController@pyramid'));

    Route::post('exit', array('as' => 'exit', 'uses' => 'UsersController@getLogout'));

    });
});

