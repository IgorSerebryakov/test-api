<?php

namespace App\Orchid\Screens\TaskStatus;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class TaskStatusEditScreen extends Screen
{
    public $status;


    public function query(TaskStatus $task_status): iterable
    {
        return [
            'status' => $task_status
        ];
    }

    public function name(): ?string
    {
        return $this->status->exists ? 'Edit task status' : 'Creating a new task status';
    }

    public function commandBar(): iterable
    {
        return [
           Button::make('Create')
            ->icon('pencil')
            ->method('create')
            ->canSee(!$this->status->exists),

           Button::make('Update')
           ->icon('note')
           ->method('update')
           ->canSee($this->status->exists),

           Button::make('Remove')
           ->icon('trash')
           ->method('remove')
           ->canSee($this->status->exists)
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('status.name')
                ->title('name')
                ->placeholder('Name of task status')
                ->required()
            ])
        ];
    }

    public function create(Request $request): RedirectResponse
    {
        $this->status->fill($request->get('task_status'))->save();

        Alert::info('You have successfully created a task status');

        return redirect()->route('platform.task-status.list');
    }

    public function update(Request $request): RedirectResponse
    {
        $this->status->fill($request->get('task_status'))->save();

        Alert::info('You have successfully updated a task status');

        return redirect()->route('platform.task-status.list');
    }

    public function delete(TaskStatus $status): RedirectResponse
    {
        $status->delete();

        Alert::info('You have successfully deleted the post');

        return redirect()->route('platform.task-status.list');
    }
}
