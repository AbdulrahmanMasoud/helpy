<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'gender',
        'mental_state',
        'adult',
        'description',
        'latitude',
        'longitude',
        'proof',
        'status',
        'created_at',
        'updated_at'
    ];
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
