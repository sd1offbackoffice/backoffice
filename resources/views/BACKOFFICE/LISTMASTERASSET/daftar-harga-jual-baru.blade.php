{{--ASSET LIST MASTER--}}
{{-- DAFTAR HARGA JUAL BARU --}}

<div>
    <fieldset class="card border-dark">
        {{--        <legend class="w-auto ml-5">Daftar Perubahan Harga Jual</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Tanggal</label>
            <div class="col-sm-6 buttonInside">
                <input id="menuAdaterangepicker" class="form-control" type="text">
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Divisi</label>
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
            <label class="col-sm-3 text-right col-form-label">Sampai Divisi</label>
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
            <label class="col-sm-3 text-right col-form-label">Mulai Dept</label>
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
            <label class="col-sm-3 text-right col-form-label">Sampai Dept</label>
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
            <label class="col-sm-3 text-right col-form-label">Mulai Kat</label>
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
            <label class="col-sm-3 text-right col-form-label">Sampai Kat</label>
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
            <label class="col-sm-3 text-right col-form-label">Urut (SORT) Atas</label>
            <div class="col-sm-6">
                <select class="form-control" id="menuASortBy">
                    <option value="1">1. DIV+DEPT+KATEGORI+KODE</option>
                    <option value="2">2. DIV+DEPT+KATEGORI+NAMA</option>
                    <option value="3">3. NAMA</option>
                </select>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Tag</label>
            <div class="col-sm-2">
                <input id="menuATag1" class="form-control" type="text">
            </div>
            <label class="col-sm-2 text-center col-form-label">s/d</label>
            <div class="col-sm-2">
                <input id="menuATag2" class="form-control" type="text">
            </div>
        </div>
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Discontinue</label>
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
    $('#menuADep1Input').on('focus',function(){
        if($('#menuADiv1Input').val() == ''){
            $('#menuADiv1Input').focus();
        }
        else if($('#menuADiv2Input').val() == ''){
            $('#menuADiv2Input').focus();
        }
    });
    $('#menuADep2Input').on('focus',function(){
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
    $('#menuAKat1Input').on('focus',function(){
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
    $('#menuAKat2Input').on('focus',function(){
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
                $('#minDep').val($('#menuADiv1Input').val()).change();
                $('#menuABtnDiv2').prop("hidden",false);
            }else{
                swal('', "Kode Divisi tidak terdaftar", 'warning');
                $('#minDep').val('').change();
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
                $('#maxDep').val($('#menuADiv2Input').val()).change();
                $('#menuABtnDep1').prop("hidden",false);
            }else{
                swal('', "Kode Divisi tidak terdaftar", 'warning');
                $('#maxDep').val('').change();
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


            $('#minKat').val('').change();
        }else{
            let index = checkDepExist($('#menuADep1Input').val());
            if(index){
                $('#menuADep1Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));
                $('#minKat').val($('#menuADep1Input').val()).change();
                $('#menuABtnDep2').prop("hidden",false);
            }else{
                swal('', "Kode Departement tidak terdaftar", 'warning');
                $('#minKat').val('').change();
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


            $('#maxKat').val('').change();
        }else{
            let index = checkDepExist($('#menuADep2Input').val());
            if(index){
                $('#menuADep2Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));
                $('#maxKat').val($('#menuADep2Input').val()).change();
                $('#menuABtnKat1').prop("hidden",false);
            }else{
                swal('', "Kode Departement tidak terdaftar", 'warning');
                $('#maxKat').val('').change();
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
                // $('#minKat').val($('#menuAKat1Input').val()).change();
                $('#menuABtnKat2').prop("hidden",false);
            }else{
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                // $('#minKat').val('').change();
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
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                // $('#minKat').val('').change();
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
        alert('cetak menu a');
    }
</script>
