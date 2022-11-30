@extends('layouts.simple.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Comptabilisation des totaux du LIFE</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Comptabilisation des totaux du LIFE</li>
@endsection

@section('content')
<div class="container-fluid">
        @include('flash-message')
        <div id="afficher_details_rapport">
            @include("rapport.details")
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                    <div class="form-group">
                        
                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <!-- Form -->
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type='file' id="file" name='file' class="form-control">
                                        <!-- Response message -->
                                        <div class="alert-danger d-none mt-2" id="responseMsg"></div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <input type="button" id="submit" value='Submit' class='btn btn-success'>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="ajax-crud-rapport" >
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Nbres de TF impactés par les inscriptions</th>
                                    <th>Nbres d'inscriptions</th>
                                    <th>Nbres de TF</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- <div class="page-notificaton"><h1 style="text-align: center"> PAS DE NOTIFICATION </h1></div>
<div class="retour" style="text-align: center">
</button><h3 style="mt-10"><a type="button" class="btn-info" href="{{route('rapport')}}">Retour aux rapports </a></h3>
</div> -->

@endsection

@section('script')
    <script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script>
    <script src="{{asset('assets/js/datepicker/date-picker/datepicker.js')}}"></script>
    <script src="{{asset('assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
    <script src="{{asset('assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>
    <script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
    <script type="text/javascript">


        // function deleteFuncRapport(id){
        //     if (confirm("Voulez-vous vraiment le supprimer?") == true) {
        //         var id = id;
        //         // ajax
        //         $.ajax({
        //             type:"POST",
        //             url: "{{ url('/rapports/supprimer-rapport') }}",
        //             data: { id: id,_token: '{{csrf_token()}}' },
        //             dataType: 'json',
        //             success: function(res){
        //                 var oTable = $('#ajax-crud-rapport').dataTable();
        //                 oTable.fnDraw(false);

        //                 window.location.reload();
        //             }
        //         });
        //         }
        //      }

        jQuery(function ($){

            $(document).ready( function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.fn.dataTable.ext.errMode = 'none';
                var table =  $('#ajax-crud-rapport').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ url('/total') }}",
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'time', name: 'date'},
                        {data: 'nbre_tf_impactes', name: 'nbre_tf_impactes'},
                        {data: 'nbre_inscription', name: 'nbre_inscription'},
                        {data: 'nbre_tf_crees', name: 'nbre_tf_crees'},
                    ],
                    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {       
                        if (aData["nbre_tf_impactes"] != "{{$nbre_tf_impactes}}" )
                            $('td', nRow).addClass('bg-danger');
                        
                        if (aData["nbre_inscription"] != "{{$nbre_inscription}}" )
                            $('td', nRow).addClass('bg-danger');
                        
                        if (aData["nbre_tf_crees"] != "{{$nbre_tf_crees}}" )
                            $('td', nRow).addClass('bg-danger');
                    },
                    order: [[0, 'desc']]
                });

                // $("#datepicker").datepicker({maxDate: new Date() });

                $('#submit').click(function(){
                    var files = $('#file')[0].files;
                    if(files.length > 0){
                        var fd = new FormData();

                        fd.append('file',files[0]);
                        fd.append('_token','{{csrf_token()}}');

                        $.ajax({
                            url: "{{route('uploadFile')}}",
                            method: 'post',
                            data: fd,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response){
                                if(response.success == 1){ 
                                    $('#responseMsg').removeClass("alert-danger");
                                    $('#responseMsg').addClass("alert-success");
                                    $('#responseMsg').html(response.message);
                                    $('#responseMsg').removeClass('d-none');
                                }else { // File not uploaded
                                    // Response message
                                    $('#responseMsg').html(response.message); 
                                    $('#responseMsg').removeClass('d-none');
                                }

                                window.location.reload();
                            },
                            error: function(response){
                                $('#responseMsg').html(response.error);
                                $('#responseMsg').removeClass('d-none');
                                // console.log("error : " + JSON.stringify(response) );
                            }
                        });
                    }else {
                        $('#responseMsg').html(" Please choose file what you want to upload");
                        $('#responseMsg').removeClass('d-none');
                    }
                });



                // $('body').on('click', '#open_detail_rapport', function (event) {
                    // event.preventDefault();
                    // var id = $(this).data('id');
                    // var id = id;
                    // // ajax
                    // $.ajax({
                    //     type: "POST",
                    //     url: "{{ url('/rapports/details') }}",
                    //     data: {id: id,_token: '{{csrf_token()}}' },
                    //     success: function (data) {
                    //         $('#afficher_details_rapport').html(data);
                    //         $('#detail_modal_rapport').modal('show');

                    //     }
                    // });
                // });
            });
        });
    </script>
@endsection