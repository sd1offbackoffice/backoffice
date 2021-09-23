@extends('navbar')
@section('title','OMI| Proses BKL')
@section('content')


    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <form enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group row mb-1">
                                <label class="col-sm-2 col-form-label text-right">Direktori/Folder</label>
                                <div class="col-sm-5 buttonInside">
                                    <input type="file" class="form-control" name="file" id="file" multiple>
                                </div>
                                <button class="btn btn-primary col-sm-2 btn-block" type="button" onclick="viewFile()">View File</button>
                            </div>
                        </form>
                        <div class="row mt-5 justify-content-center">
                            <div class="col-sm-2 btnCetak" id="btnCetakList"><button class="btn btn-success btn-block" onclick="choosePaperSize('1')">Print List</button></div>
                            <div class="col-sm-2 btnCetak" id="btnCetakBpb"><button class="btn btn-success btn-block" onclick="choosePaperSize('2')">Print BPB</button></div>
                            <div class="col-sm-2 btnCetak" id="btnCetakStruk"><button class="btn btn-success btn-block" onclick="choosePaperSize('3')">Print Struk</button></div>
                            <div class="col-sm-2 btnCetak" id="btnCetakReset"><button class="btn btn-success btn-block" onclick="choosePaperSize('4')">Print Reset</button></div>
                            <div class="col-sm-2 btnCetak" id="btnCetakTolakan"><button class="btn btn-success btn-block" onclick="choosePaperSize('5')">Print Tolakan</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <div class="table-wrapper-scroll-y my-custom-scrollbar m-1 scroll-y hidden" style="position: sticky;height:455px">
                            <table id="table_tsj" class="table table-sm table-bordered mb-3 text-center">
                                <thead class="thColor">
                                <tr>
                                    <th>Proses</th>
                                    <th>Nama File</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyTableViewFile">
                                    <tr>
                                        <td>  <input type="checkbox" aria-label="Checkbox for following text input"></td>
                                        <td>asdsasd</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row form-group mt-3 mb-0">
                            <div class="custom-control custom-checkbox col-sm-2 ml-3">
{{--                                <input type="checkbox" class="custom-control-input" id="checkAllFile" onchange="checkAllFile(event)">--}}
{{--                                <label for="checkAllFile" class="custom-control-label">Check All</label>--}}
                            </div>
                            <div class="col-sm-7"></div>
                            <button class="col btn btn-primary" onclick="prosesBKL()">PROSES BKL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        let fileUpload = [];

        $(document).ready(function () {
            $('.btnCetak').hide();
        })

        function viewFile(){
            let fileInput = document.getElementById('file');
            let length = fileInput.files.length;

            $('#tbodyTableViewFile').children().remove();

            for (let i = 0; i < length; i++){
                let file    = fileInput.files[i].name;
                let index   = file.indexOf('.');
                let ext     = file.substr((index+1),3);

                if (ext.toLowerCase() == 'dbf' || ext.toLowerCase() == 'zip'){
                    $('#tbodyTableViewFile').append(`<tr>
                                                        <td>  <input type="checkbox" class="checkBoxFile" value="${file}" onclick="checkAllFile(event)"></td>
                                                        <td>${file}</td>
                                                    </tr>`)
                }

                let files   = fileInput.files[i];
                fileUpload.push(files);
            }
        }

        function checkAllFile(e){
            $('.checkBoxFile').prop('checked', false);
            $(e.target).prop('checked',true);
        }

        function prosesBKL() {
            let totalFiles  = 0;
            let fileDBF     = new FormData();
            let dbfChecked  = $('.checkBoxFile:checked').val();

            // for (let h = 0; h < dbfChecked.length; h++){
            //     for (let i = 0; i < fileUpload.length; i++){
            //         if (fileUpload[i].name == dbfChecked[h].value){
            //             fileDBF.append('file'+totalFiles, fileUpload[i])
            //             totalFiles = totalFiles + 1;
            //         }
            //     }
            // }

            for (let i = 0; i < fileUpload.length; i++){
                if (fileUpload[i].name == dbfChecked){
                    fileDBF.append('file', fileUpload[i])
                    totalFiles = totalFiles + 1;
                }
            }

            fileDBF.append('totalFiles', totalFiles);

            if (totalFiles < 1){
                swal('Pilih File Terlebih Dahulu !', '', 'warning');
                return false;
            }

            console.log(dbfChecked)
            console.log(totalFiles)
            console.log(fileDBF)

            ajaxSetup();
            $.ajax({
                url: '{{url('/OMI/proses-bkl/proses-file')}}',
                type: 'POST',
                processData:false,
                contentType:false,
                dataType: "json",
                data:fileDBF,
                success: function (result) {
                    console.log(result)
                    console.log(result.msg)
                    let idButtonCetak = result.data.report_id;
                    if (idButtonCetak) {
                        for(let i = 0; i < idButtonCetak.length; i++){
                            if (idButtonCetak[i] == 1) {
                                $('#btnCetakList').show();
                                $('#btnCetakBpb').show();
                                $('#btnCetakStruk').show();
                                $('#btnCetakReset').show();
                            } else if (idButtonCetak[i] == 5) {
                                $('#btnCetakTolakan').show();
                            }
                        }
                    }
                }, error: function (error) {
                    errorHandlingforAjax(error)
                }
            })
        }

        function choosePaperSize(report_id) {
            if (report_id == 5) {
                console.log("cetak tolakan tanpa tanya size");
                return false;
            }
            swal({
                title: 'Pilih ukuran cetakan',
                icon: 'warning',
                buttons: {
                    cancel: 'Cancel',
                    besar: {
                        text: 'Besar',
                        value: 'B'
                    },
                    kecil: {
                        text: 'Kecil',
                        value: 'K'
                    }
                },
                dangerMode: true
            }).then((size) => {
                if (size){
                    console.log(size)
                    console.log(report_id)
                    console.log("cetak report")
                }
            });
        }

    </script>

@endsection
