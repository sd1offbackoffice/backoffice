@extends('navbar')
@section('title','MASTER | MASTER CABANG')
@section('content')

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="">Kode Cabang</label>
                                    <div class="row">
                                        <div class="col-sm-5 buttonInside" >
                                            <input type="text" class="field field1 form-control " id="i_kodeCabang" placeholder="..." field="1">
                                            <button id="btn-no-doc" type="button" class="btn btn-lov p-0" data-toggle="modal" data-target="#m_kodecabangHelp">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
{{--                                        <input type="text" class="field field1 col-sm-3 form-control ml-3" id="i_kodeCabang" placeholder="..." field="1">--}}
{{--                                        <button class="btn ml-2" type="button" data-toggle="modal" data-target="#m_kodecabangHelp"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>--}}
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
                                    <input type="text" id="i_tglSK" class="field field10  form-control tanggal" field="10">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-3">
                                    <label for="">Kode Cabang Anak</label>
                                    <div class="row">
                                        <input type="text" class="field field11 col-sm-3 form-control ml-3" id="i_kodeAnakCabang" placeholder="..." field="11">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">Nama Cabang Anak</label>
                                    <input type="text" class="field field12 form-control" id="i_namaAnakCabang" placeholder="..." field="12">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-3 offset-sm-6">
                                    <button type="button" class="btn btnOKC btn-block btn-primary" onclick="trfDataAnakCab()">Trf Data Cabang Anak</button>
                                </div>
                                <div class="form-group col-sm-3">
                                    <button type="button" class="field field13 btn btn-primary btn-block" onclick="editBranch()" field="13">Edit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="m_kodecabangHelp" tabindex="-1" role="dialog" aria-labelledby="m_kodecabangHelp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Cabang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="table_cabang">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Cabang</th>
                                        <th>Kode</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($getCabang as $data)
                                        <tr onclick='chooseBranch("{{$data->cab_kodecabang}}")' class="row_lov">
                                            <td>{{$data->cab_namacabang}}</td>
                                            <td>{{$data->cab_kodecabang}}</td>
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


    <script>
        var globalVar = 0;

        $(document).ready(function () {
            $('.tanggal').datepicker({
                "dateFormat" : "dd/mm/yy"
            });

            $('#table_cabang').dataTable();
            chooseBranch('01');
        });

        $(document).on('focus', 'input', function (e) {
            if ($(this).attr('id') == 'i_kodeCabang'){
                $('.field13').text('Edit')
            } else {
                $('.field13').text('Simpan')
            }
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

        $(window).bind('keydown', function(event) {
            if (event.ctrlKey || event.metaKey) {
                if(String.fromCharCode(event.which).toLowerCase() === 's'){
                    event.preventDefault();
                   editBranch()
                }
            }
        });

        function trfDataAnakCab() {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/trfdataanakcab',
                type: 'post',
                data: {},
                beforeSend : () => {
                    $('#modal-loader').modal('show');
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    if (result.kode === 1){
                        swal("SUKSES",result.msg, "success");
                    } else {
                        swal("Error",result.msg, "error");
                    }
                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
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
                url: '{{ url()->current() }}/getdetailcabang',
                type: 'post',
                data:{kodeigr:kodeigr},
                beforeSend : function (){
                    $('#modal-loader').modal('show');
                }, success: function (result) {
                    $('#modal-loader').modal('hide');
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
                        $('#i_telephone').val(data.cab_teleponcabang);
                        $('#i_faximile').val(data.cab_faxcabang);
                        $('#i_npwp').val(data.cab_npwpcabang);
                        $('#i_noSK').val(data.cab_nosk);
                        $('#i_tglSK').val((data.cab_tglsk) ? formatDate(data.cab_tglsk) : data.cab_tglsk);
                        $('#i_kodeAnakCabang').val(data.cab_kodecabang_anak);
                        $('#i_namaAnakCabang').val(data.cab_namacabang_anak);
                        $('#i_kodeCabang').focus();
                        globalVar = 0;
                    }
                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            });
        }

        function editBranch() {
            let btnText = $('.field13').text();

            if (btnText == 'Edit'){
                $('#i_namaCabang').focus();
                return false;
            }


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
                        url: '{{ url()->current() }}/editdatacabang',
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
                        }, beforeSend : function (){
                            $('#modal-loader').modal('show');
                        }, success: function (result) {
                            $('#modal-loader').modal('hide');
                            swal({
                                icon: 'success',
                                title: result,
                                showConfirmButton: false,
                                timer: 2000
                            });
                            $('#i_kodeCabang').val('');
                            clearField();
                            $('#i_kodeCabang').focus();
                        }, error: function (err) {
                            $('#modal-loader').modal('hide');
                            console.log(err.responseJSON.message.substr(0,100));
                            alertError(err.statusText, err.responseJSON.message);
                        }
                    })
                } else {
                    console.log('Data tidak disimpan');
                }
            });
        }

    </script>


@endsection
