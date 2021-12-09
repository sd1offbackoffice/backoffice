{{--ASSET LIST MASTER--}}
{{-- DAFTAR PERPANJANGAN ANGGOTA / MEMBER --}}

<div>
    <fieldset class="card border-dark">
{{--        <legend class="w-auto ml-5">Daftar Perpanjangan Anggota / Member</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Tanggal</label>
            <div class="col-sm-6 buttonInside">
                <input id="menuBdaterangepicker" class="form-control" type="text">
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Kode</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuBKod1Input" class="form-control" type="text">
                <button id="menuBBtnKod1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#memDateModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuBKod1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Kode</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuBKod2Input" class="form-control" type="text">
                <button id="menuBBtnKod2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#memDateModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menuBKod2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Urut (SORT) Atas</label>
            <div class="col-sm-6">
                <select class="form-control" id="menuBSortBy">
                    <option value="1">1. OUTLET+AREA+KODE</option>
                    <option value="2">2. OUTLET+AREA+NAMA</option>
                    <option value="3">3. OUTLET+KODE</option>
                    <option value="4">4. OUTLET+NAMA</option>
                    <option value="5">5. AREA+KODE</option>
                    <option value="6">6. AREA+NAMA</option>
                    <option value="7">7. KODE</option>
                    <option value="8">8. NAMA</option>
                </select>
            </div>
        </div>
        <br>
    </fieldset>
</div>

<script>
    $('#menuBdaterangepicker').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY',
        }
    });
    $('#menuBdaterangepicker').on('change',function(){
        let date = $('#menuBdaterangepicker').val();
        if(date == null || date == ""){
            swal('Periode tidak boleh kosong','','warning');
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
    $('#menuBKod2Input').on('focus',function(){
        if($('#menuBKod1Input').val() == ''){
            $('#menuBKod1Input').focus();
        }
    });

    $('#menuBKod1Input').on('change',function(){
        $('#menuBKod2Input').val('').change();

        $('#menuBKod1Desk').val('');
        $('#menuBKod2Desk').val('');
        if($('#menuBKod1Input').val() == ''){
            $('#menuBBtnKod2').prop("hidden",true);

        }else{
            let index = checkMemWithDateExist($('#menuBKod1Input').val());
            if(index){
                $('#menuBKod1Desk').val(tableMemberDate.row(index-1).data()['cus_namamember'].replace(/&amp;/g, '&'));
                $('#menuBBtnKod2').prop("hidden",false);
            }else{
                swal('', "Kode Member tidak terdaftar dalam rentang waktu yg dipilih", 'warning');
                $('#menuBKod1Input').val('').change();
            }
        }
    });
    $('#menuBKod2Input').on('change',function(){
        $('#menuBKod2Desk').val('');
        if($('#menuBKod2Input').val() == ''){
            $('#menuBBtnMem1').prop("hidden",true);

        }else{
            let index = checkMemWithDateExist($('#menuBKod2Input').val());
            if(index){
                $('#menuBKod2Desk').val(tableMemberDate.row(index-1).data()['cus_namamember'].replace(/&amp;/g, '&'));
            }else{
                swal('', "Kode Member tidak terdaftar dalam rentang waktu yg dipilih", 'warning');
                $('#menuBKod2Input').val('').change();
            }
        }
    });


    function menuBChoose(val){
        //val dan curson didapat dari "list-master.blade.php"
        let kode = val.children().first().next().text();
        let index = cursor.substr(8,4);
        switch (index){
            case "Kod1":
                $('#menuBKod1Input').val(kode).change();
                setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                    $('#menuBKod1Input').focus();
                }, 10);

                break;
            case "Kod2":
                $('#menuBKod2Input').val(kode).change();
                setTimeout(function() {
                    $('#menuBKod2Input').focus();
                }, 10);
                break;
        }
    }

    function menuBClear(){
        $('#menuBKod1Input').val('').change();

        let date = $('#menuBdaterangepicker').val();
        let dateA = date.substr(0,10);
        let dateB = date.substr(13,10);
        if(dateA != moment().format('DD/MM/YYYY') && dateB != moment().format('DD/MM/YYYY')){
            $('#menuBdaterangepicker').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
            $('#menuBdaterangepicker').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));
        }

        $('#menuBSortBy').val(1);

    }
    function menuBCetak(){
        //Date
        let date = $('#menuBdaterangepicker').val();
        // if(date == null || date == ""){
        //     swal('Periode tidak boleh kosong','','warning');
        //     return false;
        // }
        let dateA = date.substr(0,10);
        let dateB = date.substr(13,10);
        dateA = dateA.split('/').join('-');
        dateB = dateB.split('/').join('-');
        let member1 = $('#menuBKod1Input').val();
        let member2 = $('#menuBKod2Input').val();

        if(member1 != '' || member2 != ''){
            if(member1 > member2){
                temp = member1;
                member1 = member2;
                member2 = temp;
            }
        }

        //sort value
        let sort = $('#menuBSortBy').val();

        //PRINT
        window.open(`{{ url()->current() }}/print-daftar-perpanjangan-anggota-or-member?member1=${member1}&member2=${member2}&date1=${dateA}&date2=${dateB}&sort=${sort}`, '_blank');
    }
</script>
