<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendEmails extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $view;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data = null, $view = null, $subject = "Creative Insight Developer Test")
    {
        $this->data = $data;
        $this->view = $view;
        $this->subject = $subject;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->subject($this->subject)->view($this->view)->with("data", $this->data);

    }
}
