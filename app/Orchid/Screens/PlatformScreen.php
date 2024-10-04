<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Orchid\Layouts\Examples\ChartBarExample;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $statusesNames = TaskStatus::query()->pluck('name')->all();

        $usersNames = User::query()->pluck('name')->all();

        $charts = array_map(function ($statusName) use ($usersNames) {
            return
                [
                    'name' => $statusName,
                    'values' => array_map(function ($userName) use ($statusName) {
                        return Task::query()
                            ->where([
                                ['status_id', TaskStatus::query()
                                    ->where('name', $statusName)
                                    ->pluck('id')
                                    ->first()],
                                ['user_id', User::query()
                                    ->where('name', $userName)
                                    ->pluck('id')
                                    ->first()]
                            ])
                            ->count('id');
                    }, $usersNames),
                    'labels' => $usersNames
                ];
        }, $statusesNames);

        return [
            'charts'  => $charts,

            'metrics' => [
                'users' => ['value' => User::query()->count('id')],
                'tasks' => [
                    'all' => ['value' => Task::query()->count('id')],
                ],
            ]
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Main';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Summary information about users, tasks and their statuses';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::metrics([
                'Users' => 'metrics.users',
                'Tasks' => 'metrics.tasks.all',
            ]),

            Layout::columns([
                ChartBarExample::make('charts', 'Users bar chart')
                    ->description('Shows users tasks')
            ])
        ];
    }
}
