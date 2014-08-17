<?php namespace Localweather\Video;
/**
 * Aws.php
 *
 * @author  Derek Marcinyshyn <derek@marcinyshyn.com>
 * @date    15/08/14
 */

use Aws\S3\S3Client;
use Aws\S3\Enum\CannedAcl;
use Localweather\Exception\LocalweatherException;

class AwsException extends LocalweatherException {}

class Aws {

    /**
     * @var \Aws\S3\S3Client;
     */
    protected $client;

    /**
     * @param S3Client $client
     */
    public function __construct() {
        $this->client = S3Client::factory(array(
            "key"       => getenv('AWS_KEY'),
            "secret"    => getenv('AWS_SECRET')
        ));
    }

    /**
     * Upload videos to AWS S3
     *
     * @throws AwsException
     */
    public function uploadVideos() {
        $directory = storage_path('archive/video');
        $bucket = getenv('AWS_BUCKET');
        $prefix = '';
        $options = array(
            'params'        => array('ACL' => CannedAcl::PUBLIC_READ),
            'concurrency'   => 1,
            'debug'         => false,
            'force'         => false
        );

        try {
            $this->client->uploadDirectory($directory, $bucket, $prefix, $options);
        } catch (\Exception $e) {
            Log::error($e);
            throw new AwsException($e);
        }
    }
} 