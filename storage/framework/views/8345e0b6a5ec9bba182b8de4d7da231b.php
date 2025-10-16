<div>
    <div class="flex items-center px-4">
        <div class="flex-1">
            <h2 class="font-bold text-maquette-gris text-xl py-4">
                <?php echo e($currentClasse ? $currentClasse->libelle : 'Aucune classe sélectionnée'); ?>

            </h2>
        </div>
        <div class="flex gap-4 items-center px-4">
            <!-- Select Classe -->
            <select wire:model="classe" wire:change="$refresh" class="border border-gray-300 p-2 rounded text-sm w-1/2">
                <option value="">Sélectionner la classe</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($c->id); ?>"><?php echo e($c->libelle); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>

            <!-- Select Année académique -->
            <select wire:model="anneeAcademique" wire:change="$refresh" class="border border-gray-300 p-2 rounded text-sm w-1/2">
                <option value="">Sélectionner l’année académique</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $anneeAcademiques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($a->id); ?>"><?php echo e($a->code); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
        </div>
    </div>

    <!--[if BLOCK]><![endif]--><?php if($currentClasse): ?>
        <div class="py-2 px-4 m-2 shadow bg-vert2 rounded shadow border border-black">
            <div class="grid grid-cols-3 gap-2 py-2 text-md">
                <div class="flex items-center">
                    <span class="text-gray-800">Année Scolaire :</span>
                    <span class="font-bold"><?php echo e($anneeAcademiqueLabel ?? 'N/A'); ?></span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Filière :</span>
                    <span class="font-bold"><?php echo e($currentClasse->niveau_etude->metier->filiere->nom); ?></span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Métier :</span>
                    <span class="font-bold"><?php echo e($currentClasse->niveau_etude->metier->nom); ?></span>
                    &nbsp;&nbsp;&nbsp;
                    <span class="text-gray-800">Modalité :</span>
                    <span class="font-bold"><?php echo e($currentClasse->modalite); ?></span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Niveau d'études :</span>
                    <span class="font-bold"><?php echo e($currentClasse->niveau_etude->nom); ?></span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">État classe :</span>
                    <span class="font-bold">
                        <?php echo e(strval($currentClasse->statut) == "" ? 'Non Validé' : (!($currentClasse->etat_classe) ? 'Validé' : 'Lancé')); ?>

                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Nombre apprenants :</span>
                    <span class="font-bold"><?php echo e(count($apprenants)); ?></span>
                </div>
            </div>
        </div>
        <br />
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div class="w-full sm:px-2 lg:px-4">
        <div class="">
            <!--[if BLOCK]><![endif]--><?php if($currentClasse): ?>
                <div class="flex py-2">
                    <div class="w-1/2 me-2 p-4 border bg-gray border shadow rounded" style="min-height:50vh">
                        <h2 class="font-bold text-xl mb-4">Liste des apprenants</h2>
                        <hr class="w-50">
                        <div class="py-2 ">
                            <table class="w-full mb-3">
                                <tbody class="bg-white divide-y ">
                                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $apprenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apprenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="text-gray-700 <?php echo e(($selectedApprenant == $apprenant->id) ? 'bg-green-600' : ''); ?>">
                                            <td wire:click="loadCompetences(<?php echo e($apprenant->id); ?>)"
                                                class="pt px-2 font-bold border-b <?php echo e(($selectedApprenant == $apprenant->id) ? 'text-white' : 'text-gray-600'); ?>">
                                                <i class="fa fa-caret-right"></i>
                                                <?php echo e($apprenant->apprenant->user->matricule ?? '-'); ?>

                                            </td>
                                            <td class="px-2 border-b <?php echo e(($selectedApprenant == $apprenant->id) ? 'text-white' : 'text-gray-500'); ?>">
                                                <?php echo e(($apprenant->apprenant->nom.' '.$apprenant->apprenant->prenom) ?? '-'); ?>

                                            </td>
                                            <td class="px-2 text-center border-b <?php echo e(($selectedApprenant == $apprenant->id) ? 'text-white' : 'text-gray-500'); ?>">
                                                <a href="#" wire:click="loadCompetences(<?php echo e($apprenant->id); ?>)" class="text-green-600">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="3" class="px-2 font-bold text-xs text-center">
                                                Aucun apprenant n'est enregistré pour cette classe.
                                            </td>
                                        </tr>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!--[if BLOCK]><![endif]--><?php if($selectedApprenant): ?>
                    <?php
    $user = auth()->user();
    $personnel = $user?->personnel;
    $isFormateurAssigné = false;

    if ($personnel && $currentClasse) {
        $isFormateurAssigné = \Illuminate\Support\Facades\DB::table('formateur_etablissement')
            ->where('classe_id', $currentClasse->id)
            ->where('personnel_etablissement_id', $personnel->id)
            ->exists();
    }
