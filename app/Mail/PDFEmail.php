<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class PDFEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfPath;

    /**
     * Create a new message instance.
     *
     * @param  string  $pdfPath
     * @return void
     */
    public function __construct($pdfPath)
    {
        $this->pdfPath = $pdfPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('PDF Adjunto')->view('emails.pdf_email')
            ->attach($this->pdfPath, [
                'as' => 'lista_personas.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
