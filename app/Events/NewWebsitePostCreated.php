<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// Models
use App\Models\WebsitePost;
use App\Models\Subscriber;

class NewWebsitePostCreated
{
    use Dispatchable, SerializesModels;

    /**
     * The WebsitePost instance.
     *
     * @var \App\Models\WebsitePost
     */
    public $post;

    /**
     * The Website instance.
     *
     * @var \App\Models\Subscriber[]
     */
    public $subscribers;
 

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\WebsitePost  $post
     * @param  \App\Models\Subscriber[] $website
     * @return void
     */
    public function __construct(WebsitePost $post, $subscribers)
    {
        $this->post = $post;
        $this->subscribers = $subscribers;
    }
}
