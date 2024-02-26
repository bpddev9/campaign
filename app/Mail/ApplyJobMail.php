<?php

namespace App\Mail;

use App\Models\CompanyProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplyJobMail extends Mailable
{
    use Queueable, SerializesModels;

     public $job;
     public $user;
     public $is_resume;
     public $file;

    public function __construct($job, $user, $is_resume, $file)
    {
        $this->job = $job;
        $this->user = $user;
        $this->is_resume = $is_resume;
        $this->file = $file;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'New Job Application',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.job-application',
            with: [
                'job' =>$this->job,
                'user' =>$this->user,
                'is_resume' =>$this->is_resume,
                'file' =>$this->file
            ]
        );
    }

    public function attachments()
    {
        if ($this->is_resume == 1 && $this->file != null) {
            return [
                Attachment::fromPath('storage/' . $this->file)
            ];
        }
    }
}
