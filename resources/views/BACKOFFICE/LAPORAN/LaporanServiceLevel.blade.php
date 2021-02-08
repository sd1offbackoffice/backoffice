@extends ('navbar')
@section('title','LAPORAN SERVICE LEVEL PO THD BPB')
@section ('content')

    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-5">Service Level PO vs BTB</legend>
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row mb-0">
                                        <label for="tgl" class="col-sm-4 col-form-label text-right">Tanggal</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control field field1" field="1" id="tgl1" onchange="checkDate('tgl1')">
                                        </div>
                                        <label for="tglsd" class="col-sm-1 col-form-label">s/d</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control field field2" field="2" id="tgl2" onchange="checkDate('tgl2')">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="supplier" class="col-sm-4 col-form-label text-right">Supplier</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control field field3" field="3" id="supplier1">
                                            <button id="btnSupp1" type="button" class="btn btn-lov p-0" data-target="modal" onclick="helpSupp('supplier1')">
                                                <img src="{{asset('image/icon/help.png')}}" width="20px">
                                            </button>
                                        </div>
                                        <label for="suppliersd" class="col-sm-1 col-form-label">s/d</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control field field4" field="4" id="supplier2">
                                            <button id="btnSupp2" type="button" class="btn btn-lov p-0" data-toggle="modal" onclick="helpSupp('supplier2')">
                                                <img src="{{asset('image/icon/help.png')}}" width="20px">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="kodeMonitoring" class="col-sm-4 col-form-label text-right">Kode Monitoring Supplier</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control field field5" field="5" id="kodeMtrSupp">
                                            <button id="btnKode" type="button" class="btn btn-lov p-0" data-toggle="modal" onclick="helpMtrSupp('kodeMtrSupp')">
                                                <img src="{{asset('image/icon/help.png')}}" width="20px">
                                            </button>
                                        </div>
                                        <div class="col-sm-4">
                                            <input disabled type="text" class="form-control" id="namaMtrSupp">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="ranking" class="col-sm-4 col-form-label text-right">Ranking</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="ranking">
                                        </div>
                                        <label class="col-sm-6 col-form-label">% SL ( A - Z ) : 1 - Item / 2 - Kuantum / 3 - Nilai</label>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-6 col-form-label"></label>
                                        <label class="col-sm-6 col-form-label">% SL ( Z - A ) : 4 - Item / 5 - Kuantum / 6 - Nilai</label>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <button type="button" class="btn btn-info col-sm-2 offset-sm-9" id="btn-cetak">
                                            C E T A K
                                        </button>
                                    </div>
                                    <span style="float: left">
                                        ** Untuk Laporan Detail Per PO Kolom Rangking Tidak Usah Diisi
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="vertical-align: middle;">
        <div class="modal-dialog modal-dialog-centered" role="document" >
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="loader" id="loader"></div>
                            <div class="col-sm-12 text-center">
                                <label for="">LOADING...</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="modalHelp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="searchModal" class="form-control search_lov" type="text" placeholder="..." aria-label="Search">
                    </div>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="tableFixedHeader">
                                    <table class="table table-sm">
                                        <thead>
                                        <tr>
                                            <th id="modalThName1"></th>
                                            <th id="modalThName2"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbodyModalHelp"></tbody>
                                    </table>
                                    <p class="text-hide" id="idModal"></p>
                                    <p class="text-hide" id="idField"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <script>
        var today = new Date();
        var date1 = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = dd + '/' + mm + '/' + yyyy;
        date1.setDate(1);

        $("#tgl1").datepicker({
            "dateFormat" : "dd/mm/yy",
        });

        $("#tgl2").datepicker({
            "dateFormat" : "dd/mm/yy",
        });

        $("#tgl1").val(date1);
        $("#tgl2").val(today);

        $(document).on('keypress', '.field', function (e) {
            if(e.which == 13) {
                e.preventDefault();
                var field   = $(this).attr('field');
                var target  = 'field'+(parseInt(field)+1);
                $('.'+target).focus();
            }
        });

        function chooseRow(field,data) {
            $('#'+ field+'').val(data);
            $('#modalHelp').modal('hide');
        }

        function checkDate(periode){
            if($('#tgl1').datepicker('getDate') > $('#tgl2').datepicker('getDate') && ($('#tgl1').val() != '' && $('#tgl2').val() != '')){
                if(periode === 'tgl1'){
                    swal({
                        title: 'Tanggal Pertama lebih besar dari Tanggal Kedua!',
                        icon: 'warning'
                    }).then(() => {
                        $('#tgl1').val('').select();
                    });
                } else {
                    swal({
                        title: 'Tanggal Kedua lebih kecil dari Tanggal Pertama!',
                        icon: 'warning'
                    }).then(() => {
                        $('#tgl2').val('').select();
                    });
                }
            }
        }

        $('#searchModal').keypress(function (e) {
            if (e.which === 13) {
                let idModal = $('#idModal').text();
                let idField = $('#idField').text();
                let input = $('#searchModal').val();

                console.log(idField);

                if (idModal === 'supp') {
                    searchSupp(input, idField);
                } else if (idModal === 'kodemonitor') {
                    searchMtrSupp(input, idField);
                }
            }
        });

        function helpSupp(field) {
            let tgl1   = $('#tgl1').val();
            let tgl2   = $('#tgl2').val();

            if(tgl1.length === 0 || tgl2.length === 0){
                swal('Error', 'Tanggal Periode 1 dan 2 Tidak Boleh Kosong !!', 'error');
                return false;
            } else {
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/bo/laporan/laporanservicelevel/lov_supplier',
                    type: 'post',
                    data: {},
                    success: function (result) {
                        $('#modalThName1').text('Kode Supplier');
                        $('#modalThName2').text('Nama Supplier');
                        $('#idModal').text('supp');
                        $('#idField').text(field);
                        $('#searchModal').val('');

                        $('.modalRow').remove();
                        for (i = 0; i< result.length; i++){
                            $('#tbodyModalHelp').append("<tr onclick=chooseRow('"+ field +"','"+ result[i].sup_kodesupplier+"') class='modalRow'><td>"+ result[i].sup_kodesupplier +"</td><td>"+ result[i].sup_namasupplier +"</td></tr>")
                        }

                        $('#modalHelp').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                })
            }
        }

        function searchSupp(input, field) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/laporan/laporanservicelevel/lov_supplier',
                type: 'post',
                data: {
                    search:input
                },
                success: function (result) {
                    $('#modalThName1').text('Kode Supplier');
                    $('#modalThName2').text('Nama Supplier');
                    $('#idModal').text('supp');
                    $('#idField').text(field);
                    $('#searchModal').val('');

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseRow('"+ field +"','"+ result[i].sup_kodesupplier+"') class='modalRow'><td>"+ result[i].sup_kodesupplier +"</td><td>"+ result[i].sup_namasupplier +"</td></tr>")
                    }

                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function helpMtrSupp(field) {
            let supp1   = $('#supplier1').val();
            let supp2   = $('#supplier2').val();

            if(supp1.length === 0 || supp2.length === 0){
                swal('Error', 'Kode Supplier 1 dan 2 Tidak Ada !!', 'error');
                return false;
            } else {
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/bo/laporan/laporanservicelevel/lov_monitoring',
                    type: 'post',
                    data: {
                        supp1: supp1,
                        supp2: supp2
                    },
                    success: function (result) {
                        $('#modalThName2').show();
                        $('#modalThName3').hide();
                        $('#modalThName2').show();
                        $('#modalThName1').text('Kode Monitoring');
                        $('#modalThName2').text('Nama Monitoring');
                        $('#idModal').text('kodemonitor');
                        $('#idField').text(field);
                        $('#searchModal').val('');

                        $('.modalRow').remove();
                        for (i = 0; i< result.length; i++){
                            $('#tbodyModalHelp').append("<tr onclick=chooseRow('"+ field +"','"+ result[i].msu_kodemonitoring+"') class='modalRow'><td>"+ result[i].msu_kodemonitoring +"</td><td>"+ result[i].msu_namamonitoring +"</td></tr>")
                        }

                        $('#modalHelp').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                })
            }
        }

        // function chooseMtrSupp(kode,name) {
        //     $('#kodeMtrSupp').val(kode);
        //     $('#namaMtrSupp').val(name);
        //     $('#modalHelp').modal('hide');
        // }

        function searchMtrSupp(input, field) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/laporan/laporanservicelevel/lov_monitoring',
                type: 'post',
                data: {
                    search: input
                },
                success: function (result) {
                    $('#modalThName2').show();
                    $('#modalThName3').hide();
                    $('#modalThName2').show();
                    $('#modalThName1').text('Kode Monitoring');
                    $('#modalThName2').text('Nama Monitoring');
                    $('#idModal').text('kodemonitor');
                    $('#idField').text(field);
                    $('#searchModal').val('');

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseMtrSupp('"+ result[i].msu_kodemonitoring +"','"+ result[i].msu_namamonitoring+"') class='modalRow'><td>"+ result[i].msu_kodemonitoring +"</td><td>"+ result[i].msu_namamonitoring +"</td></tr>")
                    }

                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function cetak(){
            let tgl1 = $('#tgl1').val();
            let tgl2 = $('#tgl2').val();
            let supp1 = $('#supplier1').val();
            let supp2 = $('#supplier2').val();
            let kodeMonitoring = $('#kodeMtrSupp').val();
            // let namaMonitoring = $('#namaMonitoringSupp').val();
            let ranking = $('#ranking').val();

            if (!tgl1 || !tgl2) {
                swal("Tanggal Harus Terisi Semua !!", '', 'warning')
            } else if ( (supp1 && !supp2) || (!supp1 && supp2) ) {
                swal("Supplier Harus Terisi Semua !!", '', 'warning')
            } else if ( !kodeMonitoring ) {
                swal("Kode Monitoring Supplier Harus Terisi Semua !!", '', 'warning')
            } else if ( !ranking ) {
                swal("Salah Pilihan Order Cetakan !!", '', 'warning')
            } else {
                window.open('/BackOffice/public/bocetakpb/cetakreport/'+tgl1 +'/'+tgl2+'/'+doc1+'/'+doc2+'/'+div1+'/'+div2+'/'+dept1+'/'+dept2+'/'+kat1+'/'+kat2+'/'+tipePB+'/')
                clearField()
            }
        }

        function clearField(){
            $('#tgl1').val('');
            $('#tgl2').val('');
            $('#supplier1').val('');
            $('#supplier2').val('');
            $('#kodeMtrSupp').val('');
            $('#namaMtrSupp').val('');
            $('#ranking').val('');
        }



    </script>


@endsection