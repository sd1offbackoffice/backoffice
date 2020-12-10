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
                                                   <input type="text" class="form-control" id="noBTB">
                                                   <button id="btn-no-doc" type="button" class="btn btn-lov p-0" onclick="showBTB('')">
                                                       <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                   </button>
                                               </div>
                                               <label class="col-sm-1 col-form-label text-right">Tgl BTB</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control" id="tglBTB" placeholder="dd/mm/yyyy">
                                               </div>
                                           </div>

                                           <div class="form-group row mb-1">
                                               <label class="col-sm-2 col-form-label text-right">No PO</label>
                                               <div class="col-sm-2 buttonInside">
                                                   <input type="text" class="form-control" id="noPO">
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
                                                   <input type="text" class="form-control" id="kodeSupplier">
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
                                                   <input type="text" class="form-control" id="noFaktur">
                                               </div>
                                               <label class="col-sm-1 col-form-label text-right">Tgl Faktur</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control" id="tglFaktur" placeholder="dd/mm/yyyy" value="{{\Carbon\Carbon::today()->format('d/m/Y')}}">
                                               </div>
                                               <label class="col-sm-1 col-form-label text-right">TOP</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="top">
                                               </div>
                                               <label class="col-sm-1 col-form-label text-right">PKP</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control" id="pkp" disabled>
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
                                                <label class="col-sm-3 col-form-label text-md-right">Gross</label>
                                                <input type="text" id="noDoc" class="form-control col-sm-5" disabled>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label class="col-sm-3 col-form-label text-md-right">Discount</label>
                                                <input type="text" id="noDoc" class="form-control col-sm-5" disabled>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label class="col-sm-3 col-form-label text-md-right">PPN</label>
                                                <input type="text" id="noDoc" class="form-control col-sm-5" disabled>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label class="col-sm-3 col-form-label text-md-right">PPB BM</label>
                                                <input type="text" id="noDoc" class="form-control col-sm-5" disabled>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label class="col-sm-3 col-form-label text-md-right">PPN Botol</label>
                                                <input type="text" id="noDoc" class="form-control col-sm-5" disabled>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label class="col-sm-3 col-form-label text-md-right">Grant Total</label>
                                                <input type="text" id="noDoc" class="form-control col-sm-5" disabled>
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
                                                   <input type="text" class="form-control" id="" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Kemasan</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control" id="kemasan" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Status</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control" id="kemasan" disabled>
                                               </div>

                                               <label  class="col-sm-2 col-form-label text-right">BKP</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control" id="kemasan" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Bandrol</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control" id="kemasan" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Harga Beli</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="kemasan">
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Lcost</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="kemasan" disabled>
                                               </div>

                                               <label class="col-sm-2 offset-sm-2 col-form-label text-right">Acost</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="kemasan" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Kuantum</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="">
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Qtyk</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="">
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0 mt-3">
                                               <label class="col-sm-1 col-form-label text-right">Bonus I</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="">
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Bonus II</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>

                                               <label class="col-sm-2 offset-sm-2 col-form-label text-right">= Rp.</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Potongan I %</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="">
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Rp. </label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>

                                               <label class="col-sm-1 col-form-label text-right">SAT</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">= Rp.</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Potongan IV %</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="">
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Rp. </label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>

                                               <label class="col-sm-1 col-form-label text-right">SAT</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">= Rp.</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Potongan II %</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="">
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Rp. </label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>

                                               <label class="col-sm-1 col-form-label text-right">SAT</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">= Rp.</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Potongan II A %</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="">
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Rp. </label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>

                                               <label class="col-sm-2 offset-sm-2 col-form-label text-right">= Rp.</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Potongan II B %</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="">
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Rp. </label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>

                                               <label class="col-sm-2 offset-sm-2 col-form-label text-right">= Rp.</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Potongan III %</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="">
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Rp. </label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>

                                               <label class="col-sm-1 col-form-label text-right">SAT</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">= Rp.</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0 mt-3">
                                               <label class="col-sm-1 col-form-label text-right">Keterangan</label>
                                               <div class="col-sm-6">
                                                   <input type="text" class="form-control text-right" id="">
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">PPN</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-2 offset-sm-7 col-form-label text-right">Botol</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-2 offset-sm-7 col-form-label text-right">BM</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0">
                                               <label class="col-sm-1 col-form-label text-right">Jumlah Item</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>

                                               <label class="col-sm-2 col-form-label text-right">Total PO </label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>

                                               <label class="col-sm-2 offset-sm-2 col-form-label text-right">Total</label>
                                               <div class="col-sm-2">
                                                   <input type="text" class="form-control text-right" id="" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-0 mt-5">
                                               <div class="col-sm-3 text-center">
                                                   <button type="button" class="btn btn-primary pr-5 pl-5" onclick="test()">Rekam Record</button>
                                               </div>
                                               <div class="col-sm-3 text-center">
                                                   <button type="button" class="btn btn-primary btn-block">Transfer PO</button>
                                               </div>
                                               <div class="col-sm-3 text-center">
                                                   <button type="button" class="btn btn-primary btn-block">List/Hapus Record</button>
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
                                                <div class="col-sm-3 offset-sm-1 text-center">
                                                    <button type="button" class="btn btn-primary btn-block">Koreksi</button>
                                                </div>
                                                <div class="col-sm-3 offset-sm-1 text-center">
                                                    <button type="button" class="btn btn-primary btn-block">Hapus Record</button>
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

    <script>
        let typeTrn;
        let tempPO          = [];
        let tempSupplier    = [];
        let tempPlu         = [];
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

        let i_plu       = $('#i_plu');

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
            // chooseBTB('0440002383', '2H6G85854')
            // choosePO('HHBK26794')
            // showPlu('');
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
                },
                success: function (result) {
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
                }, error: function () {
                    alert('error');
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
                    $('.rowTbodyTableDetail').remove();
                    modalHelp.modal('hide');
                },
                success: function (result) {
                    console.log(result)
                    // console.log(formatDate(result.data[0].trbo_tgldoc))
                    // console.log((result.data[0].trbo_nopo))

                    if (result.kode == 0){
                        swal("", result.msg, 'warning');
                        $('#cardInput2').hide();
                        $('#cardInput1').show();
                    } else {
                        for (let i = 0; i< result.data.length; i++){
                            value = result.data[i];

                            $('.tbodyTableDetail').append(`<tr class="rowTbodyTableDetail">
                                                                <td class="sticky-cell">`+ value.trbo_prdcd +`</td>
                                                                <td class="sticky-cell">`+ value.prd_deskripsipanjang +`</td>
                                                                <td class="sticky-cell text-right" >`+ value.qty +`</td>
                                                                <td class="sticky-cell text-right" >`+ (value.trbo_qty - (value.qty * value.prd_frac)) +`</td>
                                                                <td class="sticky-cell text-right" >`+ convertToRupiah(value.trbo_hrgsatuan)+`</td>
                                                                <td class="sticky-cell text-center" >/`+ value.prd_frac +`</td>
                                                                <td>`+value.prd_kodetag+`</td>
                                                                <td>`+value.prd_flagbkp1+`</td>
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
                }, error: function () {
                    alert('error');
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
                       },
                       success: function (result) {
                           if (result.length > 0) {
                               noBTB.val(result)
                               tglBTB.focus()
                           }
                       }, error: function (error) {
                           console.log(error)
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
                },
                success: function (result) {
                    console.log(result)
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
                }, error: function () {
                    alert('error');
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
                },
                success: function (result) {
                    modalHelp.modal('hide');

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

                }, error: function (error) {
                    console.log(error)
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
                },
                success: function (result) {
                    console.log(result)
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
                }, error: function () {
                    alert('error');
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
                },
                success: function (result) {
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

                }, error: function () {
                    alert('error');
                }
            })
        }

        function choosePlu(plu) {
            let temp    = convertPlu(plu);
            let prdcd   = temp.replace(temp.substr(6,1), '0');
            let noDoc   = noBTB.val();
            let noPo    = noPO.val();
            let supplier= kodeSupp.val();

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/penerimaan/input/chooseplu',
                type: 'post',
                data: {
                    typeTrn : typeTrn,
                    prdcd   : prdcd,
                    noDoc   : noDoc,
                    noPo    : noPo,
                    supplier:supplier
                },
                success: function (result) {
                    console.log(result)

                    if(result.kode == '2'){
                        swal({
                            icon: 'warning',
                            text: result.msg,
                            buttons: false,
                            timer: 2000,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                        });

                        i_plu.focus();
                    }



                }, error: function () {
                    alert('error');
                }
            })




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

                choosePlu(val)
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

    </script>

@endsection

