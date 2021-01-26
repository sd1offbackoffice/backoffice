@extends('navbar')
{{--@section('title','Input Penerimaan')--}}
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <fieldset class="card">
                    <legend  class="w-auto ml-5">IGR BO PENERIMAAN</legend>
                    <div class="card-body cardForm">
                        <div class="row">
                            <div class="col-sm-8">
                               <div class="card">
                                   <div class="card-body">
                                       <form>
                                           <div class="form-group row mb-1 pt-4">
                                               <label class="col-sm-2 col-form-label text-right">No BTB</label>
                                               <div class="col-sm-2 buttonInside">
                                                   <input type="text" class="form-control nullPermission" id="noBTB" value="2340000001">
                                                   <button id="btn-no-doc" type="button" class="btn btn-lov p-0" onclick="showBTB('')">
                                                       <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                   </button>
                                               </div>
                                               <label class="col-sm-1 col-form-label text-right">Tgl BTB</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control nullPermission" id="tglBTB" placeholder="dd/mm/yyyy">
                                               </div>
                                           </div>

                                           <div class="form-group row mb-1">
                                               <label class="col-sm-2 col-form-label text-right">No PO</label>
                                               <div class="col-sm-2 buttonInside">
                                                   <input type="text" class="form-control nullPermission" id="noPO">
                                                   <button id="" type="button" class="btn btn-lov p-0" onclick="showPO('')">
                                                       <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                   </button>
                                               </div>
                                               <label class="col-sm-1 col-form-label text-right">Tgl PO</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control" id="tglPO" disabled placeholder="dd/mm/yyyy">
                                               </div>
                                           </div>

                                           <div class="form-group row mb-2">
                                               <label class="col-sm-2 col-form-label text-right">Supplier</label>
                                               <div class="col-sm-2 buttonInside">
                                                   <input type="text" class="form-control nullPermission" id="kodeSupplier">
                                                   <button id="btn-no-doc" type="button" class="btn btn-lov p-0 btnLOVSupplier" onclick="showSupplier('')">
                                                       <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                   </button>
                                               </div>
                                               <div class="col-sm-7">
                                                   <input type="text" class="form-control" id="namaSupplier" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row pb-4">
                                               <label class="col-sm-2 col-form-label text-right">No Faktur</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control nullPermission" id="noFaktur">
                                               </div>
                                               <label class="col-sm-1 col-form-label text-right">Tgl Faktur</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control nullPermission" id="tglFaktur" placeholder="dd/mm/yyyy" value="{{\Carbon\Carbon::today()->format('d/m/Y')}}">
                                               </div>
                                               <label class="col-sm-1 col-form-label text-right">TOP</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right nullPermission" id="top">
                                               </div>
                                               <label class="col-sm-1 col-form-label text-right">PKP</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control nullPermission" id="pkp" disabled>
                                               </div>
                                           </div>
                                       </form>
                                   </div>
                               </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <form>
                                            <div class="form-group row mb-0">
                                                <label class="col-sm-3 col-form-label text-right">Gross</label>
                                                <input type="text" id="v_gross" class="form-control col-sm-5 text-right" disabled>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label class="col-sm-3 col-form-label text-right">Discount</label>
                                                <input type="text" id="v_discount" class="form-control col-sm-5 text-right" disabled>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label class="col-sm-3 col-form-label text-right">PPN</label>
                                                <input type="text" id="v_ppn" class="form-control col-sm-5 text-right" disabled>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label class="col-sm-3 col-form-label text-right">PPB BM</label>
                                                <input type="text" id="v_ppbBm" class="form-control col-sm-5 text-right" disabled>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label class="col-sm-3 col-form-label text-right">PPN Botol</label>
                                                <input type="text" id="v_ppnBotol" class="form-control col-sm-5 text-right" disabled>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label class="col-sm-3 col-form-label text-right">Grant Total</label>
                                                <input type="text" id="v_grantTotal" class="form-control col-sm-5 text-right" disabled>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5" id="cardInput1">
                           <div class="col-sm-12">
                               <fieldset class="card">
                                   <legend  class="w-auto ml-5 text-center">Input Transaksi Pemberlian/Penerimaan Barang</legend>
                                   <div class="card-body">
                                       <form>
                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">PLU</label>
                                               <div class="col-sm-1 buttonInside">
                                                   <input type="text" class="form-control" id="i_plu">
                                                   <button id="btn-no-doc" type="button" class="btn btn-lov p-0" onclick="showPlu('')">
                                                       <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                   </button>
                                               </div>
                                               <div class="col-sm-7">
                                                   <input type="text" class="form-control" id="i_deskripsi" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Kemasan</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control" id="i_kemasan" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Status</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control" id="i_tag" disabled>
                                               </div>

                                               <label  class="col-sm-2 col-form-label text-right">BKP</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control" id="i_bkp" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Bandrol</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_bandrol" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Harga Beli</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_hrgbeli">
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Lcost</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_lcost" disabled>
                                               </div>

                                               <label class="col-sm-2 offset-sm-2 col-form-label text-right">Acost</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="i_acost" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Kuantum</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_qty">
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Qtyk</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_qtyk">
                                               </div>

                                               <label class="col-sm-2 offset-sm-2 col-form-label text-right i_isibeli">Isi Beli</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right i_isibeli" id="i_isibeli">
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0 mt-3">
                                               <label class="col-sm-1 col-form-label text-right">Bonus I</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_bonus1">
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Bonus II</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_bonus2" disabled>
                                               </div>

                                               <label class="col-sm-2 offset-sm-2 col-form-label text-right">= Rp.</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="i_gross" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Potongan I %</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_persendis1" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Rp. </label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_rphdisc1" >
                                               </div>

                                               <label class="col-sm-1 col-form-label text-right">SAT</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_flagdisc1" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">= Rp.</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="i_disc1" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Potongan IV %</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_persendis4" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Rp. </label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_rphdisc4">
                                               </div>

                                               <label class="col-sm-1 col-form-label text-right">SAT</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_flagdisc4" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">= Rp.</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="i_disc4" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Potongan II %</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_persendis2" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Rp. </label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_rphdisc2">
                                               </div>

                                               <label class="col-sm-1 col-form-label text-right">SAT</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_flagdisc2" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">= Rp.</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="i_disc2" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Potongan II A %</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_persendis2a" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Rp. </label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_rphdisc2a" >
                                               </div>

                                               <label class="col-sm-2 offset-sm-2 col-form-label text-right">= Rp.</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="i_disc2a" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Potongan II B %</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_persendis2b" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Rp. </label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_rphdisc2b" >
                                               </div>

                                               <label class="col-sm-2 offset-sm-2 col-form-label text-right">= Rp.</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="i_disc2b" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Potongan III %</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_persendis3" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Rp. </label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_rphdisc3" >
                                               </div>

                                               <label class="col-sm-1 col-form-label text-right">SAT</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_flagdisc3" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">= Rp.</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="i_disc3" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0 mt-3">
                                               <label class="col-sm-1 col-form-label text-right">Keterangan</label>
                                               <div class="col-sm-6">
                                                   <input type="text" class="form-control text-uppercase" id="i_keterangan">
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">PPN</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="i_ppn" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-2 offset-sm-7 col-form-label text-right">Botol</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="i_botol" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-2 offset-sm-7 col-form-label text-right">BM</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="i_bm" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Jumlah Item</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="sum_item" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Total PO </label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="i_totalpo" disabled>
                                               </div>

                                               <label class="col-sm-2 offset-sm-2 col-form-label text-right">Total</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="i_total" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0 mt-5">
                                               <div class="col-sm-3 text-center">
                                                   <button type="button" class="btn btn-primary btn-block" onclick="rekamData()">Rekam Record</button>
                                               </div>
                                               <div class="col-sm-3 text-center">
                                                   <button type="button" class="btn btn-primary btn-block" onclick="transferPO()">Transfer PO</button>
                                               </div>
                                               <div class="col-sm-3 text-center">
                                                   <button type="button" class="btn btn-primary btn-block" onclick="viewList()">List/Hapus Record</button>
                                               </div>
                                               <div class="col-sm-3 text-center">
                                                   <button type="button" class="btn btn-primary btn-block">Simpan Data</button>
                                               </div>
                                           </div>
                                       </form>
                                   </div>
                               </fieldset>
                           </div>
                        </div>

                        <div class="row mt-5" id="cardInput2">
                            <div class="col-sm-12">
                                <div class="card shadow-lg">
                                    <div class="card-body">
                                        <div class="sticky-table sticky-ltr-cells">
                                            <table class="table table-sm table-bordered table-striped">
                                                <thead class="text-center">
                                                <tr class="sticky-header">
                                                    <th class="sticky-cell" scope="col" style="min-width: 100px">PLU</th>
                                                    <th class="sticky-cell" scope="col" style="min-width: 500px !important;">Deskripsi</th>
                                                    <th class="sticky-cell" style="min-width: 70px">Qty</th>
                                                    <th class="sticky-cell" style="min-width: 70px">QtyK</th>
                                                    <th class="sticky-cell" style="min-width: 150px">Hrg Satuan</th>
                                                    <th class="sticky-cell" style="min-width: 70px">Kemasan</th>
                                                    <th scope="col" class="text-center" style="min-width: 70px">Tag</th>
                                                    <th scope="col" class="text-center" style="min-width: 70px">BKP</th>
                                                    <th scope="col" class="text-center" style="min-width: 100px">Bonus 1</th>
                                                    <th scope="col" class="text-center" style="min-width: 100px">Bonus 2</th>
                                                    <th scope="col" class="text-center" style="min-width: 100px">%Disc 1</th>
                                                    <th scope="col" class="text-center" style="min-width: 100px">Disc 1</th>
                                                    <th scope="col" class="text-center" style="min-width: 100px">%Disc 2</th>
                                                    <th scope="col" class="text-center" style="min-width: 100px">Disc 2</th>
                                                    <th scope="col" class="text-center" style="min-width: 100px">%Disc 2II</th>
                                                    <th scope="col" class="text-center" style="min-width: 100px">Disc 2II</th>
                                                    <th scope="col" class="text-center" style="min-width: 100px">%Disc 2III</th>
                                                    <th scope="col" class="text-center" style="min-width: 100px">Disc 2III</th>
                                                    <th scope="col" class="text-center" style="min-width: 100px">%Disc 3</th>
                                                    <th scope="col" class="text-center" style="min-width: 100px">Disc 3</th>
                                                    <th scope="col" class="text-center" style="min-width: 100px">$Disc 4</th>
                                                    <th scope="col" class="text-center" style="min-width: 100px">Disc 4</th>
                                                    <th scope="col" class="text-center" style="min-width: 150px">Gross</th>
                                                    <th scope="col" class="text-center" style="min-width: 70px">PPN</th>
                                                    <th scope="col" class="text-center" style="min-width: 150px">Average Cost</th>
                                                    <th scope="col" class="text-center" style="min-width: 150px">Last Cost</th>
                                                </tr>
                                                </thead>
                                                <tbody class="tbodyTableDetail">
                                                <tr class="rowTbodyTableDetail">
                                                    <td class="sticky-cell">PLU2</td>
                                                    <td class="sticky-cell">Deskripsi</td>
                                                    <td class="sticky-cell" >Qty</td>
                                                    <td class="sticky-cell" >QtyK</td>
                                                    <td class="sticky-cell" >Hrg Satuan</td>
                                                    <td class="sticky-cell" >Kemasan</td>
                                                    <td>Tag</td>
                                                    <td>BKP</td>
                                                    <td>Bonus 1</td>
                                                    <td>Bonus 2</td>
                                                    <td>%Disc 1</td>
                                                    <td>Disc 1</td>
                                                    <td>%Disc 2</td>
                                                    <td>Disc 2</td>
                                                    <td>%Disc 2II</td>
                                                    <td>Disc 2II</td>
                                                    <td>%Disc 2III</td>
                                                    <td>Disc 2III</td>
                                                    <td>%Disc 3</td>
                                                    <td>Disc 3</td>
                                                    <td>$Disc 4</td>
                                                    <td>Disc 4</td>
                                                    <td>Gross</td>
                                                    <td>PPN</td>
                                                    <td>Average Cost</td>
                                                    <td>Last Cost</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <form class="mt-3">
                                            <div class="form-group row mb-0 mt-5">
                                                <div class="col-sm-3 offset-sm-1 text-center">
                                                    <button type="button" class="btn btn-primary btn-block" onclick="closeCardInput2()">Tutup Daftar</button>
                                                </div>
                                                {{--<div class="col-sm-3 offset-sm-1 text-center">--}}
                                                    {{--<button type="button" class="btn btn-primary btn-block">Koreksi</button>--}}
                                                {{--</div>--}}
                                                <div class="col-sm offset-sm-1 text-center">
                                                    {{--<button type="button" class="btn btn-primary btn-block">Hapus Record</button>--}}
                                                    <p class="text-secondary text-right">* Klik Plu untuk koreksi atau hapus</p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <!-- Modal LOV-->
    <div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="m_lov" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="searchModal" class="form-control search_lov searchModal" type="text" placeholder="..." aria-label="Search">
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
                                            <th id="modalThName3"></th>
                                            <th id="modalThName4"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbodyModalHelp"></tbody>
                                    </table>
                                    <p class="text-hide" id="idModal"></p>
                                    <p class="text-hide" id="idRow"></p>
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

    <!-- Modal LOV Plu-->
    <div class="modal fade" id="modalHelpPlu" tabindex="-1" role="dialog" aria-labelledby="m_lovPlu" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="searchModal" class="form-control search_lov searchModal" type="text" placeholder="..." aria-label="Search">
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
                                            <th style="min-width: 300px !important;">Barang</th>
                                            <th>PLU</th>
                                            <th>Kemasan</th>
                                            <th>Qty Ctn</th>
                                            <th>QtyK</th>
                                            <th>Bonus1</th>
                                            <th>Bonus2</th>
                                            <th>Persen disc1</th>
                                            <th>Disc Rph1</th>
                                            <th>Persen disc2</th>
                                            <th>Disc Rph2</th>
                                            <th>Persen disc3</th>
                                            <th>Disc Rph3</th>
                                            <th>Disc Rph4</th>
                                            <th>No PO</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbodyModalHelpPlu"></tbody>
                                    </table>
                                    {{--<p class="text-hide" id="idModal"></p>--}}
                                    {{--<p class="text-hide" id="idRow"></p>--}}
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

    <!-- Modal Detail-->
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="m_detail" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div id="table-scroll" class="table-scroll">
                                    <div class="table-wrap">
                                        <table class="main-table table-bordered ">
                                            <thead>
                                            <tr>
                                                <th class="fixed-side" scope="col">PLU</th>
                                                <th class="fixed-side" scope="col">Deskripsi</th>
                                                <th class="fixed-side" >Qty</th>
                                                <th class="fixed-side" >QtyK</th>
                                                <th class="fixed-side" >Hrg Satuan</th>
                                                <th class="fixed-side" >Kemasan</th>
                                                <th scope="col">Tag</th>
                                                <th scope="col">BKP</th>
                                                <th scope="col">Bonus 1</th>
                                                <th scope="col">Bonus 2</th>
                                                <th scope="col">%Disc 1</th>
                                                <th scope="col">Disc 1</th>
                                                <th scope="col">%Disc 2</th>
                                                <th scope="col">Disc 2</th>
                                                <th scope="col">%Disc 2II</th>
                                                <th scope="col">Disc 2II</th>
                                                <th scope="col">%Disc 2III</th>
                                                <th scope="col">Disc 2III</th>
                                                <th scope="col">%Disc 3</th>
                                                <th scope="col">Disc 3</th>
                                                <th scope="col">$Disc 4</th>
                                                <th scope="col">Disc 4</th>
                                                <th scope="col">Gross</th>
                                                <th scope="col">PPN</th>
                                                <th scope="col">Average Cost</th>
                                                <th scope="col">Last Cost</th>
                                            </tr>
                                            </thead>
                                            <tbody class="tbodyTableDetail">
                                            @for($i=0;$i<15;$i++)
                                                <tr class="rowTbodyTableDetail">
                                                    <td class="fixed-side" scope="col">PLU</td>
                                                    <td class="fixed-side" scope="col">Deskripsi</td>
                                                    <td class="fixed-side" >Qty</td>
                                                    <td class="fixed-side" >QtyK</td>
                                                    <td class="fixed-side" >Hrg Satuan</td>
                                                    <td class="fixed-side" >Kemasan</td>
                                                    <td scope="col">Tag</td>
                                                    <td scope="col">BKP</td>
                                                    <td scope="col">Bonus 1</td>
                                                    <td scope="col">Bonus 2</td>
                                                    <td scope="col">%Disc 1</td>
                                                    <td scope="col">Disc 1</td>
                                                    <td scope="col">%Disc 2</td>
                                                    <td scope="col">Disc 2</td>
                                                    <td scope="col">%Disc 2II</td>
                                                    <td scope="col">Disc 2II</td>
                                                    <td scope="col">%Disc 2III</td>
                                                    <td scope="col">Disc 2III</td>
                                                    <td scope="col">%Disc 3</td>
                                                    <td scope="col">Disc 3</td>
                                                    <td scope="col">$Disc 4</td>
                                                    <td scope="col">Disc 4</td>
                                                    <td scope="col">Gross</td>
                                                    <td scope="col">PPN</td>
                                                    <td scope="col">Average Cost</td>
                                                    <td scope="col">Last Cost</td>
                                                </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
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

    <!-- Modal Lotorisasi-->
    <div class="modal fade" id="modalLotorisasi" tabindex="-1" role="dialog" aria-labelledby="m_Lotorisasi" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p>Otoritasi Penolakan PO</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <form>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">User</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">OK</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .rowTbodyTableDetail{
            cursor: pointer;
        }

        .rowTbodyTableDetail:hover{
            background-color: #e9ecef;
        }


    </style>

    <script>
        let typeTrn;
        let flagNewBTB      = 'N';
        let tempPO          = [];
        let tempSupplier    = [];
        let tempPlu         = [];
        let tempDataBTB     = [];
        let tempDataPLU     = [];
        let tempDataSave    = '';
        let modalThName1    = $('#modalThName1');
        let modalThName2    = $('#modalThName2');
        let modalThName3    = $('#modalThName3');
        let modalThName4    = $('#modalThName4');
        let modalHelp       = $('#modalHelp');
        let modalHelpPlu    = $('#modalHelpPlu');
        let noBTB           = $('#noBTB');
        let noPO            = $('#noPO');
        let tglBTB          = $('#tglBTB');
        let tglPO           = $('#tglPO');
        let kodeSupp        = $('#kodeSupplier');
        let namaSupp        = $('#namaSupplier');
        let noFaktur        = $('#noFaktur');
        let tglFaktur       = $('#tglFaktur');
        let pkp             = $('#pkp');
        let topPo           = $('#top');

         let v_gross        = $('#v_gross');
         let v_discount     = $('#v_discount');
         let v_ppn          = $('#v_ppn');
         let v_ppbBm        = $('#v_ppbBm');
         let v_ppnBotol     = $('#v_ppnBotol');
         let v_grantTotal   = $('#v_grantTotal');

        let i_plu       = $('#i_plu');
        let i_deskripsi = $('#i_deskripsi');
        let i_kemasan   = $('#i_kemasan');
        let i_tag       = $('#i_tag');
        let i_bkp       = $('#i_bkp');
        let i_bandrol   = $('#i_bandrol');
        let i_hrgbeli   = $('#i_hrgbeli');
        let i_lcost     = $('#i_lcost');
        let i_acost     = $('#i_acost');
        let i_qty       = $('#i_qty');
        let i_qtyk      = $('#i_qtyk');
        let i_isibeli   = $('#i_isibeli');
        let i_bonus1    = $('#i_bonus1');
        let i_bonus2    = $('#i_bonus2');
        let i_gross     = $('#i_gross');
        let i_persendis1= $('#i_persendis1');
        let i_rphdisc1  = $('#i_rphdisc1');
        let i_flagdisc1 = $('#i_flagdisc1');
        let i_disc1     = $('#i_disc1');
        let i_persendis2= $('#i_persendis2');
        let i_rphdisc2  = $('#i_rphdisc2');
        let i_flagdisc2 = $('#i_flagdisc2');
        let i_disc2     = $('#i_disc2');
        let i_persendis2a= $('#i_persendis2a');
        let i_rphdisc2a  = $('#i_rphdisc2a');
        let i_disc2a     = $('#i_disc2a');
        let i_persendis2b= $('#i_persendis2b');
        let i_rphdisc2b  = $('#i_rphdisc2b');
        let i_disc2b     = $('#i_disc2b');
        let i_persendis3= $('#i_persendis3');
        let i_rphdisc3  = $('#i_rphdisc3');
        let i_flagdisc3 = $('#i_flagdisc3');
        let i_disc3     = $('#i_disc3');
        let i_persendis4= $('#i_persendis4');
        let i_rphdisc4  = $('#i_rphdisc4');
        let i_flagdisc4 = $('#i_flagdisc4');
        let i_disc4     = $('#i_disc4');
        let i_keterangan= $('#i_keterangan');
        let i_ppn       = $('#i_ppn');
        let i_botol     = $('#i_botol');
        let i_bm        = $('#i_bm');
        let sum_item    = $('#sum_item');
        let i_totalpo   = $('#i_totalpo');
        let i_total     = $('#i_total');



        let isiBeliForm = $('.i_isibeli');

        tglBTB.datepicker({
            "dateFormat" : "dd/mm/yy",
        });

        tglPO.datepicker({
            "dateFormat" : "dd/mm/yy",
        });

        tglFaktur.datepicker({
            "dateFormat" : "dd/mm/yy",
        });

        $(document).ready(function () {
            // startAlert();
            $('#cardInput2').hide();
            typeTrn = 'B'
            // showPO('');
            // chooseBTB('0420000613', 'GH6H71400')
            choosePO('PH1L76267')
            // choosePO('5H1L79346')
            // showPlu('');
            isiBeliForm.hide()

            // deletePlu('123')

        });

        function startAlert() {
            swal({
                title: 'Jenis Penerimaan?',
                icon: 'info',
                buttons: {
                    confirm: "Penerimaan",
                    roll: {
                        text: "Lain-lain",
                        value: "lain",
                    },
                }
            }).then(function (confirm) {
                switch (confirm) {
                    case true:
                        typeTrn = 'B';
                        break;

                    case "lain":
                        typeTrn = 'L';
                        break;

                    default:
                        typeTrn = 'N';
                }
                noBTB.focus();
            })
        }

        function showBTB(value) {
            if(!typeTrn || typeTrn === 'N'){
                startAlert();

                return false;
            }

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/penerimaan/input/showbtb',
                type: 'post',
                data: {
                    typeTrn : typeTrn,
                    value   : value
                }, beforeSend : () => {
                    $('#modal-loader').modal('show');
                    modalHelp.modal('hide');
                }, success: function (result) {
                    $('#modal-loader').modal('hide');
                    modalThName1.text('No Dokumen');
                    modalThName2.text('No PO');
                    modalThName3.text('Tgl BTB');
                    modalThName3.show();
                    modalThName4.hide();

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseBTB('"+ result[i].trbo_nodoc +"','"+ result[i].trbo_nopo +"') class='modalRow'><td>"+ result[i].trbo_nodoc +"</td> <td>"+ result[i].trbo_nopo +"</td> <td>"+ formatDate(result[i].trbo_tglreff)+"</td></tr>")
                    }

                    modalHelp.modal('show');
                    $('#idModal').val('BTB');
                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message)
                }
            })
        }

        function chooseBTB(noDoc, noPo) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/penerimaan/input/choosebtb',
                type: 'post',
                data: {
                    noDoc:noDoc,
                    noPO:noPo,
                    typeTrn:typeTrn
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                    $('.rowTbodyTableDetail').remove();
                    modalHelp.modal('hide');
                    tempDataBTB = [];
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    tempDataBTB = result.data; console.log(result.data)

                    if (result.kode == 0){
                        swal("", result.msg, 'warning');
                        $('#cardInput2').hide();
                        $('#cardInput1').show();
                    } else {
                        // for (let i = 0; i< result.data.length; i++){
                        //     value = result.data[i];
                        //
                        //     $('.tbodyTableDetail').append(`<tr class="rowTbodyTableDetail"  onclick="editDeletePlu()">
                        //                                         <td class="sticky-cell">`+ value.trbo_prdcd +`</td>
                        //                                         <td class="sticky-cell">`+ value.prd_deskripsipanjang +`</td>
                        //                                         <td class="sticky-cell text-right" >`+ value.qty +`</td>
                        //                                         <td class="sticky-cell text-right" >`+ (value.trbo_qty - (value.qty * value.prd_frac)) +`</td>
                        //                                         <td class="sticky-cell text-right" >`+ convertToRupiah(value.trbo_hrgsatuan)+`</td>
                        //                                         <td class="sticky-cell text-center" >/`+ value.prd_frac +`</td>
                        //                                         <td>`+value.prd_kodetag+`</td>
                        //                                         <td>`+value.prd_flagbkp1+`</td>
                        //                                         <td  class="text-right">`+value.trbo_qtybonus1+`</td>
                        //                                         <td  class="text-right">`+value.trbo_qtybonus2+`</td>
                        //                                         <td  class="text-right">`+convertToRupiah(value.trbo_persendisc1)+`</td>
                        //                                         <td  class="text-right">`+convertToRupiah(value.trbo_rphdisc1)+`</td>
                        //                                         <td  class="text-right">`+value.trbo_persendisc2+`</td>
                        //                                         <td  class="text-right">`+convertToRupiah(value.trbo_rphdisc2)+`</td>
                        //                                         <td  class="text-right">`+value.trbo_persendisc2ii+`</td>
                        //                                         <td  class="text-right">`+convertToRupiah(value.trbo_rphdisc2ii)+`</td>
                        //                                         <td  class="text-right">`+value.trbo_persendisc2iii+`</td>
                        //                                         <td  class="text-right">`+convertToRupiah(value.trbo_rphdisc2iii)+`</td>
                        //                                         <td  class="text-right">`+value.trbo_persendisc3+`</td>
                        //                                         <td  class="text-right">`+convertToRupiah(value.trbo_rphdisc3)+`</td>
                        //                                         <td  class="text-right">`+value.trbo_persendisc4+`</td>
                        //                                         <td  class="text-right">`+convertToRupiah2(value.trbo_rphdisc4)+`</td>
                        //                                         <td  class="text-right">`+convertToRupiah2(value.trbo_gross)+`</td>
                        //                                         <td  class="text-right">`+convertToRupiah2(value.trbo_ppnrph)+`</td>
                        //                                         <td  class="text-right">`+convertToRupiah(value.trbo_averagecost)+`</td>
                        //                                         <td  class="text-right">`+convertToRupiah(value.trbo_oldcost)+`</td>
                        //                                     </tr>`);
                        // }
                        setValueTableDetail(result.data)

                        noBTB.val(result.data[0].trbo_nodoc);
                        noPO.val(result.data[0].trbo_nopo);
                        tglBTB.val(formatDate(result.data[0].trbo_tgldoc));
                        tglPO.val(formatDate(result.data[0].trbo_tglpo));
                        kodeSupp.val(result.data[0].trbo_kodesupplier);
                        namaSupp.val(result.data[0].sup_namasupplier);
                        noFaktur.val(result.data[0].trbo_nofaktur);
                        tglFaktur.val(formatDate(result.data[0].trbo_tglfaktur));
                        pkp.val(result.data[0].sup_pkp);

                        $('#cardInput2').show();
                        $('#cardInput1').hide();
                        $( document ).trigger( "stickyTable" );
                    }
                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message)
                }
            })
        }

        function closeCardInput2() {
            $('#cardInput2').hide();
            $('#cardInput1').show();
        }

        function getNewNoBTB() {
            if(!typeTrn || typeTrn === 'N'){
                startAlert();

                return false;
            }

            swal({
                title: 'Buat Nomor Penerimaan Baru?',
                icon: 'info',
                buttons: true,
            }).then(function (confirm) {
               if (confirm){
                   ajaxSetup();
                   $.ajax({
                       url: '/BackOffice/public/bo/transaksi/penerimaan/input/getnewnobtb',
                       type: 'post',
                       data: {
                           typeTrn: typeTrn
                       }, beforeSend : () => {
                           $('#modal-loader').modal('show');
                       },
                       success: function (result) {
                           $('#modal-loader').modal('hide');
                           if (result.length > 0) {
                               noBTB.val(result);
                               tglBTB.focus();
                               tempDataBTB = [];
                               clearSecondField();
                           }
                       }, error: function (err) {
                           $('#modal-loader').modal('hide');
                           console.log(err.responseJSON.message.substr(0,100));
                           alertError(err.statusText, err.responseJSON.message)
                       }
                   });
               } else {
                   console.log('Cancel!')
               }

            })
        }

        function showPO(value) {
            if(!typeTrn || typeTrn === 'N'){
                startAlert();

                return false;
            }

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/penerimaan/input/showpo',
                type: 'post',
                data: {
                    typeTrn : typeTrn,
                    value   : value,
                }, beforeSend : function() {
                    $('#modal-loader').modal('show');
                    modalHelp.modal('hide');
                }, success: function (result) {
                    $('#modal-loader').modal('hide');

                    modalThName1.text('No PO');
                    modalThName2.text('Tgl PO');
                    modalThName3.text('Kode Supplier');
                    modalThName4.text('Nama Supplier');
                    modalThName3.show();
                    modalThName4.show();

                    tempPO = result;

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=choosePO('"+ result[i].tpoh_nopo +"') class='modalRow'><td>"+ result[i].tpoh_nopo +"</td><td>"+ formatDate(result[i].tpoh_tglpo)+"</td><td>"+ result[i].tpoh_kodesupplier +"</td><td>"+ result[i].sup_namasupplier +"</td></tr>")
                    }

                    $('#idModal').val('PO');
                    modalHelp.modal('show');
                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            })
        }

        function choosePO(noPo) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/penerimaan/input/choosepo',
                type: 'post',
                data: {
                    typeTrn : typeTrn,
                    noPo    : noPo
                }, beforeSend: function () {
                    modalHelp.modal('hide');
                    $('#modal-loader').modal('show');
                }, success: function (result) {
                    $('#modal-loader').modal('hide');

                    if (result.kode == 0){
                        swal("", result.msg, 'warning');
                        noPO.focus()
                    } else if(result.kode == 2){
                        swal({
                            icon: 'warning',
                            text: result.msg,
                            buttons: false,
                            timer: 2000,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                        });

                        setTimeout(() => {  $('#modalLotorisasi').modal('show'); }, 2000);
                    } else {
                        let data = result['data'][0];

                        noPO.val(data.tpoh_nopo);
                        tglPO.val(formatDate(data.tpoh_tglpo));
                        kodeSupp.val(data.tpoh_kodesupplier);
                        namaSupp.val(data.sup_namasupplier);
                        pkp.val(data.sup_pkp);
                        topPo.val(data.tpoh_top);

                        kodeSupp.attr('disabled', true);
                        $('.btnLOVSupplier').attr('disabled', true);
                        noFaktur.focus();
                    }

                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            });


        }

        function showSupplier(value) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/penerimaan/input/showsupplier',
                type: 'post',
                data: {
                    typeTrn : typeTrn,
                    value   : value,
                }, beforeSend : function () {
                    $('#modal-loader').modal('show');
                    modalHelp.modal('hide');
                }, success: function (result) {
                    $('#modal-loader').modal('hide');
                    tempSupplier = result;

                    modalThName1.text('Nama Supplier');
                    modalThName2.text('Kode Supplier');
                    modalThName3.text('PKP');
                    modalThName4.text('TOP');
                    modalThName3.show();
                    modalThName4.show();

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseSupplier('"+ result[i].sup_kodesupplier +"') class='modalRow'><td>"+ result[i].sup_namasupplier +"</td><td>"+ result[i].sup_kodesupplier +"</td><td>"+ result[i].sup_pkp +"</td><td>"+ result[i].sup_top +"</td></tr>")
                    }

                    $('#idModal').val('Supplier');
                    modalHelp.modal('show');
                },  error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            })
        }

        function chooseSupplier(supp) {
            if(typeTrn == 'L'){
                swal('','Kode Supplier Tidak Boleh Diisi !!', 'warning')
                kodeSupp.val('');
                namaSupp.val('');
                noFaktur.focus();
            } else {
                for(let i = 0; i< tempSupplier.length; i++){
                    if (tempSupplier[i].sup_kodesupplier === supp){
                        kodeSupp.val(tempSupplier[i].sup_kodesupplier);
                        namaSupp.val(tempSupplier[i].sup_namasupplier);
                        pkp.val(tempSupplier[i].sup_pkp);
                        topPo.val(tempSupplier[i].sup_top);
                    }
                }
            }

            modalHelp.modal('hide');
        }

        function showPlu(value) {
            let supplier    = kodeSupp.val();
            let noPo        = noPO.val();
            let typeLov     = '';

            if (typeTrn == 'B'){
                if (noPo == ''){
                    if (supplier == ''){
                        swal({
                            icon: 'info',
                            title: "Isi Supplier!",
                            text:'       ',
                            buttons: false,
                            timer: 2000,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                        });

                        kodeSupp.focus();
                    } else {
                        typeLov = 'PLU';
                    }
                } else {
                    if (supplier != ''){
                        typeLov = 'PLU_PO';
                    } else {
                        kodeSupp.focus();
                    }
                }
            } else {
                typeLov = 'LOV155';
            }

            console.log(typeLov)
            ajaxSetup();

            $.ajax({
                url: '/BackOffice/public/bo/transaksi/penerimaan/input/showplu',
                type: 'post',
                data: {
                    typeTrn : typeTrn,
                    value   : value,
                    supplier: supplier,
                    noPo    : noPo,
                    typeLov : typeLov
                }, beforeSend: () => {
                    $('#modal-loader').modal('show');
                    modalHelpPlu.modal('hide');
                    modalHelp.modal('hide');
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    console.log(result)

                    if(typeLov == 'PLU_PO'){
                        tempPlu = result;

                        $('.modalRow').remove();
                        for (i = 0; i< result.length; i++){
                            $('#tbodyModalHelpPlu').append("<tr onclick=choosePlu('"+ result[i].tpod_prdcd +"') class='modalRow text-right'><td class='text-left'>"+ result[i].prd_deskripsipanjang +"</td><td class='text-left'>"+ result[i].tpod_prdcd+"</td><td class='text-left'>"+ result[i].kemasan +"</td><td>"+ result[i].qty+"</td>" +
                                "<td>"+ result[i].qtyk+"</td><td>"+ result[i].bonus1+"</td><td>"+ result[i].bonus2+"</td><td>"+ result[i].tpod_persentasedisc1+"</td><td>"+ result[i].tpod_rphdisc1+"</td><td>"+ result[i].tpod_persentasedisc2+"</td>" +
                                "<td>"+ result[i].tpod_rphdisc2+"</td><td>"+ result[i].tpod_persentasedisc3+"</td><td>"+ result[i].tpod_rphdisc3+"</td><td>"+ result[i].tpod_rphdisc4+"</td><td class='text-left'>"+ result[i].tpod_nopo+"</td> </tr>")
                        }

                        modalHelpPlu.modal('show');
                    } else {
                        modalThName1.text('Nama Barang');
                        modalThName2.text('PLU');
                        modalThName3.hide();
                        modalThName4.hide();

                        $('.modalRow').remove();
                        for (i = 0; i< result.length; i++){
                            $('#tbodyModalHelp').append("<tr onclick=choosePlu('"+ result[i].prd_prdcd +"') class='modalRow'><td>"+ result[i].prd_deskripsipanjang +"</td><td>"+ result[i].prd_prdcd +"</td></tr>")
                        }

                        modalHelp.modal('show');
                    }

                    $('#idModal').val('PLU');

                },  error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            })
        }

        function choosePlu(plu) {
            let temp    = convertPlu(plu);
            let prdcd   = temp.replace(temp.substr(6,1), '0');
            let noDoc   = noBTB.val();
            let noPo    = noPO.val();
            let supplier= kodeSupp.val();

            let tempData = (tempDataBTB.length < 1) ? tempDataSave : tempDataBTB;

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/penerimaan/input/chooseplu',
                type: 'post',
                data: {
                    typeTrn : typeTrn,
                    prdcd   : prdcd,
                    noDoc   : noDoc,
                    noPo    : noPo,
                    supplier:supplier,
                    tempData:tempData
                }, beforeSend : function () {
                    $('#modal-loader').modal('show');
                    modalHelpPlu.modal('hide');
                    i_rphdisc1.attr('disabled', false)
                    i_rphdisc2.attr('disabled', false)
                    i_rphdisc2a.attr('disabled', false)
                    i_rphdisc2b.attr('disabled', false)
                    i_rphdisc3.attr('disabled', false)
                    i_rphdisc4.attr('disabled', false)
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');

                    console.log(result)

                    if(result.kode == '0'){
                        let data = result.data;
                        tempDataPLU = data;
                        setValue(data);
                        i_hrgbeli.focus();

                    } else if(result.kode == '2'){
                        swal({
                            icon: 'warning',
                            text: result.msg,
                            buttons: false,
                            timer: 2000,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                        });

                        setTimeout(function(){
                            i_plu.val(prdcd);
                            i_plu.focus();
                        }, 2000);
                    }

                },  error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            })

        }

        function changeHargaBeli(hrgBeli, qty, qtyk) {
           if (!noPO.val() && !kodeSupp.val()){
               swal({
                   text: 'Nilai Harga Beli Untuk Penerimaan Lain Lain Harus 0 !!',
                   icon:'warning',
                   timer: 1500,
                   buttons: {
                       confirm: false,
                   },
               });
               i_hrgbeli.val('0');
               i_hrgbeli.focus();
               return false;
           }
           else if(hrgBeli <= 0) {
               swal({
                   text: 'Nilai Harga Beli Tidak Boleh <= 0 !!',
                   icon:'warning',
                   timer: 1500,
                   buttons: {
                       confirm: false,
                   },
               });
               i_hrgbeli.val('0');
               i_hrgbeli.focus();
               return false;
           }

           ajaxSetup();
           $.ajax({
               url: '/BackOffice/public/bo/transaksi/penerimaan/input/changehargabeli',
               type: 'post',
               data: {hargaBeli : unconvertToRupiah(hrgBeli), qty:qty, qtyk:qtyk, prdcd : i_plu.val(), supplier: kodeSupp.val(), noPo : noPO.val(), tempDataPLU : tempDataPLU},
               beforeSend : () =>{
                   $('#modal-loader').modal('show');
               },
               success: (result) => {
                   $('#modal-loader').modal('hide');
                   console.log(result);

                   if (result.kode == 0){
                       swal('', result.msg, 'warning');
                   } else {
                       tempDataPLU = result.data;
                       setValue(result.data);
                       i_qty.focus();
                       console.log(result.data)
                   }

               }, error : (err) => {
                   $('#modal-loader').modal('hide');
                   console.log(err.responseJSON.message.substr(0,100));
                   alertError(err.statusText, err.responseJSON.message);
               }
           });
        }

        function changeQty(qty, qtyk, hrgbeli,next) {

            if (!noPO.val() && !kodeSupp.val() && qty != 0){
                swal({
                    text: 'Untuk BPB Lain Lain, Kolom Qty = 0 !!',
                    icon:'warning',
                    timer: 1500,
                    buttons: {
                        confirm: false,
                    },
                });
                i_qty.val(0);
            } else {
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/bo/transaksi/penerimaan/input/changeqty',
                    type: 'post',
                    data: {hargaBeli : hrgbeli, prdcd : i_plu.val(), supplier: kodeSupp.val(), noPo : noPO.val(), qty:qty, qtyk : qtyk, tempDataPLU : tempDataPLU},
                    beforeSend : () =>{
                        $('#modal-loader').modal('show');
                    },
                    success: (result) => {
                        $('#modal-loader').modal('hide');
                        next();

                        if (result.kode == 1){
                            tempDataPLU = result.data;
                            setValue(result.data);

                        } else {
                            swal('', result.msg, 'warning');
                        }
                    }, error : (err) => {
                        $('#modal-loader').modal('hide');
                        console.log(err.responseJSON.message.substr(0,100));
                        alertError(err.statusText, err.responseJSON.message);
                    }
                });
            }

        }

        function changeBonus1(bonus1) {
            if ((bonus1 == 0 || !bonus1) &&!noPO.val() && !kodeSupp.val()){
                swal({
                    text: 'Pada Transaksi Bonus, Qty Bonus Harus Diisi !!',
                    icon:'warning',
                    timer: 1500,
                    buttons: {
                        confirm: false,
                    },
                });
                i_bonus1.focus();
                return false;
            }

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/penerimaan/input/changebonus1',
                type: 'post',
                data: {bonus1 : bonus1, prdcd : i_plu.val(), supplier: kodeSupp.val(), noPo : noPO.val(), tempDataPLU : tempDataPLU},
                beforeSend : () =>{
                    $('#modal-loader').modal('show');
                },
                success: (result) => {
                    $('#modal-loader').modal('hide');
                    console.log(result);

                    if (result.kode == 0){
                        swal('', result.msg, 'warning');
                    } else {
                        tempDataPLU = result.data;
                        setValue(result.data);
                        checkRphDisc();
                    }

                }, error : (err) => {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            });
        }

        function changeRphDisc(next) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/penerimaan/input/changerphdisc',
                type: 'post',
                data: {prdcd : i_plu.val(), supplier: kodeSupp.val(), noPo : noPO.val(), tempDataPLU : tempDataPLU},
                beforeSend : () =>{
                    $('#modal-loader').modal('show');
                },
                success: (result) => {
                    $('#modal-loader').modal('hide');
                    next();

                    if (result.kode == 0){
                        swal('', result.msg, 'warning');
                    } else {
                        tempDataPLU = result.data;
                        setValue(result.data);
                    }

                }, error : (err) => {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            });
        }

        function rekamData(){
            if(!i_plu.val()){
                swal({
                    text: 'Plu Harus Diisi !!',
                    icon:'warning',
                    timer: 1500,
                    buttons: {
                        confirm: false,
                    },
                });

                i_plu.focus();
                return false;
            }

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/penerimaan/input/rekamdata',
                type: 'post',
                data: {prdcd : i_plu.val(), noBTB: noBTB.val(), noPo : noPO.val(), tempDataPLU : tempDataPLU, tempDataSave:tempDataSave},
                beforeSend : () =>{
                    $('#modal-loader').modal('show');
                },
                success: (result) => {
                    $('#modal-loader').modal('hide');
                    console.log((result))

                    if (result.kode == 0){
                        swal('', result.msg, 'warning');
                    } else {
                        tempDataSave = result.data;

                        let gross = 0;
                        let discount = 0;
                        let ppn = 0;
                        let ppbbm = 0;
                        let ppnbotol = 0;
                        let grantTotal = 0;
                        for (let i=0; i < tempDataSave.length; i++){
                            gross   = parseInt(gross) + parseInt(tempDataSave[i].trbo_gross);
                            discount= parseInt(discount) + parseInt(unconvertToRupiah(tempDataSave[i].total_disc));
                            ppn     = parseInt(ppn) +  parseInt(tempDataSave[i].trbo_ppnrph);
                            ppbbm   = parseInt(ppbbm) +  parseInt(tempDataSave[i].trbo_ppnbmrph);
                            ppnbotol = parseInt(ppnbotol) +  parseInt(tempDataSave[i].trbo_ppnbtlrph);
                            grantTotal = parseInt(grantTotal) + parseInt(tempDataSave[i].total_rph);
                        }

                        sum_item.val(tempDataSave.length);
                        i_totalpo.val(convertToRupiah(grantTotal));
                        v_gross.val(convertToRupiah(gross));
                        v_discount.val(convertToRupiah(discount));
                        v_ppn.val(convertToRupiah(ppn));
                        v_ppbBm.val(convertToRupiah(ppbbm));
                        v_ppnBotol.val(convertToRupiah(ppnbotol));
                        v_grantTotal.val(convertToRupiah(grantTotal));
                        clearSecondField();
                    }

                }, error : (err) => {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            });
        }

        function viewList(){
            $('#cardInput2').show();
            $('#cardInput1').hide();

            if (tempDataBTB.length > 0){
                setValueTableDetail(tempDataBTB)
                console.log(tempDataBTB)
            } else if (tempDataSave.length > 0){
                setValueTableDetail(tempDataSave)
                console.log(tempDataSave)
            } else {
                console.log('Kosong')
            }
        }

        function editDeletePlu(plu){
            swal("Koreksi atau Hapus Plu "+plu+" ?", {
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Close",
                        value: 'close',
                        visible: true,
                        className: "",
                        // closeModal: true,
                    },
                    confirm: {
                        text: "Koreksi",
                        value: 'koreksi',
                        visible: true,
                        // className: "btn-danger",
                        // closeModal: true
                    },
                    delete: {
                        text: "Hapus",
                        value: 'delete',
                        visible: true,
                        className: "",
                        // closeModal: true
                    },
                },
            }).then((value) => {
                if(value === 'koreksi'){
                   koreksiPlu(plu);
                } else if(value === 'delete'){
                    swal({
                        title: "Hapus No Transaksi ini ?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        buttons: ['Tidak', 'Ya']
                    }).then((willDelete) => {
                        if (willDelete) {
                          deletePlu(plu)
                        }
                    });
                } else {
                   console.log("Plu Aman");
                }
            });
        }

        async function koreksiPlu(plu){
            let data;

            await new Promise(next => {
                for(let i=0; i < tempDataSave.length; i++){
                    if (tempDataSave[i].trbo_prdcd == plu){
                        data = tempDataSave[i];
                        break;
                    }
                }
                next();
            });


            clearRightFirstField();
            if(data){
                setValueFromTempDataSave(data);
                $('#cardInput1').show();
                $('#cardInput2').hide();
            } else {
                alertError("Error", "Data tidak ada !");
            }


        }

        function deletePlu(plu){
            for(let i=0; i < tempDataSave.length; i++){
                if (tempDataSave[i].trbo_prdcd == plu){
                   tempDataSave.splice(i,1);
                   break;
                }
            }

            let grantTotal = 0;
            for (let i=0; i < tempDataSave.length; i++){
                grantTotal = parseInt(grantTotal) + parseInt(tempDataSave[i].total_rph);
            }

            sum_item.val(tempDataSave.length);
            i_totalpo.val(convertToRupiah(grantTotal));
            clearRightFirstField();
            setValueTableDetail(tempDataSave);
        }

        function transferPO(){
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/penerimaan/input/transferpo',
                type: 'post',
                data: {prdcd : i_plu.val(), noBTB: noBTB.val(), noPo : noPO.val(), supplier:kodeSupp.val(), tempDataPLU : tempDataPLU, tempDataSave:tempDataSave},
                beforeSend : () =>{
                    $('#modal-loader').modal('show');
                },
                success: (result) => {
                    $('#modal-loader').modal('hide');
                    console.log((result))

                }, error : (err) => {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            });
        }

        //**************************************
        function setValue(data){
            i_plu.val(data.i_prdcd);
            i_deskripsi.val(data.i_barang);
            i_kemasan.val(data.i_kemasan);
            i_tag.val(data.i_tag);
            i_bkp.val(data.i_bkp);
            i_bandrol.val(data.i_bandrol);
            i_hrgbeli.val(convertToRupiah(data.i_hrgbeli));
            i_lcost.val(convertToRupiah(data.i_lcost));
            i_acost.val(convertToRupiah(data.i_acost));
            i_qty.val(data.i_qty);
            i_qtyk.val(data.i_qtyk);
            i_isibeli.val(convertToRupiah(data.i_isibeli));
            i_bonus1.val(data.i_bonus1);
            i_bonus2.val(data.i_bonus2);
            i_gross.val(convertToRupiah(data.i_gross));

            i_persendis1.val(convertToRupiah(data.i_persendis1));
            i_rphdisc1.val(convertToRupiah(data.i_rphdisc1));
            i_flagdisc1.val(data.i_flagdisc1);
            i_disc1.val(convertToRupiah(data.i_disc1));
            i_persendis2.val(convertToRupiah(data.i_persendis2));
            i_rphdisc2.val(convertToRupiah(data.i_rphdisc2));
            i_flagdisc2.val(data.i_flagdisc2);
            i_disc2.val(convertToRupiah(data.i_disc2));
            i_persendis2a.val(convertToRupiah(data.i_persendis2a));
            i_rphdisc2a.val(convertToRupiah(data.i_rphdisc2a));
            i_disc2a.val(convertToRupiah(data.i_disc2a));
            i_persendis2b.val(convertToRupiah(data.i_persendis2b));
            i_rphdisc2b.val(convertToRupiah(data.i_rphdisc2b));
            i_disc2b.val(convertToRupiah(data.i_disc2b));
            i_persendis3.val(convertToRupiah(data.i_persendis3));
            i_rphdisc3.val(convertToRupiah(data.i_rphdisc3));
            i_flagdisc3.val(data.i_flagdisc3 );
            i_disc3.val(convertToRupiah(data.i_disc3));

            // i_persendis4.val(convertToRupiah(String(data.i_persendis4)));
            // i_rphdisc4.val(convertToRupiah(String(data.i_rphdisc4)));
            // i_flagdisc4.val(data.i_flagdisc4);
            // i_disc4.val(convertToRupiah(String(data.i_disc4)));
            i_persendis4.val(convertToRupiah((data.i_persendis4)));
            i_rphdisc4.val(convertToRupiah((data.i_rphdisc4)));
            i_flagdisc4.val(data.i_flagdisc4);
            i_disc4.val(convertToRupiah((data.i_disc4)));

            i_keterangan.val(data.i_keterangan);
            i_ppn.val(convertToRupiah(data.i_ppn));
            i_botol.val(convertToRupiah(data.i_botol));
            i_bm.val(convertToRupiah(data.i_bm));
            // sum_item.val(data.sum_item);
            // i_totalpo.val(data.i_totalpo);
            i_total.val(convertToRupiah(data.i_total));

            if(parseInt(i_rphdisc1.val()) > 0){
                i_rphdisc1.attr('disabled', true)
            } if (parseInt(i_rphdisc2.val()) > 0){
                i_rphdisc2.attr('disabled', true)
            } if (parseInt(i_rphdisc2a.val()) > 0){
                i_rphdisc2a.attr('disabled', true)
            } if (parseInt(i_rphdisc2b.val()) > 0){
                i_rphdisc2b.attr('disabled', true)
            } if (parseInt(i_rphdisc3.val()) > 0){
                i_rphdisc3.attr('disabled', true)
            } if (parseInt(i_rphdisc4.val()) > 0){
                i_rphdisc4.attr('disabled', true)
            }
        }

        function setValueFromTempDataSave(data) {
            console.log(data);
            i_plu.val(data.trbo_prdcd);
            i_deskripsi.val(data.barang);
            i_kemasan.val(data.kemasan);
            i_tag.val(data.trbo_kodetag);
            i_bkp.val(data.trbo_bkp);
            i_bandrol.val(data.i_bandrol);
            i_hrgbeli.val(convertToRupiah(data.trbo_hrgsatuan));
            i_lcost.val(convertToRupiah(data.trbo_lcost));
            i_acost.val(convertToRupiah((data.trbo_unit == 'KG') ? data.trbo_averagecost / 1 : data.trbo_averagecost / data.trbo_frac));
            i_qty.val(data.qty);
            i_qtyk.val(data.qtyk);
            i_isibeli.val(convertToRupiah(data.isibeli));
            i_bonus1.val(data.trbo_qtybonus1);
            i_bonus2.val(data.trbo_qtybonus2);
            i_gross.val(convertToRupiah(data.trbo_gross));

            i_persendis1.val(convertToRupiah(data.trbo_persendis1));
            i_rphdisc1.val(convertToRupiah(data.trbo_rphdisc1));
            i_flagdisc1.val(data.trbo_flagdisc1);
            i_disc1.val(convertToRupiah(data.trbo_disc1));
            i_persendis2.val(convertToRupiah(data.trbo_persendis2));
            i_rphdisc2.val(convertToRupiah(data.i_rphdisc2));
            i_flagdisc2.val(data.trbo_flagdisc2);
            i_disc2.val(convertToRupiah(data.trbo_disc2));
            i_persendis2a.val(convertToRupiah(data.trbo_persendis2i));
            i_rphdisc2a.val(convertToRupiah(data.trbo_rphdisc2i));
            i_disc2a.val(convertToRupiah(data.trbo_disc2i));
            i_persendis2b.val(convertToRupiah(data.trbo_persendis2ii));
            i_rphdisc2b.val(convertToRupiah(data.trbo_rphdisc2ii));
            i_disc2b.val(convertToRupiah(data.trbo_disc2ii));
            i_persendis3.val(convertToRupiah(data.trbo_persendis3));
            i_rphdisc3.val(convertToRupiah(data.trbo_rphdisc3));
            i_flagdisc3.val(data.trbo_flagdisc3 );
            i_disc3.val(convertToRupiah(data.trbo_disc3));
            i_persendis4.val(convertToRupiah((data.trbo_persendis4)));
            i_rphdisc4.val(convertToRupiah((data.trbo_rphdisc4)));
            i_flagdisc4.val(data.trbo_flagdisc4);
            i_disc4.val(convertToRupiah((data.trbo_disc4)));

            i_keterangan.val(data.trbo_keterangan);
            i_ppn.val(convertToRupiah(data.i_ppnrph));
            i_botol.val(convertToRupiah(data.trbo_ppnbtlrph));
            i_bm.val(convertToRupiah(data.trbo_ppnbmrph));
            // sum_item.val(data.sum_item);
            // i_totalpo.val(data.i_totalpo);
            i_total.val(convertToRupiah(data.i_total));

            if(parseInt(i_rphdisc1.val()) > 0){
                i_rphdisc1.attr('disabled', true)
            } if (parseInt(i_rphdisc2.val()) > 0){
                i_rphdisc2.attr('disabled', true)
            } if (parseInt(i_rphdisc2a.val()) > 0){
                i_rphdisc2a.attr('disabled', true)
            } if (parseInt(i_rphdisc2b.val()) > 0){
                i_rphdisc2b.attr('disabled', true)
            } if (parseInt(i_rphdisc3.val()) > 0){
                i_rphdisc3.attr('disabled', true)
            } if (parseInt(i_rphdisc4.val()) > 0){
                i_rphdisc4.attr('disabled', true)
            }
        }

        function setValueTableDetail(data){
            $('.rowTbodyTableDetail').remove();
            for (let i = 0; i< data.length; i++){
                let value = data[i];

                $('.tbodyTableDetail').append(`<tr class="rowTbodyTableDetail"  onclick="editDeletePlu('`+ value.trbo_prdcd +`')">
                                                                <td class="sticky-cell">`+ value.trbo_prdcd +`</td>
                                                                <td class="sticky-cell">`+ value.barang +`</td>
                                                                <td class="sticky-cell text-right" >`+ value.qty +`</td>
                                                                <td class="sticky-cell text-right" >`+ (value.trbo_qty - (value.qty * value.trbo_frac)) +`</td>
                                                                <td class="sticky-cell text-right" >`+ convertToRupiah(value.trbo_hrgsatuan)+`</td>
                                                                <td class="sticky-cell text-center" >/`+ value.trbo_frac +`</td>
                                                                <td>`+nvl(value.trbo_kodetag, ' ')+`</td>
                                                                <td>`+nvl(value.trbo_bkp, ' ')+`</td>
                                                                <td  class="text-right">`+value.trbo_qtybonus1+`</td>
                                                                <td  class="text-right">`+value.trbo_qtybonus2+`</td>
                                                                <td  class="text-right">`+convertToRupiah(value.trbo_persendisc1)+`</td>
                                                                <td  class="text-right">`+convertToRupiah(value.trbo_rphdisc1)+`</td>
                                                                <td  class="text-right">`+value.trbo_persendisc2+`</td>
                                                                <td  class="text-right">`+convertToRupiah(value.trbo_rphdisc2)+`</td>
                                                                <td  class="text-right">`+value.trbo_persendisc2ii+`</td>
                                                                <td  class="text-right">`+convertToRupiah(value.trbo_rphdisc2ii)+`</td>
                                                                <td  class="text-right">`+value.trbo_persendisc2iii+`</td>
                                                                <td  class="text-right">`+convertToRupiah(value.trbo_rphdisc2iii)+`</td>
                                                                <td  class="text-right">`+value.trbo_persendisc3+`</td>
                                                                <td  class="text-right">`+convertToRupiah(value.trbo_rphdisc3)+`</td>
                                                                <td  class="text-right">`+value.trbo_persendisc4+`</td>
                                                                <td  class="text-right">`+convertToRupiah2(value.trbo_rphdisc4)+`</td>
                                                                <td  class="text-right">`+convertToRupiah2(value.trbo_gross)+`</td>
                                                                <td  class="text-right">`+convertToRupiah2(value.trbo_ppnrph)+`</td>
                                                                <td  class="text-right">`+convertToRupiah(value.trbo_averagecost)+`</td>
                                                                <td  class="text-right">`+convertToRupiah(value.trbo_oldcost)+`</td>
                                                            </tr>`);
            }
        }

        function clearSecondField(){
            setValue(0);
            i_rphdisc1.attr('disabled', false)
            i_rphdisc2.attr('disabled', false)
            i_rphdisc2a.attr('disabled', false)
            i_rphdisc2b.attr('disabled', false)
            i_rphdisc3.attr('disabled', false)
            i_rphdisc4.attr('disabled', false)
        }

        function clearRightFirstField() {
            v_gross.val('');
            v_discount.val('');
            v_ppn.val('');
            v_ppbBm.val('');
            v_ppnBotol.val('');
            v_grantTotal.val('');
        }

        function checkRphDisc(){
            if (i_rphdisc1.val() == "0.00"){
                i_rphdisc1.focus();
            } else if (i_rphdisc4.val() == "0.00"){
                i_rphdisc4.focus();
            } else if (i_rphdisc2.val() == "0.00"){
                i_rphdisc2.focus();
            } else if (i_rphdisc2a.val() == "0.00"){
                i_rphdisc2a.focus();
            } else if (i_rphdisc2b.val() == "0.00"){
                i_rphdisc2b.focus();
            } else if (i_rphdisc3.val() == "0.00"){
                i_rphdisc3.focus();
            }
        }

        noBTB.keypress(function (e) {
            if (e.which === 13) {
                getNewNoBTB();
            } else {
                return false;
            }
        });

        tglBTB.keypress(function (e) {
            if (e.which === 13) {
                noPO.focus();
            }
        });

        noPO.keypress(function (e) {
            if (e.which === 13) {
                // choosePO('VHAH93164');

                let val = $(this).val();

                if(!val){
                    kodeSupp.focus();
                } else {
                    choosePO(val)
                }
            }
        });

        kodeSupp.keypress(function (e) {
            if (e.which === 13) {
                if(typeTrn == 'L'){
                    swal('','Kode Supplier Tidak Boleh Diisi !!', 'warning')
                    kodeSupp.val('');
                    namaSupp.val('');
                }
                noFaktur.focus();
            }
        });

        tglFaktur.keypress(function (e) {
            if (e.which === 13) {
                i_plu.focus();
            }
        });

        i_plu.keypress(function (e) {
            if (e.which === 13) {
                let val = $(this).val();

                choosePlu(val);

                // if (tempDataBTB.length < 1){
                //     choosePlu(val);
                // } else {
                //     for (let i = 0; i < tempDataBTB.length; i++){
                //         if (tempDataBTB[i].trbo_prdcd == val){
                //             console.log(tempDataBTB[i]);
                //             i_plu.val(tempDataBTB[i].trbo_prdcd);
                //             i_deskripsi.val(tempDataBTB[i].prd_deskripsipanjang);
                //         }
                //     }
                // }
            }
        });

        i_hrgbeli.keypress(function (e) {
            if (e.which === 13) {
                let hrgBeli = $(this).val();
                let qty     = i_qty.val();
                let qtyk    = i_qtyk.val();

                changeHargaBeli(hrgBeli,qty, qtyk);
            }
        });

        i_qty.keypress(async function (e) {
            if (e.which === 13) {
                let qty     = $(this).val();
                let qtyk     = i_qtyk.val();
                let hrgbli  = unconvertToRupiah(i_hrgbeli.val());

                let changeqty =  await new Promise(next => {
                    changeQty(qty, qtyk, hrgbli,next);
                });


                i_qtyk.focus()
                console.log('iqtyfocus')
            }
        });

        i_qtyk.keypress(async function (e) {
            if (e.which === 13) {
                let qtyk    = $(this).val();
                let qty     = i_qty.val();
                let hrgbli  = unconvertToRupiah(i_hrgbeli.val());

                let changeqty =  await new Promise(next => {
                    changeQty(qty, qtyk, hrgbli,next);
                });
                i_bonus1.focus()

            }
        });

        i_bonus1.keypress(function (e) {
            if (e.which === 13) {
                let bonus1  = $(this).val();

                changeBonus1(bonus1)
            }
        });

        i_rphdisc1.keypress(async function (e) {
            if (e.which === 13) {
                let persendisc = i_persendis1.val();
                let rphdisc = $(this).val();

                if(persendisc == 0){
                    tempDataPLU.i_rphdisc1 = rphdisc;
                }

                await new Promise(next => {
                    changeRphDisc(next)
                });
                i_rphdisc1.attr('disabled', false);

                if (i_rphdisc4[0]['disabled'] == false){
                    i_rphdisc4.focus();
                } else if (i_rphdisc2[0]['disabled'] == false){
                    i_rphdisc2.focus();
                } else if (i_rphdisc2a[0]['disabled'] == false){
                    i_rphdisc2a.focus();
                } else if (i_rphdisc2b[0]['disabled'] == false){
                    i_rphdisc2b.focus();
                } else if (i_rphdisc3[0]['disabled'] == false){
                    i_rphdisc3.focus();
                }
            }
        });

        i_rphdisc4.keypress(async function (e) {
            if (e.which === 13) {
                let persendisc = i_persendis4.val();
                let rphdisc = $(this).val();

                if(persendisc == 0){
                    tempDataPLU.i_rphdisc4 = rphdisc;
                }

                await new Promise(next => {
                    changeRphDisc(next);
                });
                i_rphdisc4.attr('disabled', false);

                if (i_rphdisc2[0]['disabled'] == false){
                    i_rphdisc2.focus();
                } else if (i_rphdisc2a[0]['disabled'] == false){
                    i_rphdisc2a.focus();
                } else if (i_rphdisc2b[0]['disabled'] == false){
                    i_rphdisc2b.focus();
                } else if (i_rphdisc3[0]['disabled'] == false){
                    i_rphdisc3.focus();
                }
            }
        });

        i_rphdisc2.keypress(async function (e) {
            if (e.which === 13) {
                let persendisc = i_persendis2.val();
                let rphdisc = $(this).val();

                if(persendisc == 0){
                    tempDataPLU.i_rphdisc2 = rphdisc;
                }

                await new Promise(next => {
                    changeRphDisc(next);
                });
                i_rphdisc2.attr('disabled', false);

                if (i_rphdisc2a[0]['disabled'] == false){
                    i_rphdisc2a.focus();
                } else if (i_rphdisc2b[0]['disabled'] == false){
                    i_rphdisc2b.focus();
                } else if (i_rphdisc3[0]['disabled'] == false){
                    i_rphdisc3.focus();
                }
            }
        });

        i_rphdisc2a.keypress(async function (e) {
            if (e.which === 13) {
                let persendisc = i_persendis2a.val();
                let rphdisc = $(this).val();

                if(persendisc == 0){
                    tempDataPLU.i_rphdisc2a = rphdisc;
                }

                await new Promise(next => {
                    changeRphDisc(next);
                });
                i_rphdisc2a.attr('disabled', false);

                 if (i_rphdisc2b[0]['disabled'] == false){
                    i_rphdisc2b.focus();
                } else if (i_rphdisc3[0]['disabled'] == false){
                    i_rphdisc3.focus();
                }
            }
        });

        i_rphdisc2b.keypress(async function (e) {
            if (e.which === 13) {
                let persendisc = i_persendis2b.val();
                let rphdisc = $(this).val();

                if(persendisc == 0){
                    tempDataPLU.i_rphdisc2b = rphdisc;
                }

                await new Promise(next => {
                    changeRphDisc(next);
                });
                i_rphdisc2b.attr('disabled', false);

                if (i_rphdisc3[0]['disabled'] == false){
                    i_rphdisc3.focus();
                }
            }
        });

        i_rphdisc3.keypress(async function (e) {
            if (e.which === 13) {
                let persendisc = i_persendis3.val();
                let rphdisc = $(this).val();

                if(persendisc == 0){
                    tempDataPLU.i_rphdisc3 = rphdisc;
                }

               await new Promise(next => {
                    changeRphDisc(next);
                });
                i_rphdisc3.attr('disabled', false);
                i_keterangan.focus();
            }
        });

        i_keterangan.keypress(function (e) {
            if(e.which === 13){
                let keterangan = $(this).val().toUpperCase();
                tempDataPLU.i_keterangan = keterangan;

                rekamData();
            }
        });

        $('.searchModal').keypress(function (e) {
            if (e.which === 13) {
                let value   = $(this).val();
                let idModal = $('#idModal').val();

                if (idModal === 'BTB'){
                    showBTB(value);
                } else if (idModal === 'PO'){
                    showPO(value);
                } else if (idModal === 'Supplier'){
                    showSupplier(value)
                } else if(idModal === 'PLU'){
                    showPlu(value)
                }

            }
        })

        $('.form-control').on('focus', function (e) {
            let id= $(this).attr('id');
            let className = $(this).attr('class');

            if(id != 'i_plu' && id != 'searchModal' && className.search('nullPermission') < 1){
                if(!i_plu.val()) {
                    i_plu.focus();
                    return false;
                }
            }
        })

    </script>

@endsection

