@extends('navbar')
@section('title','Laporan Barang Promosi')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Laporan Barang Promosi</legend>
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row">
                            <label class="col-sm-4 text-right font-weight-normal">Periode Tanggal</label>
                            <input class="col-sm-3 text-center form-control" type="text" name="date" id="date">
                            <label class="col-sm-2 text-left">MM-YY</label>
                        </div>
                        <br>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success col-sm-3" type="button" onclick="printDoc()">C E T A K</button>
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
            $('#date').datepicker({
                dateFormat: 'mm-yy',
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true
            });
        });
        
        function printDoc() {
            let date = $('#date').val()

            if (!date) {
                swal.fire('Tanggal harus diisi')
                return;
            }

            // let getNowDate = new Date();


            // let nowMonth;
            // if (getNowMonth < 10) {
            //     nowMonth = '0' + getNowMonth;
            // } else {
            //     nowMonth = getNowMonth;
            // }
            // console.log(`inputed date: ${date}`);
            // console.log(`now month: ${nowMonth}`);

            ajaxSetup();
            $.ajax({
                type: "get",
                url: "{{ url()->current() }}/check-date",
                data: {
                    date:date
                },
                beforeSend: function () {
                    $('#modal-loader').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                },
                success: function (response) {
                    // console.log(date);
                    if (response.data === 'now') {
                        window.open(`{{ url()->current() }}/print-now?date=${date}`);
                    } else {
                        window.open(`{{ url()->current() }}/print-early?date=${date}`);
                    }
                    $('#modal-loader').modal('hide')
                }
            });
        }
    </script>
@endsection