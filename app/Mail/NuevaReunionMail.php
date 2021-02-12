<?php

namespace App\Mail;

use App\Models\ClienteComunicacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NuevaReunionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $comunicacion, $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ClienteComunicacion $comunicacion)
    {
        $this->comunicacion = $comunicacion->with('cliente')->find($comunicacion->id);
        $this->url = config('app.url');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.nueva-reunion')->subject('Reunión Agendada');
    }
}
