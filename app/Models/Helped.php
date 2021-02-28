<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Helped extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'marker_id',
        'description',
        'proof',
        'created_at',
        'updated_at'
    ];
    public function markers()
    {
        return $this->belongsTo(Marker::class);
    }
}
