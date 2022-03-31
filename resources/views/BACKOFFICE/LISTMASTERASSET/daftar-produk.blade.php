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

        //limit departemen dalam divisi
        $('#minDep').val($('#menu1Div1Input').val());
        $('#maxDep').val($('#menu1Div1Input').val()).change();

        if($('#menu1Div1Input').val() == ''){
            $('#menu1Div1Input').focus();
        }
        else if($('#menu1Div2Input').val() == ''){
            $('#menu1Div2Input').focus();
        }
    });
    $('#menu1Dep2Input, #menu1BtnDep2').on('focus',function(){

        //limit departemen dalam divisi
        $('#minDep').val($('#menu1Div2Input').val());
        $('#maxDep').val($('#menu1Div2Input').val()).change();
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
    $('#menu1Kat1Input, #menu1BtnKat1').on('focus',function(){
        $('#limitKat').val($('#menu1Dep1Input').val()).change();

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
    $('#menu1Kat2Input, #menu1BtnKat2').on('focus',function(){
        $('#limitKat').val($('#menu1Dep2Input').val()).change();

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
                // $('#maxDep').val($('#menu1Div2Input').val()).change();
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

            $('#limitKat').val('').change();
        }else{
            let index = checkDepExist($('#menu1Dep1Input').val());
            if(index){
                $('#menu1Dep1Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));

                $('#menu1BtnDep2').prop("hidden",false);
            }else{
                swal('', "Kode Departement tidak terdaftar", 'warning');
                $('#limitKat').val('').change();
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


            $('#limitKat').val('').change();
        }else{
            let index = checkDepExist($('#menu1Dep2Input').val());
            if(index){
                $('#menu1Dep2Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));

                $('#menu1BtnKat1').prop("hidden",false);
            }else{
                swal('', "Kode Departement tidak terdaftar", 'warning');
                $('#limitKat').val('').change();
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

                $('#menu1BtnKat2').prop("hidden",false);
            }else{
                swal('', "Kode Kategori tidak terdaftar", 'warning');

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
                console.log(`kat2: ${kode}`);
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
        //Date
        let date = $('#menu1daterangepicker').val();
        // if(date == null || date == ""){
        //     swal('Periode tidak boleh kosong','','warning');
        //     return false;
        // }
        let dateA = date.substr(0,10);
        dateA = dateA.split('/').join('-');

        //DIV & DEP & KAT
        let temp = '';
        let div1 = $('#menu1Div1Input').val();
        let div2 = $('#menu1Div2Input').val();
        let dep1 = $('#menu1Dep1Input').val();
        let dep2 = $('#menu1Dep2Input').val();
        let kat1 = $('#menu1Kat1Input').val();
        let kat2 = $('#menu1Kat2Input').val();
        //periksa agar input tidak aneh" meski input sudah dibatasin, jaga" kalau input nya pakai f12
        if(div1 != ''){
            if(checkDivExist(div1) == false){
                swal('', "Kode Divisi tidak terdaftar", 'warning');
                return false;
            }
        }
        if(div2 != ''){
            if(checkDivExist(div2) == false){
                swal('', "Kode Divisi tidak terdaftar", 'warning');
                return false;
            }
        }
        if(dep1 != ''){
            //limit departemen berdasarkan divisi, tak perlu trigger fungsi change, karena bukan untuk tampilan
            $('#minDep').val(div1);
            $('#maxDep').val(div1);
            if(checkDepExist(dep1) == false){
                swal('', "Kode Departemen tidak terdaftar", 'warning');
                return false;
            }
        }
        if(dep2 != ''){
            //limit departemen berdasarkan divisi, tak perlu trigger fungsi change, karena bukan untuk tampilan
            $('#minDep').val(div2);
            $('#maxDep').val(div2);
            if(checkDepExist(dep2) == false){
                swal('', "Kode Departemen tidak terdaftar", 'warning');
                return false;
            }
        }
        if(kat1 != ''){
            //limit kategori berdasarkan departemen, tak perlu trigger fungsi change, karena bukan untuk tampilan

            $('#limitKat').val(dep1);
            if(checkKatExist(kat1) == false){
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                return false;
            }
        }
        if(kat2 != ''){
            //limit kategori berdasarkan departemen, tak perlu trigger fungsi change, karena bukan untuk tampilan

            $('#limitKat').val(dep2);
            if(checkKatExist(kat2) == false){
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                return false;
            }
        }

        // if(div1 != '' && div2 != ''){ // karena dep dan kat tak mungkin isi tanpa isi div, maka hanya perlu 1 kondisi ini,
        //     if(parseInt(div1) > parseInt(div2)){ // karena nilai dep1 dan ka1 berdasarkan div1, maka ganti cek div1 saja, sama dengan dep2 dan kat2
        //         temp = div1;
        //         div1 = div2;
        //         div2 = temp;
        //         temp = dep1;
        //         dep1 = dep2;
        //         dep2 = temp;
        //         temp = kat1;
        //         kat1 = kat2;
        //         kat2 = temp;
        //     }
        // }

        // TAG
        let tag1 = $('#menu1Tag1').val();
        let tag2 = $('#menu1Tag2').val();
        let tag3 = $('#menu1Tag3').val();
        let tag4 = $('#menu1Tag4').val();
        let tag5 = $('#menu1Tag5').val();
        let ptag = '';
        if(tag1 != '' || tag2 != '' || tag3 != '' || tag4 != '' || tag5 != ''){
            if(tag1 != ''){
                ptag = "'"+tag1+"'";
            }else{
                ptag = "'b'";
            }
            if(tag2 != ''){
                ptag = ptag+",'"+tag2+"'";
            }else{
                ptag = ptag+",'b'";
            }
            if(tag3 != ''){
                ptag = ptag+",'"+tag3+"'";
            }else{
                ptag = ptag+",'b'";
            }
            if(tag4 != ''){
                ptag = ptag+",'"+tag4+"'";
            }else{
                ptag = ptag+",'b'";
            }
            if(tag5 != ''){
                ptag = ptag+",'"+tag5+"'";
            }else{
                ptag = ptag+",'b'";
            }
        }

        //checkboxes
        let produkbaru = 0;
        if($('#menu1CheckProduk').prop("checked")){
            produkbaru = 1;
        }
        let chp = 0;
        if($('#menu1CheckCHP').prop("checked")){
            chp = 1;
        }

        //sortby
        let sort = $('#menu1SortBy').val();

        //PRINT
        window.open(`{{ url()->current() }}/print-daftar-produk?div1=${div1}&div2=${div2}&dep1=${dep1}&dep2=${dep2}&kat1=${kat1}&kat2=${kat2}&ptag=${ptag}&date=${dateA}&produkbaru=${produkbaru}&chp=${chp}&sort=${sort}`, '_blank');
    }
</script>
