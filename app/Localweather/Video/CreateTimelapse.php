<?php namespace Localweather\Video;
/**
 * CreateTimelapse.php
 *
 * @author  Derek Marcinyshyn <derek@marcinyshyn.com>
 * @date    11/08/14
 */

class CreateTimelapse {

    protected $archive;
    protected $workingDirectory;

    public function __construct(Archive $archive, WorkingDirectory $workingDirectory) {
        $this->archive = $archive;
        $this->workingDirectory = $workingDirectory;
    }

    public function start() {
        try {
            $this->archive->archiveImages();
            \Event::fire('video.archive.success');
        } catch (ArchiveException $e) {
            \Event::fire('video.archive.fail');
        }
    }

    public function createWorkingDirectory() {
        try {
            $this->workingDirectory->copyImages();
            \Event::fire('video.working.directory.success');
        } catch (WorkingDirectoryException $e) {
            \Event::fire('video.working.directory.fail');
        }
    }
} 