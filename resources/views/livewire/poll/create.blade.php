<?php

use function Livewire\Volt\{state, rules, mount, uses};
use App\Models\{Poll, PollOptions};
use Illuminate\Support\Facades\DB;
use TallStackUi\Traits\Interactions;

uses([Interactions::class]);

rules(fn () => [
    'title' => ['required', 'min:10', 'max:255'],
    'options' => ['required', 'min:2']
]);

state(['title' => '']);
state(['options' => []]);

mount(function () {
    $this->options = ['', ''];
});

$addOption = function() {
    $this->options[] = '';
};

$savePoll = function() {
    $this->validate();

    DB::beginTransaction(); //Inicia uma transaction
    try {
        $poll = Poll::create([
            'title' => $this->title,
            'user_id' => auth()->id(),
        ]);

        $options = collect($this->options)->map(function ($option) use ($poll) {
            return [
                'title' => $option,
                'poll_id' => $poll->id,
            ];
        })->toArray();

        PollOptions::insert($options);

        $this->title = '';
        $this->options = [''];
        $this->toast()->success('Poll created successfully!')->send();
        $this->dispatch('newPoll');
    } catch (\Exception $e) {
        DB::rollBack();
        $this->toast()->error('Error creating poll!')->send();
    }
    DB::commit();
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
