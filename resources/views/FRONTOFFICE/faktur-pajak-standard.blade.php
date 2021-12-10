@extends('navbar')
@section('title','FO | FAKTUR PAJAK STANDARD MEMBER MERAH NON PKP')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Faktur Pajak Standard Member Merah non PKP</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <label class="col-sm-2 text-right col-form-label">Periode Transaksi</label>
                            <input type="text" class="col-sm-2 form-control" id="periode" maxlength="7" placeholder="MM/YYYY" autocomplete="off">
                            <div class="col-sm"></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <button class="col-sm-2 btn btn-primary" onclick="createCSV()">CREATE CSV ALL</button>
                            <div class="col-sm"></div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCSV" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih CSV</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container" id="modalCSVBody">
                        <div class="row form-group">
                            <button class="mr-1 col-sm btn btn-primary" onclick="getCSV('FK')">

                            </button>
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
        $(document).ready(function(){
            $('#periode').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat : "mm/yy",
            });

            // $("#periode").datepicker( {
            //     dateFormat: 'mm/yy',
            //     changeMonth: true,
            //     changeYear: true,
            //     showButtonPanel: true,
            //
            //     onClose: function(dateText, inst) {
            //         var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            //         var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            //         $(this).val($.datepicker.formatDate('mm/yy', new Date(year, month, 1)));
            //     }
            // });
            //
            // $("#periode").focus(function () {
            //     $(".ui-datepicker-calendar").hide();
            //     $("#ui-datepicker-div").position({
            //         my: "center top",
            //         at: "center bottom",
            //         of: $(this)
            //     });
            // });
        });

        $('#periode').on('change',function(){
            checkDate();
        });

        function checkDate(){
            if($('#periode').val()){
                date = $('#periode').val().split('/');

                if(!(date[0] >=1 && date[0] <= 12)){
                    swal({
                        title: 'Periode tidak sesuai format',
                        icon: 'warning'
                    }).then(()=>{
                        $('#periode').select();
                    });
                    return false;
                }
                else return true;
            }
            else return false;
        }

        function createCSV(){
            if(checkDate()){
                swal({
                    title: 'Yakin ingin create CSV untuk periode '+$('#periode').val()+' ?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then(function(ok){
                    if(ok){
                        $.ajax({
                            url: '{{ url()->current() }}/create-csv',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: {
                                periode: $('#periode').val()
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                kodeigr = '{{ Session::get('kdigr') }}';
                                periode = $('#periode').val().split('/');
                                tipe = ['FK','LT','OB'];

                                $('#modalCSVBody div').remove();

                                $.each(tipe, function(key, value){
                                    $('#modalCSVBody').append(`
                                         <div class="row form-group">
                                            <button class="mr-1 col-sm btn btn-primary" onclick="getCSV('${value}')">
                                                ${value}${kodeigr}_${periode[1]}${periode[0]}.CSV
                                            </button>
                                        </div>
                                    `);
                                });

                                swal({
                                    title: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    $('#modal-loader').modal('hide');
                                    $('#modalCSV').modal('show');
                                });
                            },
                            error: function (error) {
                                swal({
                                    title: error.responseJSON.message,
                                    icon: 'error',
                                }).then(() => {
                                    $('#modal-loader').modal('hide');
                                });
                            }
                        });
                    }
                });
            }
        }

        function getCSV(tipe){
            window.open(`{{ url()->current() }}/get-csv?tipe=${tipe}&periode=${$('#periode').val()}`);
        }
    </script>

@endsection
