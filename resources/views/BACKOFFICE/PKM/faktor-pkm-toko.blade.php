@extends('navbar')
@section('title','Faktor Penambah PKM')
@section('content')
<div class="container-fluid">
    <div class="row no-gutters justify-content-center">
        <div class="col-md-11">
            <button class="btn btn-primary" id="nBtn">N+</button>
            <button class="btn btn-primary" id="mBtn">M+</button>

            <fieldset class="card border-dark n-form">               
                <div class="card-body shadow-lg cardForm">
                    <br>
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="" id=""></th>
                                        <th>NO PERJANJIAN</th>
                                        <th>PLU</th>
                                        <th>KD DISPLAY</th>
                                        <th>TGL AWAL</th>
                                        <th>TGL AKHIR</th>
                                        <th>QTY</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-center">FILTER</h4>
                            <div class="form-group">
                                <label for="tglAwal">TGL AWAL</label>
                                <input type="text" class="form-control" name="tglAwal" id="tglAwal" aria-describedby="tglAwal" placeholder="TGL AWAL">
                            </div>
                            <div class="form-group">
                                <label for="tglAkhir">TGL AKHIR</label>
                                <input type="text" class="form-control" name="tglAkhir" id="tglAkhir" aria-describedby="tglAkhir" placeholder="TGL AKHIR">
                            </div>
                            {{-- <hr style="background-color: grey"> --}}
                            <hr style="background-color: grey">
                            <div class="form-group">
                                <label for="filterKdDisplay">FILTER KD DISPLAY</label>
                                <input type="text" class="form-control" name="filterKdDisplay" id="filterKdDisplay" aria-describedby="filterKdDisplay" placeholder="TGL AKHIR">
                            </div>
                            <hr style="background-color: grey">
                            <div class="form-group">
                                <label for="searchPLU">CARI PLU</label>
                                <input type="text" class="form-control" name="searchPLU" id="searchPLU" aria-describedby="searchPLU" placeholder="TGL AKHIR">
                            </div>
                            <hr style="background-color: grey">
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary text-center" id="updateQtyPkmg" type="button">UPDATE QTY & PKMG</button>
                            </div>
                            <div class="d-flex justify-content-center">
                                <small class="form-text text-muted"><span style="color: red;">*</span>check qty yang akan diupdate</small>
                            </div>
                            
                        </div>
                    </div>
                    <hr style="background-color: grey">
                    <div class="row no-gutters no-gutters">
                        <label class="col-sm-2" for="plu">PLU</label>
                        <input class="form-control col-sm-2" type="text" name="plu" id="plu" placeholder="plu">
                        
                        <label class="col-sm-1 text-center" for="plu2" >-</label>
                        <input class="form-control col-sm-5" type="text" name="plu2" id="plu2" placeholder="plu2">
                    </div>
                    <br>
                    <div class="row no-gutters no-gutters">
                        <label class="col-sm-1" for="mpkm">MPKM</label>
                        <input class="form-control col-sm-1" type="text" name="mpkm" id="mpkm" placeholder="mpkm">

                        <label class="col-sm-1 text-center" for="plu2" >M+</label>
                        <input class="form-control col-sm-1" type="text" name="plu2" id="plu2" placeholder="plu2">

                        <label class="col-sm-1 text-center" for="plu2" >PKMT</label>
                        <input class="form-control col-sm-1" type="text" name="plu2" id="plu2" placeholder="plu2">

                        <label class="col-sm-1 text-center" for="plu2" >QTY GONDOLA</label>
                        <input class="form-control col-sm-2" type="text" name="plu2" id="plu2" placeholder="plu2">

                        <label class="col-sm-1 text-center" for="plu2" >PKMG</label>
                        <input class="form-control col-sm-2" type="text" name="plu2" id="plu2" placeholder="plu2">
                    </div>
                    <hr style="background-color: grey">
                    <div class="row">
                        <div class="col-sm-10">
                            <h6>TAMBAH</h6>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>NO PERJANJIAN</th>
                                        <th>PLU</th>
                                        <th>KD DISPLAY</th>
                                        <th>TGL AWAL</th>
                                        <th>TGL AKHIR</th>
                                        <th>QTY</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                        <td><input type="text" class="form-control"></td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-2 d-flex align-items-center justify-content-center">
                            {{-- <div> --}}
                                <button type="button" class="btn btn-primary w-75" >ADD</button>
                            {{-- </div>                             --}}
                        </div>
                    </div>
                    <hr style="background-color: grey">
                    <div class="row">
                        <div class="col-sm-2 justify-content-center">
                            <h6>UPLOAD</h6>
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-primary">UPLOAD</button>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <p>File CSV harus ada di server database /u01/lhost/trf_mplus/DATA/</p>
                            <p>Filename NPLUS_GO.CSV separator |</p>
                            <p>List PLU yang tidak terproses ada di S:/TRF/  (jika ada)</p>
                        </div>
                        <div class="col-sm-2 d-flex align-items-center justify-content-center">
                            <div>
                                <button type="button" class="btn btn-primary">REFRESH</button>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="card border-dark m-form">               
                <div class="card-body shadow-lg cardForm">
                    <br>
                    <div class="row">
                        <div class="col-lg-6">
                            <table class="table table-sm table-bordered mb-3 text-center" id="tblM">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox"></th>
                                        <th>PLU</th>
                                        <th>M+</th>
                                        <th>M+ I</th>
                                        <th>M+ O</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <!-- row data -->
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="col-lg-5 mt-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>PLU</label>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <input type="text" class="form-control" id="md_prdcd" placeholder="MD_PRDCD">
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" id="md_deskripsi" placeholder="MD_Deskripsi">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group no-gutters">
                                        <label class="col-sm-2">MPKM</label>
                                        <label style="margin-left:5px;">PKMT</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="md_mpkm" placeholder="MD_MPKM">
                                            </div>
                                            
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="md_pkmt" placeholder="MD_PKMT">
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group row no-gutters d-flex justify-content-end">
                                        <label class="col-sm-2">CARI PLU</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="mf_prdcd" placeholder="MF_PRDCD">
                                        </div>
                                    </div>
                                    <hr class="hl">
                                    <div class="form-group row no-gutters d-flex justify-content-center">
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-primary btn-lg">UPDATE</button>
                                            <label>*check qty yang akan diupdate</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="hl">
                    <label>TAMBAH</label>
                    <div class="row d-flex justify-content-center">
                        <div class="form-group">
                            <label class="col-lg-3">PLU</label>
                            <label class="col-lg-3">M+ I</label>
                            <label>M+ O</label>
                            <br>
                            <div class="row">
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" id="ma_prdcd" placeholder="MA_PRDCD" maxlength="7">
                                </div>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" id="ma_mplus_i" placeholder="MA_PLUS_I">
                                </div>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" id="ma_mplus_o" placeholder="MA_PLUS_O">
                                </div>
                                <div class="col-lg-3">
                                   <button class="btn btn-primary btn-md" onclick="insertPLU()"> ADD </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="hl">
                    <label>UPLOAD</label>
                    <div class="row">
                        <div class="col-lg-3">

                        </div>
                        <div class="col-lg-1 justify-content-end">
                            <button class="btn btn-primary btn-md">UPLOAD</button>
                        </div>
                        <div class="col-lg-5">
                            <p>File CSV harus ada di server database /u01/lhost/trf_mplus/DATA/ <br>
                            Filename MPLUS_GO.CSV separator | <br>
                            List PLU yang tidak terproses ada di S:/TRF/  (jika ada)
                            </p>
                        </div>
                        <div class="col-lg-1">
                            <div class="vl-2"></div>
                        </div>
                        <div class="col-lg-2 mt-4">
                            <button class="btn btn-primary btn-md">REFRESH</button>
                        </div>
                    </div>
                </div>
            </fieldset>

        </div>
    </div>
