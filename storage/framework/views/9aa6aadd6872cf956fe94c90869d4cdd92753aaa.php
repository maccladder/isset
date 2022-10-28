

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/datatables.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/select2.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/date-picker.css')); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
<div class="page-notificaton"><h1 style="text-align: center"> PAS DE NOTIFICATION </h1></div>
<div class="retour" style="text-align: center">
</button><h3 style="mt-10"><a type="button" class="btn-info" href="<?php echo e(route('rapport')); ?>">Retour aux rapports </a></h3>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.simple.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Projet-Isset\isset\resources\views/notification.blade.php ENDPATH**/ ?>