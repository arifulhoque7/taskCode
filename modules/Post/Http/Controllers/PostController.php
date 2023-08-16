<?php

namespace Modules\Post\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Post\Entities\Post;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Post\DataTables\PostDataTable;
use Illuminate\Contracts\Support\Renderable;
use App\Notifications\PostPublishedNotification;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'permission:post_management']);
        $this->middleware('request:ajax', ['only' => ['store', 'update', 'destroy', 'edit']]);
        \cs_set('theme', [
            'title' => 'Post Lists',
            'back' => \back_url(),
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard'),
                ],
                [
                    'name' => 'Post Lists',
                    'link' => false,
                ],
            ],
            'rprefix' => 'posts',
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(PostDataTable $dataTable)
    { 
        // dd();
        
        $checkFreeUser = Post::isFreeMembership();
        if($checkFreeUser){
            $checkPostCount = Post::freePostCount();
        }
    
        return $dataTable->render('post::post.index', [
            'checkFreeUser' => $checkFreeUser,
            'checkPostCount' => $checkPostCount ?? null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('post::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'publish_time' => 'required',
            'status' => 'required|integer',
        ]);

        $checkFreeUser = Post::isFreeMembership();
        if($checkFreeUser){
            $checkPostCount = Post::freePostCount();
        }

        $post = Post::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'publish_time' => $data['publish_time'],
            'status' => $data['status'],
        ]);
        $post['checkPostCount'] = $checkPostCount ?? null;
        return response()->success($post, 'Room Type created successfully.', 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('post::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Request $request)
    {
        $post = Post::find($request->id);
        if (!$post) {
            return response()->error(null, 'post not found.', 404);
        }

        return response()->success([
            'post' => $post
        ], 'post data fetched successfully.', 200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:posts,id',
            'title' => 'required',
            'description' => 'required',
            'publish_time' => 'required',
            'status' => 'required|integer',

        ]);
        $editPost = Post::find($request->id);

        if (\auth()->user()->id != $editPost->user_id || $editPost->is_published != 0) {
            return response()->error([], 'You can\'t update this Post.', 403);
        }

        $editPost->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'publish_time' => $data['publish_time'],
            'status' => $data['status'],
        ]);

        return response()->success($editPost, 'Post updated successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->success(null, 'Post deleted successfully.', 200);
    }

    public function publishStatusUpdate(Post $post, Request $request)
    {
        // dd($request->all());
        if (\auth()->user()->id != $post->user_id) {
            return \response()->error([], 'You can\'t update this status.', 403);
        }
        $post->update(['is_published' => $request->is_published]);

        if($request->is_published == 1){
            $admins = User::role('Administrator')->get();
            foreach ($admins as $admin) {
                $admin->notify(new PostPublishedNotification($post));
            }
        }

        return \response()->success($post, 'Post Status Updated Successfully.', 200);
    }

    public function membershipStatusChange()
    {
        $user = User::find(auth()->user()->id);

        
        $user->update(['membership_notification' => 1]);
        

        return response()->success($user, 'Request sent successfully.', 200);
    }
}
