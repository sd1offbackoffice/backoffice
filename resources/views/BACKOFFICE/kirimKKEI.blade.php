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
                                                <table id="table_hobby" class="table table-sm table-bordered">
                                                    <thead>
                                                    <tr class="d-flex text-center">
                                                        <th class="col-sm-2"></th>
                                                        <th class="col-sm-10">Periode</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php for($i=0;$i<20;$i++){ @endphp
                                                    <tr class="d-flex">
                                                        <td class="col-sm-2">
                                                            <div class="custom-control custom-checkbox text-center">
                                                                <input type="checkbox" class="custom-control-input" id="cb_h{{ $i }}">
                                                                <label class="custom-control-label mt-2" for="cb_h{{ $i }}"></label>
                                                            </div>
                                                        </td>
                                                        <td class="col-sm-10">
                                                            <input disabled type="text" class="form-control">
                                                        </td>
                                                    </tr>
                                                    @php } @endphp
                                                    </tbody>
                                                </table>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-sm-12 mb-1 text-center">
                                        <button id="btn-upload" class="btn btn-primary">UPLOAD DATA</button>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-sm-8">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-4"><small>Monitoring Data KKEI yang sudah diupload ke GI</small></legend>
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar-monitoring">
                                        <table id="table_departement" class="table table-sm">
                                            <thead>
                                            <tr class="d-flex text-center">
                                                <th class="col-sm-2">Periode</th>
                                                <th class="col-sm-4">Data Diterima GI</th>
                                                <th class="col-sm-2">Proses PB GI</th>
                                                <th class="col-sm-2">Proses PO GI</th>
                                                <th class="col-sm-2">Proses BPB GI</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php for($i=0;$i<20;$i++){ @endphp
                                            <tr class="d-flex">
                                                <td class="col-sm-2">AAAA</td>
                                                <td class="col-sm-4">AAAA</td>
                                                <td class="col-sm-2">AAAA</td>
                                                <td class="col-sm-2">AAAA</td>
                                                <td class="col-sm-2">AAAA</td>
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



    </style>

    <script>
        $(':input').prop('readonly',true);
        $('.custom-select').prop('disabled',true);
        $('#i_kodesupplier').prop('readonly',false);
        $('#search_lov').prop('readonly',false);

        $('#row_divisi_0').addClass('table-success');

        $(document).ready(function () {

        })

        function divisi_select(value, row) {
            $('.row_divisi').removeClass('table-success');
            $('#row_divisi_'+row).addClass('table-success');
            $.ajax({
                url: '/BackOffice/public/mstdepartement/divisi_select',
                type:'GET',
                data:{"_token":"{{ csrf_token() }}", value: value},
                success: function(response){
                    $('#table_departement .row_departement').remove();
                    html = "";
                    for(i=0;i<response.length;i++){
                        html = '<tr class="row_departement d-flex"><td class="col-1">'+null_check(response[i].dep_kodedepartement)+'</td><td class="col-4">'+null_check(response[i].dep_namadepartement)+'</td><td class="col-1 pl-0 pr-0">'+null_check(response[i].dep_singkatandepartement)+'</td><td class="col-2">'+null_check(response[i].dep_kodemanager)+'</td><td class="col-2">'+null_check(response[i].dep_kodesecurity)+'</td><td class="col-2">'+null_check(response[i].dep_kodedepartement)+'</td></tr>';
                        $('#table_departement').append(html);
                    }
                }
            });
        }

        function null_check(value){
            if(value == null)
                return '';
            else return value;
        }
    </script>

@endsection
