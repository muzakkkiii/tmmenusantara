<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?string $navigationLabel = 'Kemitraan';
    protected static ?string $modelLabel = 'Pengajuan Mitra';
    protected static ?string $pluralModelLabel = 'Kemitraan';
    protected static ?int $navigationSort = 4;

    public const JENIS = ['Program', 'Sponsorship/CSR', 'Penyediaan SDM', 'Hukum & Perizinan', 'Lainnya'];

    public static function getNavigationBadge(): ?string
    {
        $n = static::getModel()::where('status', 'Baru')->count();
        return $n > 0 ? (string) $n : null;
    }

    protected static function jenisOpts(): array
    {
        return array_combine(self::JENIS, self::JENIS);
    }

    protected static function statusOpts(): array
    {
        $v = (array) config('yayasan.statuses', ['Baru', 'Diproses', 'Selesai']);
        return array_combine($v, $v);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama')->label('Nama PIC')->required()->maxLength(120),
            Forms\Components\TextInput::make('organisasi')->label('Organisasi / Perusahaan')->maxLength(160),
            Forms\Components\TextInput::make('wa')->label('WhatsApp')->maxLength(40),
            Forms\Components\TextInput::make('email')->label('Email')->email()->maxLength(120),
            Forms\Components\Select::make('jenis')->label('Jenis Kemitraan')->options(static::jenisOpts())->native(false),
            Forms\Components\Select::make('status')->label('Status')->options(static::statusOpts())->default('Baru')->native(false),
            Forms\Components\Textarea::make('pesan')->label('Detail / Proposal')->rows(4)->maxLength(3000)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Masuk')->dateTime('d M Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('nama')->label('PIC')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('organisasi')->label('Organisasi')->searchable(),
                Tables\Columns\TextColumn::make('jenis')->label('Jenis')->badge()->searchable(),
                Tables\Columns\TextColumn::make('wa')->label('WhatsApp')->copyable(),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge()->color(fn (?string $s): string => match ($s) {
                    'Baru' => 'warning', 'Diproses' => 'info', 'Selesai' => 'success', default => 'gray',
                }),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(static::statusOpts()),
                Tables\Filters\SelectFilter::make('jenis')->options(static::jenisOpts()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit'   => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
