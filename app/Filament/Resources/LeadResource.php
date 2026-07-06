<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?string $navigationLabel = 'Data Masuk';
    protected static ?string $modelLabel = 'Data Masuk';
    protected static ?string $pluralModelLabel = 'Data Masuk';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $baru = static::getModel()::where('status', 'Baru')->count();
        return $baru > 0 ? (string) $baru : null;
    }

    protected static function opsi(string $configKey): array
    {
        $vals = (array) config($configKey, []);
        return array_combine($vals, $vals) ?: [];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama')->label('Nama')->required()->maxLength(120),
            Forms\Components\TextInput::make('wa')->label('WhatsApp')->maxLength(40),
            Forms\Components\TextInput::make('email')->label('Email')->email()->maxLength(120),
            Forms\Components\Select::make('kategori')->label('Kategori')->options(static::opsi('yayasan.cats'))->native(false),
            Forms\Components\Select::make('status')->label('Status')->options(static::opsi('yayasan.statuses'))->default('Baru')->native(false),
            Forms\Components\Textarea::make('pesan')->label('Pesan')->rows(4)->maxLength(2000)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Masuk')->dateTime('d M Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('kategori')->label('Kategori')->badge()->searchable(),
                Tables\Columns\TextColumn::make('wa')->label('WhatsApp')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge()->color(fn (?string $state): string => match ($state) {
                    'Baru' => 'warning',
                    'Diproses' => 'info',
                    'Selesai' => 'success',
                    default => 'gray',
                }),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(static::opsi('yayasan.statuses')),
                Tables\Filters\SelectFilter::make('kategori')->options(static::opsi('yayasan.cats')),
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
            'index'  => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit'   => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
