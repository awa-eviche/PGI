<x-app-layout>
  

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Métier') }}
        </h2>
    </x-slot>

    <div class="mx-auto">
    <livewire:parametrage.Metier.ListeMetier/>
    </div>

</x-app-layout>
