@extends('navbar')
@section('title','MASTER | MASTER KATEGORI TOKO')
@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body shadow-lg cardForm">
                        <div class="form-group row">
                            <label for="i_class_kodeigr" class="col-sm-3 col-form-label text-right">CLASS KODEIGR
                                &nbsp;</label>
                            <div class="row col-sm-9 border border-warning rounded"
                                 style="background-color: lightyellow">
                                <div class="row col-sm-12">
                                    @foreach($result as $data)
                                        <div class="custom-control custom-checkbox col-sm-4">
                                            <input type="checkbox" class="custom-control-input"
                                                   id="{{$data->cab_kodecabang}}">
                                            <label for="{{$data->cab_kodecabang}}" id="l_{{$data->cab_kodecabang}}"
                                                   class="custom-control-label lbl-cb">{{substr( $data->cab_namacabang,11,strlen($data->cab_namacabang))}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="i_kodekategoritoko" class="col-sm-3 col-form-label text-right">Kode Kategori
                                Toko</label>
                            <input type="text" class="col-sm-1 form-control" id="i_kodekategoritoko" placeholder="...">
                        </div>
                        <div class="form-group row">
                            <label for="i_keterangan" class="col-sm-3 col-form-label text-right">Keterangan</label>
                            <input style="text-transform: uppercase;" type="text" class="col-sm-5 form-control"
                                   id="i_keterangan" placeholder="...">
                        </div>

                        <div class="form-group row mt-3">
                            <div class="col-sm-3">
                                <button class="btn btn-outline-primary" id="btn-previous">PREV</button>
                                <button class="btn btn-outline-primary" id="btn-next">NEXT</button>
                            </div>
                            <div class="col-sm-2 offset-sm-5">
                                <button class="btn btn-primary btn-block" id="btn-new" onclick="new_record()">NEW
                                </button>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-primary btn-block" id="btn-save" onclick="save_record()">SAVE
                                </button>
                            </div>
                        </div>
                        <div class="mt-3 ml-3 p-0">
                            <i><p class="text-small p-0">last update : <span id="last_update"></span></p></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        .custom-checkbox {
            width: 24px;
            margin-top: 6px !important;
        }
    </style>

    <script>
        var count_data;
        var page = 1;
        var newr = 0;
        get_kategoritoko();
        $('#btn-next').on('click', function () {
            next_page();
            get_kategoritoko();
        });
        $('#btn-previous').on('click', function () {
            previous_page();
            get_kategoritoko();
        });

        function next_page() {
            newr = 0;
            page = page + 1;
            if (count_data < page) {
                page = 1;
            }
        }

        function previous_page() {
            newr = 0;
            page = page - 1;
            if (0 == page) {
                page = count_data;
            }
        }

        function get_kategoritoko() {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/getDataKtk',
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}"},
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    $('#i_kodekategoritoko').prop("disabled", true);
                    count_data = response.length;
                    clear_value();
                    $('#i_kodekategoritoko').val(response[page - 1].ktk_kodekategoritoko);
                    $('#i_keterangan').val(response[page - 1].ktk_keterangan);
                    if (response[page - 1].ktk_classkodeigr != null) {
                        var splitedData = response[page - 1].ktk_classkodeigr.split(",");
                        for (i = 0; i < splitedData.length; i++) {
                            $('#' + splitedData[i]).prop('checked', true);
                        }
                    }
                    console.log(response);
                    $('#last_update').text(response[page - 1].ktk_modify_dt);
                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0, 100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            });
        }

        function clear_value() {
            $("input:checkbox").prop('checked', false);
            $("input:text").val('');
        }

        function new_record() {
            $('#i_kodekategoritoko').prop("disabled", false);
            clear_value();
            newr = 1;
        }

        $(window).bind('keydown', function (event) {
            if (event.ctrlKey || event.metaKey) {
                if (String.fromCharCode(event.which).toLowerCase() === 's') {
                    save_record();
                    event.preventDefault();
                }
            }
            if (event.keyCode == 33) {
                $('#btn-next').click();
                event.preventDefault();
            }
            if (event.keyCode == 34) {
                $('#btn-previous').click();
                event.preventDefault();
            }
        });

        function save_record() {
            var kodeigr = [];
            var kodeigrString;
            var kodektk;
            var keterangan;
            $("input:checkbox").each(function () {
                var $this = $(this);
                if ($this.is(":checked")) {
                    kodeigr.push($this.attr("id"));
                }
            });
            kodeigrString = kodeigr.toString();
            kodektk = $('#i_kodekategoritoko').val();
            keterangan = $('#i_keterangan').val();


            $('.rounded').addClass('border-warning');
            $('.rounded').removeClass('border-danger');
            if (kodeigr == "") {
                $('.rounded').removeClass('border-warning');
                $('.rounded').addClass('border-danger');
                swal({
                    title: "Class KodeIGR Belum dipilih!",
                    icon: "warning"
                });
            } else if ($('#i_kodekategoritoko').val() == "") {
                swal({
                    title: "Kode Kategori Toko Belum diisi!",
                    icon: "warning"
                }).then((createData) => {
                    if (createData) {
                        $('#i_kodekategoritoko').select();
                    }
                });
            } else if ($('#i_keterangan').val() == "") {
                swal({
                    title: "Keterangan Belum diisi!",
                    icon: "warning"
                }).then((createData) => {
                    if (createData) {
                        $('#i_keterangan').select();
                    }
                });
            } else {
                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/saveDataKtk',
                    type: 'POST',
                    data: {
                        kodeigr: kodeigrString,
                        kodektk: kodektk,
                        keterangan: keterangan
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');
                        if (response == 'save') {
                            swal({
                                title: "Data Berhasil Tersimpan!",
                                icon: "success"
                            });
                        } else if (response == 'update') {
                            swal({
                                title: "Data Berhasil Terupdate!",
                                icon: "success"
                            });
                        } else {
                            swal({
                                title: "Data Gagal Tersimpan!",
                                icon: "warning"
                            });
                        }
                        if (newr == 1) {
                            page = count_data + 1;
                            newr = 0;
                        }
                        get_kategoritoko();
                    }, error: function (err) {
                        $('#modal-loader').modal('hide');
                        console.log(err.responseJSON.message.substr(0, 100));
                        alertError(err.statusText, err.responseJSON.message);
                    }
                });
            }
        }

        $("#i_keterangan").on('keyup', function () {
            $("#i_keterangan").val($("#i_keterangan").val().toUpperCase());
        })
    </script>

@endsection

