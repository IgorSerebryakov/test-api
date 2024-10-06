<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\CronSetLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;

class EmailSenderScreen extends Screen
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
        return "Tasks-uncompleted email sender";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add cron')
                ->icon('bs.plus-circle')
                ->route('platform.cron.edit'),
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
            Layout::block(CronSetLayout::class)
            ->title('Set Cron')
            ->description('Update your frequency of sending messages.')
            ->commands(
                Button::make('Set')
                ->type(Color::DARK)
                ->icon('bs.check-circle')
                ->method('setCron')
            )
        ];
    }

    public function setCron(Request $request)
    {
        Cache::set('tasks_uncompleted_cron', $request->get('set_cron'));
        Toast::info('Cron was saved in scheduler');
    }
}