</div>

<style>
.vl {
  border-left: 1px solid gray;
  height: 400px;
}

.vl-2 {
  border-left: 1px solid gray;
  height: 100px;
}

#tblM, #tblB {
    overflow-x : disabled;
    overflow-y : scroll; 
}

.hl {
    border: 1px solid black;
}
</style>

{{-- <script src={{asset('/js/sweetalert2.js')}}></script> --}}
<script>
    $(document).ready(function () {
        $('.m-form').hide();

        $('#nBtn').click(function (e) {
            $('.m-form').hide();          
            $('.n-form').show();          
        });
        $('#mBtn').click(function (e) {
            $('.n-form').hide();
            $('.m-form').show();            
        });
        getDataTableM();
    });

    function getDataTableM() {
        arrDataTableM = [];

        if($.fn.DataTable.isDataTable('#tblM')){
            $('#tblM').DataTable().destroy();
            $("#tblM tbody tr").remove();
        }

        $('#tblM').DataTable({
            "ajax": '{{ route('get-data-table-m')  }}',
            "columns": [
                {data: 'pkmp_kodeigr'},
                {data: 'pkmp_prdcd'},
                {data: 'pkmp_mplus'},
                {data: 'pkmp_mplusi'},
                {data: 'pkmp_mpluso'},
            ],
            "paging": false,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "createdRow": function (row, data, dataIndex) {
                // row -> <tr>
                // data -> isi semua data dalam array
                // dataIndex -> lopping nilai index setiap data
                $(row).addClass('row-data-table-m').css({'cursor': 'pointer'});
                arrDataTableM.push(data);
            },
            "order" : [],
            "scrollY" : "53vh",
            "scrollX" : false,
            "initComplete": function(){
                $(document).on('click', '.row-data-table-m', function (e) {
                    console.log(e,'ini e');
                    $('.row-data-table-m').removeAttr('style').css({'cursor': 'pointer'});
                    $(this).css({"background-color": "#acacac","color": "white"});

                    showDetail($(this).index());
                    currentIndex = $(this).index();
                });

                $('.row-data-table-m:eq(0)').css({"background-color": "#acacac","color": "white"});
                showDetail(0);
            }
        });
    }

    function showDetail(index){
        data = arrDataTableM[index];

        // console.log(data.pkmp_prdcd);

        // $('#md_prdcd').val(data.pkmp_prdcd);
        // $('#md_deskripsi').val(data.pkmp_mplus);
        // $('#md_mpkm').val(data.pkmp_mplusi);
        // $('#md_pkmt').val(data.pkmp_mpluso);

            ajaxSetup();
            $.ajax({
                url : '{{ route('get-data-detail')  }}',
                type : 'get',
                data : {
                    pkmp_prdcd : data.pkmp_prdcd
                },
                success: function(response)
                {
                    console.log(response);
                    $('#md_prdcd').val(response[0].prd_prdcd);
                    $('#md_deskripsi').val(response[0].prd_deskripsipanjang);
                    $('#md_mpkm').val(response[0].pkm_pkmt);
                    $('#md_pkmt').val(response[0].pkm_mpkm);
                }
            });
      
    }

    function insertPLU()
    {
        if($('#ma_prdcd').val() == '' || $('#ma_mplus_i').val() == '' || $('#ma_mplus_o').val() == '')
        {
            swal('Inputan harus diisi semua !!', '', 'warning');
        }
        else if($('#ma_prdcd').val().length < 7)
        {
            swal('PLU harus terdiri dari 7 angka', '', 'warning');
        }
        else if($('#ma_mplus_i').val() + $('#ma_mplus_o').val() == '0' )
        {
            swal('Qty harus > 0', '', 'warning');
        }
        else
        {
            // convertPlu($('#'+id).val())
            swal({
                title: 'Apakah anda yakin ingin menambahkan PLU ini ? ',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function(ok){
                if(ok){
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current().'/insert-plu' }}',
                        type: 'post',
                        data: {
                            ma_prdcd : $('#ma_prdcd').val(),
                            ma_mplus_i: $('#ma_mplus_i').val(),
                            ma_mplus_o: $('#ma_mplus_o').val()
                        },
                        success: function (response) {
                            swal({
                                title: response.title,
                                text: response.message,
                                icon: 'success'
                            });
                        }, error: function (error) {
                            swal({
                                title: error.responseJSON.title,
                                text: error.responseJSON.message,
                                icon: 'error'
                            });
                        }
                    })// ajax
                }// if ok
            })
        }       
    }
</script>
@endsection