?>


                        <div class="w-1/2 p-4 border bg-gray-100 rounded border shadow">
                            <h2 class="font-bold text-xl mb-4">
                                Liste des matières et détails d'évaluation <?php echo e($currentApprenant->apprenant->matricule); ?>

                                <?php echo e($currentApprenant->apprenant->nom); ?> <?php echo e($currentApprenant->apprenant->prenom); ?>

                            </h2>
                            <hr class="w-50">
                            <div class="mt-4 flex gap-4 ">
                                <a class="text-white bg-green-600 text-sm rounded-md shadow-md px-4 py-2"
                                   target="_blank" href="<?php echo e(route('evaluation.pdf', $currentApprenant->id)); ?>">
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
                                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $matieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <?php
                                                $evaluation = $evalu->where('matiere_id', $matiere->id)
                                                                    ->where('semestre', $selectedsemestre)
                                                                    ->first();
                                            ?>
                                            <tr>
                                                <td class="p-2 border text-center font-bold"><?php echo e($matiere->nom); ?></td>
                                                <td class="p-2 border text-center"><?php echo e($matiere->coef); ?></td>
                                                <td class="p-2 border text-center"><?php echo e($evaluation->note_cc ?? '-'); ?></td>
                                                <td class="p-2 border text-center"><?php echo e($evaluation->note_composition ?? '-'); ?></td>
                                                <td class="p-2 border text-center">
                                                    <!--[if BLOCK]><![endif]--><?php if($evaluation): ?>
                                                        <?php echo e($this->calculerMoyenne($evaluation->note_cc, $evaluation->note_composition)); ?>

                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </td>
                                                <td class="p-2 border text-center"><?php echo e($evaluation->semestre ?? '-'); ?></td>
                                                <td class="p-2 border text-center">
    <!--[if BLOCK]><![endif]--><?php if($isFormateurAssigné || $user->hasRole('superadmin')): ?>
        <!--[if BLOCK]><![endif]--><?php if($evaluation): ?>
            
            <!-- Bouton Modifier -->
            <a href="#" data-modal-target="default-modal-edit<?php echo e($matiere->id); ?>" data-modal-toggle="default-modal-edit<?php echo e($matiere->id); ?>">
                <span class="text-left">
                    <i class="fa fa-edit" style="color: green;"></i>
                </span>
            </a>

            <!-- Modal Modifier -->
            <div id="default-modal-edit<?php echo e($matiere->id); ?>" tabindex="-1" aria-hidden="true"
                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Modification de l'évaluation de la matière <?php echo e($matiere->nom); ?>

                            </h3>
                            <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="default-modal-edit<?php echo e($matiere->id); ?>">
                                ✕
                            </button>
                        </div>
                        <div class="p-4 md:p-5 space-y-4">
                            <form action="<?php echo e(route('evaluation.update', ['evaluation' => $evaluation->id])); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="semestre" value="<?php echo e($selectedsemestre); ?>">
                                <input type="hidden" name="matiere_id" value="<?php echo e($evaluation->matiere_id); ?>">

                                <div class="flex flex-wrap w-full justify-evenly mb-4">
                                    <div class="flex-grow mr-2">
                                        <label for="note_cc" class="block text-sm font-bold text-gray-700">Note Contrôle Continu :</label>
                                        <input type="text" name="note_cc" id="note_cc"
                                               class="form-input rounded-md shadow-sm mt-1 block w-full"
                                               value="<?php echo e($evaluation->note_cc); ?>" />
                                    </div>

                                    <div class="flex-grow mr-2">
                                        <label for="note_composition" class="block text-sm font-bold text-gray-700">Note Composition :</label>
                                        <input type="text" name="note_composition" id="note_composition"
                                               class="form-input rounded-md shadow-sm mt-1 block w-full"
                                               value="<?php echo e($evaluation->note_composition); ?>" />
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
            <a href="#" data-modal-target="default-modal-edit-note<?php echo e($matiere->id); ?>" data-modal-toggle="default-modal-edit-note<?php echo e($matiere->id); ?>">
                <span class="text-left">
                    <i class="fa fa-eye" style="color: orange;"></i>
                </span>
            </a>

            <!-- Modal Historique -->
            <div id="default-modal-edit-note<?php echo e($matiere->id); ?>" tabindex="-1" aria-hidden="true"
                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Historique de modification de la note <?php echo e($matiere->nom); ?>

                            </h3>
                            <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="default-modal-edit-note<?php echo e($matiere->id); ?>">
                                ✕
                            </button>
                        </div>
                        <div class="p-4 md:p-5 space-y-4">
                            <?php
                                $historiques = App\Models\HistoryNote::where('evaluation_id', $evaluation->id)->get();
                            ?>
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-200 text-left">
                                        <th class="py-2 px-4 border-b">Auteur</th>
                                        <th class="py-2 px-4 border-b">Modification</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--[if BLOCK]><![endif]--><?php $__empty_2 = true; $__currentLoopData = $historiques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <tr class="hover:bg-gray-100">
                                            <td class="py-2 px-4 border-b">
                                                <?php echo e($h->user->nom.' '.$h->user->prenom); ?>

                                                <i class="text-xs">(<?php echo e($h->created_at->format('d-m-y H:i')); ?>)</i>
                                            </td>
                                            <td class="py-2 px-4 border-b">
                                                <!--[if BLOCK]><![endif]--><?php if($h->old_note_cc == null && $h->old_note_composition == null): ?>
                                                    Nouvelle note ajoutée
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <!--[if BLOCK]><![endif]--><?php if($h->old_note_cc != null && $h->old_note_composition != null): ?>
                                                    Respectivement <?php echo e($h->old_note_cc); ?> et <?php echo e($h->old_note_composition); ?>

                                                    avant la modification.
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <!--[if BLOCK]><![endif]--><?php if($h->old_note_cc != null && $h->old_note_composition == null): ?>
                                                    Note de contrôle continue modifiée (<?php echo e($h->old_note_cc); ?>)
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <!--[if BLOCK]><![endif]--><?php if($h->old_note_cc == null && $h->old_note_composition != null): ?>
                                                    Note de composition modifiée (<?php echo e($h->old_note_composition); ?>)
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <tr>
                                            <td colspan="3" class="p-2 font-bold text-lg text-center">Pas d'historique.</td>
                                        </tr>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            &nbsp;&nbsp;&nbsp;

            <!-- Bouton Supprimer -->
            <?php echo Form::open([
                'method' => 'DELETE',
                'class' => 'delete-form',
                'style' => 'display: inline;',
                'route' => ['evaluation.destroy', $evaluation->id]
            ]); ?>

                <?php echo e(csrf_field()); ?>

                <button class="text-red-500 mr-2 apix-delete" data-id="<?php echo e($evaluation->id); ?>" title="Supprimer">
                    <i class="fas fa-trash-alt mr-1"></i>
                </button>
            <?php echo Form::close(); ?>


        <?php else: ?>
            
            <a href="#" data-modal-target="default-modal<?php echo e($matiere->id); ?>" data-modal-toggle="default-modal<?php echo e($matiere->id); ?>">
                <span class="text-left">
                    <i class="fa fa-plus-circle" style="color: green;"></i>
                </span>
            </a>

            <!-- Modal Ajouter -->
            <div id="default-modal<?php echo e($matiere->id); ?>" tabindex="-1" aria-hidden="true"
                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Évaluation de la matière <?php echo e($matiere->nom); ?>

                            </h3>
                            <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="default-modal<?php echo e($matiere->id); ?>">
                                ✕
                            </button>
                        </div>
                        <div class="p-4 md:p-5 space-y-4">
                            <form action="<?php echo e(route('evaluation.store', ['inscriptionId' => $inscriptionId])); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="inscription_id" value="<?php echo e($inscriptionId); ?>">
                                <input type="hidden" name="matiere_id" value="<?php echo e($matiere->id); ?>">
                                <input type="hidden" name="semestre" value="<?php echo e($selectedsemestre); ?>">

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
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php else: ?>
        <span class="text-gray-400 text-xs italic">Non autorisé</span>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</td>

                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="7" class="p-2 font-bold text-lg text-center">Aucune matière disponible pour ce semestre.</td>
                                            </tr>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="w-full items-center text-md m-3 text-center text-red-600">
                            Aucun apprenant sélectionné !
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php else: ?>
                <div class="flex p-10 justify-center items-center">
                    <h3 class="text-2xl">Aucune donnée disponible</h3>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/inscription/liste-inscription.blade.php ENDPATH**/ ?>