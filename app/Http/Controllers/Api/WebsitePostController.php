<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

// Requests
use App\Http\Requests\StoreWebsitePostRequest;

// Models
use App\Models\WebsitePost;
use App\Models\Website;

// Events
use App\Events\NewWebsitePostCreated;

class WebsitePostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreWebsitePostRequest  $request
     * @param  \App\Models\Website $website
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWebsitePostRequest $request, Website $website)
    {
        // Create and Store New Website Post
        $websitePost = $website->posts()->create($request->all());

        // Dispatch Event
        NewWebsitePostCreated::dispatch($websitePost, $website->subscribers);

        return (new JsonResource($websitePost))
                ->response()
                ->setStatusCode(201);
    }
}
