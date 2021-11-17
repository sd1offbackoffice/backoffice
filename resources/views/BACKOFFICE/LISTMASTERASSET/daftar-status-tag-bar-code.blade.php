{{--ASSET LIST MASTER--}}
{{-- DAFTAR PRODUK --}}

<div>
    <fieldset class="card border-dark">
{{--        <legend class="w-auto ml-5">Daftar Produk</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Dept</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuCDep1Input" class="form-control" type="text">
                <button id="menuCBtnDep1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#depModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuCDep1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Dept</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuCDep2Input" class="form-control" type="text">
                <button id="menuCBtnDep2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#depModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuCDep2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Kat</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuCKat1Input" class="form-control" type="text">
                <button id="menuCBtnKat1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#katModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuCKat1Desk" class="form-control" type="text" disabled>
            </div>
            <input id="menuCKat1HiddenVal" class="form-control" type="text" hidden>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Kat</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuCKat2Input" class="form-control" type="text">
                <button id="menuCBtnKat2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#katModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuCKat2Desk" class="form-control" type="text" disabled>
            </div>
            <input id="menuCKat2HiddenVal" class="form-control" type="text" hidden>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Status</label>
            <div class="col-sm-6">
                <select class="form-control" id="menuCStatus">
                    <option value="0">SEMUA</option>
                    <option value="1">1. BN</option>
                    <option value="2">2. BC</option>
                    <option value="3">3. BD</option>
                </select>
            </div>
        </div>
        <br>
    </fieldset>
</div>

<script>
    //Fungsi isi berurutan
    let depLimiter = 0;
    $('#menuCDep1Input, #menuCBtnDep1').on('focus',function(){
        $('#filtererDep').val('').change();
    });
    $('#menuCDep2Input, #menuCBtnDep2').on('focus',function(){
        $('#filtererDep').val($('#menuCDep1Input').val()).change();
        if($('#menuCDep1Input').val() == ''){
            $('#menuCDep1Input').focus();
        }
    });
    $('#menuCKat1Input, #menuCBtnKat1').on('focus',function(){
        $('#filtererKat').val('');
        $('#filtererKat_Dep').val('').change();
        if($('#menuCDep1Input').val() == ''){
            $('#menuCDep1Input').focus();
        }
        else if($('#menuCDep2Input').val() == ''){
            $('#menuCDep2Input').focus();
        }
    });
    $('#menuCKat2Input, #menuCBtnKat2').on('focus',function(){
        $('#filtererKat').val($('#menuCKat1Input').val());
        $('#filtererKat_Dep').val($('#menuCKat1HiddenVal').val()).change();
        if($('#menuCDep1Input').val() == ''){
            $('#menuCDep1Input').focus();
        }
        else if($('#menuCDep2Input').val() == ''){
            $('#menuCDep2Input').focus();
        }
        else if($('#menuCKat1Input').val() == ''){
            $('#menuCKat1Input').focus();
        }
    });

    $('#menuCDep1Input').on('change',function(){
        $('#menuCDep2Input').val('').change();
        $('#menuCKat1Input').val('').change();
        $('#menuCKat2Input').val('').change();

        $('#menuCDep1Desk').val('');
        $('#menuCDep2Desk').val('');
        $('#menuCKat1Desk').val('');
        $('#menuCKat2Desk').val('');
        if($('#menuCDep1Input').val() == ''){
            $('#menuCBtnDep2').prop("hidden",true);


            $('#minKat').val('').change();
        }else{
            let index = checkDepExist($('#menuCDep1Input').val());
            if(index){
                $('#menuCDep1Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));
                // $('#filtererDep').val($('#menuCDep1Input').val()).change();
                $('#minKat').val($('#menuCDep1Input').val()).change();
                $('#menuCBtnDep2').prop("hidden",false);
            }else{
                swal('', "Kode Departement tidak terdaftar", 'warning');
                $('#minKat').val('').change();
                $('#menuCDep1Input').val('').change();
            }
        }
    });
    $('#menuCDep2Input').on('change',function(){
        $('#menuCKat1Input').val('').change();
        $('#menuCKat2Input').val('').change();

        $('#menuCDep2Desk').val('');
        $('#menuCKat1Desk').val('');
        $('#menuCKat2Desk').val('');
        if($('#menuCDep2Input').val() == ''){
            $('#menuCBtnKat1').prop("hidden",true);


            $('#maxKat').val('').change();
        }else{
            let index = checkDepExist($('#menuCDep2Input').val());
            if(index){
                $('#menuCDep2Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));
                $('#maxKat').val($('#menuCDep2Input').val()).change();
                $('#menuCBtnKat1').prop("hidden",false);
            }else{
                swal('', "Kode Departement tidak terdaftar atau lebih kecil dari kode sebelumnya", 'warning');
                $('#maxKat').val('').change();
                $('#menuCDep2Input').val('').change();
            }
        }
    });
    $('#menuCKat1Input').on('change',function(){
        $('#menuCKat2Input').val('').change();

        $('#menuCKat1Desk').val('');
        $('#menuCKat2Desk').val('');
        if($('#menuCKat1Input').val() == ''){
            $('#menuCBtnKat2').prop("hidden",true);
            $('#menuCKat1HiddenVal').val('');
        }else{
            let kodeDep = '';
            if($('#menuCKat1HiddenVal').val() != ''){
                kodeDep = $('#menuCKat1HiddenVal').val();
            }
            let index = checkKatExist($('#menuCKat1Input').val(), kodeDep);
            if(index){
                $('#menuCKat1Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));
                $('#menuCKat1HiddenVal').val(tableKategori.row(index-1).data()['kat_kodedepartement']);
                // $('#minKat').val($('#menuCKat1Input').val()).change();
                $('#menuCBtnKat2').prop("hidden",false);
            }else{
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                // $('#minKat').val('').change();
                $('#menuCKat1Input').val('').change();
            }
        }
    });
    $('#menuCKat2Input').on('change',function(){
        $('#menuCKat2Desk').val('');

        if($('#menuCKat2Input').val() == ''){
            //code here
            $('#menuCKat2HiddenVal').val('');
        }else{
            //code here
            let kodeDep = '';
            if($('#menuCKat2HiddenVal').val() != ''){
                kodeDep = $('#menuCKat2HiddenVal').val();
            }
            let index = checkKatExist($('#menuCKat2Input').val(),kodeDep);
            if(index){
                $('#menuCKat2Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));
                $('#menuCKat2HiddenVal').val(tableKategori.row(index-1).data()['kat_kodedepartement']);
            }else{
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                // $('#minKat').val('').change();
                $('#menuCKat2Input').val('').change();
            }
        }
    });

    //Tag berurutan
    $('#menuCTag2').on('focus',function(){
        if($('#menuCTag1').val() == ''){
            $('#menuCTag1').focus();
        }
    });
    $('#menuCTag3').on('focus',function(){
        if($('#menuCTag1').val() == ''){
            $('#menuCTag1').focus();
        }else if($('#menuCTag2').val() == ''){
            $('#menuCTag2').focus();
        }
    });
    $('#menuCTag4').on('focus',function(){
        if($('#menuCTag1').val() == ''){
            $('#menuCTag1').focus();
        }else if($('#menuCTag2').val() == ''){
            $('#menuCTag2').focus();
        }else if($('#menuCTag3').val() == ''){
            $('#menuCTag3').focus();
        }
    });
    $('#menuCTag5').on('focus',function(){
        if($('#menuCTag1').val() == ''){
            $('#menuCTag1').focus();
        }else if($('#menuCTag2').val() == ''){
            $('#menuCTag2').focus();
        }else if($('#menuCTag3').val() == ''){
            $('#menuCTag3').focus();
        }else if($('#menuCTag4').val() == ''){
            $('#menuCTag4').focus();
        }
    });
    $('#menuCTag1').on('change',function(){
        $('#menuCTag2').val('');
        $('#menuCTag3').val('');
        $('#menuCTag4').val('');
        $('#menuCTag5').val('');
    });
    $('#menuCTag2').on('change',function(){
        $('#menuCTag3').val('');
        $('#menuCTag4').val('');
        $('#menuCTag5').val('');
    });
    $('#menuCTag3').on('change',function(){
        $('#menuCTag4').val('');
        $('#menuCTag5').val('');
    });
    $('#menuCTag4').on('change',function(){
        $('#menuCTag5').val('');
    });

    function menuCChoose(val){
        //val dan curson didapat dari "list-master.blade.php"
        let kode = val.children().first().next().text();
        // let namadivisi = val.children().first().text();
        let index = cursor.substr(8,4);
        switch (index){
            case "Dep1":
                $('#menuCDep1Input').val(kode).change();
                // $('#menuCDiv2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menuCDep1Input').focus();
                }, 10);
                break;
            case "Dep2":
                $('#menuCDep2Input').val(kode).change();
                // $('#menuCDiv2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menuCDep2Input').focus();
                }, 10);
                break;
            case "Kat1":
                $('#menuCKat1HiddenVal').val(tableKategori.row( val ).data()['kat_kodedepartement']);
                $('#menuCKat1Input').val(kode).change();
                setTimeout(function() {
                    $('#menuCKat1Input').focus();
                }, 10);
                break;
            case "Kat2":
                $('#menuCKat2HiddenVal').val(tableKategori.row( val ).data()['kat_kodedepartement']);
                $('#menuCKat2Input').val(kode).change();
                setTimeout(function() {
                    $('#menuCKat2Input').focus();
                }, 10);
                break;
        }
    }

    function menuCClear(){
        $('#menuCDep1Input').val('').change();
        $('#menuCDiv1Desk').val('');
        $('#menuCDiv2Desk').val('');
        $('#menuCDep1Desk').val('');
        $('#menuCDep2Desk').val('');
        $('#menuCKat1Desk').val('');
        $('#menuCKat2Desk').val('');

        $('#menuCStatus').val(0);

        $('#filtererDep').val('').change();
        $('#filtererKat').val('').change();
    }

    function menuCCetak(){
        alert('cetak menu C');
    }
</script>
