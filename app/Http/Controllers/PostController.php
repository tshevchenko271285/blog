<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Http\Requests\UpdatePost;
use App\Services\Contracts\IPostService;

class PostController extends Controller
{
    /**
     * @var IPostService
     */
    protected $postService;

    /**
     * PostController constructor.
     * @param IPostService $postService
     */
    function __construct( IPostService $postService ) {
        $this->middleware('auth')->except( ['index', 'show', 'showPostsByTag'] );
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard', ['posts' => $this->postService->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create-post', ['tags' => $this->postService->getTags()]);
    }

    /**
     * @param StorePost $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StorePost $request)
    {
        $this->postService->store($request);
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
        return view('posts.post', ['post' => $this->postService->getPostBySlug($slug)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        return view('posts.edit-post', $this->postService->getDataEditPostBySlug($slug));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePost $request, $id)
    {
        $this->postService->update($id, $request);
        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->postService->delete($id);
        return redirect()->route('dashboard');
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPostsByTag($slug)
    {
        return view('dashboard', ['posts' => $this->postService->getPostsByTagSlug($slug)]);
    }
}
