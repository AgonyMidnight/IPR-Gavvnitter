<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::first();
        //$post = Post::with('comments.author')->first();
        $post = Post::with('comments.author')->first();

        DB::beginTransaction();
        try {
            $comments = $post->comments;
            $com = $comments->first()->toArray();

            $this->info($comments);

            $this->info('success');
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }
        DB::rollBack();
        return 0;
    }
}
