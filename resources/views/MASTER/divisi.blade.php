@extends('navbar')
@section('content')


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Master Divisi</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="form-group row mb-0">
                                    <label for="i_kodedivisi" class="col-sm-3 col-form-label">Kode Divisi</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="i_kodedivisi">
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="i_kodedivisibaru" class="col-sm-3 col-form-label">Kode Divisi Baru</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="i_kodedivisibaru">
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="i_namadivisi" class="col-sm-3 col-form-label">Nama Divisi</label>
                                    <div class="col-sm-7">
                                        <input type="email" class="form-control" id="i_namadivisi">
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="i_namadivisibaru" class="col-sm-3 col-form-label">Nama Divisi Baru</label>
                                    <div class="col-sm-7">
                                        <input type="email" class="form-control" id="i_namadivisibaru">
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="i_divisimanager" class="col-sm-3 col-form-label">Divisi Manager</label>
                                    <div class="col-sm-4">
                                        <input type="email" class="form-control" id="i_divisimanager">
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="i_singkatannamadivisi" class="col-sm-3 col-form-label">Singkatan Nama Divisi</label>
                                    <div class="col-sm-4">
                                        <input type="email" class="form-control" id="i_singkatannamadivisi">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <br>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <button class="btn btn-secondary" id="btn-prev" onclick="divisi_detail('prev')">PREV</button>
                        <button class="btn btn-secondary" id="btn-next" onclick="divisi_detail('next')">NEXT</button>
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
        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .row_divisi:hover{
            cursor: pointer;
            background-color: grey;
        }


    </style>

    <script>
        $(':input').prop('readonly',true);
        $('#i_kodedivisi').focus();



        $(document).ready(function () {

        })

        var divisi = @php echo $divisi; @endphp;
        var i = 0;

        $('#i_kodedivisi').val(divisi[0].div_kodedivisi);
        $('#i_namadivisi').val(divisi[0].div_namadivisi);
        $('#i_divisimanager').val(divisi[0].div_divisimanager);
        $('#i_singkatannamadivisi').val(divisi[0].div_singkatannamadivisi);

        $('#btn-prev').prop('disabled',true);


        // $('#i_kodedivisi').on('keydown',function (event) {
        //     divisi_detail(event);
        // });



        function divisi_detail(action) {

            if (action == 'next') {
                if(i < divisi.length - 1)
                    i++;
                if(i == divisi.length - 1)
                    $('#btn-next').prop('disabled',true);
                else $('#btn-prev').prop('disabled',false);
            }
            else if(action == 'prev') {
                if(i > 0)
                    i--;
                if(i == 0)
                    $('#btn-prev').prop('disabled',true);
                else $('#btn-next').prop('disabled',false);
            }
            $('#i_kodedivisi').val(divisi[i].div_kodedivisi);
            $('#i_namadivisi').val(divisi[i].div_namadivisi);
            $('#i_divisimanager').val(divisi[i].div_divisimanager);
            $('#i_singkatannamadivisi').val(divisi[i].div_singkatannamadivisi);
        }
    </script>

@endsection