<?php namespace Localweather\Data;
/**
 * Current weather data
 * run as a daemon getting data every x seconds
 *
 * @author  Derek Marcinyshyn <derek@marcinyshyn.com>
 * @date    August 3, 2014
 */

use Illuminate\Filesystem\Filesystem;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Current {

    const NETDUINO = 'http://192.168.1.50';
    const RASPBERRYPI = 'http://192.168.1.20:7000';
    const ALTITUDE = 500;

    protected $client;

    public function __construct() {
        $this->client = new Client;
    }

    public function getCurrentWeatherData() {
        $json = NULL;
        $json = $this->getNetduinoData();

        $barometer = $this->getRaspberryPiPressureData();
        $json->barometer = $barometer;

        $temperature = $this->getRaspberryPiTemperatureData();
        $json->temperature = $temperature;

        date_default_timezone_set('America/Vancouver');
        $json->timestamp = date('l, F j, Y', time()) . ' at ' . date('g:i:s a', time());


//        echo $json . "\n";
        dd($json);
    }

    /**
     * Get Raspberry Pi Temperature
     *
     * @return string
     */
    private function getRaspberryPiTemperatureData() {
        try {
            $temperature = file_get_contents(self::RASPBERRYPI . '/devices/bmp/sensor/temperature/c');
        } catch (RequestException $e) {
            $temperature = 'N/A';
        }

        return number_format($temperature, 1);
    }

    /**
     * Get Raspberry Pi Pressure
     *
     * @return string
     */
    private function getRaspberryPiPressureData() {
        try {
            $barometer = file_get_contents(self::RASPBERRYPI . '/devices/bmp/sensor/pressure/pa');

            // calculate adjusted barometric pressure based on elevation
            $altimeter = 101325 * pow(((288 - 0.0065 * self::ALTITUDE) / 288), 5.256);
            $pressure = number_format((((101325 + (int) $barometer) - $altimeter) / 1000), 1);

        } catch (RequestException $e) {
            $pressure = '0';
        }

        return $pressure;
    }

    /**
     * Get Netduino data
     *
     * @return array|mixed|string
     */
    private function getNetduinoData() {
        $netduino = '';

        try {
            $netduinoResponse = $this->client->get(self::NETDUINO);
            if ($netduinoResponse->getStatusCode() == '200') {
                $netduino = json_decode($netduinoResponse->getBody());
            }
        } catch (RequestException $e) {
            $netduino = array(
                'temp'              => 'N/A',
                'humidity'          => 'N/A',
                'relativehumidity'  => 'N/A',
                'direction'         => 'N/A',
                'speed'             => 'N/A'
            );
        }

        return $netduino;
    }
} 