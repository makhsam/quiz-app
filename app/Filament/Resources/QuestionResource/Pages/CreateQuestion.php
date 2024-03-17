<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use App\Filament\Resources\QuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateQuestion extends CreateRecord
{
    protected static string $resource = QuestionResource::class;

    public function afterCreate()
    {
        // create options
        foreach ($this->data['options'] as $option) {
            $this->record->options()->create([
                'name' => $option['name'],
                'is_correct' => $option['is_correct'],
            ]);
        }
    }
}
