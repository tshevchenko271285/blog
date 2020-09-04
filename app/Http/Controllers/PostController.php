<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Services\Contracts\IPostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @var IPostService
     */
    protected $postService;

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

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPostsByTag($slug) {
        return view('dashboard', ['posts' => $this->postService->getPostsByTagSlug($slug)]);
    }
}
