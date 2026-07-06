<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?string $navigationLabel = 'Berita';
    protected static ?string $modelLabel = 'Berita';
    protected static ?string $pluralModelLabel = 'Berita';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('label')
                ->label('Label / Tanggal')
                ->placeholder('mis. 12 Maret 2025 - Legalitas')
                ->required()
                ->maxLength(80),
            Forms\Components\TextInput::make('title')
                ->label('Judul')
                ->required()
                ->maxLength(200),
            Forms\Components\FileUpload::make('img')
                ->label('Gambar (unggah dari perangkat)')
                ->image()->fetchFileInformation(false)->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                ->disk('public')
                ->directory('news')
                ->imageEditor()
                // Resize & kompres otomatis di sisi browser sebelum diunggah:
                ->imageResizeMode('cover')
                ->imageResizeTargetWidth('1200')
                ->imageResizeTargetHeight('675')
                ->maxSize(2048)
                ->helperText('Otomatis dipangkas ke rasio 16:9 (1200x675) & dikompres. Maks 2 MB.')
                ->nullable(),
            Forms\Components\Textarea::make('body')
                ->label('Ringkasan singkat')
                ->required()
                ->rows(2)
                ->maxLength(600),
            Forms\Components\Textarea::make('full')
                ->label('Isi lengkap')
                ->rows(8)
                ->maxLength(5000),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('img')->label('Gambar')->height(40)->defaultImageUrl(null),
                Tables\Columns\TextColumn::make('label')->label('Label')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('title')->label('Judul')->searchable()->limit(45),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y')->sortable(),
            ])
            ->defaultSort('id', 'desc')
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
            'index'  => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit'   => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
