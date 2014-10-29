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

Route::get('/', array('as' => 'ravenstormHome', 'uses' => 'UserController@ravenstorm'));

Route::post('/search', array('as' => 'ravenstormSearch', 'uses' => 'UserController@ravenstormSearch'));

Route::get('/faq', array('as' => 'ravenstormFaq', function (){ return View::make('ravenstorm.faq'); }));

Route::get('/leaderboards', array('as' => 'ravenstormLeaderboards', 'uses' => 'UserController@ravenstormLeaderboards'));

Route::get('/userlist', array('as' => 'ravenstormUserlist', 'uses' => 'UserController@ravenstormUserList'));

Route::get('/{summonerId}', array('as' => 'ravenstormUser', 'uses' => 'UserController@ravenstormUser'));

Route::get('/updateRecentMatches/{summonerId}', array ('as' => 'getinfo', 'uses' => 'UserController@updateRecentMatches'));