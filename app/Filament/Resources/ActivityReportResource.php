<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityReportResource\Pages;
use App\Models\ActivityReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ActivityReportResource extends Resource
{
    protected static ?string $model = ActivityReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?string $navigationLabel = 'Laporan Kegiatan';
    protected static ?string $modelLabel = 'Laporan Kegiatan';
    protected static ?string $pluralModelLabel = 'Laporan Kegiatan';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('judul')->label('Judul Kegiatan')->required()->maxLength(200),
            Forms\Components\DatePicker::make('tanggal')->label('Tanggal')->native(false),
            Forms\Components\TextInput::make('lokasi')->label('Lokasi')->maxLength(200),
            Forms\Components\TextInput::make('peserta')->label('Jumlah Peserta')->numeric()->minValue(0),
            Forms\Components\FileUpload::make('img')
                ->label('Foto Dokumentasi')
                ->image()->fetchFileInformation(false)->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                ->disk('public')
                ->directory('laporan')
                ->imageEditor()
                ->imageEditorAspectRatios(['16:9', '4:3', '1:1'])
                ->imageEditorViewportWidth('1200')
                ->imageEditorViewportHeight('675')
                ->openable()
                ->downloadable()
                ->imageResizeMode('cover')
                ->imageResizeTargetWidth('1200')
                ->imageResizeTargetHeight('675')
                ->maxSize(2048)
                ->nullable(),
            Forms\Components\Textarea::make('ringkasan')->label('Ringkasan Kegiatan')->rows(6)->maxLength(5000)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')->label('Tanggal')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('judul')->label('Judul')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('lokasi')->label('Lokasi')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('peserta')->label('Peserta')->numeric()->sortable(),
            ])
            ->defaultSort('tanggal', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListActivityReports::route('/'),
            'create' => Pages\CreateActivityReport::route('/create'),
            'edit'   => Pages\EditActivityReport::route('/{record}/edit'),
        ];
    }
}
