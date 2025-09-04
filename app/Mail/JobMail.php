<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Storage;


class JobMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private $email,
        private $application_type,
        private $last_name, 
        private $first_name,
        private $phone,
        private $intitule,
        private $cv_path = null,
        private $motivation_letter_path = null,
        private $identity_document_path = null,
        private $passport_photo_path = null,
    )
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle candidature reçue via le site de la COCEC',
            from: new Address('recrutements@cocectogo.org ', 'COCEC - Notification Système'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.job',
            with: [
                'email' => $this->email,
                'application_type' => $this->application_type,
                'last_name' => $this->last_name,
                'first_name' => $this->first_name,
                'phone' => $this->phone,
                'intitule' => $this->intitule,
                'cv_path' => $this->cv_path,
                'motivation_letter_path' => $this->motivation_letter_path,
                'identity_document_path' => $this->identity_document_path,
                'passport_photo_path' => $this->passport_photo_path,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        
        // Joindre le CV
        if ($this->cv_path && Storage::disk('public')->exists($this->cv_path)) {
            $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromStorageDisk('public', $this->cv_path)
                ->as('CV_' . $this->last_name . '_' . $this->first_name . '.pdf')
                ->withMime('application/pdf');
        }
        
        // Joindre la lettre de motivation
        if ($this->motivation_letter_path && Storage::disk('public')->exists($this->motivation_letter_path)) {
            $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromStorageDisk('public', $this->motivation_letter_path)
                ->as('Lettre_Motivation_' . $this->last_name . '_' . $this->first_name . '.pdf')
                ->withMime('application/pdf');
        }

        
        // Joindre la photo passeport
        if ($this->passport_photo_path && Storage::disk('public')->exists($this->passport_photo_path)) {
            $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromStorageDisk('public', $this->passport_photo_path)
                ->as('Photo_Passeport_' . $this->last_name . '_' . $this->first_name . '.jpg')
                ->withMime('image/jpeg');
        }
        
        return $attachments;
    }
}
