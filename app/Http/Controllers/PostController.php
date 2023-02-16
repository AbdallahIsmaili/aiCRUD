<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('feed', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add-blog');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        Post::create([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return response('Inserting Done...');

        
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $posts = Post::onlyTrashed()->get();
        return view('archive', compact('posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::findorFail($id);
        return view('edit-blog', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $post = Post::findorFail($id);
        $post->title = $request->title;
        $post->content = $request->content;
 
        $post->save();

        
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Post::findorFail($id)->delete();

        return redirect()->route('posts.index');
    }

    public function latest(){
        $posts = Post::get();
        return view('latest', compact('posts'));
    }

    public function restore($id){
        $post = Post::onlyTrashed()->where('id', $id)->restore();
        return redirect()->back();
    }
}
