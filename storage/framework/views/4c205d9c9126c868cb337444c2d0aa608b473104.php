
<div class="modal fade" id="detail_modal" tabindex="-1" role="dialog" aria-labelledby="detail_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier informations</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php if(!empty($list_agent)): ?>
                <form  method="POST" action="<?php echo e(route('modifier')); ?>" class="theme-form">
                    <?php echo csrf_field(); ?>
            <div class="modal-body">
                <div class="login-main">
                        <div class="form-group">
                            <label class="col-form-label">Matricule</label>
                            <input type="hidden" value="<?php echo e($list_agent->id); ?>" name="id_agent">
                            <input class="form-control" type="text" value="<?php echo e($list_agent->matricule); ?>" name="matricule">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Nom</label>
                            <input class="form-control" type="text" name="name" value="<?php echo e($list_agent->name); ?>" >
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Prenom</label>
                            <input class="form-control" type="text" name="prenom" value="<?php echo e($list_agent->prenom); ?>">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Fonction</label>
                            <textarea name="fonction" class="col-md-12 form-control" rows="5"><?=$list_agent->fonction?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Email</label>
                            <input class="form-control" type="email" value="<?php echo e($list_agent->email); ?>" name="email">
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                    Modifier
                </button>
            </div>
            <?php endif; ?>
                </form>
        </div>
    </div>
</div>
<?php /**PATH D:\Project\laravel+Tessaract\github\isset\resources\views/agent/details.blade.php ENDPATH**/ ?>