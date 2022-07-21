@extends('navbar')
@section('title','MASTER | MASTER DEPARTEMENT')
@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <div class="col-sm-8">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-4">@lang('Divisi')</legend>
                                    <table id="table_divisi" class="table table-sm">
                                        <thead class="theadDataTables">
                                            <tr class="d-flex">
                                                <th class="col-4">@lang('Kode Divisi')</th>
                                                <th class="col-8">@lang('Nama Divisi')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <script>let counter=0;</script> {{--untuk mendata berapa banyak divisi yang ada --}}
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach($divisi as $div)
                                                <script>counter++</script> {{--untuk mendata berapa banyak divisi yang ada --}}
                                            <tr id="row_divisi_{{ $i }}"class="row_divisi row_lov d-flex" onclick="divisi_select('{{ $div->div_kodedivisi }}','{{ $i++ }}')">
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
                                        <thead class="theadDataTables">
                                        <tr class="d-flex">
                                            <th class="col-sm-1">@lang('Kode')</th>
                                            <th class="col-sm-4">@lang('Nama')</th>
                                            <th class="col-sm-1 pl-0 pr-1">@lang('Singkatan')</th>
                                            <th class="col-sm-2">@lang('Kode Manager')</th>
                                            <th class="col-sm-2">@lang('Kode Security')</th>
                                            <th class="col-sm-2">@lang('Kode Supervisor')</th>
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
                                                <td class="col-sm-2">@if($dep->dep_kodesupervisor != null){{ $dep->dep_kodesupervisor }}@endif</td>
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

    <script>
        let cursor = 0;
        let loading = false; //untuk mencegah cursor bergerak selagi loading
        let div = [];

        $(':input').prop('readonly',true);
        $('.custom-select').prop('disabled',true);
        $('#i_kodesupplier').prop('readonly',false);
        $('#search_lov').prop('readonly',false);

        $('#row_divisi_0').addClass('table-primary');

        $(document).ready(function () {
            //Load sekaligus semua diawal
            $(document).ajaxStart(function(){
                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
            });
            // $(document).ajaxComplete(function(){
            //     $('#modal-loader').modal('hide');
            // });
            let ajaxCounter = 0; // untuk menghitung banyak nya progress ajax yang selesai

            for(let i=0;i<counter;i++){
                kodeDivisi = $('#row_divisi_'+i).find(':nth-child(1)').text()
                $.when($.ajax({
                    url: '{{ url()->current() }}/divisi-select',
                    type:'GET',
                    data:{"_token":"{{ csrf_token() }}", value: kodeDivisi},
                    success: function(response){
                        div[i] = response;
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

        function divisi_select(value, row) {
            cursor = row; //cursor untuk fungsi panah
            $('.row_divisi').removeClass('table-primary');
            $('#row_divisi_'+row).addClass('table-primary');

            // ini untuk load satu persatu
            {{--$.ajax({--}}
            {{--    url: '/BackOffice/public/master/departement/divisi_select',--}}
            {{--    type:'GET',--}}
            {{--    data:{"_token":"{{ csrf_token() }}", value: value},--}}
            {{--    success: function(response){--}}
            {{--        $('#table_departement .row_departement').remove();--}}
            {{--        html = "";--}}
            {{--        for(i=0;i<response.length;i++){--}}
            {{--            html = '<tr class="row_departement d-flex"><td class="col-1">'+null_check(response[i].dep_kodedepartement)+'</td><td class="col-4">'+null_check(response[i].dep_namadepartement)+'</td><td class="col-1 pl-0 pr-0">'+null_check(response[i].dep_singkatandepartement)+'</td><td class="col-2">'+null_check(response[i].dep_kodemanager)+'</td><td class="col-2">'+null_check(response[i].dep_kodesecurity)+'</td><td class="col-2">'+null_check(response[i].dep_kodesupervisor)+'</td></tr>';--}}
            {{--            $('#table_departement').append(html);--}}
            {{--        }--}}
            {{--    }, error: function(err){--}}
            {{--        console.log(err.responseJSON.message.substr(0,100));--}}
            {{--        alertError(err.statusText, err.responseJSON.message);--}}
            {{--    }--}}
            {{--});--}}

            // ini untuk load sekaligus di awal
            $('#table_departement .row_departement').remove();
            html = "";
            datas = div[cursor];
            for(i=0;i<datas.length;i++){
                html = '<tr class="row_departement d-flex"><td class="col-1">'+null_check(datas[i].dep_kodedepartement)+'</td><td class="col-4">'+null_check(datas[i].dep_namadepartement)+'</td><td class="col-1 pl-0 pr-0">'+null_check(datas[i].dep_singkatandepartement)+'</td><td class="col-2">'+null_check(datas[i].dep_kodemanager)+'</td><td class="col-2">'+null_check(datas[i].dep_kodesecurity)+'</td><td class="col-2">'+null_check(datas[i].dep_kodesupervisor)+'</td></tr>';
                $('#table_departement').append(html);
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
                        $('.row_divisi').removeClass('table-primary');
                        $('#row_divisi_'+cursor).addClass('table-primary');
                        //mendapatkan kode divisi dan memanggil fungsi memilih divisi
                        kodeDivisi = $('#row_divisi_'+cursor).find(':nth-child(1)').text()
                        divisi_select(kodeDivisi,cursor);
                    }
                    event.preventDefault();
                }
                else if(event.which === 40){ //ini panah bawah
                    if(cursor !== counter-1){
                        cursor++;
                        $('.row_divisi').removeClass('table-primary');
                        $('#row_divisi_'+cursor).addClass('table-primary');
                        //mendapatkan kode divisi dan memanggil fungsi memilih divisi
                        kodeDivisi = $('#row_divisi_'+cursor).find(':nth-child(1)').text()
                        divisi_select(kodeDivisi,cursor);
                    }
                    event.preventDefault();
                }
            }
        });
    </script>

@endsection
