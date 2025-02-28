<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'slug',
        'published_at'];

    /**
     * Relation : Un Post appartient à un seul Utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : Un Post appartient à une seule Catégorie
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relation : Un Post peut avoir plusieurs Tags (Many-to-Many)
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    /**
     * Relation : Un Post peut avoir plusieurs Images (One-to-Many)
     */
    public function images()
    {
        return $this->hasMany(PostImage::class);
    }
}
