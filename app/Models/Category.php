<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use HasFactory, Sluggable;
    protected $guarded = ['id'];
    // protected $with = ['posts'];
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                // title diambil dari kolom database mana yang akan di generate slug
                'source' => 'name'
            ]
        ];
    }
}
