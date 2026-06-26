<?php

namespace App\Filament\Resources\SafariImages\Pages;

use App\Filament\Resources\SafariImages\SafariImageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSafariImage extends EditRecord
{
    protected static string $resource = SafariImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
