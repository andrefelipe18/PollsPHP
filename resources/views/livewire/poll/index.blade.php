<?php

use function Livewire\Volt\{state, mount, on};
use App\Models\{Poll, PollOptions, Vote};

state(['polls' => Poll::all()]);
state('optionSelected', null);

$voteInOption = function() {
    if($this->optionSelected) {
        $option = PollOptions::find($this->optionSelected);

        $vote = Vote::where('user_id', auth()->id())
            ->where('poll_id', $option->poll_id)
            ->first();

        if($vote) {
            $vote->delete();
        }

        $option->votes()->create([
            'user_id' => auth()->id(),
            'poll_id' => $option->poll_id,
            'poll_options_id' => $option->id
        ]);
    }
    $this->optionSelected = null;
};

on(['newPoll' => function () {
    $this->polls = Poll::all();
}]);
?>

<div>
    @foreach ($polls as $poll)
    <div class="mb-12">
        <x-ts-card :header="$poll->title">
            <p class="text-gray-800 mb-1">Vote in the in one option below:</p>
            @foreach ($poll->options as $option)
            <div class="flex items-center gap-4">
                <x-ts-radio class="mt-2" wire:model='optionSelected' value="{{ $option->id }}"
                    label="{{ $option->title }}" />
                <x-ts-badge>{{ $option->votes->count() }}</x-ts-badge>
            </div>
            @endforeach
            <x-ts-button class="mt-2" wire:click='voteInOption'>Vote</x-ts-button>
        </x-ts-card>
    </div>
    @endforeach
</div>
