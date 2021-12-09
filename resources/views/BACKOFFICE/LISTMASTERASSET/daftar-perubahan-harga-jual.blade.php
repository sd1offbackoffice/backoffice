{{--ASSET LIST MASTER--}}
{{-- DAFTAR PERUBAHAN HARGA JUAL --}}
{{--NOTE!!!! MENU 2 DAN MENU F SAMA HANYA BEDA INISIAL DAN FORM REPORT NYA--}}

<div>
    <fieldset class="card border-dark">
        {{--        <legend class="w-auto ml-5">Daftar Perubahan Harga Jual</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Tanggal</label>
            <div class="col-sm-6 buttonInside">
                <input id="menu2daterangepicker" class="form-control" type="text">
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Divisi</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu2Div1Input" class="form-control" type="text">
                <button id="menu2BtnDiv1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#divModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu2Div1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Divisi</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu2Div2Input" class="form-control" type="text">
                <button id="menu2BtnDiv2" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#divModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu2Div2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Dept</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu2Dep1Input" class="form-control" type="text">
                <button id="menu2BtnDep1" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#depModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu2Dep1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Dept</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu2Dep2Input" class="form-control" type="text">
                <button id="menu2BtnDep2" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#depModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu2Dep2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Kat</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu2Kat1Input" class="form-control" type="text">
                <button id="menu2BtnKat1" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#katModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu2Kat1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Kat</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu2Kat2Input" class="form-control" type="text">
                <button id="menu2BtnKat2" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#katModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu2Kat2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Urut (SORT) Atas</label>
            <div class="col-sm-6">
                <select class="form-control" id="menu2SortBy">
                    <option value="1">1. DIV+DEPT+KATEGORI+KODE</option>
                    <option value="2">2. DIV+DEPT+KATEGORI+NAMA</option>
                    <option value="3">3. NAMA</option>
                </select>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Tag</label>
            <div class="col-sm-2">
                <input id="menu2Tag1" class="form-control" type="text">
            </div>
            <label class="col-sm-2 text-center col-form-label">s/d</label>
            <div class="col-sm-2">
                <input id="menu2Tag2" class="form-control" type="text">
            </div>
        </div>
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Discontinue</label>
            <div class="col-sm-1">
                <input id="menu2Check" class="form-control" type="checkbox">
            </div>
        </div>
        <br>
    </fieldset>
</div>

<script>
    $('#menu2daterangepicker').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY',
        }
    });

    //Fungsi isi berurutan
    $('#menu2Div2Input').on('focus',function(){
        if($('#menu2Div1Input').val() == ''){
            $('#menu2Div1Input').focus();
        }
    });
    $('#menu2Dep1Input, #menu2BtnDep1').on('focus',function(){
        $('#minDep').val($('#menu2Div1Input').val());
        $('#maxDep').val($('#menu2Div1Input').val()).change();

        if($('#menu2Div1Input').val() == ''){
            $('#menu2Div1Input').focus();
        }
        else if($('#menu2Div2Input').val() == ''){
            $('#menu2Div2Input').focus();
        }
    });
    $('#menu2Dep2Input, #menu2BtnDep2').on('focus',function(){
        $('#minDep').val($('#menu2Div2Input').val());
        $('#maxDep').val($('#menu2Div2Input').val()).change();

        if($('#menu2Div1Input').val() == ''){
            $('#menu2Div1Input').focus();
        }
        else if($('#menu2Div2Input').val() == ''){
            $('#menu2Div2Input').focus();
        }
        else if($('#menu2Dep1Input').val() == ''){
            $('#menu2Dep1Input').focus();
        }
    });
    $('#menu2Kat1Input, #menu2BtnKat1').on('focus',function(){
        $('#minKat').val($('#menu2Dep1Input').val());
        $('#maxKat').val($('#menu2Dep1Input').val()).change();

        if($('#menu2Div1Input').val() == ''){
            $('#menu2Div1Input').focus();
        }
        else if($('#menu2Div2Input').val() == ''){
            $('#menu2Div2Input').focus();
        }
        else if($('#menu2Dep1Input').val() == ''){
            $('#menu2Dep1Input').focus();
        }
        else if($('#menu2Dep2Input').val() == ''){
            $('#menu2Dep2Input').focus();
        }
    });
    $('#menu2Kat2Input, #menu2BtnKat2').on('focus',function(){
        $('#minKat').val($('#menu2Dep2Input').val());
        $('#maxKat').val($('#menu2Dep2Input').val()).change();

        if($('#menu2Div1Input').val() == ''){
            $('#menu2Div1Input').focus();
        }
        else if($('#menu2Div2Input').val() == ''){
            $('#menu2Div2Input').focus();
        }
        else if($('#menu2Dep1Input').val() == ''){
            $('#menu2Dep1Input').focus();
        }
        else if($('#menu2Dep2Input').val() == ''){
            $('#menu2Dep2Input').focus();
        }
        else if($('#menu2Kat1Input').val() == ''){
            $('#menu2Kat1Input').focus();
        }
    });

    $('#menu2Div1Input').on('change',function(){
        $('#menu2Div2Input').val('').change();
        $('#menu2Dep1Input').val('').change();
        $('#menu2Dep2Input').val('').change();
        $('#menu2Kat1Input').val('').change();
        $('#menu2Kat2Input').val('').change();

        $('#menu2Div1Desk').val('');
        $('#menu2Div2Desk').val('');
        $('#menu2Dep1Desk').val('');
        $('#menu2Dep2Desk').val('');
        $('#menu2Kat1Desk').val('');
        $('#menu2Kat2Desk').val('');
        if($('#menu2Div1Input').val() == ''){
            $('#menu2BtnDiv2').prop("hidden",true);


            $('#minDep').val('').change();
        }else{
            let index = checkDivExist($('#menu2Div1Input').val());
            if(index){
                $('#menu2Div1Desk').val(tableDivisi.row(index-1).data()['div_namadivisi'].replace(/&amp;/g, '&'));

                $('#menu2BtnDiv2').prop("hidden",false);
            }else{
                swal('', "Kode Divisi tidak terdaftar", 'warning');

                $('#menu2Div1Input').val('').change().focus();
            }
        }
    });
    $('#menu2Div2Input').on('change',function(){
        $('#menu2Dep1Input').val('').change();
        $('#menu2Dep2Input').val('').change();
        $('#menu2Kat1Input').val('').change();
        $('#menu2Kat2Input').val('').change();

        $('#menu2Div2Desk').val('');
        $('#menu2Dep1Desk').val('');
        $('#menu2Dep2Desk').val('');
        $('#menu2Kat1Desk').val('');
        $('#menu2Kat2Desk').val('');
        if($('#menu2Div2Input').val() == ''){
            $('#menu2BtnDep1').prop("hidden",true);


            $('#maxDep').val('').change();
        }else{
            let index = checkDivExist($('#menu2Div2Input').val());
            if(index){
                $('#menu2Div2Desk').val(tableDivisi.row(index-1).data()['div_namadivisi'].replace(/&amp;/g, '&'));

                $('#menu2BtnDep1').prop("hidden",false);
            }else{
                swal('', "Kode Divisi tidak terdaftar", 'warning');

                $('#menu2Div2Input').val('').change();
            }
        }
    });
    $('#menu2Dep1Input').on('change',function(){
        $('#menu2Dep2Input').val('').change();
        $('#menu2Kat1Input').val('').change();
        $('#menu2Kat2Input').val('').change();

        $('#menu2Dep1Desk').val('');
        $('#menu2Dep2Desk').val('');
        $('#menu2Kat1Desk').val('');
        $('#menu2Kat2Desk').val('');
        if($('#menu2Dep1Input').val() == ''){
            $('#menu2BtnDep2').prop("hidden",true);

            $('#minKat').val('').change();
        }else{
            let index = checkDepExist($('#menu2Dep1Input').val());
            if(index){
                $('#menu2Dep1Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));

                $('#menu2BtnDep2').prop("hidden",false);
            }else{
                swal('', "Kode Departement tidak terdaftar", 'warning');

                $('#menu2Dep1Input').val('').change();
            }
        }
    });
    $('#menu2Dep2Input').on('change',function(){
        $('#menu2Kat1Input').val('').change();
        $('#menu2Kat2Input').val('').change();

        $('#menu2Dep2Desk').val('');
        $('#menu2Kat1Desk').val('');
        $('#menu2Kat2Desk').val('');
        if($('#menu2Dep2Input').val() == ''){
            $('#menu2BtnKat1').prop("hidden",true);


            $('#maxKat').val('').change();
        }else{
            let index = checkDepExist($('#menu2Dep2Input').val());
            if(index){
                $('#menu2Dep2Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));

                $('#menu2BtnKat1').prop("hidden",false);
            }else{
                swal('', "Kode Departement tidak terdaftar", 'warning');

                $('#menu2Dep2Input').val('').change();
            }
        }
    });
    $('#menu2Kat1Input').on('change',function(){
        $('#menu2Kat2Input').val('').change();

        $('#menu2Kat1Desk').val('');
        $('#menu2Kat2Desk').val('');
        if($('#menu2Kat1Input').val() == ''){
            $('#menu2BtnKat2').prop("hidden",true);

        }else{
            let index = checkKatExist($('#menu2Kat1Input').val());
            if(index){
                $('#menu2Kat1Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));
                // $('#minKat').val($('#menu2Kat1Input').val()).change();
                $('#menu2BtnKat2').prop("hidden",false);
            }else{
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                // $('#minKat').val('').change();
                $('#menu2Kat1Input').val('').change();
            }
        }
    });
    $('#menu2Kat2Input').on('change',function(){
        $('#menu2Kat2Desk').val('');
        if($('#menu2Kat2Input').val() == ''){
            //code here
        }else{
            //code here
            let index = checkKatExist($('#menu2Kat2Input').val());
            if(index){
                $('#menu2Kat2Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));
            }else{
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                // $('#minKat').val('').change();
                $('#menu2Kat2Input').val('').change();
            }
        }
    });

    //Tag berurutan
    $('#menu2Tag2').on('focus',function(){
        if($('#menu2Tag1').val() == ''){
            $('#menu2Tag1').focus();
        }
    });
    $('#menu2Tag1').on('change',function(){
        $('#menu2Tag2').val('');
    });

    function menu2Choose(val){
        //val dan curson didapat dari "list-master.blade.php"
        let kode = val.children().first().next().text();
        // let namadivisi = val.children().first().text();
        let index = cursor.substr(8,4);
        switch (index){
            case "Div1":
                $('#menu2Div1Input').val(kode).change();
                // $('#menu2Div1Desk').val(namadivisi);
                $('#minDep').val(kode).change();
                setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                    $('#menu2Div1Input').focus();
                }, 10);

                break;
            case "Div2":
                $('#menu2Div2Input').val(kode).change();
                // $('#menu2Div2Desk').val(namadivisi);
                $('#maxDep').val(kode).change();
                setTimeout(function() {
                    $('#menu2Div2Input').focus();
                }, 10);
                break;
            case "Dep1":
                $('#menu2Dep1Input').val(kode).change();
                // $('#menu2Div2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menu2Dep1Input').focus();
                }, 10);
                break;
            case "Dep2":
                $('#menu2Dep2Input').val(kode).change();
                // $('#menu2Div2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menu2Dep2Input').focus();
                }, 10);
                break;
            case "Kat1":
                $('#menu2Kat1Input').val(kode).change();
                setTimeout(function() {
                    $('#menu2Kat1Input').focus();
                }, 10);
                break;
            case "Kat2":
                $('#menu2Kat2Input').val(kode).change();
                setTimeout(function() {
                    $('#menu2Kat2Input').focus();
                }, 10);
                break;
        }
    }

    function menu2Clear(){
        $('#menu2Div1Input').val('').change();
        $('#menu2Div1Desk').val('');
        $('#menu2Div2Desk').val('');
        $('#menu2Dep1Desk').val('');
        $('#menu2Dep2Desk').val('');
        $('#menu2Kat1Desk').val('');
        $('#menu2Kat2Desk').val('');
        $('#menu2Tag1').val('').change();
        $('#menu2SortBy').val(1);
        $('#menu2Check').prop("checked",false);
        $('#menu2daterangepicker').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
        $('#menu2daterangepicker').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));
    }

    function menu2Cetak(){
        let date = $('#menu2daterangepicker').val();
        if(date == null || date == ""){
            swal('Periode tidak boleh kosong','','warning');
            return false;
        }
        let dateA = date.substr(0,10);
        let dateB = date.substr(13,10);
        dateA = dateA.split('/').join('-');
        dateB = dateB.split('/').join('-');

        //DIV & DEP & KAT
        let temp = '';
        let div1 = $('#menu2Div1Input').val();
        let div2 = $('#menu2Div2Input').val();
        let dep1 = $('#menu2Dep1Input').val();
        let dep2 = $('#menu2Dep2Input').val();
        let kat1 = $('#menu2Kat1Input').val();
        let kat2 = $('#menu2Kat2Input').val();
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
            $('#minKat').val(dep1);
            $('#maxKat').val(dep1);
            if(checkKatExist(kat1) == false){
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                return false;
            }
        }
        if(kat2 != ''){
            //limit kategori berdasarkan departemen, tak perlu trigger fungsi change, karena bukan untuk tampilan
            $('#minKat').val(dep2);
            $('#maxKat').val(dep2);
            if(checkKatExist(kat2) == false){
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                return false;
            }
        }
        if(div1 != '' || div2 != ''){
            if(parseInt(div1) > parseInt(div2)){
                temp = div1;
                div1 = div2;
                div2 = temp;
                temp = dep1;
                dep1 = dep2;
                dep2 = temp;
                temp = kat1;
                kat1 = kat2;
                kat2 = temp;
            }
        }

        //sortby
        let sort = $('#menu2SortBy').val();

        // TAG
        let tag1 = $('#menu2Tag1').val();
        let tag2 = $('#menu2Tag2').val();

        let check = 0;
        if($('#menu2Check').prop("checked")){
            check = 1;
        }

        //PRINT
        window.open(`{{ url()->current() }}/print-daftar-perubahan-harga-jual?div1=${div1}&div2=${div2}&dep1=${dep1}&dep2=${dep2}&kat1=${kat1}&kat2=${kat2}&tag1=${tag1}&tag2=${tag2}&date1=${dateA}&date2=${dateB}&check=${check}&sort=${sort}`, '_blank');
    }
</script>
