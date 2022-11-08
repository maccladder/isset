@extends('layouts.simple.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Notifications</h3>
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
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="ajax-crud-rapport" >
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Agent</th>
                                    <th>Nbres de TF impactés par les inscriptions</th>
                                    <th>Nbres d'inscriptions</th>
                                    <th>Nbres de TF</th>
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


        function deleteFuncRapport(id){
            if (confirm("Voulez-vous vraiment le supprimer?") == true) {
                var id = id;
                // ajax
                $.ajax({
                    type:"POST",
                    url: "{{ url('/rapports/supprimer-rapport') }}",
                    data: { id: id,_token: '{{csrf_token()}}' },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#ajax-crud-rapport').dataTable();
                        oTable.fnDraw(false);

                        window.location.reload();
                    }
                });
                }
             }

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
                    ajax: "{{ url('/notifications') }}",
                    columns: [

                        {data: 'id', name: 'id'},
                        {data: 'date', name: 'date'},
                        {data: 'nomcomplet', name: 'nomcomplet'},
                        {data: 'nbre_tf_impactes', name: 'nbre_tf_impactes'},
                        {data: 'nbre_inscription', name: 'nbre_inscription'},
                        {data: 'nbre_tf_crees', name: 'nbre_tf_crees'},
                        {data: 'action', name: 'action', orderable: false},
                    ],
                    // "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {       
                    //     if (aData["is_matched"] == 0 )
                    //         $('td', nRow).css('background-color', '#aa5588');
                    // },
                    order: [[0, 'desc']]
                });

                $("#datepicker").datepicker({maxDate: new Date() });

                $('body').on('click', '#open_detail_rapport', function (event) {
                    event.preventDefault();
                    var id = $(this).data('id');
                    var id = id;
                    // ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/rapports/details') }}",
                        data: {id: id,_token: '{{csrf_token()}}' },
                        success: function (data) {
                            $('#afficher_details_rapport').html(data);
                            $('#detail_modal_rapport').modal('show');

                        }
                    });

                });
            });
        });
    </script>
@endsection