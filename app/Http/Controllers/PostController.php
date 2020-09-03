<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Repositories\Contracts\IAttachmentRepo;
use App\Repositories\Contracts\IPostRepo;
use App\Repositories\Contracts\ITagRepo;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $post_repo;
    protected $tag_repo;
    protected $attachment_repo;

    function __construct( IPostRepo $post_repo, ITagRepo $tag_repo, IAttachmentRepo $attachment_repo ) {

        $this->middleware('auth')->except( ['index', 'show', 'showPostsByTag'] );

        $this->post_repo = $post_repo;
        $this->tag_repo = $tag_repo;
        $this->attachment_repo = $attachment_repo;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->post_repo->all();
        return view('dashboard', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $tags = $this->tag_repo->all();

        return view('posts.create-post', ['tags' => $tags]);

    }

    /**
     * @param StorePost $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StorePost $request)
    {
        // Validation
//        $request->validated();

        // Fill with data
        $post_data = [
            'title' => $request->input('title'),
            'description' => $request->input('description')
        ];

        // Create Thumbnail if exist
        if( $request->file('thumbnail') ) {
            $path = $request->file('thumbnail')->store('public/posts');
            $attachment = $this->attachment_repo->create($path);
            $post_data['thumbnail_id'] = $attachment->id;
        }

        // Get Tags if exist
        $tags_id = $request->input('tags');
        if( $tags_id ) {
            $post_data['tags'] = $this->tag_repo->getByIds($tags_id);
        }

        // Create Post
        $this->post_repo->create($post_data);

        return redirect('dashboard');

    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {

        $post = $this->post_repo->getPostBySlug($slug);

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

    public function showPostsByTag($slug) {

        $tag = $this->tag_repo->getTagBySlugWithPosts($slug);

        return view('dashboard', ['posts' => $tag->posts]);

    }

}
