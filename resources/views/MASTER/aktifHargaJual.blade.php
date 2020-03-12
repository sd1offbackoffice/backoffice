@extends('navbar')
@section('content')

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <fieldset class="card border-dark">
                    <legend  class="w-auto ml-5">Aktifkan Harga Jual</legend>
                    <div class="card-body cardForm">
                        <form class="form">
                            <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-md-right">Kode Plu</label>
                                <input type="text" id="kodePlu" class="form-control col-sm-2 mx-sm-1" onchange="getDetailPlu(this.value)">
                                <button class="btn ml-2" type="button" data-toggle="modal" data-target="#m_prodmast"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                <input type="text" id="namaPlu" class="form-control col-sm-5 mx-sm-1" disabled>
                            </div>
                            <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-md-right">Divisi</label>
                                <input type="text" id="kodeDivisi" class="form-control col-sm-1 mx-sm-1" disabled>
                                <input type="text" id="namaDivisi" class="form-control col-sm-4 mx-sm-1" disabled>
                            </div>
                            <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-md-right">Departement</label>
                                <input type="text" id="kodeDepartement" class="form-control col-sm-1 mx-sm-1" disabled>
                                <input type="text" id="namaDepartement" class="form-control col-sm-4 mx-sm-1" disabled>
                            </div>
                            <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-md-right">Kategori Barang</label>
                                <input type="text" id="kodeKategori" class="form-control col-sm-1 mx-sm-1" disabled>
                                <input type="text" id="namaKategori" class="form-control col-sm-4 mx-sm-1" disabled>
                            </div>
                            <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-md-right">Harga Jual Lama</label>
                                <input type="text" id="hargaLama" class="form-control col-sm-2 mx-sm-1" disabled>
                            </div>
                            <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-md-right">Harga Jual Baru</label>
                                <input type="text" id="hargaBaru" class="form-control col-sm-2 mx-sm-1" disabled>
                            </div>

                            <button type="button" id="btnAktifkanHrg" class="btn btn-primary pl-4 pr-4 float-right btnAktifkanHrg" onclick="aktifkanHarga()">Aktifkan</button>
                        </form>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--Modal HELP--}}
    <div class="modal fade" id="m_prodmast" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="searchProdmast" class="form-control search_lov" type="text" placeholder="Inputkan Nama / Kode Barang" aria-label="Search">
                        <div class="invalid-feedback">
                            Inputkan minimal 3 karakter
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
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalProdmast">
                                    @foreach($prodmast as $data)
                                        <tr onclick="getDetailPlu('{{ $data->prd_prdcd }}')" class="row_lov">
                                            <td>{{ $data->prd_prdcd }}</td>
                                            <td>{{ $data->prd_deskripsipanjang }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .row_lov:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

    </style>

    <script>
        $('#kodePlu').keypress(function (e) {
            if (e.which === 13){
                $('.btnAktifkanHrg').focus()
                getDetailPlu(this.value)
            }
        });

        function aktifkanHarga() {
            let plu     = $('#kodePlu').val();
            let harga   = $('#hargaBaru').val();

            if (harga < 1 ){
                swal('Warning', 'Tidak Ada Perubahan Harga', 'warning')
                clearField();
            } else {
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/mstaktifhrgjual/aktifkanhrg',
                    type: 'post',
                    data:({plu:plu}),
                    beforeSend: function(){
                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function (result) {
                        $('#modal-loader').modal('hide');
                        swal('SUCCESS', result, 'success')
                        console.log(result)
                        clearField()
                    }, error : function (error) {
                        $('#modal-loader').modal('hide');
                        console.log(error)
                        swal("Error",'','error');
                    }
                })
            }
        }


        $('#searchProdmast').keypress(function (e) {
            if (e.which === 13) {
                if ($(this).val().length < 3) {
                    $('.invalid-feedback').show();
                } else {
                    $('.invalid-feedback').hide();
                    $('#tbodyModalProdmast .row_lov').remove();
                    ajaxSetup();
                    $.ajax({
                        url: '/BackOffice/public/mstaktifhrgjual/getprodmast',
                        type: 'post',
                        data:({search:$(this).val()}),
                        success: function (result) {
                            for(i =0; i < result.length; i++) {
                                $('#tbodyModalProdmast').append("<tr onclick=getDetailPlu('"+ result[i].prd_prdcd +"') class='row_lov'> <td>"+ result[i].prd_prdcd +"</td><td>"+ result[i].prd_deskripsipanjang +"</td></tr>")
                            }
                        }, error : function () {
                            swal("Error",'','error');
                        }
                    })
                }
            }
        });

        function getDetailPlu(plu) {
            if (plu.length > 7){
                swal('Warning', "Kode Plu tidak boleh lebih dari 7", 'warning')
            } else {
                let max = plu.length;
                for (let i =0; i<(7-max); i++){
                    plu = '0'+plu;
                }

                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/mstaktifhrgjual/getdetailplu',
                    type: 'post',
                    data:({plu:plu}),
                    success: function (result) {
                        if (result.length === 0){
                            swal('Warning', 'Data PLU Tidak Ada', 'warning')
                            clearField()
                        } else {
                            let data = result[0];
                            $('#m_prodmast').modal('hide');
                            clearField();
                            $('#kodePlu').val(data.prd_prdcd)
                            $('#namaPlu').val(data.prd_deskripsipanjang)
                            $('#kodeDivisi').val(data.prd_kodedivisi)
                            $('#namaDivisi').val(data.div_namadivisi)
                            $('#kodeDepartement').val(data.prd_kodedepartement)
                            $('#namaDepartement').val(data.dep_namadepartement)
                            $('#kodeKategori').val(data.prd_kodekategoribarang)
                            $('#namaKategori').val(data.kat_namakategori)
                            $('#hargaLama').val(data.prd_hrgjual)
                            $('#hargaBaru').val(data.prd_hrgjual3)
                            $('.btnAktifkanHrg').focus()
                        }
                    }, error : function () {
                        swal("Error",'','error');
                    }
                })
            }
        }

        function clearField() {
            $('#kodePlu').val('')
            $('#namaPlu').val('')
            $('#kodeDivisi').val('')
            $('#namaDivisi').val('')
            $('#kodeDepartement').val('')
            $('#namaDepartement').val('')
            $('#kodeKategori').val('')
            $('#namaKategori').val('')
            $('#hargaLama').val('')
            $('#hargaBaru').val('')
        }
    </script>





@endsection
