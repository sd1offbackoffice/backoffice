@extends('navbar')
@section('title','SUPER PROMO')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5 text-left">Tabel Super Promo</legend>
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row" style="padding-bottom: 20px">
                            <label class="col-sm-4 col-form-label text-right">Tanggal</label>
                            <div class="col-sm-5">
                                <input class="text-center form-control" type="text" id="daterangepicker">
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5 text-left">Detail Tabel Super Promo</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="p-0 tableFixedHeader" style="height: 400px;">
                            <table class="table table-sm table-striped table-bordered"
                                   id="tableMain">
                                <thead>
                                <tr class="table-sm text-center">
                                    <th width="3%" class="text-center small">&nbsp;&nbsp;</th>
                                    <th width="17%" class="text-center small">PLU</th>
                                    <th width="20%" class="text-center small">Harga Jual</th>
                                    <th width="20%" class="text-center small">Target Qty</th>
                                    <th width="20%" class="text-center small">Target Sales</th>
                                    <th width="20%" class="text-center small">Target Gross Margin</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyMain" style="height: 400px;">
                                @for($i = 0 ; $i< 10 ; $i++)
                                    <tr class="baris">
                                        <td class="text-center">
                                            <button onclick="deleteRow(this)" class="btn btn-block btn-sm btn-danger btn-delete-row-header" class="icon fas fa-times">X</button>
                                        </td>
                                        <td onclick="ChangeDesk(this)">
                                            <input class="form-control plu" value="" onchange="CheckPlu(this)"
                                                   type="text">
                                        </td>
                                        <td onclick="ChangeDesk(this)">
                                            <input class="form-control hrgjual text-right" value="" onkeypress="return isNumberKey(event)"
                                                   type="text">
                                        </td>
                                        <td onclick="ChangeDesk(this)">
                                            <input class="form-control qty text-right" value=""
                                                   type="text">
                                        </td>
                                        <td onclick="ChangeDesk(this)">
                                            <input class="form-control sales text-right" value=""
                                                   type="text">
                                        </td>
                                        <td onclick="ChangeDesk(this)">
                                            <input class="form-control grossmargin text-right" value=""
                                                   type="text">
                                        </td>
                                        <td hidden>
                                            <input class="form-control hiddenDeskripsi text-right" value=""
                                                   type="text" hidden>
                                        </td>
                                        <td hidden>
                                            <input class="form-control hiddenUnit text-right" value=""
                                                   type="text" hidden>
                                        </td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Deskripsi</label>
                            <div class="col-sm-5">
                                <input class="text-left form-control" type="text" id="deskripsiTable" readonly>
                            </div>
                            <div class="col-sm-2">
                                <input class="text-left form-control" type="text" id="unitMini" readonly>
                            </div>
                            <div class="col-sm-3 d-flex justify-content-end">
                                <button class="btn btn-primary col-sm-10 add-btn" type="button" onclick="addRow()">ADD ROW</button>&nbsp;
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="row">
                    <label class="col-sm-2 col-form-label">Ctrl + S --> Simpan Data</label>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#daterangepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        // Function untuk overide tombol keyboard
        $(window).bind('keydown', function(event) {
            if (event.ctrlKey || event.metaKey) {
                if(String.fromCharCode(event.which).toLowerCase() === 's'){
                    // Lakukan yang anda mau disini
                    save();
                    event.preventDefault();
                }
            }
        });

        function CheckPlu(w){
            let crop = w.value.toUpperCase();
            let row = w.parentNode.parentNode.rowIndex-1;
            if(crop != ''){
                if(crop.substr(0,1) == '#'){
                    crop = crop.substr(1,(crop.length)-1);
                }
            }
            if(crop.length < 7){
                crop = crop.padStart(7,'0');
            }
            for(i=0;i<$('.baris').length;i++){
                if(i!=row){
                    if($('.plu')[i].value == crop){
                        swal('', "Kode produk "+crop+" sudah ada", 'warning');
                        w.value = "";
                        $('.hiddenDeskripsi')[row].value = '';
                        $('.hiddenUnit')[row].value = '';
                        return false;
                    }
                }
            }
            w.value = crop;
            $.ajax({
                url: '{{ url()->current() }}/check-plu',
                type: 'GET',
                data: {
                    kode:crop
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if(response.notif == ''){
                        $('.hiddenDeskripsi')[row].value = response.deskripsi;
                        $('.hiddenUnit')[row].value = response.unit;

                        $('#deskripsiTable').val(response.deskripsi);
                        $('#unitMini').val(response.unit);
                    }else{
                        swal('', response.notif, 'warning');
                        w.value = "";
                        $('.hiddenDeskripsi')[row].value = '';
                        $('.hiddenUnit')[row].value = '';
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                    return false;
                }
            });
        }

        function ChangeDesk(w){
            let row = w.parentNode.rowIndex-1;
            $('#deskripsiTable').val($('.hiddenDeskripsi')[row].value);
            $('#unitMini').val($('.hiddenUnit')[row].value);
        }

        function isNumberKey(evt){
            let charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        function addRow() {
            $('#tableMain').append(tempTable());
        }

        function deleteRow(e) {
            // setInterval($(e).parents("tr").remove(),10000);
            $(e).parents("tr").remove();
        }

        function tempTable() {
            var temptbl =  `<tr class="baris">
                                        <td class="text-center">
                                            <button onclick="deleteRow(this)" class="btn btn-block btn-sm btn-danger btn-delete-row-header" class="icon fas fa-times">X</button>
                                        </td>
                                        <td onclick="ChangeDesk(this)">
                                            <input class="form-control plu" value="" onchange="CheckPlu(this)"
                                                   type="text">
                                        </td>
                                        <td onclick="ChangeDesk(this)">
                                            <input class="form-control hrgjual text-right" value="" onkeypress="return isNumberKey(event)"
                                                   type="text">
                                        </td>
                                        <td onclick="ChangeDesk(this)">
                                            <input class="form-control qty text-right" value=""
                                                   type="text">
                                        </td>
                                        <td onclick="ChangeDesk(this)">
                                            <input class="form-control sales text-right" value=""
                                                   type="text">
                                        </td>
                                        <td onclick="ChangeDesk(this)">
                                            <input class="form-control grossmargin text-right" value=""
                                                   type="text">
                                        </td>
                                        <td hidden>
                                            <input class="form-control hiddenDeskripsi text-right" value=""
                                                   type="text" hidden>
                                        </td>
                                        <td hidden>
                                            <input class="form-control hiddenUnit text-right" value=""
                                                   type="text" hidden>
                                        </td>
                                    </tr>`

            return temptbl;
        }

        function save(){
            let date = $('#daterangepicker').val();
            // if(date == null || date == ""){
            //     swal('Periode tidak boleh kosong','','warning');
            //     return false;
            // }
            let dateA = date.substr(0,10);
            let dateB = date.substr(13,10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');
            let datas   = [{'plu' : '', 'hrg' : '', 'qty' : '', 'sales' : '', 'margin' : ''}];
            for(i=0;i<$('.baris').length;i++){
                if($('.plu')[i].value != ''){
                    datas.push({'plu':$('.plu')[i].value, 'hrg':$('.hrgjual')[i].value, 'qty':$('.qty')[i].value, 'sales':$('.sales')[i].value, 'margin':$('.grossmargin')[i].value})
                }
            }
            //Saving
            $.ajax({
                url: '{{ url()->current() }}/save',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    date1:dateA,
                    date2:dateB,
                    datas:datas
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    swal({
                        title: 'BERHASIL',
                        icon: 'success'
                    }).then(() => {
                        ClearForm();
                    })
                },
                complete: function () {
                    $('#modal-loader').modal('hide');
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                    return false;
                }
            });
        }

        function ClearForm(){
            $(' input').val('');
            $('#daterangepicker').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
            $('#daterangepicker').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));
        }
    </script>
@endsection
