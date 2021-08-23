@extends('navbar')
@section('title','Laporan Promosi Redeem via Unique Code')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5 text-center">LAPORAN PROMOSI REDEEM UNIQUE CODE</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Jenis Promosi</label>
                            <input class="col-sm-2 text-center form-control" type="text" id="jenisPromosi">
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Kode Promosi</label>
                            <input class="col-sm-2 text-center form-control" type="text" style="margin-right: 20px;" id="kodePromosi">
                            <input class="col-sm-6 text-center form-control" type="text" disabled>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Periode Promosi</label>
                            <input class="col-sm-3 text-center form-control" type="text" id="daterangepicker">
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Periode Sales</label>
                            <input class="col-sm-2 text-center form-control" type="text" id="daterangepicker">
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Jenis Member</label>
                            <input class="col-sm-2 text-center form-control" type="text" id="jenisMember">
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Item Pembanding</label>
                            <input class="col-sm-2 text-center form-control" type="text" style="margin-right: 20px;">
                            <input class="col-sm-6 text-center form-control" type="text" disabled id="itemPembanding">
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Minimum Pembelian</label>
                            <input class="col-sm-2 text-center form-control" type="text" id="minPembelian">
                        </div>
                        <br>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success col-sm-3" type="button" id="cetak">CETAK</button>
                        </div>
                        <br>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <script>
        $('#daterangepicker').daterangepicker({
           