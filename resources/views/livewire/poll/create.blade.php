<?php

use function Livewire\Volt\{state, rules};
use App\Models\Poll;

rules(fn () => [
    'title' => ['required', 'min:10', 'max:255'],
    'options' => ['required', 'min:2']
])->messages([
    'title.required' => 'The title is required',
    'title.min' => 'The title must be at least 10 characters',
    'title.max' => 'The title must be at most 255 characters',
    'options.required' => 'The options are required',
    'options.min' => 'The options must be at least 2'
]);

state(['title' => '']);
state(['options' => []]);

$savePoll = function() {
    $this->validate();

    $poll = Poll::create([
        'title' => $this->title
    ]);

    foreach($this->options as $option) {
        $poll->options()->create([
            'title' => $option
        ]);
    }

    $this->reset();
    $this->dispatch('newPoll');
};
?>

<div>
    <form action="" wire:submit.prevent='savePoll'>
        @csrf
        <x-ts-input wire:model="title" label="Insert Poll Title" />

        <div class="flex mt-4 gap-4">
            <x-ts-checkbox value="Livewire" wire:model='options' label="Livewire" color='fuchsia' />
            <x-ts-checkbox value="AlpineJS" wire:model='options' label="AlpineJS" color='gray' />
            <x-ts-checkbox value="Tailwind" wire:model='options' label="Tailwind" color='sky' />
            <x-ts-checkbox value="Laravel" wire:model='options' label="Laravel" color='red' />

        </div>

        <x-ts-button type="submit" class="mb-12 mt-4">Create Poll</x-ts-button>
    </form>
</div>
