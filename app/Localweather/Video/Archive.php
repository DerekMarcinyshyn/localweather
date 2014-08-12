<?php namespace Localweather\Video;
/**
 * Archive
 *
 * @author  Derek Marcinyshyn <derek@marcinyshyn.com>
 * @date    August 11, 2014
 */

use Illuminate\Filesystem\Filesystem;
use Localweather\Exception\LocalweatherException;

class ArchiveException extends LocalweatherException {}

class Archive {

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
     * Archive the images in archive/images/YEAR/MONTH/DAY
     *
     * @throws ArchiveException
     */
    public function archiveImages() {
        try {
            $destination = storage_path('archive/images/' . date('Y') . '/' . date('m') . '/' . date('d'));
            $directory = storage_path('video/images');
            $this->filesystem->copyDirectory($directory, $destination);

        } catch (\Exception $e) {
            throw new ArchiveException('Error archive images: ' . $e->getTraceAsString());
        }
    }
}