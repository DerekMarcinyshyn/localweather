<?php namespace Localweather\Notifications;
/**
 * Error
 *
 * @author  Derek Marcinyshyn <derek@marcinyshyn.com>
 * @date    August 9, 2014
 */


class RenderFailHandler {

    /**
     * Send simple fail email
     */
    public function handle() {
        $mailData = array(
            'details'   => 'Render failed.'
        );

        \Mail::send('emails.notifications.fail', $mailData, function($message) {
            $message->from('revyweather@gmail.com', 'Local weather server');
            $message->to('derek@revelstokewebhosting.com', 'Derek Marcinyshyn')
                ->subject('Render failed.');
        });
    }
} 