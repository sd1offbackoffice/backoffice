@extends('navbar')
@section('title','PENERIMAAN | BARCODE PUTIH')
@section('content')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-dark">                  
                    <div class="card-body">
                        <h4 class="card-title">Barcode Putih</h4>
                        
                        <div class="row">
                            <div class="col-md-6 justify-content-center">
                                {{-- <div class="row form-group">
                                    <label class="col-md-2 col-form-label text-right">Tanggal</label>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" id="startDate" value="{{\Carbon\Carbon::today()->format('Y-m-d')}}">
                                    </div>
                                    <label class="col-md-1 col-form-label text-center">s/d</label>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" id="endDate" value="{{\Carbon\Carbon::today()->format('Y-m-d')}}">
                                    </div>
                                </div> --}}
                                <div class="row form-group">
                                    <label class="col-md-2 col-form-label text-right">No Faktur</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="noFaktur" name="noFaktur">
                                    </div>
                                    <div class="input-group-append">
                                        <button id="btn-no-doc" type="button" class="btn btn-lov p-0 ml-4" data-toggle="modal"
                                                data-target="#m_faktur">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary" onclick="saveDataBarcode()">SIMPAN DATA UNTUK PRINT</button>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table" id="pluTable" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>PLU</th>
                                            <th>DESKRIPSI</th>
                                            {{-- <th>UNIT</th>
                                            <th>FRAC</th> --}}
                                            {{-- <th>CTN</th> --}}
                                            {{-- <th>BOX</th> --}}
                                            <th>QTY</th>                                            
                                            <th>KETERANGAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        

                        {{-- <fieldset class="card border-secondary">
                            <legend class="ml-2">Surat Jalan/Faktur</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="tableFixedHeader col-sm-12 text-center">
                                        <table class="table table-sm" id="tableSJF">
                                            <thead>
                                            <tr>
                                                <th id="nomor">NOMOR DOKUMEN</th>
                                                <th>TANGGAL</th>
                                                <th><i class="fas fa-check"></i></th>
                                            </tr>
                                            </thead>
                                            <tbody id="tBodySJFTable"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </fieldset>                                                 --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_faktur" tabindex="-1" role="dialog" aria-labelledby="m_template" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar No Faktur Penerimaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table" id="tableSJF">
                                    <thead class="thead-dark theadDataTables">
                                    <tr>
                                        <th>No Faktur</th>
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

    <script>
        let nodocs = []
        let plus = []
        let plu_datas = []
        let notExistsInMasterKlaim = []
        let existsInMasterKlaim = []
        let existsInMasterBarcode = []
        let printData = []
        // let existsPluMasterKlaimBarcode = []
        $(document).ready(function () {
            $('#pluTable').DataTable()
            showSJFData()
        })        

        function showSJFData(){
            $('#tableSJF').DataTable().destroy();

            ajaxSetup()
            $('#tableSJF').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/show-sjf-data'                    
                },
                "columns": [
                    {data: 'mstd_nofaktur', name: 'mstd_nofaktur'},
                    {data: 'mstd_tgldoc', name: 'mstd_tgldoc'},
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

        $('#tableSJF tbody').on('click', '.modalRow', function () {
            // $('#npb1').val('');
            let table = $('#tableSJF').DataTable();            
            let selectedNoFaktur = table.row(this).data().mstd_nofaktur;
            $('#noFaktur').val(selectedNoFaktur);
            
            checkNoFaktur()

            $('#m_faktur').modal('hide');
            // console.log($('#npb1').val());
        });

        $('#noFaktur').keypress(function (e) { 
            if (e.keyCode == 13) {
                // showDataToTable()
                checkNoFaktur()
                // showDataToTable()
                // showDataToTable()
                // console.log('test');
            }
        });

        function checkNoFaktur() {
            let noFaktur = $('#noFaktur').val()  
            plu_datas = []
            notExistsInMasterKlaim = []
            existsInMasterKlaim = []
            existsInMasterBarcode = []
            printData = []
            // $('#pluTable').DataTable().destroy()        

            ajaxSetup()
            $.ajax({
                type: "GET",
                url: "{{ url()->current() }}/check-no-faktur",
                async: false,
                data: {
                    noFaktur: noFaktur
                },
                beforeSend: function () {
                    $('#modal-loader').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                    // $('#modal-loader').modal('show')
                },
                success: function (res) {
                    $('#modal-loader').modal('hide');

                    if (res.status = 'SUCCESS') {
                        // console.log(res.data);
                        res.data.forEach(data => {
                            // plu_datas.push(data)
                            checkPluBarcode(data)
                        })
                        // plu_datas = res.data.plu_datas
                        // existsInMasterBarcode = res.data.existsInMasterBarcode
                        // existsInMasterKlaim = res.data.existsInMasterKlaim
                        // notExistsInMasterKlaim = res.data.notExistsInMasterKlaim
                        showDataToTable()
                    }
                    // showDataToTable(); 
                    // plu_datas = res.data.plu_datas;
                    // existsInMasterBarcode = res.data.existsInMasterBarcode;
                    // existsInMasterKlaim = res.data.existsInMasterKlaim;
                    // notExistsInMasterKlaim = res.data.notExistsInMasterKlaim;
                    // // console.log(plu_datas);
                    // $('#pluTable').DataTable().destroy() 
                    // $('#pluTable').DataTable({
                    //     data: res.data.plu_datas,
                    //     columns: [
                    //         {data: 'mstd_prdcd', name: 'mstd_prdcd'},
                    //         {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                    //         {data: 'mstd_unit', name: 'mstd_unit'},
                    //         {data: 'mstd_frac', name: 'mstd_frac'},
                    //         {data: 'mstd_qty', name: 'mstd_qty'},
                    //         {data: 'keterangan', name: 'keterangan'},
                    //     ],
                    // });  
                }
            });
            // showDataToTable();
            
        }
        
        function showDataToTable() {                   
            $('#pluTable').DataTable().destroy() 
            $('#pluTable').DataTable({
                data: plu_datas,
                columns: [
                    {data: 'mstd_prdcd', name: 'mstd_prdcd'},
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                    // {data: 'mstd_unit', name: 'mstd_unit'},
                    // {data: 'mstd_frac', name: 'mstd_frac'},
                    // {data: 'mstd_ctn', name: 'mstd_ctn'},
                    // {data: 'mstd_box', name: 'mstd_box'},
                    {data: 'mstd_qty', name: 'mstd_qty'},
                    {data: 'keterangan', name: 'keterangan'},
                ],
            });
            
            // $('#pluTable').DataTable({
            //     "ajax": {
            //         'url': '{{ url()->current() }}/show-data'                    
            //     },
            //     "data": plu_datas,
            //     "columns": [
            //         {data: 'mstd_prdcd', name: 'mstd_prdcd'},
            //         {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
            //         {data: 'mstd_unit', name: 'mstd_unit'},
            //         {data: 'mstd_frac', name: 'mstd_frac'},
            //         // {data: 'mstd_ctn', name: 'mstd_ctn'},
            //         // {data: 'mstd_box', name: 'mstd_box'},
            //         {data: 'mstd_qty', name: 'mstd_qty'},
            //         {data: 'keterangan', name: 'keterangan'},
            //     ],
            //     "paging": true,
            //     "lengthChange": true,
            //     "searching": true,
            //     "ordering": true,
            //     "info": true,
            //     "autoWidth": false,
            //     "responsive": true,
            //     "createdRow": function (row, data, dataIndex) {
            //         $(row).addClass('modalRow');
            //     },
            //     columnDefs: [],
            //     "order": []
            // })
        }

        function checkPluBarcode(data) {                             
            ajaxSetup()
            $.ajax({
                type: "GET",
                url: "{{ url()->current() }}/check-plu-barcode",
                async: false,
                data: {
                    data: data
                },
                beforeSend: function () {
                    $('#modal-loader').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                },
                success: function (res) {
                    $('#modal-loader').modal('hide');
                    // console.log(res.data)               
                    plu_datas.push(res.data.datas)
                    switch (res.status) {
                        case 'INFO MASTER':
                            existsInMasterBarcode.push(res.data.datas)                            
                            break;
                        case 'INFO KLAIM':
                            notExistsInMasterKlaim.push(res.data.datas)                                                                                                        
                            break;
                        case 'SUCCESS':
                            existsInMasterKlaim.push(res.data.datas)    
                            res.data.data_print.forEach(dp => {
                                printData.push(dp)
                            });                   
                            break;
                    }
                }
            });
        }

        function sendEmail() {
            ajaxSetup()
            $.ajax({
                type: "POST",
                url: "{{ url()->current() }}/send-email",
                data: {
                    notExistsInMasterKlaim: notExistsInMasterKlaim
                },
                beforeSend: function () {
                    $('#modal-loader').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                },
                success: function (response) {
                    $('#modal-loader').modal('hide'); 
                    
                    swal({
                        icon: response.status,
                        title: 'Email',
                        text: response.message                        
                    }).then(() => {});
                }, error: function (err) {
                    $('#modal-loader').modal('hide');

                    swal({                        
                        text: response.message,
                        icon: response.status
                    }).then(() => {});
                }
            });
        }

        function saveDataBarcode() {
            if (plu_datas.length == 0) {
                swal({
                    icon: 'info',
                    title: 'Nomor Faktur',
                    text: 'Mohon pilih nomor faktur yang ingin dicetak barcode putih',
                    timer: 2000
                });
            } else {
                if (notExistsInMasterKlaim.length > 0) {
                    sendEmail();
                }                
                
                ajaxSetup()
                $.ajax({
                    type: "POST",
                    url: "{{ url()->current() }}/save-barcode-print",
                    data: {
                        data: printData
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal({
                            backdrop: 'static',
                            keyboard: false
                        })
                    },
                    success: function (res) {
                        $('#modal-loader').modal('hide');                        
                        if (res.status == 'SUCCESS') {
                            swal({
                                icon: 'success',
                                title: 'Barcode Putih',
                                text: res.message,                        
                            }).then(() => {location.reload()});                             
                        } else {
                            swal({
                                icon: 'info',
                                title: 'Barcode Putih',
                                text: res.message,                        
                            }).then(() => {location.reload()});
                        }                        
                    }, 
                    error: function (err) {
                        $('#modal-loader').modal('hide');

                        swal({                        
                            text: response.message,
                            icon: response.status
                        }).then(() => {});
                    }
                });
                // window.open(`{{ url()->current() }}/print-barcode?plus=${plus}&noFaktur=${existsInMasterKlaim[0].mstd_nofaktur}`, '_blank')
            }                        
        }

        // function saveBarcodePrint() {
        //     ajaxSetup()
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ url()->current() }}/save-barcod-print",
        //         data: {
        //             data: printData
        //         },
        //         beforeSend: function () {
        //             $('#modal-loader').modal({
        //                 backdrop: 'static',
        //                 keyboard: false
        //             })
        //         },
        //         success: function (response) {
        //             $('#modal-loader').modal('hide');


        //         }
        //     });
        // }
    </script>
@endsection