<?php

namespace App\Filament\Resources\BlogImages\Pages;

use App\Filament\Resources\BlogImages\BlogImageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBlogImage extends EditRecord
{
    protected static string $resource = BlogImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
