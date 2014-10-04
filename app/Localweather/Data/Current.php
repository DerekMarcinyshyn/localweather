<?php namespace Localweather\Data;
/**
 * Class Current
 *
 * @package Localweather\Data
 * @author  Derek Marcinyshyn <derek@marcinyshyn.com>
 * @date    August 3, 2014
 */

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Current {

    /**
     * URL for Netduino
     */
    const NETDUINO = 'http://192.168.1.50';

    /**
     * URL for RaspberryPi
     */
    const RASPBERRYPI = 'http://192.168.1.20:7000';

    /**
     * Altitude of my house for barometric pressure compensation
     */
    const ALTITUDE = 500;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * Get current weather data
     *
     * @return array|mixed|null|string
     */
    public function getCurrentWeatherData() {
        $json = $this->getNetduinoData();

        $barometer = $this->getRaspberryPiPressureData();
        $json->barometer = $barometer;

        $temperature = $this->getRaspberryPiTemperatureData();
        $json->temperature = $temperature;
        $json->bmp_temperature = $temperature;

        date_default_timezone_set('America/Vancouver');
        $json->timestamp = date('l, F j, Y', time()) . ' at ' . date('g:i:s a', time());

        return $json;
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
        $netduino = new \stdClass();

        try {
            $netduinoResponse = $this->client->get(self::NETDUINO);
            if ($netduinoResponse->getStatusCode() == '200') {
                $netduino = json_decode($netduinoResponse->getBody());
            }
        } catch (RequestException $e) {
            $netduino->temp = '0';
            $netduino->humidity = '0';
            $netduino->relativehumidity = '0';
            $netduino->direction = 'N';
            $netduino->speed = '0';
        }

        return $netduino;
    }
} 