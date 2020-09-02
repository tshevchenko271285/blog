<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{

    function __construct() {
        $this->middleware('auth')->only( ['create', 'store', 'edit', 'update', 'destroy'] );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->with('thumbnail')->get();
        return view('dashboard', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        return view('posts.create-post', ['tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|unique:posts|max:255',
            'description' => 'required|max:255',
        ];

        if( $request->file('thumbnail') ) {
            $rules['thumbnail'] = 'image';
        }

        $request->validate($rules);
        $post_data = [
            'slug' => Str::slug($request->input('title')),
            'title' => $request->input('title'),
            'description' => $request->input('description')
        ];
        if( $request->file('thumbnail') ) {
            $path = $request->file('thumbnail')->store('public/posts');
            $attachment = new Attachment(['path' => $path]);
            $attachment->save();
            $post_data['thumbnail_id'] = $attachment->id;
        }
        $post = Post::create($post_data);

        $tags_id = $request->input('tags');
        if( $tags_id ) {
            $tags = Tag::whereIn('id', $tags_id)->get();
            $post->tags()->attach($tags);
        }
//        return redirect()->route('posts.show', $post->id);
        return redirect('dashboard');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('thumbnail')->find($id);
        return view('posts.post', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
