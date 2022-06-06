<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

// Mockers
use Illuminate\Support\Facades\Event;
use App\Events\NewWebsitePostCreated;
use App\Listeners\SendNewWebsitePostEMailNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewWebsitePostCreatedMail;

// Models
use App\Models\Website;
use App\Models\WebsitePost;

class WebsitePostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_website_post()
    {
        // Faking Mockers
        Event::fake();
        Mail::fake();

        // Perform test with wensite which not exist
        $response = $this->postJson('/api/websites/-1/posts', []);
        $response->assertNotFound();

        $websites = Website::all();
        $fakewebsiteCreated = false;
        $website = null;

        if ($websites->count()) {
            $website = $websites[0];
        } else {
            $fakewebsiteCreated = true;
            $website = Website::create(['name' => 'Fake website']);
        }

        // Perform test without playload
        $response = $this->postJson('/api/websites/' . $website->id . '/posts', []);
        $response->assertUnprocessable();
        $response->assertInvalid([
            'title' => 'The title field is required.',
            'description' => 'The description field is required.',
        ]);

        $totalWebPost = WebsitePost::count();

        // Perform test with valid playload
        $response = $this->postJson('/api/websites/' . $website->id . '/posts', [
            'title' => 'This is title',
            'description' => 'This is description',
        ]);
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'website_id',
                'title',
                'description'
            ]
        ]);
        $this->assertDatabaseCount('website_posts', $totalWebPost + 1);

        // Get Newly Created Post
        $post  = WebsitePost::find($response->json()['data']['id']);

        // Assert Event Dispatched
        Event::assertDispatched(function (NewWebsitePostCreated $event) use ($post, $website) {
            return $event->post->id === $post['id']
            && $event->subscribers->toJson() === $website->subscribers->toJson();
        });

        Event::assertListening(
            NewWebsitePostCreated::class,
            SendNewWebsitePostEMailNotification::class,
        );
        
        // Fake Event Dispatch
        $event = new NewWebsitePostCreated($post, $website);
        $listener = new SendNewWebsitePostEMailNotification();
        $listener->handle($event);

        // Assert Mailable
        if ($website->subscribers->count()) {
            Mail::assertQueued(NewWebsitePostCreatedMail::class);
        } else {
            Mail::assertNothingSent();
        }

        // Delete Data
        $post->delete();
    }
}
