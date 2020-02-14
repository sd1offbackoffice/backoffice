@extends('navbar')
@section('content')


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Master Perusahaan</legend>
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <div class="row" id="layar-1">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="i_namaperusahaan" class="col-sm-2 col-form-label text-right">Nama Perusahaan</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_namaperusahaan" value ="{{$result->prs_namaperusahaan}}">
                                        </div>
                                        <label for="i_kode" class="col-sm-4 col-form-label text-right">Kode</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" id="i_kode" value ="{{$result->prs_kodeperusahaan}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_kodewilayah" class="col-sm-2 col-form-label text-right">Kode Wilayah</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" id="i_kodewilayah" value ="{{$result->prs_kodewilayah}}">
                                        </div>
                                        <label for="i_namawilayah" class="col-sm-2 col-form-label text-right">Nama Wilayah</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_namawilayah" value ="{{$result->prs_namawilayah}}">
                                        </div>
                                        <label for="i_singkatanwilayah" class="col-sm-5 col-form-label text-right">Singkatan Wilayah</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="i_singkatanwilayah" value ="{{$result->prs_singkatanwilayah}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_koderegion" class="col-sm-2 col-form-label text-right">Kode Region</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" id="i_koderegion" value ="{{$result->prs_koderegional}}">
                                        </div>
                                        <label for="i_namaregion" class="col-sm-2 col-form-label text-right">Nama Region</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_namaregion" value ="{{$result->prs_namaregional}}">
                                        </div>
                                        <label for="i_singkatanregion" class="col-sm-5 col-form-label text-right">Singkatan Region</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="i_singkatanregion" value ="{{$result->prs_singkatanregional}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_kodecabang" class="col-sm-2 col-form-label text-right">Kode Cabang</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" id="i_kodecabang" value ="{{$result->prs_kodecabang}}">
                                        </div>
                                        <label for="i_namacabang" class="col-sm-2 col-form-label text-right">Nama Cabang</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_namacabang" value ="{{$result->prs_namacabang}}">
                                        </div>
                                        <label for="i_singkatancabang" class="col-sm-5 col-form-label text-right">Singkatan Cabang</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="i_singkatancabang" value ="{{$result->prs_singkatancabang}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_kodesbu" class="col-sm-2 col-form-label text-right">Kode SBU</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" id="i_kodesbu" value ="{{$result->prs_kodesbu}}">
                                        </div>
                                        <label for="i_namasbu" class="col-sm-2 col-form-label text-right">Nama SBU</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_namasbu" value ="{{$result->prs_namasbu}}">
                                        </div>
                                        <label for="i_singkatansbu" class="col-sm-5 col-form-label text-right">Singkatan SBU</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="i_singkatansbu" value ="{{$result->prs_singkatansbu}}">
                                        </div>
                                        <label for="i_lokasisbu" class="col-sm-5 col-form-label text-right">Lokasi SBU</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_lokasisbu" value ="{{$result->prs_lokasisbu}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_alamat1" class="col-sm-2 col-form-label text-right">Alamat</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="i_alamat1" value ="{{$result->prs_alamat1}}">
                                            <input type="text" class="form-control" id="i_alamat2" value ="{{$result->prs_alamat2}}">
                                            <input type="text" class="form-control" id="i_alamat3" value ="{{$result->prs_alamat3}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_telepone" class="col-sm-2 col-form-label text-right">Telephone</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="i_telepone" value ="{{$result->prs_telepon}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="layar-2">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <label for="i_npwp" class="col-sm-3 col-form-label text-right">NPWP</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="i_npwp" value ="{{$result->prs_npwp}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="i_ppn" class="col-sm-3 col-form-label text-right">PPN</label>
                                        <div class="col-sm-1">
                                            <input type="text" maxlength="1" class="form-control" id="i_ppn" value ="{{$result->prs_flagppn}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="i_jkp" class="col-sm-3 col-form-label text-right">J K P</label>
                                        <div class="col-sm-1">
                                            <input type="text" maxlength="1" class="form-control" id="i_jkp" value ="{{$result->prs_flagpkp}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="i_jenis_printer" class="col-sm-3 col-form-label text-right">Jenis Printer</label>
                                        <div class="col-sm-1">
                                            <input type="text" maxlength="1" class="form-control" id="i_jenis_printer" value ="{{$result->prs_jenisprinter}}">
                                        </div>
                                        <label for="i_ket_jenis_printer" class="col-sm-5 col-form-label font-weight-bold">[  -UBI / 1 -ZEBRA / 2 -UBI, ZEBRA DAN SATO</label>
                                    </div>
                                    <div class="row">
                                        <label for="i_jenis_timbangan" class="col-sm-3 col-form-label text-right">Jenis Timbangan</label>
                                        <div class="col-sm-1">
                                            <input type="text" maxlength="1" class="form-control" id="i_jenis_timbangan" value ="{{$result->prs_jenistimbangan}}">
                                        </div>
                                        <label for="i_ket_jenis_timbangan" class="col-sm-5 col-form-label font-weight-bold">[  -ISHIDA / 1 -EVERY /2 -BIZERBA /3 -ISHIDA & BIZERBA</label>
                                    </div>
                                    <div class="row">
                                        <label for="i_sk_pengukuhan_pajak" class="col-sm-3 col-form-label text-right">SK Pengukuhan Pajak</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_sk_pengukuhan_pajak" value ="{{$result->prs_nosk}}">
                                        </div>
                                        <label for="i_tanggal" class="col-sm-2 col-form-label text-right">Tanggal</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="i_tanggal" value ="{{date_format(date_create(substr($result->prs_tglsk,0,10)),"d/m/Y")}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="i_alamat_faktur_pajak" class="col-sm-3 col-form-label text-right">Alamat</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_alamat_faktur_pajak1" value ="{{$result->prs_alamatfakturpajak1}}">
                                            <input type="text" class="form-control" id="i_alamat_faktur_pajak2" value ="{{$result->prs_alamatfakturpajak2}}">
                                            <input type="text" class="form-control" id="i_alamat_faktur_pajak3" value ="{{$result->prs_alamatfakturpajak3}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="i_limit_profit_label_baru" class="col-sm-3 col-form-label text-right">Limit Profit Label Biru</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" id="i_limit_profit_label_baru" value ="{{$result->prs_limitprofitlabelbiru}}">
                                        </div>
                                        <label for="i_ket_ppn" class="col-sm-1 col-form-label font-weight-bold text-left">%</label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="i_modal_awal_baru" class="col-sm-3 col-form-label text-right">Modal Awal Rp.</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="i_modal_awal_baru" value ="{{ number_format($result->prs_modalawal) }}">
                                        </div>
                                        <label for="i_flag_commit_order" class="col-sm-3 col-form-label text-right">Flag Commit Order</label>
                                        <div class="col-sm-1">
                                            <input type="text" maxlength="1" class="form-control" id="i_flag_commit_order" value ="{{$result->prs_flagcmo}}">
                                        </div>
                                        <label for="i_tgl_commit_order" class="col-sm-9 col-form-label text-right">Tgl Commit Order</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="i_tgl_commit_order" value ="{{ date_format(date_create(substr($result->prs_tglcmo,0,10)),"d/m/Y") }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="i_periode_bulan_aktif" class="col-sm-3 col-form-label text-right">Periode Bulan Aktif</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="i_periode_bulan_aktif" value ="{{$result->prs_periodebaru}}">
                                        </div>
                                        <label for="i_periode_tahun" class="col-sm-4 col-form-label text-right">Periode Tahun</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="i_periode_tahun" value ="{{$result->prs_tahunberjalan}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                      <label for="i_periode_tanggal_aktif" class="col-sm-3 col-form-label text-right">Periode Tanggal Aktif</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="i_periode_tanggal_aktif" value ="{{ date_format(date_create(substr($result->prs_periodeterakhir,0,10)),"d/m/Y")}}">
                                        </div>
                                        <label for="i_periode_bulan" class="col-sm-4 col-form-label text-right">Periode Bulan</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="i_periode_bulan" value ="{{$result->prs_bulanberjalan}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="i_nomor_seri_faktur_pajak" class="col-sm-3 col-form-label text-right">Nomor Seri Faktur Pajak</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="i_nomor_seri_faktur_pajak" value ="{{$result->prs_noserifakturpajak}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="i_toleransi_harga_po_dgn_faktur" class="col-sm-3 col-form-label text-right">Toleransi Harga PO Dgn Faktur</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" id="i_toleransi_harga_po_dgn_faktur" value ="{{$result->prs_toleransihrg}}">
                                        </div>
                                        <label for="i_ket_toleransi_harga_po_dgn_faktur" class="col-sm-3 col-form-label font-weight-bold">%</label>
                                    </div>
                                    <div class="row">
                                        <label for="i_kode_mto" class="col-sm-3 col-form-label text-right">Kode M.T.O</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" id="i_kode_mto" value ="{{$result->prs_kodemto}}">
                                        </div>
                                        <label for="i_faktor_pengali_kph_mean" class="col-sm-5 col-form-label text-right">Faktor Pengali KPH Mean</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" id="i_faktor_pengali_kph_mean" value ="{{$result->prs_kphconst}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </fieldset>
                <br>
                <div class="form-group row">
                    <label for="i_layar" class="col-sm-2 col-form-label"  id="lbl-layar">Layar 1/2</label>
                    <div class="col-sm-10">
                        <div class="float-right">
                            {{--<button class="btn btn-primary" id="btn-rekam1">Rekam</button>--}}
                            {{--<button class="btn btn-primary" id="btn-rekam2">Rekam</button>--}}
                            <button class="btn btn-primary" id="btn-pindah">Pindah Layar</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="m_kodecabangHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr><tr>
                                        <td></td>
                                        <td></td>
                                    </tr><tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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
            /*color: #8A8A8A;*/
            font-weight: bold;
        }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }
        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>

    <script>

        $( "#layar-1" ).show();
        $( "#layar-2" ).hide();
        // $( "#btn-rekam2" ).hide();
        $(':input').prop('readonly',true);
        $( "#btn-pindah" ).click(function() {
            if($( "#layar-1" ).is(':visible')){
                $( "#layar-1" ).hide();
                $( "#layar-2" ).show();
                // $( "#btn-rekam1" ).hide();
                // $( "#btn-rekam2" ).show();
                $( "#lbl-layar" ).html('Layar 2/2');
            }
            else{
                $( "#layar-1" ).show();
                $( "#layar-2" ).hide();
                // $( "#btn-rekam1" ).show();
                // $( "#btn-rekam2" ).hide();
                $( "#lbl-layar" ).html('Layar 1/2');
            }
        });


    </script>

@endsection
