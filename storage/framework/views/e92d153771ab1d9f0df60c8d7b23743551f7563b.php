
     <div class="card">
        <header class="card-header">
            <p class="card-header-title">CAPTURE D'ECRAN DU RAPPORT DE L'AGENT : <?php echo e($rapport->nomcomplet); ?></p>
        </header>
        <div class="card-content">
            <div class="content">
                <p>Rapport du : <?php echo e(date("d-m-Y", strtotime($rapport->date))); ?></p>
                <p>Enregistré le : <?php echo e(date("h:i d-m-Y", strtotime($rapport->created_at))); ?></p>
                <hr>
                <p><img src="<?php echo e(url('Image/'.$rapport->screenshot)); ?>" style="height: 500px; width: 500px;"></p>
            </div>
        </div>
    </div>

    <a href="<?php echo e(route('rapport')); ?>">Retour aux rapports</a>

   
<?php /**PATH D:\Project\laravel+Tessaract\github\isset\resources\views/screenshot.blade.php ENDPATH**/ ?>