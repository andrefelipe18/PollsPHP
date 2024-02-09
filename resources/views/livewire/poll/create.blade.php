<?php

use function Livewire\Volt\{state, rules, mount};
use App\Models\{Poll, PollOptions};
use Illuminate\Support\Facades\DB;

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

mount(function () {
    $this->options = [''];
});

$addOption = function() {
    $this->options[] = '';
};

$savePoll = function() {
    $this->validate();

    DB::transaction(function () {
        $poll = Poll::create([
            'title' => $this->title,
            'user_id' => auth()->id(),
        ]);
        foreach($this->options as $option) {
            PollOptions::create([
                'title' => $option,
                'poll_id' => $poll->id
            ]);
        }
        $this->reset();
        $this->dispatch('newPoll');
    });
};
?>

<div>
    <form>
        @csrf
        <x-ts-input wire:model="title" id="form_create_poll" label="Insert Poll Title" />

        <div class="flex flex-col gap-4 mt-4">
            @foreach($options as $index => $option)
            <x-ts-input wire:model="options.{{ $index }}" label="Option {{ $index + 1 }}" />
            @endforeach
        </div>

        <x-ts-button wire:click="addOption" id="addOption" class="mt-4">Add Option</x-ts-button>

        <x-ts-button wire:click='savePoll' id="savePoll" type="submit" class="mt-4 mb-12" color="emerald">Create Poll
        </x-ts-button>
    </form>
</div>

@script
<script>
    let form = document.getElementById('form_create_poll');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
    });

    let addOption = document.getElementById('addOption');
    addOption.addEventListener('click', function(event) {
        event.preventDefault();
    });

    let savePoll = document.getElementById('savePoll');
    savePoll.addEventListener('click', function(event) {
        event.preventDefault();
    });

</script>
@endscript
