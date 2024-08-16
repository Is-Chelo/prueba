<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 20;

    protected static ?string $navigationGroup = 'Almacén';

    protected static ?string $label = 'Producto';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()->schema([
                    TextInput::make('nombre')
                        ->autofocus()
                        ->required()
                        ->minLength(2)
                        ->maxLength(200)
                        ->unique(static::getModel(), 'nombre', ignoreRecord: true)
                        ->label(__('Nombre'))
                        ->columns(1),
                    TextInput::make('precio')
                        ->label(__('Precio'))
                        ->numeric()
                        ->inputMode('decimal')
                        ->required()
                        ->columns(1),

                    Select::make('category_id')
                        ->relationship('category', 'nombre')
                        ->required()
                        ->label(__('categoria'))

                ])->columns(3),

                Textarea::make('descripcion')
                    ->rows(4)
                    ->minLength(2)
                    ->label(__('Descripción'))
                    ->columnSpanFull(),

                TextInput::make('cantidad')
                    ->label(__('Cantidad'))
                    ->type('number')
                    ->required()
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Imagen')
                    ->image()
                    ->maxSize(4096)
                    ->placeholder('Imagen del Producto')
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Imagen'),

                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('precio')
                    ->label('Precio')
                    ->sortable()
                    ->money('bob'),
                TextColumn::make('cantidad')
                    ->label('Cantidad')
                    ->sortable(),
                TextColumn::make('category.nombre')
                    ->label('Categoria')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->sortable()
                    ->date('d/m/Y H:i'),
                TextColumn::make('updated_at')
                    ->label('Creado')
                    ->sortable()
                    ->date('d/m/Y H:i'),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->relationship('category', 'nombre')
                    ->label(__('Categoria')),

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
            ])
            ->emptyStateDescription('No hay productos disponibles');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ImageEntry::make('image')
                    ->hiddenLabel()
                    ->columnSpanFull(),

                Section::make()->schema([
                    TextEntry::make('nombre')->label(__('Nombre')),
                    TextEntry::make('precio')->label(__('Precio'))->money('bob'),
                    TextEntry::make('category.nombre')->label(__('Categoria'))
                ])->columns(3)
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

}
