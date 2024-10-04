<?php

namespace App\Orchid\Layouts\TaskStatus;

use App\Models\TaskStatus;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TaskStatusListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'statuses';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', 'Name')
            ->render(function (TaskStatus $status) {
                return Link::make($status->name)
                    ->route('platform.task-status.edit', $status);
            }),

            TD::make('created_at', 'Created'),
            TD::make('updated_at', 'Updated')
        ];
    }
}
