<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class CronSaveLayout extends Rows
{
    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('expression')
                ->required()
                ->title('Cron expression')
                ->placeholder('* * * * *')
                ->value(''),

            Input::make('name')
                ->required()
                ->title('Cron name')
                ->placeholder('Every minute')
                ->value('')
        ];
    }
}
