@extends('navbar')
@section('title','Laporan Service Level PB')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5">LAPORAN SERVICE LEVEL PB</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Jenis Laporan</label>
                            <select class="col-md-6 text-center form-control" name="jenisLaporan" id="jenisLaporan">
                                <option value="1">1. LAPORAN SERVICE LEVEL PB YANG TIDAK DI CHECK</option>
                                <option value="2">2. LAPORAN SERVICE LEVEL PB YANG TIDAK TERPICKING</option>
                            </select>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Tanggal</label>
                            <input class="col-sm-4 text-center form-control" type="text" id="daterangepicker">
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">No. PB</label>
                            <div class="col-sm-2 buttonInside" style="margin-left: -15px; margin-right: 30px">
                                <input type="text" class="form-control" id="kodePromosi1">
                                <button id="pb1" type="button" class="btn btn-lov p-0" onclick="toggleData(this)">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <label class="col-sm-2 col-form-label text-center">s/d</label>
                            <div class="col-sm-2 buttonInside" style="margin-left: -15px; margin-right: 30px">
                                <input type="text" class="form-control" id="kodePromosi2">
                                <button id="pb2" type="button" class="btn btn-lov p-0" onclick="toggleData(this)">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success col-sm-3" type="button" id="cetak" onclick="cetak()">CETAK LAPORAN</button>
                        </div>
                        <br>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <!--MODAL PB-->
    <div class="modal fade" id="m_pb" tabindex="-1" role="dialog" aria-labelledby="m_pb" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar PB</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <input type="text" id="hiddenInput" hidden>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tablePB">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>No. Dokumen</th>
                                        <th>No. SPA</th>
                                        <th>Kd Cabang</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyPB"></tbody>
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
    <!-- END OF MODAL Pembanding-->

    <script>
        let tablePB;
        let cursor;

        $('#daterangepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
        $(document).ready(function () {
            getPB();
        })
        //
        // Pipelining function for DataTables. To be used to the `ajax` option of DataTables
        //
        $.fn.dataTable.pipeline = function ( opts ) {
            // Configuration options
            let conf = $.extend( {
                pages: 5,     // number of pages to cache
                url: '',      // script url
                data: null,   // function or object with parameters to send to the server
                              // matching how `ajax.data` works in DataTables
                method: 'GET' // Ajax HTTP method
            }, opts );

            // Private variables for storing the cache
            let cacheLower = -1;
            let cacheUpper = null;
            let cacheLastRequest = null;
            let cacheLastJson = null;

            return function ( request, drawCallback, settings ) {
                let ajax          = false;
                let requestStart  = request.start;
                let drawStart     = request.start;
                let requestLength = request.length;
                let requestEnd    = requestStart + requestLength;

                if ( settings.clearCache ) {
                    // API requested that the cache be cleared
                    ajax = true;
                    settings.clearCache = false;
                }
                else if ( cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper ) {
                    // outside cached data - need to make a request
                    ajax = true;
                }
                else if ( JSON.stringify( request.order )   !== JSON.stringify( cacheLastRequest.order ) ||
                    JSON.stringify( request.columns ) !== JSON.stringify( cacheLastRequest.columns ) ||
                    JSON.stringify( request.search )  !== JSON.stringify( cacheLastRequest.search )
                ) {
                    // properties changed (ordering, columns, searching)
                    ajax = true;
                }

                // Store the request for checking next time around
                cacheLastRequest = $.extend( true, {}, request );

                if ( ajax ) {
                    // Need data from the server
                    if ( requestStart < cacheLower ) {
                        requestStart = requestStart - (requestLength*(conf.pages-1));

                        if ( requestStart < 0 ) {
                            requestStart = 0;
                        }
                    }

                    cacheLower = requestStart;
                    cacheUpper = requestStart + (requestLength * conf.pages);

                    request.start = requestStart;
                    request.length = requestLength*conf.pages;

                    // Provide the same `data` options as DataTables.
                    if ( typeof conf.data === 'function' ) {
                        // As a function it is executed with the data object as an arg
                        // for manipulation. If an object is returned, it is used as the
                        // data object to submit
                        let d = conf.data( request );
                        if ( d ) {
                            $.extend( request, d );
                        }
                    }
                    else if ( $.isPlainObject( conf.data ) ) {
                        // As an object, the data given extends the default
                        $.extend( request, conf.data );
                    }

                    return $.ajax( {
                        "type":     conf.method,
                        "url":      conf.url,
                        "data":     request,
                        "dataType": "json",
                        "cache":    false,
                        "success":  function ( json ) {
                            cacheLastJson = $.extend(true, {}, json);

                            if ( cacheLower != drawStart ) {
                                json.data.splice( 0, drawStart-cacheLower );
                            }
                            if ( requestLength >= -1 ) {
                                json.data.splice( requestLength, json.data.length );
                            }

                            drawCallback( json );
                        }
                    } );
                }
                else {
                    json = $.extend( true, {}, cacheLastJson );
                    json.draw = request.draw; // Update the echo for each response
                    json.data.splice( 0, requestStart-cacheLower );
                    json.data.splice( requestLength, json.data.length );

                    drawCallback(json);
                }
            }
        };

        // Register an API method that will empty the pipelined data, forcing an Ajax
        // fetch on the next draw (i.e. `table.clearPipeline().draw()`)
        $.fn.dataTable.Api.register( 'clearPipeline()', function () {
            return this.iterator( 'table', function ( settings ) {
                settings.clearCache = true;
            } );
        } );

        function getPB(){
            tablePB =  $('#tablePB').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": $.fn.dataTable.pipeline( {
                    url: '{{ url()->current().'/getpb' }}',
                    pages: 200, // number of pages to cache
                    data: {
                        'value' : $('#hiddenInput').val()
                    }
                } ),
                {{--"ajax": {--}}
                {{--    'url' : '{{ url()->current().'/getpb' }}',--}}
                {{--    "data" : {--}}
                {{--        'value' : $('#hiddenInput').val()--}}
                {{--    },--}}
                {{--},--}}
                "columns": [
                    {data: 'pbo_nokoli', name: 'pbo_nokoli'},
                    {data: 'pbo_nopb', name: 'pbo_nopb'},
                    {data: 'pbo_kodeomi', name: 'pbo_kodeomi'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowPB');
                },
                columnDefs : [
                ],
                "order": []
            });
            $('#tablePB_filter input').unbind();
            $('#tablePB_filter input').bind('keyup', function(e) {
                if (e.keyCode == 13) {
                    let val = $(this).val().toUpperCase();

                    tablePB.search(this.value).draw();
                }
            });
        }

        //    Function untuk onclick pada data modal
        $(document).on('click', '.modalRowPB', function () {
            let currentButton = $(this);
            let kode = currentButton.children().first().next().text();

            if(cursor == "pb1"){
                $('#kodePromosi1').val(kode);
            }else if(cursor == "pb2"){
                $('#kodePromosi2').val(kode);
            }

            $('#m_pb').modal('toggle');
        });

        function toggleData(val){
            cursor = val.id;
            if(cursor == 'pb2'){
                if($('#kodePromosi1').val() == ''){
                    swal({
                        title:'Warning',
                        text: 'PB pertama tidak boleh kosong',
                        icon:'warning',
                    }).then(function() {
                        $('#kodePromosi1').select();
                    })
                    return false;
                }else{
                    if($('#hiddenInput').val() != $('#kodePromosi1').val()){
                        $('#hiddenInput').val($('#kodePromosi1').val());
                        tablePB.destroy();
                        getPB();
                    }
                }
            }else if(cursor == 'pb1'){
                if($('#hiddenInput').val() != '' && $('#hiddenInput').val() != $('#kodePromosi1').val()){
                    $('#hiddenInput').val('');
                    tablePB.destroy();
                    getPB();
                }
            }
            $('#m_pb').modal('toggle');
        }

        function cetak(){
            let date = $('#daterangepicker').val();
            if(date == null || date == ""){
                swal({
                    title:'Alert',
                    text: 'Tanggal Tidak Boleh Kosong !!',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#daterangepicker').focus();
                });
                return false;
            }
            let dateA = date.substr(0,10);
            let dateB = date.substr(13,10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');

            if($('#kodePromosi1').val() > $('#kodePromosi2').val()){
                swal({
                    title:'Alert',
                    text: 'No. P B  PERTAMA harus < NO. P B KEDUA',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#kodePromosi1').focus();
                });
                return false;
            }
            window.open(`{{ url()->current() }}/cetak?date1=${dateA}&date2=${dateB}&jenis=${$('#jenisLaporan').val()}&pb1=${$('#kodePromosi1').val()}&pb2=${$('#kodePromosi2').val()}`, '_blank');
        }
    </script>
@endsection
