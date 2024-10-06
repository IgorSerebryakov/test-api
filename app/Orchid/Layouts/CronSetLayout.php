<?php

namespace App\Orchid\Layouts;

use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class CronSetLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Select::make('set_cron')
                ->options(Cache::get('tasks_cron'))
                ->empty()
                ->required()
                ->title('Select cron')
        ];
    }
}
