@extends('navbar')
@section('content')


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Inquery Supplier Produksi</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <div class="col-sm-8">
                                <fieldset class="card border-secondary">
                                    <form>
                                        <div class="row text-right">
                                            <div class="col-sm-12">
                                                <div class="form-group row mb-0">
                                                    <label for="i_kodesupplier" class="col-sm-2 col-form-label">PLU</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="i_kodesupplier">
                                                    </div>
                                                    {{--<button type="button" class="btn p-0" data-toggle="modal" data-target="#m_kodesupplierHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>--}}
                                                    <label for="i_namasupplier" class="col-sm-2 col-form-label">Nama PLU</label>
                                                    <div class="col-sm-5">
                                                        <input type="text" class="form-control" id="i_namasupplier">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
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

                            <div class="col-sm-12">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-4">Detail</legend>
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                        <table id="table_departement" class="table table-sm">
                                            <thead>
                                            <tr class="d-flex">
                                                <th class="col-sm-1">Supplier</th>
                                                <th class="col-sm-3">Nama Supplier</th>
                                                <th class="col-sm-1 pl-0 pr-0">Kuantum</th>
                                                <th class="col-sm-2">BTB</th>
                                                <th class="col-sm-2">Tanggal</th>
                                                <th class="col-sm-2">Term</th>
                                                <th class="col-sm-1">H.P.P</th>
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

        .row_divisi:hover{
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
