<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'images'];

    protected $casts = [
        'images' => 'array',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
