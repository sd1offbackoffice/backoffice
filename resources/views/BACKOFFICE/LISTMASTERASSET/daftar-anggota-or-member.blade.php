{{--ASSET LIST MASTER--}}
{{-- DAFTAR ANGGOTA/MEMBER --}}

<div>
    <fieldset class="card border-dark">
{{--        <legend class="w-auto ml-5">Daftar Produk</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Kode</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu5Mem1Input" class="form-control" type="text">
                <button id="menu5BtnMem1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#memModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu5Mem1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Kode</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu5Mem2Input" class="form-control" type="text">
                <button id="menu5BtnMem2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#memModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu5Mem2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Pilihan</label>
            <div class="col-sm-6">
                <select class="form-control" id="menu5Pilihan">
                    <option value="1">SEMUA</option>
                    <option value="2">AKTIF</option>
                    <option value="3">TIDAK AKTIF</option>
                </select>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Outlet</label>
            <div class="col-sm-2 buttonInside">
                <input id="menu5OutlInput" class="form-control" type="text">
                <button id="menu5BtnOutl" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#outletModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-3">
                <input id="menu5OutlDesk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sub Outlet</label>
            <div class="col-sm-2 buttonInside">
                <input id="menu5SOu1Input" class="form-control" type="text">
                <button id="menu5BtnSOu1" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#subOutletModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <label class="col-sm-1 text-center col-form-label">s/d</label>
            <div class="col-sm-2 buttonInside">
                <input id="menu5SOu2Input" class="form-control" type="text">
                <button id="menu5BtnSOu2" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#subOutletModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Urut (SORT) Atas</label>
            <div class="col-sm-6">
                <select class="form-control" id="menu5SortBy">
                    <option value="1">1. OUTLET+AREA+KODE</option>
                    <option value="2">2. OUTLET+AREA+NAMA</option>
                    <option value="3">3. OUTLET+KODE</option>
                    <option value="4">4. OUTLER+NAMA</option>
                    <option value="5">5. AREA+KODE</option>
                    <option value="6">6. AREA+NAMA</option>
                    <option value="7">7. KODE</option>
                    <option value="8">8. NAMA</option>
                    <option value="9">9. BLOCKING PENGIRIMAN</option>
                </select>
            </div>
        </div>

        <br>
        <div class="d-flex justify-content-start">
            <label class="font-weight-bold">&nbsp;&nbsp;SUB OUTLET KOSONG = SEMUA</label>
        </div>
    </fieldset>
</div>

<script>
    //Fungsi isi berurutan
    $('#menu5Mem2Input').on('focus',function(){
        if($('#menu5Mem1Input').val() == ''){
            $('#menu5Mem1Input').focus();
        }
    });

    $('#menu5Mem1Input').on('change',function(){
        $('#menu5Mem2Input').val('').change();

        $('#menu5Mem1Desk').val('');
        $('#menu5Mem2Desk').val('');
        if($('#menu5Mem1Input').val() == ''){
            $('#menu5BtnMem2').prop("hidden",true);
        }else{
            let deskripsi = checkMemExist($('#menu5Mem1Input').val());
            if(deskripsi != "false"){
                $('#menu5Mem1Desk').val(deskripsi);
                $('#menu5BtnMem2').prop("hidden",false);
            }else{
                swal('', "Kode Member tidak terdaftar", 'warning');
                $('#menu5Mem1Input').val('').change();
            }
        }
    });
    $('#menu5Mem2Input').on('change',function(){
        $('#menu5Mem2Desk').val('');
        if($('#menu5Mem2Input').val() == ''){
            //code here
        }else{
            //code here
            let deskripsi = checkMemExist($('#menu5Mem2Input').val());
            if(deskripsi != "false"){
                $('#menu5Mem2Desk').val(deskripsi);
            }else{
                swal('', "Kode Member tidak terdaftar", 'warning');
                $('#menu5Mem2Input').val('').change();
            }
        }
    });

    //Fungsi isi outlet berurutan
    $('#menu5SOu1Input').on('focus',function(){
        if($('#menu5OutlInput').val() == ''){
            $('#menu5OutlInput').focus();
        }
    });
    $('#menu5SOu2Input').on('focus',function(){
        if($('#menu5OutlInput').val() == ''){
            $('#menu5OutlInput').focus();
        }else if($('#menu5SOu1Input').val() == ''){
            $('#menu5SOu1Input').focus();
        }
    });

    $('#menu5OutlInput').on('change',function(){
        $('#menu5SOu1Input').val('').change();
        $('#menu5SOu2Input').val('').change();

        $('#menu5OutlDesk').val('');
        if($('#menu5OutlInput').val() == ''){
            $('#menu5BtnSOu1').prop("hidden",true);
        }else{
            let index = checkOutletExist($('#menu5OutlInput').val());
            if(index){
                $('#menu5OutlDesk').val(tableOutlet.row(index-1).data()['out_namaoutlet'].replace(/&amp;/g, '&'));
                $('#outletFilterer').val($('#menu5OutlInput').val()).change();
                $('#menu5BtnSOu1').prop("hidden",false);
            }else{
                swal('', "Kode Outlet tidak terdaftar", 'warning');
                $('#menu5OutlInput').val('').change();
            }
        }
    });

    $('#menu5SOu1Input').on('change',function(){
        $('#menu5SOu2Input').val('').change();
        if($('#menu5SOu1Input').val() == ''){
            $('#menu5BtnSOu2').prop("hidden",true);
        }else{
            let index = checkSubOutletExist($('#menu5SOu1Input').val());
            if(index){
                // $('#menu5OutlDesk').val(deskripsi);
                $('#menu5BtnSOu2').prop("hidden",false);
            }else{
                swal('', "Kode Sub-Outlet tidak terdaftar", 'warning');
                $('#menu5SOu1Input').val('').change();
            }
        }
    });
    $('#menu5SOu2Input').on('change',function(){
        if($('#menu5SOu2Input').val() == ''){
            //code here
        }else{
            let index = checkSubOutletExist($('#menu5SOu2Input').val());
            if(index){
                //code here
            }else{
                swal('', "Kode Sub-Outlet tidak terdaftar", 'warning');
                $('#menu5SOu2Input').val('');
            }
        }
    });


    function menu5Choose(val){
        //val dan curson didapat dari "list-master.blade.php"
        let kode = val.children().first().next().text();
        let index = cursor.substr(8,4);
        switch (index){
            case "Mem1":
                $('#menu5Mem1Input').val(kode).change();
                setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                    $('#menu5Mem1Input').focus();
                }, 10);

                break;
            case "Mem2":
                $('#menu5Mem2Input').val(kode).change();
                setTimeout(function() {
                    $('#menu5Mem2Input').focus();
                }, 10);
                break;
            case "Outl":
                $('#menu5OutlInput').val(kode).change();
                setTimeout(function() {
                    $('#menu5OutlInput').focus();
                }, 10);
                break;
            case "SOu1":
                $('#menu5SOu1Input').val(kode).change();
                setTimeout(function() {
                    $('#menu5SOu1Input').focus();
                }, 10);
                break;
            case "SOu2":
                $('#menu5SOu2Input').val(kode);
                setTimeout(function() {
                    $('#menu5SOu2Input').focus();
                }, 10);
                break;
        }
    }

    function menu5Clear(){
        $('#menu5Mem1Input').val('').change();
        $('#menu5OutlInput').val('').change();
        $('#menu5Pilihan').val(1);
        $('#menu5SortBy').val(1);
        $('#outletFilterer').val('').change();
    }
    function menu5Cetak(){
        alert('cetak menu 5');
    }
</script>
