@extends('navbar')
@section('title','Laporan Cash Back / Supplier / Item')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5">Laporan Cash Back / Supplier / Item</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <br>
                            <div class="row">
                                <label class="col-sm-4 text-right font-weight-normal">Tanggal</label>
                                <input class="col-sm-3 text-center form-control" type="text" id="daterangepicker">
                                <label class="col-sm-2 text-left">MM / DD / YYYY</label>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-sm-4 text-right font-weight-normal">Supplier</label>
                                <div class="col-sm-3 buttonInside">
                                    <input type="text" class="form-control" id="nmr1">
                                    <button onclick="getNmr('')" id="btn-no-doc" type="button" class="btn btn-lov p-0">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                                <span>S/D</span>
                                <div class="col-sm-3 buttonInside">
                                    <input type="text" class="form-control" id="nmr2">
                                    <button onclick="getNmr2('')" id="btn-no-doc" type="button" class="btn btn-lov p-0">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-sm-4 text-right font-weight-normal">Member</label>
                                <input class="col-sm-1 form-control" type="text" id="member" onkeypress="return isY(event)" maxlength="1">
                                <label class="col-sm-4 text-left font-weight-bold">[R]eguler &nbsp;&nbsp;&nbsp;[K]husus</label>
                            </div>
                            <br>
                            <div class="d-flex justify-content-around">
                                <label class="font-weight-normal">Kosong : <span class="font-weight-bold">S e m u a</span></label>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-success col-sm-3" type="button" onclick="print()">C E T A K</button>
                            </div>

                            <br>
                        </form>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="m_kodecabangHelp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="searchModal" class="form-control search_lov" type="text" placeholder="..." aria-label="Search">
                    </div>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="tableFixedHeader">
                                    <table class="table table-sm">
                                        <thead>
                                        <tr>
                                            <th>Kode Supplier</th>
                                            <th>Nama Supplier</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbodyModalHelp"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-hide" id="idModal"></p>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <script src={{asset('/js/sweetalert2.js')}}></script>
    <script>

        function isY(evt){
            $('#member').keyup(function(){
                $(this).val($(this).val().toUpperCase());
            });
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 114) // r kecil
                return 82; // r besar

            if (charCode == 107) // k kecil
                return 75; //k besar

            if (charCode == 82 || charCode == 75)
                return true;
            return false;
        }

        $("#daterangepicker").daterangepicker( {
            format: 'MM/DD/YYYY',
        });

        $('#searchModal').keypress(function (e) {
            if (e.which === 13) {
                let val = $('#searchModal').val().toUpperCase();
                searchNmr(val)
            }
        });

        function searchNmr(val) {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/getnmr',
                type: 'post',
                data: {
                    val:val
                },
                success: function (result) {
                    $('.modalRow').remove();
                    if($('#idModal').val() == '1'){
                        for (i = 0; i< result.length; i++){
                            $('#tbodyModalHelp').append("<tr onclick=chooseNmr('"+ result[i].sup_kodesupplier+"') class='modalRow'><td>"+ result[i].sup_kodesupplier +"</td> <td>"+ result[i].sup_namasupplier +"</td></tr>")
                        }
                    }else{
                        for (i = 0; i< result.length; i++){
                            $('#tbodyModalHelp').append("<tr onclick=chooseNmr2('"+ result[i].sup_kodesupplier+"') class='modalRow'><td>"+ result[i].sup_kodesupplier +"</td> <td>"+ result[i].sup_namasupplier +"</td></tr>")
                        }
                    }
                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function getNmr(val) {
            $('#modal-loader').modal('show');
            $('#searchModal').val('');
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/getnmr',
                type: 'post',
                data: {
                    val:val
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    $('#idModal').val('1');
                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseNmr('"+ result[i].sup_kodesupplier+"') class='modalRow'><td>"+ result[i].sup_kodesupplier +"</td> <td>"+ result[i].sup_namasupplier +"</td></tr>")
                    }
                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function chooseNmr(val){
            let kode = val;
            $('#nmr1').val(kode);
            $('#modalHelp').modal('hide');
            $('#modal-loader').modal('hide');
        }

        function getNmr2(val) {
            $('#modal-loader').modal('show');
            $('#searchModal').val('');
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/getnmr',
                type: 'post',
                data: {
                    val:val
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    $('#idModal').val('2');
                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseNmr2('"+ result[i].sup_kodesupplier+"') class='modalRow'><td>"+ result[i].sup_kodesupplier +"</td> <td>"+ result[i].sup_namasupplier +"</td></tr>")
                    }
                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function chooseNmr2(val){
            let kode = val;
            $('#nmr2').val(kode);
            $('#modalHelp').modal('hide');
            $('#modal-loader').modal('hide');
        }

        function print() {
            let date = $('#daterangepicker').val();
            if(date == null || date == ""){
                swal.fire('Input masih kosong','','warning');
                return false;
            }
            let dateA = date.substr(0,10);
            let dateB = date.substr(13,10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');
            let sup1 = $('#nmr1').val();
            let sup2 = $('#nmr2').val();
            if(sup1 == '' && sup2 != '' || sup1 != '' && sup2 == ''){
                swal.fire('Kode Supplier Harus Terisi Semua Atau Tidak Terisi Sama Sekali ','','warning');
                return false;
            }else if(sup1 > sup2){
                swal.fire('Kode Supplier 1 Harus Lebih Kecil dari Kode Supplier 2','','warning');
                return false;
            }
            if(sup1 == ''){
                sup1 = "nodata";
            }
            if(sup2 == ''){
                sup2 = "nodata";
            }
            swal.fire({
                title: 'Cetak ?',
                showDenyButton: true,
                confirmButtonText: `Cash Back per Supplier`,
                denyButtonText: `Refund Cash Back per Supplier`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    if($('#member').val() == 'R'){
                        ajaxSetup();
                        $.ajax({
                            url: '{{ url()->current() }}/checkdatar',
                            type: 'post',
                            data: {
                                dateA:dateA,
                                dateB:dateB,
                                p_tipe:'S',
                                sup1:sup1,
                                sup2:sup2
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (w) {
                                if(w.kode == '1'){
                                    window.open('{{ url()->current() }}/printdocr/'+dateA+'/'+dateB+'/S/'+sup1+'/'+sup2,'_blank');
                                }
                                else if (w.kode == '0'){
                                    swal.fire('', "tidak ada data", 'warning');
                                }
                                $('#modal-loader').modal('hide');
                            }, error: function (e) {
                                console.log(e);
                                alert('error');
                            }
                        })
                    }else if($('#member').val() == 'K'){
                        ajaxSetup();
                        $.ajax({
                            url: '{{ url()->current() }}/checkdatak',
                            type: 'post',
                            data: {
                                dateA:dateA,
                                dateB:dateB,
                                p_tipe:'S',
                                sup1:sup1,
                                sup2:sup2
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (w) {
                                if(w.kode == '1'){
                                    window.open('{{ url()->current() }}/printdock/'+dateA+'/'+dateB+'/S/'+sup1+'/'+sup2,'_blank');
                                }
                                else if (w.kode == '0'){
                                    swal.fire('', "tidak ada data", 'warning');
                                }
                                $('#modal-loader').modal('hide');
                            }, error: function (e) {
                                console.log(e);
                                alert('error');
                            }
                        })
                    }else{
                        ajaxSetup();
                        $.ajax({
                            url: '{{ url()->current() }}/checkdata',
                            type: 'post',
                            data: {
                                dateA:dateA,
                                dateB:dateB,
                                p_tipe:'S',
                                sup1:sup1,
                                sup2:sup2
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (w) {
                                if(w.kode == '1'){
                                    window.open('{{ url()->current() }}/printdoc/'+dateA+'/'+dateB+'/S/'+sup1+'/'+sup2,'_blank');
                                }
                                else if (w.kode == '0'){
                                    swal.fire('', "tidak ada data", 'warning');
                                }
                                $('#modal-loader').modal('hide');
                            }, error: function (e) {
                                console.log(e);
                                alert('error');
                            }
                        })
                    }
                } else if (result.isDenied) {
                    if($('#member').val() == 'R'){
                        ajaxSetup();
                        $.ajax({
                            url: '{{ url()->current() }}/checkdatar',
                            type: 'post',
                            data: {
                                dateA:dateA,
                                dateB:dateB,
                                p_tipe:'R',
                                sup1:sup1,
                                sup2:sup2
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (w) {
                                if(w.kode == '1'){
                                    window.open('{{ url()->current() }}/printdocr/'+dateA+'/'+dateB+'/R/'+sup1+'/'+sup2,'_blank');
                                }
                                else if (w.kode == '0'){
                                    swal.fire('', "tidak ada data", 'warning');
                                }
                                $('#modal-loader').modal('hide');
                            }, error: function (e) {
                                console.log(e);
                                alert('error');
                            }
                        })
                    }else if($('#member').val() == 'K'){
                        ajaxSetup();
                        $.ajax({
                            url: '{{ url()->current() }}/checkdatak',
                            type: 'post',
                            data: {
                                dateA:dateA,
                                dateB:dateB,
                                p_tipe:'R',
                                sup1:sup1,
                                sup2:sup2
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (w) {
                                if(w.kode == '1'){
                                    window.open('{{ url()->current() }}/printdock/'+dateA+'/'+dateB+'/R/'+sup1+'/'+sup2,'_blank');
                                }
                                else if (w.kode == '0'){
                                    swal.fire('', "tidak ada data", 'warning');
                                }
                                $('#modal-loader').modal('hide');
                            }, error: function (e) {
                                console.log(e);
                                alert('error');
                            }
                        })
                    }else{
                        ajaxSetup();
                        $.ajax({
                            url: '{{ url()->current() }}/checkdata',
                            type: 'post',
                            data: {
                                dateA:dateA,
                                dateB:dateB,
                                p_tipe:'R',
                                sup1:sup1,
                                sup2:sup2
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (w) {
                                if(w.kode == '1'){
                                    window.open('{{ url()->current() }}/printdoc/'+dateA+'/'+dateB+'/R/'+sup1+'/'+sup2,'_blank');
                                }
                                else if (w.kode == '0'){
                                    swal.fire('', "tidak ada data", 'warning');
                                }
                                $('#modal-loader').modal('hide');
                            }, error: function (e) {
                                console.log(e);
                                alert('error');
                            }
                        })
                    }
                }
            })
        }
    </script>
@endsection
