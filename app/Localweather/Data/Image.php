<?php namespace Localweather\Data;
/**
 * Image
 *
 * @author  Derek Marcinyshyn <derek@marcinyshyn.com>
 * @date    August 8, 2014
 */

use Illuminate\Filesystem\Filesystem;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Event;

class Image {

    const RASPBERRYPI = 'http://192.168.1.20:2000';

    protected $client;
    protected $filesystem;
    protected $filename;

    /**
     * @param Client $client
     * @param Filesystem $filesystem
     */
    public function __construct(Client $client, Filesystem $filesystem) {
        $this->client = $client;
        $this->filesystem = $filesystem;
        $this->filename = storage_path('data/latest.jpg');
    }

    /**
     * Get the latest image from the RaspberryPi
     */
    public function getLatestImage() {
        try {
            $response = $this->client->get(self::RASPBERRYPI . '/latest.jpg');
            if ($response->getStatusCode() == '200') {
                $image = $response->getBody();
                $this->filesystem->put($this->filename, $image);
            }
        } catch (RequestException $e) {
            echo "Failed to get latest image\n";
            \Event::fire('image.fail');
        }
    }
} 