<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\FakturModel;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\DetachBulkAction;
use App\Filament\Resources\FakturResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FakturResource\RelationManagers;
use App\Models\Barang;
use App\Models\CustomerModel;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Get;
use Filament\Forms\Set;

class FakturResource extends Resource
{
    protected static ?string $model = FakturModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode_faktur')
                    ->required()
                    ->columnSpan(2),

                DatePicker::make('tanggal_faktur')
                    ->required()
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                        'lg' => 1,
                        'xl' => 1,
                    ]),

                Select::make('customer_id')
                    ->relationship('customer', 'nama_customer')
                    ->required()
                    ->reactive()
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                        'lg' => 1,
                        'xl' => 1,
                    ])
                    ->afterStateUpdated(function ($state, callable $set) {
                        $customer = CustomerModel::find($state);

                        if ($customer) {
                            $set('kode_customer', $customer->kode_customer);
                        }
                    })
                    ->afterStateHydrated(function ($state, callable $set) {
                        $customer = CustomerModel::find($state);

                        if ($customer) {
                            $set('kode_customer', $customer->kode_customer);
                        }
                    }),

                TextInput::make('kode_customer')
                    ->required()
                    ->reactive()
                    ->columnSpan(2),

                Repeater::make('detail')
                    ->relationship('detail')
                    ->schema([
                        Select::make('barang_id')
                            ->relationship('barang', 'nama_barang')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $barang = Barang::find($state);

                                if ($barang) {
                                    $set('nama_barang', $barang->nama_barang);
                                    $set('harga', $barang->harga_barang);
                                } else {
                                    $set('harga', null);
                                }
                            }),
                        TextInput::make('nama_barang')
                            // ->disabled()
                            ->columnSpan([
                                'default' => 2,
                                'md' => 1,
                                'lg' => 1,
                                'xl' => 1,
                            ]),
                        TextInput::make('harga')
                            ->prefix('Rp')
                            // ->disabled()
                            ->numeric()
                            ->columnSpan([
                                'default' => 2,
                                'md' => 1,
                                'lg' => 1,
                                'xl' => 1,
                            ]),
                        TextInput::make('qty')
                            ->reactive()
                            ->numeric()
                            ->columnSpan([
                                'default' => 2,
                                'md' => 1,
                                'lg' => 1,
                                'xl' => 1,
                            ])
                            ->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $tampungHarga = $get('harga');
                                $set('hasil_qty', intval($tampungHarga * $state));
                                // $state adalah qty dan $tampungHarga adalah harga yang di ambil dari databases nya  
                            }),
                        TextInput::make('hasil_qty')
                            // ->disabled()
                            ->numeric()
                            ->columnSpan([
                                'default' => 2,
                                'md' => 1,
                                'lg' => 1,
                                'xl' => 1,
                            ]),
                        TextInput::make('diskon')
                            ->reactive()
                            ->numeric()
                            ->columnSpan([
                                'default' => 2,
                                'md' => 1,
                                'lg' => 1,
                                'xl' => 1,
                            ])
                            ->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $hasilQty = $get('hasil_qty');
                                $diskon = $hasilQty * ($state / 100);
                                $hasil = $hasilQty - $diskon;

                                $set('subtotal', intval($hasil));
                            }),
                        TextInput::make('subtotal')
                            // ->disabled()
                            ->numeric()
                            ->columnSpan([
                                'default' => 2,
                                'md' => 1,
                                'lg' => 1,
                                'xl' => 1,
                            ]),
                    ])
                    ->live()
                    ->columnSpan(2),

                Textarea::make('ket_faktur')
                    ->required()
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                        'lg' => 1,
                        'xl' => 1,
                    ]),

                TextInput::make('total')
                    ->required()
                    ->placeholder(function (Set $set, Get $get) {
                        $detail = collect($get('detail'))->pluck('subtotal')->sum();
                        if ($detail == null) {
                            $set('total', 0);
                        } else {
                            $set('total', $detail);
                        }
                    })
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                        'lg' => 1,
                        'xl' => 1,
                    ]),

                TextInput::make('nominal_charge')
                    ->required()
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                        'lg' => 1,
                        'xl' => 1,
                    ])
                    ->reactive()
                    ->afterStateUpdated(function (Set $set, $state, Get $get) {
                        $total = $get('total');
                        $charge = $total * ($state / 100);
                        $hasil = $total + $charge;

                        $set('total_final', $hasil);
                        $set('charge', $charge);
                    }),

                TextInput::make('charge')
                    ->required()
                    ->columnSpan(2),

                TextInput::make('total_final')
                    ->required()
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_faktur'),
                TextColumn::make('tanggal_faktur'),
                TextColumn::make('kode_customer'),
                TextColumn::make('customer.nama_customer')->label('Nama Customer'),
                TextColumn::make('ket_faktur'),
                TextColumn::make('total'),
                TextColumn::make('nominal_charge'),
                TextColumn::make('charge'),
                TextColumn::make('total_final'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListFaktur::route('/'),
            'create' => Pages\CreateFaktur::route('/create'),
            'edit' => Pages\EditFaktur::route('/{record}/edit'),
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
