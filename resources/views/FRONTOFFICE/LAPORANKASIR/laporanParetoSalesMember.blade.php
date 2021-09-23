@extends('navbar')
@section('title','Laporan Kasir| Pareto Sales Member')
@section('content')


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-secondary">
                    <div class="card-body">

                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Tanggal</label>
                            <input type="text" class="form-control text-left col-sm-2 tgl" id="tgl_start" placeholder="dd/mm/yyyy">
                            <label class="col-sm-1 pt-1 text-center">s/d</label>
                            <input type="text" class="form-control text-left col-sm-2 tgl" id="tgl_end" placeholder="dd/mm/yyyy">
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Outlet</label>
                            <div class="col-sm-2 buttonInside pl-0">
                                <input type="text" class="form-control text-left" id="outlet_start" >
                                <button type="button" class="btn btn-primary btn-lov p-0" onclick="openModalOutlet('outlet_start')">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <label class="col-sm-1 pt-1 text-center">s/d</label>
                            <div class="col-sm-2 buttonInside p-0">
                                <input type="text" class="form-control text-left" id="outlet_end">
                                <button type="button" class="btn btn-primary btn-lov p-0" onclick="openModalOutlet('outlet_end')">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Member</label>
                            <div class="col-sm-2 buttonInside pl-0">
                                <input type="text" class="form-control text-left" id="member_start" >
                                <button type="button" class="btn btn-primary btn-lov p-0" onclick="openModalMember('member_start')">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <label class="col-sm-1 pt-1 text-center">s/d</label>
                            <div class="col-sm-2 buttonInside p-0">
                                <input type="text" class="form-control text-left" id="member_end" >
                                <button type="button" class="btn btn-primary btn-lov p-0" onclick="openModalMember('member_end')">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Rangking</label>
                            <input type="number" class="form-control text-right col-sm-2" id="rank_member">
                            <label class="col-sm-2 pt-1 text-center">member</label>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Limit</label>
                            <label class="col-sm-1 pt-1 text-right">Rp.</label>
                            <input type="text" class="form-control text-left col-sm-2" id="limit" onchange="changeLimit(this.value)">

                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Up/Under</label>
                            <div class="col-sm-2 buttonInside pl-0">
                                <select class="form-control" id="up_under">
                                    <option value="P">Up</option>
                                    <option value="R">Under</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Rangking By</label>
                            <div class="col-sm-2 buttonInside pl-0">
                                <select class="form-control" id="rank_by">
                                    <option value="0">All</option>
                                    <option value="1">Sales</option>
                                    <option value="2">Gross Margin</option>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Kosong : </label>
                            <label class="col-sm-3 col-form-label pl-0">Semua</label>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <button class="col-sm-2 btn btn-primary" onclick="cetakLaporan()">CETAK LAPORAN</button>
                            <div class="col-sm"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_help_outlet" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kode Outlet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalOutlet">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Outlet</th>
                                        <th>Nama Outlet</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($outlet as $data)
                                        <tr onclick="chooseOutlet({{$data->out_kodeoutlet}})"  class="row_lov">
                                            <td>{{$data->out_kodeoutlet}}</td>
                                            <td>{{$data->out_namaoutlet}}</td>
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

    <div class="modal fade" id="m_help_member" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kode Outlet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalMember">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Member</th>
                                        <th>Nama Member</th>
                                    </tr>
                                    </thead>
                                    <tbody> </tbody>
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
        let flagOpenModalOutlet;
        let flagOpenModalMember;
        let tableModal = $('#tableModalMember').DataTable();

        $(document).ready(function(){
            $('.tgl').datepicker({
                "dateFormat" : "dd/mm/yy",
            });

            $('#tableModalOutlet').DataTable();
            getDataLovMember()
        });

        function openModalOutlet(id){
            flagOpenModalOutlet = id;
            $('#m_help_outlet').modal('show');
        }

        function chooseOutlet(value){
            $('#m_help_outlet').modal('hide');
            $('#'+flagOpenModalOutlet).val(value)
        }

        function getDataLovMember(search){
            tableModal.destroy();
            tableModal =  $('#tableModalMember').DataTable({
                "ajax": {
                    'url' : '{{ url('/frontoffice/laporankasir/laporan-pareto-sales-by-member/get-lov-member') }}',
                    "data" : {search},
                },
                "columns": [
                    {data: 'cus_kodemember'},
                    {data: 'cus_namamember'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow modalMember');
                },
                columnDefs : [
                    // { targets : [2],
                    //     render : function (data, type, row) {
                    //         return formatDate(data, 'dd-mm-yy');
                    //     }
                    // }
                ],
                "order": []
            });

            $('#tableModalMember_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    getDataLovMember(val);
                }
            })
        }

        function openModalMember(id){
            flagOpenModalMember = id;
            $('#m_help_member').modal('show');
        }

        $(document).on('click', '.modalMember', function () {
            let value    = $(this).find('td')[0]['innerHTML']

            $('#m_help_member').modal('hide');
            $('#'+flagOpenModalMember).val(value)
        } );

        function changeLimit(value){
            $('#limit').val(convertToRupiah2(value))
        }

        function cetakLaporan(){
            let tgl_start       = $('#tgl_start').val();
            let tgl_end         = $('#tgl_end').val();
            let outlet_start    = $('#outlet_start').val();
            let outlet_end      = $('#outlet_end').val();
            let member_start    = $('#member_start').val();
            let member_end      = $('#member_end').val();
            let limit           = unconvertToRupiah($('#limit').val());
            let rank_member     = $('#rank_member').val();
            let up_under        = $('#up_under').val();
            let rank_by         = $('#rank_by').val();


            if (!tgl_start){
                swal("Tanggal 1 harus di isi", "", "info")
                $('#tgl_start').focus();
                return false;
            } else if (!tgl_end){
                let  date = new Date(), y = date.getFullYear(), m = date.getMonth();
                let lastDay =  new Date(y, m +1, 0).getDate() + '/' + m + '/' + y;
                $('#tgl_start').val(lastDay)
                $('#outlet_start').focus();
                return false;
            } else if (tgl_start > tgl_end) {
                swal("Tanggal 2 harus di isi >= tanggal 1", "", "info")
                $('#tgl_end').focus();
                return false;
            } else if (outlet_start > 6 && outlet_start < 0) {
                swal("Kode Outlet 1 Tidak Tersedia", "", "info")
                $('#outlet_start').val('')
                $('#outlet_start').focus()
                return false;
            }  else if (outlet_end > 6 || outlet_end < 0) {
                swal("Kode Outlet 2 Tidak Tersedia", "", "info")
                $('#outlet_end').val('')
                $('#outlet_end').focus()
                return false;
            } else if (outlet_end && outlet_start > outlet_end) {
                $('#outlet_end').val('');
                $('#outlet_end').focus();
                return false;
            } else if (member_start > member_end) {
                swal("Member 2 harus di isi >= Member 1", "", "info")
                $('#member_start').focus();
                return false;
            } else if (!limit) {
                swal("Limit harus di isi", "", "info")
                $('#limit').focus();
                return false;
            }

            window.open(`{{ url()->current() }}/cetak-laporan?tgl_start=${tgl_start}&tgl_end=${tgl_end}&outlet_start=${outlet_start}&outlet_end=${outlet_end}&member_start=${member_start}&member_end=${member_end}&limit=${limit}&rank_member=${rank_member}&up_under=${up_under}&rank_by=${rank_by}`);
        }


    </script>


@endsection
