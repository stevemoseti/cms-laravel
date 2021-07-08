<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreatePostsRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('VerifyCategoryCount')->only(['create','store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts',Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories',Category::all())->with('tags',Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {
        // upload image to storage public folder
        $image = $request->image->store('posts','public');
        // create the post
        $post = Post::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'content'=>$request->content,
            'image'=>$image,
            'published_at'=>$request->published_at,
            'category_id'=>$request->category,
            'user_id'=>auth()->user()->id


        ]);
        //attaches the tags we selected in the frontend with the post that was newly created
        if($request->tags)
        {
            $post->tags()->attach($request->tags);
        }
        // flash message
        session()->flash('success','Post Created successfully.');
        // redirect user
        return redirect(route('posts.index'));

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
    public function edit(Post $post)
    {
        return view('posts.create')->with('post',$post)->with('categories',Category::all())->with('tags',Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $post)
    {

        $posts = Post::find($post);

        $posts->title=$request->input('title');
        $posts->description=$request->input('description');
        $posts->published_at=$request->input('published_at');
        $posts->content=$request->input('content');



        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();//getting image extension
            $filename = time().'.'.$extension;
            $file->move('storage/public/posts',$filename);
            $posts->image=$filename;
        }
// if($request->tags){
//     $post->tags()->sync($request->tags);
// }

        $posts->save();

        session()->flash('success','Post updated successfully');


        return redirect(route('posts.index'));








    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed()->where('id',$id)->firstOrFail();
        // $post->delete();

        if($post->trashed())
        {
            // deletes the file also from storage folder; has an issue of concern
            $post->deleteImage();
            $post->forceDelete();
        }
        else
        {
            $post->delete();
        }



            session()->flash('success','Post trashed successfully.');





        return redirect( route('posts.index') );

    }
     /**
     * display al alist of all trashed posts
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        //gets only trashed posts
        $trashed = Post::onlyTrashed()->get();


        return view('posts.index')->with('posts',$trashed);
    }
}
