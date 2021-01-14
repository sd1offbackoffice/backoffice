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

    <script>

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = dd + '/' + mm + '/' + yyyy;

        // $("#tgl-transKmrn").datepicker({
        //     "dateFormat" : "dd/mm/yy",
        // });
        //
        // $("#tgl-sistemSkrg").datepicker({
        //     "dateFormat" : "dd/mm/yy",
        // });

        $("#tgl-transSkrg").val(today)
        $("#tgl-transKmrn").val(today)
        $("#tgl-sistemSkrg").val(today)

        $('#btn-proses').on('click', function () {
            window.open('/BackOffice/public/bo/proses/settingpagihari/cetak_perubahan_harga_jual/', "_blank");
            window.open('/BackOffice/public/bo/proses/settingpagihari/cetak_daftar_plu_tag/', "_blank");
            // window.location.href="/BackOffice/public/bo/proses/settingpagihari/cetak_perubahan_hrgjual/";
        });

    </script>

@endsection