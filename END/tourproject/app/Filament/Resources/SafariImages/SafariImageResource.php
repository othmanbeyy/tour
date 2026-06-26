<?php

namespace App\Filament\Resources\SafariImages;

use App\Filament\Resources\SafariImages\Pages\CreateSafariImage;
use App\Filament\Resources\SafariImages\Pages\EditSafariImage;
use App\Filament\Resources\SafariImages\Pages\ListSafariImages;
use App\Models\SafariImage;
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

class SafariImageResource extends Resource
{
    protected static ?string $model = SafariImage::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Safari Images';

    public static function getNavigationGroup(): string | UnitEnum | null
    {
        return 'Contact';
    }

    protected static ?string $recordTitleAttribute = 'image_path';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('safari_id')
                ->relationship('safari', 'title')
                ->required(),

            FileUpload::make('image_path')
                ->image()
                ->directory('safari-images')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('image_path')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('safari.title')->label('Safari')->searchable()->sortable(),
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
            'index' => ListSafariImages::route('/'),
            'create' => CreateSafariImage::route('/create'),
            'edit' => EditSafariImage::route('/{record}/edit'),
        ];
    }
}
