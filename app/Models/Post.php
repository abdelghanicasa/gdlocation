<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'page_id', 'text', 'image'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function blocks()
    {
        return $this->hasMany(PostBlock::class, 'post_id', 'id'); // Use PostBlock model and correct table name
    }
}

