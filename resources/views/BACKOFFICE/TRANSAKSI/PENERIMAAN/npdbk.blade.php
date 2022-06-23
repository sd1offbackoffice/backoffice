@extends('navbar')
@section('title','PENERIMAAN | INPUT')
@section('content')

<div class="container" style="width: 100%;">
    <div class="card border-dark">
        <div class="card-body cardForm">
            <fieldset class="card border-dark">
                <legend class="w-auto ml-5">Download Data NPD - Upload Data BK</legend>
                <div class="pt-4 pb-4" style="text-align: center;">
                    <button class="btn btn-primary btn-lg" onclick="download()">Download Data NPD</button>
                </div>
                <span style="border: 1px solid black;"></span>
                <div class="pt-4 pb-4" style="text-align: center;">
                    <div style="padding-left: 35%; padding-right: 35%;">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Periode Proses</span>
                        </div>
                        <input type="date" class="form-control" id="startDate" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="pt-4 pb-4" style="text-align: center;">
                    <button class="btn btn-primary btn-lg" onclick="upload()">Upload Data BA-SK</button>
                </div>
                <div class="pt-4 pb-4" style="text-align: left; margin-left: 5%;">
                    <p>*Periode proses hanya untuk upload data BA-SK</p>
                    <p>Upload data ke FTP SD5 dan FTP FAD</p>
                </div>
            </fieldset>
        </div>
    </div>
</div>

<script>
    let startdate = $('#startDate');

    function download() {
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/download',
            type: 'get',
            success: function(result) {
                if (result.kode == '0') {
                    swal('', result.message, 'info')
                } else if (result.kode == '1') {
                    swal('', result.message, 'warning')
                }
            },
            error: function(err) {
                console.log(err.responseJSON.message.substr(0, 100));
                alertError(err.statusText, err.responseJSON.message)
            }
        })
    }

    function upload() {
        console.log(startdate.val())
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/upload',
            data: {
                tgl: startdate.val(),
            },
            type: 'get',
            success: function(result) {
                console.log(result)
                if (result.kode == '0') {
                    swal('', result.message, 'info')
                } else if (result.kode == '1') {
                    swal('', result.message, 'warning')
                }
            },
            error: function(err) {
                console.log(err.responseJSON.message.substr(0, 100));
                alertError(err.statusText, err.responseJSON.message)
            }
        })
    }
</script>
@endsection