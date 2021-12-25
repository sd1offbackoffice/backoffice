@extends('navbar')

@section('title','BO | LAPORAN PER KATEGORI PRODUK')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">LAPORAN SALES PER KATEGORI PRODUK</legend>
                    <div class="card-body ">
                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">MEMBER</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="member">
                                    <option value="ALL">ALL</option>
                                    <option value="Y">KHUSUS</option>
                                    <option value="">BIASA</option>
                                </select>
                            </div>
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">OUTLET</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="outlet">
                                    <option value="ALL">ALL</option>
                                    @foreach($outlet as $o)
                                        <option value="{{$o->out_kodeoutlet}}">{{$o->out_namaoutlet}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">GROUP</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="group">
                                    <option value="ALL">ALL</option>
                                    @foreach($group as $g)
                                        <option value="{{$g->jm_kode}}">{{$g->jm_keterangan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">SUBOUTLET</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="suboutlet">
                                    <option value="ALL">ALL</option>
                                    @foreach($suboutlet as $so)
                                        <option value="{{$so->sub_kodesuboutlet}}">{{$so->sub_namasuboutlet}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">Tanggal</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggal" id="tanggal-1"
                                       value="{{$selected_tanggal1}}">
                            </div>
                            <label class="col-sm-2 pt-1 text-center">s/d</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggal" id="tanggal-2"
                                       value="{{$selected_tanggal2}}">
                            </div>

                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">DIV</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="divisi">
                                    <option value="ALL">ALL</option>
                                    @foreach($divisi as $div)
                                        <option value="{{$div->div_kodedivisi}}">{{$div->div_namadivisi}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">DEPT</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="departemen">
                                    <option value="ALL">ALL</option>
                                    @foreach($departement as $dep)
                                        <option value="{{$dep->dep_kodedepartement}}">{{$dep->dep_namadepartement}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">SEGMENTASI</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="segmentasi">
                                    <option value="ALL">ALL</option>
                                    @foreach($segmentasi as $seg)
                                        <option value="{{$seg->seg_id}}">{{$seg->seg_nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">KAT</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="kategori">
                                    <option value="ALL">ALL</option>
                                    @foreach($kategori as $kat)
                                        @if($selected_kat == $kat->kat_namakategori)
                                            <option selected
                                                    value="{{$kat->kat_kodekategori}}">{{$kat->kat_namakategori}}</option>
                                        @else
                                            <option
                                                value="{{$kat->kat_kodekategori}}">{{$kat->kat_namakategori}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="float-left col-sm-3">
                                <button class="col btn btn-danger" id="btn-reset" onclick="reloadPage()">Reset
                                </button>
                            </div>
                            <div class="col-sm-3 offset-3">
                                <button class="col btn btn-primary" id="btn-show-report" onclick="showReport()">Lihat Laporan
                                </button>
                            </div>
                            <div id="col-btn-print" class="col-sm-3">
                                <button class="col btn btn-primary" id="btn-print" onclick="printReport()">Cetak
                                </button>
                            </div>
                            <div class="btn-group col-sm-3" role="group" id="btn-group-extension"
                                 style="display: none;">
                                <button type="button" id="btn-export-csv"
                                        class="btn btn-success">
                                    <i class="fas fa-file-csv nav-icon"></i> CSV
                                </button>
                                <button type="button" id="btn-export-pdf"
                                        class="btn btn-danger">
                                    <i class="fas fa-file-pdf nav-icon"></i> PDF
                                </button>
                            </div>

                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <br>
    <div class="container" id="second_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3"></legend>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col">
                                <table class="table table-sm" id="tableData">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th></th>
                                        <th>PLU</th>
                                        <th>Qty</th>
                                        <th>Sales</th>
                                        <th>Margin</th>
                                        <th>Margin %</th>
                                        <th>Const. Sls</th>
                                        <th>Const. Mrg</th>
                                        <th>Jumlah Member</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </fieldset>

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
            font-weight: bold;
        }

        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .row_lov:hover {
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 400px;
            overflow-y: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        .clicked, .row-detail:hover {
            background-color: grey !important;
            color: white;
        }

        .ui-datepicker-calendar {
            display: none;
        }
    </style>

    <script>
        $(document).ready(function () {
            $('.tanggal').datepicker({
                "dateFormat": "dd/mm/yy",
            });

            if ($('#tanggal-1').val() == '') {
                $('.tanggal').datepicker('setDate', new Date());
            }

            $('#tableData').DataTable();
            if ($('#kategori').val() != 'ALL') {
                getData();
            }
        });

        $('.tanggal').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('.tanggal').on('apply.daterangepicker', function (ev, picker) {
            $('#tanggal-1').val(picker.startDate.format('DD/MM/YYYY'));
            $('#tanggal-2').val(picker.endDate.format('DD/MM/YYYY'));
        });
        $('.tanggal').on('cancel.daterangepicker', function (ev, picker) {
            $('#tanggal-1').val('');
            $('#tanggal-2').val('');
        });
        // $(document).on('click', '#lihat', function () {
        //     val = $(this).val();
        //     if ($(this).prop('checked') == true) {
        //         checked.push(val);
        //     } else {
        //         const index = checked.indexOf(val);
        //         if (index > -1) {
        //             checked.splice(index, 1);
        //         }
        //     }
        // });
        function reloadPage() {
            window.location = `{{ url()->current() }}`;
        }
        function showReport() {
            getData();
        }

        function printReport() {
            $('#col-btn-print').hide();
            $('#btn-group-extension').show(250);
        }

        $('#btn-export-csv, #btn-export-pdf').on('click', function () {
            var currentButton = $(this);
            var buttonName = '';
            var jenislaporan = '';

            if (currentButton.attr('id') === 'btn-export-csv') {
                jenislaporan = 'csv';
            } else {
                jenislaporan = 'pdf';
            }
            $('#btn-group-extension').hide();
            $('#col-btn-print').show(250);

            window.open(`{{ url()->current() }}/cetak?jenislaporan=${jenislaporan}&member=${$('#member').val()}&group=${$('#group').val()}&segmentasi=${$('#segmentasi').val()}&outlet=${$('#outlet').val()}&suboutlet=${$('#suboutlet').val()}&tanggal1=${$('#tanggal-1').val()}&tanggal2=${$('#tanggal-2').val()}&divisi=${$('#divisi').val()}&departemen=${$('#departemen').val()}&kategori=${$('#kategori').val()}`, '_blank');

        });

        function getData() {
            $(document).find('select').prop('disabled',true);
            $(document).find('input').prop('disabled',true);
            $('#btn-show-report').prop('disabled',true);
            if ($.fn.DataTable.isDataTable('#tableData')) {
                $('#tableData').DataTable().destroy();
            }
            // $('#tableData').DataTable().clear().draw();

            var columns = [
                {
                    title: '',
                    target: 0,
                    className: 'treegrid-control',
                    data: function (item) {
                        if (item.children) {
                            return '<span>+</span>';
                        }
                        return '';
                    }
                },
                {
                    title: 'PLU',
                    target: 1,
                    data: function (item) {
                        return item.nama;
                    }
                },
                {
                    title: 'Qty',
                    target: 2,
                    data: function (item) {
                        return item.qty;
                    }
                },
                {
                    title: 'Sales',
                    target: 3,
                    data: function (item) {
                        return item.sales;
                    }
                },
                {
                    title: 'Margin',
                    target: 4,
                    data: function (item) {
                        return item.margin;
                    }
                },
                {
                    title: 'Margin %',
                    target: 5,
                    data: function (item) {
                        return item.marginpersen;
                    }
                },
                {
                    title: 'Const. Sls',
                    target: 6,
                    data: function (item) {
                        return item.constsales;
                    }
                },
                {
                    title: 'Const. Mrg',
                    target: 7,
                    data: function (item) {
                        return item.constmargin;
                    }
                },
                {
                    title: 'Jumlah Member',
                    target: 8,
                    data: function (item) {
                        return item.jmlmember;
                    }
                },

            ];
            tableData = '';
            tableData = $('#tableData').DataTable({
                "ajax": {
                    'url': '{{ url()->current().'/get-data' }}',
                    "data": {
                        member: $('#member').val(),
                        group: $('#group').val(),
                        segmentasi: $('#segmentasi').val(),
                        outlet: $('#outlet').val(),
                        suboutlet: $('#suboutlet').val(),
                        tanggal1: $('#tanggal-1').val(),
                        tanggal2: $('#tanggal-2').val(),
                        divisi: $('#divisi').val(),
                        departemen: $('#departemen').val(),
                        kategori: $('#kategori').val(),
                    },
                },
                "columns": columns,
                'treeGrid': {
                    'left': 10,
                    'expandIcon': '<span>+</span>',
                    'collapseIcon': '<span>-</span>'
                },
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    if (!data.children) {
                        $(row).addClass('child');
                    }
                },
                "columnDefs": [
                    {
                        targets: [2],
                        className: 'text-right',
                        render: function (data, type, row) {
                            return convertToRupiah2(data)
                        }
                    },
                    {
                        targets: [3],
                        className: 'text-right',
                        render: function (data, type, row) {
                            return convertToRupiah2(data)
                        }
                    },
                    {
                        targets: [4],
                        className: 'text-right',
                        render: function (data, type, row) {
                            return convertToRupiah2(data)
                        }
                    },
                    {
                        targets: [5],
                        className: 'text-right',
                    },
                    {
                        targets: [6],
                        className: 'text-right',
                    },
                    {
                        targets: [7],
                        className: 'text-right',
                    },
                    {
                        targets: [8],
                        className: 'text-right',
                        render: function (data, type, row) {
                            return convertToRupiah2(data)
                        }
                    }
                ],
                "order": []
            });
        }

        $(document).on('click', '.child', function () {
            var currentButton = $(this);
            var plu = currentButton.find('td').eq(1).text();
            var tanggal1 = $('#tanggal-1').val();
            var tanggal2 = $('#tanggal-2').val();
            window.open(`{{ url()->current() }}/../laporan-sales-per-produk-member?plu=${plu}&tanggal1=${tanggal1}&tanggal2=${tanggal2}`, '_blank');
        });
    </script>

@endsection
