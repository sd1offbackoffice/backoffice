@extends('navbar')

@section('title',(__('PB | Upload dan Monitoring KKEI Toko IGR')))
@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">@lang('Upload dan Monitoring KKEI Toko IGR')</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <div class="col-sm-4">
                                <fieldset class="card border-secondary">
                                    <legend class="w-auto ml-4"><small>@lang('Upload Data KKEI ke GI')</small></legend>

                                    <div class="col-sm-12 m-1">
                                        <fieldset class="card border-secondary">
                                            <legend class="w-auto ml-3"><h6>@lang('Periode KKEI yang belum diupload')</h6></legend>
                                            <div class="table-wrapper-scroll-y my-custom-scrollbar m-1">
                                                <table id="table-upload" class="table table-sm table-bordered">
                                                    <thead>
                                                    <tr class="d-flex text-center">
                                                        <th class="col-sm-2"></th>
                                                        <th class="col-sm-10">@lang('Periode')</th>
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
                                        <button id="btn-upload" class="btn btn-primary" onclick="upload()">@lang('UPLOAD DATA')</button>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-sm-8">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-4"><small>@lang('Monitoring Data KKEI yang sudah diupload ke GI')</small></legend>
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar-monitoring">
                                        <table id="table-monitoring" class="table table-sm text-center">
                                            <thead>
                                            <tr class="d-flex">
                                                <th class="col-sm-2">@lang('Periode')</th>
                                                <th class="col-sm-2">@lang('Data Diterima GI')</th>
                                                <th class="col-sm-3">@lang('Proses PB GI')</th>
                                                <th class="col-sm-3">@lang('Proses PO GI')</th>
                                                <th class="col-sm-2">@lang('Proses BPB GI')</th>
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

            if(periode.length == 0){
                swal({
                    title: "{{__('Tidak ada periode yang dipilih!')}}",
                    icon: 'warning'
                });
            }
            else{
                $.ajax({
                    url: '{{ url()->current() }}/upload',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {periode: periode},
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                        console.log(periode);
                    },
                    success: function (response, xhr) {
                        // $('#modal-loader').modal('hide');

                        swal({
                            title: response.message,
                            icon: "success"
                        }).then(function(){
                            window.location.reload();
                        });
                    },
                    error: function (error) {
                        swal({
                            title: error.responseJSON.message,
                            icon: 'error',
                        }).then(() => {
                            $('#modal-loader').modal('hide');
                        });
                    }
                });
            }
        }
    </script>

@endsection
