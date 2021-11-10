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
                                            <script>let counter=0;</script> {{--untuk mendata berapa banyak departemen yang ada --}}
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach($departement as $dep)
                                                <script>counter++</script> {{--untuk mendata berapa banyak departemen yang ada --}}
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
        let cursor = 0;
        let dep = [];
        let loading = false; //untuk mencegah cursor bergerak selagi loading
        $('#row_departement_0').addClass('table-primary');

        $(document).ready(function () {
            //Load sekaligus semua diawal
            $(document).ajaxStart(function(){
                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
            });

            let ajaxCounter = 0; // untuk menghitung banyak nya progress ajax yang selesai
            for(let i=0;i<counter;i++){
                kodeDepartemen = $('#row_departement_'+i).find(':nth-child(1)').text()
                $.when($.ajax({
                    url: '{{ url()->current() }}/departement-select',
                    type:'GET',
                    data:{"_token":"{{ csrf_token() }}", value: kodeDepartemen},
                    success: function(response){
                        dep[i] = response;
                    }, error: function(err){
                        console.log(err.responseJSON.message.substr(0,100));
                        alertError(err.statusText, err.responseJSON.message);
                    }
                })).done(function() {
                    if(ajaxCounter===counter-1){ //berfungsi agar loader tidak hilang sewaktu seluruh data belum selesai load
                        $('#modal-loader').modal('hide');
                        loading = true;
                    }else{
                        ajaxCounter++;
                    }
                });
            }

        })

        function departement_select(value, row) {
            cursor = row; //cursor untuk fungsi panah
            $('.row_departement').removeClass('table-primary');
            $('#row_departement_'+row).addClass('table-primary');

            // ini untuk load satu persatu
            {{--$.ajax({--}}
            {{--    url: '/BackOffice/public/master/kategoribarang/departement_select',--}}
            {{--    type:'GET',--}}
            {{--    data:{"_token":"{{ csrf_token() }}", value: value},--}}
            {{--    success: function(response){--}}
            {{--        $('#table_kategori .row_kategori').remove();--}}
            {{--        html = "";--}}
            {{--        for(i=0;i<response.length;i++){--}}
            {{--            html = '<tr class="row_kategori d-flex"><td class="col-1">'+null_check(response[i].kat_kodekategori)+'</td><td class="col-9">'+null_check(response[i].kat_namakategori)+'</td><td class="col-2">'+null_check(response[i].kat_singkatan)+'</td></tr>';--}}
            {{--            $('#table_kategori').append(html);--}}
            {{--        }--}}
            {{--    },  error: function(err){--}}
            {{--        console.log(err.responseJSON.message.substr(0,100));--}}
            {{--        alertError(err.statusText, err.responseJSON.message);--}}
            {{--    }--}}
            {{--});--}}

            // ini untuk load sekaligus di awal
            $('#table_kategori .row_kategori').remove();
            html = "";
            datas = dep[cursor];
            for(i=0;i<datas.length;i++){
                html = '<tr class="row_kategori d-flex"><td class="col-1">'+null_check(datas[i].kat_kodekategori)+'</td><td class="col-9">'+null_check(datas[i].kat_namakategori)+'</td><td class="col-2">'+null_check(datas[i].kat_singkatan)+'</td></tr>';
                $('#table_kategori').append(html);
            }
        }

        function null_check(value){
            if(value == null)
                return '';
            else return value;
        }

        //Fungsi panah atas dan panah bawah
        $(window).bind('keydown', function(event) {
            if(loading){
                if(event.which === 38){ //ini panah atas
                    //code
                    if(cursor !== 0){
                        cursor--;
                        $('.row_departement').removeClass('table-primary');
                        $('#row_departement_'+cursor).addClass('table-primary');
                        //mendapatkan kode dep dan memanggil fungsi memilih divisi
                        kodeDepartemen = $('#row_departement_'+cursor).find(':nth-child(1)').text()
                        departement_select(kodeDepartemen,cursor);
                    }
                    event.preventDefault();
                }
                else if(event.which === 40){ //ini panah bawah
                    if(cursor !== counter-1){
                        cursor++;
                        $('.row_departement').removeClass('table-primary');
                        $('#row_departement_'+cursor).addClass('table-primary');
                        //mendapatkan kode dep dan memanggil fungsi memilih divisi
                        kodeDepartemen = $('#row_departement_'+cursor).find(':nth-child(1)').text()
                        departement_select(kodeDepartemen,cursor);
                    }
                    event.preventDefault();
                }
            }
        });
    </script>

@endsection
