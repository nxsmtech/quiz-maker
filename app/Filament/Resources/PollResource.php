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
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\HtmlString;

class PollResource extends Resource
{
    protected static ?string $model = Poll::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';

    protected static bool $shouldSkipAuthorization = true;

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
                                '<div style="position:relative; width:100%;">
                                        <iframe id="pollIframe" src="' . $url . '" style="width:100%; border:none;" frameborder="0" allowfullscreen></iframe>
                                   </div>
                                   <script>
                                         document.getElementById("pollIframe").onload = function() {
                                             const iframe = document.getElementById("pollIframe");
                                             iframe.style.height = iframe.contentWindow.document.body.scrollHeight + "px";
                                         };
                                   </script>'
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
                                        ->disk('public')
                                        ->label('Logo')
                                        ->image()
                                        ->directory('polls/logos'),

                                    ColorPicker::make('background_color')
                                        ->label('Background Color')
                                        ->nullable(),

                                    FileUpload::make('background_image')
                                        ->disk('public')
                                        ->label('Background Image')
                                        ->image()
                                        ->directory('polls/backgrounds'),

                                    ColorPicker::make('text_color')
                                        ->label('Text Color')
                                        ->nullable(),

                                    TextInput::make('total_votes_text')
                                        ->label('Total Votes Text')
                                        ->default('Total votes'),

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
                    Tabs\Tab::make('Embed')
                        ->icon('heroicon-m-code-bracket')
                        ->schema([
                            Section::make('Embed code')
                                ->columns(1)
                                ->schema([
                                    Textarea::make('iframe_code')
                                        ->afterStateHydrated(function (Textarea $component, $record) {
                                            if ($record) {
                                                $component->state(
                                                    '<iframe src="' . route('poll.preview', ['poll' => $record->id]) .
                                                    '" style="width:100%; height:100%; border:none;" frameborder="0" allowfullscreen></iframe>'
                                                );
                                            } else {
                                                $component->state('No embed code available.');
                                            }
                                        })
                                        ->readOnly()
                                        ->rows(2)
                                        ->readOnly(),
                                ])
                                ->columnSpan('full'),
                        ]),
                ])
                ->columnSpan('full')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')->sortable()->searchable(),
            TextColumn::make('question')->sortable()->searchable(),
            IconColumn::make('is_active')->boolean(),
            TextColumn::make('created_at')->dateTime(),
        ])->actions([
            ReplicateAction::make()
                ->excludeAttributes(['is_active'])
                ->beforeReplicaSaved(function (Poll $replica): void {
                    $replica->title = '[NEW] ' . $replica->title;
                }),
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
