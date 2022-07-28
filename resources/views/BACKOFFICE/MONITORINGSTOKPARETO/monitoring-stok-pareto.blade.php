@extends('navbar')

@section('title',__('BO | MONITORING STOK PARETO & KKH PB MANUAL'))

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body pt-0">
                        <fieldset class="card border-secondary mt-0">
                            <legend  class="w-auto ml-3">@lang('Monitoring Stok Pareto & KKH PB Manual')</legend>
                            <div class="card-body py-0">
                                <div class="row form-group">
                                    <label class="col-sm-2 text-right col-form-label text-right pl-0 pr-0">@lang('Periode Proses')</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-left" id="periode" value="{{ $periode }}" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-2 text-right col-form-label text-right pl-0 pr-0">@lang('Untuk PB Tanggal')</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-left" id="pbtgl" value="{{ $pbtgl }}" disabled>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control text-left" id="pbhari" value="{{ $pbhari }}" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-2 col-form-label text-right pl-0 pr-0">@lang('Kode Monitoring PLU')</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left" id="mon_kode" disabled>
                                        <button id="btn_kodemonplu" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovMonitoring()">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control text-left" id="mon_nama" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-3"></div>
                                    <button class="col-sm-6 btn btn-primary" id="btn_montok" onclick="printMontok()">
                                        @lang('CETAK MONITORING STOK (MONTOK) ITEM PARETO')
                                    </button>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-3"></div>
                                    <button class="col-sm-6 btn btn-primary" id="btn_kkhpb" onclick="printKKH()">
                                        @lang('CETAK KERTAS KERJA HARIAN (KKH) PB MANUAL')
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="modal fade" id="m_monitoring" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_monitoring">
                                    <thead class="thColor">
                                    <tr>
                                        <th>@lang('Kode Monitoring')</th>
                                        <th>@lang('Nama Monitoring')</th>
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
        $(document).ready(function(){

        });

        function showLovMonitoring(){
            $('#m_monitoring').modal('show');

            if(!$.fn.DataTable.isDataTable('#table_monitoring')){
                getLovMonitoring();
            }
        }

        function getLovMonitoring(){
            $('#table_monitoring').DataTable({
                "ajax": '{{ url()->current().'/get-lov-monitoring' }}',
                "columns": [
                    {data: 'kode_mon'},
                    {data: 'nama_mon'},
                ],
                "paging": true,
                // "pageLength" : 10,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(0)').addClass('text-left');
                    $(row).addClass('row-monitoring').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $(document).on('click', '.row-monitoring', function (e) {
                        $('#mon_kode').val($(this).find('td:eq(0)').html());
                        $('#mon_nama').val($(this).find('td:eq(1)').html());

                        $('#m_monitoring').modal('hide');

                        checkMonCode();
                    });
                }
            });
        }

        function checkMonCode(){
            if($.inArray($('#mon_kode').val(), ['SM','SJMF','SJMNF','SPVF','SPVNF','SPVGMS']) > -1){
                $('#btn_montok').prop('disabled',false).focus();
                $('#btn_kkhpb').prop('disabled',true);
            }
            else if($.inArray($('#mon_kode').val(), ['F1','F2','NF1','NF2','G','O']) > -1){
                $('#btn_montok').prop('disabled',true);
                $('#btn_kkhpb').prop('disabled',false).focus();
            }
            else{
                $('#btn_montok').prop('disabled',true);
                $('#btn_kkhpb').prop('disabled',true);
            }
        }

        function printKKH(){
            swal({
                title: `{{ __('Yakin ingin mencetak KKH PB Manual untuk kode') }} `+$('#mon_kode').val()+'?',
                text: `{{ __('Proses mungkin membutuhkan waktu beberapa menit') }}`,
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function(ok){
                if(ok)
                    window.open(`{{ url()->current() }}/print-kkh?kodemon=${$('#mon_kode').val()}`,'_blank');
            });
        }

        function printMontok(){
            swal({
                title: `{{ __('Yakin ingin mencetak Monitoring Stok Item Pareto untuk kode') }}  `+$('#mon_kode').val()+'?',
                text: `{{ __('Proses mungkin membutuhkan waktu beberapa menit') }}`,
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function(ok){
                if(ok)
                    window.open(`{{ url()->current() }}/print-montok?kodemon=${$('#mon_kode').val()}`,'_blank');
            });
        }
    </script>
@endsection
