<?php

namespace App\Console\Commands;

use App\Mail\UncompletedTasks;
use App\Models\Task;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendUncompletedTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:uncompleted-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails with uncompleted tasks to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::query()
            ->whereHas('tasks', function ($query) {
                $query->where('status_id', 2);
            })->get();

        foreach ($users as $user) {
            $uncompletedTasks = Task::query()
                ->where('user_id', $user->id)
                ->where('status_id', 2)
                ->get();

            Mail::to($user->email)->send(new UncompletedTasks($uncompletedTasks));
        }
    }
}
