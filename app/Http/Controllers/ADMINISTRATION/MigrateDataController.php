<?php

namespace App\Http\Controllers\ADMINISTRATION;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class MigrateDataController extends Controller
{

    public function __construct()
    {
        $this->listCabang = (new loginController())->listCabang;
    }

    public function index()
    {
        return view('ADMINISTRATION.migrate-data')->with([
            'cabang' => $this->listCabang
        ]);
    }

    public function migrate(Request $request)
    {
        foreach ($this->listCabang as $c) {
            if ($c->kodeigr == $request->kodeigr) {
                $cabang = $c;
            }
        }
        $connection = [];
        $connection[] = 'sim' . $cabang->kode;
        $connection[] = 'igr' . $cabang->kode;

        $message = [];
        foreach ($connection as $con) {
            try {

                DB::connection($con)->beginTransaction();


                $message[] = self::createTableAccess($con);
                $message[] = self::createTableUserAccess($con);
                $message[] = self::createTableLog($con);
                $message[] = self::createTableTBTR_BA_CMO($con);
                $message[] = self::insertUser($con);
                $message[] = self::createTableTBMASTER_MONITORINGPLUEIS($con);

                DB::connection($con)->commit();

                $message[] = 'Data berhasil dikirim ke cabang ' . strtoupper($cabang->namacabang) . '!';
            } catch (\Exception $e) {
                DB::connection($con)->rollBack();

                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        }
        return response()->json($message, 200);
    }

    static function insertUser($connection)
    {
        try {
            DB::connection($connection)
                ->table('tbmaster_user')
                ->where('userid', 'like', 'DV%')
                ->delete();

            $user = DB::connection('igrsmg')
                ->table('tbmaster_user')
                ->where('userid', 'like', 'DV%')
                ->get();

            foreach ($user as $u) {
                DB::connection($connection)
                    ->table('tbmaster_user')
                    ->insert(json_decode(json_encode($u), true));
            }

            return 'Insert User : OK!';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    static function createTableAccess($connection)
    {
        try {
            $exist = Schema::connection($connection)->hasTable('tbmaster_access_migrasi');

            if (!$exist) {
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
            } else {
                return 'Table TBMASTER_ACCESS_MIGRASI : EXISTS!';
            }

            $access = DB::connection('igrsmg')
                ->table('tbmaster_access_migrasi')
                ->get();

            $access = json_decode(json_encode($access), true);

            DB::connection($connection)
                ->table('tbmaster_access_migrasi')
                ->delete();

            foreach ($access as $a) {
                $a['acc_create_by'] = Session::get('usid');
                $a['acc_create_dt'] = Carbon::now();
                $a['acc_modify_by'] = null;
                $a['acc_modify_dt'] = null;

                DB::connection($connection)
                    ->table('tbmaster_access_migrasi')
                    ->insert($a);
            }

            return 'Table TBMASTER_ACCESS_MIGRASI : OK!';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    static function createTableUserAccess($connection)
    {
        try {
            $exist = Schema::connection($connection)->hasTable('tbmaster_useraccess_migrasi');

            if (!$exist) {
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
            } else {
                return 'Table TBMASTER_USERACCESS_MIGRASI : EXISTS!';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    static function createTableTBTR_BA_CMO($connection)
    {
        try {
            $exist = Schema::connection($connection)->hasTable('tbtr_ba_cmo');

            if (!$exist) {
                DB::connection($connection)
                    ->statement("CREATE TABLE TBTR_BA_CMO
                                (
                                BAC_KODEIGR      VARCHAR2(2 BYTE),
                                BAC_RECORDID     CHAR(1 BYTE),
                                BAC_NOBA         VARCHAR2(10 BYTE),
                                BAC_TGLBA        DATE,
                                BAC_KETERANGAN   VARCHAR2(100 BYTE),
                                BAC_PRDCD        VARCHAR2(7 BYTE),
                                BAC_QTY_STOCK    NUMBER,
                                BAC_QTY_BA       NUMBER,
                                BAC_TGLADJ       DATE,
                                BAC_QTY_ADJ      NUMBER,
                                BAC_QTY_SELISIH  NUMBER,
                                BAC_CREATE_BY    VARCHAR2(3 BYTE),
                                BAC_CREATE_DT    DATE,
                                BAC_MODIFY_BY    VARCHAR2(3 BYTE),
                                BAC_MODIFY_DT    DATE
                                )");

                return 'Table TBTR_BA_CMO : OK!';
            } else {
                return 'Table TBTR_BA_CMO : EXISTS!';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    static function createTableLog($connection)
    {
        try {
            $exist = Schema::connection($connection)->hasTable('tblog_laravel_ias');

            if (!$exist) {
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

                return 'Table TBLOG_LARAVEL_IAS : OK!';
            } else return 'Table TBLOG_LARAVEL_IAS : EXISTS!';


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    static function createTableTBMASTER_MONITORINGPLUEIS($connection)
    {
        try {
            $exist = Schema::connection($connection)->hasTable('TBMASTER_MONITORINGPLUEIS');

            if (!$exist) {
                DB::connection($connection)
                    ->statement("CREATE TABLE TBMASTER_MONITORINGPLUEIS
                        (
                          MTR_RECORD_ID   VARCHAR2(5 BYTE),
                          MTR_KODEMTR     VARCHAR2(10 BYTE),
                          MTR_NAMAMTR     VARCHAR2(30 BYTE),
                          MTR_PRDCD       VARCHAR2(8 BYTE),
                          MTR_DESKRIPSI   VARCHAR2(100 BYTE),
                          MTR_KETERANGAN  VARCHAR2(50 BYTE),
                          MTR_CREATE_BY   VARCHAR2(10 BYTE),
                          MTR_CREATE_DT   DATE,
                          MTR_UPDATE_BY   VARCHAR2(10 BYTE),
                          MTR_UPDATE_DT   DATE
                        )");

                return 'Table TBMASTER_MONITORINGPLUEIS : OK!';
            } else {
                return 'Table TBMASTER_MONITORINGPLUEIS : EXISTS!';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
