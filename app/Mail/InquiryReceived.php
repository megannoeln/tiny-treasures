<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Inquiry $inquiry)
    {
    }

    public function build(): self
    {
        $this->inquiry->loadMissing('artwork');

        $subject = 'New '.$this->inquiry->type.' inquiry';
        if ($this->inquiry->type === 'purchase' && $this->inquiry->artwork) {
            $subject = 'Purchase request: '.$this->inquiry->artwork->title;
        }

        return $this
            ->subject($subject)
            ->view('emails.inquiry-received');
    }
}
