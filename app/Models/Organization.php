<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'website',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function projects()
    {
        return $this->hasManyThrough(Project::class, Client::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
