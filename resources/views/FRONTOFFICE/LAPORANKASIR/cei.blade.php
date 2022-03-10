@extends('navbar')
@section('title','Laporan Cash Back / Event / Item')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Laporan Cash Back per Event per Item</legend>
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row">
                            <label class="col-sm-4 text-right font-weight-normal">Periode Tanggal</label>
                            <input class="col-sm-3 text-center form-control" type="text" id="daterangepicker">
                            <label class="col-sm-2 text-left">DD / MM / YYYY</label>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-4 text-right font-weight-normal">Kode Event</label>
                            <input class="col-sm-1 form-control" type="text" id="event1">
                            <span class="col-sm-1 text-center">s/d</span>
                            <input class="col-sm-1 form-control" type="text" id="event2">
                        </div>
                        <br>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success col-sm-3" type="button" onclick="print()">C E T A K</button>
                        </div>

                        <br>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <script src={{asset('/js/sweetalert2.js')}}></script>
    <script>

        $(function() {
            $("#daterangepicker").daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
        });

        function print() {
            let date = $('#daterangepicker').val();
            if(date == null || date == ""){
                swal.fire('Input masih kosong','','warning');
                return false;
            }
            let dateA = date.substr(0,10);
            let dateB = date.substr(13,10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');
            let event1 = $('#event1').val();
            let event2 = $('#event2').val();
            if(event1 == '' && event2 != '' || event1 != '' && event2 == ''){
                swal.fire('Kode Event Harus Terisi Semua Atau Tidak Terisi Sama Sekali ','','warning');
                return false;
            }else if(event1 > event2){
                swal.fire('Kode Event 1 Harus Lebih Kecil dari Kode Event 2','','warning');
                return false;
            }
            if(event1 == ''){
                event1 = "nodata";
            }
            if(event2 == ''){
                event2 = "nodata";
            }
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/checkdata',
                type: 'post',
                data: {
                    dateA:dateA,
                    dateB:dateB,
                    event1:event1,
                    event2:event2
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (w) {
                    if(w.kode == '1'){
                        window.open('{{ url()->current() }}/printdoc/'+dateA+'/'+dateB+'/'+event1+'/'+event2,'_blank');
                        window.open('{{ url()->current() }}/downloadcsv/'+dateA+'/'+dateB+'/'+event1+'/'+event2,'_blank');
                    }
                    else if (w.kode == '0'){
                        swal.fire('', "tidak ada data", 'warning');
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
