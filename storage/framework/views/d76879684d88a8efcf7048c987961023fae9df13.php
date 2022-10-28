<!DOCTYPE html>
<html>
    <head>
        <title>Google Cloud Vision OCR</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="row mt-3">
                <form method="post" action="<?php echo e(route('submitOCR')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="image" class="form-label">Select image:</label>
                        <input type="file" id="image" name="image" class="form-control">
                    </div>
                    <button type="submit" class="btn btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </body>
</html><?php /**PATH C:\wamp64\www\Projet-Isset\isset\resources\views/googleOcr.blade.php ENDPATH**/ ?>