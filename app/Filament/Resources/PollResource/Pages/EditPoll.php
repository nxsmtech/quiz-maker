<?php

namespace App\Filament\Resources\PollResource\Pages;

use App\Filament\Resources\PollResource;
use Filament\Actions\Action;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cookie;

class EditPoll extends EditRecord
{
    protected static string $resource = PollResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('resetVotes')
                ->label('Reset Votes')
                ->action(fn () => $this->resetVotes())
                ->color('warning')
                ->requiresConfirmation(),
            Actions\DeleteAction::make(),
        ];
    }

    public function resetVotes()
    {
        $this->record->options()->update(['votes' => 0]);
        $this->record->increment('version');
        Cookie::queue(Cookie::forget('poll_' . $this->record->id . '_v' . ($this->record->version - 1)));

        Notification::make()
            ->title('Votes have been reset! Version updated.')
            ->success()
            ->send();
    }
}
