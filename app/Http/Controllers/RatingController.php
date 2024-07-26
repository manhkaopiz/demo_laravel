<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request,  $post)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
        ]);

        Rating::create([
            'rating' => $request->rating,
            'post_id' => $post,
            'customer_id' => Auth::id(),
        ]);

        return redirect()->route('posts.show', $post);
    }
}
