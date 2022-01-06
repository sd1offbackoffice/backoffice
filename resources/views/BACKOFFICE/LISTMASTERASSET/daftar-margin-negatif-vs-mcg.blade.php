{{--ASSET LIST MASTER--}}
{{-- DAFTAR MARGIN NEGATIF VS MCG --}}

<div>
    <fieldset class="card border-dark">
{{--        <legend class="w-auto ml-5">Daftar margin negatif vs mcg</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Divisi</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuFDiv1Input" class="form-control" type="text">
                <button id="menuFBtnDiv1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#divModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuFDiv1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Divisi</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuFDiv2Input" class="form-control" type="text">
                <button id="menuFBtnDiv2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#divModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuFDiv2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Dept</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuFDep1Input" class="form-control" type="text">
                <button id="menuFBtnDep1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#depModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuFDep1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Dept</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuFDep2Input" class="form-control" type="text">
                <button id="menuFBtnDep2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#depModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuFDep2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Kat</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuFKat1Input" class="form-control" type="text">
                <button id="menuFBtnKat1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#katModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuFKat1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Kat</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuFKat2Input" class="form-control" type="text">
                <button id="menuFBtnKat2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#katModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuFKat2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Urut (SORT) Atas</label>
            <div class="col-sm-6">
                <select class="form-control" id="menuFSortBy">
                    <option value="1">1. DIV+DEPT+KATEGORI+KODE</option>
                    <option value="2">2. DIV+DEPT+KATEGORI+NAMA</option>
                    <option value="3">3. NAMA</option>
                </select>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Tag</label>
            <div class="col-sm-1">
                <input id="menuFTag1" class="form-control" type="text">
            </div>
            <div class="col-sm-1">
                <input id="menuFTag2" class="form-control" type="text">
            </div>
            <div class="col-sm-1">
                <input id="menuFTag3" class="form-control" type="text">
            </div>
            <div class="col-sm-1">
                <input id="menuFTag4" class="form-control" type="text">
            </div>
            <div class="col-sm-1">
                <input id="menuFTag5" class="form-control" type="text">
            </div>
            <div class="col-sm-1">
                <input id="menuFTag6" class="form-control" type="text">
            </div>
        </div>
        <br>
    </fieldset>
</div>

<script>
    $('#menuFdaterangepicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD/MM/YYYY',
        }
    });

    //Fungsi isi berurutan
    $('#menuFDiv2Input').on('focus',function(){
        if($('#menuFDiv1Input').val() == ''){
            $('#menuFDiv1Input').focus();
        }
    });
    $('#menuFDep1Input, #menuFBtnDep1').on('focus',function(){
        $('#minDep').val($('#menuFDiv1Input').val());
        $('#maxDep').val($('#menuFDiv1Input').val()).change();

        if($('#menuFDiv1Input').val() == ''){
            $('#menuFDiv1Input').focus();
        }
        else if($('#menuFDiv2Input').val() == ''){
            $('#menuFDiv2Input').focus();
        }
    });
    $('#menuFDep2Input, #menuFBtnDep2').on('focus',function(){
        $('#minDep').val($('#menuFDiv2Input').val());
        $('#maxDep').val($('#menuFDiv2Input').val()).change();

        if($('#menuFDiv1Input').val() == ''){
            $('#menuFDiv1Input').focus();
        }
        else if($('#menuFDiv2Input').val() == ''){
            $('#menuFDiv2Input').focus();
        }
        else if($('#menuFDep1Input').val() == ''){
            $('#menuFDep1Input').focus();
        }
    });
    $('#menuFKat1Input, #menuFBtnKat1').on('focus',function(){
        $('#limitKat').val($('#menuFDep1Input').val()).change();

        if($('#menuFDiv1Input').val() == ''){
            $('#menuFDiv1Input').focus();
        }
        else if($('#menuFDiv2Input').val() == ''){
            $('#menuFDiv2Input').focus();
        }
        else if($('#menuFDep1Input').val() == ''){
            $('#menuFDep1Input').focus();
        }
        else if($('#menuFDep2Input').val() == ''){
            $('#menuFDep2Input').focus();
        }
    });
    $('#menuFKat2Input, #menuFBtnKat2').on('focus',function(){
        $('#limitKat').val($('#menuFDep2Input').val()).change();

        if($('#menuFDiv1Input').val() == ''){
            $('#menuFDiv1Input').focus();
        }
        else if($('#menuFDiv2Input').val() == ''){
            $('#menuFDiv2Input').focus();
        }
        else if($('#menuFDep1Input').val() == ''){
            $('#menuFDep1Input').focus();
        }
        else if($('#menuFDep2Input').val() == ''){
            $('#menuFDep2Input').focus();
        }
        else if($('#menuFKat1Input').val() == ''){
            $('#menuFKat1Input').focus();
        }
    });

    $('#menuFDiv1Input').on('change',function(){
        $('#menuFDiv2Input').val('').change();
        $('#menuFDep1Input').val('').change();
        $('#menuFDep2Input').val('').change();
        $('#menuFKat1Input').val('').change();
        $('#menuFKat2Input').val('').change();

        $('#menuFDiv1Desk').val('');
        $('#menuFDiv2Desk').val('');
        $('#menuFDep1Desk').val('');
        $('#menuFDep2Desk').val('');
        $('#menuFKat1Desk').val('');
        $('#menuFKat2Desk').val('');
        if($('#menuFDiv1Input').val() == ''){
            $('#menuFBtnDiv2').prop("hidden",true);


            $('#minDep').val('').change();
        }else{
            let index = checkDivExist($('#menuFDiv1Input').val());
            if(index){
                $('#menuFDiv1Desk').val(tableDivisi.row(index-1).data()['div_namadivisi'].replace(/&amp;/g, '&'));

                $('#menuFBtnDiv2').prop("hidden",false);
            }else{
                swal('', "Kode Divisi tidak terdaftar", 'warning');
                //$('#minDep').val('').change();
                $('#menuFDiv1Input').val('').change().focus();
            }
        }
    });
    $('#menuFDiv2Input').on('change',function(){
        $('#menuFDep1Input').val('').change();
        $('#menuFDep2Input').val('').change();
        $('#menuFKat1Input').val('').change();
        $('#menuFKat2Input').val('').change();

        $('#menuFDiv2Desk').val('');
        $('#menuFDep1Desk').val('');
        $('#menuFDep2Desk').val('');
        $('#menuFKat1Desk').val('');
        $('#menuFKat2Desk').val('');
        if($('#menuFDiv2Input').val() == ''){
            $('#menuFBtnDep1').prop("hidden",true);


            $('#maxDep').val('').change();
        }else{
            let index = checkDivExist($('#menuFDiv2Input').val());
            if(index){
                $('#menuFDiv2Desk').val(tableDivisi.row(index-1).data()['div_namadivisi'].replace(/&amp;/g, '&'));

                $('#menuFBtnDep1').prop("hidden",false);
            }else{
                swal('', "Kode Divisi tidak terdaftar", 'warning');

                $('#menuFDiv2Input').val('').change();
            }
        }
    });
    $('#menuFDep1Input').on('change',function(){
        $('#menuFDep2Input').val('').change();
        $('#menuFKat1Input').val('').change();
        $('#menuFKat2Input').val('').change();

        $('#menuFDep1Desk').val('');
        $('#menuFDep2Desk').val('');
        $('#menuFKat1Desk').val('');
        $('#menuFKat2Desk').val('');
        if($('#menuFDep1Input').val() == ''){
            $('#menuFBtnDep2').prop("hidden",true);


            $('#limitKat').val('').change();
        }else{
            let index = checkDepExist($('#menuFDep1Input').val());
            if(index){
                $('#menuFDep1Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));

                $('#menuFBtnDep2').prop("hidden",false);
            }else{
                swal('', "Kode Departement tidak terdaftar", 'warning');

                $('#menuFDep1Input').val('').change();
            }
        }
    });
    $('#menuFDep2Input').on('change',function(){
        $('#menuFKat1Input').val('').change();
        $('#menuFKat2Input').val('').change();

        $('#menuFDep2Desk').val('');
        $('#menuFKat1Desk').val('');
        $('#menuFKat2Desk').val('');
        if($('#menuFDep2Input').val() == ''){
            $('#menuFBtnKat1').prop("hidden",true);


            $('#limitKat').val('').change();
        }else{
            let index = checkDepExist($('#menuFDep2Input').val());
            if(index){
                $('#menuFDep2Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));

                $('#menuFBtnKat1').prop("hidden",false);
            }else{
                swal('', "Kode Departement tidak terdaftar", 'warning');

                $('#menuFDep2Input').val('').change();
            }
        }
    });
    $('#menuFKat1Input').on('change',function(){
        $('#menuFKat2Input').val('').change();

        $('#menuFKat1Desk').val('');
        $('#menuFKat2Desk').val('');
        if($('#menuFKat1Input').val() == ''){
            $('#menuFBtnKat2').prop("hidden",true);

        }else{
            let index = checkKatExist($('#menuFKat1Input').val());
            if(index){
                $('#menuFKat1Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));

                $('#menuFBtnKat2').prop("hidden",false);
            }else{
                swal('', "Kode Kategori tidak terdaftar", 'warning');

                $('#menuFKat1Input').val('').change();
            }
        }
    });
    $('#menuFKat2Input').on('change',function(){
        $('#menuFKat2Desk').val('');
        if($('#menuFKat2Input').val() == ''){
            //code here
        }else{
            //code here
            let index = checkKatExist($('#menuFKat2Input').val());
            if(index){
                $('#menuFKat2Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));
            }else{
                swal('', "Kode Kategori tidak terdaftar", 'warning');

                $('#menuFKat2Input').val('').change();
            }
        }
    });

    //Tag berurutan
    $('#menuFTag2').on('focus',function(){
        if($('#menuFTag1').val() == ''){
            $('#menuFTag1').focus();
        }
    });
    $('#menuFTag3').on('focus',function(){
        if($('#menuFTag1').val() == ''){
            $('#menuFTag1').focus();
        }else if($('#menuFTag2').val() == ''){
            $('#menuFTag2').focus();
        }
    });
    $('#menuFTag4').on('focus',function(){
        if($('#menuFTag1').val() == ''){
            $('#menuFTag1').focus();
        }else if($('#menuFTag2').val() == ''){
            $('#menuFTag2').focus();
        }else if($('#menuFTag3').val() == ''){
            $('#menuFTag3').focus();
        }
    });
    $('#menuFTag5').on('focus',function(){
        if($('#menuFTag1').val() == ''){
            $('#menuFTag1').focus();
        }else if($('#menuFTag2').val() == ''){
            $('#menuFTag2').focus();
        }else if($('#menuFTag3').val() == ''){
            $('#menuFTag3').focus();
        }else if($('#menuFTag4').val() == ''){
            $('#menuFTag4').focus();
        }
    });
    $('#menuFTag6').on('focus',function(){
        if($('#menuFTag1').val() == ''){
            $('#menuFTag1').focus();
        }else if($('#menuFTag2').val() == ''){
            $('#menuFTag2').focus();
        }else if($('#menuFTag3').val() == ''){
            $('#menuFTag3').focus();
        }else if($('#menuFTag4').val() == ''){
            $('#menuFTag4').focus();
        }else if($('#menuFTag5').val() == ''){
            $('#menuFTag5').focus();
        }
    });
    $('#menuFTag1').on('change',function(){
        $('#menuFTag2').val('');
        $('#menuFTag3').val('');
        $('#menuFTag4').val('');
        $('#menuFTag5').val('');
        $('#menuFTag6').val('');
    });
    $('#menuFTag2').on('change',function(){
        $('#menuFTag3').val('');
        $('#menuFTag4').val('');
        $('#menuFTag5').val('');
        $('#menuFTag6').val('');
    });
    $('#menuFTag3').on('change',function(){
        $('#menuFTag4').val('');
        $('#menuFTag5').val('');
        $('#menuFTag6').val('');
    });
    $('#menuFTag4').on('change',function(){
        $('#menuFTag5').val('');
        $('#menuFTag6').val('');
    });
    $('#menuFTag5').on('change',function(){
        $('#menuFTag6').val('');
    });

    function menuFChoose(val){
        //val dan curson didapat dari "list-master.blade.php"
        let kode = val.children().first().next().text();
        // let namadivisi = val.children().first().text();
        let index = cursor.substr(8,4);
        switch (index){
            case "Div1":
                $('#menuFDiv1Input').val(kode).change();
                // $('#menuFDiv1Desk').val(namadivisi);
                $('#minDep').val(kode).change();
                setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                    $('#menuFDiv1Input').focus();
                }, 10);

                break;
            case "Div2":
                $('#menuFDiv2Input').val(kode).change();
                // $('#menuFDiv2Desk').val(namadivisi);
                $('#maxDep').val(kode).change();
                setTimeout(function() {
                    $('#menuFDiv2Input').focus();
                }, 10);
                break;
            case "Dep1":
                $('#menuFDep1Input').val(kode).change();
                // $('#menuFDiv2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menuFDep1Input').focus();
                }, 10);
                break;
            case "Dep2":
                $('#menuFDep2Input').val(kode).change();
                // $('#menuFDiv2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menuFDep2Input').focus();
                }, 10);
                break;
            case "Kat1":
                $('#menuFKat1Input').val(kode).change();
                setTimeout(function() {
                    $('#menuFKat1Input').focus();
                }, 10);
                break;
            case "Kat2":
                $('#menuFKat2Input').val(kode).change();
                setTimeout(function() {
                    $('#menuFKat2Input').focus();
                }, 10);
                break;
        }
    }
    function menuFClear(){
        $('#menuFDiv1Input').val('').change();
        $('#menuFDiv1Desk').val('');
        $('#menuFDiv2Desk').val('');
        $('#menuFDep1Desk').val('');
        $('#menuFDep2Desk').val('');
        $('#menuFKat1Desk').val('');
        $('#menuFKat2Desk').val('');
        $('#menuFTag1').val('').change();
        $('#menuFSortBy').val(1);
    }
    function menuFCetak(){
        //DIV & DEP & KAT
        let temp = '';
        let div1 = $('#menuFDiv1Input').val();
        let div2 = $('#menuFDiv2Input').val();
        let dep1 = $('#menuFDep1Input').val();
        let dep2 = $('#menuFDep2Input').val();
        let kat1 = $('#menuFKat1Input').val();
        let kat2 = $('#menuFKat2Input').val();

        if(div1 != '' && div2 != ''){ // karena dep dan kat tak mungkin isi tanpa isi div, maka hanya perlu 1 kondisi ini,
            if(parseInt(div1) > parseInt(div2)){ // karena nilai dep1 dan ka1 berdasarkan div1, maka ganti cek div1 saja, sama dengan dep2 dan kat2
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

        // TAG
        let tag1 = $('#menuFTag1').val();
        let tag2 = $('#menuFTag2').val();
        let tag3 = $('#menuFTag3').val();
        let tag4 = $('#menuFTag4').val();
        let tag5 = $('#menuFTag5').val();
        let tag6 = $('#menuFTag6').val();
        let ptag = '';
        if(tag1 != '' || tag2 != '' || tag3 != '' || tag4 != '' || tag5 != '' || tag6 != ''){
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
            if(tag6 != ''){
                ptag = ptag+",'"+tag6+"'";
            }else{
                ptag = ptag+",'b'";
            }
        }

        //sortby
        let sort = $('#menuFSortBy').val();

        //PRINT
        window.open(`{{ url()->current() }}/print-daftar-margin-negatif-vs-mcg?div1=${div1}&div2=${div2}&dep1=${dep1}&dep2=${dep2}&kat1=${kat1}&kat2=${kat2}&ptag=${ptag}&sort=${sort}`, '_blank');
    }
</script>
