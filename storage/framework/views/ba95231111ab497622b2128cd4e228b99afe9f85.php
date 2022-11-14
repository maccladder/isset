<form id="delete-form" method="POST" action="/delHistory/1">
    <?php echo e(csrf_field()); ?>

    <?php echo e(method_field('DELETE')); ?>


    <div class="form-group">
      <input type="submit" class="btn btn-danger" value="Delete">
    </div>
</form><?php /**PATH D:\Project\laravel+Tessaract\github\isset\resources\views/history_del.blade.php ENDPATH**/ ?>