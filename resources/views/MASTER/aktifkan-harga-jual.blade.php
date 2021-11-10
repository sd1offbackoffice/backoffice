@extends('navbar')
@section('title','MASTER | AKTIFKAN HARGA JUAL PER ITEM')
@section('content')

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
               <div class="card border-dark">
                   <div class="card-body cardForm">
                       <form class="form">
                           <div class="form-group row mb-0">
                               <label class="col-sm-4 col-form-label text-md-right">Kode Plu</label>
{{--                               <input type="text" id="kodePlu" class="form-control col-sm-2 mx-sm-1" onchange="getDetailPlu(this.value)">--}}
{{--                               <button class="btn ml-2" type="button" data-toggle="modal" data-target="#m_prodmast"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>--}}

                               <div class="col-sm-2 buttonInside">
                                   <input type="text" id="kodePlu" class="form-control" onchange="getDetailPlu(this.value)">
                                   <button id="btn-no-doc" type="button" class="btn btn-lov p-0"  data-toggle="modal" data-target="#m_prodmast">
                                       <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                   </button>
                               </div>

                               <input type="text" id="namaPlu" class="form-control col-sm-5 mx-sm-1" disabled>
                           </div>
                           <div class="form-group row mb-0">
                               <label class="col-sm-4 col-form-label text-md-right">Divisi</label>
                               <input type="text" id="kodeDivisi" class="form-control col-sm-1 mx-sm-3" disabled>
                               <input type="text" id="namaDivisi" class="form-control col-sm-4 mx-sm-1" disabled>
                           </div>
                           <div class="form-group row mb-0">
                               <label class="col-sm-4 col-form-label text-md-right">Departement</label>
                               <input type="text" id="kodeDepartement" class="form-control col-sm-1 mx-sm-3" disabled>
                               <input type="text" id="namaDepartement" class="form-control col-sm-4 mx-sm-1" disabled>
                           </div>
                           <div class="form-group row mb-0">
                               <label class="col-sm-4 col-form-label text-md-right">Kategori Barang</label>
                               <input type="text" id="kodeKategori" class="form-control col-sm-1 mx-sm-3" disabled>
                               <input type="text" id="namaKategori" class="form-control col-sm-4 mx-sm-1" disabled>
                           </div>
                           <div class="form-group row mb-0">
                               <label class="col-sm-4 col-form-label text-md-right">Harga Jual Lama</label>
                               <input type="text" id="hargaLama" class="form-control col-sm-2 mx-sm-3 text-right" disabled>
                           </div>
                           <div class="form-group row mb-0">
                               <label class="col-sm-4 col-form-label text-md-right">Harga Jual Baru</label>
                               <input type="text" id="hargaBaru" class="form-control col-sm-2 mx-sm-3 text-right" disabled>
                           </div>

                           <div class="col-sm-2 text-center offset-sm-10">
                               <button type="button" id="btnAktifkanHrg" class="btn btn-primary pl-4 pr-4 btn-block btnAktifkanHrg" onclick="aktifkanHarga()">Aktifkan</button>
                           </div>
                       </form>
                   </div>
               </div>
            </div>
        </div>
    </div>

    {{--Modal HELP--}}
    <div class="modal fade" id="m_prodmast" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">List Prodmast</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="tableModalProdmast">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalProdmast">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function (){
            {{--$('#tableModalProdmast').DataTable({--}}
            {{--    "ajax": '{{ url('mstaktifhrgjual/getprodmast') }}',--}}
            {{--    "columns": [--}}
            {{--        {data: 'prd_prdcd', name: 'prd_prdcd', width : '20%'},--}}
            {{--        {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang', width : '80%'},--}}
            {{--    ],--}}
            {{--    "paging": true,--}}
            {{--    "lengthChange": true,--}}
            {{--    "searching": true,--}}
            {{--    "ordering": true,--}}
            {{--    "info": true,--}}
            {{--    "autoWidth": false,--}}
            {{--    "responsive": true,--}}
            {{--    "createdRow": function (row, data, dataIndex) {--}}
            {{--        $(row).addClass('modalRow');--}}
            {{--    },--}}
            {{--    "order": [],--}}
            {{--    columnDefs : [--}}
            {{--    ]--}}
            {{--});--}}


            getDataProdmast('');
        });

        function getDataProdmast(value){
            let tableModal =  $('#tableModalProdmast').DataTable({
                "ajax": {
                    'url' : '{{ url()->current()}}/getprodmast',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'prd_prdcd', name: 'prd_prdcd', width : '20%'},
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang', width : '80%'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                },
                "order": []
            });

            $('#tableModalProdmast_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModal.destroy();
                    getDataProdmast(val);
                }
            })
        }

        $(document).on('click', '.modalRow', function () {
            let plu = $(this).find('td')[0]['innerHTML']

            getDetailPlu(plu)
        } );

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
                    url: '{{ url()->current() }}/aktifkanhrg',
                    type: 'post',
                    data:({plu:plu}),
                    beforeSend: function(){
                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function (result) {
                        swal('SUCCESS', result, 'success').then(function(){
                            $('#modal-loader').modal('hide');
                        });
                        console.log(result)
                        clearField()
                    }, error : function (err) {
                        console.log(err.responseJSON.message.substr(0,150));
                        alertError(err.statusText, err.responseJSON.message);
                    }
                })
            }
        }

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
                    url: '{{ url()->current() }}/getdetailplu',
                    type: 'post',
                    data:({plu:plu}),
                    beforeSend: function () {
                        $('#m_prodmast').modal('hide');
                        $('#modal-loader').modal('show');
                    }, success: function (result) {
                        $('#modal-loader').modal('hide');
                        if (result.length === 0){
                            swal('Warning', 'Data PLU Tidak Ada', 'warning')
                            clearField()
                        } else {
                            let data = result[0];
                            clearField();
                            $('#kodePlu').val(data.prd_prdcd)
                            $('#namaPlu').val(data.prd_deskripsipanjang)
                            $('#kodeDivisi').val(data.prd_kodedivisi)
                            $('#namaDivisi').val(data.div_namadivisi)
                            $('#kodeDepartement').val(data.prd_kodedepartement)
                            $('#namaDepartement').val(data.dep_namadepartement)
                            $('#kodeKategori').val(data.prd_kodekategoribarang)
                            $('#namaKategori').val(data.kat_namakategori)
                            $('#hargaLama').val(convertToRupiah2(data.prd_hrgjual))
                            $('#hargaBaru').val(convertToRupiah2(data.prd_hrgjual3))
                            $('.btnAktifkanHrg').focus()
                        }
                    }, error : function (err) {
                        $('#modal-loader').modal('hide');
                        console.log(err.responseJSON.message.substr(0,100));
                        alertError(err.statusText, err.responseJSON.message);
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
