<?php

namespace App\Mail;

use App\Models\Emprunt;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LivreEmprunte extends Mailable
{
    use Queueable, SerializesModels;

    public $emprunt;

    // 🔹 constructeur
    public function __construct(Emprunt $emprunt)
    {
        $this->emprunt = $emprunt;
    }

    // 🔹 construction du mail
    public function build()
    {
        return $this->view('emails.livre_emprunte')
            ->subject('Confirmation d\'emprunt')
            ->with([
                'titre' => $this->emprunt->exemplaire->livre->titre,
                'date_retour' => $this->emprunt->date_retour->format('d/m/Y')

            ]);
    }
}