<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Post;
use App\Category;
use App\Tag;
use Session;

class PostController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create', compact(['categories', 'tags']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate(request(), [
            'title' => 'required|max:255',
            'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
            'category_id' => 'required|integer',
            'body'  => 'required'
        ]);

        $post = new Post();
        $post->title = request('title');
        $post->slug = request('slug');
        $post->category_id = request('category_id');
        $post->body = request('body');

        $post->save();

        $post->tags()->sync(request('tags'), false);

        Session::flash('message', 'Your Post Was Saved!');
        return redirect('/posts/' . $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // $post = Post::find($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.edit', compact(['post', 'categories', 'tags']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if (Input::get('cancel')) return $this->show($post);

        if (request('slug') === $post->slug) {
            $this->validate(request(), [
                'title' => 'required',
                'category_id' => 'required|integer',
                'body' => 'required'
            ]);
        } else {
            $this->validate(request(), [
                'title' => 'required',
                'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
                'category_id' => 'required|integer',
                'body' => 'required'
            ]);
        }

        $post->title = request('title');
        $post->slug = request('slug');
        $post->category_id = request('category_id');
        $post->body  = request('body');

        $post->update();

        $post->tags()->sync(request('tags') === null ? [] : request('tags'), true);

        Session::flash('message', 'Your Post Was Updated!');        
        return redirect('/posts/' . $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->tags()->detach();     // Removes any reference to this post from the many-to-many post_tag table
        $post->delete();
        
        Session::flash('message', 'Post Deleted!');
        return redirect('/posts');
    }
}
