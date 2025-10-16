<div class="container mx-auto px-4 py-8 max-w-7xl">
  
  <div class="mb-8 text-center">
    <h1 class="text-4xl font-bold text-[#1A4085] mb-3">Annuaire des Établissements</h1>
    <p class="text-[#64748B] text-lg max-w-2xl mx-auto">
      Recherchez et filtrez les établissements d'enseignement selon la région, le département ou la commune
    </p>
  </div>

  
  <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-6">
      <div class="relative flex-1 max-w-2xl">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg class="h-5 w-5 text-[#FF6B35]" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
          </svg>
        </div>
        <input
          type="text"
          wire:model.live.debounce.300ms="search"
          placeholder="Rechercher un établissement par nom, email..."
          class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF6B35] focus:border-[#FF6B35] transition-colors duration-200"
          aria-label="Rechercher un établissement"
        >
      </div>

      <div class="bg-[#FFF5F0] rounded-lg px-5 py-3 flex items-center">
        <i class="fas fa-school text-[#FF6B35] text-lg mr-2"></i>
        <span class="text-[#FF6B35] font-semibold"><?php echo e($count); ?> établissement(s) trouvé(s)</span>
      </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
      <div>
        <label for="selectRegion" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
          <i class="fas fa-map-marked-alt text-[#FF6B35] mr-2"></i>Région
        </label>
        <select
          id="selectRegion"
          wire:model.live="selectedRegion"
          class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-[#FF6B35] focus:border-[#FF6B35] text-sm font-medium text-gray-900"
        >
          <option value="">Toutes les régions</option>
          <!--[if BLOCK]><![endif]--><?php if($regions): ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($region->id); ?>"><?php echo e($region->libelle); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
          <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </select>
      </div>

      <div>
        <label for="selectDepartement" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
          <i class="fas fa-map-marker-alt text-[#FF6B35] mr-2"></i>Département
        </label>
        <select
          id="selectDepartement"
          wire:model.live="selectedDepartement"
          <?php if(!$selectedRegion): echo 'disabled'; endif; ?>
          class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-[#FF6B35] focus:border-[#FF6B35] text-sm font-medium text-gray-900 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <option value="">Tous les départements</option>
          <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($departement->id); ?>"><?php echo e($departement->libelle); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
      </div>

      <div>
        <label for="selectCommune" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
          <i class="fas fa-location-dot text-[#FF6B35] mr-2"></i>Commune
        </label>
        <select
          id="selectCommune"
          wire:model.live="selectedCommune"
          <?php if(!$selectedDepartement): echo 'disabled'; endif; ?>
          class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-[#FF6B35] focus:border-[#FF6B35] text-sm font-medium text-gray-900 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <option value="">Toutes les communes</option>
          <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $communes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commune): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($commune->id); ?>"><?php echo e($commune->libelle); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
      </div>
    </div>
  </div>

  
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $etablissements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etablissement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="bg-white rounded-xl overflow-hidden shadow-md transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
        <div class="p-6">
          <div class="flex justify-between items-start mb-5">
            <div class="w-[60px] h-[60px] flex items-center justify-center bg-[#FFF5F0] rounded-[12px] text-[#FF6B35] text-2xl">
              <i class="fas fa-university"></i>
            </div>
            <span class="flex items-center <?php echo e($etablissement->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?> text-xs font-medium px-3 py-1.5 rounded-full">
              <i class="fas fa-circle text-xs mr-1.5 <?php echo e($etablissement->is_active ? 'text-green-500' : 'text-red-500'); ?>"></i>
              <?php echo e($etablissement->is_active ? 'Actif' : 'Inactif'); ?>

            </span>
          </div>

          <h2 class="text-xl font-bold text-[#1A4085] mb-4 truncate"><?php echo e($etablissement->nom); ?></h2>

          <div class="space-y-3 mb-5">
            <div class="flex items-center text-sm text-[#64748B]">
              <i class="fas fa-map-marker-alt text-[#FF6B35] mr-3 w-5"></i>
              <span class="truncate">
                <?php echo e($etablissement->commune->libelle ?? '-'); ?>,
                <?php echo e($etablissement->commune->departement->region->libelle ?? '-'); ?>

              </span>
            </div>

            <div class="flex items-center text-sm text-[#64748B]">
              <i class="fas fa-tag text-[#FF6B35] mr-3 w-5"></i>
              <span><?php echo e($etablissement->statut ?? '-'); ?></span>
            </div>

            <div class="flex items-center text-sm text-[#64748B]">
              <i class="fas fa-envelope text-[#FF6B35] mr-3 w-5"></i>
              <span class="truncate"><?php echo e($etablissement->email ?? '-'); ?></span>
            </div>

            <div class="flex items-center text-sm text-[#64748B]">
              <i class="fas fa-phone text-[#FF6B35] mr-3 w-5"></i>
              <span><?php echo e($etablissement->telephone ?? 'Non renseigné'); ?></span>
            </div>
          </div>

          <div class="pt-4 border-t border-gray-100 flex justify-between">
            <a href="#" class="text-[#FF6B35] hover:text-[#E85A2A] font-medium text-sm flex items-center transition-colors">
              <i class="fas fa-info-circle mr-2"></i>
              Détails
            </a>
            <a href="#" class="text-[#1A4085] hover:text-[#FF6B35] font-medium text-sm flex items-center transition-colors">
              <i class="fas fa-external-link-alt mr-2"></i>
              Site web
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="col-span-full py-16 text-center">
        <div class="inline-flex items-center justify-center rounded-full bg-[#FFF5F0] p-5 mb-5">
          <i class="fas fa-school text-4xl text-[#FF6B35]"></i>
        </div>
        <h3 class="text-2xl font-semibold text-gray-800 mb-3">Aucun établissement trouvé</h3>
        <p class="text-[#64748B] text-lg max-w-xl mx-auto">
          Essayez de modifier vos critères de recherche ou de filtrage pour afficher plus de résultats
        </p>
      </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
  </div>

  
  <!--[if BLOCK]><![endif]--><?php if($count > 12): ?>
    <div class="flex flex-col sm:flex-row items-center justify-between bg-white rounded-xl shadow-sm px-6 py-5 gap-4">
      <div class="text-sm text-[#64748B]">
        Affichage de
        <span class="font-medium"><?php echo e(min($count, $startLimit + 1)); ?></span>
        à
        <span class="font-medium"><?php echo e(min($startLimit + 12, $count)); ?></span>
        sur
        <span class="font-medium"><?php echo e($count); ?></span> résultats
      </div>

      <div class="flex space-x-3">
        <button
          type="button"
          wire:click="prev"
          <?php if($startLimit == 0): echo 'disabled'; endif; ?>
          class="inline-flex items-center px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#FF6B35] transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
          aria-label="Page précédente"
        >
          <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
          </svg>
          Précédent
        </button>

        <button
          type="button"
          wire:click="next"
          <?php if(($startLimit + 12) >= $count): echo 'disabled'; endif; ?>
          class="inline-flex items-center px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#FF6B35] transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
          aria-label="Page suivante"
        >
          Suivant
          <svg class="h-5 w-5 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
          </svg>
        </button>
      </div>
    </div>
  <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/etablissements/front-liste-etablissement.blade.php ENDPATH**/ ?>