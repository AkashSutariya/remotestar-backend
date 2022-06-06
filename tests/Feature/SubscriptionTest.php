<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

// Models
use App\Models\Website;
use App\Models\Subscriber;
use App\Models\SubscriberWebsite;

class SubscriptionTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_subscription()
    {
        // Perform test without playload
        $response = $this->postJson('/api/subscriber', []);
        $response->assertUnprocessable();
        $response->assertInvalid([
            'website' => 'The website field is required.',
            'email' => 'The email field is required.',
        ]);

        // Perform test with wrong data.
        $response = $this->postJson('/api/subscriber', [
            'website' => -1,
            'email' => 'ewew',
        ]);
        $response->assertUnprocessable();
        $response->assertInvalid([
            'website' => 'The selected website is invalid.',
            'email' => 'The email must be a valid email address.',
        ]);


        $websites = Website::all();
        $fakewebsiteCreated = false;
        $website = null;

        if ($websites->count()) {
            $website = $websites[0];
        } else {
            $fakewebsiteCreated = true;
            $website = Website::create(['name' => 'Fake website']);
        }

        
        $email = $this->faker()->email;

        while (Subscriber::where('email', $email)->first()) {
            $email = $this->faker()->email;
        }

        $totalSub = Subscriber::count();
        $totalSubWeb = SubscriberWebsite::count();

        // Perform test with valid payload
        $response = $this->postJson('/api/subscriber', [
            'website' => $website->id,
            'email' => $email,
        ]);
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'email',
            ]
        ]);
         // Assert that extra db records created from previos entries.
        $this->assertDatabaseCount('subscribers', $totalSub + 1);
        $this->assertDatabaseCount('subscriber_website', $totalSubWeb + 1);

        // Perform test with same valid payload
        $response = $this->postJson('/api/subscriber', [
            'website' => $website->id,
            'email' => $email,
        ]);
        $response->assertCreated();
        // Assert that no extra db records created from previos entries.
        $this->assertDatabaseCount('subscribers', $totalSub + 1);
        $this->assertDatabaseCount('subscriber_website', $totalSubWeb + 1);

        // Delete Fake data
        $subs = Subscriber::where('email', $email)->first();

        SubscriberWebsite::where('subscriber_id', $subs->id)
        ->where('website_id', $website->id)
        ->delete();

        $subs->delete();

        if ($fakewebsiteCreated) {
            $website->delete();
        }
    }
}
