<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductDetailPdfMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product;

    /**
     * En lugar de recibir $pdfData por constructor, lo generamos aquí
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    public function build()
    {
        // 1) Generar el PDF justo antes de enviarlo
        $pdf = Pdf::loadView('products.pdf', ['producto' => $this->product]);

        // 2) Usar markdown para que Mailtrap muestre bien attachments
        return $this
            ->subject("Detalle de producto: {$this->product->nombre}")
            ->markdown('emails.products.detail')    // Cambiamos a markdown
            ->attachData(
               $pdf->output(),
               "{$this->product->slug}.pdf",
               ['mime' => 'application/pdf']
            );
    }
}
