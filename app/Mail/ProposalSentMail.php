<?php

namespace App\Mail;

use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProposalSentMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Proposal $proposal) {
        
    }

    public function build()
    {
        return $this
            ->subject('Proposal from novALight: ' . $this->proposal->title)
            ->view('emails.proposals.sent');
    }
}