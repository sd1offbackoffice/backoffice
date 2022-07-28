@extends('navbar')
@section('title',(__('PB | UTILITY PB IGR')))
@section('content')

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <div class="row">
                           <div class="col-sm-12">
                               <form>
                                   <p class="float-right">@lang('*Proses M PLUS.I dan M PLUS.O dilakukan tiap tanggal 5')</p>
                                   <div class="form-group">
                                       <label for="">@lang('1. M PLUS.I')</label>
                                       <button type="button" id="#" class="form-control btn btn-primary" onclick="callProc1()">@lang('PROSES HITUNG NILAI M PLUS.I')</button>
                                   </div>
                                   <div class="form-group">
                                       <label for="">@lang('2. BULAN SEASONAL')</label>
                                       <button type="button" id="#" class="form-control btn btn-primary" onclick="callProc2()">@lang('TARIK DATA BULAN SEASONAL DARI OMI HO')</button>
                                   </div>
                                   <div class="form-group">
                                       <label for="">@lang('3. M PLUS.O')</label>
                                       <button type="button" id="#" class="form-control btn btn-primary " onclick="callProc3()">@lang('PROSES HITUNG NILAI M PLUS.O')</button>
                                   </div>
                                   <div class="form-group">
                                       <label for="">@lang('4. Laporan Pembentukan  M PLUS.I dan M PLUS.O')</label> <br>
                                       <div class="form-row ml-2">
                                           <label class="col-sm-3 text-right">@lang('Periode Proses Data')</label>
                                           <input type="text" class="form-control mb-2 ml-2 text-right" style="width: 200px !important;" id="dateLaporan" value="{{\Carbon\Carbon::today()->format('m/Y')}}">
                                       </div>
                                       <button type="button" id="#" class="form-control btn btn-primary " onclick="callProc4()">@lang('PROSES LAPORAN')</button>
                                   </div>
                               </form>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <a href="http://172.20.28.17/BackOffice/public/file_procedure/sp_hitung_mpluso_web.txt" target="blank">SP_HITUNG_MPLUSO_WEB</a> <br>--}}
{{--    <a href="http://172.20.28.17/BackOffice/public/file_procedure/sp_hitung_mplusi_web.txt" target="blank">SP_HITUNG_MPLUSI_WEB</a> <br>--}}
{{--    <a href="http://172.20.28.17/BackOffice/public/file_procedure/sp_tarik_seasonalomi_web.txt" target="blank">SP_TARIK_SEASONALOMI_WEB</a>--}}

    <script>
        $("#dateLaporan").datepicker({
            "dateFormat" : "M/yy"
        });

        function callProc1(){
            ajaxSetup();
            $.ajax({
                url:'{{ url()->current() }}/callproc1',
                type:'Post',
                data: {},
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    if (result.kode === '0'){
                        swal('', result.return, 'warning');
                    } else {
                        swal('Success', result.return, 'success');
                    }
                }, error: function (error) {
                    errorHandlingforAjax(error)
                }
            })
        }

        function callProc2(){
            ajaxSetup();
            $.ajax({
                url:'{{ url()->current() }}/callproc2',
                type:'Post',
                data: {},
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    if (result.kode === '0'){
                        swal('', result.return, 'warning');
                    } else {
                        swal('Success', result.return, 'success');
                    }
                }, error: function (error) {
                    errorHandlingforAjax(error)
                }
            })
        }

        function callProc3(){
            ajaxSetup();
            $.ajax({
                url:'{{ url()->current() }}/callproc3',
                type:'Post',
                data: {},
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    if (result.kode === '0'){
                        swal('', result.return, 'warning');
                    } else {
                        swal('Success', result.return, 'success');
                    }
                }, error: function (error) {
                   errorHandlingforAjax(error)
                }
            })
        }

        function callProc4(){
            // let date = $('#dateLaporan').val();
            let date = $("#dateLaporan").datepicker("getDate");

            if (!date){
                swal('Error',"{{__('Periode 1 Tidak Boleh Kosong !!')}}", 'error')
                return false;
            }

            // $('#modal-loader').modal({backdrop: 'static', keyboard: false});
            // // window.open('/BackOffice/public/utilitypbigr/callproc4/'+date+'', '_blank');
            // window.location.replace('/BackOffice/public/boutilitypbigr/callproc4/'+date+'');

            ajaxSetup();
            $.ajax({
                url:'{{ url()->current() }}/chekproc4',
                type:'Post',
                data: {date: $.datepicker.formatDate("yymm", date)},
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    if (result.kode === '0'){
                        swal('', result.return, 'warning');
                    } else {
                        $('#modal-loader').modal('hide');
                        // window.open('/BackOffice/public/utilitypbigr/callproc4/'+date+'', '_blank');
                        window.open('{{ url()->current() }}/callproc4/'+($.datepicker.formatDate("yymm", date))+'');
                    }
                    console.log(result);
                }, error: function (error) {
                    errorHandlingforAjax(error)
                }
            })
        }
    </script>


@endsection
