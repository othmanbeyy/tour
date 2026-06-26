<?php

namespace App\Filament\Resources\BlogImages;

use App\Filament\Resources\BlogImages\Pages\CreateBlogImage;
use App\Filament\Resources\BlogImages\Pages\EditBlogImage;
use App\Filament\Resources\BlogImages\Pages\ListBlogImages;
use App\Models\BlogImage;
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

class BlogImageResource extends Resource
{
    protected static ?string $model = BlogImage::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Blog Images';

    public static function getNavigationGroup(): string | UnitEnum | null
    {
        return 'Contact';
    }

    protected static ?string $recordTitleAttribute = 'image_path';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('blog_id')
                ->relationship('blog', 'title')
                ->required(),

            FileUpload::make('image_path')
                ->image()
                ->directory('blog-images')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('image_path')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('blog.title')->label('Blog')->searchable()->sortable(),
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
            'index' => ListBlogImages::route('/'),
            'create' => CreateBlogImage::route('/create'),
            'edit' => EditBlogImage::route('/{record}/edit'),
        ];
    }
}
