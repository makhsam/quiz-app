<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use App\Filament\Resources\QuestionResource;
use App\Models\QuestionOption;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuestion extends EditRecord
{
    protected static string $resource = QuestionResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['options'] = $this->record->options
            ->map(function ($option) {
                return $option->only('id', 'name', 'is_correct');
            })
            ->all();

        return $data;
    }

    public function afterSave()
    {
        foreach ($this->data['options'] as $option) {
            $questionOption = QuestionOption::find($option['id']);
            $questionOption->update($option);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
