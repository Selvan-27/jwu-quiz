<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prayer extends Model
{
    
    protected $table = 'prayers';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'title',
        'description',
        'time_limit',
        'passing_score',
        'prayerpoints',
        'is_active',
    ];
}