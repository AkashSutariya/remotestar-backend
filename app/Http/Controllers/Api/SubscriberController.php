<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

// Requests
use App\Http\Requests\StoreSubscriberRequest;

// Models
use App\Models\Subscriber;


class SubscriberController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubscriberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubscriberRequest $request)
    {
        // Select or Create Subscriber
        $subscriber = Subscriber::where('email', $request->email)
            ->firstOr(function () use ($request) {

                //Create New Sunscriber
                $newSubscriber = new Subscriber();
                $newSubscriber->email = $request->email;
                $newSubscriber->save();

                return $newSubscriber;
            });
        
        // Sync subscriber with website subscription
        $subscriber->websites()->syncWithoutDetaching($request->website);

        return (new JsonResource($subscriber))
                ->response()
                ->setStatusCode(201);
    }
}
