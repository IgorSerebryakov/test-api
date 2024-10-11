<?php

namespace App\Orchid\Screens\TaskStatus;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class TaskStatusEditScreen extends Screen
{
    public $status;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(?TaskStatus $task_status): iterable
    {
        return [
            'status' => $task_status ?? new TaskStatus()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->status->exists ? 'Edit task status' : 'Creating a new task status';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
           Button::make('Create task status')
            ->icon('pencil')
            ->method('createOrUpdate')
            ->canSee(!$this->status->exists),

           Button::make('Update')
           ->icon('note')
           ->method('createOrUpdate')
           ->canSee($this->status->exists),

           Button::make('Remove')
           ->icon('trash')
           ->method('remove')
           ->canSee($this->status->exists)
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
            Layout::rows([
                Input::make('task_status.name')
                ->title('name')
                ->placeholder('Name of task status')
                ->required()
            ])
        ];
    }

    public function createOrUpdate(Request $request)
    {
        $this->status ?? $this->status = new TaskStatus();

        $this->status->fill($request->get('task_status'))->save();

        Alert::info('You have successfully created a task status');

        return redirect()->route('platform.task-status.list');
    }

    public function remove()
    {
        $this->status->delete();

        Alert::info('You have successfully deleted the post');

        return redirect()->route('platform.task-status.list');
    }
}
