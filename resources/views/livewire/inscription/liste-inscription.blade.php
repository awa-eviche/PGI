<div>
    <div class="flex items-center px-4">
        <div class="flex-1">
            <h2 class="font-bold text-maquette-gris text-xl py-4">
                {{ $currentClasse ? $currentClasse->libelle : 'Aucune classe sélectionnée' }}
            </h2>
        </div>
        <div class="flex gap-4 items-center px-4">
            <!-- Select Classe -->
            <select wire:model="classe" wire:change="$refresh" class="border border-gray-300 p-2 rounded text-sm w-1/2">
                <option value="">Sélectionner la classe</option>
                @foreach ($classes as $c)
                    <option value="{{ $c->id }}">{{ $c->libelle }}</option>
                @endforeach
            </select>

            <!-- Select Année académique -->
            <select wire:model="anneeAcademique" wire:change="$refresh" class="border border-gray-300 p-2 rounded text-sm w-1/2">
                <option value="">Sélectionner l’année académique</option>
                @foreach ($anneeAcademiques as $a)
                    <option value="{{ $a->id }}">{{ $a->code }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if($currentClasse)
        <div class="py-2 px-4 m-2 shadow bg-vert2 rounded shadow border border-black">
            <div class="grid grid-cols-3 gap-2 py-2 text-md">
                <div class="flex items-center">
                    <span class="text-gray-800">Année Scolaire :</span>
                    <span class="font-bold">{{ $anneeAcademiqueLabel ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Filière :</span>
                    <span class="font-bold">{{ $currentClasse->niveau_etude->metier->filiere->nom }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Métier :</span>
                    <span class="font-bold">{{ $currentClasse->niveau_etude->metier->nom }}</span>
                    &nbsp;&nbsp;&nbsp;
                    <span class="text-gray-800">Modalité :</span>
                    <span class="font-bold">{{ $currentClasse->modalite }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Niveau d'études :</span>
                    <span class="font-bold">{{ $currentClasse->niveau_etude->nom }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">État classe :</span>
                    <span class="font-bold">
                        {{ strval($currentClasse->statut) == "" ? 'Non Validé' : (!($currentClasse->etat_classe) ? 'Validé' : 'Lancé') }}
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Nombre apprenants :</span>
                    <span class="font-bold">{{ count($apprenants) }}</span>
                </div>
            </div>
        </div>
        <br />
    @endif

    <div class="w-full sm:px-2 lg:px-4">
        <div class="">
            @if($currentClasse)
                <div class="flex py-2">
                    <div class="w-1/2 me-2 p-4 border bg-gray border shadow rounded" style="min-height:50vh">
                        <h2 class="font-bold text-xl mb-4">Liste des apprenants</h2>
                        <hr class="w-50">
                        <div class="py-2 ">
                            <table class="w-full mb-3">
                                <tbody class="bg-white divide-y ">
                                    @forelse ($apprenants as $apprenant)
                                        <tr class="text-gray-700 {{ ($selectedApprenant == $apprenant->id) ? 'bg-green-600' : '' }}">
                                            <td wire:click="loadCompetences({{ $apprenant->id }})"
                                                class="pt px-2 font-bold border-b {{ ($selectedApprenant == $apprenant->id) ? 'text-white' : 'text-gray-600' }}">
                                                <i class="fa fa-caret-right"></i>
                                                {{ $apprenant->apprenant->user->matricule ?? '-' }}
                                            </td>
                                            <td class="px-2 border-b {{ ($selectedApprenant == $apprenant->id) ? 'text-white' : 'text-gray-500' }}">
                                                {{ ($apprenant->apprenant->nom.' '.$apprenant->apprenant->prenom) ?? '-' }}
                                            </td>
                                            <td class="px-2 text-center border-b {{ ($selectedApprenant == $apprenant->id) ? 'text-white' : 'text-gray-500' }}">
                                                <a href="#" wire:click="loadCompetences({{ $apprenant->id }})" class="text-green-600">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-2 font-bold text-xs text-center">
                                                Aucun apprenant n'est enregistré pour cette classe.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($selectedApprenant)
                    @php
    $user = auth()->user();
    $personnel = $user?->personnel;
    $isFormateurAssigné = false;

    if ($personnel && $currentClasse) {
        $isFormateurAssigné = \Illuminate\Support\Facades\DB::table('formateur_etablissement')
            ->where('classe_id', $currentClasse->id)
            ->where('personnel_etablissement_id', $personnel->id)
            ->exists();
    }
@endphp


                        <div class="w-1/2 p-4 border bg-gray-100 rounded border shadow">
                            <h2 class="font-bold text-xl mb-4">
                                Liste des matières et détails d'évaluation {{ $currentApprenant->apprenant->matricule }}
                                {{ $currentApprenant->apprenant->nom }} {{ $currentApprenant->apprenant->prenom }}
                            </h2>
                            <hr class="w-50">
                            <div class="mt-4 flex gap-4 ">
                                <a class="text-white bg-green-600 text-sm rounded-md shadow-md px-4 py-2"
                                   target="_blank" href="{{ route('evaluation.pdf', $currentApprenant->id) }}">
                                    <i class="fa fa-file-pdf"></i>&nbsp;Télécharger le bulletin
                                </a>
                                <div class="flex items-center justify-end">
                                    <label for="selectedsemestre" class="block text-sm font-bold text-gray-700 mr-2">Semestre :</label>
                                    <select wire:model="selectedsemestre" id="selectedsemestre" name="semestre"
                                            class="block w-auto border border-gray-300 rounded shadow-sm focus:border-first-orange enlever_shadow text-sm"
                                            wire:change="$refresh">
                                        <option value="">Tous les semestres</option>
                                        <option value="1">Premier semestre</option>
                                        <option value="2">Deuxième semestre</option>
                                    </select>
                                </div>
                            </div>

                            <div class="py-2 text-xs">
                                <table class="w-full mb-3">
                                    <thead>
                                        <tr class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold uppercase border-b">
                                            <th class="p-2 border text-center text-gray-800">Matière</th>
                                            <th class="p-2 border text-center text-gray-800">Coef</th>
                                            <th class="p-2 border text-center text-gray-800">Note CC</th>
                                            <th class="p-2 border text-center text-gray-800">Note Composition</th>
                                            <th class="p-2 border text-center text-gray-800">Moyenne</th>
                                            <th class="p-2 border text-center text-gray-800">Semestre</th>
                                            <th class="p-2 border text-center text-gray-800">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y">
                                        @forelse($matieres as $matiere)
                                            @php
                                                $evaluation = $evalu->where('matiere_id', $matiere->id)
                                                                    ->where('semestre', $selectedsemestre)
                                                                    ->first();
                                            @endphp
                                            <tr>
                                                <td class="p-2 border text-center font-bold">{{ $matiere->nom }}</td>
                                                <td class="p-2 border text-center">{{ $matiere->coef }}</td>
                                                <td class="p-2 border text-center">{{ $evaluation->note_cc ?? '-' }}</td>
                                                <td class="p-2 border text-center">{{ $evaluation->note_composition ?? '-' }}</td>
                                                <td class="p-2 border text-center">
                                                    @if($evaluation)
                                                        {{ $this->calculerMoyenne($evaluation->note_cc, $evaluation->note_composition) }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="p-2 border text-center">{{ $evaluation->semestre ?? '-' }}</td>
                                                <td class="p-2 border text-center">
    @if ($isFormateurAssigné || $user->hasRole('superadmin'))
        @if ($evaluation)
            {{-- === SI la matière a déjà une note === --}}
            <!-- Bouton Modifier -->
            <a href="#" data-modal-target="default-modal-edit{{ $matiere->id }}" data-modal-toggle="default-modal-edit{{ $matiere->id }}">
                <span class="text-left">
                    <i class="fa fa-edit" style="color: green;"></i>
                </span>
            </a>

            <!-- Modal Modifier -->
            <div id="default-modal-edit{{ $matiere->id }}" tabindex="-1" aria-hidden="true"
                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Modification de l'évaluation de la matière {{ $matiere->nom }}
                            </h3>
                            <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="default-modal-edit{{ $matiere->id }}">
                                ✕
                            </button>
                        </div>
                        <div class="p-4 md:p-5 space-y-4">
                            <form action="{{ route('evaluation.update', ['evaluation' => $evaluation->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="semestre" value="{{ $selectedsemestre }}">
                                <input type="hidden" name="matiere_id" value="{{ $evaluation->matiere_id }}">

                                <div class="flex flex-wrap w-full justify-evenly mb-4">
                                    <div class="flex-grow mr-2">
                                        <label for="note_cc" class="block text-sm font-bold text-gray-700">Note Contrôle Continu :</label>
                                        <input type="text" name="note_cc" id="note_cc"
                                               class="form-input rounded-md shadow-sm mt-1 block w-full"
                                               value="{{ $evaluation->note_cc }}" />
                                    </div>

                                    <div class="flex-grow mr-2">
                                        <label for="note_composition" class="block text-sm font-bold text-gray-700">Note Composition :</label>
                                        <input type="text" name="note_composition" id="note_composition"
                                               class="form-input rounded-md shadow-sm mt-1 block w-full"
                                               value="{{ $evaluation->note_composition }}" />
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Enregistrer les modifications
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            &nbsp;&nbsp;&nbsp;

            <!-- Bouton Historique -->
            <a href="#" data-modal-target="default-modal-edit-note{{ $matiere->id }}" data-modal-toggle="default-modal-edit-note{{ $matiere->id }}">
                <span class="text-left">
                    <i class="fa fa-eye" style="color: orange;"></i>
                </span>
            </a>

            <!-- Modal Historique -->
            <div id="default-modal-edit-note{{ $matiere->id }}" tabindex="-1" aria-hidden="true"
                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Historique de modification de la note {{ $matiere->nom }}
                            </h3>
                            <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="default-modal-edit-note{{ $matiere->id }}">
                                ✕
                            </button>
                        </div>
                        <div class="p-4 md:p-5 space-y-4">
                            @php
                                $historiques = App\Models\HistoryNote::where('evaluation_id', $evaluation->id)->get();
                            @endphp
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-200 text-left">
                                        <th class="py-2 px-4 border-b">Auteur</th>
                                        <th class="py-2 px-4 border-b">Modification</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($historiques as $h)
                                        <tr class="hover:bg-gray-100">
                                            <td class="py-2 px-4 border-b">
                                                {{ $h->user->nom.' '.$h->user->prenom }}
                                                <i class="text-xs">({{ $h->created_at->format('d-m-y H:i') }})</i>
                                            </td>
                                            <td class="py-2 px-4 border-b">
                                                @if($h->old_note_cc == null && $h->old_note_composition == null)
                                                    Nouvelle note ajoutée
                                                @endif
                                                @if($h->old_note_cc != null && $h->old_note_composition != null)
                                                    Respectivement {{ $h->old_note_cc }} et {{ $h->old_note_composition }}
                                                    avant la modification.
                                                @endif
                                                @if($h->old_note_cc != null && $h->old_note_composition == null)
                                                    Note de contrôle continue modifiée ({{ $h->old_note_cc }})
                                                @endif
                                                @if($h->old_note_cc == null && $h->old_note_composition != null)
                                                    Note de composition modifiée ({{ $h->old_note_composition }})
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="p-2 font-bold text-lg text-center">Pas d'historique.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            &nbsp;&nbsp;&nbsp;

            <!-- Bouton Supprimer -->
            {!! Form::open([
                'method' => 'DELETE',
                'class' => 'delete-form',
                'style' => 'display: inline;',
                'route' => ['evaluation.destroy', $evaluation->id]
            ]) !!}
                {{ csrf_field() }}
                <button class="text-red-500 mr-2 apix-delete" data-id="{{ $evaluation->id }}" title="Supprimer">
                    <i class="fas fa-trash-alt mr-1"></i>
                </button>
            {!! Form::close() !!}

        @else
            {{-- === SI la matière n’a pas encore de note === --}}
            <a href="#" data-modal-target="default-modal{{ $matiere->id }}" data-modal-toggle="default-modal{{ $matiere->id }}">
                <span class="text-left">
                    <i class="fa fa-plus-circle" style="color: green;"></i>
                </span>
            </a>

            <!-- Modal Ajouter -->
            <div id="default-modal{{ $matiere->id }}" tabindex="-1" aria-hidden="true"
                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Évaluation de la matière {{ $matiere->nom }}
                            </h3>
                            <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="default-modal{{ $matiere->id }}">
                                ✕
                            </button>
                        </div>
                        <div class="p-4 md:p-5 space-y-4">
                            <form action="{{ route('evaluation.store', ['inscriptionId' => $inscriptionId]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="inscription_id" value="{{ $inscriptionId }}">
                                <input type="hidden" name="matiere_id" value="{{ $matiere->id }}">
                                <input type="hidden" name="semestre" value="{{ $selectedsemestre }}">

                                <div class="flex flex-wrap w-full justify-evenly">
                                    <div class="flex-grow mb-4 mr-2">
                                        <label for="note_cc" class="block text-sm font-bold text-gray-700">Note Contrôle Continu :</label>
                                        <input type="text" name="note_cc" id="note_cc" class="form-input rounded-md shadow-sm mt-1 block w-full" />
                                    </div>

                                    <div class="flex-grow mb-4 mr-2">
                                        <label for="note_composition" class="block text-sm font-bold text-gray-700">Note Composition :</label>
                                        <input type="text" name="note_composition" id="note_composition" class="form-input rounded-md shadow-sm mt-1 block w-full" />
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @else
        <span class="text-gray-400 text-xs italic">Non autorisé</span>
    @endif
</td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="p-2 font-bold text-lg text-center">Aucune matière disponible pour ce semestre.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="w-full items-center text-md m-3 text-center text-red-600">
                            Aucun apprenant sélectionné !
                        </div>
                    @endif
                </div>
            @else
                <div class="flex p-10 justify-center items-center">
                    <h3 class="text-2xl">Aucune donnée disponible</h3>
                </div>
            @endif
        </div>
    </div>
</div>
