<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PollResource\Pages;
use App\Models\Poll;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
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
                            return new HtmlString(
                                '<div style="position:relative; width:100%; height:0; padding-bottom:56.25%;">
                                         <iframe src="' . $url . '" style="position:absolute; top:0; left:0; width:100%; height:100%;" frameborder="0" allowfullscreen></iframe>
                                       </div>'
                            );
                        }),
                ])
                ->hidden(fn($livewire) => $livewire instanceof CreateRecord),

            Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Details')
                        ->icon('heroicon-m-information-circle')
                        ->schema([
                            Section::make('Poll Details')
                                ->columns(1)
                                ->schema([
                                    TextInput::make('title')
                                        ->required()
                                        ->label('Poll Title'),
                                    Textarea::make('description')
                                        ->label('Poll Description')
                                        ->nullable(),
                                    Toggle::make('is_active')->label('Is Active'),
                                ])
                                ->columnSpan('full'), // Make this full width
                        ]),
                    Tabs\Tab::make('Question')
                        ->icon('heroicon-m-chat-bubble-bottom-center-text')
                        ->schema([
                            Section::make('Poll Question')
                                ->columns(1)
                                ->schema([
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
                                ])
                                ->columnSpan('full'), // Make this full width
                        ]),
                    Tabs\Tab::make('Configurator')
                        ->icon('heroicon-m-adjustments-vertical')
                        ->schema([
                            Section::make('Poll Configurator')
                                ->columns(1)
                                ->schema([
                                    FileUpload::make('logo')
                                        ->label('Logo')
                                        ->image()
                                        ->directory('polls/logos'),

                                    ColorPicker::make('background_color')
                                        ->label('Background Color')
                                        ->nullable(),

                                    FileUpload::make('background_image')
                                        ->label('Background Image')
                                        ->image()
                                        ->directory('polls/backgrounds'),

                                    ColorPicker::make('text_color')
                                        ->label('Text Color')
                                        ->nullable(),

                                    TextInput::make('button_text')
                                        ->label('Button Text')
                                        ->default('Vote Now'),

                                    TextInput::make('results_title')
                                        ->label('Results Title')
                                        ->default('Poll Results'),

                                    Textarea::make('results_summary')
                                        ->label('Summary Text')
                                        ->default('Thank you for participating!')
                                        ->nullable(),

                                    ColorPicker::make('button_color')
                                        ->label('Button Color')
                                        ->default('#0000FF')
                                        ->nullable(),

                                    ColorPicker::make('button_text_color')
                                        ->label('Button Text Color')
                                        ->default('#FFFFFF')
                                        ->nullable(),
                                ])
                                ->columnSpan('full'), // Make this full width
                        ]),
                ])
                ->columnSpan('full')
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
