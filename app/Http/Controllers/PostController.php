<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Image;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $posts = Post::where('title', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->with('category', 'images')
                ->get();
        } else {
            $posts = Post::with('category', 'images')->get();
        }

        return view('posts.index', compact('posts', 'query'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post = Post::create([
            'name' => $request->name,
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'status' => $request->status ? 1 : 0,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                Image::create([
                    'path' => $path,
                    'post_id' => $post->id,
                ]);
            }
        }

        return redirect()->route('posts.index');
    }


        public function show($id)
    {
        $post = Post::with('category', 'images', 'comments.customer', 'ratings')->findOrFail($id);
        $comments = $post->comments;
        $averageRating = $post->ratings->avg('rating');

        return view('posts.show', compact('post', 'comments', 'averageRating'));
    }


    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post->update([
            'name' => $request->name,
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'status' => $request->status ? 1 : 0,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                Image::create([
                    'path' => $path,
                    'post_id' => $post->id,
                ]);
            }
        }

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        // Xóa tất cả các hình ảnh liên quan trước khi xóa bài viết
        $post->images()->each(function ($image) {
            \Storage::disk('public')->delete($image->path);
            $image->delete();
        });

        $post->delete();

        return redirect()->route('posts.index');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $posts = Post::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->with('category', 'images')
            ->get();

        $categories = Category::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->with('posts', 'children')
            ->get();

        return view('posts.index', compact('posts', 'categories', 'query'));
    }
}
