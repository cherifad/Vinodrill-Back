<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OAuthProvider extends Model
{
    protected $fillable = [
        'provider',
        'provider_id',
        'user_id',
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
}
