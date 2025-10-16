<div>

    <div class="flex items-center px-4">
        <div class="flex-1">
            <h2 class="font-bold text-maquette-black text-xl py-4">
                <?php echo e($currentClasse ? $currentClasse->libelle : 'Aucune classe sélectionnée'); ?>

            </h2>
        </div>
        <div class="mb-4 flex gap-4">
        <div>
            <label for="classe" class="block text-sm font-medium">Classe :</label>
            <select wire:model="classe"  wire:change="$refresh" id="classe" class="rounded border-gray-300 text-sm">
                <option value="">-- Choisir une classe ftp --</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cl->id); ?>"><?php echo e($cl->libelle); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
        </div>

        <!-- Sélection de l’année académique -->
        <div>
            <label for="annee_academique_id" class="block text-sm font-medium">Année académique :</label>
            <select wire:model="annee_academique_id" wire:change="$refresh" id="annee_academique_id" class="rounded border-gray-300 text-sm">
                <option value="">-- Toutes les années --</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = \App\Models\AnneeAcademique::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $annee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($annee->id); ?>"><?php echo e($annee->code); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
        </div>
    </div>

    </div>

    <!--[if BLOCK]><![endif]--><?php if($currentClasse): ?>
            <div class="py-2 px-4 m-2 shadow bg-vert2  shadow border border-black">
                <div class="flex flex-col sm:grid sm:grid-cols-3 gap-2 py-2 text-md">
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <span class="text-gray-800">Année Scolaire :</span>
                         <span class="font-bold"><?php echo e($anneeAcademiqueLabel ?? 'N/A'); ?></span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <span class="text-gray-800">Centre de ressources :</span>
                        <span class="font-bold"><?php echo e($currentClasse->etablissement->nom); ?></span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <span class="text-gray-800">Filiére :</span>
                        <span class="font-bold"><?php echo e($currentClasse->niveau_etude->metier->filiere->nom); ?></span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <span class="text-gray-800">Métier :</span>
                        <span class="font-bold"><?php echo e($currentClasse->niveau_etude->metier->nom); ?></span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <span class="text-gray-800">Niveau d'études :</span>
                        <span class="font-bold"><?php echo e($currentClasse->niveau_etude->nom); ?></span>
                    </div>
                    <!--div class="flex flex-col sm:flex-row sm:items-center">
                        <span class="text-gray-800">Etat classe :</span>
                        <span class="font-bold"><?php echo e(strval($currentClasse->etat_classe)=="" ? 'Non Validé' : (!($currentClasse->etat_classe) ? 'Validé' : 'Ouverte')); ?></span>
                    </div-->
                      <div class="flex items-center">
                <span class="text-gray-800">Nombre apprenants :</span>
                <span class="font-bold"><?php echo e($nombreApprenants); ?></span>
            </div>
                </div>
            </div>
            <br />

            <div class="flex flex-col sm:flex-row items-center gap-4 px-4 pb-4">
                <a class="text-white bg-red-800 text-sm rounded-md shadow-md px-4 py-2" target="_blank" href="<?php echo e(route('competence.classe.generate.pdf',$currentClasse)); ?>">
                    <i class="fa fa-file-pdf"></i>&nbsp;Exporter la situation de la classe (PDF)
                </a>

                


            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <div class="w-full sm:px-2 lg:px-4">

