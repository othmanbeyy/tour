<?php

namespace App\Filament\Resources\Safaris;

use App\Filament\Resources\Safaris\Pages\CreateSafari;
use App\Filament\Resources\Safaris\Pages\EditSafari;
use App\Filament\Resources\Safaris\Pages\ListSafaris;
use App\Models\Safari;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SafariResource extends Resource
{
    protected static ?string $model = Safari::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Safaris';

    public static function getNavigationGroup(): string | UnitEnum | null
    {
        return 'Contact';
    }

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->required()
                ->maxLength(255),

            Textarea::make('highlights')
                ->rows(4),

            Textarea::make('description')
                ->rows(6),

            TextInput::make('price')
                ->numeric()
                ->required(),

            TextInput::make('duration')
                ->maxLength(255),

            Textarea::make('included')
                ->rows(4),

            Textarea::make('itinerary')
                ->rows(6),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('price')->label('Price')->sortable(),
                TextColumn::make('duration')->label('Duration'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListSafaris::route('/'),
            'create' => CreateSafari::route('/create'),
            'edit' => EditSafari::route('/{record}/edit'),
        ];
    }
}
