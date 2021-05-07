@extends('navbar')
@section('title','Template') {{-- TITLE BAR DI AMBIL DARI NAMA MENU 2 PALING AKHIR, CONTOH : PB | CETAK PB, PEMUSNAHAN | BARANG RUSAK, PENYESUAIAN | INPUT --}}
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <p>1. Tombol LOV berada di dalam input type, tombol diletakan di sisi kanan. Panduan button liat
                            di poin ke dua</p>
                        <form>
                            <div class="form-group row mb-1 pt-4">
                                <label class="col-sm-2 col-form-label text-right">Label Atas 1</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control" id="noBTB">
                                    <button id="btn-no-doc" type="button" class="btn btn-lov p-0">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                                <label class="col-sm-1 col-form-label text-right">Label Atas 2</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="tglBTB" placeholder="dd/mm/yyyy">
                                </div>
                            </div>

                            <div class="form-group row mb-1">
                                <label class="col-sm-2 col-form-label text-right">Label Bawah 1</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control" id="noPO">
                                    <button id="" type="button" class="btn btn-lov p-0">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                                <label class="col-sm-1 col-form-label text-right">Label Bawah 2</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="tglPO" disabled
                                           placeholder="dd/mm/yyyy">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <button class="btn btn-danger col-sm-2 offset-sm-9 btn-block" type="button">Button
                                    Delete
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <p>2. Tombol di kasih class 'btn-block', ukuran disesuaikan dengan class 'col-sm-...</p>
                        <form>
                            <div class="form-group row mb-0 mt-5">
                                <div class="col-sm-2 text-center offset-sm-5">
                                    <button type="button" class="btn btn-success btn-block">Button Cetak</button>
                                </div>
                                <div class="col-sm-2 text-center">
                                    <button type="button" class="btn btn-danger btn-block">Button Delete</button>
                                </div>
                                <div class="col-sm-2 text-center">
                                    <button type="button" class="btn btn-primary btn-block">Button Lainnya</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <p>3. Penggunaan Modal. Bentuk dan ukuran modal disesuaikan dengan kebutuhan tetapi table
                            didalam modal menggunakan datatables dan modal mencul di tengah layar menggunakan class
                            'modal-dialog-centered</p>
                        <button class="btn btn-primary ml-2" type="button" data-toggle="modal"
                                data-target="#m_template"> Button Modal
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <p>4. Title di tab diambil dari nama menu 2 paling akhir</p>
                        <p>Contoh untuk menu cetak pb => PB | CETAK PB</p>
                        <p>Contoh untuk menu barang rusak => PEMUSNAHAN | BARANG RUSAK</p>
                        <p>Contoh untuk menu input penyesuaian => PENYESUAIAN | INPUT</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <p>5. Contoh Table dengan kolom berupa input type</p>
                        <div class="p-0 tableFixedHeader" style="height: 250px;">
                            <table class="table table-sm table-striped table-bordered"
                                   id="table-header">
                                <thead>
                                <tr class="table-sm text-center">
                                    <th width="3%" class="text-center small"></th>
                                    <th width="10%" class="text-center small">PLU</th>
                                    <th width="20%" class="text-center small">DESKRIPSI</th>
                                    <th width="10%" class="text-center small">SATUAN</th>
                                    <th width="7%" class="text-center small">BKP</th>
                                    <th width="7%" class="text-center small">STOCK</th>
                                    <th width="7%" class="text-center small">CTN</th>
                                    <th width="7%" class="text-center small">PCS</th>
                                    <th width="29%" class="text-center small">KETERANGAN</th>
                                </tr>
                                </thead>
                                <tbody id="body-table-header" style="height: 250px;">
                                @for($i = 0 ; $i< 10 ; $i++)
                                    <tr>
                                    <td>
                                        <button class="btn btn-block btn-sm btn-danger btn-delete-row-header"><i
                                                class="icon fas fa-times"></i></button>
                                    </td>
                                    <td class="buttonInside" style="width: 150px;">
                                        <input type="text" class="form-control plu" value="">
                                        <button id="btn-no-doc" type="button" class="btn btn-lov ml-3">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </td>
                                    <td>
                                        <input disabled class="form-control deskripsi-header-1"
                                               type="text">
                                    </td>
                                    <td>
                                        <input disabled class="form-control satuan-header-1"
                                               type="text">
                                    </td>
                                    <td>
                                        <input disabled class="form-control bkp-header-1"
                                               type="text">
                                    </td>
                                    <td>
                                        <input disabled class="form-control stock-header-1"
                                               type="text">
                                    </td>
                                    <td>
                                        <input class="form-control ctn-header ctn-header-1"
                                               rowheader=1
                                               type="text">
                                    </td>
                                    <td>
                                        <input class="form-control pcs-header pcs-header-1"
                                               rowheader=1
                                               type="text">
                                    </td>
                                    <td>
                                        <input
                                            class="form-control keteragan-header keterangan-header-1"
                                            rowheader=1 type="text">
                                    </td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <p>6. Loader, Modalnya ada di blade navbar. jadi di js tinggal di panggil saja "#modal-loader"</p>
                        <button class="btn btn-primary ml-2" type="button" onclick="modalLoader()"> Button Loader
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-sm-12">
                <fieldset class="card border-dark cardForm">
                    <legend class="w-auto ml-5">Total</legend>
                    <div class="card-body">
                        <p>7. Contoh tampilan Card untuk Form sesuaikan dengan part ini atau menu <a
                                href="{{url("/bo/transaksi/pengeluaran/input")}}" target="_blank">input pengeluaran</a></p>
                        <p>Utamakan menggunakan class 'container-fluid mt-4' 'row justify-content-center' 'col-sm-12', bisa disesuaikan apabila tampilan form tidak besar</p>
                    </div>
                </fieldset>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <p>8. Untuk convert rupiah, convert tanggal, convert PLU, bisa di lihat di script.js. di situ sudah ada functionnya, tinggal pakai </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <p>9. Table data selain yang kolomnya input type menggunakan datatables </p>

                        <table  class="table table-sm table-striped table-bordered " id="tableTemplate">
                            <thead class="theadDataTables">
                            <tr>
                                <th>Kodeigr</th>
                                <th>Nama Cabang</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{--Modal--}}
    <div class="modal fade" id="m_template" tabindex="-1" role="dialog" aria-labelledby="m_template" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title - Diganti sesuai kebutuhan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalTemplate">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kodeigr</th>
                                        <th>Nama Cabang</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
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


    <script>
        $(document).ready(function () {
            $('#tableModalTemplate').DataTable({
                "ajax": '{{ url('template/datamodal') }}',
                "columns": [
                    {data: 'cab_kodecabang', name: 'cab_kodeigr'},
                    {data: 'cab_namacabang', name: 'cab_namacabang'},
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
                },
                "order": []
            });

            $('#tableTemplate').DataTable({
                "ajax": '{{ url('template/datamodal') }}',
                "columns": [
                    {data: 'cab_kodecabang', name: 'cab_kodeigr'},
                    {data: 'cab_namacabang', name: 'cab_namacabang'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                },
                "order": []
            });

            swal('Warning', 'Bila ada yang ingin ditanyakan, chat di grup!', 'warning');
        })

        //    Function untuk onclick pada data modal
        $(document).on('click', '.modalRow', function () {
            var currentButton = $(this);
            let kodeigr = currentButton.children().first().text();
            let namacabang = currentButton.children().first().next().text();

            alert("cek console untuk hasilnya")
            console.log(kodeigr);
            console.log(namacabang);

        });

        function modalLoader() {

            $('#modal-loader').modal('show');
            setTimeout(function () {
                $('#modal-loader').modal('hide');
            }, 2000);

        }


    </script>

@endsection
