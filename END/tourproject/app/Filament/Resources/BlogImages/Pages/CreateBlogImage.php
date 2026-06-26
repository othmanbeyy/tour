<?php

namespace App\Filament\Resources\BlogImages\Pages;

use App\Filament\Resources\BlogImages\BlogImageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogImage extends CreateRecord
{
    protected static string $resource = BlogImageResource::class;
}
