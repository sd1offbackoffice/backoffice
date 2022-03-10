@extends('navbar')
@section('title','Virtual Stock CMO')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card">
                    <legend class="w-auto ml-5">Laporan Virtual Stock Untuk Data Commit Order</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-body">     
                                    <div class="form-horizontal">                                    
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Tipe Laporan</label>
                                            <div class="col-sm-10 mt-2">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="optradio" value="r1" id="tipevcmo" checked>
                                                    <label class="form-check-label">Rekap</label>
                                                </div>
                                                <div class="form-check form-check-inline ml-4">
                                                    <input class="form-check-input" type="radio" name="optradio" value="r2" id="tipevcmo">
                                                    <label class="form-check-label">Detail</label>
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="form-group row">
                                            <label for="divisi" class="col-sm-2 col-form-label">Divisi</label>
                                            <div class="col-sm-10 row">
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="div1" maxlength="1">
                                                    <button onclick="GetDiv(this)" id="1" type="button" class="btn btn-lov p-0">
                                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                    </button>
                                                </div>
                                                <div class="col-sm-1">
                                                    <label> s/d</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="div2" maxlength="1">
                                                    <button onclick="GetDiv(this)" id="2" type="button" class="btn btn-lov p-0">
                                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                    </button>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="departement" class="col-sm-2 col-form-label">Departement</label>
                                            <div class="col-sm-10 row">
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="dept1">
                                                    <button onclick="GetDept(this)" id="1" type="button" class="btn btn-lov p-0">
                                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                    </button>
                                                </div>
                                                <div class="col-sm-1">
                                                    <label> s/d</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="dept2">
                                                    <button onclick="GetDept(this)" id="2" type="button" class="btn btn-lov p-0">
                                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                    </button>
                                                </div> 
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                                            <div class="col-sm-10 row">
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="kat1">
                                                    <button onclick="GetKat(this)" id="1" type="button" class="btn btn-lov p-0">
                                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                    </button>
                                                </div>
                                                <div class="col-sm-1">
                                                    <label> s/d</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="kat2">
                                                    <button onclick="GetKat(this)" id="2" type="button" class="btn btn-lov p-0">
                                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                    </button>
                                                </div> 
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Supplier</label>
                                            <div class="col-sm-10 row">
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control text-left" id="kodesupplier" autocomplete="off">
                                                    <button type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal"
                                                            data-target="#m_supplier">
                                                        <i class="fas fa-question"></i>
                                                    </button>     
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="kodemcg" disabled>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="namasupplier" readonly>
                                                </div> 
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Tanggal</label>
                                            <div class="col-sm-10 row">
                                                <div class="col-sm-4">
                                                <input type="text" class="form-control daterange-periode" id="periode1">
                                                </div>
                                                <div class="col-sm-1">
                                                    <label>s/d</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control daterange-periode" id="periode2">
                                                </div> 
                                            </div>
                                        </div>

                                    </div><!-- form-horizontal-->
                                </div><!-- form-body-->
                                <div class="d-flex justify-content-end mt-4 mb-3">
                                    <!-- <div class="mr-auto p-2 bd-highlight font-weight-bold">** Kosong Semua = ALL</div> -->
                                    <button class="bd-highlight btn btn-primary col-sm-2" type="button" onclick="printPDF()">PRINT PDF</button>
                                    <button class="bd-highlight btn btn-success col-sm-2 ml-2" type="button" onclick="printCSV()">PRINT CSV</button>
                                </div>
                            </div> <!-- col-md-12 -->
                        </div> <!-- row -->
                    </div> <!--card body-->
                </fieldset>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="modalHelp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Memilih Divisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="modalHelper">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th id="modalThName1"></th>
                                        <th id="modalThName2"></th>
                                        <th id="modalThName3"></th>
                                        <th id="modalThName4"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_supplier">
                                    <thead>
                                    <tr>
                                        <th>KODE SUPPLIER</th>
                                        <th>KODE MCG</th>
                                        <th>NAMA SUPPLIER</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_supplier_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    
