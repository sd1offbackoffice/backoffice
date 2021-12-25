@extends('navbar')
@section('title','LAPORAN KASIR | DAFTAR MEMBER TIDAK AKTIF')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-5">Daftar Member Tidak Aktif</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <label class="col-sm-3 text-right">Mulai Kode</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="bigGuy form-control" id="mulai" readonly>
                                <button id="btn-no-doc" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                        data-target="#m_lov_member" onclick="setObj('mulai')">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="bigGuy form-control" id="mulai-nama" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right">Sampai Kode</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="bigGuy form-control" id="sampai" readonly>
                                <button id="btn-no-doc" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                        data-target="#m_lov_member" onclick="setObj('sampai')">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="bigGuy form-control" id="sampai-nama" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right">Sort by</label>
                            <div class="col-sm-7">
                                <select class="form-control" id="sort">
                                    <option value="1">OUTLET + AREA + KODE</option>
                                    <option value="2">OUTLET + AREA + NAMA</option>
                                    <option value="3">OUTLET + KODE</option>
                                    <option value="4">OUTLET + NAMA</option>
                                    <option value="5">AREA + KODE</option>
                                    <option value="6">AREA + NAMA</option>
                                    <option value="7">KODE</option>
                                    <option value="8">NAMA</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="offset-8 col-sm-2">
                                <button class="btn btn-primary btn-block" onclick="cetak()">Cetak</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_member" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_member">
                                    <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    </tbody>
                                    <tfoot></tfoot>
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
        input[type=date]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .modal tbody tr:hover {
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .btn-lov-cabang {
            position: absolute;
            bottom: 10px;
            right: 3vh;
            border: none;
            height: 30px;
            width: 30px;
            border-radius: 100%;
            outline: none;
            text-align: center;
            font-weight: bold;
        }

        .btn-lov-cabang:focus,
        .btn-lov-cabang:active {
            box-shadow: none !important;
            outline: 0px !important;
        }

        .btn-lov-plu {
            position: absolute;
            bottom: 10px;
            right: 2vh;
            border: none;
            height: 30px;
            width: 30px;
            border-radius: 100%;
            outline: none;
            text-align: center;
            font-weight: bold;
        }

        .btn-lov-plu:focus,
        .btn-lov-plu:active {
            box-shadow: none !important;
            outline: 0px !important;
        }

        .modal thead tr th {
            vertical-align: middle;
        }
    </style>

    <script>

        var obj;
        $(document).ready(function () {
            getLovMember('');
        });

        function getLovMember(val) {
            if ($.fn.DataTable.isDataTable('#table_lov_member')) {
                $('#table_lov_member').DataTable().destroy();
            }
            table_lov_member = $('#table_lov_member').DataTable({
                "ajax": {
                    url: '{{ url()->current() }}/get-lov-member',
                    data: {
                        search: val,
                    },
                },
                "columns": [
                    {data: 'cus_kodemember'},
                    {data: 'cus_namamember'},
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
                    $(row).addClass('modalRowMember');
                },
                "order": [],
                "columnDefs": [
                    {
                        targets: [1],
                        className: 'text-left'
                    },
                ],
                "initComplete": function () {
                    $(document).on('click', '.modalRowMember', function (e) {
                        $('#' + obj).val($(this).find('td:eq(0)').html());
                        $('#' + obj + '-nama').val($(this).find('td:eq(1)').html());
                        $('#m_lov_member').modal('hide');
                    });
                }
            });

            $('#table_lov_member_filter input').val().focus();

            $('#table_lov_member_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    tableLovNodoc.destroy();
                    getLovNodoc($(this).val().toUpperCase());
                }
            });
        }

        function setObj(value) {
            obj = value;
        }

        function cetak() {
            mulai = $("#mulai").val()
            sampai = $("#sampai").val()
            sort = $("#sort").val()
            if (mulai > sampai) {
                swal('Error', 'Kode member terbalik!', 'error');
            }else {
                window.open(`{{ url()->current() }}/cetak?mulai=${mulai}&sampai=${sampai}&sort=${sort}`, '_blank');
            }
        }
    </script>

@endsection
