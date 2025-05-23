<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostBlock extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'title', 'content', 'image'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
