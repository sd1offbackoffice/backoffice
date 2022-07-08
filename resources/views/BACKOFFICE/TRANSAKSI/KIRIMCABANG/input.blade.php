@extends('navbar')

@section('title','PENGIRIMAN KE CABANG | INPUT')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <fieldset class="card border-secondary">
                <div class="card-body">
                    <div class="buttonContainer" style="text-align: center;">
                        <button class="btn btn-primary" onclick="toggleInput()">Input Barang</button>
                        <button class="btn btn-info" onclick="toggleTitip()">Titipan Barang</button>
                        <button class="btn btn-warning" onclick="toggleAll()">Semua</button>
                    </div>
                    <fieldset class="card border-dark p-4" id="fieldInput">
                        <legend class="w-auto ml-5">Input</legend>
                        <div class="row">
                            <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">NOMOR TRN</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="notrn" autocomplete="off">
                                <button id="btn_lov_trn" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_trn" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            {{--<div class="col-sm-1">--}}
                            {{--<input type="text" class="form-control" id="notrn">--}}
                            {{--</div>--}}
                            {{--<div class="">--}}
                            {{--<button class="btn btn-primary rounded-circle btn_lov" id="btn_lov_trn" data-toggle="modal" data-target="#m_lov_trn" disabled>--}}
                            {{--<i class="fas fa-spinner fa-spin"></i>--}}
                            {{--</button>--}}
                            {{--</div>--}}
                            <label class="col-sm-1 pr-0 text-right col-form-label">TANGGAL TRN</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="tgltrn">
                            </div>
                            <label class="col-sm-1 pr-0 text-right col-form-label">UNTUK CABANG</label>
                            <div class="col-sm-1 buttonInside">
                                <input type="text" class="form-control" id="kodecabang" disabled>
                                <button id="btn_lov_cabang" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_cabang" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            {{--<div class="col-sm-1" style="position: relative">--}}
                            {{--<input maxlength="2" type="text" class="form-control" id="kodecabang">--}}
                            {{--<button type="button" class="btn btn_lov btn-lov-cabang" id="btn_lov_cabang" data-toggle="modal" data-target="#m_lov_cabang">--}}
                            {{--<img src="{{ asset('image/icon/help.png') }}" width="30px">--}}
                            {{--</button>--}}
                            {{--</div>--}}
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="namacabang" disabled>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="ipb" disabled>
                            </div>
                            <button class="col-sm-1 pr-0 pl-0 btn btn-danger" id="btn_hapus" onclick="hapusTrn()" disabled>HAPUS DOKUMEN</button>
                        </div>
                        <div class="row">
                            <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">NOMOR REFF</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="noreff" disabled>
                                <button id="btn_lov_ipb" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_ipb" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            {{--<div class="col-sm-1">--}}
                            {{--<input type="text" class="form-control" id="noreff">--}}
                            {{--</div>--}}
                            {{--<div class="">--}}
                            {{--<button class="btn btn-primary rounded-circle btn_lov" id="btn_lov_ipb" data-toggle="modal" data-target="#m_lov_ipb" disabled>--}}
                            {{--<i class="fas fa-spinner fa-spin"></i>--}}
                            {{--</button>--}}
                            {{--</div>--}}
                            <label class="col-sm-1 pr-0 text-right col-form-label">TANGGAL REFF</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="tglreff" disabled>
                            </div>
                            <label class="col-sm-1 pr-0 text-right col-form-label">GUDANG</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="kodegudang">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="namagudang" disabled>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="model" disabled>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="card border-dark p-4" id="fieldTitip">
                        <legend class="w-auto ml-5">Barang Titipan</legend>
                        <div class="row">
                            <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">NOMOR SJ</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="nosj" autocomplete="off">
                            </div>
                            <label class="col-sm-1 pr-0 text-right col-form-label">TGL. ETD</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="tgletd" disabled>
                            </div>
                            <label class="col-sm-1 pr-0 text-right col-form-label">TGL. ETA</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="tgleta" disabled>
                            </div>
                            <label class="col-sm-1 pr-0 text-right col-form-label">UNTUK CABANG</label>
                            <div class="col-sm-1 buttonInside">
                                <input type="text" class="form-control" id="kodecabangtitip" disabled>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="namacabangtitip" disabled>
                            </div>
                            <button class="col-sm-1 pr-0 pl-0 btn btn-danger" id="btn_hapus_titip" onclick="hapusTrn()" disabled>HAPUS DOKUMEN</button>
                        </div>
                        <div class="row">
                            <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">PILIH EKS</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="ekspedisi" disabled>
                                <button id="btn_lov_eks" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_ekspedisi" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            {{--<div class="col-sm-1">--}}
                            {{--<input type="text" class="form-control" id="ekspedisi">--}}
                            {{--</div>--}}
                            {{--<div class="">--}}
                            {{--<button class="btn btn-primary rounded-circle btn_lov" id="btn_lov_eks" data-toggle="modal" data-target="#m_lov_eks" disabled>--}}
                            {{--<i class="fas fa-spinner fa-spin"></i>--}}
                            {{--</button>--}}
                            {{--</div>--}}
                            <label class="col-sm-1 pr-0 text-right col-form-label">KODE SEAL</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="seal">
                            </div>
                            <label class="col-sm-1 pr-0 text-right col-form-label">DURASI</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="durasi" disabled>
                            </div>
                            <label class="col-sm-1 pr-0 text-right col-form-label">TARIF</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="tarif">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="tipetarif" disabled>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-1 pr-0 text-right col-form-label">ALAMAT</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="alamat" disabled>
                            </div>
                            <label class="col-sm-1 pr-0 text-right col-form-label">CATATAN</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="catatan" disabled>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-1 pr-0 text-right col-form-label">CONTAINER</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="container">
                            </div>
                            <label class="col-sm-1 pr-0 text-right col-form-label">KAPAL</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="kapal">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <fieldset class="card border-secondary ml-2 mr-2 mt-0">
                    <div class="card-body">
                        <div id="container_table_input">
                            <table id="table_daftar" class="table table-sm table-bordered mb-3 text-center">
                                <thead class="thColor">
                                    <tr>
                                        <th width="3%" class="align-middle" rowspan="2"><i class="fas fa-trash"></i> </th>
                                        <th width="8%" class="align-middle" rowspan="2">PLU</th>
                                        <th width="15%" class="align-middle" rowspan="2">DESKRIPSI</th>
                                        <th width="6%" class="align-middle" rowspan="2">SATUAN</th>
                                        <th width="3%" class="align-middle" rowspan="2">TAG</th>
                                        <th width="" class="align-middle" colspan="2">STOCK</th>
                                        <th width="" class="align-middle" colspan="2">KUANTUM</th>
                                        <th width="8%">HRG SATUAN</th>
                                        <th width="8%" class="align-middle" rowspan="2">GROSS</th>
                                        <th width="6%" class="align-middle" rowspan="2">PPN</th>
                                        <th width="" class="align-middle" rowspan="2">KETERANGAN</th>
                                    </tr>
                                    <tr>
                                        <th width="5%">CTN</th>
                                        <th width="5%">PCS</th>
                                        <th width="5%">CTN</th>
                                        <th width="5%">PCS</th>
                                        <th>IN CTN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i=0;$i<0;$i++) <tr>
                                        <td><button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></td>
                                        <td>
                                            <div class="" style="position: relative">
                                                <input maxlength="7" type="text" class="form-control prdcd">
                                                <button type="button" class="btn btn-lov-plu" data-toggle="modal" data-target="#m_lov_plu">
                                                    <img src="{{ asset('image/icon/help.png') }}" width="30px">
                                                </button>
                                            </div>
                                        </td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        </tr>
                                        @endfor
                                </tbody>
                            </table>
                        </div>
                        <div id="container_table_titip">
                            <table id="table_daftar_titip" class="table table-sm table-bordered mb-3 text-center">
                                <thead class="thColor">
                                    <tr>
                                        <th width="3%" class="align-middle" rowspan="2"><i class="fas fa-trash"></i> </th>
                                        <th width="8%" class="align-middle" rowspan="2">PLU</th>
                                        <th width="15%" class="align-middle" rowspan="2">DESKRIPSI</th>
                                        <th width="6%" class="align-middle" rowspan="2">SATUAN</th>
                                        <th width="3%" class="align-middle" rowspan="2">TAG</th>
                                        <th width="" class="align-middle" colspan="2">STOCK</th>
                                        <th width="" class="align-middle" colspan="2">KUANTUM</th>
                                        <th width="8%">HRG SATUAN</th>
                                        <th width="8%" class="align-middle" rowspan="2">GROSS</th>
                                        <th width="6%" class="align-middle" rowspan="2">PPN</th>
                                        <th width="" class="align-middle" rowspan="2">KETERANGAN</th>
                                    </tr>
                                    <tr>
                                        <th width="5%">CTN</th>
                                        <th width="5%">PCS</th>
                                        <th width="5%">CTN</th>
                                        <th width="5%">PCS</th>
                                        <th>IN CTN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i=0;$i<0;$i++) <tr>
                                        <td><button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></td>
                                        <td>
                                            <div class="" style="position: relative">
                                                <input maxlength="7" type="text" class="form-control prdcd">
                                                <button type="button" class="btn btn-lov-plu" data-toggle="modal" data-target="#m_lov_plu">
                                                    <img src="{{ asset('image/icon/help.png') }}" width="30px">
                                                </button>
                                            </div>
                                        </td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        </tr>
                                        @endfor
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="deskripsi" disabled autocomplete="off">
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="card-body" id="dataContainerInput">
                    <div class="row">
                        <div class="col-sm-2">
                            <button class="col btn btn-primary" onclick="tambahItem()" id="btn_tambah" disabled>
                                <i class="fas fa-plus"></i> TAMBAH ITEM
                            </button>
                        </div>
                        <div class="col-sm-4"></div>
                        <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">GROSS</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="gross" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">PPN</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="ppn" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">TOTAL ITEM</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control" id="totalitem" disabled>
                        </div>
                        <div class="col-sm-4"></div>
                        <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">TOTAL</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="total" disabled>
                        </div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2">
                            <button class="col btn btn-success" id="btn_simpan" disabled onclick="simpanTrn()">
                                <i class="fas fa-save"></i> SIMPAN
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="dataContainerTitip">
                    <div class="row">
                        <div class="col-sm-2">
                            <button class="col btn btn-primary" onclick="tambahItemTitip()" id="btn_tambah_titip" disabled>
                                <i class="fas fa-plus"></i> TAMBAH ITEM TITIPAN
                            </button>
                        </div>
                        <div class="col-sm-4"></div>
                        <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">GROSS</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="grosstitip" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">PPN</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="ppntitip" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">TOTAL ITEM</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control" id="totalitemtitip" disabled>
                        </div>
                        <div class="col-sm-4"></div>
                        <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">TOTAL</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="totaltitip" disabled>
                        </div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2">
                            <button class="col btn btn-success" id="btn_simpan_titip" disabled onclick="simpanTrn()">
                                <i class="fas fa-save"></i> SIMPAN TITIPAN
                            </button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>

