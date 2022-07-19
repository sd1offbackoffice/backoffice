{{--ASSET LIST MASTER--}}
{{-- MASTER DISPLAY DIV DEPT KATB --}}

<div>
    <fieldset class="card border-dark">
        {{--        <legend class="w-auto ml-5">Master Display Div/Dept/Katb</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Mulai Divisi')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuEDiv1Input" class="form-control" type="text">
                <button id="menuEBtnDiv1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#divModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuEDiv1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Sampai Divisi')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuEDiv2Input" class="form-control" type="text">
                <button id="menuEBtnDiv2" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#divModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuEDiv2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Mulai Dept')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuEDep1Input" class="form-control" type="text">
                <button id="menuEBtnDep1" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#depModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuEDep1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Sampai Dept')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuEDep2Input" class="form-control" type="text">
                <button id="menuEBtnDep2" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#depModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuEDep2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Mulai Kat')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuEKat1Input" class="form-control" type="text">
                <button id="menuEBtnKat1" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#katModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuEKat1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Sampai Kat')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuEKat2Input" class="form-control" type="text">
                <button id="menuEBtnKat2" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#katModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuEKat2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Mulai PLU')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuEPlu1Input" class="form-control" type="text">
                <button id="menuEBtnPlu1" type="button" class="btn btn-lov p-0" onclick="menuETogglePlu()">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuEPlu1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Sampai PLU')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuEPlu2Input" class="form-control" type="text">
                <button id="menuEBtnPlu2" type="button" class="btn btn-lov p-0" onclick="menuETogglePlu()">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuEPlu2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Hanya Item OMI')</label>
            <div class="col-sm-1">
                <input id="menuECheck" class="form-control" type="checkbox">
            </div>
        </div>
        <br>
    </fieldset>
</div>

<script>
    //Fungsi isi berurutan
    $('#menuEDiv2Input').on('focus',function(){
        if($('#menuEDiv1Input').val() == ''){
            $('#menuEDiv1Input').focus();
        }
    });
    $('#menuEDep1Input, #menuEBtnDep1').on('focus',function(){
        $('#minDep').val($('#menuEDiv1Input').val());
        $('#maxDep').val($('#menuEDiv1Input').val()).change();

        if($('#menuEDiv1Input').val() == ''){
            $('#menuEDiv1Input').focus();
        }
        else if($('#menuEDiv2Input').val() == ''){
            $('#menuEDiv2Input').focus();
        }
    });
    $('#menuEDep2Input, #menuEBtnDep2').on('focus',function(){
        $('#minDep').val($('#menuEDiv2Input').val());
        $('#maxDep').val($('#menuEDiv2Input').val()).change();

        if($('#menuEDiv1Input').val() == ''){
            $('#menuEDiv1Input').focus();
        }
        else if($('#menuEDiv2Input').val() == ''){
            $('#menuEDiv2Input').focus();
        }
        else if($('#menuEDep1Input').val() == ''){
            $('#menuEDep1Input').focus();
        }
    });
    $('#menuEKat1Input, #menuEBtnKat1').on('focus',function(){
        $('#limitKat').val($('#menuEDep1Input').val()).change();

        if($('#menuEDiv1Input').val() == ''){
            $('#menuEDiv1Input').focus();
        }
        else if($('#menuEDiv2Input').val() == ''){
            $('#menuEDiv2Input').focus();
        }
        else if($('#menuEDep1Input').val() == ''){
            $('#menuEDep1Input').focus();
        }
        else if($('#menuEDep2Input').val() == ''){
            $('#menuEDep2Input').focus();
        }
    });
    $('#menuEKat2Input, #menuEBtnKat2').on('focus',function(){
        $('#limitKat').val($('#menuEDep2Input').val()).change();

        if($('#menuEDiv1Input').val() == ''){
            $('#menuEDiv1Input').focus();
        }
        else if($('#menuEDiv2Input').val() == ''){
            $('#menuEDiv2Input').focus();
        }
        else if($('#menuEDep1Input').val() == ''){
            $('#menuEDep1Input').focus();
        }
        else if($('#menuEDep2Input').val() == ''){
            $('#menuEDep2Input').focus();
        }
        else if($('#menuEKat1Input').val() == ''){
            $('#menuEKat1Input').focus();
        }
    });

    $('#menuEDiv1Input').on('change',function(){
        $('#menuEDiv2Input').val('').change();
        $('#menuEDep1Input').val('').change();
        $('#menuEDep2Input').val('').change();
        $('#menuEKat1Input').val('').change();
        $('#menuEKat2Input').val('').change();
        $('#menuEPlu1Input').val('');
        $('#menuEPlu2Input').val('');

        $('#menuEDiv1Desk').val('');
        $('#menuEDiv2Desk').val('');
        $('#menuEDep1Desk').val('');
        $('#menuEDep2Desk').val('');
        $('#menuEKat1Desk').val('');
        $('#menuEKat2Desk').val('');
        $('#menuEPlu1Desk').val('');
        $('#menuEPlu2Desk').val('');
        if($('#menuEDiv1Input').val() == ''){
            $('#menuEBtnDiv2').prop("hidden",true);


            $('#minDep').val('').change();
        }else{
            let index = checkDivExist($('#menuEDiv1Input').val());
            if(index){
                $('#menuEDiv1Desk').val(tableDivisi.row(index-1).data()['div_namadivisi'].replace(/&amp;/g, '&'));

                $('#menuEBtnDiv2').prop("hidden",false);
            }else{
                swal('',`{{ __('Kode Divisi tidak terdaftar') }}`, 'warning');

                $('#menuEDiv1Input').val('').change().focus();
            }
        }
    });
    $('#menuEDiv2Input').on('change',function(){
        $('#menuEDep1Input').val('').change();
        $('#menuEDep2Input').val('').change();
        $('#menuEKat1Input').val('').change();
        $('#menuEKat2Input').val('').change();
        $('#menuEPlu1Input').val('');
        $('#menuEPlu2Input').val('');

        $('#menuEDiv2Desk').val('');
        $('#menuEDep1Desk').val('');
        $('#menuEDep2Desk').val('');
        $('#menuEKat1Desk').val('');
        $('#menuEKat2Desk').val('');
        $('#menuEPlu1Desk').val('');
        $('#menuEPlu2Desk').val('');
        if($('#menuEDiv2Input').val() == ''){
            $('#menuEBtnDep1').prop("hidden",true);


            $('#maxDep').val('').change();
        }else{
            let index = checkDivExist($('#menuEDiv2Input').val());
            if(index){
                $('#menuEDiv2Desk').val(tableDivisi.row(index-1).data()['div_namadivisi'].replace(/&amp;/g, '&'));

                $('#menuEBtnDep1').prop("hidden",false);
            }else{
                swal('', `{{ __('Kode Divisi tidak terdaftar') }}`, 'warning');

                $('#menuEDiv2Input').val('').change();
            }
        }
    });
    $('#menuEDep1Input').on('change',function(){
        $('#menuEDep2Input').val('').change();
        $('#menuEKat1Input').val('').change();
        $('#menuEKat2Input').val('').change();
        $('#menuEPlu1Input').val('');
        $('#menuEPlu2Input').val('');

        $('#menuEDep1Desk').val('');
        $('#menuEDep2Desk').val('');
        $('#menuEKat1Desk').val('');
        $('#menuEKat2Desk').val('');
        $('#menuEPlu1Desk').val('');
        $('#menuEPlu2Desk').val('');
        if($('#menuEDep1Input').val() == ''){
            $('#menuEBtnDep2').prop("hidden",true);

            $('#limitKat').val('').change();
        }else{
            let index = checkDepExist($('#menuEDep1Input').val());
            if(index){
                $('#menuEDep1Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));

                $('#menuEBtnDep2').prop("hidden",false);
            }else{
                swal('', `{{ __('Kode Departemen tidak terdaftar') }}`, 'warning');

                $('#menuEDep1Input').val('').change();
            }
        }
    });
    $('#menuEDep2Input').on('change',function(){
        $('#menuEKat1Input').val('').change();
        $('#menuEKat2Input').val('').change();
        $('#menuEPlu1Input').val('');
        $('#menuEPlu2Input').val('');

        $('#menuEDep2Desk').val('');
        $('#menuEKat1Desk').val('');
        $('#menuEKat2Desk').val('');
        $('#menuEPlu1Desk').val('');
        $('#menuEPlu2Desk').val('');
        if($('#menuEDep2Input').val() == ''){
            $('#menuEBtnKat1').prop("hidden",true);


            $('#limitKat').val('').change();
        }else{
            let index = checkDepExist($('#menuEDep2Input').val());
            if(index){
                $('#menuEDep2Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));

                $('#menuEBtnKat1').prop("hidden",false);
            }else{
                swal('',`{{ __('Kode Departemen tidak terdaftar') }}`, 'warning');

                $('#menuEDep2Input').val('').change();
            }
        }
    });
    $('#menuEKat1Input').on('change',function(){
        $('#menuEKat2Input').val('').change();
        $('#menuEPlu1Input').val('');
        $('#menuEPlu2Input').val('');

        $('#menuEKat1Desk').val('');
        $('#menuEKat2Desk').val('');
        $('#menuEPlu1Desk').val('');
        $('#menuEPlu2Desk').val('');
        if($('#menuEKat1Input').val() == ''){
            $('#menuEBtnKat2').prop("hidden",true);

        }else{
            let index = checkKatExist($('#menuEKat1Input').val());
            if(index){
                $('#menuEKat1Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));

                $('#menuEBtnKat2').prop("hidden",false);
            }else{
                swal('',`{{ __('Kode Kategori tidak terdaftar') }}`, 'warning');

                $('#menuEKat1Input').val('').change();
            }
        }
    });
    $('#menuEKat2Input').on('change',function(){
        $('#menuEPlu1Input').val('');
        $('#menuEPlu2Input').val('');

        $('#menuEKat2Desk').val('');
        $('#menuEPlu1Desk').val('');
        $('#menuEPlu2Desk').val('');
        if($('#menuEKat2Input').val() == ''){
            //code here
        }else{
            //code here
            let index = checkKatExist($('#menuEKat2Input').val());
            if(index){
                $('#menuEKat2Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));
            }else{
                swal('',`{{ __('Kode Kategori tidak terdaftar') }}`, 'warning');

                $('#menuEKat2Input').val('').change();
            }
        }
    });

    $('#menuEPlu1Input').on('change',function(){
        $('#menuEPlu1Desk').val('');
        if($('#menuEPlu1Input').val() == ''){
            //nothing happened
        }else{
            //code here
            let data = checkPluExist($('#menuEPlu1Input').val());
            if(data != "false"){
                let deskripsi = data.prd_deskripsipanjang;
                // // tak perlu check apakah plu berdasarkan div, dep, kat, yg penting plu1 < plu 2, program lama gitu
                // let div = data.prd_kodedivisi;
                // let dep = data.prd_kodedepartement;
                // let kat = data.prd_kodekategoribarang;
                // if($('#menuEDiv1Input').val() != ''){
                //     let status = menuCCustomPluCheck(div,dep,kat);
                //     if(status){
                //         $('#menuEPlu1Desk').val(deskripsi);
                //     }else{
                //         swal('', "Kode PLU tidak sesuai dengan batasan div/dep/kat", 'warning');
                //         $('#menuEPlu1Input').val('').change();
                //     }
                // }else{
                //     $('#menuEPlu1Desk').val(deskripsi); // jadi hanya merubah deskripsi
                // }
                $('#menuEPlu1Desk').val(deskripsi);
            }else{
                swal('',`{{ __('Kode Plu tidak terdaftar') }}`, 'warning');

                $('#menuEPlu1Input').val('').change();
            }
        }
    });
    $('#menuEPlu2Input').on('change',function(){
        $('#menuEPlu2Desk').val('');
        if($('#menuEPlu2Input').val() == ''){
            //nothing happened
        }else{
            //code here
            let data = checkPluExist($('#menuEPlu2Input').val());
            if(data != "false"){
                let deskripsi = data.prd_deskripsipanjang;
                // let div = data.prd_kodedivisi;
                // let dep = data.prd_kodedepartement;
                // let kat = data.prd_kodekategoribarang;

                if($('#menuEDiv1Input').val() != ''){
                    // tak perlu check apakah plu berdasarkan div, dep, kat, yg penting plu1 < plu 2, program lama gitu
                    // let status = menuCCustomPluCheck(div,dep,kat);
                    // if(status){
                    //     $('#menuEPlu2Desk').val(deskripsi);
                    // }else{
                    //     swal('', "Kode PLU tidak sesuai dengan batasan div/dep/kat", 'warning');
                    //     $('#menuEPlu2Input').val('').change();
                    // }
                    $('#menuEPlu2Desk').val(deskripsi); // jadi hanya merubah deskripsi
                }else{
                    $('#menuEPlu2Desk').val(deskripsi);
                }
            }else{
                swal('',`{{ __('Kode Plu tidak terdaftar') }}`, 'warning');

                $('#menuEPlu2Input').val('').change();
            }
        }
    });

    function menuCCustomPluCheck(div, dep, kat){
        let match = 0;
        if($('#menuEDiv1Input').val() != ''){
            if(div == $('#menuEDiv1Input').val() || div == $('#menuEDiv2Input').val()){
                match++; //match=1
            }
            if($('#menuEDep1Input').val() != ''){
                if(dep == $('#menuEDep1Input').val() || dep == $('#menuEDep2Input').val()){
                    match++; //match=2
                }
            }else{
                match++; //match=2
            }
            if($('#menuEKat1Input').val() != ''){
                if(kat == $('#menuEKat1Input').val() || kat == $('#menuEKat2Input').val()){
                    match++; //match=3
                }
            }else{
                match++; //match=3
            }
            if(match == 3){
                return true;
            }else{
                return false
            }
        }
    }

    function menuEChoose(val){
        //val dan curson didapat dari "list-master.blade.php"
        let kode = val.children().first().next().text();
        // let namadivisi = val.children().first().text();
        let index = cursor.substr(8);
        switch (index){
            case "Div1":
                $('#menuEDiv1Input').val(kode).change();
                // $('#menuEDiv1Desk').val(namadivisi);
                $('#minDep').val(kode).change();
                setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                    $('#menuEDiv1Input').focus();
                }, 10);

                break;
            case "Div2":
                $('#menuEDiv2Input').val(kode).change();
                // $('#menuEDiv2Desk').val(namadivisi);
                $('#maxDep').val(kode).change();
                setTimeout(function() {
                    $('#menuEDiv2Input').focus();
                }, 10);
                break;
            case "Dep1":
                $('#menuEDep1Input').val(kode).change();
                // $('#menuEDiv2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menuEDep1Input').focus();
                }, 10);
                break;
            case "Dep2":
                $('#menuEDep2Input').val(kode).change();
                // $('#menuEDiv2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menuEDep2Input').focus();
                }, 10);
                break;
            case "Kat1":
                $('#menuEKat1Input').val(kode).change();
                setTimeout(function() {
                    $('#menuEKat1Input').focus();
                }, 10);
                break;
            case "Kat2":
                $('#menuEKat2Input').val(kode).change();
                setTimeout(function() {
                    $('#menuEKat2Input').focus();
                }, 10);
                break;
            case "Plu1":
                $('#menuEPlu1Input').val(kode).change();
                setTimeout(function() {
                    $('#menuEPlu1Input').focus();
                }, 10);
                break;
            case "Plu2":
                $('#menuEPlu2Input').val(kode).change();
                setTimeout(function() {
                    $('#menuEPlu2Input').focus();
                }, 10);
                break;
        }
    }

    function menuETogglePlu(){
        if($('#menuEDiv1Input').val() == ''){
            $('#pluModal').modal('toggle');
        }else{
            // tak perlu modal plu custom yang mana select value range a sampai b
            // let div1 = $('#menuEDiv1Input').val();
            // let div2 = $('#menuEDiv2Input').val();
            // let dep1 = $('#menuEDep1Input').val();
            // let dep2 = $('#menuEDep2Input').val();
            // let kat1 = $('#menuEKat1Input').val();
            // let kat2 = $('#menuEKat2Input').val();
            // getModalPluCustom(div1,div2,dep1,dep2,kat1,kat2);
            // $('#pluCustomModal').modal('toggle');
            //jadi panggil plu biasa
            $('#pluModal').modal('toggle');
        }
    }

    function menuEClear(){
        $('#menuEDiv1Input').val('').change();
        $('#menuEDiv1Desk').val('');
        $('#menuEDiv2Desk').val('');
        $('#menuEDep1Desk').val('');
        $('#menuEDep2Desk').val('');
        $('#menuEKat1Desk').val('');
        $('#menuEKat2Desk').val('');
        $('#menuECheck').prop("checked",false);
    }

    function menuECetak(){
        //DIV & DEP & KAT & PLU
        let div1 = $('#menuEDiv1Input').val();
        let div2 = $('#menuEDiv2Input').val();
        let dep1 = $('#menuEDep1Input').val();
        let dep2 = $('#menuEDep2Input').val();
        let kat1 = $('#menuEKat1Input').val();
        let kat2 = $('#menuEKat2Input').val();
        let plu1 = $('#menuEPlu1Input').val();
        let plu2 = $('#menuEPlu2Input').val();

        let temp = '';
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
        if(plu2 != ''){
            if(parseInt(plu1) > parseInt(plu2)){
                temp = plu1;
                plu1 = plu2;
                plu2 = temp;
            }
        }
        //checkboxes
        let omi = 0;
        if($('#menuECheck').prop("checked")){
            omi = 1;
        }

        //PRINT
        window.open(`{{ url()->current() }}/print-master-display-div-dep-kat?div1=${div1}&div2=${div2}&dep1=${dep1}&dep2=${dep2}&kat1=${kat1}&kat2=${kat2}&plu1=${plu1}&plu2=${plu2}&omi=${omi}`, '_blank');
    }
</script>
