<?php

namespace Modules\Post\Entities;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Notifications\PostPublishedNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'publish_time',
        'status',
        'is_published'
    ];
    protected static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            static::creating(function ($model) {
                $model->user_id = Auth::id();
            });
            if(auth()->user()->membership == 0){
                self::created(function ($model) {
                    $model->is_published = 1;
                    $model->save();
                    //send post published notification to admin
                    $admins = User::role('Administrator')->get();
                    foreach ($admins as $admin) {
                        $admin->notify(new PostPublishedNotification($model));
                    }
                });
            }
        }

        static::addGlobalScope('sortByLatest', function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function publishStatusList() : array
    {
        return [
            0   => 'Not Pusblished',
            1   => 'Published',
        ];
    }

    public static function isFreeMembership()
    {
        return auth()->user()->membership == 0 ? true : false;
    }
    public static function freePostCount()
    {
        return Post::where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->count();
    }
}
