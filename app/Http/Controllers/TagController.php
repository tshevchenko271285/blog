<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTag;
use App\Http\Requests\UpdateTag;
use App\Services\Contracts\ITagService;

class TagController extends Controller
{
    /**
     * @var ITagService
     */
    private $tagService;

    function __construct( ITagService $tagService ) {
        $this->middleware('auth')->except( ['show'] );
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tags.index', ['tags' => $this->tagService->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * @param StoreTag $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTag $request)
    {
        $this->tagService->create($request);
        return redirect()->route('tags.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('tags.edit', ['tag' => $this->tagService->getById($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTag $request, $id)
    {
        $this->tagService->updateNameById($id, $request);
        return redirect()->route('tags.index');
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
