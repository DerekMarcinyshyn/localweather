<?php namespace Localweather\Video;
/**
 * WorkingDirectory.php
 *
 * @author  Derek Marcinyshyn <derek@marcinyshyn.com>
 * @date    11/08/14
 */
use Illuminate\Filesystem\Filesystem;
use Localweather\Exception\LocalweatherException;

class WorkingDirectoryException extends LocalweatherException {}

class WorkingDirectory {

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
     * Copy over images to working directory for rendering
     * clear daily image directory
     *
     * @throws WorkingDirectoryException
     */
    public function copyImages() {
        try {
            $destination = storage_path('video/working/images');
            $directory = storage_path('video/images');
            $this->filesystem->copyDirectory($directory, $destination);
            $this->filesystem->cleanDirectory($directory);

        } catch (\Exception $e) {
            throw new WorkingDirectoryException('Error copying images to work directory: ' . $e->getTraceAsString());
        }
    }
} 