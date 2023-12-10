<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PostResource\Pages;
use App\Filament\Admin\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
//    protected static ?string $navigationParentItem = 'Blog';
    protected static ?string $navigationGroup = 'Blog';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

//    protected static ?string $activeNavigationIcon = 'heroicon-o-list-bullet';

//    protected static ?string $navigationLabel = 'Custom Navigation Label';

    protected static ?int $navigationSort = 3;

    protected static ?string $model = Post::class;

//    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    protected static ?string $recordTitleAttribute = 'title';

    protected static int $globalSearchResultsLimit = 10;

//    public static function getGloballySearchableAttributes(): array
//    {
//        return ['title', 'body'];
//    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Section::make('Main content')
//                            ->description('Main content')
                            ->icon('heroicon-m-computer-desktop')
                            ->collapsible()
                            ->persistCollapsed()
                            ->compact()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->autofocus()
                                    ->live(onBlur: true, debounce: 500)
                                    ->required()
                                    ->maxLength(255)
                                    ->afterStateUpdated(function (string $operation, ?string $state, Set $set) {
                                        $set('slug', Str::slug($state));
                                    })->columnSpanFull(),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)->columnSpanFull(),
                                Forms\Components\RichEditor::make('body')
                                    ->required()
                                    ->maxLength(65535)
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(8),
                        Forms\Components\Section::make('Meta data')
//                            ->description('Meta data')
                            ->icon('heroicon-m-adjustments-horizontal')
                            ->collapsible()
                            ->persistCollapsed()
                            ->compact()
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->required(),
                                Forms\Components\Select::make('categories')
                                    ->label('Categories')
                                    ->relationship('categories', 'title')
                                    ->preload()
                                    ->multiple()
                                    ->searchable()
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('title')
                                            ->live(onBlur: true, debounce: 500)
                                            ->required()
                                            ->minLength(1)
                                            ->maxLength(150)
                                            ->afterStateUpdated(function (string $operation, ?string $state, Set $set) {
                                                $set('slug', Str::slug($state));
                                            }),
                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->minLength(1)
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true),
                                        Forms\Components\colorPicker::make('text_color'),
                                        Forms\Components\colorPicker::make('bg_color'),
                                    ])
                                ,
                                Forms\Components\Select::make('user_id')->label('Author')
                                    ->relationship('user', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Forms\Components\DateTimePicker::make('published_at'),
                                Forms\Components\Toggle::make('featured')
                                    ->required()
                            ])
                            ->columnSpan(4),
                    ])->columns(12),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
//                Tables\Columns\TextColumn::make('index')
//                    ->rowIndex(),
//                Tables\Columns\TextColumn::make('user.name')
//                    ->icon('heroicon-m-envelope')
//                    ->iconPosition(IconPosition::Before)
//                    ->fontFamily(FontFamily::Mono)
//                    ->weight(FontWeight::Bold)
//                    ->size(Tables\Columns\TextColumn\TextColumnSize::Medium)
//                    ->copyable()
//                    ->copyMessage('Author name copied')
//                    ->copyMessageDuration(1500)
//                    ->sortable(),
//                Tables\Columns\ImageColumn::make('image')->alignCenter(),
                Tables\Columns\TextColumn::make('title')
//                    ->limit(100)
                    ->words(8)
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight(FontWeight::Bold)
//                    ->copyableState(fn (Post $record): string => "URL: {$record->url}")
//                    ->description(fn(Post $record): string => Str::words($record->body, 5), position: 'below')
                ,
                Tables\Columns\TextColumn::make('categories.title')
//                    ->listWithLineBreaks()
//                    ->bulleted()
//                    ->searchable()
//                    ->limitList(1)
//                    ->expandableLimitedList()
                    ->badge()
//                    ->separator(',')
                ,
                Tables\Columns\TextColumn::make('published_at')
                    ->since()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('featured')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No posts yet')
            ->emptyStateDescription('Once you write your first post, it will appear here.')
            ->emptyStateIcon('heroicon-o-document-text')
            ->emptyStateActions([
                Tables\Actions\Action::make('create')
                    ->label('Create post')
                    ->url(route('filament.admin.resources.posts.create'))
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->defaultGroup('featured', 'desc')
            ->defaultSort('published_at', 'desc')
            ->groups([
                'published_at',
                'featured',
                Tables\Grouping\Group::make('user.name')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false)
                    ->label('Author name'),
                Tables\Grouping\Group::make('featured')
                    ->getTitleFromRecordUsing(fn(Post $record): string => ucfirst($record->featured ? 'True' : 'False'))
//                    ->getDescriptionFromRecordUsing(fn(Post $record): string => 'Description for ' . $record->title)
                ,

//                Tables\Grouping\Group::make('deleted_at')
//                    ->getTitleFromRecordUsing(fn (Post $record): string => $record->deleted_at ? 'True' : 'False'),
//                Tables\Grouping\Group::make('created_at')
//                    ->getTitleFromRecordUsing(fn (Post $record): string => $record->created_at->diffForHumans()),
//                Tables\Grouping\Group::make('updated_at')
//                    ->getTitleFromRecordUsing(fn (Post $record): string => $record->updated_at->diffForHumans()),
//                Tables\Grouping\Group::make('categories.title')
//                    ->titlePrefixedWithLabel(false)
//                    ->label('Category name')
//                    ->sortable()
//                    ->searchable()
//                    ->limitList(1)
//                    ->expandableLimitedList()
//                    ->description(fn(Post $record): string => Str::words($record->body, 5), position: 'below')
//                    ->linkToUrl(fn(Post $record): string => $record->url)
            ])
//            ->groupingSettingsHidden()
            ->groupingSettingsInDropdownOnDesktop()
            ->groupRecordsTriggerAction(
                fn(Tables\Actions\Action $action) => $action
                    ->button()
                    ->label('Group records'),
            );
    }

    public static function getRelations(): array
    {
        return [
//            RelationManagers\CategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

//    public static function getGlobalSearchResultUrl(Model $record): string
//    {
//        return self::getUrl('view', ['record' => $record]);
//    }
}
