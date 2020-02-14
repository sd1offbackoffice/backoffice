@extends('navbar')
@section('content')
    {{--<head>--}}
        {{--<script src="{{asset('/js/bootstrap-select.min.js')}}"></script>--}}
    {{--</head>--}}


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Master Supplier</legend>
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <div class="row text-right">
                                <div class="col-sm-12">
                                    <div class="form-group row mb-0">
                                        <label for="i_kodesupplier" class="col-sm-2 col-form-label">Kode Supplier</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="i_kodesupplier">
                                        </div>
                                        <button type="button" class="btn p-0" data-toggle="modal" data-target="#m_kodesupplierHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                        <label for="i_kodesupplierho" class="col-sm-2 col-form-label">Kode Supplier HO</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="i_kodesupplierho">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="i_namasupplier" class="col-sm-2 col-form-label">Nama Supplier</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" id="i_namasupplier">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row mb-0">
                                        <label for="i_email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-7">
                                            <input type="email" class="form-control" id="i_email">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="i_alamat1" class="col-sm-2 col-form-label">Alamat</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" id="i_alamat1">
                                            <input type="text" class="form-control" id="i_alamat2">
                                            <input type="text" class="form-control" id="i_alamat3">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="i_telepon" class="col-sm-2 col-form-label">Telepon</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" id="i_telepon">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="i_faximile" class="col-sm-2 col-form-label">Faximile</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_faximile">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="i_pkp" class="col-sm-2 col-form-label">Status PKP</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" id="i_pkp">
                                            {{--<div class="custom-control custom-checkbox p-0">--}}
                                                {{--<input type="checkbox" class="custom-control-input" id="i_pkp">--}}
                                                {{--<label class="custom-control-label" for="i_pkp"></label>--}}
                                            {{--</div>--}}
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="i_npwp" class="col-sm-2 col-form-label">N.P.W.P</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="i_npwp">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="i_noskp" class="col-sm-2 col-form-label">No. SKP</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="i_noskp">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="i_tglskp" class="col-sm-2 col-form-label">Tgl. SKP</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="i_tglskp">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="i_jenissupplier" class="col-sm-2 col-form-label">Jenis Supplier</label>
                                        <div class="col-sm-1 pr-0">
                                            <input type="text" class="form-control" id="i_jenissupplier">
                                            {{--<select id="i_jenissupplier" class="browser-default custom-select">--}}
                                                {{--<option selected disabled>Pilih jenis supplier</option>--}}
                                                {{--<option value="K">K - Konsinyasi</option>--}}
                                                {{--<option value="C">C - Counter</option>--}}
                                                {{--<option value="X">Lain - lain</option>--}}
                                            {{--</select>--}}
                                        </div>
                                        <label for="i_penangananbr" class="col-sm-5 col-form-label text-left">K : Konsinyasi | C : Counter | Kosong : Lain-lain</label>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="i_penyerahanfp" class="col-sm-2 col-form-label">Penyerahan F.P</label>
                                        <div class="col-sm-1 pr-0">
                                            <input type="text" class="form-control" id="i_penyerahanfp">
                                            {{--<select id="i_penyerahanfp" class="browser-default custom-select">--}}
                                                {{--<option selected disabled>Pilih Penyerahan F.P</option>--}}
                                                {{--<option value="1">1 - Saat Pengiriman</option>--}}
                                                {{--<option value="2">2 - Saat Penagihan</option>--}}
                                            {{--</select>--}}
                                        </div>
                                        <label for="i_penangananbr" class="col-sm-4 col-form-label text-left">1 : Saat Pengiriman | 2 : Saat Penagihan</label>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="i_penangananbr" class="col-sm-2 col-form-label">Penanganan B.R</label>
                                        <div class="col-sm-1 pr-0">
                                            <input type="text" class="form-control" id="i_penangananbr">
                                            {{--<select id="i_penangananbr" class="browser-default custom-select">--}}
                                                {{--<option selected disabled>Pilih Penanganan B.R</option>--}}
                                                {{--<option value="RT">RT - RETUR</option>--}}
                                                {{--<option value="TG">TG - Tukar Guling</option>--}}
                                                {{--<option value="PT">PT - Putus</option>--}}
                                            {{--</select>--}}
                                        </div>
                                        <label for="i_penangananbr" class="col-sm-4 col-form-label text-left">RT : Retur | TG : Tukar Guling | PT : Putus</label>
                                        <label for="i_minkarton" class="col-sm-2 col-form-label">Min Karton</label>
                                        <div class="col-sm-2">
                                            <input id="i_minkarton" type="number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="i_top" class="col-sm-2 col-form-label">T.O.P</label>
                                        <div class="col-sm-1 pr-0">
                                            <input type="text" class="form-control" id="i_top">
                                        </div>
                                        <label for="i_leadtimetoko" class="col-sm-2 col-form-label">Lead Time Toko</label>
                                        <div class="col-sm-1 pl-0 pr-0">
                                            <input type="text" class="form-control" id="i_leadtimetoko">
                                        </div>
                                        <label for="i_minrupiah" class="col-sm-3 col-form-label">Min Rupiah</label>
                                        <div class="col-sm-2">
                                            <input type="number" class="form-control" id="i_minrupiah">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">

                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="i_leadtimeogm" class="col-sm-2 col-form-label">Lead Time OGM</label>
                                        <div class="col-sm-1 pr-0">
                                            <input type="text" class="form-control" id="i_leadtimeogm">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="i_hari" class="col-sm-2 col-form-label">Hari Kunjungan</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_hari_kunjungan">
                                        </div>
                                        {{--<select id="i_hari_kunjungan" class="selectpicker col-sm-5" multiple data-live-search="false">--}}
                                            {{--<option value="Minggu">Minggu</option>--}}
                                            {{--<option value="Senin">Senin</option>--}}
                                            {{--<option value="Selasa">Selasa</option>--}}
                                            {{--<option value="Rabu">Rabu</option>--}}
                                            {{--<option value="Kamis">Kamis</option>--}}
                                            {{--<option value="Jumat">Jumat</option>--}}
                                            {{--<option value="Sabtu">Sabtu</option>--}}
                                        {{--</select>--}}
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="i_cp" class="col-sm-2 col-form-label">Contact Person</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_cp">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="i_supplierot" class="col-sm-2 col-form-label">Supplier Order Toko</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" id="i_supplierot">
                                        </div>
                                        {{--<div class="pl-3">--}}
                                            {{--<div class="custom-control custom-checkbox p-0">--}}
                                                {{--<input type="checkbox" class="custom-control-input" id="i_supplierot">--}}
                                                {{--<label class="custom-control-label" for="i_supplierot"></label>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        <label for="i_discsupplier" class="col-sm-2 pl-0 pr-0 col-form-label">Discontinue Supplier</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" id="i_discsupplier">
                                        </div>
                                        {{--<div class="">--}}
                                            {{--<div class="custom-control custom-checkbox p-0">--}}
                                                {{--<input type="checkbox" class="custom-control-input" id="i_discsupplier">--}}
                                                {{--<label class="custom-control-label" for="i_discsupplier"></label>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        <label for="i_lastupdate" class="col-sm-2 col-form-label">Update Terakhir</label>
                                        <div class="col-sm-1 pr-0">
                                            <input type="text" class="form-control" id="i_updateby">
                                        </div>
                                        <div class="col-sm-3 pl-0">
                                            <input type="text" class="form-control" id="i_updatedate">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="m_kodesupplierHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="search_lov" class="form-control search_lov" type="text" placeholder="Inputkan Nama / Kode Supplier" aria-label="Search">
                        <div class="invalid-feedback">
                            Inputkan minimal 3 karakter
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm" id="table_lov">
                                    <thead>
                                        <tr>
                                            <td>Nama Supplier</td>
                                            <td>Kode Supplier</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($supplier as $s)
                                        <tr onclick="lov_select('{{ $s->sup_kodesupplier }}')" class="row_lov">
                                            <td>{{ $s->sup_namasupplier }}</td>
                                            <td>{{ $s->sup_kodesupplier }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
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

        .row_lov:hover{
            cursor: pointer;
            background-color: grey;
            color: white;
        }


    </style>

    <script>

        var trlov = $('#table_lov tbody').html();
        var hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

        // lov();

        $('#select').selectpicker();

        $(':input').prop('readonly',true);
        $('.custom-select').prop('disabled',true);
        $('#i_kodesupplier').prop('readonly',false);
        $('#search_lov').prop('readonly',false);

        month = ['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGU','SEP','OKT','NOV','DES'];

        lov_select('{{ $firstsupplier->sup_kodesupplier }}');


        // $(":input").prop('readonly','true');

        $(document).ready(function () {

        })

        $('#m_kodesupplierHelp').on('shown.bs.modal', function () {
            $('#search_lov').focus();
        });

        $('#i_kodesupplier').keypress(function (event) {
            if(event.which == 13 && this.value.length == 5){
               lov_select(this.value);
            }
        });


        function lov_select(value){
            $.ajax({
                url: '/BackOffice/public/mstsupplier/lov_select',
                type:'GET',
                data:{"_token":"{{ csrf_token() }}",value: value},
                success: function(response){
                    if(response == 'not-found'){
                        swal({
                            title: "Data Tidak Ditemukan",
                            icon: "error"
                        });
                        $(':input').val('');
                        $('#i_kodesupplier').val(value);
                    }
                    else {
                        $('#i_kodesupplier').val(response.sup_kodesupplier);
                        $('#i_kodesupplierho').val(response.sup_kodesuppliermcg);
                        $('#i_namasupplier').val(response.sup_namasupplier);
                        $('#i_email').val(response.sup_emailsupplier);
                        $('#i_alamat1').val(response.sup_alamatsupplier1);
                        $('#i_alamat2').val(response.sup_alamatsupplier2);
                        $('#i_alamat3').val(response.sup_kotasupplier3);
                        $('#i_telepon').val(response.sup_telpsupplier);
                        $('#i_faximile').val(response.sup_faxsupplier);

                        $('#i_pkp').val(response.sup_pkp);

                        $('#i_npwp').val(response.sup_npwp);
                        $('#i_noskp').val(response.sup_nosk);

                        if (response.sup_tglsk != null)
                            $('#i_tglskp').val(toDate(response.sup_tglsk));

                        $('#i_jenissupplier').val(response.sup_jenissupplier);

                        $('#i_penyerahanfp').val(response.sup_flagpenyerahanfp);
                        $('#i_penangananbr').val(response.sup_flagpenangananproduk);
                        $('#i_minkarton').val(response.sup_minkarton);
                        $('#i_top').val(response.sup_top + ' hari');
                        $('#i_minrupiah').val(response.sup_minrph);
                        $('#i_leadtimeogm').val(response.sup_jangkawaktukirimbarang + ' hari');

                        var j = 0;
                        hariKunjungan = [];
                        for (i = 0; i < 7; i++) {
                            if (response.sup_harikunjungan[i] == 'Y') {
                                hariKunjungan[j] = hari[i];
                                j++;
                            }
                        }

                        $('#i_hari_kunjungan').val(hariKunjungan);

                        $('#i_cp').val(response.sup_contactperson);

                        $('#i_supplierot').val(response.sup_flagordertoko);

                        $('#i_discsupplier').val(response.sup_flagdiscontinuesupplier);

                        $('#i_updateby').val(response.sup_modify_by);

                        if (response.sup_modify_dt != null)
                            $('#i_updatedate').val(toDate(response.sup_modify_dt));
                    }
                },
                complete: function(){
                    if($('#m_kodesupplierHelp').is(':visible')) {
                        $('.modal').modal('toggle');
                        $('#search_lov').val('');
                        $('#table_lov .row_lov').remove();
                        $('#table_lov').append(trlov);
                    }
                }
            });
        }

        $('#search_lov').keypress(function (e) {
            if (e.which == 13) {
                if(this.value.length == 0) {
                    $('#table_lov .row_lov').remove();
                    $('#table_lov').append(trlov);
                }
                else if(this.value.length >= 3) {
                    $('.invalid-feedback').hide();
                    $.ajax({
                        url: '/BackOffice/public/mstsupplier/lov_search',
                        type: 'GET',
                        data: {"_token": "{{ csrf_token() }}", value: this.value.toUpperCase()},
                        success: function (response) {
                            $('#table_lov .row_lov').remove();
                            html = "";
                            console.log(response.length);
                            for (i = 0; i < response.length; i++) {
                                html = '<tr class="row_lov" onclick=lov_select("' + response[i].sup_kodesupplier + '")><td>' + response[i].sup_namasupplier + '</td><td>' + response[i].sup_kodesupplier + '</td></tr>';
                                $('#table_lov').append(html);
                            }
                        }
                    });
                }
                else{
                    $('.invalid-feedback').show();
                }
            }
        });

        function toDate(value) {
            date = new Date(value);

            return date.getDate() + '-' + month[date.getMonth()] + '-' + date.getFullYear();
        }
    </script>

@endsection
