<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Image;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
    // Trang quản lý customer
    public function manageCustomers()
    {
        $customers = Customer::all();
        return view('admin.customer.index', compact('customers'));
    }

    // Duyệt customer
    public function approveCustomer($id)
    {
        $customer = Customer::find($id);
        $customer->is_approved = 1;
        $customer->save();
        return redirect()->route('admin.customers')->with('message', 'Khach hàng đã được duyệt thành công');
    }

    // Chuyển trạng thái customer về chưa duyệt
    public function disapproveCustomer($id)
    {
        $customer = Customer::find($id);
        $customer->is_approved = 0;
        $customer->save();
        return redirect()->route('admin.customers')->with('message', 'Hủy thành công khách hàng');
    }
    public function deleteCustomer(Request $request, $id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $customer->delete();
        }
        return redirect()->route('admin.customers')->with('message', 'Khach hàng đã được xóa thành công');;
    }





    // Quản lý comment
    public function manageComments()
    {
        $comments = Comment::with('post', 'customer')->get();
        return view('admin.comments.index', compact('comments'));
    }

    // Xóa comment
    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->route('admin.posts.title',$comment->post_id)
            ->with('success', 'Comment deleted successfully');
    }




    // Quản lý post
    public function adminindex(Request $request)
    {
        $query = $request->input('query');
        $posts = Post::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->with('category', 'images')
            ->get();

        $categories = Category::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        return view('admin.posts.index', compact('posts', 'categories', 'query'));
    }

    public function admincreate()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function adminstore(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post = Post::create($data);

        if ($request->hasFile('images')) {
            // Code to handle image upload and attach to post
        }

        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }

    public function admintitle($id)
    {
        $post = Post::with('category', 'images', 'comments.customer', 'ratings')->findOrFail($id);
        $comments = $post->comments;
        $categories = Category::all();
        $averageRating = $post->ratings->avg('rating');

        return view('admin.posts.title', compact('post', 'comments', 'averageRating','categories'));
    }

    public function adminshow($id)
    {
        $categories = Category::all();
        $post = Post::with('category', 'images', 'comments.customer', 'ratings')->findOrFail($id);
        return view('admin.posts.show', compact('post', 'categories'));
    }

    public function adminupdate(Request $request, Post $post)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post->update($data);

//        if ($request->hasFile('images')) {
//            foreach ($request->file('images') as $image) {
//                $path = $image->store('images', 'public');
//
//                // Assuming you have a PostImage model to store image paths related to posts
//                Image::create([
//                    'post_id' => $request->id,
//                    'path' => $path,
//                ]);
//            }
//        }
//            if (($post->images()->exists())) {
//                foreach ($post->images as $image) {
//                    Storage::disk('public')->delete($image->path); // Xóa ảnh khỏi hệ thống file
//                    $image->delete(); // Xóa bản ghi ảnh trong cơ sở dữ liệu
//                }
//            }
//
////             Lưu ảnh mới (nếu có)
//            if ($request->hasFile('image')) {
//                $imageFile = $request->file('image');
//                $path = $imageFile->store('images', 'public');
//
//                Image::create([
//                    'post_id' => $post->id,
//                    'path' => $path,
//                ]);
//            }
        if ($request->hasFile('image')) {
            // Delete old images
            foreach ($post->images as $image) {
                Storage::delete('public/' . $image->path);
                $image->delete();
            }

            // Store new image
            $image = $request->file('image')->store('posts', 'public');
            $post->images()->create(['path' => $image]);
        }

        return redirect()->route('admin.posts' )->with('success', 'Post updated successfully');
    }

    public function admindestroy( $id)
    {
        $category = Post::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.posts')->with('success', 'Post deleted successfully');
    }

    public function postsByCategory($id)
    {
        $category = Category::with('posts')->findOrFail($id);
        $posts = $category->posts;

        return view('admin.posts.index', compact('posts', 'category'));
    }


}
