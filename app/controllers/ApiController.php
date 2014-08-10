<?php
/**
 * API Controller
 *
 * @author  Derek Marcinyshyn <derek@marcinyshyn.com>
 * @date    August 4, 2014
 */

class ApiController extends BaseController {

    /**
     * Get current weather data from local sensors
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrent() {
        return Response::json(App::make('Localweather\Data\Current')->getCurrentWeatherData());
    }
}