<div class="">
    <!--[if BLOCK]><![endif]--><?php if($currentClasse): ?>
    <div class="flex flex-col sm:flex-row py-2">

            <div class="sm:w-1/2 me-2 p-4 border bg-gray border shadow rounded" style="min-height:50vh">
                <h2 class="font-bold text-xl mb-4">Liste des apprenants (<?php echo e(sizeof($apprenants)); ?>)</h2>
                <hr class="w-50">
                <div class="text-sm w-full p-0 relative overflow-x-auto">
                    <table class="w-full border-t mb-3">
                        <thead>
                            <tr
                                class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold border-b">
                                <th class="p-2 text-gray-800">Matricule</th>
                                <th class="p-2 text-gray-800">Nom Prénoms</th>
                                <!--th class="p-2 text-gray-800">Statut</th-->
                                <th class="p-2 text-gray-800">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y ">
                            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $apprenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="text-gray-700 <?php echo e(($selectedApprenant == $inscription->id) ? 'bg-green-600' : ''); ?> ">
                                    <td  wire:click="loadCompetences(<?php echo e($inscription->id); ?>)" class="pt p-1 px-2 font-bold border-b <?php echo e(($selectedApprenant == $inscription->id) ? 'text-white' : 'text-gray-600'); ?>"><i class="fa fa-caret-right"></i> <?php echo e($inscription->apprenant->matricule ?? '-'); ?></td>
                                    <td class="px-2 p-1 border-b <?php echo e(($selectedApprenant == $inscription->id) ? 'text-white' : 'text-gray-500'); ?> ">
                                    <?php echo e(($inscription->apprenant->nom ) . ' ' . ($inscription->apprenant->prenom ?? '-')); ?>                                   
                                     <!--td class="px-2 p-1 text-center border-b <?php echo e(($selectedApprenant == $inscription->id) ? 'text-white' : 'text-gray-500'); ?> text-center"-->
                                    <!--td class="px-2 p-1 border-b <?php echo e(($selectedApprenant == $inscription->id) ? 'text-white' : 'text-gray-500'); ?> ">
                                        <!--[if BLOCK]><![endif]--><?php if($inscription->apprenant->statut): ?>
                                            <?php
                                                $statutA = $inscription->apprenant->statutApprenantEntry->valeur;
                                            ?>
                                            <!--[if BLOCK]><![endif]--><?php if($statutA == "Certifié Admis"): ?> <span class="bg-green-200 text-black rounded px-2"><?php echo e($statutA); ?></span> <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <!--[if BLOCK]><![endif]--><?php if($statutA == "Certifié non admis"): ?> <span class="bg-orange-400 text-white rounded px-2"><?php echo e($statutA); ?></span> <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <!--[if BLOCK]><![endif]--><?php if($statutA == "Formation en cours"): ?> <span class="bg-blue-200 text-black rounded px-2"><?php echo e($statutA); ?></span> <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <!--[if BLOCK]><![endif]--><?php if($statutA == "Désistement"): ?> <span class="bg-red-600 text-white rounded px-2"><?php echo e($statutA); ?></span> <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <!--[if BLOCK]><![endif]--><?php if($statutA == "Abandon"): ?> <span class="bg-red-600 rounded text-white px-2"><?php echo e($statutA); ?></span> <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php else: ?>
                                            -
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td-->
                                    <td class="px-2 p-1 text-center border-b <?php echo e(($selectedApprenant == $inscription->id) ? 'text-white' : 'text-gray-500'); ?> text-center">
                                        <a href="#" wire:click="loadCompetences(<?php echo e($inscription->id); ?>)" class="text-greeen-600"><i class="fa fa-eye"></i></a>
                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="4" class="px-2 font-bold text-xs text-center">Aucun apprenant n'est enregistré pour cette classe.</td></tr>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                </div>
            </div>

            <!--[if BLOCK]><![endif]--><?php if($selectedApprenant): ?>
                <div class="sm:w-1/2 p-4 border bg-gray-100 rounded border shadow">
                    <h2 class="font-bold text-xl mb-4">Liste des compétences acquises par <?php echo e($currentApprenant->apprenant->matricule); ?> <?php echo e($currentApprenant->apprenant->nom); ?> <?php echo e($currentApprenant->apprenant->prenom); ?></h2>
                    <hr class="w-50">
                    <div>
                        <select wire:model="filtre" wire:change="$refresh" class="flex-0 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">
                            <option value="">Filtre par compétence</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $filtres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php echo e($filtre && $comp->id == $filtre ? 'selected' : ''); ?> value="<?php echo e($comp->id); ?>"><?php echo e($comp->nom); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </div>
                    <div class="mt-4 flex flex-wrap flex-row gap-4 ">


<?php
    $user = auth()->user();
    $personnel = $user->personnel;
    $isFormateurAssigné = false;

    if ($personnel && $currentClasse) {
        $isFormateurAssigné = $currentClasse->formateurs()
            ->where('personnel_etablissement_id', $personnel->id)
            ->exists();
    }
?>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_competence')): ?>
    <!--[if BLOCK]><![endif]--><?php if($isFormateurAssigné && !auth()->user()->hasRole(config('constants.roles.superadmin'))): ?>
        <a class="text-white bg-blue-600 text-sm rounded-md shadow-md px-4 py-1"
           href="<?php echo e(route('evaluate.create',$currentApprenant->id)); ?>">
            <i class="fa fa-edit"></i>&nbsp;Evaluer
        </a>
    <?php else: ?>
        <span class="text-gray-400 italic text-sm">Non autorisé</span>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php endif; ?>
