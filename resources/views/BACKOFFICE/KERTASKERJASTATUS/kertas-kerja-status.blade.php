@extends('navbar')

@section('title',__('BO | KERTAS KERJA STATUS'))

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body pt-0">
                        <fieldset class="card border-secondary mt-0">
                            <legend  class="w-auto ml-3">@lang('KK STATUS')</legend>
                            <div class="card-body py-0">
                                <div class="row form-group">
                                    <label class="col-sm-2 text-right col-form-label  text-right pl-0">@lang('Periode Proses')</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-left" id="periode" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-2 col-form-label text-right">@lang('Kode RAK')</label>
                                    <div class="col-sm-3 buttonInside">
                                        <input type="text" class="form-control text-left" id="koderak">
                                        <button id="btn_departement" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovKodeRak()">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-2 text-right col-form-label  text-right pl-0">@lang('Row Storage Besar')</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-left" id="rowstoragebesar">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-2 text-right col-form-label  text-right pl-0">@lang('Row Storage Kecil')</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-left" id="rowstoragekecil">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-10"></div>
                                    <button class="col-sm-2 btn btn-primary" onclick="print()">{{ strtoupper(__('Cetak')) }}</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="modal fade" id="m_koderak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_koderak">
                                    <thead class="thColor">
                                    <tr>
                                        <th>@lang('Kode RAK')</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
            overflow-y: hidden;
        }
        label {
            color: #232443;
            font-weight: bold;
        }
        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .row_lov:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 400px;
            overflow-y: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        .clicked, .row-detail:hover{
            background-color: grey !important;
            color: white;
        }

        .scrollable-field{
            max-height: 200px;
            overflow-y: scroll;
            overflow-x: hidden;
        }
    </style>

    <script>
        var isSubrak = true;
        var plano = [];

        $(document).ready(function(){
            $('#periode').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat : "mm/yy",
            });

            $('#rowstoragebesar').val(130);
            $('#rowstoragekecil').val(80);
        });

        function showLovKodeRak(){
            $('#m_koderak').modal('show');

            if(!$.fn.DataTable.isDataTable('#table_koderak')){
                getLovKodeRak();
            }
        }

        function getLovKodeRak(){
            $('#table_koderak').DataTable({
                "ajax": '{{ url()->current().'/get-lov-kode-rak' }}',
                "columns": [
                    {data: 'koderak', name: 'koderak'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(0)').addClass('text-left');
                    $(row).addClass('row-koderak').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $(document).on('click', '.row-koderak', function (e) {
                        $('#koderak').val($(this).find('td:eq(0)').html());

                        $('#m_koderak').modal('hide');
                    });
                }
            });
        }

        function print(){
            swal({
                title: `{{ __('Yakin ingin mencetak KK Status periode') }} `+$('#periode').val()+'?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function(){
                window.open(`{{ url()->current() }}/print?periode=${$('#periode').val()}&koderak=${$('#koderak').val()}&rowsb=${$('#rowstoragebesar').val()}&rowsk=${$('#rowstoragekecil').val()}`,'_blank');
            })
        }
    </script>
@endsection
