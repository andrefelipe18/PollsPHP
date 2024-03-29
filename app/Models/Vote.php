<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Poll;
use App\Models\PollOptions;
use App\Models\User;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'poll_id', 'poll_option_id'];

    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class);
    }

    public function pollOption(): BelongsTo
    {
        return $this->belongsTo(PollOptions::class, 'poll_options_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
