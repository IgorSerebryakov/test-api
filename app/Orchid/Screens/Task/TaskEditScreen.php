<?php

namespace App\Orchid\Screens\Task;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class TaskEditScreen extends Screen
{
    public $task;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Task $task): iterable
    {
        return [
            'task' => $task
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->task->exists ? 'Edit task' : 'Creating a new task';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Create')
            ->icon('pencil')
            ->method('create')
            ->canSee(!$this->task->exists),

            Button::make('Update')
            ->icon('note')
            ->method('update')
            ->canSee($this->task->exists),

            Button::make('Remove')
            ->icon('trash')
            ->method('delete')
            ->canSee($this->task->exists)
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
                Input::make('task.name')
                ->title('Title')
                ->required(),

                Relation::make('task.user_id')
                ->title('Author')
                ->fromModel(User::class, 'name')
                ->required(),

                Relation::make('task.status_id')
                ->title('Status')
                ->fromModel(TaskStatus::class, 'name')
                ->required()
            ])
        ];
    }

    public function create(Request $request)
    {
        $this->task->fill($request->get('task'))->save();

        Alert::info('You have successfully created a task');

        return redirect()->route('platform.task.list');
    }

    public function update(Request $request)
    {
        $this->task->fill($request->get('task'))->save();

        Alert::info('You have successfully updated a task');

        return redirect()->route('platform.task.list');
    }

    public function delete()
    {
        $this->task->delete();

        Alert::info('You have successfully deleted the task');

        return redirect()->route('platform.task.list');
    }
}
