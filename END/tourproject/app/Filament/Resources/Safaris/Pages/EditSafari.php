<?php

namespace App\Filament\Resources\Safaris\Pages;

use App\Filament\Resources\Safaris\SafariResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSafari extends EditRecord
{
    protected static string $resource = SafariResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
