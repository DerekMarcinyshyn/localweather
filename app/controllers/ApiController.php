<?php
/**
 * API Controller
 *
 * @author  Derek Marcinyshyn <derek@marcinyshyn.com>
 * @date    August 4, 2014
 */

use Localweather\Data\Current;

class ApiController extends BaseController {

    /**
     * Get current weather data from local sensors
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrent() {
        $current = new Current;

        return Response::json($current->getCurrentWeatherData());
    }

    /**
     * Get the latest image from RaspberryPi
     * it gets loaded via cron job
     *
     * @return mixed
     */
    public function getLatestImage() {
        $image = Image::make(storage_path('data/latest.jpg'));

        return $image->response();
    }
}