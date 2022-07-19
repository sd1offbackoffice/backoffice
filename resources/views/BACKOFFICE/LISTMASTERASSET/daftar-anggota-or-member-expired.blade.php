{{--ASSET LIST MASTER--}}
{{-- DAFTAR ANGGOTA/MEMBER EXPIRED --}}

<div>
    <fieldset class="card border-dark">
{{--        <legend class="w-auto ml-5">Daftar Produk</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Mulai Kode')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu9Mem1Input" class="form-control" type="text">
                <button id="menu9BtnMem1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#memModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu9Mem1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Sampai Kode')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu9Mem2Input" class="form-control" type="text">
                <button id="menu9BtnMem2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#memModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu9Mem2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Urut (SORT) Atas')</label>
            <div class="col-sm-6">
                <select class="form-control" id="menu9SortBy">
                    <option value="1">1. @lang('OUTLET+AREA+KODE')</option>
                    <option value="2">2. @lang('OUTLET+AREA+NAMA')</option>
                    <option value="3">3. @lang('OUTLET+KODE')</option>
                    <option value="4">4. @lang('OUTLET+NAMA')</option>
                    <option value="5">5. @lang('AREA+KODE')</option>
                    <option value="6">6. @lang('AREA+NAMA')</option>
                    <option value="7">7. {{ strtoupper(__('Kode')) }}</option>
                    <option value="8">8. {{ strtoupper(__('Nama')) }}</option>
                </select>
            </div>
        </div>

        <br>
    </fieldset>
</div>

<script>
    //Fungsi isi berurutan
    $('#menu9Mem2Input').on('focus',function(){
        if($('#menu9Mem1Input').val() == ''){
            $('#menu9Mem1Input').focus();
        }
    });

    $('#menu9Mem1Input').on('change',function(){
        $('#menu9Mem2Input').val('').change();

        $('#menu9Mem1Desk').val('');
        $('#menu9Mem2Desk').val('');
        if($('#menu9Mem1Input').val() == ''){
            $('#menu9BtnMem2').prop("hidden",true);
        }else{
            let deskripsi = checkMemExist($('#menu9Mem1Input').val());
            if(deskripsi != "false"){
                $('#menu9Mem1Desk').val(deskripsi);
                $('#menu9BtnMem2').prop("hidden",false);
            }else{
                swal('', `{{ __('Kode Member tidak terdaftar') }}`, 'warning');
                $('#menu9Mem1Input').val('').change();
            }
        }
    });
    $('#menu9Mem2Input').on('change',function(){
        $('#menu9Mem2Desk').val('');
        if($('#menu9Mem2Input').val() == ''){
            //code here
        }else{
            //code here
            let deskripsi = checkMemExist($('#menu9Mem2Input').val());
            if(deskripsi != "false"){
                $('#menu9Mem2Desk').val(deskripsi);
            }else{
                swal('', `{{ __('Kode Member tidak terdaftar') }}`, 'warning');
                $('#menu9Mem2Input').val('').change();
            }
        }
    });


    function menu9Choose(val){
        //val dan curson didapat dari "list-master.blade.php"
        let kode = val.children().first().next().text();
        let index = cursor.substr(8,4);
        switch (index){
            case "Mem1":
                $('#menu9Mem1Input').val(kode).change();
                setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                    $('#menu9Mem1Input').focus();
                }, 10);

                break;
            case "Mem2":
                $('#menu9Mem2Input').val(kode).change();
                setTimeout(function() {
                    $('#menu9Mem2Input').focus();
                }, 10);
                break;
        }
    }

    function menu9Clear(){
        $('#menu9Mem1Input').val('').change();
        $('#menu9SortBy').val(1);
    }
    function menu9Cetak(){
        let member1 = $('#menu9Mem1Input').val();
        let member2 = $('#menu9Mem2Input').val();
        if(member1 != '' && member2 != ''){
            if(member1 > member2){
                temp = member1;
                member1 = member2;
                member2 = temp;
            }
        }

        //sort value
        let sort = $('#menu8SortBy').val();

        //PRINT
        window.open(`{{ url()->current() }}/print-daftar-anggota-or-member-expired?member1=${member1}&member2=${member2}&sort=${sort}`, '_blank');
    }
</script>
