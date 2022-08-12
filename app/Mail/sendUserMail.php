<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class sendUserMail extends Mailable
{
    use Queueable, SerializesModels;
    public $maildata;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($maildata)
    {
        $this->maildata = $maildata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $title=$this->maildata['title'];
        $url=$this->maildata['url'];

        Log::info($url);


        return $this->markdown('emails.sendUserMail')
                     ->subject('Üyelik İşleminiz Gerçekleşti')
                     ->with([
                        'title'=>$title,
                        'url'=>$url,
                        ]);


    }
}
