{{--ASSET LIST MASTER--}}
{{-- DAFTAR ANGGOTA/MEMBER --}}

<div>
    <fieldset class="card border-dark">
{{--        <legend class="w-auto ml-5">Daftar Produk</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Mulai Kode')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu5Mem1Input" class="form-control" type="text">
                <button id="menu5BtnMem1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#memModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu5Mem1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Sampai Kode')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu5Mem2Input" class="form-control" type="text">
                <button id="menu5BtnMem2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#memModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu5Mem2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Pilihan')</label>
            <div class="col-sm-6">
                <select class="form-control" id="menu5Pilihan">
                    <option value="1">{{ strtoupper(__('Semua')) }}</option>
                    <option value="2">{{ strtoupper(__('Aktif')) }}</option>
                    <option value="3">{{ strtoupper(__('Tidak Aktif')) }}</option>
                </select>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Outlet')</label>
            <div class="col-sm-2 buttonInside">
                <input id="menu5OutlInput" class="form-control" type="text">
                <button id="menu5BtnOutl" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#outletModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-3">
                <input id="menu5OutlDesk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Sub Outlet')</label>
            <div class="col-sm-2 buttonInside">
                <input id="menu5SOu1Input" class="form-control" type="text">
                <button id="menu5BtnSOu1" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#subOutletModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <label class="col-sm-1 text-center col-form-label">@lang('s/d')</label>
            <div class="col-sm-2 buttonInside">
                <input id="menu5SOu2Input" class="form-control" type="text">
                <button id="menu5BtnSOu2" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#subOutletModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Urut (SORT) Atas')</label>
            <div class="col-sm-6">
                <select class="form-control" id="menu5SortBy">
                    <option value="1">1. @lang('OUTLET+AREA+KODE')</option>
                    <option value="2">2. @lang('OUTLET+AREA+NAMA')</option>
                    <option value="3">3. @lang('OUTLET+KODE')</option>
                    <option value="4">4. @lang('OUTLET+NAMA')</option>
                    <option value="5">5. @lang('AREA+KODE')</option>
                    <option value="6">6. @lang('AREA+NAMA')</option>
                    <option value="7">7. {{ strtoupper(__('Kode')) }}</option>
                    <option value="8">8. {{ strtoupper(__('Nama')) }}</option>
                    <option value="9">9. @lang('BLOCKING PENGIRIMAN')</option>
                </select>
            </div>
        </div>

        <br>
        <div class="d-flex justify-content-start">
            <label class="font-weight-bold">&nbsp;&nbsp;@lang('SUB OUTLET KOSONG = SEMUA')</label>
        </div>
    </fieldset>
</div>

<script>
    //Fungsi isi berurutan
    $('#menu5BtnMem1').on('focus',function(){
        $('#minMem').val('');
        //2 line dibawah bisa ditemukan di list-master.blade.php
        tableMember.destroy();
        getModalMember('');
    });
    $('#menu5BtnMem2').on('focus',function(){
        $('#minMem').val($('#menu5Mem1Input').val());
        tableMember.destroy();
        getModalMember('');
    });
    $('#menu5Mem2Input').on('focus',function(){
        if($('#menu5Mem1Input').val() == ''){
            $('#menu5Mem1Input').focus();
        }
    });

    $('#menu5Mem1Input').on('change',function(){
        $('#menu5Mem2Input').val('').change();

        $('#menu5Mem1Desk').val('');
        $('#menu5Mem2Desk').val('');
        if($('#menu5Mem1Input').val() == ''){
            $('#menu5BtnMem2').prop("hidden",true);
        }else{
            let deskripsi = checkMemExist($('#menu5Mem1Input').val());
            if(deskripsi != "false"){
                $('#menu5Mem1Desk').val(deskripsi);
                $('#menu5BtnMem2').prop("hidden",false);
            }else{
                swal('', `{{ __('Kode Member tidak terdaftar') }}`, 'warning');
                $('#menu5Mem1Input').val('').change();
            }
        }
    });
    $('#menu5Mem2Input').on('change',function(){
        $('#menu5Mem2Desk').val('');
        if($('#menu5Mem2Input').val() == ''){
            //code here
        }else{
            //code here
            let deskripsi = checkMemExist($('#menu5Mem2Input').val());
            if(deskripsi != "false"){
                $('#menu5Mem2Desk').val(deskripsi);
            }else{
                swal('', `{{ __('Kode Member tidak terdaftar') }}`, 'warning');
                $('#menu5Mem2Input').val('').change();
            }
        }
    });

    //Fungsi isi outlet berurutan
    $('#menu5SOu1Input, #menu5BtnSOu1').on('focus',function(){
        if($('#menu5OutlInput').val() == ''){
            $('#menu5OutlInput').focus();
        }else{
            $('#minSubOutlet').val('').change();
        }
    });
    $('#menu5SOu2Input, #menu5BtnSOu2').on('focus',function(){
        if($('#menu5OutlInput').val() == ''){
            $('#menu5OutlInput').focus();
        }else if($('#menu5SOu1Input').val() == ''){
            $('#menu5SOu1Input').focus();
        }else{
            $('#minSubOutlet').val($('#menu5SOu1Input').val()).change();
        }
    });

    $('#menu5OutlInput').on('change',function(){
        $('#menu5SOu1Input').val('').change();
        $('#menu5SOu2Input').val('').change();

        $('#menu5OutlDesk').val('');
        if($('#menu5OutlInput').val() == ''){
            $('#menu5BtnSOu1').prop("hidden",true);
        }else{
            let index = checkOutletExist($('#menu5OutlInput').val());
            if(index){
                $('#menu5OutlDesk').val(tableOutlet.row(index-1).data()['out_namaoutlet'].replace(/&amp;/g, '&'));
                $('#outletFilterer').val($('#menu5OutlInput').val()).change();
                $('#menu5BtnSOu1').prop("hidden",false);
            }else{
                swal('',`{{ __('Kode Outlet tidak terdaftar') }}`, 'warning');
                $('#menu5OutlInput').val('').change();
            }
        }
    });

    $('#menu5SOu1Input').on('change',function(){
        $('#menu5SOu2Input').val('').change();
        if($('#menu5SOu1Input').val() == ''){
            $('#menu5BtnSOu2').prop("hidden",true);
        }else{
            let index = checkSubOutletExist($('#menu5SOu1Input').val());
            if(index){
                // $('#menu5OutlDesk').val(deskripsi);
                $('#menu5BtnSOu2').prop("hidden",false);
            }else{
                swal('', `{{ __('Kode Sub-Outlet tidak terdaftar') }}`, 'warning');
                $('#menu5SOu1Input').val('').change();
            }
        }
    });
    $('#menu5SOu2Input').on('change',function(){
        if($('#menu5SOu2Input').val() == ''){
            //code here
        }else{
            let index = checkSubOutletExist($('#menu5SOu2Input').val());
            if(index){
                //code here
            }else{
                swal('',`{{ __('Kode Sub-Outlet tidak terdaftar') }}`, 'warning');
                $('#menu5SOu2Input').val('');
            }
        }
    });


    function menu5Choose(val){
        //val dan curson didapat dari "list-master.blade.php"
        let kode = val.children().first().next().text();
        let index = cursor.substr(8,4);
        switch (index){
            case "Mem1":
                $('#menu5Mem1Input').val(kode).change();
                setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                    $('#menu5Mem1Input').focus();
                }, 10);

                break;
            case "Mem2":
                $('#menu5Mem2Input').val(kode).change();
                setTimeout(function() {
                    $('#menu5Mem2Input').focus();
                }, 10);
                break;
            case "Outl":
                $('#menu5OutlInput').val(kode).change();
                setTimeout(function() {
                    $('#menu5OutlInput').focus();
                }, 10);
                break;
            case "SOu1":
                $('#menu5SOu1Input').val(kode).change();
                setTimeout(function() {
                    $('#menu5SOu1Input').focus();
                }, 10);
                break;
            case "SOu2":
                $('#menu5SOu2Input').val(kode);
                setTimeout(function() {
                    $('#menu5SOu2Input').focus();
                }, 10);
                break;
        }
    }

    function menu5Clear(){
        $('#menu5Mem1Input').val('').change();
        $('#menu5OutlInput').val('').change();
        $('#menu5Pilihan').val(1);
        $('#menu5SortBy').val(1);
    }
    function menu5Cetak(){
        //DECLARE VARIABLE
        let mem1 = $('#menu5Mem1Input').val();
        let mem2 = $('#menu5Mem2Input').val();
        let pilihan = $('#menu5Pilihan').val();
        let outlet = $('#menu5OutlInput').val();
        let subOutlet1 = $('#menu5SOu1Input').val();
        let subOutlet2 = $('#menu5SOu2Input').val();
        let sort = $('#menu5SortBy').val();

        // //CHECK DATA
        // if(mem1 != '' && mem2 != ''){
        //     if(mem1 > mem2){
        //         temp = mem1;
        //         mem1 = mem2;
        //         mem2 = temp;
        //     }
        // }

        if(outlet == ''){
            swal('',`{{ __('Silahkan Isi Kode Outlet Terlebih Dahulu') }}`, 'warning');
            return false;
        }

        // if(subOutlet1 != '' && subOutlet2 != ''){
        //     if(subOutlet1 > subOutlet2){
        //         temp = subOutlet1;
        //         subOutlet1 = subOutlet2;
        //         subOutlet2 = temp;
        //     }
        // }

        //PRINT
        window.open(`{{ url()->current() }}/print-daftar-anggota-or-member?mem1=${mem1}&mem2=${mem2}&pilihan=${pilihan}&outlet=${outlet}&suboutlet1=${subOutlet1}&suboutlet2=${subOutlet2}&sort=${sort}`, '_blank');
    }
</script>
