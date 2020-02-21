@extends('navbar')
@section('content')


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Inquery Produksi Supplier</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <div class="col-sm-8">
                                <fieldset class="card border-secondary">
                                    <form>
                                        <div class="row text-right">
                                            <div class="col-sm-12">
                                                <div class="form-group row mb-0">
                                                    <label for="i_kodesupplier" class="col-sm-2 col-form-label">Supplier</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="i_kodesupplier">
                                                    </div>
                                                    <label for="i_namasupplier" class="col-sm-2 col-form-label">Nama Supplier</label>
                                                    <div class="col-sm-5">
                                                        <input type="text" class="form-control" id="i_namasupplier">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                        <tbody>
                                        {{--@php--}}
                                            {{--$i = 0;--}}
                                        {{--@endphp--}}
                                        {{--@foreach($divisi as $div)--}}
                                            {{--<tr id="row_divisi_{{ $i }}"class="row_divisi d-flex" onclick="divisi_select('{{ $div->div_kodedivisi }}','{{ $i++ }}')">--}}
                                                {{--<td class="col-4">{{ $div->div_kodedivisi }}</td>--}}
                                                {{--<td class="col-8">{{ $div->div_namadivisi }}</td>--}}
                                            {{--</tr>--}}
                                        {{--@endforeach--}}
                                        </tbody>
                                    </table>
                                </fieldset>
                            </div>
                        </div>
                            <div class="col-sm-12">
                                <fieldset class="card border-secondary">
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                        <table id="tabledetail" class="table table-sm">
                                            <thead>
                                            <tr class="d-flex">
                                                <th class="col-sm-1">PLU</th>
                                                <th class="col-sm-3">Nama Barang</th>
                                                <th class="col-sm-1 pl-0 pr-0">Stok</th>
                                                <th class="col-sm-2">Sales</th>
                                                <th class="col-sm-2">PKM Exist</th>
                                                <th class="col-sm-2">H.P.P</th>
                                                <th class="col-sm-1">Tag</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{--@foreach($result as $r)--}}
                                                {{--<tr class="row_detail d-flex">--}}
                                                    {{--<td class="col-sm-1">{{ $r->mstd_prdcd }}</td>--}}
                                                    {{--<td class="col-sm-3">{{ $r->prd_deskripsipendek }}</td>--}}
                                                    {{--<td class="col-sm-1 pl-0 pr-0">{{ $r->st_sales }}</td>--}}
                                                    {{--<td class="col-sm-2">{{ $r->st_saldoakhir }}</td>--}}
                                                    {{--<td class="col-sm-2">{{ $r->pkm_pkmt }}</td>--}}
                                                    {{--<td class="col-sm-2">{{ $r->prd_lastcost }}</td>--}}
                                                    {{--<td class="col-sm-1">{{ $r->prd_kodetag}}</td>--}}
                                                {{--</tr>--}}
                                            {{--@endforeach--}}
                                            </tbody>
                                        </table>
                                    </div>
                                    <form>
                                        <div class="row text-right">
                                            <div class="col-sm-12">
                                                <div class="form-group row mb-0">
                                                    <label for="i_totalitem" class="col-sm-2 col-form-label">Total Item</label>
                                                    <div class="col-sm-1">
                                                        <input type="text" class="form-control" id="i_totalitem" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </fieldset>
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
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .row_detail:hover{
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
        $(':input').prop('readonly',true);
        $('.custom-select').prop('disabled',true);
        $('#i_kodesupplier').prop('readonly',false);
        $('#search_lov').prop('readonly',false);

        $('#row_divisi_0').addClass('table-success');

        $(document).ready(function () {

        })

        $(document).on('keypress', '#i_kodesupplier', function (e) {
            if(e.which == 13) {
                e.preventDefault();
                let kodesupp = $('#i_kodesupplier').val();
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/inqprodsupp/prodSupp',
                    type: 'post',
                    data: {kodesupp:kodesupp},
                    success: function (result) {
                        console.log(result)
                        //$('#tabledetail. row_detail').remove();
                        var html = "";
                        var i;
                        for(i=0; i<result.data.length; i++) {
                            html = '<tr class="row_detail d-flex">' +
                                '<td class="col-1">' + result.data[1].mstd_prdcd + '</td>' +
                                '<td class="col-3">' + result.data[i].prd_deskripsipendek + '</td>' +
                                '<td class="col-1 pl-0 pr-0">' + result.data[1].st_sales + '</td>' +
                                '<td class="col-2">' + result.data[1].st_saldoakhir + '</td>' +
                                '<td class="col-2">' + result.data[1].pkm_pkmt + '</td>' +
                                '<td class="col-2">' + result.data[1].prd_lastcost + '</td>' +
                                '<td class="col-1">' + result.data[1].prd_kodetag + '</td>' +
                                '</tr>';
                            $('#i_totalitem').val(result.count);
                            $('#tabledetail').append(html);
                        }
                    }, error: function () {
                        alert('error');
                    }
                })
            }
        });

        // function null_check(value){
        //     if(value == null)
        //         return '';
        //     else return value;
        // }
    </script>

@endsection
