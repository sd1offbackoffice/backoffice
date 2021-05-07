@extends('navbar')
@section('title','LAPORAN - OUTSTANDING SCANNING IDM / OMI')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5">Laporan OUtsanding Scanning IDM / OMI</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                        <form><br>
                            <div class="col-sm-12">
                                <label class="col-sm-4 text-right font-weight-normal">Periode s/d</label>
                                <input type="text" id="datepicker">
                            </div>
                                <button class="btn btn-success" style="float: right" type="button" onclick="Cetak()">C E T A K</button>
                        </form>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <<script>

        $("#datepicker").datepicker( {
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
        });

        function Cetak() {
            let date = $('#datepicker').val();

            if(date == null || date == ""){
                swal('Input masih kosong','','warning');
                return false
            }
            date = date.split('/').join('-');
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/laporan/outsscan/checkdata',
                type: 'post',
                data: {
                    date:date
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    if(result.kode == '1'){
                        window.open('/BackOffice/public/laporan/outsscan/printdoc/'+date,'_blank');
                    }else{
                        swal('', "Tidak ada Data!", 'warning');
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
