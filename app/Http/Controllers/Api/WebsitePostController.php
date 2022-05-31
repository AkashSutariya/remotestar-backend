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
        $websitePost = new WebsitePost();

        $websitePost->website_id = $website->id;
        $websitePost->title = $request->title;
        $websitePost->description = $request->description;

        $websitePost->save();

        // Dispatch Event
        NewWebsitePostCreated::dispatch($websitePost, $website->subscribers);

        return (new JsonResource($websitePost))
                ->response()
                ->setStatusCode(201);
    }
}
