<?php
/**
* EVENTS
*/

Event::listen('image.fail', 'Localweather\Notifications\ImageFailHandler');

Event::listen('video.archive.fail', 'Localweather\Notifications\ArchiveFailHandler');
Event::listen('video.archive.success', 'Localweather\Video\WorkingDirectory@copyImages');

Event::listen('video.working.directory.fail', 'Localweather\Notifications\WorkingDirectoryFailHandler');
//Event::listen('video.working.directory.success', '');