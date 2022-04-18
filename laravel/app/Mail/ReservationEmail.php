<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue; 

class ReservationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $reservation;

    public function __construct($reservation)
    {
         $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'husni.mubarok03@gmail.com';
        $name = 'Rumah Makan Pondok Laras';
        $subject = 'Reservasion';

        $occation = 'dskjnfskdf';

        return $this->view('layouts.emailcontact')
                    ->from($address, $name)
                    ->cc($address, $name)
                    ->bcc($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with([
                        'ReName' => $this->reservation->name, 
                        'ReEmail' => $this->reservation->email, 
                        'ReAccation' => $this->reservation->occation, 
                        'ReDate' => $this->reservation->date, 
                        'ReMessage' => $this->reservation->message, 
                    ]);
    }
}
