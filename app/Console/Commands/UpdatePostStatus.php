<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Console\Command;
use Modules\Post\Entities\Post;
use App\Notifications\PostPublishedNotification;

class UpdatePostStatus extends Command
{

    protected $signature = 'posts:update-status';
    protected $description = 'Update post statuses based on publish time';

    public function handle()
    {
        $currentTime = Carbon::now()->second(0);
        $currentTimeBD = $currentTime->copy()->setTimezone('Asia/Dhaka');

        $postsToUpdate = Post::where('publish_time', '=', $currentTimeBD)
            ->where('is_published', '=', 0)
            ->get();
        foreach ($postsToUpdate as $post) {
            $postUpdated = Post::find($post->id);
            $postUpdated->is_published = 1;
            $postUpdated->save();
            $admins = User::role('Administrator')->get();
            foreach ($admins as $admin) {
                $admin->notify(new PostPublishedNotification($post));
            }
        }

        $this->info('Post statuses updated.');
    }
}

// crontab -e
// * * * * * php /path-project/artisan schedule:run >> /dev/null 2>&1