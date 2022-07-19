{{--ASSET LIST MASTER--}}
{{-- DAFTAR ANGGOTA / MEMBER BARU --}}

<div>
    <fieldset class="card border-dark">
{{--        <legend class="w-auto ml-5">Daftar Anggota or Member Baru</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Tanggal')</label>
            <div class="col-sm-6 buttonInside">
                <input id="menu7daterangepicker" class="form-control" type="text">
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Mulai Kode')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu7Kod1Input" class="form-control" type="text">
                <button id="menu7BtnKod1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#memDateModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu7Kod1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Sampai Kode')</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu7Kod2Input" class="form-control" type="text">
                <button id="menu7BtnKod2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#memDateModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu7Kod2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Urut (SORT) Atas')</label>
            <div class="col-sm-6">
                <select class="form-control" id="menu7SortBy">
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
    $('#menu7daterangepicker').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY',
        }
    });
    $('#menu7daterangepicker').on('change',function(){
        let date = $('#menu7daterangepicker').val();
        if(date == null || date == ""){
            swal(`{{ __('Periode tidak boleh kosong') }}`,'','warning');
            return false;
        }
        let dateA = date.substr(0,10);
        let dateB = date.substr(13,10);
        dateA = dateA.split('/').join('-');
        dateB = dateB.split('/').join('-');

        //Re-Draw tableMemberDate
        tableMemberDate.destroy();
        //tableMemberDate = '';
        $('.modalMemberDate').remove();
        getModalMemberDate(dateA,dateB);
    });

    //Fungsi isi berurutan
    $('#menu7Kod2Input').on('focus',function(){
        if($('#menu7Kod1Input').val() == ''){
            $('#menu7Kod1Input').focus();
        }
    });

    $('#menu7Kod1Input').on('change',function(){
        $('#menu7Kod2Input').val('').change();

        $('#menu7Kod1Desk').val('');
        $('#menu7Kod2Desk').val('');
        if($('#menu7Kod1Input').val() == ''){
            $('#menu7BtnKod2').prop("hidden",true);

        }else{
            let index = checkMemWithDateExist($('#menu7Kod1Input').val());
            if(index){
                $('#menu7Kod1Desk').val(tableMemberDate.row(index-1).data()['cus_namamember'].replace(/&amp;/g, '&'));
                $('#menu7BtnKod2').prop("hidden",false);
            }else{
                swal('', `{{ __('Kode Member tidak terdaftar dalam rentang waktu yg dipilih') }}`, 'warning');
                $('#menu7Kod1Input').val('').change();
            }
        }
    });
    $('#menu7Kod2Input').on('change',function(){
        $('#menu7Kod2Desk').val('');
        if($('#menu7Kod2Input').val() == ''){
            $('#menu7BtnMem1').prop("hidden",true);

        }else{
            let index = checkMemWithDateExist($('#menu7Kod2Input').val());
            if(index){
                $('#menu7Kod2Desk').val(tableMemberDate.row(index-1).data()['cus_namamember'].replace(/&amp;/g, '&'));
            }else{
                swal('',`{{ __('Kode Member tidak terdaftar dalam rentang waktu yg dipilih') }}`, 'warning');
                $('#menu7Kod2Input').val('').change();
            }
        }
    });


    function menu7Choose(val){
        //val dan curson didapat dari "list-master.blade.php"
        let kode = val.children().first().next().text();
        let index = cursor.substr(8,4);
        switch (index){
            case "Kod1":
                $('#menu7Kod1Input').val(kode).change();
                setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                    $('#menu7Kod1Input').focus();
                }, 10);

                break;
            case "Kod2":
                $('#menu7Kod2Input').val(kode).change();
                setTimeout(function() {
                    $('#menu7Kod2Input').focus();
                }, 10);
                break;
        }
    }

    function menu7Clear(){
        $('#menu7Kod1Input').val('').change();

        let date = $('#menu7daterangepicker').val();
        let dateA = date.substr(0,10);
        let dateB = date.substr(13,10);
        if(dateA != moment().format('DD/MM/YYYY') && dateB != moment().format('DD/MM/YYYY')){
            $('#menu7daterangepicker').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
            $('#menu7daterangepicker').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));
        }

        $('#menu7SortBy').val(1);

    }
    function menu7Cetak(){
        //Date
        let date = $('#menu7daterangepicker').val();
        // if(date == null || date == ""){
        //     swal('Periode tidak boleh kosong','','warning');
        //     return false;
        // }
        let dateA = date.substr(0,10);
        let dateB = date.substr(13,10);
        dateA = dateA.split('/').join('-');
        dateB = dateB.split('/').join('-');
        let member1 = $('#menu7Kod1Input').val();
        let member2 = $('#menu7Kod2Input').val();

        if(member1 != '' && member2 != ''){
            if(member1 > member2){
                temp = member1;
                member1 = member2;
                member2 = temp;
            }
        }

        //sort value
        let sort = $('#menu7SortBy').val();

        //PRINT
        window.open(`{{ url()->current() }}/print-daftar-anggota-or-member-baru?member1=${member1}&member2=${member2}&date1=${dateA}&date2=${dateB}&sort=${sort}`, '_blank');
    }
</script>
