<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?string $navigationLabel = 'Agenda Kegiatan';
    protected static ?string $modelLabel = 'Kegiatan';
    protected static ?string $pluralModelLabel = 'Agenda Kegiatan';
    protected static ?int $navigationSort = 3;

    public const STATUS = ['Terjadwal', 'Selesai', 'Batal'];

    protected static function statusOpts(): array
    {
        return array_combine(self::STATUS, self::STATUS);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('judul')->label('Judul Kegiatan')->required()->maxLength(200),
            Forms\Components\DateTimePicker::make('mulai')->label('Mulai')->required()->native(false)->seconds(false),
            Forms\Components\DateTimePicker::make('selesai')->label('Selesai')->native(false)->seconds(false),
            Forms\Components\TextInput::make('lokasi')->label('Lokasi')->maxLength(200),
            Forms\Components\Select::make('status')->label('Status')->options(static::statusOpts())->default('Terjadwal')->native(false),
            Forms\Components\Textarea::make('deskripsi')->label('Deskripsi')->rows(4)->maxLength(3000)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mulai')->label('Mulai')->dateTime('d M Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('judul')->label('Judul')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('lokasi')->label('Lokasi')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge()->color(fn (?string $s): string => match ($s) {
                    'Terjadwal' => 'info', 'Selesai' => 'success', 'Batal' => 'danger', default => 'gray',
                }),
            ])
            ->defaultSort('mulai', 'desc')
            ->filters([
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
            'index'  => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit'   => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
