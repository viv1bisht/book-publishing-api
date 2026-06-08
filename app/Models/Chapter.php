<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = [
        'book_id',
        'title',
        'description'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function pages()
{
    return $this->hasMany(Page::class);
}
}
