# Local weather application

Laravel app to gather raw weather data from Netduino Plus 2 and RaspberryPi sensors.

Gets the current image from RaspberryPi camera and serves to internet web server.

Creates the timelapse videos and uploads to AWS S3.

### Cron jobs

Latest image every 5 minutes from RaspberryPi.

Latest image with no watermark for archiving and creating timelapse every 10 minutes.

Create video with ffmpeg.

Sync with AWS S3.

### Settings

.env.php

```php
<?php

return [
    'GMAIL_USERNAME'    => 'user@gmail.com',
    'GMAIL_PASSWORD'    => 'secret'
];

```