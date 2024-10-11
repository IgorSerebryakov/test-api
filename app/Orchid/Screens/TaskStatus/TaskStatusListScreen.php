<?php

namespace App\Orchid\Screens\TaskStatus;

use App\Models\TaskStatus;
use App\Orchid\Layouts\TaskStatus\TaskStatusListLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class TaskStatusListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'statuses' => TaskStatus::query()->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Task Statuses';
    }

    public function description(): ?string
    {
        return 'All task statuses';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Create new')
            ->icon('pencil')
            ->route('platform.task-status.edit')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            TaskStatusListLayout::class
        ];
    }
}
