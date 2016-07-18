<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Catalog module //

// Index routes...
Route::get('/', 'Catalog\IndexController@index');


// UI routes (Sliders, Banners, Widgets, etc.)


// Catalog routes...
Route::get('catalog/index', 'Catalog\CatalogController@index');
Route::get('catalog/auto/{id?}', 'Catalog\CatalogController@item');

Route::get('menu/{pseudo_url}','Catalog\CatalogController@menu');
Route::get('news/post/{pseudo_url?}','Catalog\CatalogController@news');
Route::get('blog/post/{pseudo_url?}','Catalog\CatalogController@blog');
Route::get('catalog/top-menu','Catalog\CatalogController@getTopMenu');

Route::get('news/','Catalog\CatalogController@news_index');
Route::get('news/{pseudo_url}','Catalog\CatalogController@news_category');
Route::get('blog/','Catalog\CatalogController@blog_index');
Route::get('blog/{id}','Catalog\CatalogController@blog_category');

Route::post('news/last','Catalog\CatalogController@getLastContent');
Route::post('blog/last','Catalog\CatalogController@getLastContent');

// partners route (ajax call)
Route::get('partners','Admin\UIComponentsController@getPartners');

// feedbacks route (ajax call)
Route::get('feedbacks','Admin\ContentController@getFeedbacks');

// Admin module //

// Index route...
Route::get('admin/index', ['middleware' => 'auth', 'uses' => 'Admin\IndexController@index']);

// Filters routes...
Route::post('filter/ajax', 'Admin\FiltersController@getJSONByName');
Route::get('admin/filters', ['middleware' => 'auth', 'uses' => 'Admin\FiltersController@index']);
Route::get('admin/filter/{id}', ['middleware' => 'auth', 'uses' => 'Admin\FiltersController@filter']);
//Route::post('admin/filter/{name}', 'Admin\FiltersController@update');
Route::post('admin/filter/{id?}', ['middleware' => 'auth', 'uses' => 'Admin\FiltersController@update']);
Route::get('admin/filters/add', ['middleware' => 'auth', 'uses' => 'Admin\FiltersController@add']);
Route::get('admin/filters/delete/{id}', ['middleware' => 'auth', 'uses' => 'Admin\FiltersController@delete']);

Route::get('admin/filters/names', 'Admin\FiltersController@getJSONNames');

// Items routes...
Route::get('admin/items', ['middleware' => 'auth', 'uses' => 'Admin\ItemsController@index']);
Route::get('admin/items/add/{type}', ['middleware' => 'auth', 'uses' => 'Admin\ItemsController@add']);
Route::get('admin/items/show/{id?}', ['middleware' => 'auth', 'uses' => 'Admin\ItemsController@show']);
Route::get('admin/items/delete/{id?}', ['middleware' => 'auth', 'uses' => 'Admin\ItemsController@delete']);
Route::post('admin/items/update', ['middleware' => 'auth', 'uses' => 'Admin\ItemsController@update']);
Route::post('admin/get/items/{limit?}', 'Admin\ItemsController@getItemsObj');
Route::post('admin/items/update/images', ['middleware' => 'auth', 'uses' => 'Admin\ItemsController@updateImages']);

// Specifications routes...
Route::post('specifications/ajax', 'Admin\SpecificationsController@getJSONByName');
Route::get('admin/specifications', ['middleware' => 'auth', 'uses' => 'Admin\SpecificationsController@index']);
Route::get('admin/specification/{id}', ['middleware' => 'auth', 'uses' => 'Admin\SpecificationsController@specification']);
Route::get('admin/specifications/add/{id}', ['middleware' => 'auth', 'uses' => 'Admin\SpecificationsController@add']);
Route::get('admin/specifications/json', 'Admin\SpecificationsController@getJSONspecifications');
Route::post('admin/specifications/update', ['middleware' => 'auth', 'uses' => 'Admin\SpecificationsController@update']);
Route::get('admin/specifications/delete/{id}', ['middleware' => 'auth', 'uses' => 'Admin\SpecificationsController@delete']);

// Content routes...
Route::get('admin/content/{type}', ['middleware' => 'auth', 'uses' => 'Admin\ContentController@index']);
Route::get('admin/content/add/{type}', ['middleware' => 'auth', 'uses' => 'Admin\ContentController@add']);
Route::get('admin/content/show/main', ['middleware' => 'auth', 'uses' => 'Admin\ContentController@showMainPage']);
Route::get('admin/content/show/{id?}', ['middleware' => 'auth', 'uses' => 'Admin\ContentController@show']);
Route::get('admin/content/delete/{id}', ['middleware' => 'auth', 'uses' => 'Admin\ContentController@delete']);
Route::post('admin/content/update', ['middleware' => 'auth', 'uses' => 'Admin\ContentController@update']);

//Mail rotes
Route::post('mail/index', 'Catalog\MailController@index');

// Banners and Sliders routes...
Route::get('admin/ui-components/show/{name}', ['middleware' => 'auth', 'uses' => 'Admin\UIComponentsController@show']);
Route::post('admin/ui-components/update', ['middleware' => 'auth', 'uses' => 'Admin\UIComponentsController@update']);


// Authentication routes...
Route::get('admin/login', 'Auth\AuthController@getLogin');
Route::post('admin/login', 'Auth\AuthController@postLogin');
Route::get('admin/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/login', function(){return \Redirect::action('Auth\AuthController@getLogin');});
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Settings routes..
// _service files
Route::get('admin/settings/servicefiles', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@serviceFiles']);
Route::get('admin/settings/servicefiles/add', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@addServiceFile']);
Route::post('admin/settings/servicefiles/update', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@updateServiceFile']);
Route::get('admin/settings/servicefiles/delete/{id}', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@deleteServiceFile']);

//    _counters
Route::get('admin/settings/counters', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@counters']);
Route::get('admin/settings/calc', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@calc']);
Route::get('admin/settings/counters/add', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@addCounter']);
Route::get('admin/settings/counters/show/{id}', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@showCounter']);
Route::post('admin/settings/counters/update', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@updateCounter']);
Route::get('admin/settings/counters/delete/{id}', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@deleteCounter']);

//    _phones
Route::get('admin/settings/phones', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@phones']);
Route::get('admin/settings/phones/add', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@addPhone']);
Route::post('admin/settings/phones/add', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@insertPhone']);
Route::get('admin/settings/phones/delete/{id}', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@deletePhone']);

//    _currencies
Route::get('admin/settings/currencies', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@currencies']);
Route::get('admin/settings/currencies/add', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@addCurrency']);
Route::get('admin/settings/currencies/show/{id?}', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@showCurrency']);
Route::get('admin/settings/currencies/delete/{id}', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@deleteCurrency']);
Route::post('admin/settings/currencies/update', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@updateCurrency']);
Route::post('admin/settings/currencies/default/update', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@updateDefaultCurrency']);

Route::post('admin/settings/currencies/getCurrencies', 'Admin\SettingsController@getCurrencies');

//    _email
Route::get('admin/settings/email', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@email']);
Route::get('admin/settings/email/add', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@addEmail']);
Route::get('admin/settings/email/show/{id?}', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@showEmail']);
Route::get('admin/settings/email/delete/{id}', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@deleteEmail']);
Route::post('admin/settings/email/update', ['middleware' => 'auth', 'uses' => 'Admin\SettingsController@updateEmail']);
