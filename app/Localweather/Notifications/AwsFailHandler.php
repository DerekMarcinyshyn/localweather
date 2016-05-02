<?php namespace Localweather\Notifications;
/**
 * Error
 *
 * @author  Derek Marcinyshyn <derek@marcinyshyn.com>
 * @date    August 9, 2014
 */


class AwsFailHandler {

    /**
     * Send simple fail email
     */
    public function handle() {
        $mailData = array(
            'details'   => 'AWS upload failed.'
        );

        \Mail::send('emails.notifications.fail', $mailData, function($message) {
            $message->from('info@revyweather.ca', 'Local weather server');
            $message->to('derek@marcinyshyn.com', 'Derek Marcinyshyn')
                ->subject('AWS upload failed.');
        });
    }
} 