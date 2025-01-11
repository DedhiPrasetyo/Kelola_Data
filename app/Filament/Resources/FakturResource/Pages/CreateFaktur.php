<?php
namespace App\Filament\Resources\FakturResource\Pages;
use App\Filament\Resources\FakturResource;
use App\Models\PenjualanModel;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFaktur extends CreateRecord
{
    protected static string $resource = FakturResource::class;

    protected function afterCreate(): void
    {
        PenjualanModel::create([
            // yang di kiri mengambil tabel penjualan dan kanan mengambil tabel faktur
            'kode_penjualan' => $this->record->kode_faktur,
            'tanggal_penjualan' => $this->record->tanggal_faktur,
            'jumlah_penjualan' => $this->record->total, // Perbaiki nama kolom dari 'jumlah_pennjualan' menjadi 'jumlah_penjualan'
            'customer_id' => $this->record->customer_id,
            'faktur_id' => $this->record->id,
            'keterangan_penjualan' => $this->record->ket_faktur,
            'status_penjualan' => 0,
        ]);
    }
}