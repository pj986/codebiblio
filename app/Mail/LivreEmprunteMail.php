<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class LivreEmprunteMail extends Mailable
{

    public $livre;
    public $date_retour;

    public function __construct($livre, $date_retour)
    {
        $this->livre = $livre;
        $this->date_retour = $date_retour;
    }

    public function build()
    {
        return $this->subject('Confirmation d\'emprunt')
            ->view('emails.livre-emprunte');
    }

}