<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NPrefer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'web_push',
        'mail',
        'sms',
    ];
}
