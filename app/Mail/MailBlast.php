<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailBlast extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $detail;
    protected $member;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($detail, $member)
    {
        $this->detail = $detail;
        $this->member = $member;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address') , config('mail.from.name'))
                    ->view('panel.email-management.mail.mail')
                    ->subject(ucwords($this->detail->subject))
                    ->with([
                        'content'=> $this->detail->content,
                        'comment'=> $this->detail->comment,
                        'name'=> $this->member->name
                    ]);
    }
}
