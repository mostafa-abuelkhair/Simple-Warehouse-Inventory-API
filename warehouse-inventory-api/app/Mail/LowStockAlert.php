<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Stock;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LowStockAlert extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Stock $stock,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Low Stock Alert: ' . $this->stock->inventoryItem->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.low-stock-alert',
        );
    }
}
