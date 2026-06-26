<?php

namespace App\Filament\Resources\TourImages;

use App\Filament\Resources\TourImages\Pages\CreateTourImage;
use App\Filament\Resources\TourImages\Pages\EditTourImage;
use App\Filament\Resources\TourImages\Pages\ListTourImages;
use App\Models\TourImage;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TourImageResource extends Resource
{
    protected static ?string $model = TourImage::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Tour Images';

    public static function getNavigationGroup(): string | UnitEnum | null
    {
        return 'Tourism';
    }

    protected static ?string $recordTitleAttribute = 'image_path';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('tour_id')
                ->relationship('tour', 'title')
                ->required(),

            FileUpload::make('image_path')
                ->image()
                ->directory('tour-images')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('image_path')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('tour.title')->label('Tour')->searchable()->sortable(),
                ImageColumn::make('image_path')->label('Image'),
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
            'index' => ListTourImages::route('/'),
            'create' => CreateTourImage::route('/create'),
            'edit' => EditTourImage::route('/{record}/edit'),
        ];
    }
}
