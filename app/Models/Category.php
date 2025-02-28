<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Relation : Une Catégorie peut avoir plusieurs Posts (One-to-Many)
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
