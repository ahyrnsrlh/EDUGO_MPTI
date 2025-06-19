<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];
    
    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id', 'id');
    }
    
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
    
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
