<?php

namespace App\Filament\Resources\SafariImages\Pages;

use App\Filament\Resources\SafariImages\SafariImageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSafariImages extends ListRecords
{
    protected static string $resource = SafariImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
