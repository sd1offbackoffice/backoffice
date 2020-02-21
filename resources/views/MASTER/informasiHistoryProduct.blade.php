@extends('navbar')
@section('content')

    <div class="container">
        <div class="row justify-content-sm-center">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  align="middle" class="w-auto h5 ">KETIKAN PLU / DESKRIPSI /SCAN BARCODE BARANG</legend>
                    <div class="card-body">
                        <div class="row justify-content-md-center">
                            <input type="text" class="col-sm-8 form-control" id="input" placeholder="..." value="">
                            <button type="button" class="btn p-0 text-left" data-toggle="modal" data-target="#m_pluHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-sm-center">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend align="middle" class="w-auto">Informasi & History Product</legend>
                    <div class="card-body">
                        <input type="text" class="col-sm-3 form-control" id="cabang" disabled>
                        <hr>
                        <div class="row">
                            <label for="plu" class="col-sm-2 col-form-label text-right">PLU</label>
                            <input type="text" class="col-sm-2 form-control" id="plu" value="" disabled>
                            <label for="flaggdg" class="col-sm-2 col-form-label text-right">Flag Gdg</label>
                            <input type="text" class="col-sm-1 form-control" id="flaggdg" value="" disabled>
                            <label for="kdcabang" class="col-sm-2 col-form-label text-right">Kd Cabang</label>
                            <input type="text" class="col-sm-1 form-control" id="kdcabang" value="" disabled>
                        </div>
                        <div class="row">
                            <label for="produk" class="col-sm-2 col-form-label text-right">Produk</label>
                            <input type="text" class="col-sm-5 form-control" id="produk" value="" disabled>
                            <label for="kattoko" class="col-sm-2 col-form-label text-right">Kat. Toko</label>
                            <input type="text" class="col-sm-1 form-control" id="kattoko" value="" disabled>
                        </div>
                        <div class="row">
                            <label for="produk" class="col-sm-2 col-form-label text-right">Kat. Brg</label>
                            <input type="text" class="col-sm-5 form-control" id="produk" value="" disabled>
                            <label for="kattoko" class="col-sm-2 col-form-label text-right">Upd.</label>
                            <input type="text" class="col-sm-2 form-control" id="upd" value="" disabled>
                        </div>
                        <br>
                        <div class="row">
                            <table class="table table-sm  justify-content-md-center m-3" id="table-barang">
                                <thead class="thead-dark">
                                <tr >
                                    <th width="3%" class="text-center small">SJ</th>
                                    <th width="7%" class="text-center small">Satuan / Frac</th>
                                    <th width="20%" class="text-center small">Barcode</th>
                                    <th width="10%" class="text-center small">Hg Jual</th>
                                    <th width="10%" class="text-center small">LCost</th>
                                    <th width="10%" class="text-center small">ACost</th>
                                    <th width="10%" class="text-center small">MGN-L</th>
                                    <th width="10%" class="text-center small">MGN-A</th>
                                    <th width="5%" class="text-center small">Tag</th>
                                    <th width="5%" class="text-center small">MinJ</th>
                                    <th width="5%" class="text-center small">BPK</th>
                                    <th width="5%" class="text-center small">BKL</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="card-body p-0">
                                    <table class="table table-sm justify-content-md-center col-sm-12 p-0" id="table-barcode">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center"  colspan="3" scope="colgroup">TREND SALES</th>
                                        </tr>
                                        <tr>
                                            <th width="20%"></th>
                                            <th width="40%" class="text-center small">QTY</th>
                                            <th width="40%"class="text-center small">RUPIAH</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="p-0 text-center" >
                                                JAN
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_qty_01">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_rph_01">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-0 text-center" >
                                                FEB
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_qty_02">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_rph_02">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-0 text-center" >
                                                MAR
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_qty_03">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_rph_03">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-0 text-center" >
                                                APR
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_qty_04">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_rph_04">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-0 text-center" >
                                                MEI
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_qty_05">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_rph_05">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-0 text-center" >
                                                JUN
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_qty_06">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_rph_06">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-0 text-center" >
                                                JUL
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_qty_07">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_rph_07">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-0 text-center" >
                                                AGU
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_qty_08">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_rph_08">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-0 text-center" >
                                                SEP
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_qty_09">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_rph_09">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-0 text-center" >
                                                OKT
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_qty_10">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_rph_10">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-0 text-center" >
                                                NOV
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_qty_11">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_rph_11">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-0 text-center" >
                                                DES
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_qty_12">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled id="sls_rph_12">
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="card-body p-0">
                                    <table class="table table-sm justify-content-md-center p-0" id="table-stock">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center"  colspan="9" scope="colgroup">S T O K</th>
                                        </tr>
                                        <tr class="justify-content-md-center">
                                            <th width="3%" class="text-center small">LOKASI</th>
                                            <th width="10%" class="text-center small">AWAL</th>
                                            <th width="10%" class="text-center small">TERIMA</th>
                                            <th width="10%" class="text-center small">KELUAR</th>
                                            <th width="10%" class="text-center small">SALES</th>
                                            <th width="10%" class="text-center small">RETUR</th>
                                            <th width="10%" class="text-center small">ADJ</th>
                                            <th width="10%" class="text-center small">INSTRST</th>
                                            <th width="10%" class="text-center small">AKHIR</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="justify-content-md-center p-0">
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="lokasi" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="awal" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="terima" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="keluar" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="sales" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="retur" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="adj" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="instrst" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="akhir" disabled>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-body  p-0">
                                    <table class="table table-sm justify-content-md-center p-0" id="table-stock">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center small" style="border: 1px solid;border-bottom: 0px solid" colspan="1" scope="colgroup"></th>
                                            <th class="text-center small" style="border: 1px solid;border-bottom: 0px solid" colspan="1" scope="colgroup"></th>
                                            <th class="text-center small" style="border: 1px solid;border-bottom: 0px solid" colspan="1" scope="colgroup"></th>
                                            <th class="text-center small" style="border: 1px solid;border-bottom: 0px solid" colspan="2" scope="colgroup">PKMT</th>
                                            <th class="text-center small" style="border: 1px solid;border-bottom: 0px solid" colspan="2" scope="colgroup">MINOR</th>
                                            <th class="text-center small" style="border: 1px solid;border-bottom: 0px solid" colspan="2" scope="colgroup">MIN DISPLAY</th>
                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">DSI</th>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">TO</th>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">TOP</th>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">QTY</th>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">TO</th>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">QTY</th>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">TO</th>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">QTY</th>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">TO</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="justify-content-md-center p-0">
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="lokasi" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="awal" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="terima" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="keluar" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="sales" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="retur" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="adj" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="instrst" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" id="akhir" disabled>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="row mr-0">
                                        <label for="mplus" class="col-sm-2 col-form-label text-right">M+</label>
                                        <input type="text" class="col-sm-2 form-control" id="mplus" disabled>
                                        <label for="minory" class="col-sm-6 col-form-label text-right">(PKMT Sudah termasuk M+) MINOR Y</label>
                                        <input type="text" class="col-sm-2 form-control" id="minory"  disabled>
                                    </div>
                                    <div class="row mr-0">
                                        <label for="suppterakhir" class="col-sm-2 col-form-label text-right">Supplier Terakhir</label>
                                        <input type="text" class="col-sm-5 form-control" id="suppterakhir" value="" disabled>
                                    </div>
                                    <div class="row mr-0">
                                        <label for="hargabeli" class="col-sm-2 col-form-label text-right">Harga Beli</label>
                                        <input type="text" class="col-sm-3 form-control" id="hargabeli" value="" disabled>
                                    </div>
                                    <div class="row mr-0">
                                        <label for="avgsales" class="col-sm-2 col-form-label text-right">Average Sales</label>
                                        <input type="text" class="col-sm-3 form-control" id="avgsales" value="" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <table class="table col-sm-8 table-sm justify-content-md-center p-0" id="table-stock">
                                <thead class="thead-dark">
                                <tr>
                                    <th class="text-center" colspan="7" scope="colgroup">FLAG</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="justify-content-md-center p-0">
                                    <td class="p-0">
                                        <input type="text" class="form-control" id="flagnas" value="" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" id="flagigr" value="" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" id="flagidm" value="" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" id="flagomi" value="" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" id="flagbd" value="" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" id="flagobi" value="" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" id="flagdepo" value="" disabled>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="row justify-content-md-center">
                            <button class="btn btn-primary col-sm-1 m-1" id="btn-detailsales" data-toggle="modal" data-target="#m-detailsales">Detail Sales</button>
                            <button class="btn btn-primary  m-1" id="btn-penerimaan"  data-toggle="modal" data-target="#m-penerimaan">Penerimaan</button>
                            <button class="btn btn-primary col-sm-1 m-1" id="btn-pb" data-toggle="modal" data-target="#m-pb">PB</button>
                            <button class="btn btn-primary col-sm-1 m-1" id="btn-so" data-toggle="modal" data-target="#m-so">SO</button>
                            <button class="btn btn-primary col-sm-1 m-1" id="btn-hargabeli" data-toggle="modal" data-target="#m-hargabeli">Harga Beli</button>
                            <button class="btn btn-primary col-sm-1 m-1" id="btn-stockcarton" data-toggle="modal" data-target="#m-stockcarton">Stock Carton</button>
                            <button class="btn btn-primary col-sm-1 m-1" id="btn-cetak" data-toggle="modal" data-target="#m-cetak">Cetak</button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="m_pluHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="search_lov" class="form-control search_lov" type="text" placeholder="Inputkan Deskripsi / PLU Produk" aria-label="Search">
                        <div class="invalid-feedback">
                            Inputkan minimal 3 karakter
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table" id="table_lov">
                                    <thead>
                                    <tr>
                                        <td>Deskripsi</td>
                                        <td>PLU</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($produk as $p)
                                        <tr onclick="lov_select('{{ $p->prd_prdcd }}')" class="row_lov">
                                            <td>{{ $p->prd_deskripsipanjang }}</td>
                                            <td>{{ $p->prd_prdcd }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    {{--MODAL DETAIL SALES--}}
    <div class="modal fade" id="m-detailsales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-scrollable modal-xl"  role="document" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Rekap Trend Sales</h5>
                </div>
                <div class="modal-body" style="height: 650px;">
                    {{--<div class="container">--}}
                    <div class="row">
                        <div class="col">
                            <table class="table table-sm justify-content-md-center p-0 col-sm-12" id="table-detailsales">
                                <thead class="thead-dark">
                                <tr>
                                    <th class="text-center small" style="border: 1px solid;border-bottom: 0px solid" colspan="1" scope="colgroup"></th>
                                    <th class="text-center" style="border: 1px solid;border-bottom: 0px solid" colspan="2" scope="colgroup">INDOGROSIR</th>
                                    <th class="text-center" style="border: 1px solid;border-bottom: 0px solid" colspan="2" scope="colgroup">OMI</th>
                                    <th class="text-center" style="border: 1px solid;border-bottom: 0px solid" colspan="2" scope="colgroup">IDM</th>
                                    <th class="text-center" style="border: 1px solid;border-bottom: 0px solid" colspan="2" scope="colgroup">MEMBER MERAH</th>
                                </tr>
                                <tr>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">BULAN</th>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">QTY</th>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">RUPIAH</th>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">QTY</th>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">RUPIAH</th>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">QTY</th>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">RUPIAH</th>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">QTY</th>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%" class="text-center small">RUPIAH</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="justify-content-md-center p-0">
                                    <td class="p-0 text-center" style="padding-top: .45rem!important;" >
                                        JAN
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" id="awal" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" id="terima" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" id="keluar" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" id="sales" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" id="retur" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" id="adj" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" id="instrst" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" id="akhir" disabled>
                                    </td>
                                </tr>
                                </tbody>
                                <tfoot class="table-secondary">
                                <tr>
                                    <td class="text-center" colspan="2" style="padding-top: .55rem!important;" ><b> Average Sales</b></td>
                                    <td>
                                        <input type="text" class="form-control" id="avgsls-igr" value="123" disabled>
                                    </td>
                                    <td></td>
                                    <td>
                                        <input type="text" class="form-control" id="avgsls-omi" value="123" disabled>
                                    </td>
                                    <td></td>
                                    <td>
                                        <input type="text" class="form-control" id="avgsls-idm" value="123" disabled>
                                    </td>
                                    <td></td>
                                    <td>
                                        <input type="text" class="form-control" id="avgsls-mm" value="123" disabled>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    {{--</div>--}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--MODAL Penerimaan--}}
    <div class="modal fade" id="m-penerimaan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-scrollable modal-xl" style="max-width: 80%" role="document" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Penerimaan</h5>
                </div>
                <div class="modal-body" style="height: 650px;">
                    <div class="row">
                        <div class="col">
                            <table class="table table-sm justify-content-md-center p-0 col-sm-12" id="table-penerimaan">
                                <thead class="thead-dark">
                                <tr>
                                    <th width="30%" class="text-center small">Supplier</th>
                                    <th width="5%" class="text-center small">Qty BPB</th>
                                    <th width="7%" class="text-center small">Bonus 1</th>
                                    <th width="7%" class="text-center small">Bonus 2</th>
                                    <th width="10%" class="text-center small">Dokumen</th>
                                    <th width="13%" class="text-center small">Tanggal</th>
                                    <th width="5%" class="text-center small">Top</th>
                                    <th width="10%" class="text-center small">Last Cost (pcs)</th>
                                    <th width="10%" class="text-center small">Avg Cost (pcs)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="justify-content-md-center p-0">
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--MODAL PB--}}
    <div class="modal fade" id="m-pb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-scrollable modal-xl" style="max-width: 80%" role="document" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5>PB</h5>
                </div>
                <div class="modal-body" style="height: 650px;">
                    <div class="row">
                        <div class="col">
                            <table class="table table-sm justify-content-md-center p-0 col-sm-12" id="table-pb">
                                <thead class="thead-dark">
                                <tr>
                                    <th class="text-center" style="border: 1px solid;border-bottom: 0px solid;border-left: 0px solid" colspan="4" scope="colgroup">PB</th>
                                    <th class="text-center" style="border: 1px solid;border-bottom: 0px solid" colspan="2" scope="colgroup">PO</th>
                                    <th class="text-center" style="border: 1px solid;border-bottom: 0px solid" colspan="2" scope="colgroup">BPB</th>
                                </tr>
                                <tr>
                                    <th width="10%" class="text-center small">Dokumen</th>
                                    <th width="10%" class="text-center small">Tanggal</th>
                                    <th width="5%" class="text-center small">Qty</th>
                                    <th width="15%" class="text-center small">Keterangan</th>
                                    <th width="10%" class="text-center small">Dokumen</th>
                                    <th width="10%" class="text-center small">Tanggal</th>
                                    <th width="5%" class="text-center small">Qty</th>
                                    <th width="15%" class="text-center small">Keterangan</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="justify-content-md-center p-0">
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control" disabled>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--MODAL SO--}}
    <div class="modal fade" id="m-so" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-scrollable modal-xl" style="max-width: 80%" role="document" >
            <div class="modal-content">
                <div class="modal-body" style="height: 800px;">
                    <div class="row">
                        <fieldset class="card border-secondary p-2 col-sm-8">
                            <legend  align="middle" class="w-auto h5 ">Stock Opname Nasional</legend>
                            <div class="row">
                                    <label for="periode-so" class="col-sm-2 col-form-label text-right">Periode SO</label>
                                    <input type="text" class="form-control col-sm-2">
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <table class="table table-sm justify-content-md-center col-sm-12 " id="table-so">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th width="10%" class="text-center small">Qty SO</th>
                                            <th width="10%" class="text-center small">Qty LPP</th>
                                            <th width="5%" class="text-center small">Qty Adj</th>
                                            <th width="15%" class="text-center small">Selisih</th>
                                            <th width="10%" class="text-center small">Avg. Cost</th>
                                            <th width="10%" class="text-center small">-/+ Rupiah</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="justify-content-md-center p-0">
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <label for="keterangan-so" class=" col-form-label">&nbsp;Selisih = Qty SO - Qty LPP - Qty Adjustment</label>

                            <fieldset class="card border-secondary m-2 p-2">
                                <legend  class="w-auto h5 ml-5">Detail Adjustment</legend>
                                <div class="row">
                                    <div class="col my-custom-scrollbar table-wrapper-scroll-y">
                                        <table class="table table-sm justify-content-md-center col-sm-12" id="table-detailadj">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th width="10%" class="text-center small">Seq</th>
                                                <th width="20%" class="text-center small">Qty Adj</th>
                                                <th width="50%" class="text-center small">Keterangan</th>
                                                <th width="20%" class="text-center small">Tanggal Adj</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="justify-content-md-center p-0">
                                                <td class="p-0">
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                                <td class="p-0">
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                                <td class="p-0">
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                                <td class="p-0">
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </fieldset>
                        </fieldset>

                        <div class="col-sm-4">
                            <fieldset class="card border-secondary p-2 ">
                                <legend  align="middle" class="w-auto h5 ">Stock Opname IC</legend>
                                <div class="row">
                                    <div class="col my-custom-scrollbar table-wrapper-scroll-y">
                                        <table class="table table-sm justify-content-md-center col-sm-12 " id="table-soic">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th width="10%" class="text-center small">Tgl SO</th>
                                                <th width="10%" class="text-center small">Kode SO</th>
                                                <th width="5%" class="text-center small">Qty</th>
                                                <th width="10%" class="text-center small">Avg. Cost</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="justify-content-md-center p-0">
                                                <td class="p-0">
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                                <td class="p-0">
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                                <td class="p-0">
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                                <td class="p-0">
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="col-sm-12 text-center p-2">
                                <button class="btn btn-primary btn-lg " id="btn-cetak">Cetak</button>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--MODAL Harga Beli--}}
    <div class="modal fade" id="m-hargabeli" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-scrollable modal-xl" style="max-width: 80%" role="document" >
            <div class="modal-content">
                <div class="modal-body" style="height: 800px;">
                    <fieldset class="card border-secondary col-sm-12">
                        <legend  align="middle" class="w-auto h5">Harga Beli</legend>
                        <div class="row m-1">
                            <label for="supp-terakhir" class="col-sm-2 col-form-label text-right">Supp Terakhir</label>
                            <input type="text" class="form-control col-sm-10" id="hb-supp-terakhir">
                        </div>
                        <div class="row m-1">
                            <label for="plu" class="col-sm-2 col-form-label text-right">PLU</label>
                            <input type="text" class="form-control col-sm-10" id="hb-plu">
                        </div>
                        <div class="row m-1">
                            <label for="status-tag" class="col-sm-2 col-form-label text-right">Status Tag</label>
                            <input type="text" class="form-control col-sm-5" id="hb-status-tag">
                            <label for="satuan-beli" class="col-sm-2 col-form-label text-right">Satuan Beli</label>
                            <input type="text" class="form-control col-sm-3" id="hb-satuan-beli">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">BKP</label>
                            <input type="text" class="form-control col-sm-1" id="hb-bkp">
                            <label class="col-sm-3 col-form-label text-right">Flag Bandrol</label>
                            <input type="text" class="form-control col-sm-1" id="hb-flag-bandrol">
                            <label class="col-sm-2 col-form-label text-right">Harga Omi</label>
                            <input type="text" class="form-control col-sm-3" id="hb-harga-omi">
                        </div>
                    </fieldset>
                    <fieldset class="card border-secondary col-sm-12 mt-2">
                        <div class="row m-1">
                            <label for="supp" class="col-sm-2 col-form-label text-right">Supp</label>
                            <input type="text" class="form-control col-sm-8" id="hb-supp">
                            <label for="plu" class="col-sm-1 col-form-label text-right">PKP</label>
                            <input type="text" class="form-control col-sm-1" id="hb-plu">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">Jenis Harga</label>
                            <input type="text" class="form-control col-sm-3" id="hb-jenis-harga">
                            <label class="col-sm-2 col-form-label text-right">Tgl Berlaku</label>
                            <input type="text" class="form-control col-sm-3" id="hb-tgl-berlaku">
                            <label class="col-sm-1 col-form-label text-right">TOP</label>
                            <input type="text" class="form-control col-sm-1" id="hb-top">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">Harga Beli</label>
                            <input type="text" class="form-control col-sm-3" id="hb-harga-beli">
                            <label class="col-sm-2 col-form-label text-right">Kondisi</label>
                            <input type="text" class="form-control col-sm-3" id="hb-kondisi">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">PPN BM</label>
                            <input type="text" class="form-control col-sm-3" id="hb-ppn-bm">
                            <label class="col-sm-2 col-form-label text-right">PPN</label>
                            <input type="text" class="form-control col-sm-3" id="hb-ppn">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">Botol</label>
                            <input type="text" class="form-control col-sm-3" id="hb-botol">
                            <label class="col-sm-2 col-form-label text-right">Total</label>
                            <input type="text" class="form-control col-sm-3" id="hb-total">
                        </div>
                        <div class="row m-1 mt-2">
                            <label class="col-sm-2 col-form-label text-right">Discount 1 %</label>
                            <input type="text" class="form-control col-sm-1" id="hb-discount-1">
                            <label class="col-sm-1 col-form-label text-right">Rp.</label>
                            <input type="text" class="form-control col-sm-2" id="hb-rp-1">
                            <label class="col-sm-1 col-form-label text-right">Satuan</label>
                            <input type="text" class="form-control col-sm-1" id="hb-satuan">
                            <label class="col-sm-1 col-form-label text-right">Bonus I</label>
                            <input type="text" class="form-control col-sm-1" id="hb-bonus-1">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">Discount 2 %</label>
                            <input type="text" class="form-control col-sm-1" id="hb-discount-2">
                            <label class="col-sm-1 col-form-label text-right">Rp.</label>
                            <input type="text" class="form-control col-sm-2" id="hb-rp-2">
                            <label class="col-sm-1 col-form-label text-right">Periode</label>
                            <input type="text" class="form-control col-sm-3" id="hb-periode-2">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">Discount 2 A %</label>
                            <input type="text" class="form-control col-sm-1" id="hb-discount-2a">
                            <label class="col-sm-1 col-form-label text-right">Rp.</label>
                            <input type="text" class="form-control col-sm-2" id="hb-rp-2a">
                            <label class="col-sm-1 col-form-label text-right">Periode</label>
                            <input type="text" class="form-control col-sm-3" id="hb-periode-2a">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">Discount 2 B %</label>
                            <input type="text" class="form-control col-sm-1" id="hb-discount-2b">
                            <label class="col-sm-1 col-form-label text-right">Rp.</label>
                            <input type="text" class="form-control col-sm-2" id="hb-rp-2b">
                            <label class="col-sm-1 col-form-label text-right">Periode</label>
                            <input type="text" class="form-control col-sm-3" id="hb-periode-2b">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">Discount 3 %</label>
                            <input type="text" class="form-control col-sm-1" id="hb-discount-3">
                            <label class="col-sm-1 col-form-label text-right">Rp.</label>
                            <input type="text" class="form-control col-sm-2" id="hb-rp-3">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-3 col-form-label text-right">Discount 4: &nbsp; No. Return %</label>
                            <input type="text" class="form-control col-sm-1" id="hb-no-return">
                            <label class="col-sm-1 col-form-label text-right">Rp.</label>
                            <input type="text" class="form-control col-sm-2" id="hb-rp-no-return">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-3 col-form-label text-right">Cash Discount %</label>
                            <input type="text" class="form-control col-sm-1" id="hb-cash-discount">
                            <label class="col-sm-1 col-form-label text-right">Rp.</label>
                            <input type="text" class="form-control col-sm-2" id="hb-rp-cash-discount">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-3 col-form-label text-right">Distribution Fee</label>
                            <input type="text" class="form-control col-sm-1" id="hb-distribution-fee">
                            <label class="col-sm-1 col-form-label text-right">Rp.</label>
                            <input type="text" class="form-control col-sm-2" id="hb-rp-distribution-fee">
                            <label class="col-sm-1 col-form-label text-right">Total</label>
                            <input type="text" class="form-control col-sm-2" id="hb-total">
                        </div>
                        <div class="row m-1 mt-3">
                            <label class="col-sm-2 col-form-label text-right">Bonus Kelipatan</label>
                            <input type="text" class="form-control col-sm-1" id="hb-bonus-kelipatan">
                            <label class="col-sm-2 col-form-label text-right">Periode</label>
                            <input type="text" class="form-control col-sm-2" id="hb-rp-3">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">QTY BELI --> #1</label>
                            <input type="text" class="form-control col-sm-2" id="hb-qty-beli1">
                            <label class="col-sm-1 col-form-label text-right">#2</label>
                            <input type="text" class="form-control col-sm-2" id="hb-qty-beli2">
                            <label class="col-sm-1 col-form-label text-right">#3</label>
                            <input type="text" class="form-control col-sm-2" id="hb-qty-beli3">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">QTY BNS --> #1</label>
                            <input type="text" class="form-control col-sm-2" id="hb-qty-bns1">
                            <label class="col-sm-1 col-form-label text-right">#2</label>
                            <input type="text" class="form-control col-sm-2" id="hb-qty-bns2">
                            <label class="col-sm-1 col-form-label text-right">#3</label>
                            <input type="text" class="form-control col-sm-2" id="hb-qty-bns3">
                        </div>
                    </fieldset>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"><<< PREV </button>
                    <button type="button" class="btn btn-secondary">NEXT >>></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--MODAL Stock Carton--}}
    <div class="modal fade" id="m-stockcarton" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-scrollable modal"  role="document" >
            <div class="modal-content" style="max-height: 50%;">
                <div class="modal-header">
                    <h5>Stock Carton</h5>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" id="stock-akhir-satuan-carton" disabled>
                    <div class="row">
                        <table class="table table-sm justify-content-md-center m-2" id="table-stockcarton">
                            <thead class="thead-dark">
                            <tr>
                                <th class="text-center small">Status Barang</th>
                                <th class="text-center small">Carton</th>
                                <th class="text-center small">Pcs</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="justify-content-md-center p-0">
                                <td class="p-0">
                                    <input type="text" class="form-control" disabled>
                                </td>
                                <td class="p-0">
                                    <input type="text" class="form-control" disabled>
                                </td>
                                <td class="p-0">
                                    <input type="text" class="form-control" disabled>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--LOADING--}}
    <div class="modal fade" id="modal-loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="vertical-align: middle;">
        <div class="modal-dialog modal-dialog-centered" role="document" >
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="loader" id="loader"></div>
                            <div class="col-sm-12">
                                <label for="">LOADING...</label>
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
        label {
            color: #232443;
            /*color: #8A8A8A;*/
            font-weight: bold;
        }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }
        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .my-custom-scrollbar {
            position: relative;
            height: 300px;
            overflow-x: hidden;
            overflow-y: scroll;
        }
        .table-wrapper-scroll-y {
            display: block;
        }
        .row_lov:hover{
            cursor: pointer;
            background-color: grey;
            color: white;
        }
    </style>

    <script>
        $(document).ready(function () {
            // $('#table_penerimaan').DataTable({
            //     "lengthChange": false,
            //     "pageLength": 15
            // });
            $('#input').focus();
        });
        month = ['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGU','SEP','OKT','NOV','DES'];

        $('#input').keypress(function(e) {
            if (e.keyCode == 13) {
                plu = convertPlu($(this).val());
                $(this).val(plu);
            }
        });

        function get_data(value) {
            $.ajax({
                url: '/BackOffice/public/mstjenisitem/lov_select',
                type:'POST',
                data:{"_token":"{{ csrf_token() }}",value: value},
                beforeSend: function(){
                    $('#m_pluHelp').modal('hide');
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function(response){
                    console.log(response);
                    $('#i_pluplanogram').val(value);
                    $('#i_deskripsi').val(response['produk']['prd_deskripsipanjang']);
                    $('#i_unitfrac').val(response['produk']['prd_unit']+'/'+response['produk']['prd_frac']);
                    $('#i_maxpalet').val(response['palet']['mpt_maxqty']);
                    $('#sls_qty_01').val(format_currency(response['trendsales']['sls_qty_01']));
                    $('#sls_qty_02').val(format_currency(response['trendsales']['sls_qty_02']));
                    $('#sls_qty_03').val(format_currency(response['trendsales']['sls_qty_03']));
                    $('#sls_qty_04').val(format_currency(response['trendsales']['sls_qty_04']));
                    $('#sls_qty_05').val(format_currency(response['trendsales']['sls_qty_05']));
                    $('#sls_qty_06').val(format_currency(response['trendsales']['sls_qty_06']));
                    $('#sls_qty_07').val(format_currency(response['trendsales']['sls_qty_07']));
                    $('#sls_qty_08').val(format_currency(response['trendsales']['sls_qty_08']));
                    $('#sls_qty_09').val(format_currency(response['trendsales']['sls_qty_09']));
                    $('#sls_qty_10').val(format_currency(response['trendsales']['sls_qty_10']));
                    $('#sls_qty_11').val(format_currency(response['trendsales']['sls_qty_11']));
                    $('#sls_qty_12').val(format_currency(response['trendsales']['sls_qty_12']));
                    $('#sls_rph_01').val(format_currency(response['trendsales']['sls_rph_01']));
                    $('#sls_rph_02').val(format_currency(response['trendsales']['sls_rph_02']));
                    $('#sls_rph_03').val(format_currency(response['trendsales']['sls_rph_03']));
                    $('#sls_rph_04').val(format_currency(response['trendsales']['sls_rph_04']));
                    $('#sls_rph_05').val(format_currency(response['trendsales']['sls_rph_05']));
                    $('#sls_rph_06').val(format_currency(response['trendsales']['sls_rph_06']));
                    $('#sls_rph_07').val(format_currency(response['trendsales']['sls_rph_07']));
                    $('#sls_rph_08').val(format_currency(response['trendsales']['sls_rph_08']));
                    $('#sls_rph_09').val(format_currency(response['trendsales']['sls_rph_09']));
                    $('#sls_rph_10').val(format_currency(response['trendsales']['sls_rph_10']));
                    $('#sls_rph_11').val(format_currency(response['trendsales']['sls_rph_11']));
                    $('#sls_rph_12').val(format_currency(response['trendsales']['sls_rph_12']));

                    $('.baris').remove();
                    for (var i = 0; i < response['po'].length ; i++ ){
                        $('#table-po').append('<tr class="row baris justify-content-md-center p-0"> <td class="col-sm-4 p-0 text-center" > <input type="text" class="form-control" disabled value="'+response['po'][i].tpoh_nopo+'"> </td> <td class="col-sm-5 p-0"><input type="text" class="form-control" disabled value="'+toDate(response['po'][i].tpoh_tglpo.substr(0,10))+'"> </td> <td class="col-sm-3 p-0"><input type="text" class="form-control" disabled  value="'+response['po'][i].tpod_qtypo+'"></td></tr>');
                    }
                    for (var i = 0; i < response['lokasi'].length ; i++ ){
                        $('#table-lokasi-plu').append('<tr class="row baris justify-content-md-center p-0"><td class="col-sm-4 p-0 text-center" ><input type="text" class="form-control" disabled value="'+response['lokasi'][i].lks_koderak+'.'+response['lokasi'][i].lks_kodesubrak+'.'+response['lokasi'][i].lks_tiperak+'.'+response['lokasi'][i].lks_shelvingrak+'.'+response['lokasi'][i].lks_nourut+'"></td><td class="col-sm-2 p-0"><input type="text" class="form-control" disabled value="'+response['lokasi'][i].lks_jenisrak+'"></td><td class="col-sm-2 p-0"><input type="text" class="form-control" disabled value="'+response['lokasi'][i].lks_qty+'"></td><td class="col-sm-2 p-0"><input type="text" class="form-control" disabled value="'+response['lokasi'][i].lks_maxplano+'"></td><td class="col-sm-2 p-0"><input type="text" class="form-control" disabled value="'+response['lokasi'][i].lks_maxdisplay+'"></td></tr>');
                    }
                    $('#lokasi').val(format_currency(response['prodstock'].st_lokasi));
                    $('#awal').val(format_currency(response['prodstock'].st_saldoawal));
                    $('#terima').val(format_currency(response['prodstock'].st_trfin));
                    $('#keluar').val(format_currency(response['prodstock'].st_trfout));
                    $('#sales').val(format_currency(response['prodstock'].st_sales));
                    $('#retur').val(format_currency(response['prodstock'].st_retur));
                    $('#adj').val(format_currency(response['prodstock'].st_adj));
                    $('#instrst').val(format_currency(response['prodstock'].st_intransit));
                    $('#akhir').val(format_currency(response['prodstock'].st_saldoakhir));
                    $('#avgsales').val(format_currency(response['AVGSALES']));

                    $('#table_penerimaan').DataTable().clear();

                    for (var i = 0; i < response['supplier'].length ; i++ ){
                        $('#table_penerimaan').DataTable().row.add(
                            [response['supplier'][i].trm_supp,
                                format_currency(response['supplier'][i].trm_qtybns),
                                response['supplier'][i].trm_bonus,
                                response['supplier'][i].trm_bonus2,
                                response['supplier'][i].trm_dokumen,
                                response['supplier'][i].trm_tanggal,
                                response['supplier'][i].trm_top,
                                response['supplier'][i].trm_hpp,
                                format_currency(response['supplier'][i].trm_acost)
                            ]).draw();
                    }
                    null_check();
                },
                complete: function(){
                    if($('#m_pluHelp').is(':visible')){
                        $('#search_lov').val('');
                        $('#table_lov .row_lov').remove();
                        $('#table_lov').append(trlov);
                    }
                    $('#modal-loader').modal('hide');
                }
            });
        }
        var trlov = $('#table_lov tbody').html();

        function lov_select(value){
            get_data(value);
        }

        $('#search_lov').keypress(function (e) {
            if (e.which == 13) {
                if(this.value.length == 0) {
                    $('#table_lov .row_lov').remove();
                    $('#table_lov').append(trlov);
                    $('.invalid-feedback').hide();
                }
                else if(this.value.length >= 3) {
                    $('.invalid-feedback').hide();
                    $.ajax({
                        url: '/BackOffice/public/mstjenisitem/lov_search',
                        type: 'POST',
                        data: {"_token": "{{ csrf_token() }}", value: this.value.toUpperCase()},
                        success: function (response) {
                            $('#table_lov .row_lov').remove();
                            html = "";
                            console.log(response.length);
                            for (i = 0; i < response.length; i++) {
                                html = '<tr class="row_lov" onclick=lov_select("' + response[i].prd_prdcd + '")><td>' + response[i].prd_deskripsipanjang + '</td><td>' + response[i].prd_prdcd + '</td></tr>';
                                trlov += html;
                                $('#table_lov').append(html);
                            }
                        }
                    });
                }
                else{
                    $('.invalid-feedback').show();
                }
            }
        });


        function save() {
            $('#l_jenisrak').css("color", "black");

            if( $('#i_jenisrak').val()!='D' && $('#i_jenisrak').val()!='N'){
                $('#i_jenisrak').val("");
                $('#i_jenisrak').select();
                $('#l_jenisrak').css("color", "red");
            }
            else {
                var prdcd = $('#i_pluplanogram').val();
                var jenisrak = $('#i_jenisrak').val();
                var prdcd = $('#i_pluplanogram').val();
                $.ajax({
                    url: '/BackOffice/public/mstjenisitem/savedata',
                    type: 'POST',
                    data: {"_token": "{{ csrf_token() }}", prdcd:prdcd,jenisrak:jenisrak},
                    success: function (response) {
                        console.log(response);
                        swal({
                            title: response['message'],
                            icon: response['status']
                        }).then((createData) => {
                            if (createData) {

                            }
                        });
                    }
                });

            }
        }
        function format_currency(value) {
            var val = (value/1).toFixed(2).replace('.', ',');
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        function toDate(value) {
            date = new Date(value);
            return date.getDate() + '-' + month[date.getMonth()] + '-' + date.getFullYear();
        }
        function null_check() {
            $("input:text").each(function(){
                var $this = $(this);
                if($this.val()=="null"){
                    $this.val("0");
                }
            });
        }
    </script>

@endsection

