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
                                                    <label for="i_kodeplu" class="col-sm-2 col-form-label">PLU</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="i_kodeplu">
                                                    </div>
                                                    {{--<button type="button" class="btn p-0" data-toggle="modal" data-target="#m_kodesupplierHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>--}}
                                                    <label for="i_deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                                                    <div class="col-sm-5">
                                                        <input type="text" class="form-control" id="i_deskripsi" disabled>
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

                            <div class="col-sm-12">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-4">Detail</legend>
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                        <table id="table_detail" class="table table-sm">
                                            <thead>
                                            <tr class="d-flex">
                                                <th class="col-sm-1">Supplier</th>
                                                <th class="col-sm-4">Nama Supplier</th>
                                                <th class="col-sm-1 pl-0 pr-0">Kuantum</th>
                                                <th class="col-sm-1">BTB</th>
                                                <th class="col-sm-2">Tanggal</th>
                                                <th class="col-sm-2">Term</th>
                                                <th class="col-sm-1">H.P.P</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="row_detail d-flex">
                                            </tr>
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
        // $(':input').prop('readonly',true);
        // $('.custom-select').prop('disabled',true);
        // $('#i_kodesupplier').prop('readonly',false);
        // $('#search_lov').prop('readonly',false);
        //
        // $('#row_divisi_0').addClass('table-success');
        //
        // $(document).ready(function () {
        //
        // })

        $(document).on('keypress', '#i_kodeplu', function (e) {
            if(e.which == 13) {
                e.preventDefault();
                let kodeplu = $('#i_kodeplu').val();
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/inqsupprod/suppProd',
                    type: 'get',
                    data: {kodeplu:kodeplu},
                    beforeSend: function(){
                        $('#modal-loader').modal('show');
                    },
                    success: function (result) {
                        $('#modal-loader').modal('hide');
                        console.log(result)
                        $('#table_detail .row_detail').remove();
                        if(result) {
                            var html = "";
                            var i;
                            for (i = 0; i < result.data.length; i++) {
                                    html =
                                '<tr class="row_detail d-flex">' +
                                    '<td class="col-1">' + result.data[i].kodesup + '</td>' +
                                    '<td class="col-4">' + result.data[i].namasup + '</td>' +
                                    '<td class="col-1 pl-0 pr-0">' + result.data[i].qty + '</td>' +
                                    '<td class="col-1">' + result.data[i].nobpb + '</td>' +
                                    '<td class="col-2">' + formatDate(result.data[i].tglbpb) + '</td>' +
                                    '<td class="col-2">' + result.data[i].term + '</td>' +
                                    '<td class="col-1">' + convertToRupiah(result.data[i].hpp) + '</td>' +
                                    '</tr>'
                                //$('#i_deskripsi').val();
                                // $('#i_totalitem').val(result.count);
                                $('#table_detail').append(html);
                            }
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
