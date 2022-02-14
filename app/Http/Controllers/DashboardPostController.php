<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
// use Clockwork\Storage\Storage;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.posts.index', [
            'posts' => Post::where('user_id', auth()->user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.posts.create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->file('image')->store('post-images');
        $validateData = $request->validate([
            'title' => 'required|max:255',
            //* unique akan mengambil nama dari table di database jadi nantinya akan mengambil dari table posts
            'slug' => 'required|unique:posts',
            'category_id' => 'required',
            'image' => 'image|file|max:1024',
            'body' => 'required'
        ]);

        if ($request->file('image')) {
            $validateData['image'] = $request->file('image')->store('post-images');
        }

        $validateData['user_id'] = auth()->user()->id;
        // * Str::limit digunakan untuk memotong String (jumlah yang diambil adalah jumlah karakter bukan jumlah kata), kemudian strip_tags digunakan untuk menghilangkan tags html seperti h1, p, dll. jadi isi setelah di strip_tags hanya tulisan
        $validateData['excerpt'] = Str::limit(strip_tags($request->body), 200);

        Post::create($validateData);

        return redirect('/dashboard/posts')->with('success', 'New post has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('dashboard.posts.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', [
            'post' => $post,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Post $post)
    {
        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'image' => 'image|file|max:1024',
            'body' => 'required'
        ];

        // * apabila nantinya slug baru tidak sama dengan slug yang ada di database maka nantinya akan di proses, tapi jika tidak sama maka akan langsung di proses ke update
        if ($request->slug != $post->slug) {
            $rules['slug'] = 'required|unique:posts';
        }

        $validateData = $request->validate($rules);
        if ($request->file('image')) {
            // Menggunakan method delete yang ada di class Storage untuk menghapus apabila ada gambar lama yang sudah digunakan dalam post tersebut sehingga nantinya gambar baru yang diupload tidak tertumpuk di dalam storage
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }

            $validateData['image'] = $request->file('image')->store('post-images');
        }
        $validateData['user_id'] = auth()->user()->id;
        $validateData['excerpt'] = Str::limit(strip_tags($request->body), 200);

        Post::where('id', $post->id)
            ->update($validateData);

        return redirect('/dashboard/posts')->with('success', 'Post has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::delete($post->image);
        }
        Post::destroy($post->id);
        return redirect('/dashboard/posts')->with('success', 'Post has been deleted!');
    }

    public function checkSlug(Request $request)
    {
        // createSlug nantinya akan mengambild ari class Post, kemudian mengambil field dari class post juga dalam hal ini adalah slug jadi dituliskan 'slug' , kemudian parameter terakhirnya dalah title yang nantinya akan di ubah menjadi slug secara otomatis
        // setelah itu akan direturn sebagai response kemudian diberi bentuk sebagai json supaya nantinya dapat diolah oleh method json yang ada di file create, yang isinya adalah array assosiative yang isinya 'slug' => $slug (MENURUT SAYA : jika dilihat dari file create yaitu nantinya nilai akhir adalah data.slug nah .slug adalah object yang ada dalam array assosiative)
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}
