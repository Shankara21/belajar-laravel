<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
// use App\Model\Category;

class PostController extends Controller
{
    public function index()
    {
        //todo Logika!
        //todo  apabila ada sesuatu yang dituliskan kemudian di search maka nantinya akan masuk kedalam if telebih dahulu kemudian diproses dan akan menghasilkan seperti apa yang dicari, apabila tidak melakukan sebuah pencarian maka nantinya akan langsung ditampilkan postingan yang terbaru menggunakan latest
        $title = '';
        if (request('category')) {
            $category = Category::firstWhere('slug', request('category'));
            $title = ' in ' . $category->name;
        }
        if (request('author')) {
            $author = User::firstWhere('username', request('author'));
            $title = ' by ' . $author->name;
        }

        return view('posts', [
            "title" => "All Posts" . $title,
            "active" => 'posts',
            "posts" => Post::latest()->filter(request(['search', 'category', 'author']))->paginate(7)->withQueryString()
        ]);
    }
    public function show(Post $post)
    {
        return view('post', [
            "title" => "Single Post",
            "active" => 'posts',
            "tes" => $post
        ]);
    }
    public function about()
    {
        return view('about', [
            "name" => "Muhamamd Lazuardi Timur",
            "active" => 'about',
            "email" => "lazuardit21@gmail.com",
            "foto" => "timur.jpg",
            "title" => "About"
        ]);
    }
    public function category(Category $category)
    {
        return view('posts', [
            "title" => "Post by Category : $category->name",
            "active" => 'categories',
            "posts" => $category->posts->load('category', 'author')
            // "category" => $category->name
        ]);
    }
    public function categories()
    {
        return view('categories', [
            "title" => "Post Categories",
            "active" => 'categories',
            "categories" => Category::all()
        ]);
    }
}
