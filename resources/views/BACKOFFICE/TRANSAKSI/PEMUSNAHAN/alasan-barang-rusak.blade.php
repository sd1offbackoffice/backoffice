@extends('navbar')
@section('title','PEMUSNAHAN | MASTER ALASAN BARANG RUSAK')
@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <div class="col-sm-12">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-4">Master Alasan Barang Rusak</legend>
                                    <table id="table_divisi" class="table table-sm">
                                        <thead class="theadDataTables">
                                            <tr class="d-flex">
                                                <th class="col-4">Kode</th>
                                                <th class="col-8">Alasan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        {{-- <script>let counter=0;</script> untuk mendata berapa banyak divisi yang ada --}}
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach($data as $d)
                                                {{-- <script>counter++</script> untuk mendata berapa banyak divisi yang ada --}}
                                            {{-- <tr id="row_data_{{ $i }}"class="row_data row_lov d-flex" onclick="divisi_select('{{ $div->div_kodedivisi }}','{{ $i++ }}')"> --}}
                                                @if ($d->kbr_flagmanual == 'Y')
                                                    
                                                @else
                                                    <tr id="row_data_{{ $i }}"class="row_data row_lov d-flex">
                                                        <td class="col-4">{{ $d->kbr_tipeid }}</td>
                                                        <td class="col-8">{{ $d->kbr_tipe }}</td>
                                                    </tr>                                                  
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-4">Lain-Lain</legend>
                                    <table id="table_divisi" class="table table-sm">
                                        <thead class="theadDataTables">
                                            <tr class="d-flex">
                                                <th class="col-4">Kode</th>
                                                <th class="col-8">Alasan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        {{-- <script>let counter=0;</script> untuk mendata berapa banyak divisi yang ada --}}
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach($data as $d)

                                                {{-- <script>counter++</script> untuk mendata berapa banyak divisi yang ada --}}
                                            {{-- <tr id="row_data_{{ $i }}"class="row_data row_lov d-flex" onclick="divisi_select('{{ $div->div_kodedivisi }}','{{ $i++ }}')"> --}}
                                                @if ($d->kbr_flagmanual == 'Y')
                                                    <tr id="row_data_{{ $i }}"class="row_data row_lov d-flex">
                                                        <td class="col-4">{{ $d->kbr_tipeid }}</td>
                                                        <td class="col-8">{{ $d->kbr_tipe }}</td>
                                                    </tr>                                                   
                                                @else

                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // let cursor = 0;
        // let loading = false; //untuk mencegah cursor bergerak selagi loading
        // let div = [];

        // $(':input').prop('readonly',true);
        // $('.custom-select').prop('disabled',true);
        // $('#i_kodesupplier').prop('readonly',false);
        // $('#search_lov').prop('readonly',false);

        // $('#row_data_0').addClass('table-primary');

        // $(document).ready(function () {
        //     //Load sekaligus semua diawal
        //     $(document).ajaxStart(function(){
        //         $('#modal-loader').modal({backdrop: 'static', keyboard: false});
        //     });
        //     // $(document).ajaxComplete(function(){
        //     //     $('#modal-loader').modal('hide');
        //     // });
        //     let ajaxCounter = 0; // untuk menghitung banyak nya progress ajax yang selesai

        //     // for(let i=0;i<counter;i++){
        //     //     kodeDivisi = $('#row_data_'+i).find(':nth-child(1)').text()
        //     //     $.when($.ajax({
        //     //         url: '{{ url()->current() }}/divisi-select',
        //     //         type:'GET',
        //     //         data:{"_token":"{{ csrf_token() }}", value: kodeDivisi},
        //     //         success: function(response){
        //     //             div[i] = response;
        //     //         }, error: function(err){
        //     //             console.log(err.responseJSON.message.substr(0,100));
        //     //             alertError(err.statusText, err.responseJSON.message);
        //     //         }
        //     //     })).done(function() {
        //     //         if(ajaxCounter===counter-1){ //berfungsi agar loader tidak hilang sewaktu seluruh data belum selesai load
        //     //             $('#modal-loader').modal('hide');
        //     //             loading = true;
        //     //         }else{
        //     //             ajaxCounter++;
        //     //         }
        //     //     });
        //     // }
        // })

        // function divisi_select(value, row) {
        //     cursor = row; //cursor untuk fungsi panah
        //     $('.row_data').removeClass('table-primary');
        //     $('#row_data_'+row).addClass('table-primary');

        //     // ini untuk load satu persatu
        //     // {{--$.ajax({--}}
        //     // {{--    url: '/BackOffice/public/master/departement/divisi_select',--}}
        //     // {{--    type:'GET',--}}
        //     // {{--    data:{"_token":"{{ csrf_token() }}", value: value},--}}
        //     // {{--    success: function(response){--}}
        //     // {{--        $('#table_departement .row_departement').remove();--}}
        //     // {{--        html = "";--}}
        //     // {{--        for(i=0;i<response.length;i++){--}}
        //     // {{--            html = '<tr class="row_departement d-flex"><td class="col-1">'+null_check(response[i].dep_kodedepartement)+'</td><td class="col-4">'+null_check(response[i].dep_namadepartement)+'</td><td class="col-1 pl-0 pr-0">'+null_check(response[i].dep_singkatandepartement)+'</td><td class="col-2">'+null_check(response[i].dep_kodemanager)+'</td><td class="col-2">'+null_check(response[i].dep_kodesecurity)+'</td><td class="col-2">'+null_check(response[i].dep_kodesupervisor)+'</td></tr>';--}}
        //     // {{--            $('#table_departement').append(html);--}}
        //     // {{--        }--}}
        //     // {{--    }, error: function(err){--}}
        //     // {{--        console.log(err.responseJSON.message.substr(0,100));--}}
        //     // {{--        alertError(err.statusText, err.responseJSON.message);--}}
        //     // {{--    }--}}
        //     // {{--});--}}

        //     // ini untuk load sekaligus di awal
        //     $('#table_departement .row_departement').remove();
        //     html = "";
        //     datas = div[cursor];
        //     for(i=0;i<datas.length;i++){
        //         html = '<tr class="row_departement d-flex"><td class="col-1">'+null_check(datas[i].dep_kodedepartement)+'</td><td class="col-4">'+null_check(datas[i].dep_namadepartement)+'</td><td class="col-1 pl-0 pr-0">'+null_check(datas[i].dep_singkatandepartement)+'</td><td class="col-2">'+null_check(datas[i].dep_kodemanager)+'</td><td class="col-2">'+null_check(datas[i].dep_kodesecurity)+'</td><td class="col-2">'+null_check(datas[i].dep_kodesupervisor)+'</td></tr>';
        //         $('#table_departement').append(html);
        //     }

        // }

        // function null_check(value){
        //     if(value == null)
        //         return '';
        //     else return value;
        // }

        // //Fungsi panah atas dan panah bawah
        // $(window).bind('keydown', function(event) {
        //     if(loading){
        //         if(event.which === 38){ //ini panah atas
        //             //code
        //             if(cursor !== 0){
        //                 cursor--;
        //                 $('.row_data').removeClass('table-primary');
        //                 $('#row_data_'+cursor).addClass('table-primary');
        //                 //mendapatkan kode divisi dan memanggil fungsi memilih divisi
        //                 kodeDivisi = $('#row_data_'+cursor).find(':nth-child(1)').text()
        //                 divisi_select(kodeDivisi,cursor);
        //             }
        //             event.preventDefault();
        //         }
        //         else if(event.which === 40){ //ini panah bawah
        //             if(cursor !== counter-1){
        //                 cursor++;
        //                 $('.row_data').removeClass('table-primary');
        //                 $('#row_data_'+cursor).addClass('table-primary');
        //                 //mendapatkan kode divisi dan memanggil fungsi memilih divisi
        //                 kodeDivisi = $('#row_data_'+cursor).find(':nth-child(1)').text()
        //                 divisi_select(kodeDivisi,cursor);
        //             }
        //             event.preventDefault();
        //         }
        //     }
        // });
    </script>

@endsection
