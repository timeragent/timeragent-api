<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
