<div>

    <div class="w-full mr-4 border bg-gray-100 border-1 shadow p-2 rounded bg-light">
        <div class="flex w-1/5 items-center      p-2 my-2 bg-white rounded-md dark:bg-darker">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                </svg>
                
              </div>
              <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Etablissement
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    <span class="siffre" style="color:rgba(227, 142, 24, 1);"><?php echo e($count); ?></span>&thinsp;&thinsp; &thinsp; &thinsp; <span class="prctg" style="font-size: 10px;">
      
                  </p>           
              </div>
            
        </div>
        <div class="w-1/6 flex items-center">
            <p wire:click="resetAll" wire:change="$refresh" class="border-2 flex items-center font-bold bg-first-orange rounded py-1 px-3 text-sm cursor-pointer text-white">Tous</p>
        </div>
        <div class="flex justify-between items-center bg-gray-100">
            
            <div class="flex items-baseline my-2 w-full">
                <label for="selectedRegion" class="sr-only">Région</label>
                <select id="selectedRegion" wire:model="selectedRegion" wire:change="$refresh" name="selectedRegion"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir une Région</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($region->id ??''); ?>"><?php echo e($region->libelle ?? ''); ?></option> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>

            </div>
            <div class="flex items-baseline my-2 w-full">
                <label for="selectedCommune" class="sr-only">Départemant</label>
                <select id="selectedDepartemant" wire:model="selectedDepartemant" wire:change="$refresh" name="selectedDepartemant"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir un Départemant</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($departement->id); ?>"><?php echo e($departement->libelle ?? ''); ?></option> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>

            </div>
            <div class="flex items-baseline my-2 w-full">
                <label for="selectedCommune" class="sr-only">Commune</label>
                <select id="selectedCommune" wire:model="selectedCommune" wire:change="$refresh" name="selectedCommune"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir une Commune</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $communes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commune): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($commune->id); ?>"><?php echo e($commune->libelle); ?></option> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>

            </div>
            
            
        </div>

        <div class="flex justify-between items-center">
            <div class="flex items-baseline my-2 w-full">
                
                <label for="selectedIA" class="sr-only">IA</label>
                <select id="selectedIA" wire:model="selectedIA" wire:change="$refresh" name="selectedIA"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir une IA</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $ias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($ia->id); ?>"><?php echo e($ia->nom); ?></option>                     
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>

            </div> 
            

            
            <div class="flex items-baseline my-2 w-full">
                <label for="selectedIef" class="sr-only">IEF</label>
                <select id="selectedIef" wire:model="selectedIef" wire:change="$refresh" name="selectedIef"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir une IEF</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $iefs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ief): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($ief->id); ?>"><?php echo e($ief->nom); ?></option> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>

            </div>
            <div class="flex items-baseline my-2 w-full">
               
            </div>
        </div>
        <div class="flex justify-between items-center">
            <div class="flex items-baseline my-2 w-full">
                <label for="selectedNiveau" class="sr-only">Niveaux</label>
                <select id="selectedNiveau" wire:model="selectedNiveau" wire:change="$refresh" name="selectedNiveau"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir une Niveaux</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $niveaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $niveau): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($niveau->id); ?>"><?php echo e($niveau->nom); ?></option> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>

            </div>

            <div class=" flex items-baseline my-2 w-full">
                <label for="selectedClasse" class="sr-only">Classe</label>
                <select id="selectedClasse" wire:model="selectedClasse" wire:change="$refresh" name="selectedClasse"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir une Classe</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($classe->id); ?>"><?php echo e($classe->libelle); ?></option> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>

            </div>
            <div class="flex items-baseline my-2 w-full">
                <label for="selectedFiliere" class="sr-only">Filiere</label>
                <select id="selectedFiliere" wire:model="selectedFiliere" wire:change="$refresh" name="selectedFiliere"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir une filiere</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $filieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($filiere->id); ?>"><?php echo e($filiere->nom); ?></option> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>

            </div>
        </div>
        
        <div class="p-2 w-full bg-white">
            <table class="w-full mb-3">
                <thead>
                    <tr
                        class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold border-b">
                        
                        <th class="px-1 text-gray-800">Nom</th>
                        <th class="px-1 text-gray-800">Email</th>
                        <th class="px-1 text-gray-800">Commune</th>
                        <th class="px-1 text-gray-800">type</th>
                        <th class="px-1 text-gray-800">Réference</th>
                        
                    </tr>
                </thead>
                <tbody class="bg-white divide-y ">
                        <tr class="text-gray-700 ">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $etablissements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etablissement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <td class="p-2 border-b text-gray-500 ">
                                <?php echo e($etablissement->nom ?? ' - '); ?>

                            </td>
                            <td class="p-2 border-b text-gray-500 ">
                                <?php echo e($etablissement->email ?? ' - '); ?>

                            </td>
                            <td class="p-2 border-b text-gray-500 ">
                                <?php echo e($etablissement->nameCommune ?? ' - '); ?>

                            </td>
                            
                            <td class="p-2 border-b text-gray-500 ">
                                <?php echo e($etablissement->type ?? ' - '); ?>

                            </td>
                            <td class="p-2 border-b text-gray-500 ">
                                
                                <?php echo e($etablissement->dateAutOuv ?? ' - '); ?>

                            </td>
                            
                            

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    
                </tbody>
            </table>
        </div>
        
    </div>
    <?php echo e($etablissements->links()); ?>

</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/dfpt/getalletablissement.blade.php ENDPATH**/ ?>