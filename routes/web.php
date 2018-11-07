<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', ['as' => 'home', 'uses' => 'PagesController@index']);

Route::get('search', 'PagesController@search');

Route::get('command/postCSV', 'PagesController@command');

Route::middleware(['auth'])->group(function () {
    Route::get('/p/add', ['as' => 'createPost', 'uses' => 'PostsController@create']);
    Route::post('/p/add', 'PostsController@store');

    //user control panel
    Route::get('/u/preferences', ['as' => 'userPreferences', 'uses' => 'UsersController@preferences']);
    Route::post('/u/preferences', ['as' => 'userPreferencesEdit', 'uses' => 'UsersController@preferencesProcess']);

    // maybe need to change, to direct the user to where they have interest
    Route::get('/u/messages', ['as' => 'userMessages', 'uses' => 'UsersController@inMessages']);


    Route::get('/u/messages/in', ['as' => 'userInMessages', 'uses' => 'UsersController@inMessages']);
    Route::get('/u/messages/in/{offer_id}', ['as' => 'userInMessagesDialog', 'uses' => 'UsersController@inMessagesDialog']);
    Route::post('/u/messages/in/{offer_id}', ['as' => 'userInMessagesPost', 'uses' => 'UsersController@inMessagesPost']);
    Route::get('/u/messages/out', ['as' => 'userOutMessages', 'uses' => 'UsersController@messages']);

    Route::get('/u/my_offers', ['as' => 'myOffers', 'uses' => 'UsersController@myOffers']);

    Route::post('/p/offer/{post_id}', ['as'  => 'postOffer', 'uses'  => 'PostsController@offer'])->middleware('valid_post');

    // AJAX for only autentecated users
    Route::get('/ajax/category', 'AjaxController@subCategory');
    Route::get('/ajax/district', 'AjaxController@subDistrict');
});

// for check valid post and belongs to the authentecated user
Route::middleware(['auth', 'valid_post', 'post_owned_by_user'])->group(function () {
    Route::get('/p/add/info/{post_id}', [ 'as' => 'addInfo', 'uses' => 'PostsController@addInfo' ]);
    Route::post('/p/add/info/{post_id}', 'PostsController@store');

    Route::get('/p/edit/{post_id}', [ 'as' => 'editPost', 'uses' => 'PostsController@edit' ]);

    Route::get('/p/add/photos/{post_id}', [ 'as' => 'addPhoto', 'uses' => 'PostsController@addPhoto' ]);
    Route::post('/p/add/photos/{post_id}/upload', 'AjaxController@uploadPhoto');
    Route::post('/p/add/photos/{post_id}/primary', 'PostsController@primaryPhoto');
    Route::get('/p/add/photos/{post_id}/confirm', ['as' => 'confirmPost', 'uses' => 'PostsController@confirm']);
//    Route::get('/p/add/photos/{post_id}/confirm/activate', ['as' => 'activatePost', 'uses' => 'PostsController@activate']);
//    Route::get('/p/add/photos/{post_id}/confirm/disable', ['as' => 'disablePost', 'uses' => 'PostsController@disable']);

    Route::get('/p/delete/photos/{post_id}/{photo_id}', 'PostsController@deletePhoto');

    Route::post('/ajax/post/activate', 'AjaxController@activatePost');
    Route::post('/ajax/post/disable', 'AjaxController@disablePost');
});

//single post route
Route::get('/p/{post_id}', ['as' => 'showPost', 'uses'  => 'PostsController@show'])->where('post_id', '[0-9]+')->middleware('valid_post');

// users handling
Route::post('/u/register/process', 'UsersController@store');
Auth::routes();

Route::get('/edit', 'PostsController@change');