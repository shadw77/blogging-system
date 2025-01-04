<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Comments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('post_id')
                    ->label('Post')
                    ->required()
                    ->relationship('post', 'title')
                    ->searchable()
                    ->placeholder('Select a post'),

                Forms\Components\TextInput::make('user_name')
                    ->label('User Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('user_email')
                    ->label('User Email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('content')
                    ->label('Comment Content')
                    ->required()
                    ->maxLength(65535),

                Forms\Components\Toggle::make('approved')
                    ->label('Approved')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('post.title')
                    ->label('Post')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('user_name')
                    ->label('User Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user_email')
                    ->label('User Email')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('content')
                    ->label('Content')
                    ->limit(50)
                    ->searchable(),

                BooleanColumn::make('approved')
                    ->label('Approved'),
            ])
            ->filters([
                Tables\Filters\Filter::make('approved')
                    ->label('Approved')
                    ->query(fn (Builder $query) => $query->where('approved', true)),
                Tables\Filters\Filter::make('unapproved')
                    ->label('Unapproved')
                    ->query(fn (Builder $query) => $query->where('approved', false)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
