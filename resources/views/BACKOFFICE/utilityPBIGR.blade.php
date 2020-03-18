@extends('navbar')
@section('content')

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <fieldset class="card">
                    <legend  class="w-auto ml-5">Variabel Penghitung Nilai PB IGR</legend>
                    <div class="card-body cardForm">
                        <div class="row">
                           <div class="col-sm-12">
                               <form>
                                   <div class="form-group">
                                       <label for="">1. M PLUS.I</label>
                                       <button type="button" id="#" class="form-control btn btn-primary" onclick="callProc1()">PROSES HITUNG NILAI M PLUS.I</button>
                                   </div>
                                   <div class="form-group">
                                       <label for="">2. BULAN SEASONAL</label>
                                       <button type="button" id="#" class="form-control btn btn-primary" onclick="callProc2()">TARIK DATA BULAN SEASONAL DARI OMI IIO</button>
                                   </div>
                                   <div class="form-group">
                                       <label for="">3. M PLUS.O</label>
                                       <button type="button" id="#" class="form-control btn btn-primary " onclick="callProc3()">PROSES HITUNG NILAI M PLUS.O</button>
                                   </div>
                                   <div class="form-group">
                                       <label for="">4. Laporan Pembentukan  M PLUS.I dan M PLUS.O</label> <br>
                                       <div class="form-row ml-2">
                                           <label class="col-sm-3 text-right">Periode Proses Data</label>
                                           <input type="month" class="form-control col-sm-2 mb-2 ml-2" id="dateLaporan" value="{{\Carbon\Carbon::today()->format('M-y')}}">
                                       </div>
                                       <button type="button" id="#" class="form-control btn btn-primary " onclick="callProc4()">PROSES LAPORAN</button>
                                   </div>
                               </form>
                               <small class="float-right">*Proses M PLUS.I dan M PLUS.O dilakukan tiap tanggal 5</small>
                           </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <script>
        function callProc1(){
            ajaxSetup();
            $.ajax({
                url:'/BackOffice/public/boutilitypbigr/callproc1',
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
                    console.log(result);
                }, error: function (err) {
                    console.log(err);
                }
            })
        }

        function callProc2(){
            ajaxSetup();
            $.ajax({
                url:'/BackOffice/public/boutilitypbigr/callproc2',
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
                    console.log(result);
                }, error: function (err) {
                    console.log(err);
                }
            })
        }

        function callProc3(){
            ajaxSetup();
            $.ajax({
                url:'/BackOffice/public/boutilitypbigr/callproc3',
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
                    console.log(result);
                }, error: function (err) {
                    console.log(err);
                }
            })
        }

        function callProc4(){
            let date = $('#dateLaporan').val();

            if (!date){
                swal('Error','Periode 1 Tidak Boleh Kosong !!', 'error')
                return false;
            }

            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
            // window.open('/BackOffice/public/utilitypbigr/callproc4/'+date+'', '_blank');
            window.location.replace('/BackOffice/public/boutilitypbigr/callproc4/'+date+'');
        }
    </script>


@endsection
