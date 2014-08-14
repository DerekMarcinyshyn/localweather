<?php namespace Localweather\Video;
/**
 * Render.php
 *
 * @author  Derek Marcinyshyn <derek@marcinyshyn.com>
 * @date    14/08/14
 */

use Localweather\Exception\LocalweatherException;
use Illuminate\Filesystem\Filesystem;

class RenderException extends LocalweatherException {}

class Render {

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    public function __construct(Filesystem $filesystem) {
        $this->filesystem = $filesystem;
    }

    public function createStorageFolder() {
        try {
            $directory = storage_path('archive/video/' . date('Y') . '/' . date('m') . '/' . date('d'));
            $this->filesystem->makeDirectory($directory, 0777, true, true);
            $this->renderH264();
        } catch (\Exception $e) {
            throw new RenderException('Error try to create storage folder.');
        }
    }

    public function renderH264() {
        echo shell_exec('ffmpeg');
    }

    public function renderWebm() {

    }
} 