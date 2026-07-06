<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?string $navigationLabel = 'Anggota & Relawan';
    protected static ?string $modelLabel = 'Anggota/Relawan';
    protected static ?string $pluralModelLabel = 'Anggota & Relawan';
    protected static ?int $navigationSort = 6;

    public const PERAN = ['Anggota', 'Relawan', 'Pengurus'];
    public const STATUS = ['Aktif', 'Nonaktif'];

    protected static function peranOpts(): array
    {
        return array_combine(self::PERAN, self::PERAN);
    }

    protected static function statusOpts(): array
    {
        return array_combine(self::STATUS, self::STATUS);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama')->label('Nama Lengkap')->required()->maxLength(120),
            Forms\Components\TextInput::make('wa')->label('WhatsApp')->maxLength(40),
            Forms\Components\TextInput::make('email')->label('Email')->email()->maxLength(120),
            Forms\Components\Select::make('peran')->label('Peran')->options(static::peranOpts())->default('Relawan')->native(false),
            Forms\Components\TextInput::make('bidang')->label('Bidang / Minat')->maxLength(120),
            Forms\Components\Select::make('status')->label('Status')->options(static::statusOpts())->default('Aktif')->native(false),
            Forms\Components\Textarea::make('alamat')->label('Alamat')->rows(2)->maxLength(255)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('peran')->label('Peran')->badge()->color(fn (?string $s): string => match ($s) {
                    'Anggota' => 'info', 'Relawan' => 'success', 'Pengurus' => 'warning', default => 'gray',
                }),
                Tables\Columns\TextColumn::make('bidang')->label('Bidang')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('wa')->label('WhatsApp')->copyable(),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge()->color(fn (?string $s): string => $s === 'Aktif' ? 'success' : 'gray'),
            ])
            ->defaultSort('nama')
            ->filters([
                Tables\Filters\SelectFilter::make('peran')->options(static::peranOpts()),
                Tables\Filters\SelectFilter::make('status')->options(static::statusOpts()),
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
            'index'  => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit'   => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
