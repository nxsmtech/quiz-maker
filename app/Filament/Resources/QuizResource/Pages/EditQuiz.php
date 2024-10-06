<?php

namespace App\Filament\Resources\QuizResource\Pages;

use App\Filament\Resources\QuizResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;

class EditQuiz extends EditRecord
{
    protected static string $resource = QuizResource::class;

    protected $listeners = ['updateQuestion' => 'updateQuestion'];

    public function updateQuestion($newText)
    {
        dd(111);
        Log::info('Updated Question Text: ' . $newText);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
