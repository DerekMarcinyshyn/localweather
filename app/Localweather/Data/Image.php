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

    /**
     * URL of RaspberryPi
     */
    const RASPBERRYPI = 'http://192.168.1.20:2000';

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * @var string
     */
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
     *
     * @return bool
     */
    public function getLatestImage() {
        try {
            $response = $this->client->get(self::RASPBERRYPI . '/latest.jpg');
            if ($response->getStatusCode() == '200') {
                $image = $response->getBody();
                $this->filesystem->put($this->filename, $image);

                return true;
            } else {
                \Event::fire('image.fail');
                return false;
            }
        } catch (RequestException $e) {
            echo "Failed to get latest image\n";
            \Event::fire('image.fail');
            return false;
        }
    }

    /**
     * Get the latest Clean image (no watermark) from RaspberryPi
     *
     * @return bool
     */
    public function getCleanImage() {
        try {
            $response = $this->client->get(self::RASPBERRYPI . '/original.jpg');
            if ($response->getStatusCode() == '200') {
                $image = $response->getBody();

                // image-2014-08-09-14:20:00.jpg
                $date = date('Y-m-d-H:i:s');
                $filename = storage_path('video/images/image-' . $date . '.jpg');
                $this->filesystem->put($filename, $image);

                return true;
            } else {
                \Event::fire('image.fail');

                return false;
            }
        } catch (RequestException $e) {
            echo "Failed to get latest image\n";
            \Event::fire('image.fail');

            return false;
        }
    }
} 