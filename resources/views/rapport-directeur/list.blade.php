@extends('layouts.simple.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">
@endsection

@section('style')

@endsection

@section('breadcrumb-title')
    <h3>Dashboard</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="container-fluid">
        @include('flash-message')
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <form  method="POST" action="{{ route('rapport.export') }}">
                        @csrf
                        <div class="form-group">
                            <label class="radio-inline">
                                <input type="radio" name="optradio" value="day" checked> Day
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="optradio" value="range" > A - B
                            </label>
                        </div>
                        <div class="dispform">
                            <div class="col-md-4 margin-div-dir">
                                
                                <div class="form-group">
                                    <label class="col-form-label pt-0">Date</label>
                                    <input class="datepicker-here form-control digits height-range range_picker d-none" autocomplete="off" name="search_id_date" type="text" data-range="true" placeholder="Veuillez sélectionner un interval de temps" data-multiple-dates-separator=" - " data-language="en">
                                    <input class="datepicker-here form-control digits height-range day_picker" autocomplete="off" name="search_id_date" type="text" data-range="false"  placeholder="Veuillez sélectionner un interval de temps" data-language="en">
                                </div>
                            </div>
                            <div class="col-md-4 mr-4 margin-div-dir">
                                <div class="form-group">
                                    <label class="col-form-label pt-0">Agent</label>
                                    <select name="search_id_agent" id="search_id_agent" class="form-control js-example-basic-single col-sm-12">
                                        <option value="">Tous les agents</option>
                                        @foreach (\App\Models\Agent::all() as $key => $agent)
                                            <option value="{{ $agent->id }}">
                                                {{ $agent->name }}   {{ $agent->prenom }}
                                            </option>
                                        @endforeach
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
                        <div class="offset-md-8 col-md-4" style="text-align: right">
                            <div class="form-group">
                                <button type="submit" class="btn-block-option btn btn-primary" data-toggle="block-option"
                                   data-action="state_toggle" data-action-mode="demo">
                                    Exporter les données
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
                    <div class="card-body" id="emplacement_table">
                        <div class="table-responsive" id="show_table">
                            <table class="display" id="ajax-crud-directeur" >
                                <thead>
                                <tr>
                                    <!-- <th>Id</th> -->
                                    <th>Date</th>
                                    <th>Agent</th>
                                    <th>Nbres de TF impactés par les inscriptions</th>
                                    <th>Nbres d'inscriptions</th>
                                    <th>Nbres de TF</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>TOTAL</th>
                                    <!-- <th></th> -->
                                    <th></th>
                                    <th id="nbre_tf_impactes"></th>
                                    <th id="total_nbre_inscription"></th>
                                    <th id="total_nbre_tf_crees"></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

        jQuery(function ($){


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
             var table =  $('#ajax-crud-directeur').DataTable({
                     fixedHeader: {
                         header: true,
                         footer: true
                    },
                    processing: true,
                    serverSide: true,
                    iDisplayLength: 25,
                    ajax: {
                        'type': 'POST',
                        'url': '{{ url('/dashboard') }}',
                        'data' : function ( d ) {
                        return $.extend( {}, d, {
                            "_token" : "{{ csrf_token() }}",
                            "optradio":$("input[name='optradio']:checked").val(),
                            "id_agent" :$("#search_id_agent").val(),
                            "date" : $("input[name='optradio']:checked").val() == "day" ? $(".day_picker").val() :$(".range_picker").val()
                        });
                      }
                    },
                    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {       
                        if (aData["is_matched"] == 0 ){
                            $('td', nRow).css('background-color', '#dc3545');
                            $('td', nRow).css('color', '#fff');
                        }
                    },
                    columns: [
                        // {data: 'id', name: 'id'},
                        {data: 'date', name: 'date'},
                        {data: 'name', name: 'nomcomplet'},
                        {data: 'nbre_tf_impactes', name: 'nbre_tf_impactes', className:'total_nbre_tf_impactes'},
                        {data: 'nbre_inscription', name: 'nbre_inscription', className:'total_nbre_inscription'},
                        {data: 'nbre_tf_crees', name: 'nbre_tf_crees', className:'total_nbre_tf_crees'},
                    ],
                    order: [[0, 'desc']]
                });

                table.on('draw', function () {

                    setTimeout(function() {

                        var somme1 = 0;
                        $("#nbre_tf_impactes").text(somme1);
                        $('#ajax-crud-directeur').find('tr').each(function(index) {

                            if(parseInt( $(this).find('.total_nbre_tf_impactes').text() )){
                                somme1 = somme1 + parseInt( $(this).find('.total_nbre_tf_impactes').text() );
                            }

                        });
                        // console.log("Hello => {{$total->nbre_tf_impactes}}");

                        $("#nbre_tf_impactes").text(somme1);

                        var somme2 = 0;
                        $("#total_nbre_inscription").text(somme2);
                        $('#ajax-crud-directeur').find('tr').each(function(index) {

                            if(parseInt( $(this).find('.total_nbre_inscription').text() )){
                                somme2 = somme2 + parseInt( $(this).find('.total_nbre_inscription').text() );
                            }

                        });

                        $("#total_nbre_inscription").text(somme2);

                        var somme3 = 0;
                        $("#total_nbre_tf_crees").text(somme3);
                        $('#ajax-crud-directeur').find('tr').each(function(index) {

                            if(parseInt( $(this).find('.total_nbre_tf_crees').text() )){
                                somme3 = somme3 + parseInt( $(this).find('.total_nbre_tf_crees').text() );
                            }

                        });

                        $("#total_nbre_tf_crees").text(somme3);

                    }, 1500);

                });

                $(".day_picker").datepicker();
                $(".range_picker").datepicker({maxDate: new Date() });

                $('body').on('click', '#validform', function () {
                       table.draw();

                    setTimeout(function() {

                        var somme1 = 0;
                    $("#nbre_tf_impactes").text(somme1);
                    $('#ajax-crud-directeur').find('tr').each(function(index) {

                        if(parseInt( $(this).find('.total_nbre_tf_impactes').text() )){
                            somme1 = somme1 + parseInt( $(this).find('.total_nbre_tf_impactes').text() );
                        }

                    });
                    $("#nbre_tf_impactes").text(somme1);


                    var somme2 = 0;
                    $("#total_nbre_inscription").text(somme2);
                    $('#ajax-crud-directeur').find('tr').each(function(index) {

                        if(parseInt( $(this).find('.total_nbre_inscription').text() )){
                            somme2 = somme2 + parseInt( $(this).find('.total_nbre_inscription').text() );
                        }

                    });
                    $("#total_nbre_inscription").text(somme2);

                    var somme3 = 0;
                    $("#total_nbre_tf_crees").text(somme3);
                    $('#ajax-crud-directeur').find('tr').each(function(index) {

                        if(parseInt( $(this).find('.total_nbre_tf_crees').text() )){
                            somme3 = somme3 + parseInt( $(this).find('.total_nbre_tf_crees').text() );
                        }

                    });
                    $("#total_nbre_tf_crees").text(somme3);


                    }, 1500);
                });



                $('body').on('click', '#export_exel', function (event) {
                    event.preventDefault();
                    var id_agent_export = $("#search_id_agent").val();
                    var date_export = $("input[name='optradio']:checked").val() == "day" ? $(".day_picker").val() :$(".range_picker").val()
                    // ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/export') }}",
                        data: {
                            id_agent_export: id_agent_export,
                            optradio:$("input[name='optradio']:checked").val(),
                            date_export: date_export,
                            _token: '{{csrf_token()}}' },
                        success: function (data) {

                        }
                    });

                });

            });


            $('input[type=radio]').change(function() {                
                if ( this.value == "day") {
                    $('.day_picker').removeClass('d-none');
                    $('.range_picker').addClass('d-none');                    
                }else {
                    $('.day_picker').addClass('d-none');
                    $('.range_picker').removeClass('d-none');  
                }
            });

        });
    </script>
@endsection