<div class="modal fade" id="m_lov_trn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <br>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col lov">
                            <table class="table table-sm mb-0" id="table_lov_trn">
                                <thead>
                                    <tr>
                                        <th>No. List</th>
                                        <th>Tanggal List</th>
                                        <th>No. Nota</th>
                                    </tr>
                                </thead>
                                <tbody id="">
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="m_lov_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <br>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col lov">
                            <table class="table table-sm mb-0" id="table_lov_plu">
                                <thead>
                                    <tr>
                                        <th>PLU</th>
                                        <th>DESKRIPSI</th>
                                        <th>SATUAN</th>
                                    </tr>
                                </thead>
                                <tbody id="">
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="m_lov_cabang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <br>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col lov">
                            <table class="table table-sm mb-0" id="table_lov_cabang">
                                <thead>
                                    <tr>
                                        <th>KODE CABANG</th>
                                        <th>KODE WILAYAH CABANG</th>
                                        <th>NAMA CABANG</th>
                                    </tr>
                                </thead>
                                <tbody id="">
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="m_lov_ipb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <br>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col lov">
                            <table class="table table-sm mb-0" id="table_lov_ipb">
                                <thead>
                                    <tr>
                                        <th>NO IPB</th>
                                        <th>TGL IPB</th>
                                        <th>UNTUK CABANG</th>
                                        <th>NAMA CABANG</th>
                                    </tr>
                                </thead>
                                <tbody id="">
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="m_lks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <br>
            <div class="modal-body">
                <div class="container">
                    <div class="row form-group">
                        <label class="col-sm-1 pr-0 text-right col-form-label">NO. DOC</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="lks_nodoc" disabled>
                        </div>
                        <label class="col-sm-1 pr-0 text-right col-form-label">PLU</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="lks_prdcd" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <table class="table table-sm mb-0" id="table_lks">
                                <thead class="text-center">
                                    <tr>
                                        <th rowspan="2">LOKASI</th>
                                        <th colspan="2">QTY PLANO</th>
                                        <th rowspan="2">EXP DATE</th>
                                        <th rowspan="2">MAX PLANO</th>
                                        <th colspan="2">QTY TAC</th>
                                    </tr>
                                    <tr>
                                        <th>CTN</th>
                                        <th>PCS</th>
                                        <th>CTN</th>
                                        <th>PCS</th>
                                    </tr>
                                </thead>
                                <tbody id="" class="text-center">
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-1 pr-0 text-right col-form-label">TOTAL</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="lks_total" disabled>
                        </div>
                        <label class="col-sm-1 pr-0 text-right col-form-label">QTY TRF</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="lks_qtytrf" disabled>
                        </div>
                        <div class="col-sm-1"></div>
                        <button class="col-sm-2 btn btn-danger" onclick="lks_cancel()">CANCEL</button>
                        <div class="col-sm-1"></div>
                        <button class="col-sm-2 btn btn-success" onclick="lks_ok()">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ekspedisi -->
