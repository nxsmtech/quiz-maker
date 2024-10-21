<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poll extends Model
{
    protected $fillable = [
        'title',
        'description',
        'question',
        'button_text',
        'results_title',
        'results_summary',
        'logo',
        'background_image',
        'background_color',
        'text_color',
        'button_color',
        'button_text_color',
        'is_active',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(PollOption::class);
    }
}
