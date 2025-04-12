<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nis')
                    ->required()
                    ->unique(ignorable:fn($record)=>$record),
                Forms\Components\TextInput::make('nama')
                    ->required(),
                Forms\Components\TextInput::make('absen')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('kelas')
                    ->required()
                    ->options(\App\Models\Kelas::pluck('kelas', 'kelas')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nis'),
                Tables\Columns\TextColumn::make('nama'),
                Tables\Columns\TextColumn::make('absen'),
                Tables\Columns\TextColumn::make('kelas'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kelas')
                ->options(\App\Models\Kelas::pluck('kelas', 'kelas')),
                Tables\Filters\SelectFilter::make('absen')
                ->options(Siswa::pluck('absen', 'id')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
