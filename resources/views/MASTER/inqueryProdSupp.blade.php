@extends('navbar')
@section('content')


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Inquery Produksi Per Supplier</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <div class="col-sm-10">
                                <fieldset class="card border-secondary">
                                    <form>
                                        <div class="row text-right">
                                            <div class="col-sm-12">
                                                <div class="form-group row mb-0">
                                                    <label for="i_kodesupplier" class="col-sm-2 col-form-label">Supplier</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="i_kodesupplier">
                                                    </div>
                                                    <button type="button" class="btn p-0" data-toggle="modal" data-target="#modal_supp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                                    <label for="i_namasupplier" class="col-sm-2 col-form-label">Nama Supplier</label>
                                                    <div class="col-sm-5">
                                                        <input type="text" class="form-control" id="i_namasupplier" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <tbody>
                                    </tbody>
                                    </table>
                                </fieldset>
                            </div>
                            <div class="col-sm-12">
                                <fieldset class="card border-secondary">
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                        <table id="tabledetail" class="table table-sm">
                                            <thead>
                                            <tr class="d-flex">
                                                <th class="col-sm-1">PLU</th>
                                                <th class="col-sm-3">Nama Barang</th>
                                                <th class="col-sm-1 pl-0 pr-0 text-right">Stok</th>
                                                <th class="col-sm-2 text-right">Sales</th>
                                                <th class="col-sm-2 text-right">PKM Exist</th>
                                                <th class="col-sm-2 text-right">H.P.P</th>
                                                <th class="col-sm-1 text-right">Tag</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="rowdetail d-flex"></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    {{--<form>--}}
                                    {{--<div class="row text-right">--}}
                                    {{--<div class="col-sm-12">--}}
                                    {{--<div class="form-group row mb-2">--}}
                                    {{--<label for="i_totalitem" class="col-sm-2 col-form-label">Total Item</label>--}}
                                    {{--<div class="col-sm-1">--}}
                                    {{--<input type="text" class="form-control" id="i_totalitem" value="">--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</form>--}}
                                </fieldset>
                            </div>
                        </div>
                        <div class="row text-right">
                            <div class="offset-sm-12 col-sm-5 mt-3">
                                <div class="form-group row mb-0">
                                    <label for="i_totalitem" class="col-sm-4 col-form-label">Total Item</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="i_totalitem" value="" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </fieldset>
        </div>
    </div>
    </div>

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

    <div class="modal fade" id="modal_supp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">

            <!-- Modal content-->
            <div class="modal-content">
                {{--<div class="modal-header">--}}
                    {{--<div class="form-row col-sm">--}}
                    {{--<input id="helpSearch" class="form-control helpSearch" type="text" placeholder="Inputkan Nama / Kode Supplier" aria-label="Search">--}}
                    {{--<div class="invalid-feedback">--}}
                    {{--Inputkan minimal 3 karakter</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <table class="table table-sm" id="table_lov">
                                <thead>
                                <tr>
                                    <td>Kode Supplier</td>
                                    <td>Nama Supplier</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($supplier2 as $s)
                                    <tr onclick="helpSelect('{{ $s->sup_kodesupplier }}')" class="row_lov">
                                        <td>{{ $s->sup_kodesupplier }}</td>
                                        <td>{{ $s->sup_namasupplier }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{--<div class="modal-footer">--}}
                {{--</div>--}}
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

        .rowdetail:hover{
            cursor: pointer;
            background-color: grey;
        }
        .my-custom-scrollbar {
            position: relative;
            height: 380px;
            overflow: auto;
        }
        .table-wrapper-scroll-y {
            display: block;
        }



    </style>

    <script>

        $(document).on('keypress', '#i_kodesupplier', function (e) {
            if(e.which == 13) {
                e.preventDefault();
                let kodesupp = $('#i_kodesupplier').val()
                helpSelect(kodesupp);
                }
            });

        function helpSelect(kodesupp) {
            $('#modal_supp').modal('hide')
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/inqprodsupp/prodSupp',
                type: 'post',
                data: {kodesupp: kodesupp},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    console.log(result)
                    $('#tabledetail .rowdetail').remove();
                    if (result) {
                        console.log(result.data[0]);
                        var html = "";
                        var i;
                        for (i = 0; i < result.data.length; i++) {
                            var pkm = parseInt(result.data[i].pkm_pkmt) + parseInt(result.data[i].ngdl);
                            var hpp = result.data[i].prd_lastcost / result.data[i].nfrac;
                            html = '<tr class="rowdetail d-flex">' +
                                '<td class="col-1">' + result.data[i].mstd_prdcd + '</td>' +
                                '<td class="col-3">' + result.data[i].prd_deskripsipendek + '</td>' +
                                '<td class="col-1 pl-0 pr-0 text-right">' + result.data[i].st_saldoakhir + '</td>' +
                                '<td class="col-2 text-right">' + result.data[i].st_sales + '</td>' +
                                '<td class="col-2 text-right">' + pkm + '</td>' +
                                '<td class="col-2 text-right">' + convertToRupiah(hpp) + '</td>' +
                                '<td class="col-1 text-right">' + result.data[i].prd_kodetag + '</td>' +
                                '</tr>'
                            $('#i_namasupplier').val(result.data[i].sup_namasupplier);
                            $('#i_totalitem').val(result.count);
                            $('#tabledetail').append(html);
                        }
                    }
                }, error: function () {
                   alert('error');
                }
            })
        }

        // $(document).on('keypress', '#i_kodesupplier', function (e) {
        //     if (e.which == 13) {
        //         e.preventDefault()
        //         kode = $('').val();
        //         test(kode)
        //     }
        // }
        //
        // function test(kode){
        //     ajax()
        //     let a = kode;
        // }


        // function null_check(value){
        //     if(value == null)
        //         return '';
        //     else return value;
        // }
    </script>

@endsection
