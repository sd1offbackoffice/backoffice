@extends('navbar')
@section('title','MASTER | MASTER KATEGORI BARANG')
@section('content')


    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <div class="col-sm-8">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-4">Departement</legend>
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar-dep tableFixHead">
                                        <table id="table_departement" class="table table-sm">
                                            <thead class="theadDataTables">
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
                                                <tr id="row_departement_{{ $i }}"class="row_departement row_lov d-flex" onclick="departement_select('{{ $dep->dep_kodedepartement }}','{{ $i++ }}')">
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
                                            <thead class="theadDataTables">
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
                </div>
            </div>
        </div>
    </div>

    <style>
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
    </style>

    <script>
        $('#row_departement_0').addClass('table-primary');

        $(document).ready(function () {

        })

        function departement_select(value, row) {
            $('.row_departement').removeClass('table-primary');
            $('#row_departement_'+row).addClass('table-primary');
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
                },  error: function(err){
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
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
