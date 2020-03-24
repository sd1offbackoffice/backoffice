@extends('navbar')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Master Hari Libur</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="tableFixedHeader">
                            <table class="table table-sm table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th> TANGGAL</th>
                                    <th >KETERANGAN</th>
                                </tr>
                                </thead>
                                <tbody  id="tbodyHariLibur">
                                @foreach($harilibur as $dataHariLibur)
                                    <tr class="modalRow justify-content-md-center p-0 hariLiburRow" id="{{$dataHariLibur->lib_tgllibur}}" val="{{$dataHariLibur->lib_keteranganlibur}}" onclick='inputToField(this)'>
                                        <td>{{ date('d-M-Y', strtotime($dataHariLibur->lib_tgllibur)) }}</td>
                                        <td>{{$dataHariLibur->lib_keteranganlibur}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group row mb-0 mt-3">
                            <label for="i_tgl" class="col-sm-2 col-form-label text-right">TANGGAL</label>
                            <div class="col-sm-2">
                                <input type="date" class="form-control" data-date-format="DD MMMM YYYY" id="i_tgl" placeholder="...">
                            </div>
                            <label for="i_keterangan" class="col-sm-2 col-form-label text-right">KETERANGAN</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="i_keterangan" placeholder="...">
                            </div>
                            <button class="btn btn-primary pl-4 pr-4 mr-3" id="btn-save" onclick="saveHariLibur()">SAVE</button>
                            <button class="btn btn-danger pl-4 pr-4" id="btn-delete" onclick="deleteHariLibur()">DELETE</button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <style>
        input{
            text-transform: uppercase;
        }
    </style>

    <script>
        function actionHariLibur(string) {
            let tgl = $('#i_tgl').val();
            let ket = $('#i_keterangan').val();

            if(!ket && !tgl){
                swal('MOHON MENGISI TANGGAL DAN KETERANGAN', '', 'warning');
            } else if (!tgl) {
                swal('MOHON MENGISI TANGGAL', '', 'warning')
            } else  if(!ket){
                swal('MOHON MENGISI KETERANGAN', '', 'warning')
            } else {
                ajaxSetup();
                $.ajax({
                    url: string,
                    type: 'post',
                    data: {tgllibur: tgl, ketlibur: ket},
                    beforeSend: function(){
                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function (result) {
                        if (result.kode === 1) {
                            swal(result.msg,'','success');

                            $('.hariLiburRow').remove();
                            for (let i =0 ; i < result.data.length; i++){
                                const d = new Date(result.data[i].lib_tgllibur.substr(0,10))
                                const ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d);
                                const mo = new Intl.DateTimeFormat('en', { month: 'short' }).format(d);
                                const da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d);

                                let date = da+'-'+mo+'-'+ye;
                                $('#tbodyHariLibur').append(" <tr class='modalRow justify-content-md-center p-0 hariLiburRow' id='"+ result.data[i].lib_tgllibur +"' val='"+ result.data[i].lib_keteranganlibur +"' onclick='inputToField(this)'>\n" +
                                    "<td>"+ date +"</td>\n" +
                                    "<td>"+ result.data[i].lib_keteranganlibur +"</td>\n" +
                                    "</tr>")
                            }
                        } else {
                            swal('ERROR', "Something's Error", 'error')
                        }

                        $('#i_tgl').val('');
                        $('#i_keterangan').val('');
                        $('#modal-loader').modal('hide');
                    }, error: function (error) {
                        console.log(error)
                    }
                });
            }
        }

        function saveHariLibur() {
            actionHariLibur( '/BackOffice/public/mstharilibur/insert')
        }

        function deleteHariLibur() {
            swal({
                icon: 'warning',
                title: 'Hari Libur Akan di Hapus?',
                buttons: true,
                dangerMode: true
            }).then((response) =>{
                if (response){
                    actionHariLibur( '/BackOffice/public/mstharilibur/delete')
                }
                });
        }

        function inputToField(temp) {
            let tgl =  temp['attributes'][1]['nodeValue']
            let ket =  temp['attributes'][2]['nodeValue']

            $('#i_tgl').val(tgl.substr(0,10));
            $('#i_keterangan').val(ket);
        }
    </script>

@endsection
