<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $guarded = [];

    protected $casts = [
        'archived' => 'boolean'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function archive()
    {
        return $this->update(['archived' => true]);
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
