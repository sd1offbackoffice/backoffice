@extends('navbar')
@section('title','LAPORAN - SERVICE LEVEL ITEM PARETO')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5">Service Level Item Pareto</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <br>
                            <div class="col-sm-12">
                                <label class="col-sm-4 text-right font-weight-normal">Tanggal</label>
                                <input class="col-sm-3 text-center" type="text" id="daterangepicker">
                                <label class="col-sm-2 text-left">DD / MM / YYYY</label>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 text-right font-weight-normal">Kode Monitoring Produk</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control" id="kmp" onchange="checkNmr()">
                                    <button id="btn-no-doc" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                            data-target="#monitoringModal">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                                <input class="col-sm-3 text-center" type="text" id="display_kmp" readonly style="background-color: lightgray">
                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <label class="col-sm-4 text-right font-weight-normal">Ranking</label>
                                    <div class="col-sm-5">
                                        <input type="radio" id="ddk" name="ranking" value="ddk" checked>
                                        <label for="ddk">Divisi/Departmen/Kategory</label><br>
                                        <input type="radio" id="Supplier" name="ranking" value="Supplier">
                                        <label for="Supplier">Supplier</label><br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5 float-right">
                                <input type="checkbox" id="bkl" name="bkl" value="bkl" onchange="bklChange()">
                                <label for="bkl">BKL</label>
                                <button class="btn btn-success col-sm-3" type="button" onclick="print()">C E T A K</button>
                            </div>
                            <br>
                        </form>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="m_kodecabangHelp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="searchModal" class="form-control search_lov" type="text" placeholder="..." aria-label="Search">
                    </div>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="tableFixedHeader">
                                    <table class="table table-sm">
                                        <thead>
                                        <tr>
                                            <th id="modalThName1"></th>
                                            <th id="modalThName2"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbodyModalHelp"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    {{--Modal--}}
    <div class="modal fade" id="monitoringModal" tabindex="-1" role="dialog" aria-labelledby="monitoringModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">MONITORING</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="monitoringTable">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Monitoring</th>
                                        <th>Nama Monitoring</th>
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

    <script>
        $(document).ready(function () {
            $('#monitoringTable').DataTable({
                "ajax": '{{ url('laporan/servicelevelitempareto/modalnmr') }}',
                "columns": [
                    {data: 'mpl_kodemonitoring', name: 'mpl_kodemonitoring'},
                    {data: 'mpl_namamonitoring', name: 'mpl_namamonitoring'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                },
                "order": []
            });
        });
        $(document).on('click', '.modalRow', function () {
            var currentButton = $(this);
            let kode = currentButton.children().first().text();
            let nama = currentButton.children().first().next().text();

            chooseMtr(kode+','+nama);
            $('#monitoringModal').modal('hide');
        });

        $('#daterangepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        function bklChange(){
            if($('input[name="bkl"]:checked').val() == "bkl"){
                $('#kmp').prop('disabled',true);
                $('#btn-no-doc').prop('disabled',true);
            }else{
                $('#kmp').prop('disabled',false);
                $('#btn-no-doc').prop('disabled',false);
            }
        }

        function checkNmr() {
            val = $('#kmp').val();
            $('#modal-loader').modal('show');
                ajaxSetup();
                $.ajax({
                url: '/BackOffice/public/laporan/servicelevelitempareto/getnmr',
                type: 'post',
                data: {
                    val:val
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    $('#modalThName1').text('Kode Monitoring');
                    $('#modalThName2').text('Nama Monitoring');
                    if(result.mpl_kodemonitoring){
                        chooseMtr(result.mpl_kodemonitoring + ',' + result.mpl_namamonitoring)
                    }else{
                        swal('Input Salah!','','warning');
                        $('#kmp').val('');
                        $('#display_kmp').val('');
                    }
                }, error: function () {
                    alert('error');
                }
            })
        }

        function chooseMtr(val){
            let temp = val.split(",");
            let kode = temp[0];
            let nama = temp[1];
            $('#kmp').val(kode);
            $('#display_kmp').val(nama);
            $('#modalHelp').modal('hide');
            $('#modal-loader').modal('hide');
        }

        function print() {
            let date = $('#daterangepicker').val();
            if(date == null || date == ""){
                swal('Input masih kosong','','warning');
                return false;
            }
            let dateA = date.substr(0,10);
            let dateB = date.substr(13,10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');
            let monthA = dateA.split("-");
            let monthB = dateB.split("-");
            let kmp = '';
            if(monthA[0] != monthB[0]){
                swal('', "Bulan Periode Harus Sama !!", 'warning');
                return false;
            }if(monthA[2] != monthB[2]){
                swal('', "Tahun Periode Harus Sama !!", 'warning');
                return false;
            }
            if($('input[name="bkl"]:checked').val() == "bkl"){
                kmp = "zonk-zonk";
            }else if($('#kmp').val() != ''){
                kmp = $('#kmp').val();
            }else{
                swal('', "Harus mencentang bkl atau menginput kode monitor !!", 'warning');
                return false;
            }
            let rad_order = $('input[name="ranking"]:checked').val();

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/laporan/servicelevelitempareto/checkdata',
                type: 'post',
                data: {
                    dateA:dateA,
                    dateB:dateB,
                    kmp:kmp,
                    rad_order:rad_order
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    if(result.kode == '1'){
                        if(rad_order == "Supplier" || kmp == "zonk-zonk"){
                            window.open('/BackOffice/public/laporan/servicelevelitempareto/printdocsupplier/'+kmp+'/'+dateA+'/'+dateB,'_blank');
                        }else{
                            window.open('/BackOffice/public/laporan/servicelevelitempareto/printdocddk/'+kmp+'/'+dateA+'/'+dateB,'_blank');
                        }
                    }else if (result.kode == '2'){
                        swal('', "Kode Monitoring Tidak Terdaftar !!", 'warning');
                    }
                    else if (result.kode == '0'){
                        swal('', "tidak ada data", 'warning');
                    }
                    $('#modal-loader').modal('hide');
                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }
    </script>
@endsection
