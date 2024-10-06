<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\CronSaveLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CronEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Add cron';
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
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [

            Layout::block(CronSaveLayout::class)
                ->title('Add Cron')
                ->description('Add your own cron.')
                ->commands(
                    Button::make('Save')
                        ->type(Color::DARK)
                        ->icon('bs.check-circle')
                        ->method('saveCron')
                )
        ];
    }

    public function saveCron(Request $request)
    {
        $newCronExpression = [
            $request->get('expression') => $request->get('name')
        ];

        $cronExpressions = Cache::get('tasks_cron') ?? [];

        Cache::set('tasks_cron', array_merge($cronExpressions, $newCronExpression));

        Toast::info('Cron was added.');

        return redirect()->route('platform.email');
    }
}
