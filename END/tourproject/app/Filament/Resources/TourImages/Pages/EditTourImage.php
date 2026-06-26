<?php

namespace App\Filament\Resources\TourImages\Pages;

use App\Filament\Resources\TourImages\TourImageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTourImage extends EditRecord
{
    protected static string $resource = TourImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
