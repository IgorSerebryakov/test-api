<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Predis\Client;

class CronSetLayout extends Rows
{
    public Client $redis;

    public function __construct()
    {
        $this->redis = new Client('tcp://predis:6379');
    }
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Select::make('set_cron')
                ->options($this->getOptions())
                ->empty()
                ->required()
                ->title('Select cron')
        ];
    }

    private function getOptions()
    {
        $cronExpressions = $this->redis->get('cron_expressions');

        $cronExpressions = $cronExpressions ? json_decode($cronExpressions, true) : [];

        return array_merge(...$cronExpressions);
    }
}
