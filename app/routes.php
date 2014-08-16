<?php
/**
 * ROUTES
 */

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('current', array(
    'uses' => 'ApiController@getCurrent'
));

Route::get('latest-image', function() {
    return Image::make(storage_path('data/latest.jpg'))->response('jpg');
});


// backwards compatible for Selkirk server and old revyweather.com
Route::get('weather-station/data', array(
    'uses' => 'ApiController@getCurrent'
));

Route::get('weather-station/latest.jpg', function() {
    return Image::make(storage_path('data/latest.jpg'))->response('jpg');
});
