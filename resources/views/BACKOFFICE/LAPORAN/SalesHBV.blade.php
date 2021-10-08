@extends('navbar')
@section('title','LAPORAN - TRANSFER SATUAN PRODUK HOT BEVERAGES')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Perhitungan Transfer Satuan Produk</legend>
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <br>
                            <div class="col-sm-12">
                                <label class="col-sm-4 text-right font-weight-normal">Periode</label>
                                <input class="col-sm-3 text-center" type="text" id="daterangepicker">
                                <label class="col-sm-2 text-left">DD / MM / YYYY</label>
                                <button class="btn btn-success col-sm-2" type="button" onclick="print()">C E T A K</button>
                            </div>
                            <br>
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
                url: '/BackOffice/public/laporan/saleshbv/checkdata',
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
                        window.open('/BackOffice/public/laporan/saleshbv/printdoc/'+dateA+'/'+dateB,'_blank');
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
