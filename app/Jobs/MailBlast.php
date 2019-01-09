<?php

namespace App\Jobs;

use Mail;
use App\Email;
use App\Member;
use App\Mail\MailBlast as MailList;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MailBlast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->email->member as $i => $v)
            $member = Member::find($v);
            $send = Mail::to($member->email)->send(new MailList($this->email, $member));
            if($send)
                $email = $this->email;
                $email->success = ++$i;
                $email->save();
    }
}
