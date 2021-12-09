{{--ASSET LIST MASTER--}}
{{-- DAFTAR STATUS TAG BAR --}}

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
            <label class="col-sm-3 text-right col-form-label">Mulai PLU</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuCPlu1Input" class="form-control" type="text">
                <button id="menuCBtnPlu1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#pluModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuCPlu1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai PLU</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuCPlu2Input" class="form-control" type="text">
                <button id="menuCBtnPlu2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#pluModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuCPlu2Desk" class="form-control" type="text" disabled>
            </div>
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
    $('#menuCDep2Input').on('focus',function(){
        if($('#menuCDep1Input').val() == ''){
            $('#menuCDep1Input').focus();
        }
    });
    $('#menuCKat1Input, #menuCBtnKat1').on('focus',function(){
        $('#minKat').val($('#menuCDep1Input').val());
        $('#maxKat').val($('#menuCDep1Input').val()).change();

        if($('#menuCDep1Input').val() == ''){
            $('#menuCDep1Input').focus();
        }
        else if($('#menuCDep2Input').val() == ''){
            $('#menuCDep2Input').focus();
        }
    });
    $('#menuCKat2Input, #menuCBtnKat2').on('focus',function(){
        $('#minKat').val($('#menuCDep2Input').val());
        $('#maxKat').val($('#menuCDep2Input').val()).change();

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

                $('#menuCBtnKat1').prop("hidden",false);
            }else{
                swal('', "Kode Departement tidak terdaftar", 'warning');
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

        }else{
            let index = checkKatExist($('#menuCKat1Input').val());
            if(index){
                $('#menuCKat1Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));
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
        }else{
            //code here
            let index = checkKatExist($('#menuCKat2Input').val());
            if(index){
                $('#menuCKat2Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));
            }else{
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                // $('#minKat').val('').change();
                $('#menuCKat2Input').val('').change();
            }
        }
    });

    $('#menuCPlu1Input').on('change',function(){
        // $('#menuCPlu2Input').val('').change();

        $('#menuCPlu1Desk').val('');
        // $('#menuCPlu2Desk').val('');
        if($('#menuCPlu1Input').val() == ''){
            // $('#menuCBtnPlu2').prop("hidden",true);
        }else{
            let deskripsi = checkPluExist($('#menuCPlu1Input').val());
            if(deskripsi != "false"){
                deskripsi = deskripsi.prd_deskripsipanjang;
                $('#menuCPlu1Desk').val(deskripsi);
                // $('#menuCBtnPlu2').prop("hidden",false);
            }else{
                swal('', "Kode Plu tidak terdaftar", 'warning');
                $('#menuCPlu1Input').val('').change();
            }
        }
    });
    $('#menuCPlu2Input').on('change',function(){
        $('#menuCPlu2Desk').val('');
        if($('#menuCPlu2Input').val() == ''){
            // code here
        }else{
            let deskripsi = checkPluExist($('#menuCPlu2Input').val());
            if(deskripsi != "false"){
                deskripsi = deskripsi.prd_deskripsipanjang;
                $('#menuCPlu2Desk').val(deskripsi);
            }else{
                swal('', "Kode Plu tidak terdaftar", 'warning');
                $('#menuCPlu2Input').val('').change();
            }
        }
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
                $('#menuCKat1Input').val(kode).change();
                setTimeout(function() {
                    $('#menuCKat1Input').focus();
                }, 10);
                break;
            case "Kat2":
                $('#menuCKat2Input').val(kode).change();
                setTimeout(function() {
                    $('#menuCKat2Input').focus();
                }, 10);
                break;
            case "Plu1":
                $('#menuCPlu1Input').val(kode).change();
                // $('#menuCDiv2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menuCPlu1Input').focus();
                }, 10);
                break;
            case "Plu2":
                $('#menuCPlu2Input').val(kode).change();
                // $('#menuCDiv2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menuCPlu2Input').focus();
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
        $('#menuCPlu1Input').val('').change();
        $('#menuCPlu2Input').val('').change();

        $('#menuCStatus').val(0);

        $('#filtererDep').val('').change();
        $('#filtererKat').val('').change();
    }

    function menuCCetak(){
        //DEP & KAT
        let temp = '';
        let dep1 = $('#menuCDep1Input').val();
        let dep2 = $('#menuCDep2Input').val();
        let kat1 = $('#menuCKat1Input').val();
        let kat2 = $('#menuCKat2Input').val();
        if(dep1 != '' || dep2 != ''){
            if(parseInt(dep1) > parseInt(dep2)){
                temp = dep1;
                dep1 = dep2;
                dep2 = temp;
                temp = kat1;
                kat1 = kat2;
                kat2 = temp;
            }
        }
        let plu1 = $('#menuCPlu1Input').val();
        let plu2 = $('#menuCPlu2Input').val();
        if(plu1 != '' || plu2 != ''){
            if(parseInt(plu1) > parseInt(plu2)){
                temp = plu1;
                plu1 = plu2;
                plu2 = temp;
            }
        }

        //status
        let status = $('#menuCStatus').val();

        //PRINT
        window.open(`{{ url()->current() }}/print-daftar-status-tag-bar?dep1=${dep1}&dep2=${dep2}&kat1=${kat1}&kat2=${kat2}&plu1=${plu1}&plu2=${plu2}&status=${status}`, '_blank');
    }
</script>
