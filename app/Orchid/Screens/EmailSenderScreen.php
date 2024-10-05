<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\CronSaveLayout;
use App\Orchid\Layouts\CronSetLayout;
use Illuminate\Http\Request;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;
use Predis\Client;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;

class EmailSenderScreen extends Screen
{
    public Client $redis;

    public function __construct()
    {
        $this->redis = new Client('tcp://predis:6379');
    }
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
            Button::make('Send messages now')
                ->icon('paper-plane')
                ->method('sendEmails')
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
        $this->redis->set('tasks_uncompleted_cron', $request->get('set_cron'));
        Toast::info('Cron was saved in scheduler');
    }
}
