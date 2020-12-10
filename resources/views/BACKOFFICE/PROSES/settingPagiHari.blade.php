@extends ('navbar')
@section('title','SETTING PAGI HARI')
@section ('content')

    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-sm-9">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-5">IGR BO SETTING PAGI HARI</legend>
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row mb-0">
                                        <label for="tgl-transKmrn" class="col-sm-5 col-form-label text-right">Tanggal Transaksi Kemarin</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="tgl-transKmrn">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="tgl-sistemSkrg" class="col-sm-5 col-form-label text-right">Tanggal Sistem Sekarang</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="tgl-sistemSkrg">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="tgl-transSkrg" class="col-sm-5 col-form-label text-right">Tanggal Transaksi Sekarang</label>
                                        <div class="col-sm-3">
                                            <input disabled type="text" class="form-control" id="tgl-transSkrg">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="" class="col-sm-5 col-form-label text-right"></label>
                                    </div>
                                    <div class="form-group row mb-0">
                                    <button type="button" class="btn btn-info col-sm-10 offset-sm-1" id="btn-proses">
                                        PROSES
                                    </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <style>

    </style>

    <script>

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = dd + '/' + mm + '/' + yyyy;

        // $("#tgl-transKmrn").datepicker({
        //     "dateFormat" : "dd/mm/yy",
        // });

        // $("#tgl-sistemSkrg").datepicker({
        //     "dateFormat" : "dd/mm/yy",
        // });

        // $("#tgl-transSkrg").datepicker({
        //     "dateFormat" : "dd/mm/yy",
        // });

        $("#tgl-transSkrg").val(today)
        $("#tgl-transKmrn").val(today)
        $("#tgl-sistemSkrg").val(today)

        $('#btn-proses').on('click', function () {
            // let doc         = $('#nmrtrn').val();
            // let keterangan  = $('#keterangan').val();

            // if (!doc || !keterangan){
            //     swal('Data Tidak Boleh Kosong','','warning')
            //     return false;
            // }

            // if(doc && keterangan === '* TAMBAH' || doc && keterangan === '*KOREKSI*'){
            //     saveData('cetak');
            // } else {
                window.open('/BackOffice/public/bo/proses/settingpagihari/cetak_perubahan_hrgjual/');
                // clearField();
            // }
        });






    </script>

@endsection