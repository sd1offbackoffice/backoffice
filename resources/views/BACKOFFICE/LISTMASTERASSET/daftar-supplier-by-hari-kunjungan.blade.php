{{--ASSET LIST MASTER--}}
{{-- DAFTAR SUPPLIER BY HARI KUNJUNGAN --}}

<div>
    <fieldset class="card border-dark">
{{--        <legend class="w-auto ml-5">Daftar Supplier by Hari Kunjungan</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Mulai Kode')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuGSup1Input" class="form-control" type="text">
                <button id="menuGBtnSup1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#supModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuGSup1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Sampai Kode')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuGSup2Input" class="form-control" type="text">
                <button id="menuGBtnSup2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#supModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuGSup2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <br>
        <div class="row">
            {{--minggu--}}
            <label class="col-sm-3 text-right col-form-label">@lang('Hari')</label>
            <div class="col-sm-1">
                <input id="menuGCheckMinggu" class="form-control" type="checkbox">
            </div>
            <label class="col-sm-2 text-left col-form-label">@lang('Minggu')</label>
            {{--senin--}}
            <div class="col-sm-1">
                <input id="menuGCheckSenin" class="form-control" type="checkbox">
            </div>
            <label class="col-sm-2 text-left col-form-label">@lang('Senin')</label>
            {{--selasa--}}
            <div class="col-sm-1">
                <input id="menuGCheckSelasa" class="form-control" type="checkbox">
            </div>
            <label class="col-sm-2 text-left col-form-label">@lang('Selasa')</label>
        </div>
        <div class="row">
            {{--rabu--}}
            <label class="col-sm-3 text-right col-form-label">&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <div class="col-sm-1">
                <input id="menuGCheckRabu" class="form-control" type="checkbox">
            </div>
            <label class="col-sm-2 text-left col-form-label">@lang('Rabu')</label>
            {{--kamis--}}
            <div class="col-sm-1">
                <input id="menuGCheckKamis" class="form-control" type="checkbox">
            </div>
            <label class="col-sm-2 text-left col-form-label">@lang('Kamis')</label>
            {{--jumat--}}
            <div class="col-sm-1">
                <input id="menuGCheckJumat" class="form-control" type="checkbox">
            </div>
            <label class="col-sm-2 text-left col-form-label">@lang('Jumat')</label>
        </div>
        <div class="row">
            {{--rabu--}}
            <label class="col-sm-3 text-right col-form-label">&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <div class="col-sm-1">
                <input id="menuGCheckSabtu" class="form-control" type="checkbox">
            </div>
            <label class="col-sm-2 text-left col-form-label">@lang('Sabtu')</label>
        </div>
    </fieldset>
</div>

<script>
    //Fungsi isi berurutan
    $('#menuGSup2Input').on('focus',function(){
        if($('#menuGSup1Input').val() == ''){
            $('#menuGSup1Input').focus();
        }
    });

    $('#menuGSup1Input').on('change',function(){
        $('#menuGSup2Input').val('').change();

        $('#menuGSup1Desk').val('');
        $('#menuGSup2Desk').val('');
        if($('#menuGSup1Input').val() == ''){
            $('#menuGBtnSup2').prop("hidden",true);

        }else{
            let index = checkSupExist($('#menuGSup1Input').val());
            if(index){
                $('#menuGSup1Desk').val(tableSupplier.row(index-1).data()['sup_namasupplier'].replace(/&amp;/g, '&'));
                $('#menuGBtnSup2').prop("hidden",false);
            }else{
                swal('',`{{ __('Kode Supplier tidak terdaftar') }}`, 'warning');
                $('#menuGSup1Input').val('').change();
            }
        }
    });
    $('#menuGSup2Input').on('change',function(){
        $('#menuGSup2Desk').val('');
        if($('#menuGSup2Input').val() == ''){
            //code here
        }else{
            //code here
            let index = checkSupExist($('#menuGSup2Input').val());
            if(index){
                $('#menuGSup2Desk').val(tableSupplier.row(index-1).data()['sup_namasupplier'].replace(/&amp;/g, '&'));
            }else{
                swal('',`{{ __('Kode Supplier tidak terdaftar') }}`, 'warning');
                $('#menuGSup2Input').val('').change();
            }
        }
    });


    function menuGChoose(val){
        //val dan curson didapat dari "list-master.blade.php"
        let kode = val.children().first().next().text();
        let index = cursor.substr(8,4);
        switch (index){
            case "Sup1":
                $('#menuGSup1Input').val(kode).change();
                setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                    $('#menuGSup1Input').focus();
                }, 10);

                break;
            case "Sup2":
                $('#menuGSup2Input').val(kode).change();
                setTimeout(function() {
                    $('#menuGSup2Input').focus();
                }, 10);
                break;
        }
    }

    function menuGClear(){
        $('#menuG input').val('').change();
    }
    function menuGCetak(){
        let sup1 = $('#menuGSup1Input').val();
        let sup2 = $('#menuGSup2Input').val();
        let phari = "";
        if(sup1 != '' && sup2 != ''){
            if(sup1 > sup2){
                temp = sup1;
                sup1 = sup2;
                sup2 = temp;
            }
        }

        if($('#menuGCheckMinggu').prop("checked")){
            phari = "'MINGGU',";
        }
        if($('#menuGCheckSenin').prop("checked")){
            phari = phari+"'SENIN',";
        }
        if($('#menuGCheckSelasa').prop("checked")){
            phari = phari+"'SELASA',";
        }
        if($('#menuGCheckRabu').prop("checked")){
            phari = phari+"'RABU',";
        }
        if($('#menuGCheckKamis').prop("checked")){
            phari = phari+"'KAMIS',";
        }
        if($('#menuGCheckJumat').prop("checked")){
            phari = phari+"'JUMAT',";
        }
        if($('#menuGCheckSabtu').prop("checked")){
            phari = phari+"'SABTU',";
        }

        if(phari.slice(-1) == ","){
            phari = phari.slice(0, -1);
            //phari = phari.substring(0, phari.length - 1);
        }

        //PRINT
        window.open(`{{ url()->current() }}/print-daftar-supplier-by-hari-kunjungan?sup1=${sup1}&sup2=${sup2}&phari=${phari}`, '_blank');
    }
</script>
