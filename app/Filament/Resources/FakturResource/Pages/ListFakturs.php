<?php

namespace App\Filament\Resources\FakturResource\Pages;

use App\Filament\Resources\FakturResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFaktur extends ListRecords
{
    protected static string $resource = FakturResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
