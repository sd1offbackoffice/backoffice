@extends('navbar')
@section('title', 'Cetak Ulang Faktur Pajak')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
                    <div class="card-body">
                        <div class="row">
                            <label class="col-sm-3" for="npb1">Nomor NPB</label>
                            <input class="form-control col-sm-3" type="text" name="npb1" id="npb1" placeholder="NPB1">
                            <div class="input-group-append">
                                <button id="btn-no-doc" type="button" class="btn btn-lov p-0 ml-4" data-toggle="modal"
                                        data-target="#m_npb1" >
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            
                            <label class="col-sm-1" for="npb2">s/d</label>
                            <input class="form-control col-sm-3" type="text" name="npb2" id="npb2" placeholder="NPB2">
                            <div class="input-group-append">
                                <button id="btn-no-doc" type="button" class="btn btn-lov p-0 ml-4" data-toggle="modal"
                                        data-target="#m_npb2">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <label for="signedName" class="col-sm-3">Nama Penandatangan</label>
                            <input class="form-control col-sm-8" type="text" name="signedName" id="signedName" placeholder="TTD">
                        </div>
                        <div class="row mt-2">
                            <label class="col-sm-3" for="role">Jabatan</label>
                            <input class="form-control col-sm-8" type="text" name="role" id="role" placeholder="JBT">
                        </div>
                        <div class="row mt-2">
                            <label class="col-sm-3" for="role2">Jabatan 2</label>
                            <input class="form-control col-sm-8" type="text" name="role2" id="role2" placeholder="JBT2">
                        </div>
                        <div class="d-flex justify-content-end row mt-4 mr-4">
                            <button class="btn btn-success ml-2" type="submit" onclick="printDoc()">CETAK</button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{-- MODAL NPB 1 --}}
    <div class="modal fade" id="m_npb1" tabindex="-1" role="dialog" aria-labelledby="m_template" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Pengeluaran Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalNPB1">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>No Doc</th>
                                        <th>Tanggal Doc</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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
    {{-- MODAL NPB 2 --}}
    <div class="modal fade" id="m_npb2" tabindex="-1" role="dialog" aria-labelledby="m_template" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Pengeluaran Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalNPB2">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>No Doc</th>
                                        <th>Tanggal Doc</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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

    <script src={{asset('/js/sweetalert2.js')}}></script>
    <script>
        $(document).ready(function () {
            
            showDataNPB1('');
            // showDataNPB2('');
            var e = $.Event("keypress");
            e.keyCode = 13;

        });

        function showDataNPB1(value) {
            ajaxSetup();
            let tableModal = $('#tableModalNPB1').DataTable({
                "ajax": {
                    'type': "post",
                    'url': '{{ url()->current() }}/lov-search1',
                    "data": {
                        // '_token': '{{ csrf_token() }}',
                        'value': value
                    },
                },
                
                "columns": [
                    {data: 'msth_nodoc', name: 'msth_nodoc'},
                    {data: 'msth_tgldoc', name: 'msth_tgldoc'},
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
                columnDefs: [],
                "order": []
            })

            // $('#tableModalNPB1_filter input').off().on('keypress', function (e) {
            //     if (e.which == 13) {
            //         let val = $(this).val().toUpperCase();

            //         tableModal.destroy();
            //         showDataNPB1(val);
            //     }
            // })
        }

        function showDataNPB2(value) {
            ajaxSetup();
            let tableModal = $('#tableModalNPB2').DataTable({
                "ajax": {
                    'type': "post",
                    'url': '{{ url()->current() }}/lov-search2',
                    "data": {
                        // '_token': '{{ csrf_token() }}',
                        'value': value
                    },
                },
                
                "columns": [
                    {data: 'msth_nodoc', name: 'msth_nodoc'},
                    {data: 'msth_tgldoc', name: 'msth_tgldoc'},
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
                columnDefs: [],
                "order": []
            })
        }

        $('#tableModalNPB1 tbody').on('click', '.modalRow', function () {
            // $('#npb1').val('');
            let table = $('#tableModalNPB1').DataTable();
            let selectedNPB1 = table.row(this).data().msth_nodoc;
            $('#npb1').val(selectedNPB1);
            
            showDataNPB2(selectedNPB1);

            $('#m_npb1').modal('hide');
            // console.log($('#npb1').val());
        });

        $('#tableModalNPB2 tbody').on('click', '.modalRow', function () {
            // $('#npb1').val('');
            let table = $('#tableModalNPB2').DataTable();
            let selectedNPB2 = table.row(this).data().msth_nodoc;
            $('#npb2').val(selectedNPB2);

            $('#m_npb2').modal('hide');
            // checkData();
            // console.log($('#npb1').val());
        });

        function printDoc() {
            let npb1 = $('#npb1').val();
            let npb2 = $('#npb2').val();
            let signedName = $('#signedName').val();
            let role1 = $('#role').val();
            let role2 = $('#role2').val();

            if (!npb1 || !npb2) {
                swal.fire('Nomor NPB Harus Terisi')
                return;
            }
            if (npb1 > npb2) {
                swal.fire('Range Nomor NPB salah')
                return;
            }
            if (!signedName) {
                swal.fire('Nama Penandatangan Harus Terisi')
                return;
            }
            if (!role) {
                swal.fire('Jabatan Harus Terisi')
                return;
            }
            if (!role2) {
                swal.fire('Jabatan 2 Harus Terisi')
                return;
            }

            ajaxSetup();
            $.ajax({
                type: "get",
                url: "{{ url()->current() }}/check-data",
                data: {
                    npb1:npb1,
                    npb2:npb2
                },
                beforeSend: function () {
                    $('#modal-loader').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                },
                success: function (res) {
                    if (res.status === 'FAILED') {
                        swal.fire('', "Tidak ada data", 'warning');
                        return;
                    }

                    let datas = res.datas;
                    let concatData = '';
                    for (let i = 0; i < datas.length; i++) {
                        if (i === datas.length - 1) {
                            concatData += datas[i].msth_nodoc;
                        } else {
                            concatData += datas[i].msth_nodoc + ', ';
                        }
                    }

                    console.log(concatData);
                    window.open(`{{ url()->current() }}/print-doc?concatData=${concatData}&npb1=${npb1}&npb2=${npb2}&signedName=${signedName}&role1=${role1}&role2=${role2}`);

                    $('#modal-loader').modal('hide');
                }
            });
        }
    </script>
@endsection