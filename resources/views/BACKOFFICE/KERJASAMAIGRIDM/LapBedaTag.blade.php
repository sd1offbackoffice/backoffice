@extends('navbar')
@section('title','Laporan Beda Tag')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5">LAPORAN PERBEDAAN TAG IGR dan IDM</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <div class="row">
                                <label class="col-sm-4 text-right font-weight-normal">Per Tanggal</label>
                                <input class="col-sm-3 text-center" type="text" id="datepicker" disabled>
                                <label class="col-sm-2 text-left">DD / MM / YYYY</label>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 text-right font-weight-normal">Kode Tag IGR</label>
                                <input class="col-sm-1 text-center" type="text" id="tag" maxlength="1">
                                <label class="col-sm-2 text-left">[ kosong - SEMUA ]</label>
                            </div>
                            <br>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-success col-sm-4" type="button" onclick="print()">CETAK</button>
                            </div>
                        </form>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <<script>

        $(document).ready(function() {
            let today = new Date();
            let dd = String(today.getDate()).padStart(2, '0');
            let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            let yyyy = today.getFullYear();

            today = dd + '/' + mm + '/' + yyyy;
            $('#datepicker').val(today);
        });

        $('#tag').keyup(function(){
            this.value = this.value.toUpperCase();
        });

        function print() {
            let tag = $('#tag').val();
            if(tag == '' || tag == null){
                tag = '_';
            }

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/kerjasamaigridm/lapbedatag/checkdata',
                type: 'post',
                data: {
                    tag:tag
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    if(result.kode == '0'){
                        window.open('/BackOffice/public/kerjasamaigridm/lapbedatag/printdoc/'+tag,'_blank');
                    }else if(result.kode == '1'){
                        swal('', "tidak ada data", 'warning');
                    }else if(result.kode == '2'){
                        swal('', "Kode Tag tidak terdaftar", 'warning');
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
