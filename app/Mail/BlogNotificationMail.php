<?php

namespace App\Mail;

use App\Models\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class BlogNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $blog;
    public $unsubscribeToken;

    /**
     * Create a new message instance.
     */
    public function __construct(Blog $blog, $unsubscribeToken = null)
    {
        $this->blog = $blog;
        $this->unsubscribeToken = $unsubscribeToken;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvel article sur le blog COCEC : ' . $this->blog->title,
            from: new Address('newsletters@cocectogo.org', 'COCEC - Microfinance'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.blog-notification',
            with: [
                'blog' => $this->blog,
                'unsubscribeToken' => $this->unsubscribeToken,
                'siteUrl' => 'https://cocectogo.org',
                'blogUrl' => 'https://cocectogo.org/blogs/' . $this->blog->id,
            ]
        );
    }

    /**
     * Get the attachments for the array.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
