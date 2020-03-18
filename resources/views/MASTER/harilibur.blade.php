@extends('navbar')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Master Hari Libur</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="tableFixedHeader">
                            <table class="table table-sm table-hover table-bordered" id="table-harilibur">
                                <thead class="thead-dark">
                                <tr>
                                    <th class="col-sm-">TANGGAL</th>
                                    <th class="col-sm-5">KETERANGAN</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($harilibur as $dataHariLibur)
                                    <tr class="row_harilibur justify-content-md-center p-0">
                                        <td class="col-4">{{ date('d F Y', strtotime($dataHariLibur->lib_tgllibur)) }}</td>
                                        <td class="col-8">{{$dataHariLibur->lib_keteranganlibur}}</td>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group row mb-0">
                            <label for="i_tgl" class="col-sm-2 col-form-label text-right">TANGGAL</label>
                            <div class="col-sm-2">
                                <input type="date" class="form-control" data-date-format="DD MMMM YYYY" id="i_tgl" placeholder="...">
                            </div>
                            <label for="i_keterangan" class="col-sm-2 col-form-label text-right">KETERANGAN</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="i_keterangan" placeholder="...">
                            </div>
                            <button class="btn btn-success" id="btn-save" onclick="save_harilibur()">SAVE</button>
                            <button class="btn btn-success" id="btn-delete" onclick="delete_harilibur()">DELETE</button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
        }
        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .my-custom-scrollbar {
            position: relative;
            height: 350px;
            overflow-x: hidden;
            overflow-y: scroll;
        }
        .table-wrapper-scroll-y {
            display: block;
        }

        .row_harilibur:hover{
            cursor: pointer;
            background-color: grey;
        }


        /*.tableFixedHeader          { overflow-y: auto; height: 300px; }*/
        /*.tableFixedHeader thead th { position: sticky; top: 0; }*/
        /*.tableFixedHeader th     { background:#eee; }*/
        /*.tableFixedHeader table  { border-collapse: collapse; width: 100%; }*/
        /*.tableFixedHeader th, td { padding: 8px 16px; }*/


    </style>

    <script>

        $(document).ready(function(){
            $('#btn-save').click(function() {
                var tgllibur = $('#i_tgl').val();
                var ketlibur = $('#i_keterangan').val();

                if (tgllibur != null && ketlibur != null) {
                    $.ajax({
                        url: '/BackOffice/public/mstharilibur/insert',
                        type: 'post',
                        data: {_token: CSRF_TOKEN, tgllibur: tgllibur, ketlibur: ketlibur},
                        success: function (response) {
                            if (response > 0) {
                                var id = response;
                                var findnorecord = $('#userTable tr.norecord').length;

                                if (findnorecord > 0) {
                                    $('#userTable tr.norecord').remove();
                                }
                                // var tr_str = "<tr>"+
                                //     "<td align='center'><input type='text' value='" + username + "' id='username_"+id+"' disabled ></td>" +
                                //     "<td align='center'><input type='text' value='" + name + "' id='name_"+id+"'></td>" +
                                //     "<td align='center'><input type='email' value='" + email + "' id='email_"+id+"'></td>" +
                                //     "<td align='center'><input type='button' value='Update' class='update' data-id='"+id+"' ><input type='button' value='Delete' class='delete' data-id='"+id+"' ></td>"+
                                //     "</tr>";

                                $('#i_tgl').val(tgllibur);
                                $('#i_keterangan').val(keterangan);

                               // $("#userTable tbody").append(tr_str);
                            } else if (response == 0) {
                                alert('Username already in use.');
                            } else {
                                alert(response);
                            }

                            // Empty the input fields
                            $('#i_tgl').val('');
                            $('#i_keterangan').val('');
                        }
                    });
                } else {
                    alert('Fill all fields');
                }
            });
            });




    </script>

@endsection
