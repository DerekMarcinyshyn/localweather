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
    protected $render;

    public function __construct(Archive $archive, WorkingDirectory $workingDirectory, Render $render) {
        $this->archive = $archive;
        $this->workingDirectory = $workingDirectory;
        $this->render = $render;
    }

    /**
     * STEP 1
     *
     * archive today images
     */
    public function start() {
        try {
            $this->archive->archiveImages();
            \Event::fire('video.archive.success');
        } catch (ArchiveException $e) {
            \Event::fire('video.archive.fail');
        }
    }

    /**
     * STEP 2
     *
     * copy images over to working directory
     */
    public function copyImages() {
        try {
            $this->workingDirectory->copyImages();
            \Event::fire('video.copy-images.success');
        } catch (WorkingDirectoryException $e) {
            \Event::fire('video.copy-images.fail');
        }
    }

    /**
     * STEP 3
     *
     * rename files img001.jpg ...
     */
    public function renameFiles() {
        try {
            $this->workingDirectory->renameFiles();
            \Event::fire('video.rename-files.success');
        } catch (WorkingDirectoryException $e) {
            \Event::fire('video.rename-files.fail');
        }
    }

    /**
     * STEP 4
     *
     * render out the timelapse movies
     */
    public function render() {
        try {
            $this->render->createStorageFolder();
            \Event::fire('video.render.success');
        } catch (RenderException $e) {
            \Event::fire('video.render.fail');
        }
    }

    /**
     * STEP 5
     *
     * sync with Amazon S3
     */
    public function syncStorage() {

    }
} 