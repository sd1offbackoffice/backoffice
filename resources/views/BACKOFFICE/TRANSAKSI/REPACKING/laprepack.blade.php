@extends('navbar')
@section('title','LAPORAN REPACKING')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5">Cetak Laporan Repacking</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <div class="col-sm-12">
                                <label class="col-sm-4 text-right font-weight-normal">Periode Tanggal</label>
                                <input class="col-sm-3 text-center" type="text" id="daterangepicker">
                                <label class="col-sm-2 text-left">DD / MM / YYYY</label>
                            </div>
                            <br>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success col-sm-4" type="button" onclick="print()">PRINT</button>
                            </div>
                        </form>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <<script>

        $('#daterangepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
        function print() {
            let date = $('#daterangepicker').val();
            let dateA = date.substr(0,10);
            let dateB = date.substr(13,10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');



            if(date == null || date == ""){
                swal('Input masih kosong','','warning');
                return false
            }
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/transaksi/laprepacking/checkdata',
                type: 'post',
                data: {
                    dateA:dateA,
                    dateB:dateB
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    if(result.kode == '1'){
                        window.open('/BackOffice/public/transaksi/laprepacking/printdoc/'+dateA+'/'+dateB,'_blank');
                    }else{
                        swal('', "tidak ada data", 'warning');
                    }
                    $('#modal-loader').modal('hide');
                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }
    </script>
@endsection