<div class="modal fade" id="m_lov_ekspedisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <br>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col lov">
                            <table class="table table-sm mb-0" id="table_lov_eks">
                                <thead>
                                    <tr>
                                        <th>NAMA EKSPEDISI</th>
                                        <th>ALAMAT</th>
                                        <th>TIPE EKSPEDISI</th>
                                        <th>TARIF EKSPEDISI</th>
                                        <th>TIPE TARIF EKSPEDISI</th>
                                        <th>DURASI EKSPEDISI</th>
                                        <th>AREA EKSPEDISI</th>
                                        <th>CATATAN</th>
                                    </tr>
                                </thead>
                                <tbody id="">
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #edece9;
        /*background-color: #ECF2F4  !important;*/
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button,
    input[type=date]::-webkit-inner-spin-button,
    input[type=date]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .modal tbody tr:hover {
        cursor: pointer;
        background-color: #acacac;
        color: white;
    }

    .btn-lov-cabang {
        position: absolute;
        bottom: 10px;
        right: 3vh;
        border: none;
        height: 30px;
        width: 30px;
        border-radius: 100%;
        outline: none;
        text-align: center;
        font-weight: bold;
    }

    .btn-lov-cabang:focus,
    .btn-lov-cabang:active {
        box-shadow: none !important;
        outline: 0px !important;
    }

    .btn-lov-plu {
        position: absolute;
        bottom: 10px;
        right: 2vh;
        border: none;
        height: 30px;
        width: 30px;
        border-radius: 100%;
        outline: none;
        text-align: center;
        font-weight: bold;
    }

    .btn-lov-plu:focus,
    .btn-lov-plu:active {
        box-shadow: none !important;
        outline: 0px !important;
    }

    .modal thead tr th {
        vertical-align: middle;
    }
</style>

