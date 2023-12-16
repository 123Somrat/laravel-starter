<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct()
    {
//        $this->middleware(['auth', 'clearance'])->except('index', 'show');
    }

    public function index(): View
    {
        $data = array();
        $data['posts'] = Post::orderby('id', 'desc')->paginate(5); //show only 5 items at a time in descending order

        return view('admin.pages.posts.index')->with($data);
    }

    public function create(): View
    {
        return view('admin.pages.posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'title' => 'required|max:100',
            'body'  => 'required',
        ]);

        $post = Post::create($request->only('title', 'body'));

        return redirect(route('admin.posts.index'))->with('msg', 'Article, ' . $post->title . ' created');
    }

    public function show($id): View
    {
        $post = Post::findOrFail($id); //Find post of id = $id

        return view('admin.pages.posts.show', compact('post'));
    }

    public function edit($id): View
    {
        $post = Post::findOrFail($id);

        return view('admin.pages.posts.edit', compact('post'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'title' => 'required|max:100',
            'body'  => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        return redirect(route('admin.posts.index', $post->id))->with('msg', 'Article, ' . $post->title . ' updated');
    }

    public function destroy($id): RedirectResponse
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect(route('admin.posts.index'))->with('msg', 'Article successfully deleted');
    }
}
