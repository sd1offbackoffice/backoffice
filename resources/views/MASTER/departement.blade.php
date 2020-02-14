@extends('navbar')
@section('content')


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Master Departement</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <div class="col-sm-8">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-4">Divisi</legend>
                                    <table id="table_divisi" class="table table-sm">
                                        <thead>
                                            <tr class="d-flex">
                                                <th class="col-4">Kode Divisi</th>
                                                <th class="col-8">Nama Divisi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach($divisi as $div)
                                            <tr id="row_divisi_{{ $i }}"class="row_divisi d-flex" onclick="divisi_select('{{ $div->div_kodedivisi }}','{{ $i++ }}')">
                                                <td class="col-4">{{ $div->div_kodedivisi }}</td>
                                                <td class="col-8">{{ $div->div_namadivisi }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </fieldset>
                            </div>

                            <div class="col-sm-12">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-4">Departement</legend>
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table id="table_departement" class="table table-sm">
                                        <thead>
                                        <tr class="d-flex">
                                            <th class="col-sm-1">Kode</th>
                                            <th class="col-sm-4">Nama</th>
                                            <th class="col-sm-1 pl-0 pr-0">Singkatan</th>
                                            <th class="col-sm-2">Kode Manager</th>
                                            <th class="col-sm-2">Kode Security</th>
                                            <th class="col-sm-2">Kode Supervisor</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($departement as $dep)
                                            <tr class="row_departement d-flex">
                                                <td class="col-sm-1">@if($dep->dep_kodedepartement != null){{ $dep->dep_kodedepartement }}@endif</td>
                                                <td class="col-sm-4">{{ $dep->dep_namadepartement }}</td>
                                                <td class="col-sm-1 pl-0 pr-0">{{ $dep->dep_singkatandepartement }}</td>
                                                <td class="col-sm-2">{{ $dep->dep_kodemanager }}</td>
                                                <td class="col-sm-2">@if($dep->dep_kodesecurity != 'null'){{ $dep->dep_kodesecurity }}@endif</td>
                                                <td class="col-sm-2">{{ $dep->dep_kodedepartement }}</td>
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
