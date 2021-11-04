
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
    if (!number || number == '0')
        return '0.00';
    else
        number = parseFloat(number).toFixed(2);
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Untuk merubah angka biasa menjadi format Rupiah tanpa .00
// Created By : Leo(25/02/2020) | Modify By :
function convertToRupiah2(number) {
    if (!number)
        return 0;
    else return parseInt(number).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
        if(value == 'now')
            date = new Date();
        else date = new Date(value.substr(0,10));

        if(parseInt(date.getDate()) < 10)
            tgl = '0' + date.getDate().toString();
        else tgl = date.getDate();

        if(parseInt(date.getMonth()+1) < 10)
            bulan = '0' + parseInt(date.getMonth()+1).toString();
        else bulan = parseInt(date.getMonth()+1).toString();

        return tgl + '/' + bulan + '/' + date.getFullYear();
    }
}

// Untuk merubah format tanggal menjadi sesuai keinginan
// Created By : Leo (01/04/2020) | Modify By :
function formatDateCustom(value,format) {
    return $.datepicker.formatDate(format, new Date(value));
}


function nvl(value,param) {
    if(value==null || value=="" || value=="null" || value==" " || value=="NaN" ){
        return param;
    }
    else
        return value;
}

// Untuk substring waktu yang ada di tanggal
// Created By : JR (27/02/2020) | Modify By :
function formatDateForInputType(value) {
    if(value == null || value == '')
        return 0;
    else {
        return value.substr(0,10);
    }
}

// Untuk substring waktu yang ada di tanggal
// Created By : Denni (23/08/2021) | Modify By :
function cekNull(value,p2) {
    if(value == null || value == '')
        return p2;
    else {
        return value;
    }
}

// Untuk mengecek inputan tanggal apakah berformat dd/mm/yyyy
// Created By : Leo (28/02/2020) | Modify By :
function checkDate(date){
    if(date.length == 10 && date[2] == '/' && date[5] == '/'){
        var dateRegex = /^(?=\d)(?:(?:31(?!.(?:0?[2469]|11))|(?:30|29)(?!.0?2)|29(?=.0?2.(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(?:\x20|$))|(?:2[0-8]|1\d|0?[1-9]))([-.\/])(?:1[012]|0?[1-9])\1(?:1[6-9]|[2-9]\d)?\d\d(?:(?=\x20\d)\x20|$))?(((0?[1-9]|1[012])(:[0-5]\d){0,2}(\x20[AP]M))|([01]\d|2[0-3])(:[0-5]\d){1,2})?$/;

        return dateRegex.test(date);
    }
    else return false;
}

//nvl
// function nvl(str,ret){
//     if(str == null || str == ''){
//         return ret;
//     }
//     else str;
// }

// Template alert error di ajax
// Created By : JR (05/01/2021) | Modify By :

function alertError(title, text) {
    swal(title, text.substr(0,200), 'error').then(function(){
        $('#modal-loader').modal('hide');
    });
}

// Fungsi untuk mengecek float
// Created By : Leo (13/01/2021) | Modify By :
function isFloat(value) {
    return value === +value && value !== (value|0);
}

// Fungsi untuk encode html char
// Created By : Leo (29/01/2021) | Modify By :
function encodeHtml(text) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };

    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

// Fungsi untuk decode html char
// Created By : Leo (29/01/2021) | Modify By :
function decodeHtml(str)
{
    var map =
        {
            '&amp;': '&',
            '&lt;': '<',
            '&gt;': '>',
            '&quot;': '"',
            '&#039;': "'"
        };
    return str.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g, function(m) {return map[m];});
}

// Fungsi untuk munculin swal dengan timer. Dibuat function supaya penulisan code lebih singkat, (tinggal panggil nama function)
// Created By : JR (09/07/2021) | Modify By :
function swalWithTime(title,text,icon,time){
    swal({
        icon: icon,
        title: title,
        text:text,
        // showConfirmButton: false,
        buttons: false,
        timer: time
    });
}

function errorHandlingforAjax(error){
    $('#modal-loader').modal('hide');
    console.log(error.responseJSON.message.substr(0,100));
    swal(error.statusText, error.responseJSON.message.substr(0,200), 'error')
}
