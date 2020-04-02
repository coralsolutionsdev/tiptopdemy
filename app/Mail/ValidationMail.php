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
        $headerImage = asset_image('/assets/true_friends.png');
        $receiverData = $this->receiverData;
        $validationCode = $receiverData['validation_code'];
        $senderEmail = 'support@example.com';
        $validationLink = url('/account/activate?verify_email='.$validationCode);
        return $this->from($senderEmail)->subject($domain.': Account activation')->markdown('emails.registration.validation_mail', compact('domain', 'domainLogoPath', 'receiverData','emailContactList', 'validationLink', 'headerImage'));
    }
}
