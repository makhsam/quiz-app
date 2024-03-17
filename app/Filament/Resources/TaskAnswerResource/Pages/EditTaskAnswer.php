<?php

namespace App\Filament\Resources\TaskAnswerResource\Pages;

use App\Filament\Resources\TaskAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTaskAnswer extends EditRecord
{
    protected static string $resource = TaskAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
