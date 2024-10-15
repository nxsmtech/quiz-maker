<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PollResource\Pages;
use App\Models\Poll;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\HtmlString;

class PollResource extends Resource
{
    protected static ?string $model = Poll::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Poll Preview')
                ->schema([
                    Placeholder::make('pollPreview')
                        ->label('Poll Preview')
                        ->content(function ($record) {
                            $url = route('poll.preview', ['poll' => $record->id]);
                            return new HtmlString('
                                    <div style="position:relative; width:100%; height:0; padding-bottom:56.25%;">
                                        <iframe src="' . $url . '" style="position:absolute; top:0; left:0; width:100%; height:100%;" frameborder="0" allowfullscreen></iframe>
                                    </div>'
                            );
                        }),
                ])
                ->hidden(fn ($livewire) => $livewire instanceof CreateRecord),
            Section::make('Poll Details')
                ->columns(1)
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->label('Poll Title'),
                    Textarea::make('description')
                        ->label('Poll Description')
                        ->nullable(),
                    Textarea::make('question')
                        ->label('Poll Question')
                        ->required(),
                    Repeater::make('options')
                        ->relationship('options')
                        ->schema([
                            TextInput::make('option_text')
                                ->label('Option Text')
                                ->required(),
                        ])
                        ->minItems(2)
                        ->label('Poll Options'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')->sortable()->searchable(),
            TextColumn::make('created_at')->dateTime(),
        ]);
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Quizzes';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPolls::route('/'),
            'create' => Pages\CreatePoll::route('/create'),
            'edit' => Pages\EditPoll::route('/{record}/edit'),
        ];
    }
}
