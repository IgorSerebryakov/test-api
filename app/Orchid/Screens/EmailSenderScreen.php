<?php

namespace App\Orchid\Screens;

use Hamcrest\Core\Every;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
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
        return [
            'cron' => config('cron_expression'),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Email sender";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Send to emails now')
                ->icon('paper-plane')
                ->method('?')
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
                Select::make('cron')
                    ->options([
                        '* * * * *' => 'Every minute',
                        '*/2 * * * *' => 'Every 2 minutes',
                        '*/30 * * * *' => 'Every 30 minutes',
                        '0 * * * *' => 'Every hour'
                    ])
                ->title('Select cron')
            ])
        ];
    }

    public function setCron(Request $request)
    {
        Redis::command('set', [
            'tasks_uncompleted_cron', $request->get('cron')
        ]);
    }

    public function sendMessage()
    {

    }
}
