{{--ASSET LIST MASTER--}}
{{-- DAFTAR ANGGOTA / TYPE OUTLET --}}

<div>
    <fieldset class="card border-dark">
{{--        <legend class="w-auto ml-5">Daftar Produk</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Mulai Outlet')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu6Out1Input" class="form-control" type="text">
                <button id="menu6BtnOut1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#outletModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu6Out1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Sampai Outlet')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu6Out2Input" class="form-control" type="text">
                <button id="menu6BtnOut2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#outletModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu6Out2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Mulai Member')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu6Mem1Input" class="form-control" type="text">
                <button id="menu6BtnMem1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#memModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu6Mem1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Sampai Member')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu6Mem2Input" class="form-control" type="text">
                <button id="menu6BtnMem2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#memModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu6Mem2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <br>
    </fieldset>
</div>

<script>
    //Fungsi isi berurutan
    $('#menu6Out2Input').on('focus',function(){
        if($('#menu6Out1Input').val() == ''){
            $('#menu6Out1Input').focus();
        }
    });
    $('#menu6Mem1Input').on('focus',function(){
        if($('#menu6Out1Input').val() == ''){
            $('#menu6Out1Input').focus();
        }else if($('#menu6Out2Input').val() == ''){
            $('#menu6Out2Input').focus();
        }
    });
    $('#menu6Mem2Input').on('focus',function(){
        if($('#menu6Out1Input').val() == ''){
            $('#menu6Out1Input').focus();
        }else if($('#menu6Out2Input').val() == ''){
            $('#menu6Out2Input').focus();
        }else if($('#menu6Mem1Input').val() == ''){
            $('#menu6Mem1Input').focus();
        }
    });

    $('#menu6Out1Input').on('change',function(){
        $('#menu6Out2Input').val('').change();
        $('#menu6Mem1Input').val('').change();
        $('#menu6Mem2Input').val('').change();

        $('#menu6Out1Desk').val('');
        $('#menu6Out2Desk').val('');
        $('#menu6Mem1Desk').val('');
        $('#menu6Mem2Desk').val('');
        if($('#menu6Out1Input').val() == ''){
            $('#menu6BtnOut2').prop("hidden",true);

        }else{
            let index = checkOutletExist($('#menu6Out1Input').val());
            if(index){
                $('#menu6Out1Desk').val(tableOutlet.row(index-1).data()['out_namaoutlet'].replace(/&amp;/g, '&'));
                $('#menu6BtnOut2').prop("hidden",false);
            }else{
                swal('', `{{ __('Kode Outlet tidak terdaftar') }}`, 'warning');
                $('#menu6Out1Input').val('').change();
            }
        }
    });
    $('#menu6Out2Input').on('change',function(){
        $('#menu6Mem1Input').val('').change();
        $('#menu6Mem2Input').val('').change();

        $('#menu6Out2Desk').val('');
        $('#menu6Mem1Desk').val('');
        $('#menu6Mem2Desk').val('');
        if($('#menu6Out2Input').val() == ''){
            $('#menu6BtnMem1').prop("hidden",true);

        }else{
            let index = checkOutletExist($('#menu6Out2Input').val());
            if(index){
                $('#menu6Out2Desk').val(tableOutlet.row(index-1).data()['out_namaoutlet'].replace(/&amp;/g, '&'));
                $('#menu6BtnMem1').prop("hidden",false);
            }else{
                swal('', `{{ __('Kode Outlet tidak terdaftar') }}`, 'warning');
                $('#menu6Out2Input').val('').change();
            }
        }
    });
    $('#menu6Mem1Input').on('change',function(){
        $('#menu6Mem2Input').val('').change();

        $('#menu6Mem1Desk').val('');
        $('#menu6Mem2Desk').val('');
        if($('#menu6Mem1Input').val() == ''){
            $('#menu6BtnMem2').prop("hidden",true);

        }else{
            let deskripsi = checkMemExist($('#menu6Mem1Input').val());
            if(deskripsi != "false"){
                $('#menu6Mem1Desk').val(deskripsi);
                $('#menu6BtnMem2').prop("hidden",false);
            }else{
                swal('', `{{ __('Kode Member tidak terdaftar') }}`, 'warning');
                $('#menu6Mem1Input').val('').change();
            }
        }
    });

    $('#menu6Mem2Input').on('change',function(){
        $('#menu6Mem2Desk').val('');
        if($('#menu6Mem2Input').val() == ''){
            $('#menu6BtnMem2').prop("hidden",true);

        }else{
            let deskripsi = checkMemExist($('#menu6Mem2Input').val());
            if(deskripsi != "false"){
                $('#menu6Mem2Desk').val(deskripsi);
            }else{
                swal('',`{{ __('Kode Member tidak terdaftar') }}`, 'warning');
                $('#menu6Mem2Input').val('');
            }
        }
    });


    function menu6Choose(val){
        //val dan curson didapat dari "list-master.blade.php"
        let kode = val.children().first().next().text();
        let index = cursor.substr(8,4);
        switch (index){
            case "Out1":
                $('#menu6Out1Input').val(kode).change();
                setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                    $('#menu6Out1Input').focus();
                }, 10);

                break;
            case "Out2":
                $('#menu6Out2Input').val(kode).change();
                setTimeout(function() {
                    $('#menu6Out2Input').focus();
                }, 10);
                break;
            case "Mem1":
                $('#menu6Mem1Input').val(kode).change();
                setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                    $('#menu6Mem1Input').focus();
                }, 10);

                break;
            case "Mem2":
                $('#menu6Mem2Input').val(kode).change();
                setTimeout(function() {
                    $('#menu6Mem2Input').focus();
                }, 10);
                break;
        }
    }

    function menu6Clear(){
        $('#menu6 input').val('').change();
    }
    function menu6Cetak(){
        //DECLARE VARIABLE
        let outlet1 = $('#menu6Out1Input').val();
        let outlet2 = $('#menu6Out2Input').val();
        let member1 = $('#menu6Mem1Input').val();
        let member2 = $('#menu6Mem2Input').val();

        //CHECK DATA
        if(outlet1 != '' && outlet2 != ''){
            if(outlet1 > outlet2){
                temp = outlet1;
                outlet1 = outlet2;
                outlet2 = temp;
            }
        }
        if(member1 != '' && member2 != ''){
            if(member1 > member2){
                temp = member1;
                member1 = member2;
                member2 = temp;
            }
        }

        //PRINT
        window.open(`{{ url()->current() }}/print-daftar-anggota-or-type-outlet?outlet1=${outlet1}&outlet2=${outlet2}&member1=${member1}&member2=${member2}`, '_blank');
    }
</script>
