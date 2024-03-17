<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskAnswerResource\Pages;
use App\Filament\Resources\TaskAnswerResource\RelationManagers;
use App\Models\TaskAnswer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskAnswerResource extends Resource
{
    protected static ?string $model = TaskAnswer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('task_id')
                    ->relationship('task', 'id')
                    ->required(),
                Forms\Components\Select::make('question_id')
                    ->relationship('question', 'name')
                    ->required(),
                Forms\Components\Select::make('option_id')
                    ->relationship('option', 'name')
                    ->required(),
                Forms\Components\TextInput::make('score')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('task.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('question.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('option.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTaskAnswers::route('/'),
            'create' => Pages\CreateTaskAnswer::route('/create'),
            'edit' => Pages\EditTaskAnswer::route('/{record}/edit'),
        ];
    }
}
