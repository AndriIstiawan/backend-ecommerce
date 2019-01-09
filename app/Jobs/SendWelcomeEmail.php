<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data=[
            'sender' => env('MAIL_USERNAME', 'admin@fiture.id'),
            'memberEmail'=> 'c.faishal.amrullah@gmail.com',
            'subject'=> 'testing email',
            'content' => 'testing oi',
        ];

        Mail::send('panel.email-management.mail.mail',$data,function($message) use ($data){
            $message->from($data['sender'],'Admin Fiture');
            $message->to($data['memberEmail']);
            $message->subject($data['subject']);
        });
    }
}