<?php
    $user = auth()->user();
?>

<!--[if BLOCK]><![endif]--><?php if(
    $user->hasRole('chef_de_travaux') ||
    $user->hasRole('chef_etablissement') ||
    $user->hasRole('directeur_etude')
): ?>
                        <a class="text-white bg-red-800 text-sm rounded-md shadow-md px-4 py-1" target="_blank" href="<?php echo e(route('competence.generate.pdf',$currentApprenant->id)); ?>">
                            <i class="fa fa-file-pdf"></i>&nbsp;Télecharger le Bulletin
                        </a>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
   <div class="flex items-center justify-end">
                            <label for="selectedsemestre" class="block text-sm font-bold text-gray-700 mr-2">Semestre :</label>
                            <select wire:model="selectedsemestre" id="selectedsemestre" name="semestre" class="block w-auto border border-gray-300 rounded shadow-sm focus:border-first-orange enlever_shadow text-sm" wire:change="$refresh">
                                <option value="">Tous les semestres</option>
                                <option value="1">Premier semestre</option>
                                <option value="2">Deuxième semestre</option>
                            </select>
                        </div>                        

                       
                    </div>
                    <div class="mt-4 flex gap-4 justify-end">
                        <!-- Modal toggle -->
                        <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="text-white bg-gray-600 text-sm rounded-md shadow-md px-4 py-1" type="button">
                            Voir la vue complète
                        </button>
                    </div>

                    <div class="text-xs w-full py-2 relative overflow-x-auto">
                        <table class="w-full border-t mb-3">
                            <thead>
                                <tr
                                    class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold uppercase border-b">
                                    <th class="p-2 border border-black text-center text-gray-800">Compétence</th>
                                  
                                    <th class="p-2 border border-black text-center text-gray-800">Seuil de réussite</th>
                                   <th class="p-2 border border-black text-center text-gray-800">Note / 20</th>

                                    <th class="p-2 border border-black text-center text-gray-800">Date</th>
                                  
                                </tr>
                            </thead>
