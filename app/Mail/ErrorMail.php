<?php

namespace App\Mail;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ErrorMail extends Mailable
{
    use Queueable, SerializesModels;

    public $exception, $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Exception $exception)
    {
        $this->url = config('app.url');
        $this->exception = $exception;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.notificacion')->subject('Error Exception');
    }
}
