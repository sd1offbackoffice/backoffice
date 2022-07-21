{{--ASSET LIST MASTER--}}
{{-- DAFTAR SUPPLIER --}}

<div>
    <fieldset class="card border-dark">
{{--        <legend class="w-auto ml-5">Daftar Supplier</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">@lang('Mulai Kode')</label>
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
            <label class="col-sm-3 text-right col-form-label">@lang('Sampai Kode')</label>
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
    $('#menu4Sup1Input, #menu4BtnSup1').on('focus',function(){
        $('#minSup').val('').change();
    });
    $('#menu4Sup2Input, #menu4BtnSup2').on('focus',function(){
        if($('#menu4Sup1Input').val() == ''){
            $('#menu4Sup1Input').focus();
        }else{
            $('#minSup').val($('#menu4Sup1Input').val()).change();
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
                swal('', `{{ __('Kode Supplier tidak terdaftar') }}`, 'warning');
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
                swal('',`{{ __('Kode Supplier tidak terdaftar') }}`, 'warning');
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
        $('#minSup').val('').change();
    }
    function menu4Cetak(){
        let sup1 = $('#menu4Sup1Input').val();
        let sup2 = $('#menu4Sup2Input').val();
        if(sup1 != ''){
            if(checkSupExist(sup1) == false){
                swal('',`{{ __('Kode Supplier tidak terdaftar') }}`, 'warning');
                return false;
            }
        }
        if(sup2 != ''){
            if(checkSupExist(sup2) == false){
                swal('', `{{ __('Kode Supplier tidak terdaftar') }}`, 'warning');
                return false;
            }
        }
        if(sup1 != '' && sup2 != ''){
            if(sup1 > sup2){
                // temp = sup1;
                // sup1 = sup2;
                // sup2 = temp;
                swal('', `{{ __('Range Supplier Salah') }}`, 'warning');
                return false;
            }
        }
        //PRINT
        window.open(`{{ url()->current() }}/print-daftar-supplier?sup1=${sup1}&sup2=${sup2}`, '_blank');
    }
</script>
