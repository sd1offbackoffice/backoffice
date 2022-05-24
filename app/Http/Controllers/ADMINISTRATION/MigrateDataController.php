<?php

namespace App\Http\Controllers\ADMINISTRATION;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class MigrateDataController extends Controller
{
    public function __construct(){
        $this->listCabang = array(
            (object)array(
                'kodeigr' => '01',
                'namacabang' => 'cipinang',
                'segment' => '226',
                'kode' => 'cpg',
                'dbHostProd' => '192.168.226.193',
                'dbHostSim' => '192.168.226.193',
                'dbPass' => 'M1ghtyth0rcpg!'
            ),
            (object)array(
                'kodeigr' => '03',
                'namacabang' => 'surabaya',
                'segment' => '220',
                'kode' => 'sby',
                'dbHostProd' => '192.9.220.191',
                'dbHostSim' => '192.9.220.193',
                'dbPass' => 'V1s10nsby!'
            ),
            (object)array(
                'kodeigr' => '04',
                'namacabang' => 'bandung',
                'segment' => '222',
                'kode' => 'bdg',
                'dbHostProd' => '192.168.222.191',
                'dbHostSim' => '192.168.222.193',
                'dbPass' => 'Ind0gros1r2018'
            ),
            (object)array(
                'kodeigr' => '05',
                'namacabang' => 'tangerang',
                'segment' => '228',
                'kode' => 'tgr',
                'dbHostProd' => '192.168.228.191',
                'dbHostSim' => '192.168.228.193',
                'dbPass' => 'Gr34thulktgr!'
            ),
            (object)array(
                'kodeigr' => '06',
                'namacabang' => 'yogyakarta',
                'segment' => '224',
                'kode' => 'ygy',
                'dbHostProd' => '192.168.224.191',
                'dbHostSim' => '192.168.224.193',
                'dbPass' => 'Sp1d3rmanyog!'
            ),
            (object)array(
                'kodeigr' => '15',
                'namacabang' => 'medan',
                'segment' => '229',
                'kode' => 'mdn',
                'dbHostProd' => '192.168.229.191',
                'dbHostSim' => '192.168.229.193',
                'dbPass' => 'Sc4rl3tw1cmdn!'
            ),
            (object)array(
                'kodeigr' => '16',
                'namacabang' => 'bekasi',
                'segment' => '225',
                'kode' => 'bks',
                'dbHostProd' => '192.168.225.191',
                'dbHostSim' => '192.168.225.193',
                'dbPass' => '1r0nm4nbks!'
            ),
            (object)array(
                'kodeigr' => '17',
                'namacabang' => 'palembang',
                'segment' => '232',
                'kode' => 'plg',
                'dbHostProd' => '192.168.232.191',
                'dbHostSim' => '192.168.232.193',
                'dbPass' => 'V4lkyr13PLG!'
            ),
            (object)array(
                'kodeigr' => '18',
                'namacabang' => 'kemayoran',
                'segment' => '234',
                'kode' => 'kmy',
                'dbHostProd' => '192.168.234.193',
                'dbHostSim' => '192.168.234.193',
                'dbPass' => 'C4ptus4kmy!'
            ),
            (object)array(
                'kodeigr' => '20',
                'namacabang' => 'pekanbaru',
                'segment' => '235',
                'kode' => 'pku',
                'dbHostProd' => '192.168.235.191',
                'dbHostSim' => '192.168.235.193',
                'dbPass' => 'Bl4ckw1dowpku!'
            ),
            (object)array(
                'kodeigr' => '21',
                'namacabang' => 'samarinda',
                'segment' => '236',
                'kode' => 'smd',
                'dbHostProd' => '192.168.236.191',
                'dbHostSim' => '192.168.236.193',
                'dbPass' => 'Furrysmd!'
            ),
            (object)array(
                'kodeigr' => '22',
                'namacabang' => 'semarang',
                'segment' => '237',
                'kode' => 'smg',
                'dbHostProd' => '192.168.237.191',
                'dbHostSim' => '192.168.237.193',
                'dbPass' => 'H4wkey3smg!'
            ),
            (object)array(
                'kodeigr' => '25',
                'namacabang' => 'bogor',
                'segment' => '240',
                'kode' => 'bgr',
                'dbHostProd' => '192.168.240.191',
                'dbHostSim' => '192.168.240.193',
                'dbPass' => '4ntm4nbgr!'
            ),
            (object)array(
                'kodeigr' => '26',
                'namacabang' => 'pontianak',
                'segment' => '238',
                'kode' => 'ptk',
                'dbHostProd' => '192.168.238.191',
                'dbHostSim' => '192.168.238.193',
                'dbPass' => 'Bp4nthptk!'
            ),
            (object)array(
                'kodeigr' => '27',
                'namacabang' => 'banjarmasin',
                'segment' => '239',
                'kode' => 'bms',
                'dbHostProd' => '192.168.239.191',
                'dbHostSim' => '192.168.239.193',
                'dbPass' => 'Drstr4ng3bms!'
            ),
            (object)array(
                'kodeigr' => '28',
                'namacabang' => 'manado',
                'segment' => '241',
                'kode' => 'mdo',
                'dbHostProd' => '192.168.241.191',
                'dbHostSim' => '192.168.241.193',
                'dbPass' => 'W0lfverin3mdo!'
            ),
            (object)array(
                'kodeigr' => '30',
                'namacabang' => 'gij',
//                'segment' => '240',
                'segment' => '245', //Diganti sama kaya ciputat oleh JR atas permintaan ko ari pada tanggal 31-05-2021
                'kode' => 'gij',
                'dbHost' => '172.20.22.93',
                'dbPass' => 'St4rL0rdgib!'
            ),
            (object)array(
                'kodeigr' => '31',
                'namacabang' => 'makasar',
                'segment' => '243',
                'kode' => 'mks',
                'dbHostProd' => '192.168.243.191',
                'dbHostSim' => '192.168.243.193',
                'dbPass' => 'C4pm4rv3lmks!'
            ),
            (object)array(
                'kodeigr' => '32',
                'namacabang' => 'jambi',
                'segment' => '242',
                'kode' => 'jbi',
                'dbHostProd' => '192.168.242.191',
                'dbHostSim' => '192.168.242.193',
                'dbPass' => 'B4bygr0otjbi!'
            ),
            (object)array(
                'kodeigr' => '33',
                'namacabang' => 'kendari',
                'segment' => '244',
                'kode' => 'kri',
                'dbHostProd' => '192.168.244.191',
                'dbHostSim' => '192.168.244.193',
                'dbPass' => 'D4redev1lkri!'
            ),
            (object)array(
                'kodeigr' => '34',
                'namacabang' => 'ambon',
                'segment' => '230',
                'kode' => 'amb',
                'dbHostProd' => '192.168.230.191',
                'dbHostSim' => '192.168.230.193',
                'dbPass' => 'L0k1amb!'
            ),
            (object)array(
                'kodeigr' => '35',
                'namacabang' => 'ciputat',
                'segment' => '245',
                'kode' => 'cpt',
                'dbHostProd' => '192.168.245.191',
                'dbHostSim' => '192.168.245.193',
                'dbPass' => 'Slvsurf3rcpt!'
            ),
            (object)array(
                'kodeigr' => '36',
                'namacabang' => 'karawang',
                'segment' => '231',
                'kode' => 'krw',
                'dbHostProd' => '192.168.231.191',
                'dbHostSim' => '192.168.231.193',
                'dbPass' => 'F4lc0nkrw!'
            ),
            (object)array(
                'kodeigr' => '37',
                'namacabang' => 'malang',
                'segment' => '246',
                'kode' => 'mlg',
                'dbHostProd' => '192.168.246.191',
                'dbHostSim' => '192.168.246.193',
                'dbPass' => 'G4m0r4mlg!'
            ),
            (object)array(
                'kodeigr' => '38',
                'namacabang' => 'bandar lampung',
                'segment' => '247',
                'kode' => 'bdl',
                'dbHostProd' => '192.168.247.191',
                'dbHostSim' => '192.168.247.193',
                'dbPass' => 'J4rv15bdl!'
            ),
            (object)array(
                'kodeigr' => '39',
                'namacabang' => 'solo',
                'segment' => '248',
                'kode' => 'slo',
                'dbHostProd' => '192.168.248.191',
                'dbHostSim' => '192.168.248.193',
                'dbPass' => 'Ultr0nslo!'
            ),
            (object)array(
                'kodeigr' => '44',
                'namacabang' => 'cikokol',
                'segment' => '249',
                'kode' => 'ckl',
                'dbHostProd' => '192.168.249.191',
                'dbHostSim' => '192.168.249.193',
                'dbPass' => 'Sh4ngch1ckl!'
            ),
        );
    }

