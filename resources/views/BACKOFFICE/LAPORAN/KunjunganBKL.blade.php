@extends('navbar')
@section('title','LAPORAN - BULANAN KEDATANGAN SUPPLIER BKL')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Kedatangan Supplier BKL</legend>
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <div class="col-sm-12">
                                <label class="col-sm-4 text-right font-weight-normal">Periode</label>
                                <input type="text" id="datepicker">
                                <label class="col-sm-2 text-left">MM / YYYY</label>
                            </div>
                                <button class="btn btn-success" style="float: right" type="button" onclick="cetak()">C E T A K</button>
                        </form>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <script>

        $("#datepicker").datepicker( {
            dateFormat: 'mm/yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,

            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).val($.datepicker.formatDate('mm/yy', new Date(year, month, 1)));
            }
        });

        $("#datepicker").focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });
        function cetak() {
            let date = $('#datepicker').val();
            if(date == null || date == ""){
                swal('Input masih kosong','','warning');
                return false
            }
            date = date.split('/').join('-');
            // let date2 = date.split("/")
            // let year = date2[1];
            // let month = date2[0];
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/checkdata',
                type: 'post',
                data: {
                    date:date
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    if(result.kode == '1'){
                        window.open('{{ url()->current() }}/printdoc/'+date,'_blank');
                    }else{
                        swal('', "Tidak ada data!", 'warning');
                    }
                    $('#modal-loader').modal('hide');
                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }
    </script>
@endsection
