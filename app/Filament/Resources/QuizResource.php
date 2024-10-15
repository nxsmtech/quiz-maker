<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizResource\Pages;
use App\Models\Quiz;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Quiz Preview')
                    ->schema([
                        Placeholder::make('quizPreview')
                            ->label('Quiz Preview')
                            ->content(function ($record) {
                                $url = route('quiz.preview', ['quiz' => $record->id]);
                                return new HtmlString('
                                    <div style="position:relative; width:100%; height:0; padding-bottom:56.25%;">
                                        <iframe src="' . $url . '" style="position:absolute; top:0; left:0; width:100%; height:100%;" frameborder="0" allowfullscreen></iframe>
                                    </div>'
                                );
                            }),
                    ])
                    ->hidden(fn ($livewire) => $livewire instanceof CreateRecord),

                Section::make('Quiz Details')
                    ->schema([
                        TextInput::make('title')->required(),
                        Textarea::make('description'),
                    ]),

                Section::make('Questions')
                    ->schema([
                        Repeater::make('questions')
                            ->relationship('questions')
                            ->orderColumn('order_nr')
                            ->reorderable()
                            ->schema([
                                Textarea::make('question_text')->required(),
                                Repeater::make('answers')
                                    ->relationship('answers')
                                    ->orderColumn('order_nr')
                                    ->reorderable()
                                    ->schema([
                                        RichEditor::make('answer_text')->required(),
                                        Toggle::make('is_correct')->label('Correct Answer')->inline(false),
                                    ])
                                    ->itemLabel(fn (array $state): string => 'Answer ' . ($state['order_nr'] ?? '') . ' - ' . strip_tags($state['answer_text']))
                                    ->collapsible()
                                    ->collapsed()
                                    ->cloneable(),
                            ])
                            ->collapsed()
                            ->collapsible()
                            ->cloneable()
                            ->itemLabel(fn (array $state): string => 'Question ' . ($state['order_nr'] ?? '') . ' - ' . $state['question_text']),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('created_at')->dateTime(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Quizzes';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }
}
