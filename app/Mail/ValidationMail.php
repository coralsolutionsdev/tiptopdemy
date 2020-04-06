<?php

namespace App\Mail;

use App\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ValidationMail extends Mailable
{
    use Queueable, SerializesModels;
    private $receiverData;

    /**
     * Create a new message instance.
     * ValidationMail constructor.
     * @param $receiverData
     */
    public function __construct($receiverData)
    {
        $this->receiverData = $receiverData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $domain = ucfirst(getApplicationDomain());
        $domainLogoPath = asset_image(getSite()->logo);
        $headerImage = asset_image('assets/email_01.png');
        $receiverData = $this->receiverData;
        $validationCode = $receiverData['validation_code'];
        $senderEmail = 'support@tiptopdemy.com';
        $validationLink = url('/account/activate?verify_email='.$validationCode);
        return $this->from($senderEmail, $domain)->subject('Account Activation')->markdown('emails.registration.validation_mail', compact('domain', 'domainLogoPath', 'receiverData','emailContactList', 'validationLink', 'headerImage'));
    }
}
