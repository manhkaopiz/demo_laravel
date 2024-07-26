<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        Comment::create([
            'content' => $request->input('content'),
            'post_id' => $post,
            'customer_id' => Auth::id(),
        ]);

        return redirect()->route('posts.show', $post);
    }
    public function destroy($id)
    {

        $comment = Comment::findOrFail($id);

        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
