<?php

namespace App\Filament\Resources\BlogImages\Pages;

use App\Filament\Resources\BlogImages\BlogImageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBlogImages extends ListRecords
{
    protected static string $resource = BlogImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
