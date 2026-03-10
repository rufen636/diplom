<?php

namespace App\Mail;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestInspection extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected string $mailTo;
    protected ServiceRequest $serviceRequest;

    public function __construct($mailTo,ServiceRequest $serviceRequest)
    {
        $this->mailTo = $mailTo;
        $this->serviceRequest = $serviceRequest;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('rovik636@gmial.com','Manager'),
            replyTo: $this->mailTo,
            subject: 'Request Inspection'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.notif_inspection',
            with: [
                'clientName' => $this->serviceRequest->providerClient->name ?? null,
                'serviceRequest' => $this->serviceRequest,
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
        return [];
    }
}
