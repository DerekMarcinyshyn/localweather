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
}