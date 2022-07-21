{{--ASSET LIST MASTER--}}
{{-- DAFTAR PERUBAHAN HARGA JUAL --}}

<div>
    <fieldset class="card border-dark">
        {{--        <legend class="w-auto ml-5">Daftar Perubahan Harga Jual</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Tanggal')</label>
            <div class="col-sm-6 buttonInside">
                <input id="menuAdaterangepicker" class="form-control" type="text">
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Mulai Divisi')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuADiv1Input" class="form-control" type="text">
                <button id="menuABtnDiv1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#divModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuADiv1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Sampai Divisi')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuADiv2Input" class="form-control" type="text">
                <button id="menuABtnDiv2" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#divModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuADiv2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Mulai Dept')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuADep1Input" class="form-control" type="text">
                <button id="menuABtnDep1" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#depModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuADep1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Sampai Dept')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuADep2Input" class="form-control" type="text">
                <button id="menuABtnDep2" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#depModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuADep2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Mulai Kat')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuAKat1Input" class="form-control" type="text">
                <button id="menuABtnKat1" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#katModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuAKat1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Sampai Kat')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuAKat2Input" class="form-control" type="text">
                <button id="menuABtnKat2" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#katModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuAKat2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Urut (SORT) Atas')</label>
            <div class="col-sm-6">
                <select class="form-control" id="menuASortBy">
                    <option value="1">1. @lang('DIV+DEPT+KATEGORI+KODE')</option>
                    <option value="2">2. @lang('DIV+DEPT+KATEGORI+NAMA')</option>
                    <option value="3">3. {{ strtoupper(__('Nama')) }}</option>
                </select>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Tag')</label>
            <div class="col-sm-2">
                <input id="menuATag1" class="form-control" type="text">
            </div>
            <label class="col-sm-2 text-center col-form-label">@lang('s/d')</label>
            <div class="col-sm-2">
                <input id="menuATag2" class="form-control" type="text">
            </div>
        </div>
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Discontinue')</label>
            <div class="col-sm-1">
                <input id="menuACheck" class="form-control" type="checkbox">
            </div>
        </div>
        <br>
    </fieldset>
</div>

<script>
    $('#menuAdaterangepicker').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY',
        }
    });

    //Fungsi isi berurutan
    $('#menuADiv2Input').on('focus',function(){
        if($('#menuADiv1Input').val() == ''){
            $('#menuADiv1Input').focus();
        }
    });
    $('#menuADep1Input, #menuABtnDep1').on('focus',function(){
        $('#minDep').val($('#menuADiv1Input').val());
        $('#maxDep').val($('#menuADiv1Input').val()).change();

        if($('#menuADiv1Input').val() == ''){
            $('#menuADiv1Input').focus();
        }
        else if($('#menuADiv2Input').val() == ''){
            $('#menuADiv2Input').focus();
        }
    });
    $('#menuADep2Input, #menuABtnDep2').on('focus',function(){
        $('#minDep').val($('#menuADiv2Input').val());
        $('#maxDep').val($('#menuADiv2Input').val()).change();

        if($('#menuADiv1Input').val() == ''){
            $('#menuADiv1Input').focus();
        }
        else if($('#menuADiv2Input').val() == ''){
            $('#menuADiv2Input').focus();
        }
        else if($('#menuADep1Input').val() == ''){
            $('#menuADep1Input').focus();
        }
    });
    $('#menuAKat1Input, #menuABtnKat1').on('focus',function(){
        $('#limitKat').val($('#menuADep1Input').val()).change();

        if($('#menuADiv1Input').val() == ''){
            $('#menuADiv1Input').focus();
        }
        else if($('#menuADiv2Input').val() == ''){
            $('#menuADiv2Input').focus();
        }
        else if($('#menuADep1Input').val() == ''){
            $('#menuADep1Input').focus();
        }
        else if($('#menuADep2Input').val() == ''){
            $('#menuADep2Input').focus();
        }
    });
    $('#menuAKat2Input, #menuABtnKat2').on('focus',function(){
        $('#limitKat').val($('#menuADep2Input').val()).change();

        if($('#menuADiv1Input').val() == ''){
            $('#menuADiv1Input').focus();
        }
        else if($('#menuADiv2Input').val() == ''){
            $('#menuADiv2Input').focus();
        }
        else if($('#menuADep1Input').val() == ''){
            $('#menuADep1Input').focus();
        }
        else if($('#menuADep2Input').val() == ''){
            $('#menuADep2Input').focus();
        }
        else if($('#menuAKat1Input').val() == ''){
            $('#menuAKat1Input').focus();
        }
    });

    $('#menuADiv1Input').on('change',function(){
        $('#menuADiv2Input').val('').change();
        $('#menuADep1Input').val('').change();
        $('#menuADep2Input').val('').change();
        $('#menuAKat1Input').val('').change();
        $('#menuAKat2Input').val('').change();

        $('#menuADiv1Desk').val('');
        $('#menuADiv2Desk').val('');
        $('#menuADep1Desk').val('');
        $('#menuADep2Desk').val('');
        $('#menuAKat1Desk').val('');
        $('#menuAKat2Desk').val('');
        if($('#menuADiv1Input').val() == ''){
            $('#menuABtnDiv2').prop("hidden",true);


            $('#minDep').val('').change();
        }else{
            let index = checkDivExist($('#menuADiv1Input').val());
            if(index){
                $('#menuADiv1Desk').val(tableDivisi.row(index-1).data()['div_namadivisi'].replace(/&amp;/g, '&'));

                $('#menuABtnDiv2').prop("hidden",false);
            }else{
                swal('', `{{ __('Kode Divisi tidak terdaftar') }}`, 'warning');

                $('#menuADiv1Input').val('').change().focus();
            }
        }
    });
    $('#menuADiv2Input').on('change',function(){
        $('#menuADep1Input').val('').change();
        $('#menuADep2Input').val('').change();
        $('#menuAKat1Input').val('').change();
        $('#menuAKat2Input').val('').change();

        $('#menuADiv2Desk').val('');
        $('#menuADep1Desk').val('');
        $('#menuADep2Desk').val('');
        $('#menuAKat1Desk').val('');
        $('#menuAKat2Desk').val('');
        if($('#menuADiv2Input').val() == ''){
            $('#menuABtnDep1').prop("hidden",true);


            $('#maxDep').val('').change();
        }else{
            let index = checkDivExist($('#menuADiv2Input').val());
            if(index){
                $('#menuADiv2Desk').val(tableDivisi.row(index-1).data()['div_namadivisi'].replace(/&amp;/g, '&'));

                $('#menuABtnDep1').prop("hidden",false);
            }else{
                swal('',`{{ __('Kode Divisi tidak terdaftar') }}`, 'warning');

                $('#menuADiv2Input').val('').change();
            }
        }
    });
    $('#menuADep1Input').on('change',function(){
        $('#menuADep2Input').val('').change();
        $('#menuAKat1Input').val('').change();
        $('#menuAKat2Input').val('').change();

        $('#menuADep1Desk').val('');
        $('#menuADep2Desk').val('');
        $('#menuAKat1Desk').val('');
        $('#menuAKat2Desk').val('');
        if($('#menuADep1Input').val() == ''){
            $('#menuABtnDep2').prop("hidden",true);

            $('#limitKat').val('').change();
        }else{
            let index = checkDepExist($('#menuADep1Input').val());
            if(index){
                $('#menuADep1Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));

                $('#menuABtnDep2').prop("hidden",false);
            }else{
                swal('', `{{ __('Kode Departemen tidak terdaftar') }}`, 'warning');

                $('#menuADep1Input').val('').change();
            }
        }
    });
    $('#menuADep2Input').on('change',function(){
        $('#menuAKat1Input').val('').change();
        $('#menuAKat2Input').val('').change();

        $('#menuADep2Desk').val('');
        $('#menuAKat1Desk').val('');
        $('#menuAKat2Desk').val('');
        if($('#menuADep2Input').val() == ''){
            $('#menuABtnKat1').prop("hidden",true);


            $('#limitKat').val('').change();
        }else{
            let index = checkDepExist($('#menuADep2Input').val());
            if(index){
                $('#menuADep2Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));

                $('#menuABtnKat1').prop("hidden",false);
            }else{
                swal('', `{{ __('Kode Departemen tidak terdaftar') }}`, 'warning');

                $('#menuADep2Input').val('').change();
            }
        }
    });
    $('#menuAKat1Input').on('change',function(){
        $('#menuAKat2Input').val('').change();

        $('#menuAKat1Desk').val('');
        $('#menuAKat2Desk').val('');
        if($('#menuAKat1Input').val() == ''){
            $('#menuABtnKat2').prop("hidden",true);

        }else{
            let index = checkKatExist($('#menuAKat1Input').val());
            if(index){
                $('#menuAKat1Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));

                $('#menuABtnKat2').prop("hidden",false);
            }else{
                swal('', `{{ __('Kode Kategori tidak terdaftar') }}`, 'warning');

                $('#menuAKat1Input').val('').change();
            }
        }
    });
    $('#menuAKat2Input').on('change',function(){
        $('#menuAKat2Desk').val('');
        if($('#menuAKat2Input').val() == ''){
            //code here
        }else{
            //code here
            let index = checkKatExist($('#menuAKat2Input').val());
            if(index){
                $('#menuAKat2Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));
            }else{
                swal('', `{{ __('Kode Kategori tidak terdaftar') }}`, 'warning');

                $('#menuAKat2Input').val('').change();
            }
        }
    });

    //Tag berurutan
    $('#menuATag2').on('focus',function(){
        if($('#menuATag1').val() == ''){
            $('#menuATag1').focus();
        }
    });
    $('#menuATag1').on('change',function(){
        $('#menuATag2').val('');
    });

    function menuAChoose(val){
        //val dan curson didapat dari "list-master.blade.php"
        let kode = val.children().first().next().text();
        // let namadivisi = val.children().first().text();
        let index = cursor.substr(8,4);
        switch (index){
            case "Div1":
                $('#menuADiv1Input').val(kode).change();
                // $('#menuADiv1Desk').val(namadivisi);
                $('#minDep').val(kode).change();
                setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                    $('#menuADiv1Input').focus();
                }, 10);

                break;
            case "Div2":
                $('#menuADiv2Input').val(kode).change();
                // $('#menuADiv2Desk').val(namadivisi);
                $('#maxDep').val(kode).change();
                setTimeout(function() {
                    $('#menuADiv2Input').focus();
                }, 10);
                break;
            case "Dep1":
                $('#menuADep1Input').val(kode).change();
                // $('#menuADiv2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menuADep1Input').focus();
                }, 10);
                break;
            case "Dep2":
                $('#menuADep2Input').val(kode).change();
                // $('#menuADiv2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menuADep2Input').focus();
                }, 10);
                break;
            case "Kat1":
                $('#menuAKat1Input').val(kode).change();
                setTimeout(function() {
                    $('#menuAKat1Input').focus();
                }, 10);
                break;
            case "Kat2":
                $('#menuAKat2Input').val(kode).change();
                setTimeout(function() {
                    $('#menuAKat2Input').focus();
                }, 10);
                break;
        }
    }

    function menuAClear(){
        $('#menuADiv1Input').val('').change();
        $('#menuADiv1Desk').val('');
        $('#menuADiv2Desk').val('');
        $('#menuADep1Desk').val('');
        $('#menuADep2Desk').val('');
        $('#menuAKat1Desk').val('');
        $('#menuAKat2Desk').val('');
        $('#menuATag1').val('').change();
        $('#menuASortBy').val(1);
        $('#menuACheck').prop("checked",false);
        $('#menuAdaterangepicker').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
        $('#menuAdaterangepicker').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));
    }

    function menuACetak(){
        let date = $('#menuAdaterangepicker').val();
        if(date == null || date == ""){
            swal(`{{ __('Periode tidak boleh kosong') }}`,'','warning');
            return false;
        }
        let dateA = date.substr(0,10);
        let dateB = date.substr(13,10);
        dateA = dateA.split('/').join('-');
        dateB = dateB.split('/').join('-');

        //DIV & DEP & KAT
        let temp = '';
        let div1 = $('#menuADiv1Input').val();
        let div2 = $('#menuADiv2Input').val();
        let dep1 = $('#menuADep1Input').val();
        let dep2 = $('#menuADep2Input').val();
        let kat1 = $('#menuAKat1Input').val();
        let kat2 = $('#menuAKat2Input').val();
        if(div1 != '' && div2 != ''){
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
        let sort = $('#menuASortBy').val();

        // TAG
        let tag1 = $('#menuATag1').val();
        let tag2 = $('#menuATag2').val();

        let check = 0;
        if($('#menuACheck').prop("checked")){
            check = 1;
        }

        //PRINT
        window.open(`{{ url()->current() }}/print-daftar-harga-jual-baru?div1=${div1}&div2=${div2}&dep1=${dep1}&dep2=${dep2}&kat1=${kat1}&kat2=${kat2}&tag1=${tag1}&tag2=${tag2}&date1=${dateA}&date2=${dateB}&check=${check}&sort=${sort}`, '_blank');
    }
</script>
