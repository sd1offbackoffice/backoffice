@extends('navbar')
@section('title','Input Penerimaan')
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
                                                   <input type="text" class="form-control" id="no_penyesuaian">
                                                   <button id="btn-no-doc" type="button" class="btn btn-lov p-0" onclick="showBTB()">
                                                       <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                   </button>
                                               </div>
                                               <label class="col-sm-1 col-form-label text-right">Tgl BTB</label>
                                               <div class="col-sm-2">
                                                   <input type="date" class="form-control" id="">
                                               </div>
                                           </div>

                                           <div class="form-group row mb-1">
                                               <label class="col-sm-2 col-form-label text-right">No PO</label>
                                               <div class="col-sm-2 buttonInside">
                                                   <input type="text" class="form-control" id="no_penyesuaian">
                                                   <button id="btn-no-doc" type="button" class="btn btn-lov p-0" data-toggle="modal" data-target="#m_lov_penyesuaian">
                                                       <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                   </button>
                                               </div>
                                               <label class="col-sm-1 col-form-label text-right">Tgl PO</label>
                                               <div class="col-sm-2">
                                                   <input type="date" class="form-control" id="" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row mb-2">
                                               <label class="col-sm-2 col-form-label text-right">Supplier</label>
                                               <div class="col-sm-2 buttonInside">
                                                   <input type="text" class="form-control" id="no_penyesuaian">
                                                   <button id="btn-no-doc" type="button" class="btn btn-lov p-0" data-toggle="modal" data-target="#m_lov_penyesuaian">
                                                       <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                   </button>
                                               </div>
                                               <div class="col-sm-7">
                                                   <input type="text" class="form-control" id="" disabled>
                                               </div>
                                           </div>

                                           <div class="form-group row pb-4">
                                               <label class="col-sm-2 col-form-label text-right">No Faktur</label>
                                               <div class="col-sm-2 buttonInside">
                                                   <input type="text" class="form-control" id="no_penyesuaian">
                                                   <button id="btn-no-doc" type="button" class="btn btn-lov p-0" data-toggle="modal" data-target="#m_lov_penyesuaian">
                                                       <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                   </button>
                                               </div>
                                               <label class="col-sm-1 col-form-label text-right">Tgl Faktur</label>
                                               <div class="col-sm-2">
                                                   <input type="date" class="form-control" id="" >
                                               </div>
                                               <label class="col-sm-1 col-form-label text-right">TOP</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control" id="">
                                               </div>
                                               <label class="col-sm-1 col-form-label text-right">PKP</label>
                                               <div class="col-sm-1">
                                                   <input type="text" class="form-control" id="" disabled>
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
                                                   <input type="text" class="form-control" id="no_penyesuaian">
                                                   <button id="btn-no-doc" type="button" class="btn btn-lov p-0">
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
                                                   <button type="button" class="btn btn-primary btn-block" onclick="test()">Rekam Record</button>
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
                                            <th id="modalThName3"></th>
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

    <script>
        let typeTrn;
        let modalThName1    = $('#modalThName1');
        let modalThName2    = $('#modalThName2');
        let modalThName3    = $('#modalThName3');

        $(document).ready(function () {
           // startAlert();
            $('#cardInput2').hide();
            typeTrn = 'B'
            // showBTB();
            chooseBTB('0420000042', '8H3E63045')
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
            })
        }

        function showBTB() {
            if(!typeTrn || typeTrn === 'N'){
                startAlert();

                return false;
            }

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/penerimaan/input/showbtb',
                type: 'post',
                data: {
                    typeTrn:typeTrn
                },
                success: function (result) {
                    modalThName1.text('No Dokumen');
                    modalThName2.text('No PO');
                    modalThName3.text('Tgl BTB');
                    modalThName3.show();

                    console.log(result)

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseBTB('"+ result[i].trbo_nodoc +"','"+ result[i].trbo_nopo +"') class='modalRow'><td>"+ result[i].trbo_nodoc +"</td> <td>"+ result[i].trbo_nopo +"</td> <td>"+ formatDate(result[i].trbo_tglreff)+"</td></tr>")
                    }

                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function chooseBTB(noDoc, noPO) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/penerimaan/input/choosebtb',
                type: 'post',
                data: {
                    noDoc:noDoc,
                    noPO:noPO,
                    typeTrn:typeTrn
                },
                success: function (result) {
                    console.log(result)
                    console.log(result.data[0].trbo_prdcd)

                    if (result.kode == 0){
                        swal("", result.msg, 'warning');
                    } else {
                        $('.rowTbodyTableDetail').remove();

                        for (let i = 0; i< result.data.length; i++){
                            value = result.data[i];

                            $('.tbodyTableDetail').append(`<tr class="rowTbodyTableDetail">
                                                                <td class="sticky-cell">`+ value.trbo_prdcd +`</td>
                                                                <td class="sticky-cell">`+ value.prd_deskripsipanjang +`</td>
                                                                <td class="sticky-cell" >`+ value.trbo_qty+`</td>
                                                                <td class="sticky-cell" >`+ value.trbo_qty+`</td>
                                                                <td class="sticky-cell text-right" >`+ convertToRupiah(value.trbo_hrgsatuan)+`</td>
                                                                <td class="sticky-cell" >`+ value.prd_frac +`</td>
                                                                <td>`+value.prd_kodetag+`</td>
                                                                <td>BKP</td>
                                                                <td  class="text-right">`+value.trbo_qtybonus1+`</td>
                                                                <td  class="text-right">`+value.trbo_qtybonus2+`</td>
                                                                <td  class="text-right">`+value.trbo_persendisc1+`</td>
                                                                <td  class="text-right">`+value.trbo_rphdisc1+`</td>
                                                                <td  class="text-right">`+value.trbo_persendisc2+`</td>
                                                                <td  class="text-right">`+value.trbo_rphdisc2+`</td>
                                                                <td  class="text-right">`+value.trbo_persendisc2ii+`</td>
                                                                <td  class="text-right">`+value.trbo_rphdisc2ii+`</td>
                                                                <td  class="text-right">`+value.trbo_persendisc2iii+`</td>
                                                                <td  class="text-right">`+value.trbo_rphdisc2iii+`</td>
                                                                <td  class="text-right">`+value.trbo_persendisc3+`</td>
                                                                <td  class="text-right">`+value.trbo_rphdisc3+`</td>
                                                                <td  class="text-right">`+value.trbo_persendisc4+`</td>
                                                                <td  class="text-right">`+value.trbo_rphdisc4+`</td>
                                                                <td>`+value.trbo_gross+`</td>
                                                                <td>PPN</td>
                                                                <td>`+value.trbo_averagecost+`</td>
                                                                <td>Last Cost</td>
                                                            </tr>`);
                        }
                    }


                    $('#modalHelp').modal('hide');
                    $('#cardInput2').show();
                    $('#cardInput1').hide();

                    $( document ).trigger( "stickyTable" );


                }, error: function () {
                    alert('error');
                }
            })
        }

        function closeCardInput2() {
            $('#cardInput2').hide();
            $('#cardInput1').show();
        }


    </script>

@endsection
