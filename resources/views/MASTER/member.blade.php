@extends('navbar')
@section('content')


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Master Member</legend>
                    <div class="card-body">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="form-group row mb-0">
                                    <label for="i_kodemember" class="col-sm-2 col-form-label">Nomor Anggota</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="i_kodemember">
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn p-0" data-toggle="modal" data-target="#m_kodememberHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                    </div>
                                    <label for="i_statusmember" class="col-sm-2 col-form-label"></label>
                                    <label for="i_statusmember" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="i_statusmember">
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="i_namamember" class="col-sm-2 col-form-label">Nama Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="i_namamember">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs custom-color" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#p_identitas">Identitas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#p_identitas2">Identitas 2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#p_identitas3">Identitas 3</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#p_hobby">Hobby</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#p_alamatnpwp">Alamat NPWP</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#p_fasilitasbank">Fasilitas Perbankan</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="p_identitas" class="container tab-pane active pl-0 pr-0 fix-height">
                            <div class="card-body ">
                                <div class="row text-right">
                                    <div class="col-sm-12">
                                        <div class="form-group row mb-0">
                                            <label for="i_noktp" class="col-sm-2 col-form-label">No. KTP<span class="wajib">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="i_noktp">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_alamatktp" class="col-sm-2 col-form-label">Alamat KTP<span class="wajib">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="i_alamatktp">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_kelurahanktp" class="col-sm-2 col-form-label">Kelurahan<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_kelurahanktp">
                                            </div>
                                            <div class="col-sm-1">
                                                <button type="button" class="btn p-0" data-toggle="modal" data-target="#m_kodeposHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                            </div>
                                            <label for="i_kecamatanktp" class="col-sm-2 col-form-label">Kecamatan<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_kecamatanktp">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_kodeposktp" class="col-sm-2 col-form-label">Kode Pos<span class="wajib">*</span></label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_kodeposktp">
                                            </div>
                                            <label for="i_kotaktp" class="col-sm-4 col-form-label">Kota<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_kotaktp">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_alamatsurat" class="col-sm-2 col-form-label">Alamat Surat<span class="wajib">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="i_alamatsurat">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_kelurahansurat" class="col-sm-2 col-form-label">Kelurahan<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_kelurahansurat">
                                            </div>
                                            <div class="col-sm-1">
                                                <button type="button" class="btn p-0" data-toggle="modal" data-target="#m_kodememberHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                            </div>
                                            <label for="i_kecamatansurat" class="col-sm-2 col-form-label">Kecamatan<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_kecamatansurat">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_kodepossurat" class="col-sm-2 col-form-label">Kode Pos<span class="wajib">*</span></label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_kodepossurat">
                                            </div>
                                            <label for="i_kotasurat" class="col-sm-4 col-form-label">Kota<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_kotasurat">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_telepon" class="col-sm-2 col-form-label">Telepon<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_telepon">
                                            </div>
                                            <label for="i_hp" class="col-sm-3 col-form-label">HP<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_hp">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_tempatlahir" class="col-sm-2 col-form-label">Tempat Lahir<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_tempatlahir">
                                            </div>
                                            <label for="i_tgllahir" class="col-sm-3 col-form-label">Tgl. Lahir<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_tgllahir">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_jeniscustomer" class="col-sm-2 col-form-label">Jenis Customer</label>
                                            <div class="col-sm-1 pr-0">
                                                <input type="text" class="form-control" id="i_jeniscustomer1">
                                            </div>
                                            <div class="col-sm-2 pl-0">
                                                <input type="text" class="form-control" id="i_jeniscustomer2">
                                            </div>
                                            <label for="i_jenisoutlet" class="col-sm-3 col-form-label">Jenis Outlet</label>
                                            <div class="col-sm-1 pr-0">
                                                <input type="text" class="form-control" id="i_jenisoutlet1">
                                            </div>
                                            <div class="col-sm-2 pl-0">
                                                <input type="text" class="form-control" id="i_jenisoutlet2">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_jarak" class="col-sm-2 col-form-label">Jarak</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_jarak">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_pkp" class="col-sm-2 col-form-label">PKP</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="i_pkp">
                                            </div>
                                            <label for="i_pkp" class="col-sm-1 col-form-label pl-0 text-left">[ Y / T ]</label>
                                            <label for="i_npwp" class="col-sm-4 col-form-label">NPWP</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_npwp">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_flagkredit" class="col-sm-2 col-form-label">Flag Kredit</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="i_flagkredit">
                                            </div>
                                            <label for="i_flagkredit" class="col-sm-1 col-form-label pl-0 text-left">[ Y / T ]</label>
                                            <label for="i_limit" class="col-sm-1 col-form-label">Limit</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_limit">
                                            </div>
                                            <label for="i_top" class="col-sm-1 col-form-label">TOP</label>
                                            <div class="col-sm-1 pr-0">
                                                <input type="text" class="form-control" id="i_top">
                                            </div>
                                            <label for="i_limit" class="col-sm-1 col-form-label text-left pl-0">Hari</label>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_salesman" class="col-sm-2 col-form-label">Salesman</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_salesman">
                                            </div>
                                            <label for="i_memberkhusus" class="col-sm-4 col-form-label">Member Khusus</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="i_memberkhusus">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_kirimsms" class="col-sm-2 col-form-label">Kirim SMS</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="i_kirimsms">
                                            </div>
                                            <label for="i_kirimsms" class="col-sm-1 col-form-label pl-0 text-left">[ Y / T ]</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="p_identitas2" class="container tab-pane fade pl-0 pr-0 fix-height">
                            <div class="card-body ">
                                <div class="row text-right">
                                    <div class="col-sm-12">
                                        <div class="form-group row mb-0">
                                            <label for="i_group" class="col-sm-2 col-form-label">Group<span class="wajib">*</span></label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_group">
                                            </div>
                                            <label for="i_kategori" class="col-sm-4 col-form-label">Kategori</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_kategori">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_subgroup" class="col-sm-2 col-form-label">Sub Group</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_subgroup">
                                            </div>
                                            <label for="i_subkategori" class="col-sm-3 col-form-label">Sub Kategori</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_subkategori">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_jenisanggota" class="col-sm-2 col-form-label">Jenis Anggota<span class="wajib">*</span></label>
                                            <div class="col-sm-1">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input" id="i_jenisanggotaR">
                                                    <label class="custom-control-label" for="i_jenisanggotaR">Regular</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input" id="i_jenisanggotaK">
                                                    <label class="custom-control-label" for="i_jenisanggotaK">Khusus</label>
                                                </div>
                                            </div>
                                            <label for="i_jeniskelamin" class="col-sm-4 col-form-label">Jenis Kelamin<span class="wajib">*</span></label>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="checkbox-inline custom-control-input" id="i_jeniskelaminL">
                                                    <label class="custom-control-label" for="i_jeniskelaminL">Laki-laki</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input" id="i_jeniskelaminP">
                                                    <label class="custom-control-label" for="i_jeniskelaminP">Perempuan</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_cp1" class="col-sm-2 col-form-label">Contact Person 1</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="i_cp1">
                                            </div>
                                            <label for="i_nohp1" class="col-sm-2 col-form-label">No. HP 1</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_nohp1">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_cp2" class="col-sm-2 col-form-label">Contact Person 2</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="i_cp2">
                                            </div>
                                            <label for="i_nohp2" class="col-sm-2 col-form-label">No. HP 2</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_nohp2">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_email" class="col-sm-2 col-form-label">Alamat Email<span class="wajib">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="i_email">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_agama" class="col-sm-2 col-form-label">Agama<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <select class="browser-default custom-select" id="i_agama">
                                                    <option selected disabled>Pilih Agama</option>
                                                    <option value="ISLAM">Islam</option>
                                                    <option value="KRISTEN">Kristen</option>
                                                    <option value="KATHOLIK">Katholik</option>
                                                    <option value="BUDHA">Budha</option>
                                                    <option value="HINDU">Hindu</option>
                                                    <option value="ALIRAN">Aliran Kepercayaan</option>
                                                </select>
                                            </div>
                                            <label for="i_pekerjaan" class="col-sm-3 col-form-label">Pekerjaan</label>
                                            <div class="col-sm-3">
                                                <select class="browser-default custom-select" id="i_pekerjaan">
                                                    <option selected disabled>Pilih Pekerjaan</option>
                                                    <option value="wiraswasta">Wiraswasta</option>
                                                    <option value="pegawainegeri">Pegawai Negeri</option>
                                                    <option value="pegawaiswasta">Pegawai Swasta</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_namasuami-istri" class="col-sm-2 col-form-label">Nama Suami / Istri</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="i_namasuami-istri">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_tgllahirpasangan" class="col-sm-2 col-form-label">Tgl. Lahir Pasangan</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_tgllahirpasangan">
                                            </div>
                                            <label for="i_jmlanak" class="col-sm-3 col-form-label">Jumlah Anak</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="i_jmlanak">
                                            </div>
                                            <label for="i_jmlanak" class="col-sm-1 pl-0 text-left col-form-label">Anak</label>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_pendidikan" class="col-sm-2 col-form-label">Pendidikan Terakhir</label>
                                            <div class="col-sm-3">
                                                <select class="browser-default custom-select" id="i_pendidikan">
                                                    <option selected disabled>...</option>
                                                    <option value="SD">SD</option>
                                                    <option value="SLTP">SLTP</option>
                                                    <option value="SLTA">SLTA</option>
                                                    <option value="S-1">S-1</option>
                                                    <option value="S-2">S-2</option>
                                                    <option value="S-3">S-3</option>
                                                    <option value="X">Lainnya</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 pl-0">
                                                <input type="text" class="form-control" id="i_pendidikanX">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_nof" class="col-sm-2 col-form-label">No. F</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_nof">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_internet" class="col-sm-5 col-form-label">Apakah HP Anda menggunakan Layanan Data / Internet<span class="wajib">*</span></label>
                                            <div class="col-sm-1">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input" id="i_internetY">
                                                    <label class="custom-control-label" for="i_internetY">Ya</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input" id="i_internetT">
                                                    <label class="custom-control-label" for="i_internetT">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_merktipehp" class="col-sm-5 col-form-label">Merk dan Tipe HP yang digunakan</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="i_merktipehp">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_banksekarang" class="col-sm-5 col-form-label">Bank yang sekarang digunakan<span class="wajib">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="i_banksekarang">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_metodeinformasi" class="col-sm-5 col-form-label">Metode yang paling disukai dalam<br> menyampaikan informasi<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <select class="browser-default custom-select" id="i_metodeinformasi">
                                                    <option selected disabled>...</option>
                                                    <option value="POSR">Pos ke alamat rumah</option>
                                                    <option value="POSK">Pos ke alamat tempat usaha</option>
                                                    <option value="EMAIL">e-mail</option>
                                                    <option value="SMS">SMS</option>
                                                    <option value="X">Lainnya</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3 pl-0">
                                                <input type="text" class="form-control" id="i_metodeinformasiX">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_koordinat" class="col-sm-5 col-form-label">Koordinat Tempat Usaha</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="i_koordinat">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="p_identitas3" class="container tab-pane fade pl-0 pr-0 fix-height">
                            <div class="card-body ">
                                <div class="row text-right">
                                    <div class="col-sm-12">
                                        <div class="form-group row mb-0">
                                            <label for="i_alamatusaha" class="col-sm-2 pl-0 col-form-label">Alamat Tempat Usaha<span class="wajib">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="i_alamatusaha">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_kelurahanusaha" class="col-sm-2 col-form-label">Kelurahan<span class="wajib">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="i_kelurahanusaha">
                                            </div>
                                            <label for="i_kecamatanusaha" class="col-sm-2 col-form-label">Kecamatan<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_kecamatanusaha">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_kodeposusaha" class="col-sm-2 col-form-label">Kode Pos<span class="wajib">*</span></label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_kodeposusaha">
                                            </div>
                                            <label for="i_kotausaha" class="col-sm-4 col-form-label">Kota<span class="wajib">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_kotausaha">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_jenisusaha" class="col-sm-4 col-form-label">Apakah jenis Tempat Usaha Anda?<span class="wajib">*</span></label>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input" id="i_jenisbangunanP">
                                                    <label class="custom-control-label" for="i_jenisbangunanP">Permanen</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input" id="i_jenisbangunanS">
                                                    <label class="custom-control-label" for="i_jenisbangunanS">Semi Permanen</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input" id="i_jenisbangunanN">
                                                    <label class="custom-control-label" for="i_jenisbangunanN">Non Permanen</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_lamamenempati" class="col-sm-2 col-form-label">Lama menempati<span class="wajib">*</span></label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="i_lamamenempati">
                                            </div>
                                            <label for="i_lamamenempati" class="col-sm-1 pl-0 text-left col-form-label">Tahun</label>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_statusbangunan" class="col-sm-2 col-form-label">Status Bangunan<span class="wajib">*</span></label>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input" id="i_statusbangunanM">
                                                    <label class="custom-control-label" for="i_statusbangunanM">Milik Sendiri</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input" id="i_statusbangunanS">
                                                    <label class="custom-control-label" for="i_statusbangunanS">Sewa</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_kreditusaha" class="col-sm-2 col-form-label">Kredit Usaha</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="i_kreditusaha">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_kreditbank" class="col-sm-2 pl-0 col-form-label">Bank Penerima Kredit</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="i_kreditbank">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_jenikendaraan" class="col-sm-2 col-form-label">Jenis Kendaraan</label>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input" id="i_jenikendaraanMotor">
                                                    <label class="custom-control-label" for="i_jenikendaraanMotor">Motor</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 pl-0 pr-0">
                                                <select class="browser-default custom-select" id="i_motor">
                                                    <option selected disabled>...</option>
                                                    <option value="HONDA">HONDA</option>
                                                    <option value="YAMAHA">YAMAHA</option>
                                                    <option value="KAWASAKI">KAWASAKI</option>
                                                    <option value="SUZUKI">SUZUKI</option>
                                                    <option value="X">LAINNYA</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3 pl-0">
                                                <input type="text" class="form-control" id="i_motorX">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_jenikendaraan" class="col-sm-2 col-form-label">Jenis Kendaraan</label>
                                            <div class="col-sm-2">
                                                <div class="custom-control custom-checkbox mt-2 text-left">
                                                    <input type="checkbox" class="custom-control-input" id="i_jenikendaraanMobil">
                                                    <label class="custom-control-label" for="i_jenikendaraanMobil">Mobil</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 pl-0 pr-0">
                                                <select class="browser-default custom-select" id="i_mobil">
                                                    <option selected disabled>...</option>
                                                    <option value="TOYOTA">TOYOTA</option>
                                                    <option value="DAIHATSU">DAIHATSU</option>
                                                    <option value="MITSUBISHI">MITSUBISHI</option>
                                                    <option value="SUZUKI">SUZUKI</option>
                                                    <option value="HONDA">HONDA</option>
                                                    <option value="X">LAINNYA</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3 pl-0">
                                                <input type="text" class="form-control" id="i_mobilX">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="p_hobby" class="container tab-pane fade pl-0 pr-0 fix-height">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-10">
                                        <div class="card border-secondary">
                                            <div class="table-wrapper-scroll-y my-custom-scrollbar-hobby">
                                                <table id="table_hobby" class="table table-sm table-bordered">
                                                    <thead>
                                                    <tr class="d-flex text-center">
                                                        <th class="col-sm-5">Nama Hobby</th>
                                                        <th class="col-sm-1"></th>
                                                        <th class="col-sm-6">Keterangan</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php $i = 0 @endphp
                                                    @foreach($hobby as $h)
                                                    @php $i++ @endphp
                                                    <tr class="row_hobby_{{ $i }} d-flex" id="{{ $h->hob_kodehobby }}">
                                                        <td class="col-sm-5"><label for="i_group" class="col-sm-12 col-form-label">{{ $h->hob_namahobby }}</label></td>
                                                        <td class="col-sm-1">
                                                            <div class="custom-control custom-checkbox text-center">
                                                                <input onchange="hobby(event)" type="checkbox" class="custom-control-input" id="i_{{ $h->hob_kodehobby }}">
                                                                <label class="custom-control-label mt-2" for="i_{{ $h->hob_kodehobby }}"></label>
                                                            </div>
                                                        </td>
                                                        <td class="col-sm-6">
                                                            <input disabled type="text" class="form-control" id="i_{{ $h->hob_kodehobby }}_ket">
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-1"></div>
                                </div>
                            </div>
                        </div>
                        <div id="p_alamatnpwp" class="container tab-pane fade pl-0 pr-0 fix-height">
                            <div class="card-body ">
                                <div class="row text-right">
                                    <div class="col-sm-12">
                                        <div class="form-group row mb-0">
                                            <label for="i_tglmulai" class="col-sm-3 pl-0 col-form-label">Tanggal Mulai</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglmulai">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_tglregis" class="col-sm-3 pl-0 col-form-label">Tanggal Registrasi</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglregis">
                                            </div>
                                            <label for="i_bebasiuran" class="col-sm-4 pl-0 col-form-label">Bebas Iuran</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="i_bebasiuran">
                                            </div>
                                            <label for="i_bebasiuran" class="col-sm-1 pl-0 text-left col-form-label">( Y /  )</label>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_emailnpwp" class="col-sm-3 pl-0 col-form-label">Alamat Email</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="i_emailnpwp">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_nomorkartu" class="col-sm-3 pl-0 col-form-label">Nomor Kartu</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_nomorkartu">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_blockpengiriman" class="col-sm-3 pl-0 col-form-label">Blocking Pengiriman</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="i_blockpengiriman">
                                            </div>
                                            <label for="i_bebasiuran" class="col-sm-1 pl-0 text-left col-form-label">( Y /  )</label>
                                        </div>
                                        <div class="form-group row">
                                            <label for="i_flagpemerintah" class="col-sm-3 pl-0 col-form-label">Flag Institusi Pemerintah</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="i_flagpemerintah">
                                            </div>
                                            <label for="i_flagpemerintah" class="col-sm-1 pl-0 text-left col-form-label">( Y /  )</label>
                                        </div>

                                        <fieldset class="card border-secondary">
                                            <div class="card-header pb-0">
                                                <h5 class="text-left">NPWP</h5>
                                            </div>
                                            <div class="card-body ">
                                                <div class="row text-right">
                                                    <div class="col-sm-12">
                                                        <div class="form-group row mb-0">
                                                            <label for="i_npwpalamat" class="col-sm-3 pl-0 col-form-label">Alamat</label>
                                                            <div class="col-sm-8 pl-0">
                                                                <input type="text" class="form-control" id="i_npwpalamat">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="i_npwpkelurahan" class="col-sm-3 pl-0 col-form-label">Kelurahan</label>
                                                            <div class="col-sm-3 pl-0">
                                                                <input type="text" class="form-control" id="i_npwpkelurahan">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="i_npwpkota" class="col-sm-3 pl-0 col-form-label">Kota</label>
                                                            <div class="col-sm-3 pl-0">
                                                                <input type="text" class="form-control" id="i_npwpkota">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="i_npwpkodepos" class="col-sm-3 pl-0 col-form-label">Kode Pos</label>
                                                            <div class="col-sm-2 pl-0">
                                                                <input type="text" class="form-control" id="i_npwpkodepos">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="p_fasilitasbank" class="container tab-pane fade pl-0 pr-0 fix-height">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-6">
                                        <div class="card border-secondary">
                                            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                                <table id="table_fasilitas_perbankan" class="table table-sm table-bordered mb-0">
                                                    <thead>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($fasilitasperbankan as $fp)
                                                    <tr class="row_fasilitasperbankan d-flex">
                                                        <td class="col-sm-1">
                                                            <div class="custom-control custom-checkbox text-center">
                                                                <input type="checkbox" class="custom-control-input" id="i_fp_{{ $fp->fba_kodefasilitasbank }}">
                                                                <label class="custom-control-label ml-1" for="i_fp_{{ $fp->fba_kodefasilitasbank }}"></label>
                                                            </div>
                                                        </td>
                                                        <td class="col-sm-11">{{ $fp->fba_namafasilitasbank }}</td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="i_updateterakhir" class="col-sm-2 col-form-label">Update Terakhir</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="i_updateterakhir">
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-sm-2">

                                    </div>
                                    <div class="col-sm-1">
                                        <button class="btn btn-primary">REKAM</button>
                                    </div>
                                    <div class="col-sm-2 pl-0">
                                        <button class="btn btn-primary">AKTIF / NONAKTIF</button>
                                    </div>
                                    <div class="col-sm-1 pl-0">
                                        <button class="btn btn-danger">HAPUS</button>
                                    </div>
                                    <div class="col-sm-5">
                                        <button class="btn btn-success">EXPORT KE CRM</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="m_kodememberHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="search_lov_member" class="form-control search_lov" type="text" placeholder="Inputkan Nama / Kode Member" aria-label="Search">
                        <div class="invalid-feedback">
                            Inputkan minimal 4 karakter
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov">
                                    <thead>
                                    <tr>
                                        <td>Nama Member</td>
                                        <td>Kode Member</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($member as $m)
                                        <tr onclick="lov_select('{{ $m->cus_kodemember }}')" class="row_lov">
                                            <td>{{ $m->cus_namamember }}</td>
                                            <td>{{ $m->cus_kodemember }}</td>
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

    <div class="modal fade" id="m_kodeposHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="search_lov_kodepos" class="form-control search_lov" type="text" placeholder="Cari Nama Kelurahan" aria-label="Search">
                        <div class="invalid-feedback">
                            Inputkan minimal 4 karakter
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov">
                                    <thead>
                                    <tr>
                                        <td>Kelurahan</td>
                                        <td>Kecamatan</td>
                                        <td>Kota</td>
                                        <td>Provinsi</td>
                                        <td>Kode Pos</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($kodepos as $k)
                                        <tr onclick="lov_select('{{ $m->cus_kodemember }}')" class="row_lov">
                                            <td>{{ $k->pos_kelurahan }}</td>
                                            <td>{{ $k->pos_kecamatan }}</td>
                                            <td>{{ $k->pos_kabupaten }}</td>
                                            <td>{{ $k->pos_propinsi }}</td>
                                            <td>{{ $k->pos_kode }}</td>
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

    {{--LOADER--}}
    <div class="modal fade" id="modal-loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="vertical-align: middle;">
        <div class="modal-dialog modal-dialog-centered" role="document" >
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="loader" id="loader"></div>
                            <div class="col-sm-12">
                                <label for="">LOADING...s</label>
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
        .card-form {
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

        .my-custom-scrollbar-hobby {
            position: relative;
            height: 650px;
            overflow: auto;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 380px;
            overflow: auto;
        }
        .table-wrapper-scroll-y {
            display: block;
        }

        .custom-color li a{
            background-color: lightgrey;
        }

        .fix-height{
            height: 672px;
        }

        .wajib{
            color: red;
        }

    </style>

    <script>
        month = ['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGU','SEP','OKT','NOV','DES'];
        trlov = $('#table_lov tbody').html();

        $('#i_pendidikanX').hide();
        $('#i_metodeinformasiX').hide();
        $('#i_motor').hide();
        $('#i_motorX').hide();
        $('#i_mobil').hide();
        $('#i_mobilX').hide();

        // $(':input').prop('readonly',true);
        $('#search_lov').prop('readonly',false);
        $('#i_kodemember').prop('readonly',false);

        $('#i_kodemember').on('keypress',function (event) {
            if(event.which == 13){
                lov_select(this.value);
            }
        });

        function lov_member_select(value){
            $.ajax({
                url: '/BackOffice/public/mstmember/lov_member_select',
                type:'GET',
                data:{"_token":"{{ csrf_token() }}",value: value},
                success: function(response){
                    if(response == 'not-found'){
                        swal({
                            title: "Data Tidak Ditemukan",
                            icon: "error"
                        });
                        $(':input').val('');
                        $('#i_kodemember').val(value);
                    }
                    else {
                        member = response['member'];
                        ktp = response['ktp'];
                        surat = response['surat'];
                        usaha = response['usaha'];
                        jenismember = response['jenismember'];
                        outlet = response['outlet'];
                        group = response['group'];
                        npwp = response['npwp'];

                        $(':input').val('');
                        $(':input').prop('checked',false);

                        $('#i_kodemember').val(member.cus_kodemember);
                        $('#i_namamember').val(member.cus_namamember);

                        //######################################################### panel identitas 1 ######################################################################
                        $('#i_noktp').val(member.cus_ktp);
                        $('#i_alamatktp').val(member.cus_alamatmember1);
                        $('#i_kelurahanktp').val(ktp.pos_kelurahan);
                        $('#i_kecamatanktp').val(ktp.pos_kecamatan);
                        $('#i_kotaktp').val(member.cus_alamatmember2);
                        $('#i_kodeposktp').val(member.cus_alamatmember3);
                        $('#i_alamatsurat').val(member.cus_alamatmember5);
                        $('#i_kelurahansurat').val(member.cus_alamatmember8);
                        $('#i_kecamatansurat').val(surat.pos_kecamatan);
                        $('#i_kotasurat').val(member.cus_alamatmember6);
                        $('#i_kodepossurat').val(member.cus_alamatmember7);
                        $('#i_telepon').val(member.cus_tlpmember);
                        $('#i_hp').val(member.cus_hpmember);
                        $('#i_tempatlahir').val(member.crm_tmptlahir);
                        $('#i_tgllahir').val(toDate(member.cus_tgllahir));
                        $('#i_jeniscustomer1').val(jenismember.jm_kode);
                        $('#i_jeniscustomer2').val(jenismember.jm_keterangan);
                        $('#i_jenisoutlet1').val(outlet.out_kodeoutlet);
                        $('#i_jenisoutlet2').val(outlet.out_namaoutlet);
                        $('#i_jarak').val(member.cus_jarak);
                        $('#i_pkp').val(member.cus_flagpkp);
                        $('#i_npwp').val(member.cus_npwp);
                        $('#i_flagkredit').val(member.cus_flagkredit);
                        $('#i_limit').val(member.cus_creditlimit);
                        $('#i_top').val(member.cus_top);
                        $('#i_salesman').val(member.cus_nosalesman);
                        $('#i_memberkhusus').val(member.cus_flagmemberkhusus);
                        $('#i_kirimsms').val(member.cus_flagkirimsms);

                        //######################################################### panel identitas 2 ######################################################################
                        if(member.crm_kodemember != null){
                            $('#i_group').val(group.grp_group);
                            $('#i_subgroup').val(group.grp_subgroup);
                            $('#i_kategori').val(group.grp_kategori);
                            $('#i_subkategori').val(group.grp_subkategori);
                        }
                        if(member.crm_jenisanggota == 'R'){
                            $('#i_jenisanggotaR').prop('checked',true);
                        }
                        else if(member.crm_jenisanggota == 'K'){
                            $('#i_jenisanggotaK').prop('checked',true);
                        }
                        if(member.crm_jeniskelamin == 'L'){
                            $('#i_jeniskelaminL').prop('checked',true);
                        }
                        else if(member.crm_jeniskelamin == 'P'){
                            $('#i_jeniskelaminP').prop('checked',true);
                        }
                        $('#i_cp1').val(member.crm_pic1);
                        $('#i_nohp1').val(member.crm_nohppic1);
                        $('#i_cp2').val(member.crm_pic2);
                        $('#i_nohp2').val(member.crm_nohppic2);
                        $('#i_email').val(member.crm_email);
                        $('#i_agama').val(to_uppercase(member.crm_agama));
                        $('#i_pekerjaan').val(member.crm_pekerjaan);
                        $('#i_namasuami-istri').val(member.crm_namapasangan);
                        $('#i_tgllahirpasangan').val(toDate(member.crm_tgllahirpasangan));
                        $('#i_jmlanak').val(member.crm_jmlanak);
                        if(member.crm_pendidikanakhir != ''){
                            $('#i_pendidikan').val(member.crm_pendidikanakhir);
                            $('#i_pendidikanX').hide();
                        }
                        else{
                            $('#i_pendidikan').val('X');
                            $('#i_pendidikanX').show();
                        }
                        $('#i_nof').val(member.crm_nofax);
                        if(member.crm_internet == 'Y'){
                            $('#i_internetY').prop('checked',true);
                        }
                        else if(member.crm_jeniskelamin == 'T'){
                            $('#i_internetT').prop('checked',true);
                        }
                        $('#i_merktipehp').val(member.crm_tipehp);
                        $('#i_banksekarang').val(member.crm_namabank);
                        $('#i_metodeinformasi').val(member.crm_metodekirim);
                        if($('#i_metodeinformasi').val() == null || $('#i_metodeinformasi').val() == 'X'){
                            $('#i_metodeinformasiX').show();
                            $('#i_metodeinformasiX').val(member.crm_metodekirim);
                        }
                        else $('#i_metodeinformasiX').hide();
                        $('#i_koordinat').val(member.crm_koordinat);

                        //#########################################################panel identitas 3######################################################################
                        $('#i_alamatusaha').val(member.crm_alamatusaha1);
                        $('#i_kelurahanusaha').val(member.crm_alamatusaha4);
                        $('#i_kecamatanusaha').val(usaha.pos_kecamatan);
                        $('#i_kodeposusaha').val(usaha.pos_kode);
                        $('#i_kotausaha').val(member.crm_alamatusaha2);
                        if(member.crm_jenisbangunan != '')
                            $('#i_jenisbangunan'+member.crm_jenisbangunan).prop('checked',true);
                        $('#i_lamamenempati').val(member.crm_lamatmpt);
                        if(member.crm_statusbangunan != '')
                            $('#i_statusbangunan'+member.crm_statusbangunan).prop('checked',true);
                        $('#i_kreditusaha').val(member.crm_kreditusaha);
                        $('#i_kreditbank').val(member.crm_bankkredit);
                        if(member.crm_motor != '' && member.crm_motor != null){
                            $('#i_motor').val(member.crm_motor);
                            if($('#i_motor').val() != null) {
                                $('#i_jenikendaraanMotor').prop('checked', true);
                                $('#i_motor').show();
                                $('#i_motorX').hide();
                            }
                            else{
                                $('#i_motor').val('X');
                                $('#i_motorX').val(member.crm_motor);
                                $('#i_motorX').show();
                            }
                        }
                        else{
                            $('#i_motor').hide();
                            $('#i_motorX').hide();
                        }
                        if(member.crm_mobil != '' && member.crm_mobil != null){
                            $('#i_mobil').val(member.crm_mobil);
                            if($('#i_mobil').val() != null) {
                                $('#i_jenikendaraanMobil').prop('checked', true);
                                $('#i_mobil').show();
                                $('#i_mobilX').hide();
                            }
                            else{
                                $('#i_mobil').val('X');
                                $('#i_mobilX').val(member.crm_mobil);
                                $('#i_mobilX').show();
                            }
                        }
                        else{
                            $('#i_mobil').hide();
                            $('#i_mobilX').hide();
                        }

                        //######################################################### panel hobby ######################################################################
                        for(i=0;i<response['hobbymember'].length;i++){
                            $('#i_'+response['hobbymember'][i].dhb_kodehobby).prop('checked',true);
                            if(response['hobbymember'][i].dhb_keterangan != null && response['hobbymember'][i].dhb_keterangan != ''){
                                $('#i_'+response['hobbymember'][i].dhb_kodehobby+'_ket').val(response['hobbymember'][i].dhb_keterangan);
                                $('#i_'+response['hobbymember'][i].dhb_kodehobby+'_ket').prop('disabled',false);
                            }
                            else{
                                $('#i_'+response['hobbymember'][i].dhb_kodehobby+'_ket').val('');
                            }
                        }

                        //######################################################### panel npwp ######################################################################
                        $('#i_tglmulai').val(toDate(member.cus_tglmulai));
                        $('#i_tglregis').val(toDate(member.cus_tglregistrasi));
                        $('#i_bebasiuran').val(member.cus_flagbebasiuran);
                        $('#i_emailnpwp').val(member.cus_alamatemail);
                        $('#i_nomorkartu').val(member.cus_nokartumember);
                        $('#i_blockpengiriman').val(member.cus_flagblockingpengiriman);
                        $('#i_flagpemerintah').val(member.cus_flaginstitusipemerintah);

                        if(npwp != '' && npwp != null){
                            $('#i_npwpalamat').val(npwp.pwp_alamat);
                            $('#i_npwpkelurahan').val(npwp.pwp_kelurahan);
                            $('#i_npwpkota').val(npwp.pwp_kota);
                            $('#i_npwpkodepos').val(npwp.pwp_kodepos);
                        }
                        else{
                            $('#i_npwpalamat').val(member.cus_alamatmember1);
                            $('#i_npwpkelurahan').val(member.cus_alamatmember4);
                            $('#i_npwpkota').val(member.cus_alamatmember2);
                            $('#i_npwpkodepos').val(member.cus_alamatmember3);
                        }

                    }
                },
                complete: function(){
                    if($('#m_kodememberHelp').is(':visible')) {
                        $('.modal').modal('toggle');
                        $('#search_lov').val('');
                        $('#table_lov .row_lov').remove();
                        $('#table_lov').append(trlov);
                    }
                }
            });
        }

        $('#search_lov_member').keypress(function (e) {
            if (e.which == 13) {
                if(this.value.length == 0) {
                    $('.invalid-feedback').hide();
                    $('#table_lov .row_lov').remove();
                    $('#table_lov').append(trlov);
                }
                else if(this.value.length >= 4) {
                    $('.invalid-feedback').hide();
                    $.ajax({
                        url: '/BackOffice/public/mstmember/lov_member_search',
                        type: 'GET',
                        data: {"_token": "{{ csrf_token() }}", value: this.value.toUpperCase()},
                        beforeSend: function(){
                            $('#m_kodememberHelp').modal({backdrop: 'static', keyboard: false});
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            $('#table_lov .row_lov').remove();
                            html = "";
                            console.log(response.length);
                            for (i = 0; i < response.length; i++) {
                                html = '<tr class="row_lov" onclick=lov_member_select("' + response[i].cus_kodemember + '")><td>' + response[i].cus_namamember + '</td><td>' + response[i].cus_kodemember + '</td></tr>';
                                $('#table_lov').append(html);
                            }
                        },
                        complete: function(){
                            $('#m_kodememberHelp').modal({backdrop: 'static', keyboard: true});
                            $('#modal-loader').modal('hide');
                        }
                    });
                }
                else{
                    $('.invalid-feedback').show();
                }
            }
        });

        $('#i_jenisanggotaR').on('change',function(){
            if($('#i_jenisanggotaR').is(':checked')){
                $('#i_jenisanggotaK').prop('checked',false);
            }
        });

        $('#i_jenisanggotaK').on('change',function(){
            if($('#i_jenisanggotaK').is(':checked')){
                $('#i_jenisanggotaR').prop('checked',false);
            }
        });

        $('#i_jeniskelaminL').on('change',function(){
            if($('#i_jeniskelaminL').is(':checked')){
                $('#i_jeniskelaminP').prop('checked',false);
            }
        });

        $('#i_jeniskelaminP').on('change',function(){
            if($('#i_jeniskelaminP').is(':checked')){
                $('#i_jeniskelaminL').prop('checked',false);
            }
        });

        $('#i_pendidikan').on('change',function(){
            if(this.value == 'X'){
                $('#i_pendidikanX').val('');
                $('#i_pendidikanX').show();
            }
            else{
                $('#i_pendidikanX').val('');
                $('#i_pendidikanX').hide();
            }
        })

        $('#i_metodeinformasi').on('change',function(){
            if(this.value == 'X'){
                $('#i_metodeinformasiX').val('');
                $('#i_metodeinformasiX').show();
            }
            else{
                $('#i_metodeinformasiX').val('');
                $('#i_metodeinformasiX').hide();
            }
        });

        $('#i_jenisbangunanP').on('change',function () {
            if($('#i_jenisbangunanP').is(':checked')){
                $('#i_jenisbangunanS').prop('checked',false);
                $('#i_jenisbangunanN').prop('checked',false);
            }
        });

        $('#i_jenisbangunanS').on('change',function () {
            if($('#i_jenisbangunanS').is(':checked')){
                $('#i_jenisbangunanP').prop('checked',false);
                $('#i_jenisbangunanN').prop('checked',false);
            }
        });

        $('#i_jenisbangunanN').on('change',function () {
            if($('#i_jenisbangunanN').is(':checked')){
                $('#i_jenisbangunanP').prop('checked',false);
                $('#i_jenisbangunanS').prop('checked',false);
            }
        });

        $('#i_statusbangunanM').on('change',function () {
            if($('#i_statusbangunanM').is(':checked')){
                $('#i_statusbangunanS').prop('checked',false);
            }
        });

        $('#i_statusbangunanS').on('change',function () {
            if($('#i_statusbangunanS').is(':checked')){
                $('#i_statusbangunanM').prop('checked',false);
            }
        });

        $('#i_jenikendaraanMotor').on('change',function () {
            if($('#i_jenikendaraanMotor').is(':checked')){
                $('#i_motor').val('...');
                $('#i_motor').show();
            }
            else{
                $('#i_motor').val('...');
                $('#i_motor').hide();
                $('#i_motorX').val('');
                $('#i_motorX').hide();
            }
        });

        $('#i_motor').on('change',function () {
            if(this.value == 'X'){
                $('#i_motorX').val('');
                $('#i_motorX').show();
            }
            else{
                $('#i_motorX').val('');
                $('#i_motorX').hide();
            }
        });

        $('#i_jenikendaraanMobil').on('change',function () {
            if($('#i_jenikendaraanMobil').is(':checked')){
                $('#i_mobil').val('...');
                $('#i_mobil').show();
            }
            else{
                $('#i_mobil').val('...');
                $('#i_mobil').hide();
                $('#i_mobilX').val('');
                $('#i_mobilX').hide();
            }
        });

        $('#i_mobil').on('change',function () {
            if(this.value == 'X'){
                $('#i_mobilX').val('');
                $('#i_mobilX').show();
            }
            else{
                $('#i_mobilX').val('');
                $('#i_mobilX').hide();
            }
        });

        function hobby(event){
            if($('#'+event.target.id).is(':checked')){
                $('#'+event.target.id+'_ket').prop('disabled',false);
            }
            else{
                $('#'+event.target.id+'_ket').val('');
                $('#'+event.target.id+'_ket').prop('disabled',true);
            }
        }

        function to_uppercase(value) {
            if(value == '' || value == null)
                return '';
            else return value.toUpperCase();
        }

        function toDate(value) {
            if(value == null || value == '')
                return '';
            else {
                date = new Date(value);

                return date.getDate() + '-' + month[date.getMonth()] + '-' + date.getFullYear();
            }
        }

        //buat hobby $('.row_hobby_1').find('#i_'+$('.row_hobby_1').attr('id')).is(':checked')
    </script>

@endsection
