<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouvel Demandes') }}
        </h2>
    </x-slot>

    <livewire:demandes.new-demande :typeDemande="$typeDemande"/>
</x-app-layout>

