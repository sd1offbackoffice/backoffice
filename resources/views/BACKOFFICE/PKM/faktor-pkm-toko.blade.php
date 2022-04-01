@extends('navbar')
@section('title','Faktor Penambah PKM')
@section('content')
<div class="container-fluid">
    <div class="row no-gutters justify-content-center">
        <div class="col-md-11">
            <button class="btn btn-primary" id="nBtn">N+</button>
            <button class="btn btn-primary" id="mBtn">M+</button>

            <fieldset class="card border-dark n-form">               
                <div class="card-body shadow-lg cardForm">
                    <br>
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="" id=""></th>
                                        <th>NO PERJANJIAN</th>
                                        <th>PLU</th>
                                        <th>KD DISPLAY</th>
                                        <th>TGL AWAL</th>
                                        <th>TGL AKHIR</th>
                                        <th>QTY</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-center">FILTER</h4>
                            <div class="form-group">
                                <label for="tglAwal">TGL AWAL</label>
                                <input type="text" class="form-control" name="tglAwal" id="tglAwal" aria-describedby="tglAwal" placeholder="TGL AWAL">
                            </div>
                            <div class="form-group">
                                <label for="tglAkhir">TGL AKHIR</label>
                                <input type="text" class="form-control" name="tglAkhir" id="tglAkhir" aria-describedby="tglAkhir" placeholder="TGL AKHIR">
                            </div>
                            {{-- <hr style="background-color: grey"> --}}
                            <hr style="background-color: grey">
                            <div class="form-group">
                                <label for="filterKdDisplay">FILTER KD DISPLAY</label>
                                <input type="text" class="form-control" name="filterKdDisplay" id="filterKdDisplay" aria-describedby="filterKdDisplay" placeholder="TGL AKHIR">
                            </div>
                            <hr style="background-color: grey">
                            <div class="form-group">
                                <label for="searchPLU">CARI PLU</label>
                                <input type="text" class="form-control" name="searchPLU" id="searchPLU" aria-describedby="searchPLU" placeholder="TGL AKHIR">
                            </div>
                            <hr style="background-color: grey">
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary text-center" id="updateQtyPkmg" type="button">UPDATE QTY & PKMG</button>
                            </div>
                            <div class="d-flex justify-content-center">
                                <small class="form-text text-muted"><span style="color: red;">*</span>check qty yang akan diupdate</small>
                            </div>
                            
                        </div>
                    </div>
                    <hr style="background-color: grey">
                    <div class="row no-gutters no-gutters">
                        <label class="col-sm-2" for="plu">PLU</label>
                        <input class="form-control col-sm-2" type="text" name="plu" id="plu" placeholder="plu">
                        
                        <label class="col-sm-1 text-center" for="plu2" >-</label>
                        <input class="form-control col-sm-5" type="text" name="plu2" id="plu2" placeholder="plu2">
                    </div>
                    <br>
                    <div class="row no-gutters no-gutters">
                        <label class="col-sm-1" for="mpkm">MPKM</label>
                        <input class="form-control col-sm-1" type="text" name="mpkm" id="mpkm" placeholder="mpkm">

                        <label class="col-sm-1 text-center" for="plu2" >M+</label>
                        <input class="form-control col-sm-1" type="text" name="plu2" id="plu2" placeholder="plu2">

                        <label class="col-sm-1 text-center" for="plu2" >PKMT</label>
                        <input class="form-control col-sm-1" type="text" name="plu2" id="plu2" placeholder="plu2">

                        <label class="col-sm-1 text-center" for="plu2" >QTY GONDOLA</label>
                        <input class="form-control col-sm-2" type="text" name="plu2" id="plu2" placeholder="plu2">

                        <label class="col-sm-1 text-center" for="plu2" >PKMG</label>
                        <input class="form-control col-sm-2" type="text" name="plu2" id="plu2" placeholder="plu2">
                    </div>
                    <hr style="background-color: grey">
                    <div class="row">
                        <div class="col-sm-10">
                            <h6>TAMBAH</h6>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>NO PERJANJIAN</th>
                                        <th>PLU</th>
                                        <th>KD DISPLAY</th>
                                        <th>TGL AWAL</th>
                                        <th>TGL AKHIR</th>
                                        <th>QTY</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-2 d-flex align-items-center justify-content-center">
                            {{-- <div> --}}
                                <button type="button" class="btn btn-primary w-75">ADD</button>
                            {{-- </div>                             --}}
                        </div>
                    </div>
                    <hr style="background-color: grey">
                    <div class="row">
                        <div class="col-sm-2 justify-content-center">
                            <h6>UPLOAD</h6>
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-primary">UPLOAD</button>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <p>File CSV harus ada di server database /u01/lhost/trf_mplus/DATA/</p>
                            <p>Filename NPLUS_GO.CSV separator |</p>
                            <p>List PLU yang tidak terproses ada di S:/TRF/  (jika ada)</p>
                        </div>
                        <div class="col-sm-2 d-flex align-items-center justify-content-center">
                            <div>
                                <button type="button" class="btn btn-primary">REFRESH</button>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="card border-dark m-form">               
                <div class="card-body shadow-lg cardForm">
                    <br>
                    <div class="row no-gutters">
                        <label class="col-sm-4 text-right font-weight-normal">B</label>
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
    $(document).ready(function () {
        $('.m-form').hide();

        $('#nBtn').click(function (e) {
            $('.m-form').hide();          
            $('.n-form').show();          
        });
        $('#mBtn').click(function (e) {
            $('.n-form').hide();
            $('.m-form').show();            
        });
    });

    function getData(params) {
        
    }
</script>
@endsection