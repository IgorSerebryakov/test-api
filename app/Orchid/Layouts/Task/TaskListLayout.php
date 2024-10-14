<?php

namespace App\Orchid\Layouts\Task;

use App\Models\Task;
use Carbon\Carbon;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TaskListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'tasks';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', 'Title')
            ->render(function (Task $task) {
                return Link::make($task->name)
                    ->route('platform.task.edit', $task);
            }),

            TD::make('created_at', 'Created')
                ->render(function (Task $task) {
                    return $task->created_at;
                }),

            TD::make('updated_at', 'Last edit')
                ->render(function (Task $task) {
                    return $task->updated_at;
                })
        ];
    }
}
