<?php $__currentLoopData = $inscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    
    <?php echo $__env->make('pdf.bulletin', ['inscription' => $inscription], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <?php if(!$loop->last): ?>
        <div style="page-break-after: always;"></div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /Applications/MAMP/htdocs/PGI-1/resources/views/pdf/bulletins-classe.blade.php ENDPATH**/ ?>