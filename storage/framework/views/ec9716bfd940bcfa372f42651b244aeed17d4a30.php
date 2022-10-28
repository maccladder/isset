
     <div class="card">
        <header class="card-header">
            <p class="card-header-title">CAPTURE D'ECRAN DU RAPPORT DE L'AGENT : <?php echo e($rapport->nomcomplet); ?></p>
        </header>
        <div class="card-content">
            <div class="content">
                <p>Enregistré le : <?php echo e($rapport->created_at); ?></p>
                <hr>
                <p><img src="<?php echo e(url('public/Image/'.$rapport->screenshot)); ?>" style="height: 500px; width: 500px;"></p>
            </div>
        </div>
    </div>

    <a href="<?php echo e(route('rapport')); ?>">Retour aux rapports</a>

   
<?php /**PATH C:\wamp64\www\Projet-Isset\isset\resources\views/screenshot.blade.php ENDPATH**/ ?>