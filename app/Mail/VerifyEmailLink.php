<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmailLink extends Mailable
{
    use Queueable, SerializesModels;

    public $url;

    /**
     * Create a new message instance.
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Verify Your Email Address')
                    ->view('emails.verify') // Blade file you’ll create next
                    ->with(['url' => $this->url]);
    }
}
