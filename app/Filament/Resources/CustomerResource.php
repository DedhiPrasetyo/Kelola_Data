<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use App\Models\CustomerModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class CustomerResource extends Resource
{
    protected static ?string $model = CustomerModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'Kelola Customer';

    protected static ?string $navigationGroup = 'Kelola';

    protected static ?string $slug = 'kelola-customer';

    public static ?string $label ='Kelola Customer';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_customer')
                ->label('Nama')
                ->required()
                ->placeholder('Masukkan Nama Customer'),

                TextInput::make('kode_customer')
                ->label('Kode')
                ->required()
                ->placeholder('Masukkan Kode Customer')
                ->numeric(),

                TextInput::make('alamat_customer')
                ->label('Alamat')
                ->required()
                ->placeholder('Masukkan Alamat Customer'),

                TextInput::make('telpon_customer')
                ->label('Telpon')
                ->required()
                ->placeholder('Masukkan Nomor Telpon Customer')
                ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_customer')
                ->label('Nama')
                ->sortable()
                ->searchable(),

                TextColumn::make('kode_customer')
                ->label('Kode')
                ->searchable(),

                TextColumn::make('alamat_customer')
                ->label('Alamat')
                ->searchable(),

                TextColumn::make('telpon_customer')
                ->label('Telpon')
                ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
