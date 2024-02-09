<?php

use function Livewire\Volt\{state};
use App\Models\Poll;

state(['title' => '']);
state(['options' => []]);

$savePoll = function() {
    $this->validate([
        'title' => 'required',
        'options' => 'required'
    ]);

    $poll = Poll::create([
        'title' => $this->title
    ]);

    foreach($this->options as $option) {
        $poll->options()->create([
            'title' => $option
        ]);
    }

    $this->reset();
    session()->flash('message', 'Poll created successfully');
};
?>

<div>
    @if(session()->has('message'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
        <p class="font-bold">Success</p>
        <p>{{ session('message') }}</p>
    </div>
    @endif
    <form action="" wire:submit='savePoll'>
        @csrf
        <x-ts-input wire:model="title" label="Insert Poll Title" />

        <div class="flex mt-4 gap-4">
            <x-ts-checkbox value="Livewire" wire:model='options' label="Livewire" color='fuchsia' />
            <x-ts-checkbox value="AlpineJS" wire:model='options' label="AlpineJS" color='gray' />
            <x-ts-checkbox value="Tailwind" wire:model='options' label="Tailwind" color='sky' />
            <x-ts-checkbox value="Laravel" wire:model='options' label="Laravel" color='red' />
        </div>

        <x-ts-button type="submit" class="mt-4">Create Poll</x-ts-button>
    </form>
</div>
