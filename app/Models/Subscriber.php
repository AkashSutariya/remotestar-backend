<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\Website;

class Subscriber extends Model
{
    use HasFactory;

    /**
     * The websites that belong to the subsciber.
     */
    public function websites()
    {
        return $this->belongsToMany(Website::class)->withTimestamps();
    }
}