    public function index(){
        return view('ADMINISTRATION.migrate-data')->with([
            'cabang' => $this->listCabang
        ]);
    }

    public function migrate(Request $request){
        foreach($this->listCabang as $c){
            if($c->kodeigr == $request->kodeigr){
                $cabang = $c;
            }
        }

        $connection = 'sim'.$cabang->kode;

        try{
            DB::connection($connection)->beginTransaction();

            $table = DB::connection($connection)->table('tbmaster_useraccess_migrasi');

//            dd($table);

            $message = [];
            $message[] = self::createTableAccess($connection);
            $message[] = self::createTableUserAccess($connection);
            $message[] = self::createTableLog($connection);

            DB::connection($connection)->commit();

            $message[] = 'Data berhasil dikirim ke cabang '.strtoupper($cabang->namacabang).'!';

            return response()->json($message,200);
        }
        catch (\Exception $e){
            DB::connection($connection)->rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    static function createTableAccess($connection){
        try{
            $exist = Schema::connection($connection)->hasTable('tbmaster_access_migrasi');

            if(!$exist){
                DB::connection($connection)
                    ->statement("CREATE TABLE TBMASTER_ACCESS_MIGRASI
                (
                  ACC_GROUP      VARCHAR2(50 BYTE)              NOT NULL,
                  ACC_SUBGROUP1  VARCHAR2(50 BYTE),
                  ACC_SUBGROUP2  VARCHAR2(50 BYTE),
                  ACC_SUBGROUP3  VARCHAR2(50 BYTE),
                  ACC_NAME       VARCHAR2(75 BYTE)              NOT NULL,
                  ACC_LEVEL      NUMBER(1)                      NOT NULL,
                  ACC_URL        VARCHAR2(255 BYTE)             NOT NULL,
                  ACC_ID         VARCHAR2(10 BYTE),
                  ACC_CREATE_BY  VARCHAR2(3 BYTE),
                  ACC_CREATE_DT  DATE,
                  ACC_MODIFY_BY  VARCHAR2(3 BYTE),
                  ACC_MODIFY_DT  DATE,
                  ACC_STATUS     CHAR(1 BYTE),
                  ACC_ORDER      NUMBER
                )");
            }
            else{
                return 'Table TBMASTER_ACCESS_MIGRASI : EXISTS!';
            }

            $access = DB::connection('igrsmg')
                ->table('tbmaster_access_migrasi')
                ->get();

            $access = json_decode(json_encode($access),true);

            DB::connection($connection)
                ->table('tbmaster_access_migrasi')
                ->delete();

            foreach($access as $a){
                $a['acc_create_by'] = Session::get('usid');
                $a['acc_create_dt'] = Carbon::now();
                $a['acc_modify_by'] = null;
                $a['acc_modify_dt'] = null;

                DB::connection($connection)
                    ->table('tbmaster_access_migrasi')
                    ->insert($a);
            }

            return 'Table TBMASTER_ACCESS_MIGRASI : OK!';
        }
        catch (\Exception $e){
            return $e->getMessage();
        }
    }

    static function createTableUserAccess($connection){
        try{
            $exist = Schema::connection($connection)->hasTable('tbmaster_useraccess_migrasi');

            if(!$exist) {
                DB::connection($connection)
                    ->statement("CREATE TABLE TBMASTER_USERACCESS_MIGRASI
                    (
                      UAC_USERID     VARCHAR2(3 BYTE),
                      UAC_ACC_ID     VARCHAR2(10 BYTE),
                      UAC_CREATE     VARCHAR2(1 BYTE),
                      UAC_READ       VARCHAR2(1 BYTE),
                      UAC_UPDATE     VARCHAR2(1 BYTE),
                      UAC_DELETE     VARCHAR2(1 BYTE),
                      UAC_CREATE_BY  VARCHAR2(3 BYTE),
                      UAC_CREATE_DT  DATE,
                      UAC_MODIFY_BY  VARCHAR2(3 BYTE),
                      UAC_MODIFY_DT  DATE
                    )");

                return 'Table TBMASTER_USERACCESS_MIGRASI : OK!';
            }
            else{
                return 'Table TBMASTER_USERACCESS_MIGRASI : EXISTS!';
            }
        }
        catch (\Exception $e){
            return $e->getMessage();
        }
    }

    static function createTableLog($connection){
        try{
            $exist = Schema::connection($connection)->hasTable('tblog_laravel_ias');

            if($exist){
                DB::connection($connection)
                    ->statement("DROP TABLE TBLOG_LARAVEL_IAS CASCADE CONSTRAINTS");
            }

            DB::connection($connection)
                ->statement("CREATE TABLE TBLOG_LARAVEL_IAS
                    (
                      MENU        VARCHAR2(50 BYTE),
                      SUBMENU     VARCHAR2(50 BYTE),
                      START_TIME  DATE,
                      END_TIME    DATE,
                      STATUS      VARCHAR2(20 BYTE),
                      MESSAGE     VARCHAR2(100 BYTE)
                    )");

//            DB::connection($connection)
//                ->statement("TABLESPACE RESULT_CACHE (MODE DEFAULT)
//                    PCTUSED    0
//                    PCTFREE    10
//                    INITRANS   1
//                    MAXTRANS   255
//                    STORAGE    (
//                                INITIAL          64K
//                                NEXT             1M
//                                MAXSIZE          UNLIMITED
//                                MINEXTENTS       1
//                                MAXEXTENTS       UNLIMITED
//                                PCTINCREASE      0
//                                BUFFER_POOL      DEFAULT
//                                FLASH_CACHE      DEFAULT
//                                CELL_FLASH_CACHE DEFAULT
//                               )
//                    LOGGING
//                    NOCOMPRESS
//                    NOCACHE
//                    NOPARALLEL
//                    MONITORING");

//            DB::connection($connection)
//                ->statement("CREATE INDEX IDX_TBLOG_LARAVEL_IAS ON TBLOG_LARAVEL_IAS
//                    (MENU, SUBMENU)
//                    LOGGING
//                    TABLESPACE PCTFREE    10
//                    INITRANS   2
//                    MAXTRANS   255
//                    STORAGE    (
//                                INITIAL          64K
//                                NEXT             1M
//                                MAXSIZE          UNLIMITED
//                                MINEXTENTS       1
//                                MAXEXTENTS       UNLIMITED
//                                PCTINCREASE      0
//                                BUFFER_POOL      DEFAULT
//                                FLASH_CACHE      DEFAULT
//                                CELL_FLASH_CACHE DEFAULT
//                               )
//                    NOPARALLEL");

            return 'Table TBLOG_LARAVEL_IAS : OK!';
        }
        catch (\Exception $e){
            return $e->getMessage();
        }
    }
}
