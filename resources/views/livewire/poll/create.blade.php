<?php

use function Livewire\Volt\{state};

state(['title' => '']);
state(['options' => []]);

$savePoll = function() {
    dd($this->options);
    $this->validate([
        'title' => 'required'
    ]);

    $poll = Poll::create([
        'title' => $this->title
    ]);
    
};
?>

<div>
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
