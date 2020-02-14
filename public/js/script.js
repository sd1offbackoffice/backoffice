function ajaxSetup(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}

// Untuk merubah inputan user menjadi huruf kapital
function convertToUpper(val, id) {
    $('#'+ id +'').val(val.toUpperCase());
}
