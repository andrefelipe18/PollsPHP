<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 dark:bg-gray-800 shadow-sm sm:rounded-lg flex flex-col">
                <div class="p-4 text-gray-900 dark:text-gray-100">
                    {{-- Cria a Poll --}}
                    @livewire('poll.create')

                    {{-- Lista as Polls --}}
                    @livewire('poll.index')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
