<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $application_status, $application_type, $reject_remarks, $inspection_date, $inspector_date_rejected)
    {
        $this->name = $name;
        $this->email = $email;
        $this->application_status = $application_status;
        $this->application_type = $application_type;
        $this->reject_remarks = $reject_remarks;
        $this->inspection_date = $inspection_date;
        $this->inspector_date_rejected = $inspector_date_rejected;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notification for Inspection of Water Refilling Facility/Station',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.application-notification',
            with: [
                'name' => $this->name,
                'email' => $this->email,
                'application_status' => $this->application_status,
                'application_type' => $this->application_type,
                'reject_remarks' => $this->reject_remarks,
                'inspection_date'=>$this->inspection_date,
                'inspector_date_rejected'=>$this->inspector_date_rejected
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
