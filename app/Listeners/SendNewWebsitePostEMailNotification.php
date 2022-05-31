<?php

namespace App\Listeners;

// Facades
use Illuminate\Support\Facades\Mail;

// Events
use App\Events\NewWebsitePostCreated;

// Mailables
use App\Mail\NewWebsitePostCreatedMail;

class SendNewWebsitePostEMailNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewWebsitePostCreated  $event
     * @return void
     */
    public function handle(NewWebsitePostCreated $event)
    {
        // Send Mail to subscribers
        if ($event->subscribers->count()) {
            Mail::to($event->subscribers)->send(new NewWebsitePostCreatedMail($event->post));
        }
    }
}
