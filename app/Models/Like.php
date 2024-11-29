<?php

namespace App\Models;

use App\Traits\Likeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'likeable_id', 'likeable_type', 'is_like', 'is_liked_by_current_user'];

    // Defining relationships for models 
    public function likeable(){
        return $this->morphTo();
    }

    // Defining relationships with user
    public function user(){
        return $this->belongsTo(User::class);
    }
}
