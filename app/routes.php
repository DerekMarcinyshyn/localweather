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
    try {
        return Image::make(storage_path('data/latest.jpg'))->response('jpg');
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        return false;
    }
});

Route::get('weather-station/latest.jpg', function() {
    try {
        return Image::make(storage_path('data/latest.jpg'))->response('jpg');
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        return false;
    }
});
