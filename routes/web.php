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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard','MaillistController@dashboard');
Route::get('/maillist','MaillistController@index');
Route::post('/maillist','MaillistController@send');
Route::post('/maillist/update','MaillistController@update');

Route::get('/mailchimp','MailchimpController@index');
Route::post('/create/list','MailchimpController@create');
Route::post('/add/member','MailchimpController@add_member');

Route::post('/create/campaign','MailchimpController@create_campaign');
Route::get('/launch/campaign/{id}','MailchimpController@launch_campaign');

Route::get('/test','MailchimpController@test');
Route::get('/createlist','MailchimpController@create_list');