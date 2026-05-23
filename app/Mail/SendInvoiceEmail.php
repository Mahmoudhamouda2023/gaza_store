<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class SendInvoiceEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $pdf;

    public function __construct(Order $order, $pdf = null)
    {
        $this->order = $order;
        $this->pdf = $pdf;
    }

    public function build()
    {
        $mail = $this->subject('فاتورتك - Your Invoice')
            ->markdown('emails.invoice', ['order' => $this->order]);

        if ($this->pdf) {
            $mail->attachData($this->pdf->output(), "invoice_{$this->order->id}.pdf");
        }

        return $mail;
    }
}
