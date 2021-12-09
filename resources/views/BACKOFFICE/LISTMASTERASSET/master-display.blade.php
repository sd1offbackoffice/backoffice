{{--ASSET LIST MASTER--}}
{{-- MASTER DISPLAY --}}

<div>
    <fieldset class="card border-dark">
        {{--        <legend class="w-auto ml-5">Master Display</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Kode Rak</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuDRak1Input" class="form-control" type="text" readonly>
                <button id="menuDBtnRak1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#rakModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <label class="col-sm-2 text-center col-form-label">s/d</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuDRak2Input" class="form-control" type="text" readonly>
                <button id="menuDBtnRak2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#rakModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Kode Sub Rak</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuDSubRak1Input" class="form-control" type="text" readonly>
                <button id="menuDBtnSubRak1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#rakModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <label class="col-sm-2 text-center col-form-label">s/d</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuDSubRak2Input" class="form-control" type="text" readonly>
                <button id="menuDBtnSubRak2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#rakModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Tipe Rak</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuDTipeRak1Input" class="form-control" type="text" readonly>
                <button id="menuDBtnTipeRak1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#rakModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <label class="col-sm-2 text-center col-form-label">s/d</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuDTipeRak2Input" class="form-control" type="text" readonly>
                <button id="menuDBtnTipeRak2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#rakModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Shelving</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuDShelving1Input" class="form-control" type="text" readonly>
                <button id="menuDBtnShelving1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#rakModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <label class="col-sm-2 text-center col-form-label">s/d</label>
            <div class="col-sm-3 buttonInside">
                <input id="menuDShelving2Input" class="form-control" type="text" readonly>
                <button id="menuDBtnShelving2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#rakModal">
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
    function menuDChoose(val){
        //val dan cursor didapat dari "list-master.blade.php"
        let rak = val.children().first().text();
        let subrak = val.children().first().next().text();
        let tiperak = val.children().first().next().next().text();
        let shelving = val.children().first().next().next().next().text();
        //let index = cursor.substr(8);
        let index = cursor.substr(cursor.length - 1);
        switch (index){
            case "1":
                $('#menuDRak1Input').val(rak);
                $('#menuDSubRak1Input').val(subrak);
                $('#menuDTipeRak1Input').val(tiperak);
                $('#menuDShelving1Input').val(shelving);
                break;
            case "2":
                $('#menuDRak2Input').val(rak);
                $('#menuDSubRak2Input').val(subrak);
                $('#menuDTipeRak2Input').val(tiperak);
                $('#menuDShelving2Input').val(shelving);
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
    }

    function menuDCetak(){
        let rak1 = $('#menuDRak1Input').val();
        let rak2 = $('#menuDRak1Input').val();
        let subrak1 = $('#menuDSubRak1Input').val();
        let subrak2 = $('#menuDSubRak2Input').val();
        let tiperak1 = $('#menuDTipeRak1Input').val();
        let tiperak2 = $('#menuDTipeRak2Input').val();
        let shelving1 = $('#menuDShelving1Input').val();
        let shelving2 = $('#menuDShelving2Input').val();

        let temp = '';
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
