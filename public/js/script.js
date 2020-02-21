// Untuk CSRF token Ajax
// Created By : JR(18/02/2020) | Modify By :
function ajaxSetup(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}

// Untuk merubah inputan user menjadi huruf kapital
// Created By : JR(18/02/2020) | Modify By :
function convertToUpper(val, id) {
    $('#'+ id +'').val(val.toUpperCase());
}

// Untuk merubah angka biasa menjadi format Rupiah
// Created By : Denni(21/02/2020) | Modify By :
function convertToRupiah(number) {
    if (!number)
        return 0;
    else
        number = parseFloat(number).toFixed(2);
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Untuk merubah format Rupiah menjadi angka biasa
// Created By : Denni(21/02/2020) | Modify By :
function unconvertToRupiah(number) {
    if (!number)
        return 0;
    else
        return number.toString().replace(/\,/g, '');
}

// Untuk merubah digit plu sesuai keinginan
// Created By : Denni(21/02/2020) | Modify By :
function convertPlu(val) {
    var plu = val;
    for(var i = plu.length ; i < 7 ; i++){
        plu='0'+plu;
    }
    return plu;
}

// Untuk merubah format tanggal menjadi dd/mm/yyyy
// Created By : Leo (21/02/2020) | Modify By :
function formatDate(value) {
    if(value == null || value == '')
        return '';
    else {
        date = new Date(value.substr(0,10));

        if(parseInt(date.getDate()) < 10)
            tgl = '0' + date.getDate().toString();
        else tgl = date.getDate();

        if(parseInt(date.getMonth()+1) < 10)
            bulan = '0' + parseInt(date.getMonth()+1).toString();
        else bulan = parseInt(date.getMonth()+1).toString();



        return tgl + '/' + bulan + '/' + date.getFullYear();
    }
}
