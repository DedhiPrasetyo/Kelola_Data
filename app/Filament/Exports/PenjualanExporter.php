<?php

namespace App\Filament\Exports;

use App\Models\PenjualanModel;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PenjualanExporter extends Exporter
{
    protected static ?string $model =PenjualanModel::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('kode_penjualan')->label('Kode Penjualan'),
            ExportColumn::make('tanggal_penjualan')->label('Tanggal Penjualan'),
            ExportColumn::make('jumlah_penjualan')->label('Jumlah Penjualan'),
            ExportColumn::make('customer_id')->label('ID Customer'),
            ExportColumn::make('faktur_id')->label('ID Faktur'),
            ExportColumn::make('status_penjualan')->label('Status Penjualan'),
            ExportColumn::make('keterangan_penjualan')->label('Keterangan Penjualan'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor penjualan Anda telah selesai dan ' . number_format($export->successful_rows) . ' ' . str('baris')->plural($export->successful_rows) . ' berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' gagal diekspor.';
        }

        return $body;
    }
}
