<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'url_image'];

    /**
     * Relation : Une Image appartient à un seul Post (One-to-Many)
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
