<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{--    {{ __('Données de l\'apprenant') }}  --}}
        </h2>
    </x-slot>

    <livewire:Apprenants.DetailApprenant :apprenant="$apprenant"  />


</x-app-layout>
