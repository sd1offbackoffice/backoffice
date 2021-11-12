{{--ASSET LIST MASTER--}}
{{-- DAFTAR SUPPLIER --}}

<div>
    <fieldset class="card border-dark">
{{--        <legend class="w-auto ml-5">Daftar Produk</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Kode</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu4Sup1Input" class="form-control" type="text">
                <button id="menu4BtnSup1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#supModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu4Sup1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Kode</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu4Sup2Input" class="form-control" type="text">
                <button id="menu4BtnSup2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#supModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu4Sup2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <br>
    </fieldset>
</div>

<script>
    //Fungsi isi berurutan
    $('#menu4Sup2Input').on('focus',function(){
        if($('#menu4Sup1Input').val() == ''){
            $('#menu4Sup1Input').focus();
        }
    });

    $('#menu4Sup1Input').on('change',function(){
        $('#menu4Sup2Input').val('').change();

        $('#menu4Sup1Desk').val('');
        $('#menu4Sup2Desk').val('');
        if($('#menu4Sup1Input').val() == ''){
            $('#menu4BtnSup2').prop("hidden",true);

        }else{
            let index = checkSupExist($('#menu4Sup1Input').val());
            if(index){
                $('#menu4Sup1Desk').val(tableSupplier.row(index-1).data()['sup_namasupplier'].replace(/&amp;/g, '&'));
                $('#menu4BtnSup2').prop("hidden",false);
            }else{
                swal('', "Kode Supplier tidak terdaftar", 'warning');
                $('#menu4Sup1Input').val('').change();
            }
        }
    });
    $('#menu4Sup2Input').on('change',function(){
        $('#menu4Sup2Desk').val('');
        if($('#menu4Sup2Input').val() == ''){
            //code here
        }else{
            //code here
            let index = checkSupExist($('#menu4Sup2Input').val());
            if(index){
                $('#menu4Sup2Desk').val(tableSupplier.row(index-1).data()['sup_namasupplier'].replace(/&amp;/g, '&'));
            }else{
                swal('', "Kode Supplier tidak terdaftar", 'warning');
                $('#menu4Sup2Input').val('').change();
            }
        }
    });


    function menu4Choose(val){
        //val dan curson didapat dari "list-master.blade.php"
        let kode = val.children().first().next().text();
        let index = cursor.substr(8,4);
        switch (index){
            case "Sup1":
                $('#menu4Sup1Input').val(kode).change();
                setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                    $('#menu4Sup1Input').focus();
                }, 10);

                break;
            case "Sup2":
                $('#menu4Sup2Input').val(kode).change();
                setTimeout(function() {
                    $('#menu4Sup2Input').focus();
                }, 10);
                break;
        }
    }

    function menu4Clear(){
        $('#menu4 input').val('').change();
    }
    function menu4Cetak(){
        alert('cetak menu 4');
    }
</script>
