<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenjualanResource\Pages;
use App\Filament\Resources\PenjualanResource\RelationManagers;
use App\Models\Penjualan;
use App\Models\PenjualanModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenjualanResource extends Resource
{
    protected static ?string $model = PenjualanModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Laporan Penjualan';

    protected static ?string $navigationGroup = 'Faktur';

    public static ?string $label = 'Laporan Penjualan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal_penjualan')
                    ->label('Tanggal Penjualan')
                    ->sortable()
                    ->searchable()
                    ->date('d-F-Y'),
                TextColumn::make('kode_penjualan')
                    ->label('Kode Penjualan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('jumlah_penjualan')
                    ->label('Jumlah Penjualan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('customer.nama_customer')
                    ->label('Nama Customer')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status_penjualan')
                    ->label('Status Penjualan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('keterangan_penjualan')
                    ->label('Keterangan Penjualan')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenjualans::route('/'),
            'create' => Pages\CreatePenjualan::route('/create'),
            'edit' => Pages\EditPenjualan::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
