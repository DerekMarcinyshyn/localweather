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
Event::listen('video.render.success', 'Localweather\Notifications\RenderSuccessHandler'); // send success email
Event::listen('video.render.success', 'Localweather\Video\CreateTimelapse@uploadVideos');

Event::listen('video.aws.fail', 'Localweather\Notifications\AwsFailHandler');
Event::listen('video.aws.success', 'Localweather\Notifications\AwsSuccessHandler'); // send success email

Event::listen('video.post.render.clean.up.fail', 'Localweather\Notifications\PostRenderCleanUpFailHandler');