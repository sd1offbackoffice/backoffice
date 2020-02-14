@extends('navbar')
@section('content')


    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Master Hari Libur</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="my-custom-scrollbar table-wrapper-scroll-y">
                            <table class="table table-sm border-bottom  justify-content-md-center" id="table-barcode">
                                <thead class="thead-dark">
                                <tr class="row justify-content-md-center p-0">
                                    <th class="col-sm-5">Tanggal</th>
                                    <th class="col-sm-4">Keterangan</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--@foreach($barcode as $dataBarcode)
                                    <tr class="row baris justify-content-md-center p-0">
                                        <td class="col-sm-5 pt-0 pb-0" >
                                            <input type="text" class="form-control" disabled value="{{$dataBarcode->brc_barcode}}">
                                        </td>
                                        <td class="col-sm-4 pt-0 pb-0">
                                            <input type="text" class="form-control" disabled value="{{$dataBarcode->brc_prdcd}}">
                                        </td>
                                    </tr>
                                @endforeach--}}
                                </tbody>
                            </table>
                        </div>
                        <br>
                        {{--<div class="form-group row">
                            <label for="i_prdcd" class=" col-sm-2 col-form-label text-right">PRDCD</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="i_prdcd" placeholder="...">
                            </div>
                            <div class="col-sm-3">
                                <div >
                                    <button class="btn btn-success" id="btn-search" onclick="search_barcode()">SEARCH</button>
                                    <button class="btn btn-success" id="btn-clear" onclick="clear_table()">CLEAR</button>
                                </div>
                            </div>
                        </div>--}}
                    </div>
                </fieldset>
            </div>
        </div>
    </div>