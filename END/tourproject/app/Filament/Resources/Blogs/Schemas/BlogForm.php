<?php

namespace App\Filament\Resources\Blogs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated(false),
                Textarea::make('excerpt')
                    ->rows(3)
                    ->maxLength(1000),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('location')
                    ->maxLength(255),
                Select::make('category')
                    ->options([
                        'General' => 'General',
                        'Safari' => 'Safari',
                        'Beach' => 'Beach',
                        'Culture' => 'Culture',
                        'Adventure' => 'Adventure',
                        'Travel Tips' => 'Travel Tips',
                        'Food' => 'Food',
                        'Wildlife' => 'Wildlife',
                    ])
                    ->default('General'),
                TextInput::make('tags')
                    ->placeholder('Comma separated tags'),
                TextInput::make('duration')
                    ->placeholder('e.g. 3 days, 1 week')
                    ->maxLength(100),
                Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ])
                    ->default('draft')
                    ->required(),
            ]);
    }
}
