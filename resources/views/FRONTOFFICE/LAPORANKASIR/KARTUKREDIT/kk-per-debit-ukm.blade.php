@extends('navbar')
@section('title','LAPORAN KASIR | KK PER DEBIT UKM')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-sm-2"></div>
                            <label class="col-sm-1 text-right col-form-label pl-0">TANGGAL</label>
                            <input type="text" class="col-sm-7 form-control text-center" id="tanggal" placeholder="DD/MM/YYYY - DD/MM/YYYY" readonly>
                            <div class="col-sm"></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-1"></div>
                            <label class="col-sm-2 text-right col-form-label pl-0">KODE KASIR</label>
                            <div class="col-sm-3 buttonInside pl-0">
                                <input type="text" class="form-control text-left" id="kasir1" onchange="checkKasir('kasir1')" disabled>
                                <button id="btn_lov_kasir" type="button" class="btn btn-primary btn-lov p-0" onclick="showLov('kasir1')" disabled>
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <label class="col-sm-1 pt-1 text-center">s/d</label>
                            <div class="col-sm-3 buttonInside p-0">
                                <input type="text" class="form-control text-left" id="kasir2" onchange="checkKasir('kasir2')" disabled>
                                <button id="btn_lov_kasir" type="button" class="btn btn-primary btn-lov p-0" onclick="showLov('kasir2')" disabled>
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <div class="col-sm"></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <button class="col-sm-2 btn btn-primary" onclick="cetak()">CETAK LAPORAN</button>
                            <div class="col-sm"></div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov">
                                    <thead>
                                    <tr>
                                        <th>USERID</th>
                                        <th>USERNAME</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_lov_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .modal tbody tr:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .btn-lov-cabang{
            position:absolute;
            bottom: 10px;
            right: 3vh;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .btn-lov-cabang:focus,
        .btn-lov-cabang:active{
            box-shadow:none !important;
            outline:0px !important;
        }

        .btn-lov-plu{
            position:absolute;
            bottom: 10px;
            right: 2vh;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .btn-lov-plu:focus,
        .btn-lov-plu:active{
            box-shadow:none !important;
            outline:0px !important;
        }

        .modal thead tr th{
            vertical-align: middle;
        }
    </style>

    <script>
        var currField;

        $(document).ready(function(){
            $('#tanggal').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });

            getLov();
        });

        function getLov(){
            $('#table_lov').DataTable({
                "ajax": '{{ url()->current() }}/get-lov',
                "columns": [
                    {data: 'userid', name: 'userid'},
                    {data: 'username', name: 'username'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov').css({'cursor': 'pointer'});
                    $('.btn-lov').prop('disabled', false);
                },
                "order" : [],
                "initComplete": function(){
                    $(document).on('click', '.row-lov', function (e) {
                        $('#'+currField).val($(this).find('td:eq(0)').html());

                        $('#m_lov').modal('hide');

                        checkKasir();
                    });
                }
            });
        }

        function showLov(field){
            currField = field;

            $('#m_lov').modal('show');
        }

        function checkKasir(){
            if($('#kasir1').val() && $('#kasir2').val() && $('#kasir1').val() > $('#kasir2').val()){
                swal({
                    title: 'Kode kasir 1 lebih besar dari kode kasir 2!',
                    icon: 'warning'
                }).then(function(){
                    $('#'+currField).val('');
                })
            }
        }

        $('#tanggal').on('change',function(){
            // if(!checkDate(this.value)){
            //     swal({
            //         title: 'Tanggal tidak sesuai format',
            //         icon: 'warning'
            //     }).then(()=>{
            //         $(this).select();
            //     });
            // }
        });

        // function showModal(){
        //     if(!$('#tanggal').val() || !checkDate($('#tanggal').val())){
        //         swal({
        //             title: 'Tanggal tidak sesuai format',
        //             icon: 'warning'
        //         }).then(()=>{
        //             $(this).select();
        //         });
        //     }
        //     else $('#m_result').modal('show')
        // }

        function cetak(){
            tgl1 = $("#tanggal").data('daterangepicker').startDate.format('DD/MM/YYYY');
            tgl2 = $("#tanggal").data('daterangepicker').endDate.format('DD/MM/YYYY');

            if(($('#kasir1').val() && $('#kasir2').val()) || (!$('#kasir1').val() && !$('#kasir2').val())){
                window.open(`{{ url()->current() }}/cetak?tgl1=${tgl1}&tgl2=${tgl2}&kasir1=${$('#kasir1').val()}&kasir2=${$('#kasir2').val()}`, '_blank');
            }
            else{
                swal({
                    title: 'Kode kasir harus terisi semua atau tidak terisi sama sekali!',
                    icon: 'warning'
                });
            }
        }
    </script>

@endsection
