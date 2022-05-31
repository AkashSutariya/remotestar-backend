<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// Models
use App\Models\WebsitePost;

class NewWebsitePostCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The WebsitePost instance.
     *
     * @var \App\Models\WebsitePost
     */
    public $post;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\WebsitePost  $post
     * @return void
     */
    public function __construct(WebsitePost $post)
    {
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->post->title)
                    ->text('mails.new_post');
    }
}
