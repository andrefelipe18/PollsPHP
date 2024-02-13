<?php

namespace App\Jobs;

use App\Models\{PollOptions, User};
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\OptionVoted;
use Illuminate\Support\Facades\Mail;

class SendVoteOptionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public PollOptions $option,
        public User $author,
        public User $user,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $senderEmail = $this->user->email;
        $senderName = $this->user->name;
        Mail::to($this->author->email)->send(new OptionVoted([
            'senderEmail' => $senderEmail,
            'senderName' => $senderName,
            'subject' => 'New vote on your poll',
        ]));
    }
}
