

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/datatables.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/select2.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/date-picker.css')); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
    <h3>Histories</h3>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-items'); ?>
    <li class="breadcrumb-item active">Dashboard</li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="ajax-crud-rapport" >
                                <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Log</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/js/datatable/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/datatable/datatables/datatable.custom.js')); ?>"></script>
    <script type="text/javascript">

    function deleteFuncHistory(id){
        
            if (confirm("Voulez-vous vraiment le supprimer?") == true) {
                var id = id;
                // ajax
                $.ajax({
                    type:"POST",
                    url: "<?php echo e(url('/delHistory/')); ?>",
                    data: { id:id, _token: '<?php echo e(csrf_token()); ?>' },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#ajax-crud-rapport').dataTable();
                        oTable.fnDraw(false);
                    }
                });
                }
             }

        jQuery(function ($){
            
            const types = ['fa fa-plus', 'fa fa-pencil', 'fa fa-minus'];
            const colors = ['green', 'orange', 'red'];

            $(document).ready( function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                console.log('call datatable');
                $.fn.dataTable.ext.errMode = 'none';
                var table =  $('#ajax-crud-rapport').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "<?php echo e(url('/history')); ?>",
                    columns: [
                        {data: 'type', name: 'type'},
                        {data: 'log', name: 'log'},
                        {data: 'action', name: 'action', orderable: false},
                    ],
                    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {   
                        $(nRow).find('td:eq(0)').css('color', colors[aData["type"]]);
                        $(nRow).find('td:eq(0)').html("<i class='"+types[aData["type"]]+"'></i>")
                    },
                    order: [[0, 'desc']]
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.simple.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project\laravel+Tessaract\github\isset\resources\views/history.blade.php ENDPATH**/ ?>