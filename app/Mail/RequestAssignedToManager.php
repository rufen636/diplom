<?php

namespace App\Mail;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestAssignedToManager extends Mailable
{
    use Queueable, SerializesModels;

    protected string $mailTo;
    protected ServiceRequest $serviceRequest;

    public function __construct(string $mailTo, ServiceRequest $serviceRequest)
    {
        $this->mailTo = $mailTo;
        $this->serviceRequest = $serviceRequest;
        $this->serviceRequest->load(['providerClient', 'service', 'equipments']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address', 'noreply@example.com'), config('mail.from.name', 'SysAdmin')),
            replyTo: $this->mailTo,
            subject: 'Оборудование привязано к заявке #' . $this->serviceRequest->id
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'view.notif_assigned',
            with: [
                'clientName' => $this->serviceRequest->providerClient->name ?? null,
                'serviceRequest' => $this->serviceRequest,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
