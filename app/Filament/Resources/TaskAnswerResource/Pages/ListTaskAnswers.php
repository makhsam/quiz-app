<?php

namespace App\Filament\Resources\TaskAnswerResource\Pages;

use App\Filament\Resources\TaskAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaskAnswers extends ListRecords
{
    protected static string $resource = TaskAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
