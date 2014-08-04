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
        $json = $this->getNetduinoData();

        $json->barometer = $this->getRaspberryPiPressureData();
        $json->temperature = $this->getRaspberryPiTemperatureData();

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
        $temperature = '';

        try {
            $temperatureResponse = $this->client->get(self::RASPBERRYPI . '/devices/bmp/sensor/temperature/c');
            if ($temperatureResponse->getStatusCode() == '200') {
                $temperature = number_format($temperatureResponse->getBody()->getContents(), 1);
            }

        } catch (RequestException $e) {
            $temperature = '0';
        }

        return $temperature;
    }

    /**
     * Get Raspberry Pi Pressure
     *
     * @return string
     */
    private function getRaspberryPiPressureData() {
        $pressure = '';

        try {
            $raspberryPiPressureResponse = $this->client->get(self::RASPBERRYPI . '/devices/bmp/sensor/pressure/pa');
            if ($raspberryPiPressureResponse->getStatusCode() == '200') {
                $raspberrypi = $raspberryPiPressureResponse->getBody()->getContents();

                // calculate adjusted barometric pressure based on elevation
                $altimeter = 101325 * pow(((288 - 0.0065 * self::ALTITUDE) / 288), 5.256);
                $pressure = number_format((((101325 + (int) $raspberrypi) - $altimeter) / 1000), 1);
            }
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
        $netduino = 'hello';

        try {
            $netduinoResponse = $this->client->get(self::NETDUINO);
            if ($netduinoResponse->getStatusCode() == '200') {
                $netduino = json_decode($netduinoResponse->getBody()->getContents());
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