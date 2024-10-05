<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\CronSaveLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Predis\Client;

class CronEditScreen extends Screen
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
        return 'CronEditScreen';
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

    public function saveCron(Request $request): void
    {
        $newCronExpression = [
            $request->get('expression') => $request->get('name')
        ];

        $cronExpressions = $this->redis->get('cron_expressions');
        $cronExpressions = $cronExpressions ? json_decode($cronExpressions, true) : [];

        if (!in_array($newCronExpression, $cronExpressions)) {
            $cronExpressions[] = $newCronExpression;
        }

        $this->redis->set('cron_expressions', json_encode($cronExpressions));

        Toast::info('Cron was added.');
    }
}
