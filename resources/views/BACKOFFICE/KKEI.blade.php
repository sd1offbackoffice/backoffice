@extends('navbar')
@section('content')


    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Kertas Kerja Estimasi Kebutuhan Toko IGR</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <label for="periode" class="col-sm-1 col-form-label">Tanggal</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="periode" readonly>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="" readonly value="DATA KKEI">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 pr-0">
                                <fieldset class="card border-secondary">
                                    <legend class="w-auto ml-4">Detail</legend>
                                    <div class="kiri col-sm">
                                        <table id="table_hobby" class="table table-sm table-bordered m-1">
                                            <thead>
                                            <tr class="d-flex text-center">
                                                <th class="col-sm-2"></th>
                                                <th class="col-sm-5">PLU</th>
                                                <th class="col-sm-3">Unit</th>
                                                <th class="col-sm-2">Frac</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php for($i=0;$i<10;$i++){ @endphp
                                            <tr class="d-flex">
                                                <td class="col-sm-2 text-center">
                                                    <button id="btn-delete" class="col-sm btn btn-danger">X</button>
                                                </td>
                                                <td class="col-sm-5">
                                                    <input type="text" class="form-control">
                                                </td>
                                                <td class="col-sm-3">
                                                    <input type="text" class="form-control">
                                                </td>
                                                <td class="col-sm-2">
                                                    <input type="text" class="form-control">
                                                </td>
                                            </tr>
                                            @php } @endphp
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-sm-8 pl-0">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-4">Form</legend>
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar m-1">
                                        <table id="table_hobby" class="table table-sm table-bordered mb-0">
                                            <thead>
                                            <tr class="d-flex text-center">
                                                <th class="col-sm-2"></th>
                                                <th class="col-sm-10">Periode</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php for($i=0;$i<10;$i++){ @endphp
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
                                                <td class="col-sm-2">
                                                    <div class="custom-control custom-checkbox text-center">
                                                        <input type="checkbox" class="custom-control-input" id="cb_h{{ $i }}">
                                                        <label class="custom-control-label mt-2" for="cb_h{{ $i }}"></label>
                                                    </div>
                                                </td>
                                                <td class="col-sm-2">
                                                    <div class="custom-control custom-checkbox text-center">
                                                        <input type="checkbox" class="custom-control-input" id="cb_h{{ $i }}">
                                                        <label class="custom-control-label mt-2" for="cb_h{{ $i }}"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php } @endphp
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="txt_deskripsi" readonly>
                            </div>
                            <div class="col-sm-6 mb-1 text-center">
                                <button id="btn-print" class="col-sm-4 btn btn-primary">PRINT</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <h4>Kebutuhan Kontainer : 20 Feet</h4>
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
            height: 560px;
            overflow-x: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        .kiri{
            height: 568px;
        }



    </style>

    <script>

        $("#periode").datepicker({
            "dateFormat" : "dd/mm/yy"
        });


    </script>

@endsection
