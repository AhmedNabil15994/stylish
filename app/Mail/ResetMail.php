<?php

namespace App\Mail;

use App\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $expire_at;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code,$expire_at)
    {
        $this->code= $code;
        $this->expire_at= $expire_at;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $setting = Setting::first();
        return $this->from($setting->email1,$setting->name)
            ->view('emails.reset');
    }
}
