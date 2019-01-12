<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Channel extends Model
{
    protected $guarded = [];

    protected $casts = [
        'archived' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('archived', false)
                ->orderBy('name', 'asc');
        });
    }

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
