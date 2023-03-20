<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckEmployee extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $checkemployee;

    public function __construct($checkemployee)
    {
        $this->checkemployee = $checkemployee;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('rbookscorp@gmail.com', 'Quản lý nhân sự RBOOKS')->subject('Xét duyệt Nghỉ: ' . $this->checkemployee->employee->fullname)->view('mail.checkemployee')->with(['checkemployee' => $this->checkemployee]);
    }
}
