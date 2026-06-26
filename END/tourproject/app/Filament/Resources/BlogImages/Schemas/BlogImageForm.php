<?php

namespace App\Filament\Resources\BlogImages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BlogImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('blog_id')
                    ->required()
                    ->numeric(),
                FileUpload::make('image_path')
                    ->image()
                    ->required(),
            ]);
    }
}
