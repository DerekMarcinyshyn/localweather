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
     * @var Current
     */
    protected $current;

    /**
     * @param Current $current
     */
    public function __construct(Current $current)
    {
        $this->current = $current;
    }

    /**
     * Get current weather data from local sensors
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrent() {
        return Response::json($this->current->getCurrentWeatherData());
//        return Response::json(App::make('Localweather\Data\Current')->getCurrentWeatherData());
    }
}