@extends('navbar')
@section('content')

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <fieldset class="card">
                    <legend  class="w-auto ml-5">Master Cabang Form</legend>
                    <div class="card-body cardForm">
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="">Kode Cabang</label>
                                    <div class="row">
                                        <input type="text" class="field field1 col-sm-3 form-control ml-3" id="i_kodeCabang" placeholder="..." field="1">
                                        <button class="btn ml-2" type="button" data-toggle="modal" data-target="#m_kodecabangHelp"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Nama Cabang</label>
                                    <input type="text" class="field field2 form-control" id="i_namaCabang" placeholder="..." field="2">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-4">
                                    <label for="">Alamat</label>
                                    <input type="text" class="field field3 form-control" id="i_alamat1" placeholder="..."  field="3">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for=""> </label>
                                    <input type="text" class="field field4 form-control mt-2" id="i_alamat2" placeholder="..."  field="4">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for=""></label>
                                    <input type="text" class="field field5 form-control mt-2" id="i_alamat3" placeholder="..."  field="5">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-4">
                                    <label for="">Telephone</label>
                                    <input type="text" class="field field6 form-control" id="i_telephone" placeholder="..."  field="6">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">FAXIMILE</label>
                                    <input type="text" class="field field7 form-control" id="i_faximile" placeholder="..."  field="7">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">N.P.W.P.</label>
                                    <input type="text" class="field field8 form-control" id="i_npwp" placeholder="..." field="8">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-4">
                                    <label for="">No. SK</label>
                                    <input type="text" class="field field9 form-control" id="i_noSK" placeholder="..." field="9">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="">Tgl. SK</label>
                                    <input type="text" class="field field10 form-control" id="i_tglSK" placeholder="..." field="10">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-3">
                                    <label for="">Kode Anak Cabang</label>
                                    <div class="row">
                                        <input type="text" class="field field11 col-sm-3 form-control ml-3" id="i_kodeAnakCabang" placeholder="..." field="11">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">Nama Anak Cabang</label>
                                    <input type="text" class="field field12 form-control" id="i_namaAnakCabang" placeholder="..." field="12">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-4 offset-sm-8">
                                    <button type="button" class="btn btnOKC" onclick="trfDataAnakCab()">Trf Data Aak Cabang</button>
                                    <button type="button" class="field field13 btn btn-primary" onclick="editBranch()" field="13">Submit</button>
                                    {{--<button type="button" class="field field13 btn btnSubmit" onclick="editBranch()" field="13">Submit</button>--}}
                                </div>
                            </div>
                        </form>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="m_kodecabangHelp" tabindex="-1" role="dialog" aria-labelledby="m_kodecabangHelp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th>Nama Cabang</th>
                                        <th>Kode Cabang</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($getCabang as $data)
                                        <tr onclick='chooseBranch("{{$data->cab_kodecabang}}")' class="modalRowBranch">
                                            <td>{{$data->cab_kodecabang}}</td>
                                            <td>{{$data->cab_namacabang}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
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


    <style>
            body {
                background-color: #edece9;
                /*background-color: #ECF2F4  !important;*/
            }

            label {
                color: #232443;
                /*color: #8A8A8A;*/
                font-weight: bold;
            }

            .btnOKC{
                border-color: #6c757d;
            }

            .btnSubmit {
                background-color: #535353;
                color: white;
            }

            .btnSubmit:hover{
                background-color: #464545;
                color: white;
                border-color: #535353;
            }

            .modalRowBranch:hover{
                cursor: pointer;
                background-color: #acacac;
            }

        </style>


    <script>
        var globalVar = 0;
        $(document).ready(function () {

        });

        $(document).on('keypress', '.field', function (e) {
            if(e.which == 13) {
                e.preventDefault();
                var field   = $(this).attr('field');
                var target  = 'field'+(parseInt(field)+1);
                $('.'+target).focus();
            }
        });

        $(document).on('keypress', '#i_kodeCabang', function (e) {
            if(e.which == 13) {
                e.preventDefault();
                let kodeigr = $('#i_kodeCabang').val();
                let proses = chooseBranch(kodeigr);
            }
        });

        function trfDataAnakCab() {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/mstcabang/trfdataanakcab',
                type: 'post',
                data: {},
                success: function (result) {
                    console.log(result);
                    if (result.kode === 1){
                        swal("SUKSES",result.msg, "success");
                    } else {
                        swal("Error",result.msg, "error");
                    }
                }, error: function () {

                }
            })
        }

        function clearField() {
            $('#i_namaCabang').val('');
            $('#i_alamat1').val('');
            $('#i_alamat2').val('');
            $('#i_alamat3').val('');
            $('#i_telephone').val('');
            $('#i_faximile').val('');
            $('#i_npwp').val('');
            $('#i_noSK').val('');
            $('#i_tglSK').val('');
            $('#i_kodeAnakCabang').val('');
            $('#i_namaAnakCabang').val('');
        }

        function chooseBranch(kodeigr) {
            $('#m_kodecabangHelp').modal('hide');
            clearField()

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/mstcabang/getdetailcabang',
                type: 'post',
                data:{kodeigr:kodeigr},
                success: function (result) {
                    let data = result[0];

                    if (!data){
                        swal({
                            title: "Create New Data?",
                            text: "Data Cabang tidak terdaftar",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        }).then((createData) => {
                            if (createData) {
                                clearField();
                                $('#i_namaCabang').focus();
                                globalVar = 1;
                            } else {
                                $('#i_kodeCabang').val('');
                                clearField();
                                $('#i_kodeCabang').focus();
                            }
                        });
                    } else {
                        $('#i_kodeCabang').val(data.cab_kodecabang);
                        $('#i_namaCabang').val(data.cab_namacabang);
                        $('#i_alamat1').val(data.cab_alamat1);
                        $('#i_alamat2').val(data.cab_alamat2);
                        $('#i_alamat3').val(data.cab_alamat3);
                        globalVar = 0;
                    }
                }, error: function () {
                    swal("Error","", "error");
                }
            });
        }

        function editBranch() {
            if (globalVar === 1){
                var title = "Create Data?"
            } else {
                title = "Edit Data?"
            }

            swal({
                title: title,
                text: "Data Cabang tetap bisa diedit setelah di simpan",
                icon: "info",
                buttons: true,
                dangerMode: true,
            }).then((editData) => {
                if (editData) {
                    ajaxSetup();
                    $.ajax({
                        url: '/BackOffice/public/mstcabang/editdatacabang',
                        type: 'post',
                        data:{
                            kodeigr     : $('#i_kodeCabang').val(),
                            namacabang  : $('#i_namaCabang').val(),
                            alamat1     : $('#i_alamat1').val(),
                            alamat2     : $('#i_alamat2').val(),
                            alamat3     : $('#i_alamat3').val(),
                            telephone   : $('#i_telephone').val(),
                            faximile    : $('#i_faximile').val(),
                            npwp        : $('#i_npwp').val(),
                            nosk        : $('#i_noSK').val(),
                            tgksk       : $('#i_tglSK').val(),
                            kodeanakcab : $('#i_kodeAnakCabang').val(),
                            namaanakcab : $('#i_namaAnakCabang').val(),
                        },
                        success: function (result) {
                            swal({
                                icon: 'success',
                                title: result,
                                showConfirmButton: false,
                                timer: 2000
                            });
                            $('#i_kodeCabang').val('');
                            clearField();
                            $('#i_kodeCabang').focus();
                        }, error: function () {
                            swal("Error","", "error");
                        }
                    })
                } else {
                    console.log('Data tidak disimpan');
                }
            });
        }

    </script>


@endsection
