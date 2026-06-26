<?php

namespace App\Filament\Resources\TourImages\Pages;

use App\Filament\Resources\TourImages\TourImageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTourImages extends ListRecords
{
    protected static string $resource = TourImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
