<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Post\Entities\Post;
use Illuminate\Support\Facades\Cache;

class FrontEndController extends Controller
{
    public function index()
    {
        $page = request('page', 1);
        $perPage = 10;
        $cacheKey = "frontend.home.$page";
        $cacheTime = 60;

        $allPosts = Cache::remember($cacheKey, $cacheTime, function ()  use ($perPage)  {
            return Post::where('is_published', 1)->orderBy('publish_time', 'desc')->paginate($perPage);
        });
        return view('post', compact('allPosts'));
    }
}
