<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Client
 *
 * @property-read \App\Models\Contact                                            $contact
 * @property-read \App\Models\Organization                                       $organization
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @mixin \Eloquent
 */
class Client extends Model
{
    protected $fillable = [
        'organization_id',
        'contact_id',
        'name',
        'invoice_prefix',
        'address',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
