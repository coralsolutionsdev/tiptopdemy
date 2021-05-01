<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormMail extends Mailable
{
    use Queueable, SerializesModels;
    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $domain = ucfirst(getApplicationDomain());
        $data = $this->data;
        $contentItems = $data['items'];
        $senderEmail = $data['sender_email'] ?? 'support@tiptopdemy.com';
        $senderName = $data['sender_name'] ?? $domain;
        return $this->from($senderEmail, $senderName)->replyTo($senderEmail, $senderName)->subject('Contact us :: '.$senderName)->markdown('emails.forms.mail', compact('domain', 'contentItems'));
    }
}
