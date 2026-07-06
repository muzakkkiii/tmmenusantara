<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinanceResource\Pages;
use App\Models\Finance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FinanceResource extends Resource
{
    protected static ?string $model = Finance::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?string $navigationLabel = 'Keuangan';
    protected static ?string $modelLabel = 'Transaksi';
    protected static ?string $pluralModelLabel = 'Keuangan';
    protected static ?int $navigationSort = 2;

    protected static function opsi(string $configKey): array
    {
        $vals = (array) config($configKey, []);
        return array_combine($vals, $vals) ?: [];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('type')->label('Jenis')->options([
                'masuk' => 'Dana Masuk',
                'keluar' => 'Dana Keluar',
            ])->required()->native(false),
            Forms\Components\DatePicker::make('tgl')->label('Tanggal')->required()->native(false)->displayFormat('d M Y'),
            Forms\Components\TextInput::make('nama')->label('Sumber / Tujuan')->required()->maxLength(120),
            Forms\Components\Select::make('prog')->label('Program')->options(static::opsi('yayasan.progs'))->native(false),
            Forms\Components\TextInput::make('ket')->label('Keterangan')->maxLength(200),
            Forms\Components\TextInput::make('amt')->label('Nominal')->numeric()->required()->prefix('Rp')->minValue(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tgl')->label('Tanggal')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('type')->label('Jenis')->badge()->formatStateUsing(fn (?string $state): string => $state === 'masuk' ? 'Masuk' : 'Keluar')->color(fn (?string $state): string => $state === 'masuk' ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('nama')->label('Sumber / Tujuan')->searchable(),
                Tables\Columns\TextColumn::make('prog')->label('Program')->badge()->searchable(),
                Tables\Columns\TextColumn::make('amt')->label('Nominal')->money('IDR')->sortable(),
            ])
            ->defaultSort('tgl', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')->label('Jenis')->options([
                    'masuk' => 'Dana Masuk',
                    'keluar' => 'Dana Keluar',
                ]),
                Tables\Filters\SelectFilter::make('prog')->label('Program')->options(static::opsi('yayasan.progs')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListFinances::route('/'),
            'create' => Pages\CreateFinance::route('/create'),
            'edit'   => Pages\EditFinance::route('/{record}/edit'),
        ];
    }
}
