<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    use HasFactory, Sluggable;
    // protected $fillable = ['title', 'excerpt', 'body'];
    protected $guarded = ['id'];
    // with adalah sebuah eager loader yang digunakan untuk meminimalkan query yang terjadi, parameter yang ada dalam arraynya adalah function yang ada pada class modelnya 
    protected $with = ['category', 'author'];

    // todo 
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    // cara untuk mengubungkan antar table yaitu dengan memberi foreign key pada migrations lalu untuk diberi function yang di dalamnya adalah kolom foreign key, nama dari function tadi akan di panggil apabila dibutuhkan, jadi apabila ingin memanggil kolom pada table lain yang telah di foreign key maka dapat dipanggil dengan memanggil nama function yang dibuat
    public function author()
    {
        return  $this->belongsTo(User::class, 'user_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%');
        });

        $query->when($filters['category'] ?? false, function ($query, $category) {
            // whereHas adalah sebuah method untuk melakukan join table dimana akan menggabungkan 2 table. seperti pada contohnya adalah menggunakan category yang dimana category adalah sebuah relationship yang ada di table post
            // yang ditulis dalam whereHas adalah nama relationship
            return $query->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        });
        // $query->when($filters['author'] ?? false, function ($query, $author) {
        //     return $query->whereHas('author', function ($query) use ($author) {
        //         $query->where('username', $author);
        //     });
        // });
        // Menggunakan arrow function
        $query->when(
            $filters['author'] ?? false,
            fn ($query, $author) =>
            $query->whereHas(
                'author',
                fn ($query) =>
                $query->where('username', $author)
            )
        );
    }
    // todo getRouteKeyName adalah sebuah method yang digunakan untuk melakukan proses pencarian apabila ingin mengcustom pencarian menggunakan nama kolom lain, karena pada defaultnya akan menggunakan id
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                // title diambil dari kolom database mana yang akan di generate slug
                'source' => 'title'
            ]
        ];
    }
}
