@extends('navbar')
@section('title','Restore Data Month End')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <fieldset class="card">
                    <legend class="w-auto ml-5">Restore Data Untuk Proses Month End</legend>
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <div class="col-sm-12">
                                <label class="col-sm-4 text-right font-weight-normal">Periode</label>
                                <input type="text" id="datepicker">
                                {{--<input class="col-sm-4 text-left date" type="month" placeholder="TXT_PERIODE" style="text-align: left">--}}
                                <label class="col-sm-2 text-left">MM / YYYY</label>
                            </div>
                                <button class="btn btn-primary" style="float: right" type="button" onclick="restoreNow()">RESTORE DATA</button>
                        </form>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <<script>

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
        function restoreNow() {
            let date = $('#datepicker').val();
            //let year = date.substr(0,4);
            //let month = date.substr(5,6);
            let year = date.substr(3,6);
            let month = date.substr(0,2);

            if(date == null || date == ""){
                swal('Input masih kosong','','warning');
                return false
            }
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/restorenow',
                type: 'post',
                data: {
                    month:month,
                    year:year
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    if(result.kode == '1'){
                        swal('', result.msg, 'success');
                    }else{
                        swal('', result.msg, 'warning');
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
