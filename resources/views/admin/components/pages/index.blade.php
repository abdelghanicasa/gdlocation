<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['page_id', 'text', 'image'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}