<script>
    var notrn;
    var lovtrn;
    var lovcabang;
    var lovplu;
    var data = [];
    var prdcd;
    var tipe;
    var rowIndex = 0;
    var currentRow = 0;
    var tabel;
    var tabel_titip;
    var tgltrn;
    var tgletd;
    var tgleta;
    var datalks = [];
    // {{--var parameterPPN = {{ Session::get('ppn') }} / 100; ikut IAS lama parameter.PPN ga disii (18/04/2022) --}}
    var parameterPPN = 0;
    var arrCabang = [];
    let currurl = '{{ url()->current() }}';

    $(document).ready(function() {
        tgltrn = $('#tgltrn').datepicker({
            "dateFormat": "dd/mm/yy",
        });

        tgletd = $('#tgletd').datepicker({
            "dateFormat": "dd/mm/yy",
        });

        tgleta = $('#tgleta').datepicker({
            "dateFormat": "dd/mm/yy",
        });

        tabel = $('#table_daftar').DataTable({
            "scrollY": "40vh",
            "paging": false,
            "sort": false,
            "bInfo": false,
            "searching": false
        });

        tabel_titip = $('#table_daftar_titip').DataTable({
            "scrollY": "40vh",
            "paging": false,
            "sort": false,
            "bInfo": false,
            "searching": false
        });

        getLovIpb();
        getLovCabang();
        getLovTrn();
        getLovEks();
        // $('#m_lks').modal('show');
    });

    function getLovTrn() {
        lovtrn = $('#table_lov_trn').DataTable({
            "ajax": currurl + '/get-data-lov-trn',
            "columns": [{
                    data: 'trbo_nodoc',
                    name: 'trbo_nodoc'
                },
                {
                    data: 'trbo_tgldoc',
                    name: 'trbo_tgldoc'
                },
                {
                    data: 'nota',
                    name: 'nota'
                },
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "createdRow": function(row, data, dataIndex) {
                $(row).addClass('row-lov-trn').css({
                    'cursor': 'pointer'
                });
            },
            "order": [],
            "initComplete": function() {
                $('#btn_lov_trn').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                $(document).on('click', '.row-lov-trn', function(e) {
                    notrn = $(this).find('td:eq(0)').html();

                    $('#m_lov_trn').modal('hide');

                    getDataTrn(notrn);
                });
            }
        });
    }

    function getLovIpb() {
        lovipb = $('#table_lov_ipb').DataTable({
            "ajax": currurl + '/get-data-lov-ipb',
            "columns": [{
                    data: 'ipb_noipb',
                    name: 'ipb_noipb'
                },
                {
                    data: 'ipb_tglipb',
                    name: 'ipb_tglipb'
                },
                {
                    data: 'ipb_kodecabang2',
                    name: 'ipb_kodecabang2'
                },
                {
                    data: 'cab_namacabang',
                    name: 'cab_namacabang'
                },
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "createdRow": function(row, data, dataIndex) {
                $(row).addClass('row-lov-ipb').css({
                    'cursor': 'pointer'
                });
            },
            "order": [],
            "initComplete": function() {
                $('#btn_lov_ipb').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                $(document).on('click', '.row-lov-ipb', function(e) {
                    noref = $(this).find('td:eq(0)').html();
                    tglref = $(this).find('td:eq(1)').html();
                    kodecabang = $(this).find('td:eq(2)').html();
                    namacabang = $(this).find('td:eq(3)').html();

                    $('#m_lov_cabang').modal('hide');

                    $('#noref').val(noref);
                    $('#tglref').val(tglref);
                    $('#kodecabang').val(kodecabang);
                    $('#namacabang').val(namacabang);
                });
            }
        });
    }

    function getLovCabang() {
        lovcabang = $('#table_lov_cabang').DataTable({
            "ajax": currurl + '/get-data-lov-cabang',
            "columns": [{
                    data: 'cab_kodecabang',
                    name: 'cab_kodecabang'
                },
                {
                    data: 'cab_kodewilayah',
                    name: 'cab_kodewilayah'
                },
                {
                    data: 'cab_namacabang',
                    name: 'cab_namacabang'
                },
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "createdRow": function(row, data, dataIndex) {
                $(row).addClass('row-lov-cabang').css({
                    'cursor': 'pointer'
                });

                arrCabang.push(data);
            },
            "order": [],
            "initComplete": function() {
                $('#btn_lov_cabang').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                $(document).on('click', '.row-lov-cabang', function(e) {
                    kodecabang = $(this).find('td:eq(0)').html();
                    kodewilayahcabang = $(this).find('td:eq(1)').html();
                    namacabang = $(this).find('td:eq(2)').html();
                    $('#m_lov_cabang').modal('hide');

                    $('#kodecabang').val(kodecabang);
                    $('#namacabang').val(namacabang);
                });

                getLovPlu();
            }
        });
    }

    function getLovPlu() {
        lovplu = $('#table_lov_plu').DataTable({
            "ajax": currurl + '/get-data-lov-plu',
            "columns": [{
                    data: 'prd_prdcd',
                    name: 'prd_prdcd'
                },
                {
                    data: 'prd_deskripsipanjang',
                    name: 'prd_deskripsipanjang'
                },
                {
                    data: 'satuan',
                    name: 'satuan'
                },
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "createdRow": function(row, data, dataIndex) {
                $(row).addClass('row-lov-plu').css({
                    'cursor': 'pointer'
                });
            },
            "order": [],
            "initComplete": function() {
                $('#btn_lov_eks').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                $(document).on('click', '.row-lov-plu', function(e) {
                    prdcd = $(this).find('td:eq(0)').html();

                    $('#m_lov_plu').modal('hide');

                    $('.row-' + currentRow + ' .prdcd').val(prdcd);

                    getDataPlu(prdcd);
                });
            }
        });
    }

    function getLovEks() {
        loveks = $('#table_lov_eks').DataTable({
            "ajax": currurl + '/get-data-ekspedisi',
            "columns": [{
                    data: 'eks_nama',
                    name: 'eks_nama'
                },
                {
                    data: 'eks_alamat',
                    name: 'eks_alamat'
                },
                {
                    data: 'eks_tipe',
                    name: 'eks_tipe'
                },
                {
                    data: 'eks_tarif',
                    name: 'eks_tarif'
                },
                {
                    data: 'eks_tipe_tarif',
                    name: 'eks_tipe_tarif'
                },
                {
                    data: 'eks_durasi',
                    name: 'eks_durasi'
                },
                {
                    data: 'eks_area',
                    name: 'eks_area'
                },
                {
                    data: 'eks_notes',
                    name: 'eks_notes'
                },
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "createdRow": function(row, data, dataIndex) {
                $(row).addClass('row-lov-eks').css({
                    'cursor': 'pointer'
                });
            },
            "order": [],
            "initComplete": function() {
                $(document).on('click', '.row-lov-eks', function(e) {
                    eks_nama = $(this).find('td:eq(0)').html() ? $(this).find('td:eq(0)').html() : '-';
                    eks_alamat = $(this).find('td:eq(1)').html() ? $(this).find('td:eq(1)').html() : '-';
                    eks_tipe = $(this).find('td:eq(2)').html() ? $(this).find('td:eq(2)').html() : '-';
                    eks_tarif = $(this).find('td:eq(3)').html() ? $(this).find('td:eq(3)').html() : '-';
                    eks_tipe_tarif = $(this).find('td:eq(4)').html() ? $(this).find('td:eq(4)').html() : '-';
                    eks_durasi = $(this).find('td:eq(5)').html() ? $(this).find('td:eq(5)').html() : '-';
                    eks_area = $(this).find('td:eq(6)').html() ? $(this).find('td:eq(6)').html() : '-';
                    eks_notes = $(this).find('td:eq(7)').html() ? $(this).find('td:eq(7)').html() : '-';
                    $('#m_lov_ekspedisi').modal('hide');
                    $('.row-' + currentRow + ' .eks_nama').val(eks_nama);
                    $('.row-' + currentRow + ' .eks_alamat').val(eks_alamat);
                    $('.row-' + currentRow + ' .eks_tipe').val(eks_tipe);
                    $('.row-' + currentRow + ' .eks_tarif').val(eks_tarif);
                    $('.row-' + currentRow + ' .eks_tipe_tarif').val(eks_tipe_tarif);
                    $('.row-' + currentRow + ' .eks_durasi').val(eks_durasi);
                    $('.row-' + currentRow + ' .eks_area').val(eks_area);
                    $('.row-' + currentRow + ' .eks_notes').val(eks_notes);

                    console.log(eks_nama, eks_tipe, eks_tarif, eks_tipe_tarif, eks_durasi, eks_area, eks_notes)
                    $('#ekspedisi').val(eks_nama);
                    $('#tarif').val(convertToRupiah(eks_tarif));
                    $('#tipetarif').val(eks_tipe_tarif);
                    $('#durasi').val(eks_durasi + ' hari');
                    $('#catatan').val(eks_notes);
                    $('#alamat').val(eks_alamat);

                    etd = $('#tgletd').val();
                    etd = formatDate((etd.substr(0, 10)));
                    etd = new Date(etd);
                    eta = new Date();
                    duration = parseInt(etd.getDate()) + parseInt(eks_durasi)
                    eta.setDate(duration)
                    var dd = eta.getDate();
                    var mm = eta.getMonth() + 1;
                    var yyyy = eta.getFullYear();
                    if (dd < 10) {
                        dd = '0' + dd;
                    }
                    if (mm < 10) {
                        mm = '0' + mm;
                    }
                    eta = dd + '/' + mm + '/' + yyyy;
                    console.log(eta);
                    eta = $('#tgleta').val(eta);
                    getCabang(eks_area);
                });
            }
        });
    }

    function getCabang(area) {
        $.ajax({
            type: "GET",
            url: currurl + '/get-data-cabang',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                area: area
            },
            beforeSend: function() {
                $('#modal-loader').modal('show');
            },
            success: function(response) {
                $('#modal-loader').modal('hide');
                $('#kodecabangtitip').val(response.data[0].cab_kodecabang);
                $('#namacabangtitip').val(response.data[0].cab_namacabang);
                console.log(response)
            },
            error: function(error) {
                $('#modal-loader').modal('hide');
                // handle error
                swal({
                    title: 'Terjadi kesalahan!',
                    text: error.responseJSON.message,
                    icon: 'error'
                }).then(() => {

                });
            }
        });
    }

    function getPLU(event, index) {
        if (event.which == 13) {
            currentRow = index;

            getDataPlu(convertPlu($('.row-' + currentRow).find('.prdcd').val()));
        }
    }

    function getDataPlu(prdcd) {
        $.ajax({
            type: "GET",
            url: currurl + '/get-data-plu',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                prdcd: prdcd
            },
            beforeSend: function() {
                $('#modal-loader').modal('show');
            },
            success: function(response) {
                $('#modal-loader').modal('hide');

                if (response.length == 0) {
                    swal({
                        title: 'PLU tidak ditemukan!',
                        icon: 'error'
                    }).then(function() {
                        $('.row-' + currentRow).find('.prdcd').select();
                    });
                } else {
                    data[`row-${currentRow}`] = response;
                    row = $('.row-' + currentRow);
                    row.find('.prdcd').val(prdcd);
                    row.find('.deskripsi').val(response.prd_deskripsipendek);
                    row.find('.satuan').val(response.prd_unit + '/' + response.prd_frac);
                    row.find('.tag').val(response.prd_kodetag);

                    if (response.st_avgcost == null || response.st_avgcost == 0) {
                        row.find('.hrgsatuan').val(parseFloat(response.prd_avgcost).toFixed(2));
                    } else {
                        if (response.prd_unit == 'KG')
                            row.find('.hrgsatuan').val(parseFloat(response.st_avgcost).toFixed(2));
                        else row.find('.hrgsatuan').val(parseFloat(response.st_avgcost * response.prd_frac).toFixed(2));
                    }

                    // if(response.prd_flagbkp1 == 'Y')
                    //     row.find('.ppn').val(parseFloat(row.find('.gross').val() * 0).toFixed(2));
                    // else
                    row.find('.ppn').val('0.00');

                    row.find('.sctn').val(parseInt(response.st_saldoakhir / response.prd_frac));
                    row.find('.spcs').val(response.st_saldoakhir % response.prd_frac);

                    row.find('.kctn').val('').select();
                    row.find('.kpcs').val('');
                    row.find('.gross').val('');

                    hitungItem();
                }
            },
            error: function(error) {
                $('#modal-loader').modal('hide');
                // handle error
                swal({
                    title: 'Terjadi kesalahan!',
                    text: error.responseJSON.message,
                    icon: 'error'
                }).then(() => {

                });
            }
        });
    }

    function getDataTrn(notrn) {
        $.ajax({
            type: "GET",
            url: currurl + '/get-data-trn',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                notrn: notrn
            },
            beforeSend: function() {
                $('#modal-loader').modal('show');
            },
            success: function(response) {
                $('#modal-loader').modal('hide');

                if ($.fn.DataTable.isDataTable('#table_daftar')) {
                    $('#table_daftar').DataTable().destroy();
                    $("#table_daftar tbody [role='row']").remove();
                }

                $('#notrn').val(response[0].trbo_nodoc);
                $('#tgltrn').val(response[0].trbo_tgldoc);
                $('#kodecabang').val(response[0].trbo_loc);
                $('#namacabang').val(response[0].cab_namacabang);
                $('#kodegudang').val(response[0].trbo_gdg);

                $('#totalitem').val(response.length);

                gross = 0;
                ppn = 0;

                data = [];

                for (i = 0; i < response.length; i++) {
                    rowIndex++;

                    data['row-' + rowIndex] = response[i];

                    html = `<tr class="row-${rowIndex}" onmouseover="pointerIn(${rowIndex})" onmouseout="pointerOut()">
                                <td><button class="btn btn-sm btn-danger" onclick="hapusItem(${rowIndex})"><i class="fas fa-trash"></i></button></td>
                                <td>
                                    <div class="" style="position: relative">
                                        <input maxlength="7" type="text" class="form-control prdcd" value="${response[i].trbo_prdcd}" onkeypress="getPLU(event,${rowIndex})">
                                        <button type="button" class="btn btn-lov-cabang" data-toggle="modal" data-target="#m_lov_plu" onclick="currentRow = ${i}">
                                            <img src="{{ asset('image/icon/help.png') }}" width="30px">
                                        </button>
                                    </div>
                                </td>
                                <td><input type="text" class="form-control deskripsi" value="${response[i].prd_deskripsipendek}" disabled></td>
                                <td><input type="text" class="form-control satuan" value="${response[i].prd_unit}/${response[i].prd_frac}" disabled></td>
                                <td><input type="text" class="form-control tag" value="${response[i].prd_kodetag}" disabled></td>
                                <td><input type="text" class="form-control sctn" value="${parseInt(response[i].st_saldoakhir / response[i].prd_frac)}" disabled></td>
                                <td><input type="text" class="form-control spcs" value="${response[i].st_saldoakhir % response[i].prd_frac}" disabled></td>
                                <td><input type="text" class="form-control kctn" value="${parseInt(response[i].trbo_qty / response[i].prd_frac)}" onkeyup="hitunghrg(${rowIndex})" onblur="cekqty(${rowIndex})"></td>
                                <td><input type="text" class="form-control kpcs" value="${response[i].trbo_qty % response[i].prd_frac}" onkeyup="hitunghrg(${rowIndex})" onblur="showLKSonBlur(${rowIndex})" onkeypress="showLKS(event, ${rowIndex})"></td>
                                <td><input type="text" class="form-control hrgsatuan" value="${convertToRupiah(response[i].trbo_hrgsatuan)}" disabled></td>
                                <td><input type="text" class="form-control gross" value="${convertToRupiah(response[i].trbo_gross)}"></td>
                                <td><input type="text" class="form-control ppn" value="${convertToRupiah(response[i].trbo_ppnrph)}" disabled></td>
                                <td><input type="text" class="form-control keterangan" value="${nvl(response[i].trbo_keterangan, '')}"></td>
                            </tr>`;

                    $('#table_daftar tbody').append(html);

                    gross += parseFloat(nvl(response[i].trbo_gross, 0));
                    ppn += parseFloat(nvl(response[i].trbo_ppnrph, 0));
                }

                $('#gross').val(convertToRupiah(parseFloat(gross).toFixed(2)));
                $('#ppn').val(convertToRupiah(parseFloat(ppn).toFixed(2)));
                $('#total').val(convertToRupiah(parseFloat(gross + ppn).toFixed(2)));

                // $('#table_daftar tbody tr').hover(pointerIn, pointerOut);

                if (response[0].trbo_flagdoc == '*') {
                    $('#model').val('* NOTA SUDAH DICETAK *');
                    disableField();
                } else {
                    $('#model').val('* KOREKSI *');
                    enableField();
                }

                tabel = $('#table_daftar').DataTable({
                    "scrollY": "40vh",
                    "paging": false,
                    "sort": false,
                    "bInfo": false,
                    "searching": false
                });
            },
            error: function(error) {
                $('#modal-loader').modal('hide');
                // handle error
                swal({
                    title: error.responseJSON.exception,
                    text: error.responseJSON.message,
                    icon: 'error'
                }).then(() => {

                });
            }
        });
    }

    function pointerIn(index) {
        if ($('.row-' + index).find('.prdcd').val() != '') {
            $('#deskripsi').val(data['row-' + index].prd_deskripsipanjang);
        }
        $('#table_daftar tbody tr').removeAttr('style');
        $('#table_daftar_titip tbody tr').removeAttr('style');
        $('.row-' + index).css({
            "background-color": "#acacac",
            "color": "white"
        });
    }

    function pointerOut() {
        // $('#deskripsi').val('');
        // $('#table_daftar tbody tr').removeAttr('style');
    }

    function tambahItem() {
        rowIndex++;
        $('#table_daftar tbody').append(
            `<tr class="row-${rowIndex}" onmouseover="pointerIn(${rowIndex})" onmouseout="pointerOut()">
                <td><button class="btn btn-sm btn-danger" onclick="hapusItem(${rowIndex})"><i class="fas fa-trash"></i></button></td>
                <td><div class="" style="position: relative">
                        <input maxlength="7" type="text" class="form-control prdcd" onkeypress="getPLU(event,${rowIndex})">
                        <button type="button" class="btn btn-lov-plu" data-toggle="modal" data-target="#m_lov_plu" onclick="currentRow = ${rowIndex}">
                            <img src="{{ asset('image/icon/help.png') }}" width="30px">
                        </button>
                    </div></td>
                <td><input type="text" class="form-control deskripsi" disabled></td>
                <td><input type="text" class="form-control satuan" disabled></td>
                <td><input type="text" class="form-control tag" disabled></td>
                <td><input type="text" class="form-control sctn" disabled></td>
                <td><input type="text" class="form-control spcs" disabled></td>
                <td><input type="text" class="form-control kctn" onkeyup="hitunghrg(${rowIndex})" onblur="cekqty(${rowIndex})"></td>
                <td><input type="text" class="form-control kpcs" onkeyup="hitunghrg(${rowIndex})" onblur="showLKSonBlur(${rowIndex})" onkeypress="showLKS(event, ${rowIndex})" onchange="showLKS(event, ${rowIndex})"></td>
                <td><input type="text" class="form-control hrgsatuan" disabled></td>
                <td><input type="text" class="form-control gross"></td>
                <td><input type="text" class="form-control ppn" disabled></td>
                <td><input type="text" class="form-control keterangan"></td>
            </tr>`);

        if (!$.fn.DataTable.isDataTable('#table_daftar')) {
            tabel = $('#table_daftar').DataTable({
                "scrollY": "40vh",
                "paging": false,
                "sort": false,
                "bInfo": false,
                "searching": false
            });
        }
        //
        // $('#table_daftar tbody tr').hover(pointerIn, pointerOut);
    }

    function tambahItemTitip() {
        rowIndex++;
        $('#table_daftar_titip tbody').append(
            `<tr class="row-${rowIndex}" onmouseover="pointerIn(${rowIndex})" onmouseout="pointerOut()">
                <td><button class="btn btn-sm btn-danger" onclick="hapusItem(${rowIndex})"><i class="fas fa-trash"></i></button></td>
                <td><div class="" style="position: relative">
                        <input maxlength="7" type="text" class="form-control prdcd" onkeypress="getPLU(event,${rowIndex})">
                        <button type="button" class="btn btn-lov-plu" data-toggle="modal" data-target="#m_lov_plu" onclick="currentRow = ${rowIndex}">
                            <img src="{{ asset('image/icon/help.png') }}" width="30px">
                        </button>
                    </div></td>
                <td><input type="text" class="form-control deskripsi" disabled></td>
                <td><input type="text" class="form-control satuan" disabled></td>
                <td><input type="text" class="form-control tag" disabled></td>
                <td><input type="text" class="form-control sctn" disabled></td>
                <td><input type="text" class="form-control spcs" disabled></td>
                <td><input type="text" class="form-control kctn" onkeyup="hitunghrg(${rowIndex})" onblur="cekqty(${rowIndex})"></td>
                <td><input type="text" class="form-control kpcs" onkeyup="hitunghrg(${rowIndex})" onblur="showLKSonBlur(${rowIndex})" onkeypress="showLKS(event, ${rowIndex})" onchange="showLKS(event, ${rowIndex})"></td>
                <td><input type="text" class="form-control hrgsatuan" disabled></td>
                <td><input type="text" class="form-control gross"></td>
                <td><input type="text" class="form-control ppn" disabled></td>
                <td><input type="text" class="form-control keterangan"></td>
            </tr>`);

        if (!$.fn.DataTable.isDataTable('#table_daftar_titip')) {
            tabel_titip = $('#table_daftar_titip').DataTable({
                "scrollY": "40vh",
                "paging": false,
                "sort": false,
                "bInfo": false,
                "searching": false
            });
        }
        //
        // $('#table_daftar tbody tr').hover(pointerIn, pointerOut);
    }

    function hapusItem(i) {
        $(`.row-${i}`).remove();
        hitungItem();
    }

    function hitungItem() {
        totalitem = 0;
        $('.prdcd').each(function() {
            if ($(this).val() != '')
                totalitem++;
        });

        $('#totalitem').val(totalitem);
    }

    function showLKSonBlur(index) {
        var e = jQuery.Event("keypress");
        e.which = 13; //choose the one you want

        cekqty(index);
        showLKS(e, index);
    }

    function showLKS(e, index) {
        prdcd = $('.row-' + index).find('.prdcd').val();

        currentRow = index;

        if (e.which == 13 || e.type == 'change') {
            $.ajax({
                type: "GET",
                url: currurl + '/get-data-lks',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    prdcd: prdcd
                    // prdcd: '0000410'
                },
                beforeSend: function() {
                    $('#modal-loader').modal('show');
                },
                success: function(response) {
                    $('#modal-loader').modal('hide');

                    if ($.fn.DataTable.isDataTable('#table_lks')) {
                        $('#table_lks').DataTable().destroy();
                    }

                    $("#table_lks tbody tr").remove();

                    for (i = 0; i < response.length; i++) {
                        html = `<tr>
                                        <td><input type="text" class="form-control lokasi" disabled value="${nvl(response[i].lokasi,'')}"></td>
                                        <td><input type="text" class="form-control" disabled value="${nvl(response[i].qty_ctn,'')}"></td>
                                        <td><input type="text" class="form-control" disabled value="${nvl(response[i].qty_pcs,'')}"></td>
                                        <td><input type="text" class="form-control" disabled value="${nvl(response[i].lks_expdate,'')}"></td>
                                        <td><input type="text" class="form-control" disabled value="${nvl(response[i].lks_maxplano,'')}"></td>
                                        <td><input type="text" class="form-control ctn" value="0" onkeyup="hitunglks(event)"></td>
                                        <td><input type="text" class="form-control pcs" value="0" onkeyup="hitunglks(event)"></td>
                                    </tr>`;

                        $('#table_lks tbody').append(html);
                    }

                    $('#table_lks').DataTable({
                        "scrollY": "30vh",
                        "paging": false,
                        "sort": false,
                        "bInfo": false,
                        "searching": false
                    });

                    $('#lks_nodoc').val($('#notrn').val());
                    $('#lks_prdcd').val(prdcd);

                    frac = parseInt(data['row-' + index].prd_frac);
                    kctn = parseInt($('.row-' + index).find('.kctn').val());
                    kpcs = parseInt($('.row-' + index).find('.kpcs').val());

                    $('#lks_qtytrf').val((frac * kctn) + kpcs);
                    $('#lks_total').val(0);

                    $('#m_lks').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                },
                error: function(error) {

                }
            });
        }
    }

    function hitunglks(e) {
        frac = parseInt(data['row-' + currentRow].prd_frac);

        totalctn = 0;
        totalpcs = 0;

        $('#table_lks .ctn').each(function() {
            totalctn += parseInt(nvl($(this).val(), 0));
        });

        $('#table_lks .pcs').each(function() {
            totalpcs += parseInt(nvl($(this).val(), 0));
        });

        total = (frac * totalctn) + totalpcs;

        if (total > parseInt($('#lks_qtytrf').val())) {
            swal({
                title: 'QTY melebihi!',
                icon: 'error'
            }).then(() => {
                $(e.target).val(0).select();

                totalctn = 0;
                totalpcs = 0;

                $('#table_lks .ctn').each(function() {
                    totalctn += parseInt(nvl($(this).val(), 0));
                });

                $('#table_lks .pcs').each(function() {
                    totalpcs += parseInt(nvl($(this).val(), 0));
                });

                total = (frac * totalctn) + totalpcs;
                $('#lks_total').val(total)
            })
        } else $('#lks_total').val(total);
    }

    $('#m_lks').on('shown.bs.modal', () => {
        // $('#table_lks').DataTable({
        //     "scrollY": "30vh",
        //     "paging" : false,
        //     "sort": false,
        //     "bInfo": false,
        //     "searching": false
        // });

        $('#table_lks .ctn:eq(0)').select();
    });

    function lks_cancel() {
        $.ajax({
            type: "POST",
            url: currurl + '/delete-data-lks',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                nodoc: $('#lks_nodoc').val(),
                prdcd: $('#lks_prdcd').val(),
            },
            beforeSend: function() {
                $('#modal-loader').modal('show');
            },
            success: function(response) {
                $('#modal-loader').modal('hide');

                if (response.status == 'error') {
                    swal({
                        title: 'Terjadi kesalahan!',
                        text: error.responseJSON.message,
                        icon: 'error'
                    });
                } else {
                    $('#m_lks').modal('hide');
                    $('.row-' + currentRow).find('.kpcs').val(0);
                    $('.row-' + currentRow).find('.kctn').val(0).select();

                    hitunghrg(currentRow);
                }
            },
            error: function(error) {
                $('#modal-loader').modal('hide');
                swal({
                    title: 'Terjadi kesalahan!',
                    text: error.responseJSON.message,
                    icon: 'error'
                });
            }
        });
    }

    function lks_ok() {
        if ($('#table_lks tbody tr').length == 0) {
            $('#m_lks').modal('hide');
            $('.row-' + currentRow).find('.gross').select();
        } else if ($('#lks_total').val() != $('#lks_qtytrf').val()) {
            swal({
                title: 'QTY belum sesuai!',
                icon: 'error'
            })
        } else {
            lokasi = [];
            ctn = [];
            pcs = [];
            $('#table_lks tbody tr').each(function() {
                lokasi.push($(this).find('.lokasi').val());
                ctn.push($(this).find('.ctn').val());
                pcs.push($(this).find('.pcs').val());
            });

            $.ajax({
                type: "POST",
                url: currurl + '/save-data-lks',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    nodoc: $('#lks_nodoc').val(),
                    prdcd: $('#lks_prdcd').val(),
                    frac: data['row-' + currentRow].prd_frac,
                    lokasi,
                    ctn,
                    pcs
                },
                beforeSend: function() {
                    $('#modal-loader').modal('show');
                },
                success: function(response) {
                    $('#modal-loader').modal('hide');

                    if (response.status == 'error') {
                        swal({
                            title: 'Terjadi kesalahan!',
                            text: error.responseJSON.message,
                            icon: 'error'
                        });
                    } else {
                        $('#m_lks').modal('hide');
                        $('.row-' + currentRow).find('.gross').select();
                    }
                },
                error: function(error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: 'Terjadi kesalahan!',
                        text: error.responseJSON.message,
                        icon: 'error'
                    });
                }
            });
        }
    }

    $('#notrn').on('keypress', function(e) {
        if (e.which == 13) {
            if ($(this).val().length == 0) {
                swal({
                    title: 'Buat Nomor Surat Jalan Baru?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    if (ok) {
                        $.ajax({
                            type: "GET",
                            url: currurl + '/get-new-no-trn',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                notrn: notrn
                            },
                            beforeSend: function() {
                                $('#modal-loader').modal('show');
                            },
                            success: function(response) {
                                $('#modal-loader').modal('hide');

                                if ($.fn.DataTable.isDataTable('#table_daftar')) {
                                    $('#table_daftar').DataTable().destroy();
                                }

                                $("#table_daftar tbody [role='row']").remove();
                                $('input').val('');
                                rowIndex = 0;
                                data = [];

                                $('#model').val('* TAMBAH *');
                                // $('#table_daftar input').prop('disabled',false);

                                enableField();

                                tambahItem();

                                $('#notrn').val(response);
                                tgltrn.datepicker('setDate', new Date())
                            },
                            error: function(error) {
                                $('#modal-loader').modal('hide');
                                // handle error
                                swal({
                                    title: 'Terjadi kesalahan!',
                                    text: error.responseJSON.message,
                                    icon: 'error'
                                }).then(() => {

                                });
                            }
                        });
                    }
                });
            } else {
                getDataTrn(this.value);
            }
        }
    });

    $('#nosj').on('keypress', function(e) {
        if (e.which == 13) {
            if ($(this).val().length == 0) {
                swal({
                    title: 'Buat Nomor Surat Jalan Baru?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    if (ok) {
                        $.ajax({
                            type: "GET",
                            url: currurl + '/get-new-no-trn',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                notrn: notrn
                            },
                            beforeSend: function() {
                                $('#modal-loader').modal('show');
                            },
                            success: function(response) {
                                $('#modal-loader').modal('hide');

                                if ($.fn.DataTable.isDataTable('#table_daftar_titip')) {
                                    $('#table_daftar_titip').DataTable().destroy();
                                }

                                $("#table_daftar_titip tbody [role='row']").remove();
                                $('input').val('');
                                rowIndex = 0;
                                data = [];

                                $('#model').val('* TAMBAH *');
                                // $('#table_daftar input').prop('disabled',false);

                                enableFieldTitip();

                                tambahItemTitip();

                                $('#nosj').val(response);
                                tgletd.datepicker('setDate', new Date())
                            },
                            error: function(error) {
                                $('#modal-loader').modal('hide');
                                // handle error
                                swal({
                                    title: 'Terjadi kesalahan!',
                                    text: error.responseJSON.message,
                                    icon: 'error'
                                }).then(() => {

                                });
                            }
                        });
                    }
                });
            } else {
                getDataTrn(this.value);
            }
        }
    });

    function hapusTrn() {
        swal({
            title: 'Yakin ingin menghapus data ' + $('#notrn').val() + ' ?',
            icon: 'warning',
            buttons: true,
            dangerMode: true
        }).then((ok) => {
            if (ok) {
                $.ajax({
                    type: "POST",
                    url: currurl + '/delete-trn',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        notrn: $('#notrn').val()
                    },
                    beforeSend: function() {
                        $('#modal-loader').modal('show');
                    },
                    success: function(response) {
                        $('#modal-loader').modal('hide');
                        swal({
                            title: response.title,
                            text: response.message,
                            icon: response.status
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(error) {
                        $('#modal-loader').modal('hide');
                        // handle error
                        swal({
                            title: 'Terjadi kesalahan!',
                            text: error.responseJSON.message,
                            icon: 'error'
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
            }
        });
    }

    function simpanTrn() {
        if ($('#kodecabang').val() == '') {
            swal({
                title: 'Inputan belum lengkap!',
                icon: 'error'
            })
        } else {
            trbo_prdcd = [];
            trbo_qty = [];
            trbo_hrgsatuan = [];
            trbo_gross = [];
            trbo_ppnrph = [];
            trbo_averagecost = [];
            trbo_stokqty = [];
            trbo_keterangan = [];

            $('#table_daftar tbody tr').each(function() {
                idx = $(this).attr('class').replace(/ .*/, '');

                frac = data[idx].prd_frac;

                row = $(this);
                trbo_prdcd.push(convertPlu(row.find('.prdcd').val()));
                trbo_qty.push(frac * row.find('.kctn').val() + parseInt(row.find('.kpcs').val()));
                trbo_hrgsatuan.push(data[idx].prd_avgcost);
                trbo_gross.push(unconvertToRupiah(row.find('.gross').val()));
                trbo_ppnrph.push(unconvertToRupiah(row.find('.ppn').val()));
                trbo_averagecost.push(data[idx].prd_avgcost);
                trbo_stokqty.push(frac * row.find('.sctn').val() + parseInt(row.find('.spcs').val()));
                trbo_keterangan.push(row.find('.keterangan').val());
            });

            $.ajax({
                type: "POST",
                url: currurl + '/save-data-trn',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    nodoc: $('#notrn').val(),
                    tgldoc: $('#tgltrn').val(),
                    loc: $('#kodecabang').val(),
                    trbo_prdcd,
                    trbo_qty,
                    trbo_hrgsatuan,
                    trbo_gross,
                    trbo_ppnrph,
                    trbo_averagecost,
                    trbo_stokqty,
                    trbo_keterangan
                },
                beforeSend: function() {
                    $('#modal-loader').modal('show');
                },
                success: function(response) {
                    $('#modal-loader').modal('hide');

                    swal({
                        title: response.title,
                        text: response.message,
                        icon: response.status
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(error) {

                }
            });
        }
    }

    function simpanTrnTitip() {
        if ($('#kodecabang').val() == '') {
            swal({
                title: 'Inputan belum lengkap!',
                icon: 'error'
            })
        } else {
            trbo_prdcd = [];
            trbo_qty = [];
            trbo_hrgsatuan = [];
            trbo_gross = [];
            trbo_ppnrph = [];
            trbo_averagecost = [];
            trbo_stokqty = [];
            trbo_keterangan = [];

            $('#table_daftar_titip tbody tr').each(function() {
                idx = $(this).attr('class').replace(/ .*/, '');

                frac = data[idx].prd_frac;

                row = $(this);
                trbo_prdcd.push(convertPlu(row.find('.prdcd').val()));
                trbo_qty.push(frac * row.find('.kctn').val() + parseInt(row.find('.kpcs').val()));
                trbo_hrgsatuan.push(data[idx].prd_avgcost);
                trbo_gross.push(unconvertToRupiah(row.find('.gross').val()));
                trbo_ppnrph.push(unconvertToRupiah(row.find('.ppn').val()));
                trbo_averagecost.push(data[idx].prd_avgcost);
                trbo_stokqty.push(frac * row.find('.sctn').val() + parseInt(row.find('.spcs').val()));
                trbo_keterangan.push(row.find('.keterangan').val());
            });

            $.ajax({
                type: "POST",
                url: currurl + '/save-data-trn-titip',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    nodoc: $('#nosj').val(),
                    tgletd: $('#tgletd').val(),
                    tgleta: $('#tgleta').val(),
                    loc: $('#kodecabangtitip').val(),
                    ekspedisi: $('#ekspedisi').val(),
                    seal: $('#seal').val(),
                    durasi: $('#durasi').val(),
                    tarif: $('#tarif').val(),
                    tipetarif: $('#tipetarif').val(),
                    alamat: $('#alamat').val(),
                    catatan: $('#catatan').val(),
                    container: $('#container').val(),
                    kapal: $('#kapal').val(),
                    trbo_prdcd,
                    trbo_qty,
                    trbo_hrgsatuan,
                    trbo_gross,
                    trbo_ppnrph,
                    trbo_averagecost,
                    trbo_stokqty,
                    trbo_keterangan
                },
                beforeSend: function() {
                    $('#modal-loader').modal('show');
                },
                success: function(response) {
                    $('#modal-loader').modal('hide');

                    swal({
                        title: response.title,
                        text: response.message,
                        icon: response.status
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(error) {

                }
            });
        }
    }

    function enableField() {
        $('#table_daftar button').prop('disabled', false);
        $('#btn_tambah').prop('disabled', false);
        $('#btn_simpan').prop('disabled', false);
        $('#btn_hapus').prop('disabled', false);
        $('#notrn').prop('disabled', false);
        $('#tgltrn').prop('disabled', false);
        $('#noreff').prop('disabled', false);
        $('.btn_lov').prop('disabled', false);
        $('#kodecabang').prop('disabled', false);
        $('#kodegudang').prop('disabled', false);
    }

    function enableFieldTitip() {
        $('#table_daftar_titip button').prop('disabled', false);
        $('#btn_tambah_titip').prop('disabled', false);
        $('#btn_simpan_titip').prop('disabled', false);
        $('#btn_hapus_titip').prop('disabled', false);
        $('#nosj').prop('disabled', false);
        $('#tgletd').prop('disabled', false);
    }

    function disableField() {
        $('#table_daftar input').prop('disabled', true);
        $('#table_daftar button').prop('disabled', true);
        $('#btn_tambah').prop('disabled', true);
        $('#btn_simpan').prop('disabled', true);
        $('#btn_hapus').prop('disabled', true);
        $('input').prop('disabled', true);
        $('#notrn').prop('disabled', false);
        $('.btn_lov').prop('disabled', true);
        $('#btn_lov_trn').prop('disabled', false);
    }

    function hitunghrg(index) {
        hrgctn = data['row-' + index].prd_avgcost;
        hrgpcs = hrgctn / data['row-' + index].prd_frac;
        flagbkp = data['row-' + index].prd_flagbkp1;

        row = $('.row-' + index);

        ctn = row.find('.kctn').val();
        pcs = row.find('.kpcs').val();

        hrg = (hrgctn * ctn) + (hrgpcs * pcs);

        row.find('.gross').val(convertToRupiah(parseFloat(hrg).toFixed(2)));

        if (flagbkp == 'Y' && parameterPPN > 0)
            row.find('.ppn').val(parseFloat(hrg + (hrg * parameterPPN)).toFixed(2));
        else row.find('.ppn').val(0.00);

        gross = 0;
        ppn = 0;

        $('.gross').each(function() {
            gross = parseFloat(gross) + parseFloat(unconvertToRupiah($(this).val()));
        });

        $('.ppn').each(function() {
            ppn = parseFloat(ppn) + parseFloat(unconvertToRupiah($(this).val()));
        });

        $('#gross').val(convertToRupiah(parseFloat(gross).toFixed(2)));
        $('#ppn').val(convertToRupiah(parseFloat(ppn).toFixed(2)));
        $('#total').val(convertToRupiah(parseFloat(gross + ppn).toFixed(2)));
    }

    function cekqty(index) {
        row = $('.row-' + index);

        ctn = row.find('.kctn').val();
        pcs = row.find('.kpcs').val();

        if (ctn == '')
            row.find('.kctn').val('0');
        else if (pcs == '')
            row.find('.kpcs').val('0');

        if (ctn + pcs <= 0 && ctn != '' && pcs != '') {
            swal({
                title: 'CTN + PCS <= 0 !',
                icon: 'error'
            }).then(() => {
                row.find('.kctn').select();
            });
        }
    }

    function updateData() {
        $.ajax({
            type: "POST",
            url: currurl,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                parameter1: data1
            },
            beforeSend: function() {

            },
            success: function(response) {

            },
            error: function(error) {

            }
        });
    }

    $('#kodecabang').on('keypress', function(e) {
        if (e.which == 13) {
            found = false;
            $.each(arrCabang, function(key, value) {
                if ($('#kodecabang').val() == value.cab_kodecabang) {
                    $('#namacabang').val(value.cab_namacabang);
                    found = true;
                }
            });

            if (!found) {
                swal({
                    title: 'Cabang yang diinputkan salah!',
                    icon: 'error'
                }).then(() => {
                    $('#kodecabang').select();
                });
            } else $('.row-1 .prdcd').select();
        }
    })

    function toggleTitip() {
        $('#fieldInput').css({
            'display': 'none'
        });
        $('#fieldTitip').css({
            'display': 'block'
        });
        $('#container_table_input').css({
            'display': 'none'
        });
        $('#container_table_titip').css({
            'display': 'block'
        });
        $('#btn_tambah').css({
            'display': 'none'
        });
        $('#btn_tambah_titip').css({
            'display': 'block'
        });
        $('#btn_simpan').css({
            'display': 'none'
        });
        $('#btn_simpan_titip').css({
            'display': 'block'
        });
        $('#dataContainerInput').css({
            'display': 'none'
        });
        $('#dataContainerTitip').css({
            'display': 'block'
        });
    }

    function toggleInput() {
        $('#fieldInput').css({
            'display': 'block'
        });
        $('#fieldTitip').css({
            'display': 'none'
        });
        $('#container_table_input').css({
            'display': 'block'
        });
        $('#container_table_titip').css({
            'display': 'none'
        });
        $('#btn_tambah').css({
            'display': 'block'
        });
        $('#btn_tambah_titip').css({
            'display': 'none'
        });
        $('#btn_simpan').css({
            'display': 'block'
        });
        $('#btn_simpan_titip').css({
            'display': 'none'
        });
        $('#dataContainerInput').css({
            'display': 'block'
        });
        $('#dataContainerTitip').css({
            'display': 'none'
        });
    }

    function toggleAll() {
        $('#fieldInput').css({
            'display': 'block'
        });
        $('#fieldTitip').css({
            'display': 'block'
        });
        $('#container_table_input').css({
            'display': 'block'
        });
        $('#container_table_titip').css({
            'display': 'block'
        });
        $('#btn_tambah').css({
            'display': 'block'
        });
        $('#btn_tambah_titip').css({
            'display': 'block'
        });
        $('#btn_simpan').css({
            'display': 'block'
        });
        $('#btn_simpan_titip').css({
            'display': 'block'
        });
        $('#dataContainerInput').css({
            'display': 'block'
        });
        $('#dataContainerTitip').css({
            'display': 'block'
        });
    }
</script>

@endsection