<?php namespace Localweather\Video;
/**
 * CleanUpPostRender.php
 *
 * @author  Derek Marcinyshyn <derek@marcinyshyn.com>
 * @date    16/08/14
 */

use Illuminate\Filesystem\Filesystem;
use Localweather\Exception\LocalweatherException;

/**
 * Class CleanUpPostRenderException
 * @package Localweather\Video
 */
class CleanUpPostRenderException extends LocalweatherException {}

class CleanUpPostRender {

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem) {
        $this->filesystem = $filesystem;
    }

    /**
     * empty directories
     */
    public function emptyDirectory() {
        $directory = storage_path('video/working/render');
        $this->cleanUp($directory);
    }

    /**
     * execute clean up directory
     *
     * @param $directory string
     * @throws CleanUpPostRenderException
     */
    private function cleanUp($directory) {
        try {
            $this->filesystem->cleanDirectory($directory);
        } catch (\Exception $e) {
            throw new CleanUpPostRenderException($e);
        }
    }
} 