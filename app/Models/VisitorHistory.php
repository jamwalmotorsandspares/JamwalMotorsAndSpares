<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorHistory extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'activity_type',
        'url',
        'route_name',
        'method',
        'ip_address',
        'user_agent',
        'referer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function subject()
    {
        return $this->morphTo();
    }
}