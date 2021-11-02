@extends('navbar')
@section('title','HARGA PROMOSI')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5 text-left">Tabel Harga Promosi</legend>
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-right">PLU</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="pluInput">
                                <button type="button" class="btn btn-lov p-0" onclick="ToggleData(this)">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="deskripsiPlu" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-right">Satuan</label>
                            <div class="col-sm-2">
                                <input class="text-left form-control" type="text" id="satuan" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-right">Jenis Promosi</label>
                            <div class="col-sm-1">
                                <input class="text-left form-control" type="text" id="jPromosi" onkeypress="isTD(event)" maxlength="1" disabled>
                            </div>
                            <label class="col-sm-3 col-form-label text-left">[T] Turun Langsung&nbsp;&nbsp;&nbsp;&nbsp;[D] Diskon</label>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-right">Tanggal Mulai</label>
                            <div class="col-sm-2">
                                <input class="text-center form-control" type="text" id="dateStart" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-right">Tanggal Selesai</label>
                            <div class="col-sm-2">
                                <input class="text-center form-control" type="text" id="dateEnd" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-right">Harga Jual</label>
                            <div class="col-sm-2">
                                <input class="text-right form-control" type="text" id="hrgJual" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-right">Potongan %</label>
                            <div class="col-sm-2">
                                <input class="text-right form-control" type="text" id="potPersen" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-right">Potongan Rupiah</label>
                            <div class="col-sm-2">
                                <input class="text-right form-control" type="text" id="potRupiah" disabled>
                            </div>
                        </div>
                        <br>
                        {{--BUTTONS--}}
                        <div class="col-sm-11 d-flex justify-content-end">
                            <button class="btn btn-success col-sm-1" type="button" onclick="print()">PRINT</button>&nbsp;
                        </div>
                    </div>
                </fieldset>
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5 text-left">Detail Tabel Harga Promosi</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="p-0 tableFixedHeader" style="height: 400px;">
                            <table class="table table-sm table-striped table-bordered"
                                   id="tableMain">
                                <thead>
                                <tr class="table-sm text-center">
                                    <th width="10%" class="text-center small">PLU</th>
                                    <th width="10%" class="text-center small">Jenis<br>Promosi</th>
                                    <th width="20%" class="text-center small">Tgl Mulai</th>
                                    <th width="20%" class="text-center small">Tgl Akhir</th>
                                    <th width="20%" class="text-center small">Harga Jual</th>
                                    <th width="10%" class="text-center small">Potongan<br>Persen</th>
                                    <th width="10%" class="text-center small">Potongan<br>Rph</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyMain" style="height: 400px;">
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Deskripsi</label>
                            <div class="col-sm-4">
                                <input class="text-left form-control" type="text" id="deskripsiTable" readonly>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>


    <!--MODAL PLU-->
    <div class="modal fade" id="m_plu" tabindex="-1" role="dialog" aria-labelledby="m_plu" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informasi Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tablePlu">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>PLU</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyPlu"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- END OF MODAL PLU-->

    <style>
        .myCustom{
            text-align: right;
        }
    </style>

    <script>
        let tableMain;
        let tablePlu;

        $(document).ready(function () {
            PluModal('');
            MainTable();
        });

        $('#pluInput').on('keydown', function() {
            if(event.key == 'Tab'){
                if($('#pluInput').val() == ''){
                    swal({
                        title:'Alert',
                        text: 'Kode Barang Tidak Boleh Kosong !!',
                        icon:'warning',
                    }).then(() => {
                        $('#pluInput').focus();
                    });
                }else{
                    $('#pluInput').change();
                }
            }
        });
        $('#pluInput').on('change', function() {
            let crop = $('#pluInput').val().toUpperCase();
            if(crop != ''){
                if(crop.substr(0,1) == '#'){
                    crop = crop.substr(1,(crop.length)-1);
                }
            }
            if(crop.length < 7){
                crop = crop.padStart(7,'0');
            }
            $.ajax({
                url: '{{ url()->current() }}/checkplu',
                type: 'GET',
                data: {
                    kode:crop
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                    $('#pluInput').val(crop);
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if(response.notif != ""){
                        swal({
                            title:'Alert',
                            text: response.notif,
                            icon:'warning',
                        }).then(() => {
                            $('#pluInput').focus();
                        });
                    }else{
                        $('#deskripsiPlu').val(response.barang.deskripsi);
                        $('#satuan').val(response.barang.unit);
                        if(response.promo != ''){
                            //$('#plu').val(crop);
                            let date = response.promo.prmd_tglawal;
                            let dateA = date.substr(0,10);
                            date = response.promo.prmd_tglakhir;
                            let dateB = date.substr(0,10);

                            let temp = dateA.split('-');
                            dateA = temp[2]+"/"+temp[1]+"/"+temp[0];
                            temp = dateB.split('-');
                            dateB = temp[2]+"/"+temp[1]+"/"+temp[0];
                            // dateA = dateA.split('-').join('-');
                            // dateB = dateB.split('-').join('-');

                            $('#jPromosi').val(response.promo.prmd_jenisdisc);
                            $('#dateStart').val(dateA);
                            $('#dateEnd').val(dateB);
                            $('#hrgJual').val(convertToRupiah2(response.promo.prmd_hrgjual));
                            $('#potPersen').val(convertToRupiah(response.promo.prmd_potonganpersen));
                            $('#potRupiah').val(convertToRupiah2(response.promo.prmd_potonganrph));
                        }else{
                            $('#jenisLaporan').val('');
                            $('#dateStart').val('');
                            $('#dateEnd').val('');
                            $('#hrgJual').val('');
                            $('#potPersen').val('');
                            $('#potRupiah').val('');
                        }
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                    return false;
                }
            });
        });

        function MainTable(){
            tableMain =  $('#tableMain').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/tabelmain' }}',
                },
                "columns": [
                    {data: 'prmd_prdcd', name: 'prmd_prdcd'},
                    {data: 'prmd_jenisdisc', name: 'prmd_jenisdisc'},
                    {data: 'prmd_tglawal', name: 'prmd_tglawal'},
                    {data: 'prmd_tglakhir', name: 'prmd_tglakhir'},
                    {data: 'prmd_hrgjual', name: 'prmd_hrgjual', class: 'myCustom'},
                    {data: 'prmd_potonganpersen', name: 'prmd_potonganpersen', class: 'myCustom'},
                    {data: 'prmd_potonganrph', name: 'prmd_potonganrph', class: 'myCustom'},
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang', visible: false},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalMain');
                },
                columnDefs : [
                ],
                "order": []
            });
        }

        function PluModal(value){
            tablePlu =  $('#tablePlu').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/modalplu' }}',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                    {data: 'prd_prdcd', name: 'prd_prdcd'},

                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalPlu');
                },
                columnDefs : [
                ],
                "order": []
            });

            $('#tablePlu_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tablePlu.destroy();
                    PluModal(val);
                }
            })
        }

        //    Function untuk onclick pada data modal
        $(document).on('click', '.modalMain', function () {
            let currentButton = $(this);
            let deskripsi = tableMain.row(currentButton).data()['prd_deskripsipanjang']

            $('#deskripsiTable').val(deskripsi);
        });

        //    Function untuk onclick pada data modal
        $(document).on('click', '.modalPlu', function () {
            let currentButton = $(this);
            let nama = currentButton.children().first().text();
            let kode = currentButton.children().first().next().text();

            $('#pluInput').val(kode);
            $('#pluInput').change();

            $('#m_plu').modal('toggle');
        });


        function ToggleData(val){
            $('#m_plu').modal('toggle');
        }


        function isTD(evt){ //membatasi input untuk hanya boleh Y dan T, serta mendeteksi bila menekan tombol enter
            $('#jPromosi').keyup(function(){
                $(this).val($(this).val().toUpperCase());
            });
            let charCode = (evt.which) ? evt.which : evt.keyCode;

            if (charCode == 116) // t kecil
                return 84; //t besar

            if (charCode == 100) // d kecil
                return 68; // D besar

            if (charCode == 89 || charCode == 84)
                return true

            return false;
        }


        function print(){
            window.open('{{ url()->current() }}/print','_blank');
        }

    </script>
@endsection
