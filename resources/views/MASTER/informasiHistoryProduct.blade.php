@extends('navbar')
@section('title','MASTER | INFORMASI HISTORY PRODUCT')
@section('content')

    <div class="container-fluid page1">
        <div class="row justify-content-sm-center">
            <div class="col-sm-12">
                <fieldset class="card border-dark card-hdr cardForm">
                    <legend class="w-auto ml-5">{{$_SESSION['connection']}} Ketik PLU / Deskripsi / Scan Barcode
                        Barang
                    </legend>
                    <div class="card-body">
                        <div class="row justify-content-md-center">
                            <div class="col-sm-8 buttonInside">
                                <input type="text" class="form-control" id="input" placeholder="..." value="">
                                <button id="btn-no-doc" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                        data-target="#m_plu">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="container-fluid page2">
        <div class="row justify-content-sm-center">
            <div class="col-sm-12">
                <fieldset class="card border-secondary card-hdr ">
                    <legend class="w-auto ml-5">Informasi & History Product</legend>
                    <div class="card-body">
                        <div class="row mr-2">
                            <input type="text" class="col-sm-3 form-control" id="cabang" disabled>
                            {{--                            <label for="plu" class="offset-5 col-sm-1 col-form-label text-center">= Promosi =</label>--}}
                        </div>
                        <hr>
                        <div class="row mr-2">
                            <label for="plu" class="col-sm-1 col-form-label text-right">PLU</label>
                            <input type="text" class="col-sm-1 form-control" id="plu" value="" disabled>
                            <label for="flaggdg" class="col-sm-2 col-form-label text-right">Flag Gdg</label>
                            <input type="text" class="col-sm-1 form-control" id="flaggdg" value="" disabled>
                            <label for="kdcabang" class="col-sm-1 col-form-label text-right">Kd Cabang</label>
                            <input type="text" class="col-sm-1 form-control" id="kdcabang" value="" disabled>
                            {{--                            <input type="text" class="offset-1 col-sm-1 form-control" id="promosi" value="" disabled>--}}
                            <label for="tglprm" class="offset-2 col-sm-1 col-form-label text-right promo">Tgl
                                Prm</label>
                            <input type="text" class="col-sm-2 form-control promo" id="tglpromo" value="" disabled>
                        </div>
                        <div class="row mr-2">
                            <label for="produk" class="col-sm-1 col-form-label text-right">Produk</label>
                            <input type="text" class="col-sm-3 form-control" id="produk" value="" disabled>
                            <label for="kattoko" class="col-sm-2 col-form-label text-right">Kat. Toko</label>
                            <input type="text" class="col-sm-1 form-control" id="kattoko" value="" disabled>
                            <label for="jamprm" class="offset-2 col-sm-1 col-form-label text-right promo">Jam
                                Prm</label>
                            <input type="text" class="col-sm-2 form-control promo" id="jampromo" value="" disabled>
                        </div>
                        <div class="row mr-2">
                            <label for="kat-barang" class="col-sm-1 col-form-label text-right">Kat.Brg</label>
                            <input type="text" class="col-sm-3 form-control" id="katbarang" value="" disabled>
                            <label for="upd" class="col-sm-2 col-form-label text-right">Upd.</label>
                            <input type="text" class="col-sm-2 form-control" id="upd" value="" disabled>
                            <label for="hrgpromo" class="col-sm-2 col-form-label text-right promo">Hrg. Promo</label>
                            <input type="text" class="col-sm-2 form-control promo" id="hrgpromo" value="" disabled>
                        </div>
                        <br>
                        <div class="row">
                            <table class="table table-sm  justify-content-md-center m-3" id="table-satuan">
                                <thead class="theadDataTables">
                                <tr>
                                    <th width="3%" class="text-center small">SJ</th>
                                    <th width="7%" class="text-center small">Satuan / Frac</th>
                                    <th class="text-center small">Barcode</th>
                                    <th width="9%" class="text-center small">Hg Jual</th>
                                    <th width="9%" class="text-center small">LCost</th>
                                    <th width="9%" class="text-center small">ACost</th>
                                    <th width="6%" class="text-center small">MGN-L</th>
                                    <th width="6%" class="text-center small">MGN-A</th>
                                    <th width="3%" class="text-center small">Tag</th>
                                    <th width="3%" class="text-center small">MinJ</th>
                                    <th width="3%" class="text-center small">BPK</th>
                                    <th width="3%" class="text-center small">BKL</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="baris">
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
                            <div class="col-sm-4">
                                <div class="card-body p-0">
                                    <table class="table table-sm justify-content-md-center col-sm-12 p-0"
                                           id="table-trendsales">
                                        <thead class="theadDataTables">
                                        <tr>
                                            <th class="text-center" colspan="3" scope="colgroup">TREND SALES</th>
                                        </tr>
                                        <tr>
                                            <th width="20%"></th>
                                            <th width="40%" class="text-center small">QTY</th>
                                            <th width="40%" class="text-center small">RUPIAH</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="baris">
                                            <td class="p-0 text-center">
                                                JAN
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_qty_01">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_rph_01">
                                            </td>
                                        </tr>
                                        <tr class="baris">
                                            <td class="p-0 text-center">
                                                FEB
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_qty_02">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_rph_02">
                                            </td>
                                        </tr>
                                        <tr class="baris">
                                            <td class="p-0 text-center">
                                                MAR
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_qty_03">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_rph_03">
                                            </td>
                                        </tr>
                                        <tr class="baris">
                                            <td class="p-0 text-center">
                                                APR
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_qty_04">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_rph_04">
                                            </td>
                                        </tr>
                                        <tr class="baris">
                                            <td class="p-0 text-center">
                                                MEI
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_qty_05">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_rph_05">
                                            </td>
                                        </tr>
                                        <tr class="baris">
                                            <td class="p-0 text-center">
                                                JUN
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_qty_06">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_rph_06">
                                            </td>
                                        </tr>
                                        <tr class="baris">
                                            <td class="p-0 text-center">
                                                JUL
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_qty_07">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_rph_07">
                                            </td>
                                        </tr>
                                        <tr class="baris">
                                            <td class="p-0 text-center">
                                                AGU
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_qty_08">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_rph_08">
                                            </td>
                                        </tr>
                                        <tr class="baris">
                                            <td class="p-0 text-center">
                                                SEP
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_qty_09">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_rph_09">
                                            </td>
                                        </tr>
                                        <tr class="baris">
                                            <td class="p-0 text-center">
                                                OKT
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_qty_10">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_rph_10">
                                            </td>
                                        </tr>
                                        <tr class="baris">
                                            <td class="p-0 text-center">
                                                NOV
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_qty_11">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_rph_11">
                                            </td>
                                        </tr>
                                        <tr class="baris">
                                            <td class="p-0 text-center">
                                                DES
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_qty_12">
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class=" form-control text-right" disabled
                                                       id="sls_rph_12">
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="card-body p-0">
                                    <table class="table table-sm justify-content-md-center p-0" id="table-stock">
                                        <thead class="theadDataTables">
                                        <tr>
                                            <th class="text-center" colspan="10" scope="colgroup">S T O K</th>
                                        </tr>
                                        <tr class="justify-content-md-center">
                                            <th width="10%" class="text-center small">LOKASI</th>
                                            <th width="10%" class="text-center small">AWAL</th>
                                            <th width="10%" class="text-center small">TERIMA</th>
                                            <th width="10%" class="text-center small">KELUAR</th>
                                            <th width="10%" class="text-center small">SALES</th>
                                            <th width="10%" class="text-center small">RETUR</th>
                                            <th width="10%" class="text-center small">ADJ</th>
                                            <th width="10%" class="text-center small">INSTRST</th>
                                            <th width="10%" class="text-center small">SO</th>
                                            <th width="10%" class="text-center small">AKHIR</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="justify-content-md-center p-0 baris">
                                            <td class="p-0">
                                                <input type="text" class="form-control" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" disabled>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-body  p-0">
                                    <table class="table table-sm justify-content-md-center p-0" id="table-stock">
                                        <thead class="theadDataTables">
                                        <tr>
                                            <th class="text-center small"
                                                style="border: 1px solid;border-bottom: 0px solid" colspan="1"
                                                scope="colgroup"></th>
                                            <th class="text-center small"
                                                style="border: 1px solid;border-bottom: 0px solid" colspan="1"
                                                scope="colgroup"></th>
                                            <th class="text-center small"
                                                style="border: 1px solid;border-bottom: 0px solid" colspan="1"
                                                scope="colgroup"></th>
                                            <th class="text-center small"
                                                style="border: 1px solid;border-bottom: 0px solid" colspan="2"
                                                scope="colgroup">PKMT
                                            </th>
                                            <th class="text-center small"
                                                style="border: 1px solid;border-bottom: 0px solid" colspan="2"
                                                scope="colgroup">MINOR
                                            </th>
                                            <th class="text-center small"
                                                style="border: 1px solid;border-bottom: 0px solid" colspan="2"
                                                scope="colgroup">MIN DISPLAY
                                            </th>
                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                                class="text-center small">DSI
                                            </th>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                                class="text-center small">TO
                                            </th>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                                class="text-center small">TOP
                                            </th>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                                class="text-center small">QTY
                                            </th>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                                class="text-center small">TO
                                            </th>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                                class="text-center small">QTY
                                            </th>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                                class="text-center small">TO
                                            </th>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                                class="text-center small">QTY
                                            </th>
                                            <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                                class="text-center small">TO
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="justify-content-md-center p-0">
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" id="dsi" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" id="to" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" id="top" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" id="pkmtqty"
                                                       disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" id="pkmtto" disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" id="minorqty"
                                                       disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" id="minorto"
                                                       disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" id="mindisqty"
                                                       disabled>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control text-right" id="mindisto"
                                                       disabled>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="row mr-0">
                                        <label for="mplus" class="col-sm-2 col-form-label text-right">M+</label>
                                        <input type="text" class="col-sm-2 form-control text-right" id="mplus" disabled>
                                        <label for="minory" class="col-sm-6 col-form-label text-right">(PKMT Sudah
                                            termasuk M+) MINOR Y</label>
                                        <input type="text" class="col-sm-2 form-control text-right" id="minory"
                                               disabled>
                                    </div>
                                    <div class="row mr-0">
                                        <label for="suppterakhir" class="col-sm-2 col-form-label text-right">Supplier
                                            Terakhir</label>
                                        <input type="text" class="col-sm-6 form-control" id="suppterakhir" value=""
                                               disabled>
                                    </div>
                                    <div class="row mr-0">
                                        <label for="hargabeli" class="col-sm-2 col-form-label text-right">Harga
                                            Beli</label>
                                        <input type="text" class="col-sm-3 form-control text-right" id="hargabeli"
                                               value="" disabled>
                                    </div>
                                    <div class="row mr-0">
                                        <label for="avgsales" class="col-sm-2 col-form-label text-right">Average
                                            Sales</label>
                                        <input type="text" class="col-sm-3 form-control text-right" id="avgsales"
                                               value="" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <label class=" col-sm-2 justify-content-md-center p-0" for="" id="item"></label>
                            <table class="table col-sm-8 table-sm justify-content-md-center p-0" id="table-stock">
                                <thead class="theadDataTables">
                                <tr>
                                    <th class="text-center" colspan="7" scope="colgroup">FLAG</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="justify-content-md-center p-0">
                                    <td class="p-0">
                                        <input type="text" class="form-control text-center text-danger" id="flagnas"
                                               value="" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control text-center text-danger" id="flagigr"
                                               value="" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control text-center text-danger" id="flagidm"
                                               value="" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control text-center text-danger" id="flagomi"
                                               value="" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control text-center text-danger" id="flagbrd"
                                               value="" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control text-center text-danger" id="flagobi"
                                               value="" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" class="form-control text-center text-danger" id="flagdepo"
                                               value="" disabled>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="row justify-content-md-center">
                            <button class="btn btn-primary col-sm-1 m-1" id="btn-detailsales" data-toggle="modal"
                                    data-target="#m-detailsales">Detail Sales
                            </button>
                            <button class="btn btn-primary m-1" id="btn-penerimaan" data-toggle="modal"
                                    data-target="#m-penerimaan">Penerimaan
                            </button>
                            <button class="btn btn-primary col-sm-1 m-1" id="btn-pb" data-toggle="modal"
                                    data-target="#m-pb">PB
                            </button>
                            <button class="btn btn-primary col-sm-1 m-1" id="btn-so" data-toggle="modal"
                                    data-target="#m-so">SO
                            </button>
                            <button class="btn btn-primary col-sm-1 m-1" id="btn-hargabeli" data-toggle="modal"
                                    data-target="#m-hargabeli">Harga Beli
                            </button>
                            <button class="btn btn-primary col-sm-1 m-1" id="btn-stockcarton" data-toggle="modal"
                                    data-target="#m-stockcarton">Stock Carton
                            </button>
                            <button class="btn btn-primary col-sm-1 m-1" id="btn-cetak">Cetak
                            </button>
                            <button class="btn btn-primary col-sm-1 m-1" id="btn-keluar">Keluar
                            </button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="m_plu" tabindex="-1" role="dialog" aria-labelledby="m_template" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">List Prodmast</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalPLU">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>PLU</th>
                                        <th>Nama Produk</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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

    {{--MODAL DETAIL SALES--}}
    <div class="modal fade" id="m-detailsales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Rekap Trend Sales</h5>
                </div>
                <div class="modal-body" style="height: 650px;">
                    {{--<div class="container">--}}
                    <div class="row">
                        <div class="col">
                            <table class="table table-sm justify-content-md-center p-0 col-sm-12"
                                   id="table-detailsales">
                                <thead class="theadDataTables">
                                <tr>
                                    <th class="text-center small" style="border: 1px solid;border-bottom: 0px solid"
                                        colspan="1" scope="colgroup"></th>
                                    <th class="text-center" style="border: 1px solid;border-bottom: 0px solid"
                                        colspan="2" scope="colgroup">INDOGROSIR
                                    </th>
                                    <th class="text-center" style="border: 1px solid;border-bottom: 0px solid"
                                        colspan="2" scope="colgroup">OMI
                                    </th>
                                    <th class="text-center" style="border: 1px solid;border-bottom: 0px solid"
                                        colspan="2" scope="colgroup">IDM
                                    </th>
                                    <th class="text-center" style="border: 1px solid;border-bottom: 0px solid"
                                        colspan="2" scope="colgroup">MEMBER MERAH
                                    </th>
                                </tr>
                                <tr>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                        class="text-center small">BULAN
                                    </th>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                        class="text-center small">QTY
                                    </th>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                        class="text-center small">RUPIAH
                                    </th>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                        class="text-center small">QTY
                                    </th>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                        class="text-center small">RUPIAH
                                    </th>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                        class="text-center small">QTY
                                    </th>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                        class="text-center small">RUPIAH
                                    </th>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                        class="text-center small">QTY
                                    </th>
                                    <th style="border: 1px solid;border-top: 0px solid" width="11%"
                                        class="text-center small">RUPIAH
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="justify-content-md-center p-0 baris">
                                    <td class="p-0 text-center" style="padding-top: .45rem!important;">
                                        JAN
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
                                <tfoot class="table-secondary">
                                <tr>
                                    <td class="text-center" colspan="2" style="padding-top: .55rem!important;"><b>
                                            Average Sales</b></td>
                                    <td>
                                        <input type="text" class="form-control text-right" id="avgsls-igr" value=""
                                               disabled>
                                    </td>
                                    <td></td>
                                    <td>
                                        <input type="text" class="form-control text-right" id="avgsls-omi" value=""
                                               disabled>
                                    </td>
                                    <td></td>
                                    <td>
                                        <input type="text" class="form-control text-right" id="avgsls-idm" value=""
                                               disabled>
                                    </td>
                                    <td></td>
                                    <td>
                                        <input type="text" class="form-control text-right" id="avgsls-mrh" value=""
                                               disabled>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    {{--</div>--}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--MODAL Penerimaan--}}
    <div class="modal fade" id="m-penerimaan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" style="max-width: 80%"
             role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Penerimaan</h5>
                </div>
                <div class="modal-body" style="height: 650px;">
                    <div class="row">
                        <label for="prod" class="col-sm-1 text-right">Produk </label>
                        <input type="text" id="produk-penerimaan" class="form-control p-0 col-sm-6" disabled>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="tableFixedHeader">
                                <table class="table table-sm justify-content-md-center p-0 col-sm-12"
                                       id="table-penerimaan">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th width="30%" class="text-center small">Supplier</th>
                                        <th width="7%" class="text-center small">Qty BPB</th>
                                        <th width="6%" class="text-center small">Bonus 1</th>
                                        <th width="6%" class="text-center small">Bonus 2</th>
                                        <th width="10%" class="text-center small">Dokumen</th>
                                        <th width="13%" class="text-center small">Tanggal</th>
                                        <th width="5%" class="text-center small">Top</th>
                                        <th width="10%" class="text-center small">Last Cost (pcs)</th>
                                        <th width="10%" class="text-center small">Avg Cost (pcs)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="justify-content-md-center p-0 baris">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--MODAL PB--}}
    <div class="modal fade" id="m-pb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" style="max-width: 80%"
             role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>PB</h5>
                </div>
                <div class="modal-body" style="height: 520px;">
                    <div class="row">
                        <div class="col">
                            <div class="">
                                <table class="table table-sm justify-content-md-center p-0 col-sm-12 fixed_header"
                                       id="table-pb">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th class="text-center"
                                            style="border: 1px solid;border-bottom: 0px solid;border-left: 0px solid"
                                            colspan="4" scope="colgroup">PB
                                        </th>
                                        <th class="text-center" style="border: 1px solid;border-bottom: 0px solid"
                                            colspan="2" scope="colgroup">PO
                                        </th>
                                        <th class="text-center" style="border: 1px solid;border-bottom: 0px solid"
                                            colspan="2" scope="colgroup">BPB
                                        </th>
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
                                    <tr class="justify-content-md-center p-0 baris">
                                        <td class="p-0">
                                            <input type="text" class="form-control" value="" disabled>
                                        </td>
                                        <td class="p-0">
                                            <input type="text" class="form-control" value="" disabled>
                                        </td>
                                        <td class="p-0">
                                            <input type="text" class="form-control" value="" disabled>
                                        </td>
                                        <td class="p-0">
                                            <input type="text" class="form-control" value="" disabled>
                                        </td>
                                        <td class="p-0">
                                            <input type="text" class="form-control" value="" disabled>
                                        </td>
                                        <td class="p-0">
                                            <input type="text" class="form-control" value="" disabled>
                                        </td>
                                        <td class="p-0">
                                            <input type="text" class="form-control" value="" disabled>
                                        </td>
                                        <td class="p-0">
                                            <input type="text" class="form-control" value="" disabled>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--MODAL SO--}}
    <div class="modal fade" id="m-so" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" style="max-width: 80%"
             role="document">
            <div class="modal-content">
                <div class="modal-body" style="height: 800px;">
                    <div class="row">
                        <fieldset class="card border-secondary p-2 col-sm-8">
                            <legend align="middle" class="w-auto h5 ">Stock Opname Nasional</legend>
                            <div class="row">
                                <label for="periode-so" class="col-sm-2 col-form-label text-right">Periode SO</label>
                                <input type="text" class="form-control col-sm-2" id="periode-so" disabled>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <table class="table table-sm justify-content-md-center col-sm-12 " id="table-so">
                                        <thead class="theadDataTables">
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
                                        <tr class="p-0 baris">
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

                            <label for="keterangan-so" class=" col-form-label">&nbsp;Selisih = Qty SO - Qty LPP - Qty
                                Adjustment</label>

                            <fieldset class="card border-secondary m-2 p-2">
                                <legend class="w-auto h5 ml-5">Detail Adjustment</legend>
                                <div class="row">
                                    <div class="col my-custom-scrollbar table-wrapper-scroll-y">
                                        <table class="table table-sm justify-content-md-center col-sm-12"
                                               id="table-detailadj">
                                            <thead class="theadDataTables">
                                            <tr>
                                                <th width="10%" class="text-center small">Seq</th>
                                                <th width="20%" class="text-center small">Qty Adj</th>
                                                <th width="50%" class="text-center small">Keterangan</th>
                                                <th width="20%" class="text-center small">Tanggal Adj</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="p-0 baris">
                                                <td class="p-0">
                                                    <input type="text" class="form-control text-center" disabled>
                                                </td>
                                                <td class="p-0">
                                                    <input type="text" class="form-control text-center" disabled>
                                                </td>
                                                <td class="p-0">
                                                    <input type="text" class="form-control text-center" disabled>
                                                </td>
                                                <td class="p-0">
                                                    <input type="text" class="form-control text-center" disabled>
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
                                <legend align="middle" class="w-auto h5 ">Stock Opname IC</legend>
                                <div class="row">
                                    <div class="col my-custom-scrollbar table-wrapper-scroll-y">
                                        <table class="table table-sm justify-content-md-center col-sm-12 "
                                               id="table-soic">
                                            <thead class="theadDataTables">
                                            <tr>
                                                <th width="10%" class="text-center small">Tgl SO</th>
                                                <th width="10%" class="text-center small">Kode SO</th>
                                                <th width="5%" class="text-center small">Qty</th>
                                                <th width="10%" class="text-center small">Avg. Cost</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="p-0 baris">
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
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn-cetak-soic">Cetak</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--MODAL Harga Beli--}}
    <div class="modal fade" id="m-hargabeli" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" style="max-width: 90%"
             role="document">
            <div class="modal-content">
                <div class="modal-body" style="height: 1000px;">
                    <fieldset class="card border-secondary col-sm-12">
                        <legend align="middle" class="w-auto h5">Harga Beli</legend>
                        <div class="row m-1">
                            <label for="supp-terakhir" class="col-sm-2 col-form-label text-right">Supp Terakhir</label>
                            <input type="text" class="form-control col-sm-10" id="hb-supp-terakhir" disabled>
                        </div>
                        <div class="row m-1">
                            <label for="plu" class="col-sm-2 col-form-label text-right">PLU</label>
                            <input type="text" class="form-control col-sm-10" id="hb-plu" disabled>
                        </div>
                        <div class="row m-1">
                            <label for="status-tag" class="col-sm-2 col-form-label text-right">Status Tag</label>
                            <input type="text" class="form-control col-sm-5" id="hb-status-tag" disabled>
                            <label for="satuan-beli" class="col-sm-2 col-form-label text-right">Satuan Beli</label>
                            <input type="text" class="form-control col-sm-3 text-right" id="hb-satuan-beli" disabled>
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">BKP</label>
                            <input type="text" class="form-control col-sm-1" id="hb-bkp" disabled>
                            <label class="col-sm-3 col-form-label text-right">Flag Bandrol</label>
                            <input type="text" class="form-control col-sm-1" id="hb-flag-bandrol" disabled>
                            <label class="col-sm-2 col-form-label text-right">Harga Omi</label>
                            <input type="text" class="form-control text-right col-sm-3" id="hb-harga-omi" disabled>
                        </div>
                    </fieldset>
                    <fieldset class="card border-secondary col-sm-12 mt-2">
                        <div class="row m-1">
                            <label for="supp" class="col-sm-2 col-form-label text-right">Supp</label>
                            <input type="text" class="form-control col-sm-8" id="hb-supp" disabled>
                            <label for="plu" class="col-sm-1 col-form-label text-right">PKP</label>
                            <input type="text" class="form-control col-sm-1 text-center" id="hb-pkp" disabled>
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">Jenis Harga</label>
                            <input type="text" class="form-control col-sm-3" id="hb-jenis-harga" disabled>
                            <label class="col-sm-2 col-form-label text-right">Tgl Berlaku</label>
                            <input type="text" class="form-control col-sm-3" id="hb-tgl-berlaku" disabled>
                            <label class="col-sm-1 col-form-label text-right">TOP</label>
                            <input type="text" class="form-control col-sm-1" id="hb-top" disabled>
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">Harga Beli</label>
                            <input type="text" class="form-control col-sm-3 text-right" id="hb-harga-beli" disabled>
                            <label class="col-sm-2 col-form-label text-right">Kondisi</label>
                            <input type="text" class="form-control col-sm-3" id="hb-kondisi" disabled>
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">PPN BM</label>
                            <input type="text" class="form-control col-sm-3 text-right" id="hb-ppn-bm" disabled>
                            <label class="col-sm-2 col-form-label text-right">PPN</label>
                            <input type="text" class="form-control col-sm-3 text-right" id="hb-ppn" disabled>
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">Botol</label>
                            <input type="text" class="form-control col-sm-3 text-right" disabled id="hb-botol">
                            <label class="col-sm-2 col-form-label text-right">Total</label>
                            <input type="text" class="form-control col-sm-3 text-right" disabled id="hb-total">
                        </div>
                        <div class="row m-1 mt-2">
                            <label class="col-sm-2 col-form-label text-right">Discount 1 %</label>
                            <input type="text" class="form-control col-sm-1 text-right" disabled id="hb-discount-1">
                            <label class="col-sm-1 col-form-label text-right">Rp.</label>
                            <input type="text" class="form-control col-sm-2 text-right" disabled id="hb-rp-1">
                            <label class="col-sm-1 col-form-label text-right">Satuan</label>
                            <input type="text" class="form-control col-sm-1" disabled id="hb-satuan">
                            <label class="col-sm-1 col-form-label text-right">Bonus I</label>
                            <input type="text" class="form-control col-sm-1 text-right" disabled id="hb-bonus-1">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">Discount 2 %</label>
                            <input type="text" class="form-control col-sm-1 text-right" disabled id="hb-discount-2">
                            <label class="col-sm-1 col-form-label text-right">Rp.</label>
                            <input type="text" class="form-control col-sm-2 text-right" disabled id="hb-rp-2">
                            <label class="col-sm-1 col-form-label text-right">Periode</label>
                            <input type="text" class="form-control col-sm-3" disabled id="hb-periode-2">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">Discount 2 A %</label>
                            <input type="text" class="form-control col-sm-1 text-right" disabled id="hb-discount-2a">
                            <label class="col-sm-1 col-form-label text-right">Rp.</label>
                            <input type="text" class="form-control col-sm-2 text-right" disabled id="hb-rp-2a">
                            <label class="col-sm-1 col-form-label text-right tex">Periode</label>
                            <input type="text" class="form-control col-sm-3" disabled id="hb-periode-2a">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">Discount 2 B %</label>
                            <input type="text" class="form-control col-sm-1 text-right" disabled id="hb-discount-2b">
                            <label class="col-sm-1 col-form-label text-right">Rp.</label>
                            <input type="text" class="form-control col-sm-2 text-right" disabled id="hb-rp-2b">
                            <label class="col-sm-1 col-form-label text-right">Periode</label>
                            <input type="text" class="form-control col-sm-3" disabled id="hb-periode-2b">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">Discount 3 %</label>
                            <input type="text" class="form-control col-sm-1 text-right" disabled id="hb-discount-3">
                            <label class="col-sm-1 col-form-label text-right">Rp.</label>
                            <input type="text" class="form-control col-sm-2 text-right" disabled id="hb-rp-3">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-3 col-form-label text-right">Discount 4: &nbsp; No. Return %</label>
                            <input type="text" class="form-control col-sm-1 text-right" disabled id="hb-no-return">
                            <label class="col-sm-1 col-form-label text-right">Rp.</label>
                            <input type="text" class="form-control col-sm-2 text-right" disabled id="hb-rp-no-return">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-3 col-form-label text-right">Cash Discount %</label>
                            <input type="text" class="form-control col-sm-1 text-right" disabled id="hb-cash-discount">
                            <label class="col-sm-1 col-form-label text-right">Rp.</label>
                            <input type="text" class="form-control col-sm-2 text-right" disabled
                                   id="hb-rp-cash-discount">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-3 col-form-label text-right">Distribution Fee</label>
                            <input type="text" class="form-control col-sm-1 text-right" disabled
                                   id="hb-distribution-fee">
                            <label class="col-sm-1 col-form-label text-right">Rp.</label>
                            <input type="text" class="form-control col-sm-2 text-right" disabled
                                   id="hb-rp-distribution-fee">
                            <label class="col-sm-1 col-form-label text-right">Total</label>
                            <input type="text" class="form-control col-sm-2 text-right" disabled id="hb-total-discount">
                        </div>
                        <div class="row m-1 mt-3">
                            <label class="col-sm-2 col-form-label text-right">Bonus Kelipatan</label>
                            <input type="text" class="form-control col-sm-1 text-right" disabled
                                   id="hb-bonus-kelipatan">
                            <label class="col-sm-2 col-form-label text-right">Periode</label>
                            <input type="text" class="form-control col-sm-2" disabled id="hb-periode">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">QTY BELI --> #1</label>
                            <input type="text" class="form-control col-sm-2 text-right" disabled id="hb-qty-beli1">
                            <label class="col-sm-1 col-form-label text-right">#2</label>
                            <input type="text" class="form-control col-sm-2 text-right" disabled id="hb-qty-beli2">
                            <label class="col-sm-1 col-form-label text-right">#3</label>
                            <input type="text" class="form-control col-sm-2 text-right" disabled id="hb-qty-beli3">
                        </div>
                        <div class="row m-1">
                            <label class="col-sm-2 col-form-label text-right">QTY BNS --> #1</label>
                            <input type="text" class="form-control col-sm-2 text-right" disabled id="hb-qty-bns1">
                            <label class="col-sm-1 col-form-label text-right">#2</label>
                            <input type="text" class="form-control col-sm-2 text-right" disabled id="hb-qty-bns2">
                            <label class="col-sm-1 col-form-label text-right">#3</label>
                            <input type="text" class="form-control col-sm-2 text-right" disabled id="hb-qty-bns3">
                        </div>
                    </fieldset>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn-hb-prev"><<< PREV</button>
                    <button type="button" class="btn btn-secondary" id="btn-hb-next">NEXT >>></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--MODAL Stock Carton--}}
    <div class="modal fade" id="m-stockcarton" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal" role="document">
            <div class="modal-content" style="max-height: 70%;">
                <div class="modal-header">
                    <h5>Stock Carton</h5>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control text-center" id="title-stock-carton" disabled>
                    <div class="row">
                        <table class="table table-sm justify-content-md-center m-2" id="table-stockcarton">
                            <thead class="theadDataTables">
                            <tr>
                                <th class="text-center small">Status Barang</th>
                                <th class="text-center small">Carton</th>
                                <th class="text-center small">Pcs</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="baris p-0">
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <style>
        .my-custom-scrollbar {
            position: relative;
            height: 300px;
            overflow-x: hidden;
            overflow-y: scroll;
        }

        .table-wrapper-scroll-y {
            display: block;
        }
    </style>

    <script>
        $(document).ready(function () {
            $('#item').hide();
            $('#input').focus();
            $('#btn-hb-prev').prop('disabled', true);
            // $('.page2').hide();
            $('.page2').show();
            getModalDataPLU('');

            var e = $.Event("keypress");
            e.keyCode = 13;

        });

        function getModalDataPLU(value) {
            let tableModal = $('#tableModalPLU').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/lov_search',
                    "data": {
                        'value': value
                    },
                },
                "columns": [
                    {data: 'prd_prdcd', name: 'prd_prdcd'},
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
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
                columnDefs: [],
                "order": []
            });

            $('#tableModalPLU_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModal.destroy();
                    getModalDataPLU(val);
                }
            })
        }

        $(document).on('click', '.modalRow', function () {
            var currentButton = $(this);
            let plu = currentButton.children().first().text();
            get_data(plu);
            $('#m_plu').modal('hide');
        });

        cetakso = {};
        cetak = {};
        hbke = 0;
        data_hb = '';
        total_data_hb = 0;
        month = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'];

        $('#input').keypress(function (e) {
            if (e.keyCode == 13) {
                plu = $(this).val();
                if (plu.length < 7) {
                    plu = convertPlu($(this).val());
                }
                $(this).val(plu);
                get_data(plu);
                console.log(plu);
                $('#input').val('');

            }
        });

        function getDataRekapTrendSales() {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/get-data-rekap-trend-sales',
                type: 'post',
                data: {
                    doc: $('#dokumen').val(),
                    lap: $('#laporan').val(),
                    reprint: $('#reprint:checked').val(),
                    tgl1: $('#tgl1').val(),
                    tgl2: $('#tgl2').val(),
                    data: checked,
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    for (i = 0; i < 12; i++) {
                        c = i + 1;
                        $('#table-detailsales').append('<tr class="justify-content-md-center p-0 baris">\n' +
                            '                                    <td class="p-0 text-center" style="padding-top: .45rem!important;" >\n' +
                            '                                        ' + month[i] + ' \n' +
                            '                                    </td>\n' +
                            '                                    <td class="p-0">\n' +
                            '                                        <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['detailsales'].igr['qty_igr' + c]) + '" disabled>\n' +
                            '                                    </td>\n' +
                            '                                    <td class="p-0">\n' +
                            '                                        <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['detailsales'].igr['rph_igr' + c]) + '" disabled>\n' +
                            '                                    </td>\n' +
                            '                                    <td class="p-0">\n' +
                            '                                        <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['detailsales'].omi['qty_omi' + c]) + '" disabled>\n' +
                            '                                    </td>\n' +
                            '                                    <td class="p-0">\n' +
                            '                                        <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['detailsales'].omi['rph_omi' + c]) + '" disabled>\n' +
                            '                                    </td>\n' +
                            '                                    <td class="p-0">\n' +
                            '                                        <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['detailsales'].idm['qty_omi' + c]) + '" disabled>\n' +
                            '                                    </td>\n' +
                            '                                    <td class="p-0">\n' +
                            '                                        <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['detailsales'].idm['rph_omi' + c]) + '" disabled>\n' +
                            '                                    </td>\n' +
                            '                                    <td class="p-0">\n' +
                            '                                        <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['detailsales'].mrh['qty_mrh' + c]) + '" disabled>\n' +
                            '                                    </td>\n' +
                            '                                    <td class="p-0">\n' +
                            '                                        <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['detailsales'].mrh['rph_mrh' + c]) + '" disabled>\n' +
                            '                                    </td>\n' +
                            '                                </tr>');
                    }
                    $('#produk-penerimaan').val(response.produk['prd_deskripsipanjang'] + ' [' + response.produk['prd_prdcd'] + ']');

                    $('#avgsls-igr').val(convertToRupiah2(response['detailsales'].avgigr));
                    $('#avgsls-idm').val(convertToRupiah2(response['detailsales'].avgidm));
                    $('#avgsls-omi').val(convertToRupiah2(response['detailsales'].avgomi));
                    $('#avgsls-mrh').val(convertToRupiah2(response['detailsales'].avgmrh));
                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    errorHandlingforAjax(err)
                }
            })



        }

        function get_data(value) {
            $('.page1').hide();
            $('.page2').show();
            ajaxSetup();
            $.ajax({
                    url: '{{ url()->current() }}/lov_select',
                    type: 'POST',
                    data: {"_token": "{{ csrf_token() }}", value: value},
                    beforeSend: function () {
                        $('#m_pluHelp').modal('hide');
                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.length == 1) {
                            clearpage();
                            swal({
                                title: response,
                                icon: 'info'
                            }).then((createData) => {
                            });
                        } else {
                            notif(response.message, -1, response.message.length);

                            $('.baris').remove();
                            $('#cabang').val(response.produk['cab_namacabang']);
                            $('#plu').val(response.produk['prd_prdcd']);
                            $('#produk').val(response.produk['prd_deskripsipanjang']);
                            $('#katbarang').val(response.produk['katbrg']);
                            $('#kdcabang').val(response.produk['prd_kodecabang']);
                            $('#flaggdg').val(response.produk['prd_flaggudang']);
                            $('#kattoko').val(response.produk['prd_kategoritoko']);
                            $('#upd').val(formatDate(response.produk['prd_create_dt']));
                            if (response.showpromo) {
                                $('#hrgpromo').val(convertToRupiah2(response.produk['hrgpromo']));
                                $('#tglpromo').val((response.produk['tglpromo']));
                                $('#jampromo').val((response.produk['jampromo']));
                            } else {
                                $('.promo').hide();
                            }

                            for (i = 0; i < response.sj.length; i++) {
                                $('#table-satuan').append('<tr class="baris">\n' +
                                    '                                    <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control" value="' + response.sj[i].sj_sj + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                    <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control" value="' + response.sj[i].sj_sat + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                    <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control" value="' + response.sj[i].sj_barcode + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                    <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control text-right" value="' + convertToRupiah2(response.sj[i].sj_hgjual) + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                    <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control text-right" value="' + format_currency(response.sj[i].sj_lcost) + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                    <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control text-right" value="' + format_currency(response.sj[i].sj_acost) + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                    <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control text-right" value="' + format_currency(response.sj[i].sj_mgnl) + '%' + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                    <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control text-right" value="' + format_currency(response.sj[i].sj_mgna) + '%' + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                    <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control" value="' + response.sj[i].sj_tag + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                    <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control" value="' + response.sj[i].sj_minj + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                    <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control" value="' + response.sj[i].sj_bkp + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                    <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control" value="' + response.sj[i].sj_bkl + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                </tr>');
                            }

                            for (i = 0; i < 12; i++) {
                                j = i + 1;
                                if (j < 10) {
                                    j = "0" + j;
                                }
                                if ((response['FMPBLNA'] - 1) == i) {

                                    $('#table-trendsales').append('' +
                                        '<tr class="baris bg-warning">\n' +
                                        '   <td class="p-0 text-center">\n' +
                                        '       ' + month[i] + '\n' +
                                        '   </td>\n' +
                                        '   <td class="p-0">\n' +
                                        '       <input type="text" class="bg-warning form-control text-right" value="' + response['trendsales']['sls_qty_' + j] + '" readonly >\n' +
                                        '   </td>\n' +
                                        '   <td class="p-0">\n' +
                                        '       <input type="text" class="bg-warning form-control text-right" value="' + format_currency(response['trendsales']['sls_rph_' + j]) + '" disabled >\n' +
                                        '   </td>\n' +
                                        '</tr>');
                                } else {
                                    $('#table-trendsales').append('' +
                                        '<tr class="baris">\n' +
                                        '   <td class="p-0 text-center">\n' +
                                        '       ' + month[i] + '\n' +
                                        '   </td>\n' +
                                        '   <td class="p-0">\n' +
                                        '       <input type="text" class=" form-control text-right" value="' + response['trendsales']['sls_qty_' + j] + '" disabled >\n' +
                                        '   </td>\n' +
                                        '   <td class="p-0">\n' +
                                        '       <input type="text" class=" form-control text-right" value="' + format_currency(response['trendsales']['sls_rph_' + j]) + '" disabled >\n' +
                                        '   </td>\n' +
                                        '</tr>');
                                }
                            }

                            for (i = 0; i < response.stock.length; i++) {
                                $('#table-stock').append('<tr class="justify-content-md-center p-0 baris">\n' +
                                    '                                            <td class="p-0">\n' +
                                    '                                                <input type="text" class="form-control" value="' + response.stock[i].st + '" disabled>\n' +
                                    '                                            </td>\n' +
                                    '                                            <td class="p-0">\n' +
                                    '                                                <input type="text" class="form-control text-right" value="' + convertToRupiah2(response.stock[i].st_saldoawal) + '" disabled>\n' +
                                    '                                            </td>\n' +
                                    '                                            <td class="p-0">\n' +
                                    '                                                <input type="text" class="form-control text-right" value="' + convertToRupiah2(response.stock[i].st_trfin) + '" disabled>\n' +
                                    '                                            </td>\n' +
                                    '                                            <td class="p-0">\n' +
                                    '                                                <input type="text" class="form-control text-right" value="' + convertToRupiah2(response.stock[i].st_trfout) + '" disabled>\n' +
                                    '                                            </td>\n' +
                                    '                                            <td class="p-0">\n' +
                                    '                                                <input type="text" class="form-control text-right" value="' + convertToRupiah2(response.stock[i].st_sales) + '" disabled>\n' +
                                    '                                            </td>\n' +
                                    '                                            <td class="p-0">\n' +
                                    '                                                <input type="text" class="form-control text-right" value="' + convertToRupiah2(response.stock[i].st_retur) + '" disabled>\n' +
                                    '                                            </td>\n' +
                                    '                                            <td class="p-0">\n' +
                                    '                                                <input type="text" class="form-control text-right" value="' + convertToRupiah2(response.stock[i].st_adj) + '" disabled>\n' +
                                    '                                            </td>\n' +
                                    '                                            <td class="p-0">\n' +
                                    '                                                <input type="text" class="form-control text-right" value="' + convertToRupiah2(response.stock[i].st_intransit) + '" disabled>\n' +
                                    '                                            </td>\n' +
                                    '                                            <td class="p-0">\n' +
                                    '                                                <input type="text" class="form-control text-right" value="' + convertToRupiah2(response.stock[i].st_selisih_so) + '" disabled>\n' +
                                    '                                            </td>\n' +
                                    '                                            <td class="p-0">\n' +
                                    '                                                <input type="text" class="form-control text-right" value="' + convertToRupiah2(response.stock[i].st_saldoakhir) + '" disabled>\n' +
                                    '                                            </td>\n' +
                                    '                                        </tr>');
                            }

                            $('#avgsales').val(format_currency(response['AVGSALES']));
                            /*PKMT*/
                            $('#dsi').val(convertToRupiah2(response['pkmt'].dsi));
                            $('#to').val(convertToRupiah2(response['pkmt'].to));
                            $('#top').val(convertToRupiah2(response['pkmt'].top));
                            $('#pkmtqty').val(convertToRupiah2(response['pkmt'].pkm_qty));
                            $('#pkmtto').val(convertToRupiah2(response['pkmt'].pkm_to));
                            $('#minorqty').val(convertToRupiah2(response['pkmt'].min_qty));
                            $('#minorto').val(convertToRupiah2(response['pkmt'].min_to));
                            $('#mindisqty').val(convertToRupiah2(response['pkmt'].md_qty));
                            $('#mindisto').val(convertToRupiah2(response['pkmt'].md_to));
                            $('#mplus').val(format_currency(nvl(response['pkmt'].mplus, 0)));
                            $('#minory').val(convertToRupiah2(response['pkmt'].minory));
                            $('#suppterakhir').val(response['pkmt'].sup);
                            $('#hargabeli').val(format_currency(response['pkmt'].hgb_hrgbeli));
                            /*FLAG*/
                            $('#flagnas').val(response['flag'].NAS);
                            $('#flagomi').val(response['flag'].OMI);
                            $('#flagbrd').val(response['flag'].BRD);
                            $('#flagobi').val(response['flag'].OBI);
                            $('#flagigr').val(response['flag'].IGR);
                            $('#flagidm').val(response['flag'].IDM);
                            /*ITEM*/
                            $('#item').text(response['ITEM']);
                            // for (i = 0; i < 12; i++) {
                            //     c = i + 1;
                            //     $('#table-detailsales').append('<tr class="justify-content-md-center p-0 baris">\n' +
                            //         '                                    <td class="p-0 text-center" style="padding-top: .45rem!important;" >\n' +
                            //         '                                        ' + month[i] + ' \n' +
                            //         '                                    </td>\n' +
                            //         '                                    <td class="p-0">\n' +
                            //         '                                        <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['detailsales'].igr['qty_igr' + c]) + '" disabled>\n' +
                            //         '                                    </td>\n' +
                            //         '                                    <td class="p-0">\n' +
                            //         '                                        <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['detailsales'].igr['rph_igr' + c]) + '" disabled>\n' +
                            //         '                                    </td>\n' +
                            //         '                                    <td class="p-0">\n' +
                            //         '                                        <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['detailsales'].omi['qty_omi' + c]) + '" disabled>\n' +
                            //         '                                    </td>\n' +
                            //         '                                    <td class="p-0">\n' +
                            //         '                                        <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['detailsales'].omi['rph_omi' + c]) + '" disabled>\n' +
                            //         '                                    </td>\n' +
                            //         '                                    <td class="p-0">\n' +
                            //         '                                        <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['detailsales'].idm['qty_omi' + c]) + '" disabled>\n' +
                            //         '                                    </td>\n' +
                            //         '                                    <td class="p-0">\n' +
                            //         '                                        <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['detailsales'].idm['rph_omi' + c]) + '" disabled>\n' +
                            //         '                                    </td>\n' +
                            //         '                                    <td class="p-0">\n' +
                            //         '                                        <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['detailsales'].mrh['qty_mrh' + c]) + '" disabled>\n' +
                            //         '                                    </td>\n' +
                            //         '                                    <td class="p-0">\n' +
                            //         '                                        <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['detailsales'].mrh['rph_mrh' + c]) + '" disabled>\n' +
                            //         '                                    </td>\n' +
                            //         '                                </tr>');
                            // }
                            // $('#produk-penerimaan').val(response.produk['prd_deskripsipanjang'] + ' [' + response.produk['prd_prdcd'] + ']');
                            //
                            // $('#avgsls-igr').val(convertToRupiah2(response['detailsales'].avgigr));
                            // $('#avgsls-idm').val(convertToRupiah2(response['detailsales'].avgidm));
                            // $('#avgsls-omi').val(convertToRupiah2(response['detailsales'].avgomi));
                            // $('#avgsls-mrh').val(convertToRupiah2(response['detailsales'].avgmrh));

                            for (var i = 0; i < response['supplier'].length; i++) {
                                $('#table-penerimaan').append('<tr class="baris"><td class="p-0">\n' +
                                    '<input type="text" class="form-control" value="' + response['supplier'][i].sup_namasupplier + '" disabled>\n' +
                                    '</td>\n' +
                                    '<td class="p-0">\n' +
                                    '    <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['supplier'][i].trm_qtybns) + '" disabled>\n' +
                                    '</td>\n' +
                                    '<td class="p-0">\n' +
                                    '    <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['supplier'][i].trm_bonus) + '" disabled>\n' +
                                    '</td>\n' +
                                    '<td class="p-0">\n' +
                                    '    <input type="text" class="form-control text-right" value="' + convertToRupiah2(response['supplier'][i].trm_bonus2) + '" disabled>\n' +
                                    '</td>\n' +
                                    '<td class="p-0">\n' +
                                    '    <input type="text" class="form-control" value="' + response['supplier'][i].trm_dokumen + '" disabled>\n' +
                                    '</td>\n' +
                                    '<td class="p-0">\n' +
                                    '    <input type="text" class="form-control" value="' + formatDate(response['supplier'][i].trm_tanggal) + '" disabled>\n' +
                                    '</td>\n' +
                                    '<td class="p-0">\n' +
                                    '    <input type="text" class="form-control" value="' + response['supplier'][i].trm_top + '" disabled>\n' +
                                    '</td>\n' +
                                    '<td class="p-0">\n' +
                                    '    <input type="text" class="form-control text-right" value="' + format_currency(response['supplier'][i].trm_hpp) + '" disabled>\n' +
                                    '</td>\n' +
                                    '<td class="p-0">\n' +
                                    '    <input type="text" class="form-control text-right" value="' + format_currency(response['supplier'][i].trm_acost) + '" disabled>\n' +
                                    '</td><tr>');
                            }
                            for (var i = 0; i < response['permintaan'].length; i++) {
                                $('#table-pb').append('<tr class="justify-content-md-center p-0 baris">\n' +
                                    '                                    <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control" value="' + response['permintaan'][i].pb_no + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                    <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control" value="' + formatDate(response['permintaan'][i].pb_tgl) + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                    <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control text-right" value="' + nvl(convertToRupiah2(response['permintaan'][i].pb_qty), '') + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                   <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control" value="' + response['permintaan'][i].pb_ket + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                    <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control" value="' + response['permintaan'][i].pb_nopo + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                   <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control" value="' + formatDate(response['permintaan'][i].pb_tglpo) + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                   <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control text-right" value="' + nvl(convertToRupiah2(response['permintaan'][i].pb_qtybpb, '')) + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                   <td class="p-0">\n' +
                                    '                                        <input type="text" class="form-control" value="' + response['permintaan'][i].pb_ketbpb + '" disabled>\n' +
                                    '                                    </td>\n' +
                                    '                                </tr>');
                            }
                            //SO
                            cetakso.so = response['so'];
                            cetakso.sotgl = response['so_tgl'];
                            cetakso.adjustso = response['adjustso'];
                            cetakso.resetsoic = response['resetsoic'];
                            cetakso.plu = response.produk['prd_prdcd'];
                            cetakso.barcode = response.produk['brc_barcode'];
                            cetakso.produk = response.produk['prd_deskripsipanjang'];

                            $('#periode-so').val(formatDate(response['so_tgl']));
                            for (var i = 0; i < response['so'].length; i++) {
                                $('#table-so').append(
                                    '<tr class="p-0 baris">\n' +
                                    '    <td class="p-0">\n' +
                                    '         <input type="text" class="form-control text-center" value="' + convertToRupiah2(response['so'][i].sop_qtyso) + '" disabled>\n' +
                                    '    </td>\n' +
                                    '     <td class="p-0">\n' +
                                    '         <input type="text" class="form-control text-center" value="' + convertToRupiah2(response['so'][i].sop_qtylpp) + '" disabled>\n' +
                                    '    </td>\n' +
                                    '    <td class="p-0">\n' +
                                    '         <input type="text" class="form-control text-center" value="' + convertToRupiah2(response['so'][i].qty_adj) + '" disabled>\n' +
                                    '    </td>\n' +
                                    '    <td class="p-0">\n' +
                                    '         <input type="text" class="form-control text-center" value="' + convertToRupiah2(response['so'][i].selisih) + '" disabled>\n' +
                                    '    </td>\n' +
                                    '    <td class="p-0">\n' +
                                    '         <input type="text" class="form-control text-center" value="' + convertToRupiah2(response['so'][i].sop_newavgcost) + '" disabled>\n' +
                                    '    </td>\n' +
                                    '    <td class="p-0">\n' +
                                    '         <input type="text" class="form-control text-center" value="' + convertToRupiah(response['so'][i].rupiah) + '" disabled>\n' +
                                    '    </td>\n' +
                                    '</tr>');
                            }

                            for (var i = 0; i < response['adjustso'].length; i++) {
                                $('#table-detailadj').append(
                                    '<tr class="p-0 baris">\n' +
                                    '    <td class="p-0">\n' +
                                    '       <input type="text" value="' + response['adjustso'][i].adj_seq + '" class="form-control text-center" disabled>\n' +
                                    '    </td>\n' +
                                    '    <td class="p-0">\n' +
                                    '       <input type="text" value="' + convertToRupiah2(response['adjustso'][i].adj_qty) + '" class="form-control text-center" disabled>\n' +
                                    '    </td>\n' +
                                    '    <td class="p-0">\n' +
                                    '       <input type="text" value="' + response['adjustso'][i].adj_keterangan + '" class="form-control text-center" disabled>\n' +
                                    '    </td>\n' +
                                    '    <td class="p-0">\n' +
                                    '       <input type="text" value="' + formatDate(response['adjustso'][i].adj_create_dt) + '" class="form-control text-center" disabled>\n' +
                                    '    </td>\n' +
                                    '</tr>'
                                );
                            }

                            for (var i = 0; i < response['resetsoic'].length; i++) {
                                $('#table-soic').append(
                                    '<tr class="p-0 baris">\n' +
                                    '    <td class="p-0">\n' +
                                    '       <input type="text" value="' + formatDate(response['resetsoic'].rso_tglso) + '" class="form-control text-center" disabled>\n' +
                                    '    </td>\n' +
                                    '    <td class="p-0">\n' +
                                    '       <input type="text" value="' + response['resetsoic'].rso_kodeso + '" class="form-control text-center" disabled>\n' +
                                    '    </td>\n' +
                                    '    <td class="p-0">\n' +
                                    '       <input type="text" value="' + convertToRupiah2(response['resetsoic'].rso_qty) + '" class="form-control text-center" disabled>\n' +
                                    '    </td>\n' +
                                    '    <td class="p-0">\n' +
                                    '       <input type="text" value="' + convertToRupiah2(response['resetsoic'].rso_avgcostreset) + '" class="form-control text-center" disabled>\n' +
                                    '    </td>\n' +
                                    '</tr>'
                                );
                            }

                            //HARGA BELI
                            total_data_hb = response['hargabeli'].length;
                            data_hb = response['hargabeli'];
                            if (total_data_hb == 1) {
                                $('#btn-hb-next').prop('disabled', true);
                            } else {
                                $('#btn-hb-next').removeAttr('disabled');
                            }
                            $('#hb-supp-terakhir').val(response['hargabeli'][0].hb_supplier);
                            $('#hb-plu').val(response['hargabeli'][0].hb_plu);
                            $('#hb-status-tag').val(response['hargabeli'][0].hb_statustag);
                            $('#hb-satuan-beli').val(response['hargabeli'][0].hb_satuanbl);
                            $('#hb-bkp').val(response['hargabeli'][0].hb_bkp);
                            $('#hb-flag-bandrol').val(response['hargabeli'][0].hb_flagbandrol);
                            $('#hb-harga-omi').val(convertToRupiah(response['hargabeli'][0].hb_hrgomi));

                            $('#hb-supp').val(response['hargabeli'][0].hb_supplier);
                            $('#hb-pkp').val(response['hargabeli'][0].hb_pkp);
                            $('#hb-jenis-harga').val(response['hargabeli'][0].hb_jnshg);
                            $('#hb-tgl-berlaku').val(formatDate(response['hargabeli'][0].hb_tglberlaku));
                            $('#hb-top').val(response['hargabeli'][0].hb_top);
                            $('#hb-harga-beli').val(convertToRupiah(response['hargabeli'][0].hb_hgbeli));
                            $('#hb-kondisi').val(response['hargabeli'][0].hb_kondisi);
                            $('#hb-ppn-bm').val(convertToRupiah(response['hargabeli'][0].hb_ppnbm));
                            $('#hb-ppn').val(convertToRupiah(response['hargabeli'][0].hb_ppn));
                            $('#hb-botol').val(convertToRupiah(response['hargabeli'][0].hb_btl));
                            $('#hb-total').val(convertToRupiah(response['hargabeli'][0].hb_total));

                            $('#hb-discount-1').val(convertToRupiah(response['hargabeli'][0].hb_persendisc1));
                            $('#hb-rp-1').val(convertToRupiah(response['hargabeli'][0].hb_rpdisc1));
                            $('#hb-satuan').val(response['hargabeli'][0].hb_satuan);
                            $('#hb-bonus-1').val(response['hargabeli'][0].hb_bns1);

                            $('#hb-discount-2').val(convertToRupiah(response['hargabeli'][0].hb_persendisc2));
                            $('#hb-rp-2').val(convertToRupiah(response['hargabeli'][0].hb_rpdisc2));
                            $('#hb-periode-2').val((response['hargabeli'][0].hb_periode));

                            $('#hb-discount-2a').val(convertToRupiah(response['hargabeli'][0].hb_persendisc2ii));
                            $('#hb-rp-2a').val(convertToRupiah(response['hargabeli'][0].hb_rpdisc2ii));
                            $('#hb-periode-2a').val(formatDate(response['hargabeli'][0].hb_periodeii));

                            $('#hb-discount-2b').val(convertToRupiah(response['hargabeli'][0].hb_persendisc2iii));
                            $('#hb-rp-2b').val(convertToRupiah(response['hargabeli'][0].hb_rpdisc2iii));
                            $('#hb-periode-2b').val(formatDate(response['hargabeli'][0].hb_periodeiii));

                            $('#hb-discount-3').val(convertToRupiah(response['hargabeli'][0].hb_persendisc3));
                            $('#hb-rp-3').val(convertToRupiah(response['hargabeli'][0].hb_rpdisc3));

                            $('#hb-no-return').val(convertToRupiah(response['hargabeli'][0].hb_persendisc4));
                            $('#hb-rp-no-return').val(convertToRupiah(response['hargabeli'][0].hb_rpdisc4));

                            $('#hb-cash-discount').val(convertToRupiah(response['hargabeli'][0].hb_persencd));
                            $('#hb-rp-cash-discount').val(convertToRupiah(response['hargabeli'][0].hb_rpcd));

                            $('#hb-distribution-fee').val(convertToRupiah(response['hargabeli'][0].hb_persendf));
                            $('#hb-rp-distribution-fee').val(convertToRupiah(response['hargabeli'][0].hb_rpdf));
                            $('#hb-total-discount').val(convertToRupiah(response['hargabeli'][0].hb_total2));

                            $('#hb-bonus-kelipatan').val(convertToRupiah2(response['hargabeli'][0].hb_bnslipat));
                            $('#hb-periode').val(response['hargabeli'][0].hb_periodbns);

                            $('#hb-qty-beli1').val(convertToRupiah2(response['hargabeli'][0].hb_qtybeli1));
                            $('#hb-qty-beli2').val(convertToRupiah2(response['hargabeli'][0].hb_qtybeli2));
                            $('#hb-qty-beli3').val(convertToRupiah2(response['hargabeli'][0].hb_qtybeli3));

                            $('#hb-qty-bns1').val(convertToRupiah2(response['hargabeli'][0].hb_qtybns1));
                            $('#hb-qty-bns2').val(convertToRupiah2(response['hargabeli'][0].hb_qtybns2));
                            $('#hb-qty-bns3').val(convertToRupiah2(response['hargabeli'][0].hb_qtybns3));


                            //STOCK CARTON
                            $('#title-stock-carton').val(response['stockcarton'].STC_TITLE);

                            $('#table-stockcarton').append(
                                '<tr class="baris p-0">\n' +
                                '    <td class="p-0">\n' +
                                '        <input type="text" class="form-control" value="' + response['stockcarton'].STC_baik + '" disabled>\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input type="text" class="form-control text-right" value="' + response['stockcarton'].STC_CT1 + '" disabled>\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input type="text" class="form-control text-right" value="' + response['stockcarton'].STC_PCS1 + '" disabled>\n' +
                                '    </td>\n' +
                                '</tr>' +
                                '<tr class="baris p-0">\n' +
                                '    <td class="p-0">\n' +
                                '        <input type="text" class="form-control" value="' + response['stockcarton'].STC_retur + '" disabled>\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input type="text" class="form-control text-right" value="' + response['stockcarton'].STC_CT2 + '" disabled>\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input type="text" class="form-control text-right" value="' + response['stockcarton'].STC_PCS2 + '" disabled>\n' +
                                '    </td>\n' +
                                '</tr>' +
                                '<tr class="baris p-0">\n' +
                                '    <td class="p-0">\n' +
                                '        <input type="text" class="form-control" value="' + response['stockcarton'].STC_rsk + '" disabled>\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input type="text" class="form-control text-right" value="' + response['stockcarton'].STC_CT3 + '" disabled>\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input type="text" class="form-control text-right" value="' + response['stockcarton'].STC_PCS3 + '" disabled>\n' +
                                '    </td>\n' +
                                '</tr>');

                            //CETAK
                            cetak = response;
                            null_check();
                        }

                    },
                    complete:
                        function () {
                            if ($('#m_pluHelp').is(':visible')) {
                                $('#search_lov').val('');
                                $('#table_lov .row_lov').remove();
                                $('#table_lov').append(trlov);
                            }
                            $('#modal-loader').modal('hide');
                        }
                }
            );
        }

        var trlov = $('#table_lov tbody').html();

        function notif(value, arr, leng) {
            arr = arr + 1;
            if (arr < leng) {
                swal({
                    title: value[arr],
                    icon: 'info'
                }).then((createData) => {
                    notif(value, arr, leng);
                });
            }
        }

        $('#btn-hb-next').on('click', function () {
            hbke++;
            data_hargabeli(hbke);

            if (hbke == total_data_hb - 1) {
                $('#btn-hb-next').prop('disabled', true);
            } else if (hbke == 0) {
                $('#btn-hb-prev').prop('disabled', true);
            } else {
                $('#btn-hb-prev').removeAttr('disabled');
                $('#btn-hb-next').removeAttr('disabled');
            }
        });

        $('#btn-hb-prev').on('click', function () {
            hbke--;
            data_hargabeli(hbke);
            if (hbke == total_data_hb - 1) {
                $('#btn-hb-next').prop('disabled', true);
            } else if (hbke == 0) {
                $('#btn-hb-prev').prop('disabled', true);
            } else {
                $('#btn-hb-prev').removeAttr('disabled');
                $('#btn-hb-next').removeAttr('disabled');
            }
        });

        $('#btn-keluar').on('click', function () {
            $('.page1').show();
            $('.page2').hide();
        });

        function data_hargabeli(value) {
            $('#hb-supp').val(data_hb[value].hb_supplier);
            $('#hb-pkp').val(data_hb[value].hb_pkp);
            $('#hb-jenis-harga').val(data_hb[value].hb_jnshg);
            $('#hb-tgl-berlaku').val(formatDate(data_hb[value].hb_tglberlaku));
            $('#hb-top').val(data_hb[value].hb_top);
            $('#hb-harga-beli').val(convertToRupiah(data_hb[value].hb_hgbeli));
            $('#hb-kondisi').val(data_hb[value].hb_kondisi);
            $('#hb-ppn-bm').val(convertToRupiah(data_hb[value].hb_ppnbm));
            $('#hb-ppn').val(convertToRupiah(data_hb[value].hb_ppn));
            $('#hb-botol').val(convertToRupiah(data_hb[value].hb_btl));
            $('#hb-total').val(convertToRupiah(data_hb[value].hb_total));

            $('#hb-discount-1').val(convertToRupiah(data_hb[value].hb_persendisc1));
            $('#hb-rp-1').val(convertToRupiah(data_hb[value].hb_rpdisc1));
            $('#hb-satuan').val(data_hb[value].hb_satuan);
            $('#hb-bonus-1').val(data_hb[value].hb_bns1);

            $('#hb-discount-2').val(convertToRupiah(data_hb[value].hb_persendisc2));
            $('#hb-rp-2').val(convertToRupiah(data_hb[value].hb_rpdisc2));
            $('#hb-periode-2').val(formatDate(data_hb[value].hb_periode));

            $('#hb-discount-2a').val(convertToRupiah(data_hb[value].hb_persendisc2ii));
            $('#hb-rp-2a').val(convertToRupiah(data_hb[value].hb_rpdisc2ii));
            $('#hb-periode-2a').val(formatDate(data_hb[value].hb_periodeii));

            $('#hb-discount-2b').val(convertToRupiah(data_hb[value].hb_persendisc2iii));
            $('#hb-rp-2b').val(convertToRupiah(data_hb[value].hb_rpdisc2iii));
            $('#hb-periode-2b').val(formatDate(data_hb[value].hb_periodeiii));

            $('#hb-discount-3').val(convertToRupiah(data_hb[value].hb_persendisc3));
            $('#hb-rp-3').val(convertToRupiah(data_hb[value].hb_rpdisc3));

            $('#hb-no-return').val(convertToRupiah(data_hb[value].hb_persendisc4));
            $('#hb-rp-no-return').val(convertToRupiah(data_hb[value].hb_rpdisc4));

            $('#hb-cash-discount').val(convertToRupiah(data_hb[value].hb_persencd));
            $('#hb-rp-cash-discount').val(convertToRupiah(data_hb[value].hb_rpcd));

            $('#hb-distribution-fee').val(convertToRupiah(data_hb[value].hb_persendf));
            $('#hb-rp-distribution-fee').val(convertToRupiah(data_hb[value].hb_rpdf));
            $('#hb-total-discount').val(convertToRupiah(data_hb[value].hb_total2));

            $('#hb-bonus-kelipatan').val(convertToRupiah2(data_hb[value].hb_bnslipat));
            $('#hb-periode').val(data_hb[value].hb_periodbns);

            $('#hb-qty-beli1').val(convertToRupiah2(data_hb[value].hb_qtybeli1));
            $('#hb-qty-beli2').val(convertToRupiah2(data_hb[value].hb_qtybeli2));
            $('#hb-qty-beli3').val(convertToRupiah2(data_hb[value].hb_qtybeli3));

            $('#hb-qty-bns1').val(convertToRupiah2(data_hb[value].hb_qtybns1));
            $('#hb-qty-bns2').val(convertToRupiah2(data_hb[value].hb_qtybns2));
            $('#hb-qty-bns3').val(convertToRupiah2(data_hb[value].hb_qtybns3));
        }

        $('#btn-cetak-soic').on('click', function () {
            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
            data = {
                cetakso: cetakso
            };

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                var a;
                if (xhttp.readyState === 4 && xhttp.status === 200) {
                    a = document.createElement('a');
                    a.href = window.URL.createObjectURL(xhttp.response);
                    a.download = "SO.txt";
                    a.style.display = 'none';
                    document.body.appendChild(a);
                    a.click();
                    $('#modal-loader').modal('hide');
                }
            };
            xhttp.open("POST", "{{ url()->current() }}/cetak_so");
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            xhttp.responseType = 'blob';
            xhttp.send(JSON.stringify(data));


        });

        $('#btn-cetak').on('click', function () {
            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
            data = {
                cetak: cetak
            };

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                var a;
                if (xhttp.readyState === 4 && xhttp.status === 200) {
                    a = document.createElement('a');
                    a.href = window.URL.createObjectURL(xhttp.response);
                    a.download = "INQUIRY.txt";
                    a.style.display = 'none';
                    document.body.appendChild(a);
                    a.click();
                    $('#modal-loader').modal('hide');
                }
            };
            xhttp.open("POST", "{{ url()->current() }}/cetak");
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            xhttp.responseType = 'blob';
            xhttp.send(JSON.stringify(data));
        });


        function format_currency(value) {
            var val = (value / 1).toFixed(2).replace('.', ',');
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function toDate(value) {
            date = new Date(value);
            return date.getDate() + '-' + month[date.getMonth()] + '-' + date.getFullYear();
        }

        function clearpage() {
            $("input:text").each(function () {
                var $this = $(this);
                $this.val("");
            });
        }

        function null_check() {
            $("input:text").each(function () {
                var $this = $(this);
                if ($this.val() == "null") {
                    $this.val("");
                }
            });
        }

        $(window).bind('keydown', function (event) {
            plu = $('#plu').val();
            if (plu != '') {
                if (event.which == 34) { // Page Down
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/getNextPLU',
                        type: 'GET',
                        data: {plu: plu},
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            get_data(response);
                        }
                    });
                    event.preventDefault();
                } else if (event.which == 33) { // Page Up
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/getPrevPLU',
                        type: 'GET',
                        data: {plu: plu},
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            get_data(response);
                        }
                    });
                    event.preventDefault();
                }
            }

        });
    </script>

@endsection

