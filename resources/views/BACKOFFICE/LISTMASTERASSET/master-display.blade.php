{{--ASSET LIST MASTER--}}
{{-- MASTER DISPLAY --}}

<div>
    <fieldset class="card border-dark">
        {{--        <legend class="w-auto ml-5">Master Display</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Kode Rak</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuDRak1Input" class="form-control" type="text">
                <button id="menuDBtnRak1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#rakModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <label class="col-sm-2 text-center col-form-label">s/d</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuDRak2Input" class="form-control" type="text">
                <button id="menuDBtnRak2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#rakModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Kode Sub Rak</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuDSubRak1Input" class="form-control" type="text">
                <button id="menuDBtnSubRak1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#rakModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <label class="col-sm-2 text-center col-form-label">s/d</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuDSubRak2Input" class="form-control" type="text">
                <button id="menuDBtnSubRak2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#rakModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Tipe Rak</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuDTipeRak1Input" class="form-control" type="text">
                <button id="menuDBtnTipeRak1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#rakModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <label class="col-sm-2 text-center col-form-label">s/d</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuDTipeRak2Input" class="form-control" type="text">
                <button id="menuDBtnTipeRak2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#rakModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Shelving</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuDShelving1Input" class="form-control" type="text">
                <button id="menuDBtnShelving1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#rakModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <label class="col-sm-2 text-center col-form-label">s/d</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuDShelving2Input" class="form-control" type="text">
                <button id="menuDBtnShelving2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#rakModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
        </div>
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Hanya Item OMI</label>
            <div class="col-sm-1">
                <input id="menuDCheck" class="form-control" type="checkbox">
            </div>
        </div>
        <br>
    </fieldset>
</div>

<script>
    //####### DARI #######
    $('#menuDBtnRak1, #menuDRak1Input').on('focus',function(){
        $('#rakColumn').val('rak').change();
    });
    $('#menuDBtnSubRak1, #menuDSubRak1Input').on('focus',function(){
        if($('#menuDRak1Input').val() == ''){
            $('#menuDRak1Input').focus();
        }else{
            $('#theRak').val($('#menuDRak1Input').val());
            $('#rakColumn').val('subrak').change();
        }
    });
    $('#menuDBtnTipeRak1, #menuDTipeRak1Input').on('focus',function(){
        if($('#menuDRak1Input').val() == ''){
            $('#menuDRak1Input').focus();
        }else if($('#menuDSubRak1Input').val() == ''){
            $('#menuDSubRak1Input').focus();
        }else{
            $('#theSubRak').val($('#menuDSubRak1Input').val());
            $('#rakColumn').val('tiperak').change();
        }
    });
    $('#menuDBtnShelving1, #menuDShelving1Input').on('focus',function(){
        if($('#menuDRak1Input').val() == ''){
            $('#menuDRak1Input').focus();
        }else if($('#menuDSubRak1Input').val() == ''){
            $('#menuDSubRak1Input').focus();
        }else if($('#menuDTipeRak1Input').val() == ''){
            $('#menuDTipeRak1Input').focus();
        }else{
            $('#theTipeRak').val($('#menuDTipeRak1Input').val());
            $('#rakColumn').val('shelving').change();
        }
    });

    //onchange input
    $('#menuDRak1Input').on('change',function(){
        $('#menuDSubRak1Input').val('').change();
        $('#menuDTipeRak1Input').val('').change();
        $('#menuDShelving1Input').val('').change();

        if($('#menuDRak1Input').val() === ''){
            $('#menuDBtnSubRak1').prop("hidden",true);
        }else{
            let index = checkRakExist($('#menuDRak1Input').val());
            if(index){
                $('#menuDBtnSubRak1').prop("hidden",false);
            }else{
                swal('', "Kode Rak tidak terdaftar", 'warning');
                $('#menuDRak1Input').val('').change().focus();
            }
        }
    });
    $('#menuDSubRak1Input').on('change',function(){
        $('#menuDTipeRak1Input').val('').change();
        $('#menuDShelving1Input').val('').change();

        if($('#menuDSubRak1Input').val() === ''){
            $('#menuDBtnTipeRak1').prop("hidden",true);
        }else{
            let index = checkSubRakExist($('#menuDSubRak1Input').val());
            if(index){
                $('#menuDBtnTipeRak1').prop("hidden",false);
            }else{
                swal('', "Kode Sub Rak tidak termasuk dalam Rak", 'warning');
                $('#menuDSubRak1Input').val('').change().focus();
            }
        }
    });
    $('#menuDTipeRak1Input').on('change',function(){
        $('#menuDShelving1Input').val('').change();

        if($('#menuDTipeRak1Input').val() === ''){
            $('#menuDBtnShelving1').prop("hidden",true);
        }else{
            let index = checkTipeRakExist($('#menuDTipeRak1Input').val());
            if(index){
                $('#menuDBtnShelving1').prop("hidden",false);
            }else{
                swal('', "Kode Tipe Rak tidak termasuk dalam Sub Rak", 'warning');
                $('#menuDTipeRak1Input').val('').change().focus();
            }
        }
    });
    $('#menuDShelving1Input').on('change',function(){
        if($('#menuDShelving1Input').val() === ''){
            //do nothing
        }else{
            let index = checkShelvingExist($('#menuDShelving1Input').val());
            if(index){
                //do nothing
            }else{
                swal('', "Kode Shelving Rak tidak termasuk dalam Tipe Rak", 'warning');
                $('#menuDShelving1Input').val('').change().focus();
            }
        }
    });

    //####### SAMPAI #######
    $('#menuDBtnRak2, #menuDRak2Input').on('focus',function(){
        $('#rakColumn').val('rak').change();
    });
    $('#menuDBtnSubRak2, #menuDSubRak2Input').on('focus',function(){
        if($('#menuDRak2Input').val() === ''){
            $('#menuDRak2Input').focus();
        }else{
            $('#theRak').val($('#menuDRak2Input').val());
            $('#rakColumn').val('subrak').change();
        }
    });
    $('#menuDBtnTipeRak2, #menuDTipeRak2Input').on('focus',function(){
        if($('#menuDRak2Input').val() === ''){
            $('#menuDRak2Input').focus();
        }else if($('#menuDSubRak2Input').val() == ''){
            $('#menuDSubRak2Input').focus();
        }else{
            $('#theSubRak').val($('#menuDSubRak2Input').val());
            $('#rakColumn').val('tiperak').change();
        }
    });
    $('#menuDBtnShelving2, #menuDShelving2Input').on('focus',function(){
        if($('#menuDRak2Input').val() === ''){
            $('#menuDRak2Input').focus();
        }else if($('#menuDSubRak2Input').val() == ''){
            $('#menuDSubRak2Input').focus();
        }else if($('#menuDTipeRak2Input').val() == ''){
            $('#menuDTipeRak2Input').focus();
        }else{
            $('#theTipeRak').val($('#menuDTipeRak2Input').val());
            $('#rakColumn').val('shelving').change();
        }
    });

    //onchange input
    $('#menuDRak2Input').on('change',function(){
        $('#menuDSubRak2Input').val('').change();
        $('#menuDTipeRak2Input').val('').change();
        $('#menuDShelving2Input').val('').change();

        if($('#menuDRak2Input').val() === ''){
            $('#menuDBtnSubRak2').prop("hidden",true);
        }else{
            let index = checkRakExist($('#menuDRak2Input').val());
            if(index){
                $('#menuDBtnSubRak2').prop("hidden",false);
            }else{
                swal('', "Kode Rak tidak terdaftar", 'warning');
                $('#menuDRak2Input').val('').change().focus();
            }
        }
    });
    $('#menuDSubRak2Input').on('change',function(){
        $('#menuDTipeRak2Input').val('').change();
        $('#menuDShelving2Input').val('').change();

        if($('#menuDSubRak2Input').val() === ''){
            $('#menuDBtnTipeRak2').prop("hidden",true);
        }else{
            let index = checkSubRakExist($('#menuDSubRak2Input').val());
            if(index){
                $('#menuDBtnTipeRak2').prop("hidden",false);
            }else{
                swal('', "Kode Sub Rak tidak termasuk dalam Rak", 'warning');
                $('#menuDSubRak2Input').val('').change().focus();
            }
        }
    });
    $('#menuDTipeRak2Input').on('change',function(){
        $('#menuDShelving2Input').val('').change();

        if($('#menuDTipeRak2Input').val() === ''){
            $('#menuDBtnShelving2').prop("hidden",true);
        }else{
            let index = checkTipeRakExist($('#menuDTipeRak2Input').val());
            if(index){
                $('#menuDBtnShelving2').prop("hidden",false);
            }else{
                swal('', "Kode Tipe Rak tidak termasuk dalam Sub Rak", 'warning');
                $('#menuDTipeRak2Input').val('').change().focus();
            }
        }
    });
    $('#menuDShelving2Input').on('change',function(){
        if($('#menuDShelving2Input').val() === ''){
            //do nothing
        }else{
            let index = checkShelvingExist($('#menuDShelving2Input').val());
            if(index){
                //do nothing
            }else{
                swal('', "Kode Shelving Rak tidak termasuk dalam Tipe Rak", 'warning');
                $('#menuDShelving2Input').val('').change().focus();
            }
        }
    });

    function menuDChoose(val){
        //val dan cursor didapat dari "list-master.blade.php"
        // let rak = val.children().first().text();
        // let subrak = val.children().first().next().text();
        // let tiperak = val.children().first().next().next().text();
        // let shelving = val.children().first().next().next().next().text();

        let data = val.children().first().text();
        //let index = cursor.substr(8);
        let index = cursor.substr(cursor.length - 1);
        switch (index){
            case "1":
                switch ($('#rakColumn').val()){
                    case "rak" :
                        $('#menuDRak1Input').val(data).change();
                        break;
                    case "subrak" :
                        $('#menuDSubRak1Input').val(data).change();
                        break;
                    case "tiperak" :
                        $('#menuDTipeRak1Input').val(data).change();
                        break;
                    case "shelving" :
                        $('#menuDShelving1Input').val(data).change();
                        break;
                }
                break;
            case "2":
                switch ($('#rakColumn').val()){
                    case "rak" :
                        $('#menuDRak2Input').val(data).change();
                        break;
                    case "subrak" :
                        $('#menuDSubRak2Input').val(data).change();
                        break;
                    case "tiperak" :
                        $('#menuDTipeRak2Input').val(data).change();
                        break;
                    case "shelving" :
                        $('#menuDShelving2Input').val(data).change();
                        break;
                }
                break;
        }
    }

    function menuDClear(){
        $('#menuDRak1Input').val('');
        $('#menuDSubRak1Input').val('');
        $('#menuDTipeRak1Input').val('');
        $('#menuDShelving1Input').val('');

        $('#menuDRak2Input').val('');
        $('#menuDSubRak2Input').val('');
        $('#menuDTipeRak2Input').val('');
        $('#menuDShelving2Input').val('');

        $('#menuDCheck').prop("checked",false);

        $('#theRak').val();
        $('#theSubRak').val();
        $('#theTipeRak').val();
        $('#rakColumn').val('').change();
    }

    function menuDCetak(){
        let rak1 = $('#menuDRak1Input').val();
        let rak2 = $('#menuDRak2Input').val();
        let subrak1 = $('#menuDSubRak1Input').val();
        let subrak2 = $('#menuDSubRak2Input').val();
        let tiperak1 = $('#menuDTipeRak1Input').val();
        let tiperak2 = $('#menuDTipeRak2Input').val();
        let shelving1 = $('#menuDShelving1Input').val();
        let shelving2 = $('#menuDShelving2Input').val();

        let temp = '';

        if(rak1 !== '' && rak2 !== ''){
            if(rak1 > rak2){
                temp = rak1;
                rak1 = rak2;
                rak2 = temp;
                temp = subrak1;
                subrak1 = subrak2;
                subrak2 = temp;
                temp = tiperak1;
                tiperak1 = tiperak2;
                tiperak2 = temp;
                temp = shelving1;
                shelving1 = shelving2;
                shelving2 = temp;
            }else if(rak1 === rak2){
                if(subrak1 !== '' && subrak2 !== ''){
                    if(subrak1 > subrak2){
                        temp = subrak1;
                        subrak1 = subrak2;
                        subrak2 = temp;
                        temp = tiperak1;
                        tiperak1 = tiperak2;
                        tiperak2 = temp;
                        temp = shelving1;
                        shelving1 = shelving2;
                        shelving2 = temp;
                    }else if(subrak1 === subrak2){
                        if(tiperak1 !== '' && tiperak2 !== ''){
                            if(tiperak1 > tiperak2){
                                temp = tiperak1;
                                tiperak1 = tiperak2;
                                tiperak2 = temp;
                                temp = shelving1;
                                shelving1 = shelving2;
                                shelving2 = temp;
                            }else if(tiperak1 === tiperak2){
                                if(shelving1 !== '' && shelving2 !== ''){
                                    if(shelving1 > shelving2){
                                        temp = shelving1;
                                        shelving1 = shelving2;
                                        shelving2 = temp;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        //checkboxes
        let omi = 0;
        if($('#menuDCheck').prop("checked")){
            omi = 1;
        }

        //PRINT
        window.open(`{{ url()->current() }}/print-master-display?rak1=${rak1}&rak2=${rak2}&subrak1=${subrak1}&subrak2=${subrak2}&tiperak1=${tiperak1}&tiperak2=${tiperak2}&shelving1=${shelving1}&shelving2=${shelving2}&omi=${omi}`, '_blank');
    }
</script>
