<?php
/**
 * ROUTES
 */

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/current', array(
    'uses' => 'ApiController@getCurrent'
));

Route::get('/latest-image', array(
    'uses' => 'ApiController@getLatestImage'
));



/**
 * EVENTS
 */

Event::listen('image.fail', 'Localweather\Notifications\ImageFailHandler');