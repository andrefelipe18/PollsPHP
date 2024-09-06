<?php

use function Livewire\Volt\{state, rules, mount, on};
use \App\Models\Message;
use App\Events\NewMessageEvent;


state(['messages' => []]);
state(['content' => '']);
state(['isDisabled' => false]);


mount(function(){
    $this->messages = Message::latest()->take(10)->get();
});


$create = function () {
    if(empty($this->content)) return;

    $message = Message::create([
        'content' => $this->content,
        'user_id' => Auth::user()->id,
    ]);

    NewMessageEvent::dispatch($message);

    $this->content = '';
};

on(['echo-private:newmessage,NewMessageEvent'=>function($data){
    $this->messages = Message::latest()->take(6)->get();
}]);

?>

<div>
    <x-ts-input label="Name" hint="Insert your name" :disabled="$isDisabled" />
    <x-ts-button wire:click="$set('isDisabled', true)">
        Disable
    </x-ts-button>
    <h1>Messages</h1>
    <ul>
        @foreach($messages as $message)
        <li class="mt-2 mb-2">
            @if($message->user->id === Auth::user()->id)
            <x-ts-alert :title="$message->user->name">
                {{ $message->content }}
            </x-ts-alert>
            @else
            <x-ts-alert :title=" $message->user->name" color="slate">
                {{ $message->content }}
            </x-ts-alert>
            @endif
        </li>
        @endforeach
    </ul>
    <div>
        <x-ts-input wire:model="content" />
        <x-ts-button wire:click="create" class="mt-2">
            Send
        </x-ts-button>
    </div>
</div>
