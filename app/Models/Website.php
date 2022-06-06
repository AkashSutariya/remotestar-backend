<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\Subscriber;
use App\Models\WebsitePost;

class Website extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Get the posts for the website.
     */
    public function posts()
    {
        return $this->hasMany(WebsitePost::class);
    }

    /**
     * The subscribers that belong to the website.
     */
    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class)->withTimestamps();
    }
}
