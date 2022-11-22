

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/datatables.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/select2.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/date-picker.css')); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-title'); ?>
    <h3>Historiques</h3>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb-items'); ?>
    <li class="breadcrumb-item active">Tableau de bord</li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="dispform">
                            <div class="col-md-4 margin-div-dir">
                                <div class="form-group">
                                    <label class="col-form-label pt-0">Date</label>
                                    <input class="datepicker-here form-control digits height-range" autocomplete="off" name="search_id_date" id="search_id_date" type="text" data-range="true" placeholder="Veuillez sélectionner un interval de temps" data-multiple-dates-separator=" - " data-language="en">
                                </div>
                            </div>
                            <div class="col-md-4 mr-4 margin-div-dir">
                                <div class="form-group">
                                    <label class="col-form-label pt-0">Type</label>
                                    <select name="search_id_agent" id="search_id_agent" class="form-control js-example-basic-single col-sm-12">
                                        <option value="">Tous les types</option>
                                        <option value="0">Création de nouveau rapport</option>
                                        <option value="1">Modification de rapport</option>
                                        <option value="2">Suppression de rapport</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="button" class="btn-block-option margin-btn-dir btn btn-primary" id="validform" data-toggle="block-option"
                                            data-action="state_toggle" data-action-mode="demo">
                                        Valider
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="ajax-crud-rapport" >
                                <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Nom de l'agent</th>
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
    <script src="<?php echo e(asset('assets/js/datepicker/date-picker/datepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/datepicker/date-picker/datepicker.en.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/datepicker/date-picker/datepicker.custom.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/select2/select2.full.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/select2/select2-custom.js')); ?>"></script>
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

                setTimeout(function() {
                    $('#validform').trigger('click');
                }, 2000);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.fn.dataTable.ext.errMode = 'none';
                var table =  $('#ajax-crud-rapport').DataTable({
                    processing: true,
                    serverSide: true,
                    // ajax: "<?php echo e(url('/history')); ?>",
                    ajax: {
                        'type': 'GET',
                        'url': "<?php echo e(url('/history')); ?>",
                        'data' : function ( d ) {
                        return $.extend( {}, d, {
                            "_token" : "<?php echo e(csrf_token()); ?>",
                            "id_agent" :$("#search_id_agent").val(),
                            "date" : $("#search_id_date").val()
                        });
                      }
                    },
                    columns: [
                        {data: 'type', name: 'type'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'name', name: 'name'},
                        {data: 'log', name: 'log'},
                        {data: 'action', name: 'action', orderable: false},
                    ],
                    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {   
                        $(nRow).find('td:eq(0)').css('color', colors[aData["type"]]);
                        $(nRow).find('td:eq(0)').html("<i class='"+types[aData["type"]]+"'></i>")

                        $(nRow).find('td:eq(1)').html(new Date(aData["created_at"]).toLocaleDateString());
                    },
                    order: [[0, 'desc']]
                });

                $("#search_id_date").datepicker({maxDate: new Date() });
                $('body').on('click', '#validform', function () {
                    table.draw();
                    setTimeout(function() {
                    }, 1500);
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.simple.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project\laravel+Tessaract\github\isset\resources\views/history.blade.php ENDPATH**/ ?>