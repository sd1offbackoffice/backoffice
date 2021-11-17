{{--ASSET LIST MASTER--}}
{{-- DAFTAR ANGGOTA / MEMBER JATUH TEMPO --}}

<div>
    <fieldset class="card border-dark">
{{--        <legend class="w-auto ml-5">Daftar Produk</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Tanggal</label>
            <div class="col-sm-6 buttonInside">
                <input id="menu8daterangepicker" class="form-control" type="text">
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Kode</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu8Kod1Input" class="form-control" type="text">
                <button id="menu8BtnKod1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#memDateModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu8Kod1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Kode</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu8Kod2Input" class="form-control" type="text">
                <button id="menu8BtnKod2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#memDateModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu8Kod2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Urut (SORT) Atas</label>
            <div class="col-sm-6">
                <select class="form-control" id="menu8SortBy">
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
    $('#menu8daterangepicker').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY',
        }
    });
    $('#menu8daterangepicker').on('change',function(){
        let date = $('#menu8daterangepicker').val();
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
    $('#menu8Kod2Input').on('focus',function(){
        if($('#menu8Kod1Input').val() == ''){
            $('#menu8Kod1Input').focus();
        }
    });

    $('#menu8Kod1Input').on('change',function(){
        $('#menu8Kod2Input').val('').change();

        $('#menu8Kod1Desk').val('');
        $('#menu8Kod2Desk').val('');
        if($('#menu8Kod1Input').val() == ''){
            $('#menu8BtnKod2').prop("hidden",true);

        }else{
            let index = checkMemWithDateExist($('#menu8Kod1Input').val());
            if(index){
                $('#menu8Kod1Desk').val(tableMemberDate.row(index-1).data()['cus_namamember'].replace(/&amp;/g, '&'));
                $('#menu8BtnKod2').prop("hidden",false);
            }else{
                swal('', "Kode Member tidak terdaftar dalam rentang waktu yg dipilih", 'warning');
                $('#menu8Kod1Input').val('').change();
            }
        }
    });
    $('#menu8Kod2Input').on('change',function(){
        $('#menu8Kod2Desk').val('');
        if($('#menu8Kod2Input').val() == ''){
            $('#menu8BtnMem1').prop("hidden",true);

        }else{
            let index = checkMemWithDateExist($('#menu8Kod2Input').val());
            if(index){
                $('#menu8Kod2Desk').val(tableMemberDate.row(index-1).data()['cus_namamember'].replace(/&amp;/g, '&'));
            }else{
                swal('', "Kode Member tidak terdaftar dalam rentang waktu yg dipilih", 'warning');
                $('#menu8Kod2Input').val('').change();
            }
        }
    });


    function menu8Choose(val){
        //val dan curson didapat dari "list-master.blade.php"
        let kode = val.children().first().next().text();
        let index = cursor.substr(8,4);
        switch (index){
            case "Kod1":
                $('#menu8Kod1Input').val(kode).change();
                setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                    $('#menu8Kod1Input').focus();
                }, 10);

                break;
            case "Kod2":
                $('#menu8Kod2Input').val(kode).change();
                setTimeout(function() {
                    $('#menu8Kod2Input').focus();
                }, 10);
                break;
        }
    }

    function menu8Clear(){
        $('#menu8Kod1Input').val('').change();

        let date = $('#menu8daterangepicker').val();
        let dateA = date.substr(0,10);
        let dateB = date.substr(13,10);
        if(dateA != moment().format('DD/MM/YYYY') && dateB != moment().format('DD/MM/YYYY')){
            $('#menu8daterangepicker').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
            $('#menu8daterangepicker').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));
        }

        $('#menu8SortBy').val(1);

    }
    function menu8Cetak(){
        alert('cetak menu 8');
    }
</script>
