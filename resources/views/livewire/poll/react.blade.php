<?php

use function Livewire\Volt\{state,mount, on};
use \App\Models\PollReaction;

state(['quantity' => 0]);
state(['reaction' => '']);
state(['poll' => '']);

mount(function($poll){
    $this->quantity = PollReaction::where('poll_id', $poll->id)->count();
    $this->poll = $poll;
});

on(['echo-private:pollreaction,NewReactionEvent'=>function($data){
    $pollId = $data['reaction']['poll_id'];
    if($pollId === $this->poll->id) {
        $this->quantity = PollReaction::where('poll_id', $this->poll->id)->count();
    }
}]);


$react = function(string $reaction) {

    $userHasReacted = PollReaction::where('poll_id', $this->poll->id)
        ->where('user_id', auth()->id())
        ->first();

    if($userHasReacted && $userHasReacted->reaction === $reaction) {
        $userHasReacted->delete();
        $this->quantity--;
        return;
    }

    if($userHasReacted && $userHasReacted->reaction !== $reaction) {
        $userHasReacted->update(['reaction' => $reaction]);
        return;
    }

    PollReaction::create([
        'poll_id' => $this->poll->id,
        'reaction' => $reaction,
        'user_id' => auth()->id()
    ]);

    $this->quantity++;
};

?>

<div>
    <div class="mt-2 mb-4">
        <x-ts-reaction wire:model="quantity" :$quantity :only="['thumbs-up', 'thumbs-down', 'heart']" />
        <p>Reaction count: {{ $quantity }}</p>
    </div>
</div>
