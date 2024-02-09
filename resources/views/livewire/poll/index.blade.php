<?php

use function Livewire\Volt\{state, mount, on};
use App\Models\Poll;

state(['polls' => []]);

mount(function() {
    $this->polls = Poll::all();
});

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
                <x-ts-radio class="mt-2" wire:model="polls.{{ $poll->id }}" value="{{ $option->id }}" label="{{ $option->title }}" />
                {{-- <x-ts-badge>{{ $option->votes->count() }}</x-ts-badge> --}}
            </div>
            @endforeach
        </x-ts-card>
    </div>
    @endforeach
</div>
