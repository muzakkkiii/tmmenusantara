<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParticipantResource\Pages;
use App\Models\Participant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ParticipantResource extends Resource
{
    protected static ?string $model = Participant::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?string $navigationLabel = 'Pendaftar Peserta';
    protected static ?string $modelLabel = 'Peserta';
    protected static ?string $pluralModelLabel = 'Pendaftar Peserta';
    protected static ?int $navigationSort = 5;

    public static function getNavigationBadge(): ?string
    {
        $n = static::getModel()::where('status', 'Baru')->count();
        return $n > 0 ? (string) $n : null;
    }

    protected static function progOpts(): array
    {
        $v = (array) config('donasi.progs', ['Umum']);
        return array_combine($v, $v);
    }

    protected static function statusOpts(): array
    {
        $v = (array) config('yayasan.statuses', ['Baru', 'Diproses', 'Selesai']);
        return array_combine($v, $v);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama')->label('Nama Lengkap')->required()->maxLength(120),
            Forms\Components\TextInput::make('wa')->label('WhatsApp')->maxLength(40),
            Forms\Components\TextInput::make('email')->label('Email')->email()->maxLength(120),
            Forms\Components\Select::make('program')->label('Program')->options(static::progOpts())->native(false),
            Forms\Components\TextInput::make('asal')->label('Asal Sekolah / Instansi')->maxLength(160),
            Forms\Components\Select::make('status')->label('Status')->options(static::statusOpts())->default('Baru')->native(false),
            Forms\Components\Textarea::make('catatan')->label('Catatan')->rows(3)->maxLength(2000)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Daftar')->dateTime('d M Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('program')->label('Program')->badge()->searchable(),
                Tables\Columns\TextColumn::make('asal')->label('Asal')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('wa')->label('WhatsApp')->copyable(),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge()->color(fn (?string $s): string => match ($s) {
                    'Baru' => 'warning', 'Diproses' => 'info', 'Selesai' => 'success', default => 'gray',
                }),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(static::statusOpts()),
                Tables\Filters\SelectFilter::make('program')->options(static::progOpts()),
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
            'index'  => Pages\ListParticipants::route('/'),
            'create' => Pages\CreateParticipant::route('/create'),
            'edit'   => Pages\EditParticipant::route('/{record}/edit'),
        ];
    }
}