<script>
    object_plu = '#plu1';
    let cursor = '0';
    $(document).ready(function() {
        var d = new Date();

        var month = d.getMonth() + 1;
        var day = d.getDate();

        var output1 = '0' + (day - day + 1) + '/' + (month < 10 ? '0' : '') + month + '/' + d.getFullYear();
        var output2 = (day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + d.getFullYear();
            $('#periode1').val(output1);
            $('#periode2').val(output2);

        getSupplier('');
    });
    // end document

    $('.daterange-periode').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('.daterange-periode').on('apply.daterangepicker', function (ev, picker) {
        $('#periode1').val(picker.startDate.format('DD/MM/YYYY'));
        $('#periode2').val(picker.endDate.format('DD/MM/YYYY'));
    });

    $('.daterange-periode').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

    $('#btn-proses').on('click', function () {
        periode1 = $('#periode1').val();
        periode2 = $('#periode2').val();
        if (periode1 == "" || periode2 == "") {
            swal('Mohon isi periode dengan benar !!', '', 'warning');
        } else {
            ajaxSetup();
            $.ajax({
                url: "{{ url('/bo/virtual-stock-cmo') }}",
                type: 'post',
                data: {
                    periode1: periode1,
                    periode2: periode2
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if (response.status == 'success') {
                        $('#modal-loader').modal('show');
                        console.log(response);
                        swal(response.status, response.message, response.status);
                    } else {
                        alertError(response.status, response.message, response.status)
                    }
                }, error: function (error) {
                    console.log(error);
                }
            });
        }
    });

    function GetDiv(val) {
        cursor = val.id;
 
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/getdiv',
            type: 'post',
            success: function (result) {
                $('#modalThName1').text('KODE DIVISI');
                $('#modalThName2').text('NAMA DIVISI');
                $('#modalThName3').text('SINGKATAN DIVISI');
                $('#modalThName4').text('');

                $('.modalRow').remove();
                $('#modalHelper').DataTable().clear().destroy();
                $('#modalHelper').find("tbody").empty();
                for (i = 0; i< result.length; i++){
                    $('#tbodyModalHelp').append("<tr onclick=chooseDiv('"+ result[i].div_kodedivisi+"') class='modalRow'><td>"+ result[i].div_kodedivisi +"</td> <td>"+ result[i].div_namadivisi +"</td> <td>"+ result[i].div_singkatannamadivisi +"</td><td> </td></tr>")
                }
                $('#modalHelper').DataTable();
                $('#modalHelp').modal('show');
            }, error: function () {
                alert('error');
            }
        })
    }

    function chooseDiv(div){
        console.log(div,'ini div');
        $('#div'+cursor).val(div);
        $('#modalHelp').modal('hide');
    }

    function GetDept(val) {
        cursor = val.id;
        console.log($('#div1').val(),'ini div 1');
        if($('#div1').val() == '' || $('#div2').val() == ''){
            swal('', "Kode div 1 dan div 2 harus di isi untuk mencari departemen !!", 'warning');
        }else{
            let div1 = $('#div1').val();
            let div2 = $('#div2').val();
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/getdept',
                type: 'post',
                data: {
                    div1:div1,
                    div2:div2
                },
                success: function (result) {
                    $('#modalThName1').text('KODE DEPARTEMEN');
                    $('#modalThName2').text('NAMA DEPARTEMEN');
                    $('#modalThName3').text('KODE DIVISI');
                    $('#modalThName4').text('SINGKATAN DEPARTEMEN');

                    $('.modalRow').remove();
                    $('#modalHelper').DataTable().clear().destroy();
                    $('#modalHelper').find("tbody").empty();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseDept('"+ result[i].dep_kodedepartement+"') class='modalRow'><td>"+ result[i].dep_kodedepartement +"</td> <td>"+ result[i].dep_namadepartement +"</td> <td>"+ result[i].dep_kodedivisi +"</td><td>"+ result[i].dep_singkatandepartement +"</td></tr>")
                    }
                    $('#modalHelper').DataTable();
                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            });

        }
    }

    function chooseDept(dept){
        $('#dept'+cursor).val(dept);
        $('#modalHelp').modal('hide');
    }

    function GetKat(val) {
        cursor = val.id;
        if($('#dept1').val() == '' || $('#dept2').val() == ''){
            swal('', "Kode dept 1 dan dept 2 harus di isi untuk mencari departemen !!", 'warning');
        }else{
            let dept1 =  $('#dept1').val();
            let dept2 =  $('#dept2').val();
            $('#searchModal').val('');
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/getkat',
                type: 'post',
                data: {
                    dept1:dept1,
                    dept2:dept2
                },
                success: function (result) {
                    $('#modalThName1').text('KODE KATEGORI');
                    $('#modalThName2').text('NAMA KATEGORI');
                    $('#modalThName3').text('KODE DEPARTEMEN');
                    $('#modalThName4').text('SINGKATAN KATEGORI');

                    $('.modalRow').remove();
                    $('#modalHelper').DataTable().clear().destroy();
                    $('#modalHelper').find("tbody").empty();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseKat('"+ result[i].kat_kodekategori+"') class='modalRow'><td>"+ result[i].kat_kodekategori +"</td> <td>"+ result[i].kat_namakategori +"</td> <td>"+ result[i].kat_kodedepartement +"</td> <td>"+ result[i].kat_singkatan +"</td></tr>")
                    }
                    $('#modalHelper').DataTable();
                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }
    }

    function chooseKat(kat){
        $('#kat'+cursor).val(kat);
        $('#modalHelp').modal('hide');
    }

    
    function reset() {
        $('#kodesupplier').val('');
        $('#kodemcg').val('');
        $('#namasupplier').val('');
    }

    $("#kodesupplier").on('keypress', function (e) {
        if (e.which == 13) {
            if ($('#kodesupplier').val() != '') {
                getDataSupplier();
            }
        }
    })

    function getSupplier() {
        if ($.fn.DataTable.isDataTable('#table_supplier')) {
            $('#table_supplier').DataTable().destroy();
        }
        table_supplier = $('#table_supplier').DataTable({
            "ajax": {
                url: '{{ url()->current() }}/get-supplier',
            },
            "columns": [
                {data: 'sup_kodesupplier'},
                {data: 'sup_kodesuppliermcg'},
                {data: 'sup_namasupplier'},
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "createdRow": function (row, data, dataIndex) {
                $(row).addClass('row-supplier').css({'cursor': 'pointer'});
            },
            "order": [],
            "initComplete": function () {
                // $('.btn-lov-kode-omi').prop('disabled', false).html('').append('<i class="fas fa-question"></i>');

                $(document).on('click', '.row-supplier', function (e) {
                    reset();
                    $('#kodesupplier').val($(this).find('td:eq(0)').html());
                    $('#kodemcg').val($(this).find('td:eq(1)').html());
                    $('#namasupplier').val($(this).find('td:eq(2)').html());
                    getDataSupplier();
                    $('#m_supplier').modal('hide');
                });
            }
        });
    }

    function getDataSupplier() {
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current().'/get-data-supplier' }}',
            type: 'post',
            data: {
                kodesupplier: $('#kodesupplier').val(),
            },
            beforeSend: function () {
                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
            },
            success: function (result) {

                $('#modal-loader').modal('hide');
                $('#kodemcg').val(result.data.sup_kodesuppliermcg);
                $('#namasupplier').val(result.data.sup_namasupplier);
            }, error: function (e) {
                alert('error');
            }
        })
    }

    function printPDF() {
        if ($('#div1').val() == '' || $('#div2').val() == '' 
        || $('#dept1').val() == '' || $('#dept2').val() == ''
        || $('#kat1').val() == '' || $('#kat2').val() == ''
        || $('#kodesupp').val() == '' || $('#kodemcg').val() == '' || $('#namasupplier').val() == ''
        || $('#periode1').val() == '' || $('#periode2').val() == '') {
            swal('Error', "Input semua kolom untuk cetak PDF !", 'error');
        }else {
            window.open(`{{ url()->current() }}/printPDF?tipevcmo=${$("input[type='radio'][name='optradio']:checked").val()}&div1=${$('#div1').val()}&div2=${$('#div2').val()}&dept1=${$('#dept1').val()}&dept2=${$('#dept2').val()}&kat1=${$('#kat1').val()}&kat2=${$('#kat2').val()}&kodesupplier=${$('#kodesupplier').val()}&kodemcg=${$('#kodemcg').val()}&namasupplier=${$('#namasupplier').val()}&periode1=${$('#periode1').val()}&periode2=${$('#periode2').val()}`, '_blank');
        }
    }

    function printCSV() {
        if ($('#div1').val() == '' || $('#div2').val() == '' 
        || $('#dept1').val() == '' || $('#dept2').val() == ''
        || $('#kat1').val() == '' || $('#kat2').val() == ''
        || $('#kodesupp').val() == '' || $('#kodemcg').val() == '' || $('#namasupplier').val() == ''
        || $('#periode1').val() == '' || $('#periode2').val() == '') {
            swal('Error', "Input semua kolom untuk cetak CSV !", 'error');
        }else {
            window.open(`{{ url()->current() }}/printCSV?tipevcmo=${$("input[type='radio'][name='optradio']:checked").val()}&div1=${$('#div1').val()}&div2=${$('#div2').val()}&dept1=${$('#dept1').val()}&dept2=${$('#dept2').val()}&kat1=${$('#kat1').val()}&kat2=${$('#kat2').val()}&kodesupplier=${$('#kodesupplier').val()}&kodemcg=${$('#kodemcg').val()}&namasupplier=${$('#namasupplier').val()}&periode1=${$('#periode1').val()}&periode2=${$('#periode2').val()}`, '_blank');
        }
    }

    </script>
@endsection
