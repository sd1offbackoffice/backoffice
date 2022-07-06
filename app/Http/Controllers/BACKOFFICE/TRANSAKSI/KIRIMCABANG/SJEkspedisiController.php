<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\KIRIMCABANG;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class SJEkspedisiController extends Controller
{
	public function index()
	{
		return view('BACKOFFICE.TRANSAKSI.PENERIMAAN.SJEkspedisi');
	}

	public function getNewNoTrn()
	{
		$ip = Session::get('ip');

		$arrip = explode('.', $ip);

		$c = loginController::getConnectionProcedure();
		$s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMORSTADOC('" . Session::get('kdigr') . "','SJK','Nomor Surat Jalan'," . $arrip[3] . "||'3',6,FALSE); END;");
		oci_bind_by_name($s, ':ret', $no, 32);
		oci_execute($s);

		DB::connection(Session::get('connection'))->table('tbtr_tac')
			->where('tac_kodeigr', Session::get('kdigr'))
			->where('tac_nodoc', $no)
			->delete();

		return $no;
	}

	public function getDataLovTrn()
	{
		$lov = DB::connection(Session::get('connection'))->table('tbtr_backoffice')
			->selectRaw("TRBO_NODOC,TO_CHAR(TRBO_TGLDOC, 'DD/MM/YYYY') TRBO_TGLDOC,
                    CASE
                        WHEN TRBO_FLAGDOC='*' THEN TRBO_NONOTA
                        ELSE 'Belum Cetak Nota'
                    END NOTA")
			->where('trbo_typetrn', 'O')
			->orderBy('trbo_nodoc', 'desc')
			->distinct()
			->get();

		return DataTables::of($lov)->make(true);
	}

	public function getDataLovCabang()
	{
		$lov = DB::connection(Session::get('connection'))->table('tbmaster_cabang')
			->select('cab_kodecabang', 'cab_namacabang')
			->where('cab_kodeigr', Session::get('kdigr'))
			->orderBy('cab_kodecabang')
			->get();

		return DataTables::of($lov)->make(true);
	}

	public function getDataLovPlu()
	{
		$lov = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
			->selectRaw("PRD_PRDCD, PRD_UNIT||'/'||TO_CHAR(PRD_FRAC) SATUAN, PRD_DESKRIPSIPANJANG")
			->where('prd_kodeigr', Session::get('kdigr'))
			->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
			->whereRaw("nvl(prd_recordid,9)<>1")
			->orderBy('prd_prdcd')
			->limit(200)
			->get();

		return DataTables::of($lov)->make(true);
	}

	public function getDataLovIpb()
	{
		$kodeigr = Session::get('kdigr');
		$lov = DB::connection(Session::get('connection'))->select("SELECT DISTINCT
                IPB_NOIPB,IPB_TGLIPB,IPB_KODECABANG2,CAB_NAMACABANG
                FROM TBTR_IPB,TBMASTER_CABANG
                WHERE IPB_KODECABANG2 = CAB_KODECABANG 
				AND CAB_KODEIGR = '$kodeigr'
				AND IPB_KODEIGR = '$kodeigr' 
				AND IPB_KODECABANG1 = '$kodeigr'
				AND (NVL(IPB_RECORDID,' ') = ' ' OR IPB_RECORDID IS NULL)
                ORDER BY IPB_NOIPB");

		return DataTables::of($lov)->make(true);
	}
}
