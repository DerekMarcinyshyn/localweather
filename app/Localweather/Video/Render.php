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

    /**
     * @var string
     */
    protected $imagesFolder;

    /**
     * @var string
     */
    protected $directory;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem) {
        $this->filesystem = $filesystem;
        $this->imagesFolder = storage_path('video/working/render');
        $this->directory = storage_path('archive/video/' . date('Y') . '/' . date('F') . '/' . date('d'));
        $this->filename = date('F') . '-' . date('d');
    }

    /**
     * Create the storage folder then render 2 video formats h264 and webm
     *
     * @throws RenderException
     */
    public function createStorageFolder() {
        try {
            $this->filesystem->makeDirectory($this->directory, 0777, true, true);
            $this->renderH264();
            $this->renderWebm();
        } catch (\Exception $e) {
            throw new RenderException();
        }
    }

    /**
     * Render H264 video
     */
    private function renderH264() {
        $h264 = 'ffmpeg -r 4/1 -i ' . $this->imagesFolder . '/img%03d.jpg ' .
            '-vf "movie=' . storage_path('video/watermark/watermark.png') . '[watermark]; [in][watermark] overlay=0:0 [out]" ' .
            '-c:v libx264 ' .
            '-r 24 ' .
            '-pix_fmt yuv420p ' .
            $this->directory . '/' . $this->filename . '.mp4';

        $output = shell_exec($h264);

        echo $output . "\n";
    }

    /**
     * Render WebM video
     */
    private function renderWebm() {
        $webm = 'ffmpeg -r 4/1 -i ' . $this->imagesFolder . '/img%03d.jpg ' .
            '-vf "movie=' . storage_path('video/watermark/watermark.png') . '[watermark]; [in][watermark] overlay=0:0 [out]" ' .
            '-c:v libvpx ' .
            '-r 24 ' .
            '-pix_fmt yuv420p ' .
            $this->directory . '/' . $this->filename . '.webm';

        $output = shell_exec($webm);

        echo $output . "\n";
    }
} 