<?php

namespace App\Mail;

use App\Models\Contract;
use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PushForBuh extends Mailable
{
    use Queueable, SerializesModels;
    protected string $mailTo;
    protected Contract $contract;
    /**
     * Create a new message instance.
     */
    public function __construct(string $mailTo, Contract $contract)
    {
        $this->mailTo = $mailTo;
        $this->contract = $contract;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address', 'noreply@example.com'), config('mail.from.name', 'Accountant')),
            replyTo: $this->mailTo,
            subject: 'Push For Buh',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.notif_buh',
            with: [
                'contract' => $this->contract,
                'clientName' => $this->contract->providerClient->name ?? null,
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
