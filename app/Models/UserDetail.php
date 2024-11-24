<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
            'mobile',
            'website',
            'facebook',
            'whatsapp',
            'linkedin',
            'gender',
            'date_of_birth',
            'current_city',
            'nick_name',
            'primary_lang',
            'secondary_lang',
            'favorite_quote',
    ];

    // Relation with user
    public function user(){
        return $this->belongsTo(User::class);
    }
}
