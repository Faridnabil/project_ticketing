<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket; // Tambahkan property untuk tiket

    /**
     * Create a new message instance.
     */
    public function __construct($ticket)
    {
        $this->ticket = $ticket; // Inisialisasi tiket
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Laporan Tiket: ' . $this->ticket->title, // Menambahkan judul tiket sebagai subjek
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket_report', // Mengarahkan ke view yang sesuai
            with: ['ticket' => $this->ticket], // Mengirim data tiket ke view
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return []; // Tambahkan attachment jika diperlukan
    }
}