<tbody class="bg-white divide-y">
    <!--[if BLOCK]><![endif]--><?php if($competences && $competences->count() > 0): ?>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $competences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competence): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $critere = null;
                foreach ($competence->criteres as $c) {
                    if ($c) {
                        $critere = $c;
                        break;
                    }
                }
            ?>

            <!--[if BLOCK]><![endif]--><?php if($critere): ?>
            <tr class="cptRow"
                data-critere="<?php echo e($critere->id); ?>"
                wire:key="row-<?php echo e($critere->id); ?>-sem-<?php echo e($selectedsemestre ?? 'x'); ?>">
                
                <td class="px-4 py-3 border border-black font-bold"><?php echo e($competence->nom ?? '-'); ?></td>

                
                <td class="px-4 py-3 border border-black"><?php echo e($critere->libelle ?? '-'); ?></td>

                
                <td class="px-4 py-3 border border-black text-center">
                    <input type="number" min="0" max="20" step="0.5"
                           class="noteCritere border border-gray-300 p-1 w-full text-center"
                           value="<?php echo e($evaluationData[$critere->id]['note'] ?? ''); ?>">
                </td>

                
                <td class="px-4 py-3 border border-black text-center">
                    <input type="date"
                           class="critereDate border border-gray-300 p-1 w-full"
                           value="<?php echo e($evaluationData[$critere->id]['date'] ?? ''); ?>">
                </td>
            </tr>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    <?php else: ?>
        <tr>
            <td colspan="4" class="px-4 py-4 font-bold text-center">Aucune donnée disponible</td>
        </tr>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</tbody>








                        </table>
                        <!--[if BLOCK]><![endif]--><?php if($count > 2): ?>
                            <div class="flex justify-start items-center mt-5">
                                <button <?php echo e($startLimit == 0 ? 'disabled' : ''); ?> wire:click="prev" type="button" class="bg-white px-4 rounded-md border-white py-3 flex text-black text-sm text-center shadow-lg items-center">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="11" height="14" viewBox="0 0 11 14" fill="none">
                                        <path id="Polygon 1" d="M0.982423 8.69351C-0.0296571 7.89277 -0.0296574 6.35734 0.982422 5.55659L7.00906 0.788418C8.32029 -0.249004 10.25 0.684883 10.25 2.35688V11.8932C10.25 13.5652 8.32029 14.4991 7.00906 13.4617L0.982423 8.69351Z" fill="black"/>
                                    </svg>
                                </button>
                                <span class="text-md text-black mx-3"><?php echo e(min($count,$startLimit+1)); ?> à <?php echo e(min($startLimit+2,$count)); ?> sur <?php echo e($count); ?></span>
                                <button wire:click="next" <?php echo e(($startLimit+2) >= $count ? 'disabled' : ''); ?> type="button" class="bg-white px-4 rounded-md border-white py-3 flex text-black text-sm text-center shadow-lg items-center">
                                    <svg class="w-4 h-4" width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path id="Polygon 1" d="M10.0176 5.55649C11.0297 6.35723 11.0297 7.89266 10.0176 8.69341L3.99094 13.4616C2.67971 14.499 0.75 13.5651 0.75 11.8931L0.75 2.35677C0.75 0.684774 2.67971 -0.249114 3.99094 0.788308L10.0176 5.55649Z" fill="black"/>
                                    </svg>
                                </button>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Main modal -->
                    <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        Situation de compétence : [<?php echo e($currentApprenant->apprenant->matricule); ?>] <?php echo e($currentApprenant->apprenant->nom); ?> <?php echo e($currentApprenant->apprenant->prenom); ?>

                                    </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Fermer</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-4 md:p-5 space-y-4 relative overflow-x-auto">
                                    <table class="w-full mb-3">
                                        <thead>
                                            <tr
                                                class="text-xs font-black tracking-wide text-left text-maquette-black font-bold uppercase border-b bg-sp-green">
                                                <th class="p-2 border border-black text-center text-black text-lg">Compétence</th>
                                               
                                                <th class="p-2 border border-black text-center text-black text-lg">Seuil de réussite</th>
                                                <th class="p-2 border border-black text-center text-black text-lg">Note</th>
                                            
                                                <th class="p-2 border border-black text-center text-black text-lg"><abbr title="Date Evaluation">Date Eva</abbr></th>
                                               
                                            </tr>
                                        </thead>
   <tbody class="bg-white divide-y">
    <!--[if BLOCK]><![endif]--><?php if($competences && $competences->count() > 0): ?>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $competences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competence): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $critere = null;
                foreach ($competence->criteres as $c) {
                    if ($c) {
                        $critere = $c;
                        break;
                    }
                }
            ?>

            <!--[if BLOCK]><![endif]--><?php if($critere): ?>
            <tr class="cptRow"
                data-critere="<?php echo e($critere->id); ?>"
                wire:key="row-<?php echo e($critere->id); ?>-sem-<?php echo e($selectedsemestre ?? 'x'); ?>">
                
                <td class="px-4 py-3 border border-black font-bold"><?php echo e($competence->nom ?? '-'); ?></td>

                
                <td class="px-4 py-3 border border-black"><?php echo e($critere->libelle ?? '-'); ?></td>

                
                <td class="px-4 py-3 border border-black text-center">
                    <input type="number" min="0" max="20" step="0.5"
                           class="noteCritere border border-gray-300 p-1 w-full text-center"
                           value="<?php echo e($evaluationData[$critere->id]['note'] ?? ''); ?>">
                </td>

                
                <td class="px-4 py-3 border border-black text-center">
                    <input type="date"
                           class="critereDate border border-gray-300 p-1 w-full"
                           value="<?php echo e($evaluationData[$critere->id]['date'] ?? ''); ?>">
                </td>
            </tr>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    <?php else: ?>
        <tr>
            <td colspan="4" class="px-4 py-4 font-bold text-center">Aucune donnée disponible</td>
        </tr>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</tbody>

                                    </table>
                                </div>
                                <!-- Modal footer -->
                                <div class="flex items-center p-4 md:p-5 rounded-b dark:border-gray-600">
                                    <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 text-sm font-medium text-white bg-red-600 rounded-lg border border-gray-200 ">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            <?php else: ?>
                <div class="sm:w-1/2 p-4 border bg-gray-100 rounded border shadow" >
                        <div class="text-center py-4 px-4"><span class="text-red-600 text-lg">Aucun apprenant sélectionné !</span></div>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php else: ?>
        <div class="alert bg-orange-100 flex p-4 rounded mt-4 p-10 m-10 justify-center items-center">
            <h3 class="text-2xl">Veuiller sélectionner une classe  et une année académique !</h3>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>

</div>
    
</div>

<?php /**PATH /Applications/MAMP/htdocs/PGI-1/resources/views/livewire/param/classe-switch.blade.php ENDPATH**/ ?>