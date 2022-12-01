
     <div class="card">
        <header class="card-header">
        </header>
        <div class="card-content">
            <div class="content">
                <p>Rapport du : <?php echo e(date("d-m-Y", strtotime($total->created_at))); ?></p>
                <p>Enregistré dans ISSET le : <?php echo e(date("d-m-Y", strtotime($total->created_at))); ?> à <?php echo e(date("h:i", strtotime($total->created_at))); ?></p>
                <hr>                
                <p><embed src="<?php echo e(url('Image/'.$total->screenshot.'#page=1')); ?>" type="application/pdf" width="500px" height="500px"></p>
            </div>
        </div>

        
    </div>

    <a href="<?php echo e(route('totals')); ?>">Retour aux rapports</a>

   
<?php /**PATH D:\Project\laravel+Tessaract\github\isset\resources\views/totalscreenshot.blade.php ENDPATH**/ ?>