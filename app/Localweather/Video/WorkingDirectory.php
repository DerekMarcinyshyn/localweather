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

            if ($result = $this->filesystem->copyDirectory($directory, $destination)) {
                $this->filesystem->cleanDirectory($directory);
            } else {
                throw new WorkingDirectoryException();
            }

        } catch (\Exception $e) {
            throw new WorkingDirectoryException($e);
        }
    }

    /**
     * Copy images over to render folder and rename img001.jpg, img002.jpg, ...
     *
     * @throws WorkingDirectoryException
     */
    public function renameFiles() {
        try {
            $render = storage_path('video/working/render');
            $images = $this->filesystem->files(storage_path('video/working/images'));

            for ($i = 0; $i < count($images); $i++) {
                rename($images[$i], $render . "/img" . sprintf('%03d', $i + 1) . ".jpg");
            }

        } catch (\Exception $e) {
            throw new WorkingDirectoryException('Error renaming files in working directory' . $e->getTraceAsString());
        }
    }
} 