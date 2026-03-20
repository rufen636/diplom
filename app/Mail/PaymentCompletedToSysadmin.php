<?php

namespace App\Mail;

use App\Models\Billing;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentCompletedToSysadmin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Billing $billing
    ) {
        $this->billing->load(['providerClient', 'contract', 'tariff']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address', 'noreply@example.com'), config('mail.from.name', 'Бухгалтерия')),
            subject: 'Оплата получена — счёт №' . $this->billing->billing_number
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'view.payment_completed',
            with: [
                'billing' => $this->billing,
                'clientName' => $this->billing->providerClient?->name ?? '-',
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
