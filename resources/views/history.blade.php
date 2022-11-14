@extends('layouts.simple.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Histories</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection


@section('content')
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
@endsection


@section('script')
    <script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script>
    <script type="text/javascript">

    function deleteFuncHistory(id){
        
            if (confirm("Voulez-vous vraiment le supprimer?") == true) {
                var id = id;
                // ajax
                $.ajax({
                    type:"POST",
                    url: "{{ url('/delHistory/') }}",
                    data: { id:id, _token: '{{csrf_token()}}' },
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
                    ajax: "{{ url('/history') }}",
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
@endsection