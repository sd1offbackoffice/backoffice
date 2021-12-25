<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AllModel extends Model
{
    public function getKodeigr(){ // Created By : JR(10/02/2020) | Modify By :
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')->get()->toArray();

        return $perusahaan;
    }

    public function getDate(){ // Created By : JR(10/02/2020) | Modify By :
        date_default_timezone_set('Asia/Jakarta');
        $date       = date('Y-m-d');

        return $date;
    }

    public function getDateTime(){ // Created By : JR(10/02/2020) | Modify By :
        date_default_timezone_set('Asia/Jakarta');
        $date       = date('Y-m-d H:i:s');

        return $date;
    }

    public function connectionProcedure(){
        //yang ini jangan diganti punya JEFRI
        return oci_connect('simsmg', 'simsmg','(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.237.193)(PORT=1521)) (CONNECT_DATA=(SERVER=DEDICATED) (SERVICE_NAME = simsmg)))');
    }


}
