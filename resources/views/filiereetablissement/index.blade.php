<x-app-layout>
  

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Filières') }}
        </h2>
    </x-slot>

    <div class="mx-auto">
    <livewire:FiliereEtablissements.ListeFiliereEtablissement/>
    </div>

</x-app-layout>
