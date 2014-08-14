<?php
/**
* EVENTS
*/

Event::listen('image.fail', 'Localweather\Notifications\ImageFailHandler');

Event::listen('video.archive.fail', 'Localweather\Notifications\ArchiveFailHandler');
Event::listen('video.archive.success', 'Localweather\Video\CreateTimelapse@copyImages');

Event::listen('video.copy-images.fail', 'Localweather\Notifications\WorkingDirectoryFailHandler');
Event::listen('video.copy-images.success', 'Localweather\Video\CreateTimeLapse@renameFiles');

Event::listen('video.rename-files.fail', 'Localweather\Notifications\WorkingDirectoryFailHandler');
//Event::listen('video.rename-files.success', '');