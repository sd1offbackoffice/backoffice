@extends('navbar')
@section('content')


    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Upload dan Monitoring KKEI Toko IGR</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <div class="col-sm-4">
                                <fieldset class="card border-secondary">
                                    <legend class="w-auto ml-4"><small>Upload Data KKEI ke GI</small></legend>

                                    <div class="col-sm-12 m-1">
                                        <fieldset class="card border-secondary">
                                            <legend class="w-auto ml-3"><h6>Periode KKEI yang belum diupload</h6></legend>
                                            <div class="table-wrapper-scroll-y my-custom-scrollbar m-1">
                                                <table id="table-upload" class="table table-sm table-bordered">
                                                    <thead>
                                                    <tr class="d-flex text-center">
                                                        <th class="col-sm-2"></th>
                                                        <th class="col-sm-10">Periode</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($kkei as $k)
                                                    <tr class="d-flex">
                                                        <td class="col-sm-2">
                                                            <div class="custom-control custom-checkbox text-center">
                                                                <input type="checkbox" class="custom-control-input cb_kkei" id="cb_h{{ $k->kke_periode }}">
                                                                <label class="custom-control-label mt-2" for="cb_h{{ $k->kke_periode }}"></label>
                                                            </div>
                                                        </td>
                                                        <td class="col-sm-10">
                                                            <input disabled type="text" class="form-control periode" value="{{ $k->kke_periode }}">
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @for($i=count($kkei);$i<10;$i++)
                                                        <tr class="d-flex">
                                                            <td class="col-sm-2">
                                                                <div class="custom-control custom-checkbox text-center">
                                                                    <input type="checkbox" class="custom-control-input cb_kkei" id="cb_h{{ $i }}">
                                                                    <label class="custom-control-label mt-2" for="cb_h{{ $i }}"></label>
                                                                </div>
                                                            </td>
                                                            <td class="col-sm-10">
                                                                <input disabled type="text" class="form-control periode" value="">
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                    </tbody>
                                                </table>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-sm-12 mb-1 text-center">
                                        <button id="btn-upload" class="btn btn-primary" onclick="upload()">UPLOAD DATA</button>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-sm-8">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-4"><small>Monitoring Data KKEI yang sudah diupload ke GI</small></legend>
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar-monitoring">
                                        <table id="table-monitoring" class="table table-sm text-center">
                                            <thead>
                                            <tr class="d-flex">
                                                <th class="col-sm-2">Periode</th>
                                                <th class="col-sm-2">Data Diterima GI</th>
                                                <th class="col-sm-3">Proses PB GI</th>
                                                <th class="col-sm-3">Proses PO GI</th>
                                                <th class="col-sm-2">Proses BPB GI</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data as $d)
                                                <tr class="d-flex">
                                                    <td class="col-sm-2 format">{{ $d->kke_periode }}</td>
                                                    <td class="col-sm-2 format">{{ $d->kke_create_dt }}</td>
                                                    <td class="col-sm-3">{{ $d->kke_nomorpb }}</td>
                                                    <td class="col-sm-3">{{ $d->pbd_nopo }}</td>
                                                    <td class="col-sm-2">{{ $d->msth_nodoc }}</td>
                                                </tr>
                                            @endforeach
                                            @php for($i=count($data);$i<17;$i++){ @endphp
                                            <tr class="d-flex">
                                                <td class="col-sm-2" style="color:white">AAAA</td>
                                                <td class="col-sm-2" style="color:white">AAAA</td>
                                                <td class="col-sm-3" style="color:white">AAAA</td>
                                                <td class="col-sm-3" style="color:white">AAAA</td>
                                                <td class="col-sm-2" style="color:white">AAAA</td>
                                            </tr>
                                            @php } @endphp
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>

    {{--LOADER--}}
    <div class="modal fade" id="modal-loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="vertical-align: middle;">
        <div class="modal-dialog modal-dialog-centered" role="document" >
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="loader" id="loader"></div>
                            <div class="col-sm-12 text-center">
                                <label for="">LOADING...</label>
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
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .row_divisi:hover{
            cursor: pointer;
            background-color: grey;
        }
        .my-custom-scrollbar {
            position: relative;
            height: 535px;
            overflow: auto;
        }

        .my-custom-scrollbar-monitoring {
            position: relative;
            height: 628px;
            overflow: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        .table{
            margin-bottom: 0px !important;
        }



    </style>

    <script>
        $(document).ready(function () {

        })

        $('.format').each(function(){
            $(this).html(formatDate($(this).html()));
        });

        function upload(){
            periode = [];
            $('.cb_kkei').each(function(){
                if($(this).is(':checked')){
                    periode.push($(this).parent().parent().parent().find('.periode').val().replace(/\//g,''));
                }
            });

            $.ajax({
                url: '/BackOffice/public/bokirimkkei/upload',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {periode: periode},
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    console.log(periode);
                },
                success: function (response, xhr) {
                    console.log(xhr.status);
                    $('#modal-loader').modal('toggle');
                    if(response.status == 'success'){
                        swal({
                            title: response.message,
                            icon: "success"
                        }).then(function(){
                            refresh();
                        });
                    }
                    else{
                        swal({
                            title: response.message,
                            icon: "error"
                        });
                    }
                }
            });
        }

        function refresh() {
            $.ajax({
                url: '/BackOffice/public/bokirimkkei/refresh',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $('#modal-loader').modal('toggle');
                },
                success: function (response) {
                    $('#modal-loader').modal('toggle');
                    console.log(response);

                    $('#table-upload tbody tr').remove();

                    for(i=0;i<response.kkei.length;i++){
                        html = '<tr class="d-flex">' +
                                '<td class="col-sm-2">' +
                                    '<div class="custom-control custom-checkbox text-center">' +
                                        '<input type="checkbox" class="custom-control-input cb_kkei" id="cb_h'+response.kkei[i].kke_periode+'">' +
                                        '<label class="custom-control-label mt-2" for="cb_h'+response.kkei[i].kke_periode+'"></label>' +
                                    '</div>' +
                                '</td>' +
                                '<td class="col-sm-10">' +
                                    '<input disabled type="text" class="form-control periode" value="'+response.kkei[i].kke_periode+'">' +
                                '</td>' +
                            '</tr>';

                        $('#table-upload').append(html);
                    }

                    for(i=response.kkei.length;i<10;i++){
                        html = '<tr class="d-flex">' +
                            '<td class="col-sm-2">' +
                            '<div class="custom-control custom-checkbox text-center">' +
                            '<input type="checkbox" class="custom-control-input cb_kkei" id="cb_h'+i+'">' +
                            '<label class="custom-control-label mt-2" for="cb_h'+i+'"></label>' +
                            '</div>' +
                            '</td>' +
                            '<td class="col-sm-10">' +
                            '<input disabled type="text" class="form-control periode">' +
                            '</td>' +
                            '</tr>';

                        $('#table-upload').append(html);
                    }



                    $('#table-monitoring tbody tr').remove();

                    for(i=0;i<response.data.length;i++){
                        html = '<tr class="d-flex">'+
                            '<td class="col-sm-2 format">'+response.data[i].kke_periode+'</td>' +
                            '<td class="col-sm-2 format">'+response.data[i].kke_create_dt+'</td>' +
                            '<td class="col-sm-3">'+response.data[i].kke_nomorpb+'</td>' +
                            '<td class="col-sm-3">'+response.data[i].pbd_nopo+'</td>' +
                            '<td class="col-sm-2">'+response.data[i].msth_nodoc+'</td>' +
                            '</tr>';

                        $('#table-monitoring').append(html);
                    }
                    for(i=response.data.length;i<17;i++){
                        html = '<tr class="d-flex">'+
                            '<td class="col-sm-2" style="color:white">AA</td>' +
                            '<td class="col-sm-2" style="color:white">AA</td>' +
                            '<td class="col-sm-3" style="color:white">AA</td>' +
                            '<td class="col-sm-3" style="color:white">AA</td>' +
                            '<td class="col-sm-2" style="color:white">AA</td>' +
                            '</tr>';

                        $('#table-monitoring').append(html);
                    }

                    $('.format').each(function(){
                        $(this).html(formatDate($(this).html()));
                    });
                }
            });
        }
    </script>

@endsection
