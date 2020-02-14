@extends('navbar')
@section('content')


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Master Kategori Barang</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <div class="col-sm-8">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-4">Departement</legend>
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar-dep tableFixHead">
                                        <table id="table_departement" class="table table-sm fixed_headers">
                                            <thead>
                                                <tr class="d-flex">
                                                    <th class="col-4">Kode</th>
                                                    <th class="col-8">Nama Departement</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach($departement as $dep)
                                                <tr id="row_departement_{{ $i }}"class="row_departement d-flex" onclick="departement_select('{{ $dep->dep_kodedepartement }}','{{ $i++ }}')">
                                                    <td class="col-4">{{ $dep->dep_kodedepartement }}</td>
                                                    <td class="col-8">{{ $dep->dep_namadepartement }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-sm-12">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-4">Master Kategori</legend>
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar-kat">
                                        <table id="table_kategori" class="table table-sm">
                                            <thead>
                                                <tr class="d-flex">
                                                    <th class="col-1">Kode</th>
                                                    <th class="col-9">Nama Kategori</th>
                                                    <th class="col-2">Singkatan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($kategori as $kat)
                                                <tr class="row_kategori d-flex">
                                                    <td class="col-1">@if($kat->kat_kodekategori != null){{ $kat->kat_kodekategori }}@endif</td>
                                                    <td class="col-9">{{ $kat->kat_namakategori }}</td>
                                                    <td class="col-2">{{ $kat->kat_singkatan }}</td>
                                                </tr>
                                            @endforeach
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

        .row_departement:hover{
            cursor: pointer;
            background-color: grey;
        }

        .my-custom-scrollbar-dep {
            position: relative;
            height: 260px;
            overflow: auto;
        }
        .my-custom-scrollbar-kat {
            position: relative;
            height: 380px;
            overflow: auto;
        }
        .table-wrapper-scroll-y {
            display: block;
        }

        .fixed_headers {
            width: @table_width;
            table-layout: fixed;
            border-collapse: collapse;

        th { text-decoration: underline; }
        th, td {
            padding: 5px;
            text-align: left;
        }

        td:nth-child(1), th:nth-child(1) { min-width: @column_one_width; }
        td:nth-child(2), th:nth-child(2) { min-width: @column_two_width; }
        td:nth-child(3), th:nth-child(3) { width: @column_three_width; }

        thead {
            background-color: @header_background_color;
            color: @header_text_color;
        tr {
            display: block;
            position: relative;
        }
        }
        tbody {
            display: block;
            overflow: auto;
            width: 100%;
            height: @table_body_height;
        tr:nth-child(even) {
            background-color: @alternate_row_background_color;
        }
        }
        }


    </style>

    <script>
        $('#row_departement_0').addClass('table-success');

        $(document).ready(function () {

        })

        function departement_select(value, row) {
            $('.row_departement').removeClass('table-success');
            $('#row_departement_'+row).addClass('table-success');
            $.ajax({
                url: '/BackOffice/public/mstkategoribarang/departement_select',
                type:'GET',
                data:{"_token":"{{ csrf_token() }}", value: value},
                success: function(response){
                    $('#table_kategori .row_kategori').remove();
                    html = "";
                    for(i=0;i<response.length;i++){
                        html = '<tr class="row_kategori d-flex"><td class="col-1">'+null_check(response[i].kat_kodekategori)+'</td><td class="col-9">'+null_check(response[i].kat_namakategori)+'</td><td class="col-2">'+null_check(response[i].kat_singkatan)+'</td></tr>';
                        $('#table_kategori').append(html);
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
