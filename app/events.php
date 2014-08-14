<?php
/**
* EVENTS
*/

Event::listen('image.fail', 'Localweather\Notifications\ImageFailHandler');

Event::listen('video.archive.fail', 'Localweather\Notifications\ArchiveFailHandler');
Event::listen('video.archive.success', 'Localweather\Video\CreateTimelapse@copyImages');

Event::listen('video.copy-images.fail', 'Localweather\Notifications\WorkingDirectoryFailHandler');
Event::listen('video.copy-images.success', 'Localweather\Video\CreateTimelapse@renameFiles');

Event::listen('video.rename-files.fail', 'Localweather\Notifications\WorkingDirectoryFailHandler');
Event::listen('video.rename-files.success', 'Localweather\Video\CreateTimelapse@render');

Event::listen('video.render.fail', 'Localweather\Notifications\RenderFailHandler');
//Event::listen('video.render.success', '');