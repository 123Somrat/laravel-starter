<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index() {
        $posts = Post::orderby('id', 'desc')->paginate(5);

        return view('admin.pages.dashboard', compact('posts'));
    }
}
