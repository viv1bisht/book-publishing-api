<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
    'user_id',
    'title',
    'description',
    'status'
];
public function user()
{
    return $this->belongsTo(User::class);
}

public function chapters()
{
    return $this->hasMany(Chapter::class);
}
}
