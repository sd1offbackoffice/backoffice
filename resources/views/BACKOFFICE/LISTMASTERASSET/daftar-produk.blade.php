{{--ASSET LIST MASTER--}}
{{-- DAFTAR PRODUK --}}

<div>
    <fieldset class="card border-dark">
{{--        <legend class="w-auto ml-5">Daftar Produk</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Divisi</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu1Div1Input" class="form-control" type="text">
                <button id="menu1BtnDiv1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#divModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu1Div1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Divisi</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu1Div2Input" class="form-control" type="text">
                <button id="menu1BtnDiv2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#divModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu1Div2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Dept</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu1Dep1Input" class="form-control" type="text">
                <button id="menu1BtnDep1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#depModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu1Dep1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Dept</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu1Dep2Input" class="form-control" type="text">
                <button id="menu1BtnDep2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#depModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu1Dep2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Kat</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu1Kat1Input" class="form-control" type="text">
                <button id="menu1BtnKat1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#katModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu1Kat1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Kat</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu1Kat2Input" class="form-control" type="text">
                <button id="menu1BtnKat2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#katModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu1Kat2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Urut (SORT) Atas</label>
            <div class="col-sm-6">
                <select class="form-control" id="menu1SortBy">
                    <option value="1">1. DIV+DEPT+KATEGORI+KODE</option>
                    <option value="2">2. DIV+DEPT+KATEGORI+NAMA</option>
                    <option value="3">3. NAMA</option>
                </select>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Tag</label>
            <div class="col-sm-1">
                <input id="menu1Tag1" class="form-control" type="text">
            </div>
            <div class="col-sm-1">
                <input id="menu1Tag2" class="form-control" type="text">
            </div>
            <div class="col-sm-1">
                <input id="menu1Tag3" class="form-control" type="text">
            </div>
            <div class="col-sm-1">
                <input id="menu1Tag4" class="form-control" type="text">
            </div>
            <div class="col-sm-1">
                <input id="menu1Tag5" class="form-control" type="text">
            </div>
        </div>
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Produk Baru</label>
            <div class="col-sm-1">
                <input id="menu1CheckProduk" class="form-control" type="checkbox">
            </div>
            <label class="col-sm-3 text-right col-form-label">Periode Produk Baru</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu1daterangepicker" class="form-control" type="text">
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Cetak Harga Pokok</label>
            <div class="col-sm-1">
                <input id="menu1CheckCHP" class="form-control" type="checkbox">
            </div>
        </div>
        <br>
    </fieldset>
</div>

<script>
    $('#menu1daterangepicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD/MM/YYYY',
        }
    });

    //Fungsi isi berurutan
    $('#menu1Div2Input').on('focus',function(){
        if($('#menu1Div1Input').val() == ''){
            $('#menu1Div1Input').focus();
        }
    });
    $('#menu1Dep1Input, #menu1BtnDep1').on('focus',function(){

        //limit departemen dalam divi
        $('#minDep').val($('#menu1Div1Input').val());
        $('#maxDep').val($('#menu1Div1Input').val()).change();

        if($('#menu1Div1Input').val() == ''){
            $('#menu1Div1Input').focus();
        }
        else if($('#menu1Div2Input').val() == ''){
            $('#menu1Div2Input').focus();
        }
    });
    $('#menu1Dep2Input').on('focus',function(){
        if($('#menu1Div1Input').val() == ''){
            $('#menu1Div1Input').focus();
        }
        else if($('#menu1Div2Input').val() == ''){
            $('#menu1Div2Input').focus();
        }
        else if($('#menu1Dep1Input').val() == ''){
            $('#menu1Dep1Input').focus();
        }
    });
    $('#menu1Kat1Input').on('focus',function(){
        if($('#menu1Div1Input').val() == ''){
            $('#menu1Div1Input').focus();
        }
        else if($('#menu1Div2Input').val() == ''){
            $('#menu1Div2Input').focus();
        }
        else if($('#menu1Dep1Input').val() == ''){
            $('#menu1Dep1Input').focus();
        }
        else if($('#menu1Dep2Input').val() == ''){
            $('#menu1Dep2Input').focus();
        }
    });
    $('#menu1Kat2Input').on('focus',function(){
        if($('#menu1Div1Input').val() == ''){
            $('#menu1Div1Input').focus();
        }
        else if($('#menu1Div2Input').val() == ''){
            $('#menu1Div2Input').focus();
        }
        else if($('#menu1Dep1Input').val() == ''){
            $('#menu1Dep1Input').focus();
        }
        else if($('#menu1Dep2Input').val() == ''){
            $('#menu1Dep2Input').focus();
        }
        else if($('#menu1Kat1Input').val() == ''){
            $('#menu1Kat1Input').focus();
        }
    });

    $('#menu1Div1Input').on('change',function(){
        $('#menu1Div2Input').val('').change();
        $('#menu1Dep1Input').val('').change();
        $('#menu1Dep2Input').val('').change();
        $('#menu1Kat1Input').val('').change();
        $('#menu1Kat2Input').val('').change();

        $('#menu1Div1Desk').val('');
        $('#menu1Div2Desk').val('');
        $('#menu1Dep1Desk').val('');
        $('#menu1Dep2Desk').val('');
        $('#menu1Kat1Desk').val('');
        $('#menu1Kat2Desk').val('');
        if($('#menu1Div1Input').val() == ''){
            $('#menu1BtnDiv2').prop("hidden",true);


            $('#minDep').val('').change();
        }else{
            let index = checkDivExist($('#menu1Div1Input').val());
            if(index){
                $('#menu1Div1Desk').val(tableDivisi.row(index-1).data()['div_namadivisi'].replace(/&amp;/g, '&'));
                $('#menu1BtnDiv2').prop("hidden",false);
            }else{
                swal('', "Kode Divisi tidak terdaftar", 'warning');
                $('#minDep').val('').change();
                $('#menu1Div1Input').val('').change().focus();
            }
        }
    });
    $('#menu1Div2Input').on('change',function(){
        $('#menu1Dep1Input').val('').change();
        $('#menu1Dep2Input').val('').change();
        $('#menu1Kat1Input').val('').change();
        $('#menu1Kat2Input').val('').change();

        $('#menu1Div2Desk').val('');
        $('#menu1Dep1Desk').val('');
        $('#menu1Dep2Desk').val('');
        $('#menu1Kat1Desk').val('');
        $('#menu1Kat2Desk').val('');
        if($('#menu1Div2Input').val() == ''){
            $('#menu1BtnDep1').prop("hidden",true);


            $('#maxDep').val('').change();
        }else{
            let index = checkDivExist($('#menu1Div2Input').val());
            if(index){
                $('#menu1Div2Desk').val(tableDivisi.row(index-1).data()['div_namadivisi'].replace(/&amp;/g, '&'));
                $('#maxDep').val($('#menu1Div2Input').val()).change();
                $('#menu1BtnDep1').prop("hidden",false);
            }else{
                swal('', "Kode Divisi tidak terdaftar", 'warning');
                $('#maxDep').val('').change();
                $('#menu1Div2Input').val('').change();
            }
        }
    });
    $('#menu1Dep1Input').on('change',function(){
        $('#menu1Dep2Input').val('').change();
        $('#menu1Kat1Input').val('').change();
        $('#menu1Kat2Input').val('').change();

        $('#menu1Dep1Desk').val('');
        $('#menu1Dep2Desk').val('');
        $('#menu1Kat1Desk').val('');
        $('#menu1Kat2Desk').val('');
        if($('#menu1Dep1Input').val() == ''){
            $('#menu1BtnDep2').prop("hidden",true);


            $('#minKat').val('').change();
        }else{
            let index = checkDepExist($('#menu1Dep1Input').val());
            if(index){
                $('#menu1Dep1Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));
                $('#minKat').val($('#menu1Dep1Input').val()).change();
                $('#menu1BtnDep2').prop("hidden",false);
            }else{
                swal('', "Kode Departement tidak terdaftar", 'warning');
                $('#minKat').val('').change();
                $('#menu1Dep1Input').val('').change();
            }
        }
    });
    $('#menu1Dep2Input').on('change',function(){
        $('#menu1Kat1Input').val('').change();
        $('#menu1Kat2Input').val('').change();

        $('#menu1Dep2Desk').val('');
        $('#menu1Kat1Desk').val('');
        $('#menu1Kat2Desk').val('');
        if($('#menu1Dep2Input').val() == ''){
            $('#menu1BtnKat1').prop("hidden",true);


            $('#maxKat').val('').change();
        }else{
            let index = checkDepExist($('#menu1Dep2Input').val());
            if(index){
                $('#menu1Dep2Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));
                $('#maxKat').val($('#menu1Dep2Input').val()).change();
                $('#menu1BtnKat1').prop("hidden",false);
            }else{
                swal('', "Kode Departement tidak terdaftar", 'warning');
                $('#maxKat').val('').change();
                $('#menu1Dep2Input').val('').change();
            }
        }
    });
    $('#menu1Kat1Input').on('change',function(){
        $('#menu1Kat2Input').val('').change();

        $('#menu1Kat1Desk').val('');
        $('#menu1Kat2Desk').val('');
        if($('#menu1Kat1Input').val() == ''){
            $('#menu1BtnKat2').prop("hidden",true);

        }else{
            let index = checkKatExist($('#menu1Kat1Input').val());
            if(index){
                $('#menu1Kat1Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));
                // $('#minKat').val($('#menu1Kat1Input').val()).change();
                $('#menu1BtnKat2').prop("hidden",false);
            }else{
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                // $('#minKat').val('').change();
                $('#menu1Kat1Input').val('').change();
            }
        }
    });
    $('#menu1Kat2Input').on('change',function(){
        $('#menu1Kat2Desk').val('');
        if($('#menu1Kat2Input').val() == ''){
            //code here
        }else{
            //code here
            let index = checkKatExist($('#menu1Kat2Input').val());
            if(index){
                $('#menu1Kat2Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));
            }else{
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                // $('#minKat').val('').change();
                $('#menu1Kat2Input').val('').change();
            }
        }
    });

    //Tag berurutan
    $('#menu1Tag2').on('focus',function(){
        if($('#menu1Tag1').val() == ''){
            $('#menu1Tag1').focus();
        }
    });
    $('#menu1Tag3').on('focus',function(){
        if($('#menu1Tag1').val() == ''){
            $('#menu1Tag1').focus();
        }else if($('#menu1Tag2').val() == ''){
            $('#menu1Tag2').focus();
        }
    });
    $('#menu1Tag4').on('focus',function(){
        if($('#menu1Tag1').val() == ''){
            $('#menu1Tag1').focus();
        }else if($('#menu1Tag2').val() == ''){
            $('#menu1Tag2').focus();
        }else if($('#menu1Tag3').val() == ''){
            $('#menu1Tag3').focus();
        }
    });
    $('#menu1Tag5').on('focus',function(){
        if($('#menu1Tag1').val() == ''){
            $('#menu1Tag1').focus();
        }else if($('#menu1Tag2').val() == ''){
            $('#menu1Tag2').focus();
        }else if($('#menu1Tag3').val() == ''){
            $('#menu1Tag3').focus();
        }else if($('#menu1Tag4').val() == ''){
            $('#menu1Tag4').focus();
        }
    });
    $('#menu1Tag1').on('change',function(){
        $('#menu1Tag2').val('');
        $('#menu1Tag3').val('');
        $('#menu1Tag4').val('');
        $('#menu1Tag5').val('');
    });
    $('#menu1Tag2').on('change',function(){
        $('#menu1Tag3').val('');
        $('#menu1Tag4').val('');
        $('#menu1Tag5').val('');
    });
    $('#menu1Tag3').on('change',function(){
        $('#menu1Tag4').val('');
        $('#menu1Tag5').val('');
    });
    $('#menu1Tag4').on('change',function(){
        $('#menu1Tag5').val('');
    });

    function menu1Choose(val){
        //val dan curson didapat dari "list-master.blade.php"
        let kode = val.children().first().next().text();
        // let namadivisi = val.children().first().text();
        let index = cursor.substr(8,4);
        switch (index){
            case "Div1":
                $('#menu1Div1Input').val(kode).change();
                // $('#menu1Div1Desk').val(namadivisi);
                $('#minDep').val(kode).change();
                setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                    $('#menu1Div1Input').focus();
                }, 10);

                break;
            case "Div2":
                $('#menu1Div2Input').val(kode).change();
                // $('#menu1Div2Desk').val(namadivisi);
                $('#maxDep').val(kode).change();
                setTimeout(function() {
                    $('#menu1Div2Input').focus();
                }, 10);
                break;
            case "Dep1":
                $('#menu1Dep1Input').val(kode).change();
                // $('#menu1Div2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menu1Dep1Input').focus();
                }, 10);
                break;
            case "Dep2":
                $('#menu1Dep2Input').val(kode).change();
                // $('#menu1Div2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menu1Dep2Input').focus();
                }, 10);
                break;
            case "Kat1":
                $('#menu1Kat1Input').val(kode).change();
                setTimeout(function() {
                    $('#menu1Kat1Input').focus();
                }, 10);
                break;
            case "Kat2":
                $('#menu1Kat2Input').val(kode).change();
                setTimeout(function() {
                    $('#menu1Kat2Input').focus();
                }, 10);
                break;
        }
    }

    function menu1Clear(){
        $('#menu1Div1Input').val('').change();
        $('#menu1Div1Desk').val('');
        $('#menu1Div2Desk').val('');
        $('#menu1Dep1Desk').val('');
        $('#menu1Dep2Desk').val('');
        $('#menu1Kat1Desk').val('');
        $('#menu1Kat2Desk').val('');
        $('#menu1Tag1').val('').change();
        $('#menu1SortBy').val(1);
        $('#menu1CheckProduk').prop("checked",false);
        $('#menu1CheckCHP').prop("checked",false);
        $('#menu1daterangepicker').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
        // $('#menu1daterangepicker').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));
    }

    function menu1Cetak(){
        alert('cetak menu 1');
    }
</script>
