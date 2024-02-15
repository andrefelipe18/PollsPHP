<?php

use function Livewire\Volt\{state};

state(['quantity' => 0]);
state(['reaction' => '']);

$react = function(string $reaction) {
    $this->quantity++;
    $this->reaction = $reaction;
};

?>

<div>
    <div class="mt-2 mb-4">
        <x-ts-reaction wire:model="quantity" :$quantity :only="['thumbs-up', 'thumbs-down', 'heart']" />
        <p>Reaction count: {{ $quantity }}</p>
    </div>
</div>
