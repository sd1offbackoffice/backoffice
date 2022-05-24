@extends('navbar')

@section('title','ADMINISTRATION | ACCESS MENU')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body pt-0">
                        <fieldset class="card border-secondary mt-0" id="data-field">
                            <legend  class="w-auto ml-3">Migrate Data</legend>
                            <div class="card-body pt-0 pb-0">
                                <div class="row form-group">
                                    <label for="" class="col-sm-1 col-form-label text-center pl-0 pr-0">TO : </label>
                                    <select class="form-control col-sm-4" id="cabang">
                                        @foreach($cabang as $c)
                                            <option value="{{ $c->kodeigr }}">{{ strtoupper($c->namacabang) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="col-sm"></div>
                                    <button class="col-sm-2 btn btn-primary mr-3" id="" onclick="migrate()">MIGRATE</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
            /*overflow-y: hidden;*/
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

        .row_lov:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        /*.my-custom-scrollbar {*/
        /*    position: relative;*/
        /*    height: 400px;*/
        /*    overflow-y: auto;*/
        /*}*/

        .table-wrapper-scroll-y {
            display: block;
        }

        .clicked, .row-detail:hover{
            background-color: grey !important;
            color: white;
        }
    </style>

    <script>
        var tableData;
        var dataAccess = [];
        var dataRow;

        $(document).ready(function(){

        });

        function migrate(){
            $.ajax({
                url: '{{ url()->current() }}/migrate',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    kodeigr: $('#cabang').val()
                },
                beforeSend: function(){
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    messages = '';

                    for(i=0;i<response.length-1;i++){
                        messages += response[i]+'\n';
                    }

                    swal({
                        title: response[response.length-1],
                        text: messages,
                        icon: 'success'
                    });
                },
                error: function(error){
                    $('#modal-loader').modal('hide');

                    swal({
                        title: error.responseJSON.message,
                        icon: 'error'
                    }).then(() => {

                    });
                }
            });
        }
    </script>
@endsection
