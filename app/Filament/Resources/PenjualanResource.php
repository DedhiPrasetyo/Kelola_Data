<?php // Mendeklarasikan awal file PHP

namespace App\Filament\Resources; // Menentukan namespace untuk file ini

use App\Filament\Resources\PenjualanResource\Pages; // Mengimpor Pages dari PenjualanResource
use App\Filament\Resources\PenjualanResource\RelationManagers; // Mengimpor RelationManagers dari PenjualanResource
use App\Models\Penjualan; // Mengimpor model Penjualan
use App\Models\PenjualanModel; // Mengimpor model PenjualanModel
use Filament\Actions\Exports\Exporter;
use Filament\Forms; // Mengimpor komponen Forms dari Filament
use Filament\Forms\Form; // Mengimpor kelas Form dari Filament
use Filament\Resources\Resource; // Mengimpor kelas Resource dari Filament
use Filament\Tables; // Mengimpor komponen Tables dari Filament
use Filament\Tables\Columns\TextColumn; // Mengimpor kelas TextColumn dari Tables
use Filament\Tables\Table; // Mengimpor kelas Table dari Tables
use Illuminate\Database\Eloquent\Builder; // Mengimpor kelas Builder dari Eloquent
use Illuminate\Database\Eloquent\SoftDeletingScope; // Mengimpor SoftDeletingScope dari Eloquent

class PenjualanResource extends Resource // Mendeklarasikan kelas PenjualanResource yang merupakan turunan dari Resource
{
    protected static ?string $model = PenjualanModel::class; // Menentukan model yang digunakan

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar'; // Menentukan ikon navigasi

    protected static ?string $navigationLabel = 'Laporan Penjualan'; // Menentukan label navigasi

    protected static ?string $navigationGroup = 'Faktur'; // Menentukan grup navigasi

    public static ?string $label = 'Laporan Penjualan'; // Menentukan label untuk resource

    public static function form(Form $form): Form // Mendefinisikan metode form
    {
        return $form // Mengembalikan form
            ->schema([ // Menentukan skema form
                // 
            ]);
    }

    public static function table(Table $table): Table // Mendefinisikan metode table
    {
        return $table // Mengembalikan table
            ->columns([ // Menentukan kolom-kolom dalam table
                TextColumn::make('tanggal_penjualan') // Membuat kolom untuk tanggal penjualan
                    ->label('Tanggal Penjualan') // Menentukan label kolom
                    ->sortable() // Mengizinkan pengurutan
                    ->searchable() // Mengizinkan pencarian
                    ->date('d-F-Y'), // Menentukan format tanggal
                TextColumn::make('kode_penjualan') // Membuat kolom untuk kode penjualan
                    ->label('Kode Penjualan') // Menentukan label kolom
                    ->sortable() // Mengizinkan pengurutan
                    ->searchable(), // Mengizinkan pencarian
                TextColumn::make('jumlah_penjualan') // Membuat kolom untuk jumlah penjualan
                    ->label('Jumlah Penjualan') // Menentukan label kolom
                    ->sortable() // Mengizinkan pengurutan
                    ->searchable(), // Mengizinkan pencarian
                TextColumn::make('customer.nama_customer') // Membuat kolom untuk nama customer
                    ->label('Nama Customer') // Menentukan label kolom
                    ->sortable() // Mengizinkan pengurutan
                    ->searchable(), // Mengizinkan pencarian
                TextColumn::make('status_penjualan') // Membuat kolom untuk status penjualan
                    ->label('Status Penjualan') // Menentukan label kolom
                    ->sortable() // Mengizinkan pengurutan
                    ->badge() // Menampilkan badge
                    ->color(fn (string $state): string => match ($state) { // Menentukan warna badge berdasarkan status
                        '0' => 'danger', // Jika status 0, warna badge adalah 'danger'
                        '1' => 'info', // Jika status 1, warna badge adalah 'info'
                    })
                    ->formatStateUsing(fn(PenjualanModel $record): string => $record->setatus ==  0?'Belum Lunas':'Lunas') // Menentukan format status
                    ->searchable(), // Mengizinkan pencarian
                TextColumn::make('keterangan_penjualan') // Membuat kolom untuk keterangan penjualan
                    ->label('Keterangan Penjualan') // Menentukan label kolom
                    ->sortable() // Mengizinkan pengurutan
                    ->searchable(), // Mengizinkan pencarian
             ])


            ->emptyStateHeading('Tidak ada Data Laporan') // Menambahkan heading jika tidak ada data
            ->filters([ // Menentukan filter
                Tables\Filters\TrashedFilter::make(), // Menambahkan filter untuk data yang dihapus


            ])


            ->actions([ // Menentukan aksi yang dapat dilakukan
                Tables\Actions\EditAction::make(), // Menambahkan aksi edit
                Tables\Actions\DeleteAction::make(), // Menambahkan aksi hapus
                // Kode ini tidak dapat digunakan karena kelas ExporterAction dan ProductExporter tidak terdefinisi
                // Pastikan untuk mengimpor kelas yang diperlukan atau mendefinisikannya sebelum digunakan
            ])
           
            ->bulkActions([ // Menentukan aksi bulk
                Tables\Actions\BulkActionGroup::make([ // Membuat grup aksi bulk
                    Tables\Actions\DeleteBulkAction::make(), // Menambahkan aksi hapus bulk
                    Tables\Actions\ForceDeleteBulkAction::make(), // Menambahkan aksi hapus paksa bulk
                    Tables\Actions\RestoreBulkAction::make(), // Menambahkan aksi pulihkan bulk
                ]),
            ]);

    }

    public static function getRelations(): array // Mendefinisikan metode untuk mendapatkan relasi
    {
        return [ // Mengembalikan array relasi
            // 
        ];
    }

    public static function getPages(): array // Mendefinisikan metode untuk mendapatkan halaman
    {
        return [ // Mengembalikan array halaman
            'index' => Pages\ListPenjualans::route('/'), // Menentukan rute untuk halaman index
            'create' => Pages\CreatePenjualan::route('/create'), // Menentukan rute untuk halaman create
            'edit' => Pages\EditPenjualan::route('/{record}/edit'), // Menentukan rute untuk halaman edit
        ];
    }

    public static function getEloquentQuery(): Builder // Mendefinisikan metode untuk mendapatkan query Eloquent
    {
        return parent::getEloquentQuery() // Memanggil metode parent
            ->withoutGlobalScopes([ // Menghapus global scopes
                SoftDeletingScope::class, // Menghapus soft deleting scope
            ]);
    }
}
