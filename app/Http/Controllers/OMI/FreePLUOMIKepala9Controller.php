<?php

namespace App\Http\Controllers\OMI;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;
use File;

class FreePLUOMIKepala9Controller extends Controller
{
    public function index()
    {
        return view('OMI.freepluomikepala9');
    }

    public function getLovPLU(Request $request)
    {
        $where = "rom_nodokumen like '%" . $request->search . "%'";

        $data = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->selectRaw("prd_deskripsipanjang Deskripsi, prd_prdcd PLU ")
            ->whereRaw("substr(prd_prdcd,7,1)='0'")
            ->whereRaw("nvl(prd_kodetag,'_') not in ('N','H','X')")
            ->WhereRaw("prd_prdcd like '%" . $request->search . "%'")
            ->orderBy('prd_deskripsipanjang', 'asc')
            ->limit($request->search == '' ? 100 : 0)
            ->get();

        return DataTables::of($data)->make(true);
    }

    public function getDataInput(Request $request)
    {
        $plu = $request->plu;
        $data = DB::connection(Session::get('connection'))->select("SELECT fpl_freepluomi, NVL (BRG_MERK, ' ') BRG_MERK, NVL (BRG_NAMA, ' ') BRG_NAMA,
		       NVL (BRG_FLAVOR, ' ') BRG_FLAVOR, NVL (BRG_KEMASAN, ' ') BRG_KEMASAN,
		       NVL (BRG_UKURAN, ' ') BRG_UKURAN,
		       NVL (PRD_KODEDIVISI, ' ') || ' - ' || NVL (DIV_NAMADIVISI, ' ') divisi,
		       NVL (PRD_KODEDEPARTEMENT, ' ') || ' - ' || NVL (DEP_NAMADEPARTEMENT, ' ') departemen,
		       NVL (PRD_KODEKATEGORIBARANG, ' ') || ' - ' || NVL (KAT_NAMAKATEGORI, ' ') kategori,
		       NVL (PRD_BARCODE, ' ') PRD_BARCODE,
		       CASE
		           WHEN NVL (PRD_FLAGBKP1, 'x') || NVL (PRD_FLAGBKP2, 'x') = 'YY'
		               THEN 'BKP'
		           WHEN NVL (PRD_FLAGBKP1, 'x') || NVL (PRD_FLAGBKP2, 'x') = 'xN'
		               THEN 'Non BKP'
		           WHEN NVL (PRD_FLAGBKP1, 'x') || NVL (PRD_FLAGBKP2, 'x') = 'xC'
		               THEN 'Kena Cukai'
		       END STAT_BRG
		FROM   TBMASTER_freeplu,
		       TBMASTER_PRODMAST,
		       TBMASTER_BARANG,
		       TBMASTER_DIVISI,
		       TBMASTER_KATEGORI,
		       TBMASTER_DEPARTEMENT
		 WHERE fpl_PLUIGR (+) = PRD_PRDCD
		   AND Prd_prdcd = BRG_PRDCD(+)
		   AND PRD_KODEDIVISI = DIV_KODEDIVISI(+)
		   AND PRD_KODEDEPARTEMENT = DEP_KODEDEPARTEMENT(+)
		   AND PRD_KODEDEPARTEMENT = KAT_KODEDEPARTEMENT(+)
		   AND PRD_KODEKATEGORIBARANG = KAT_KODEKATEGORI(+)
		   AND prd_prdcd = '" . $plu . "'");

        $tempomi = DB::connection(Session::get('connection'))->select("select nvl(count(1),0) count
		from tbmaster_freeplu
		where fpl_pluigr = '" . $plu . "'")[0]->count;
        if ($tempomi == 0) {
            $data[0]->fpl_freepluomi = '9' . substr($plu, 1, 6);
        }
        return $data;
    }

    public function getDatatable()
    {
        $data = DB::connection(Session::get('connection'))->select("SELECT fpl_pluigr, fpl_freepluomi,
					 nvl(brg_merk,' ') brg_merk,
					 nvl(brg_nama,' ') brg_nama,
					 nvl(brg_flavor,' ') brg_flavor,
					 nvl(brg_kemasan,' ') brg_kemasan,
					 nvl(brg_ukuran,' ') brg_ukuran,
				   nvl(prd_kodedivisi,' ') prd_kodedivisi,
				   nvl(div_namadivisi,' ') div_namadivisi,
				   nvl(prd_kodedepartement,' ') prd_kodedepartement,
				   nvl(prd_kodekategoribarang,' ') prd_kodekategoribarang,
				   nvl(kat_namakategori,' ') kat_namakategori,
				   nvl(prd_barcode,' ') prd_barcode,
				   nvl(prd_flagbkp1,' ') prd_flagbkp1,
				   nvl(prd_flagbkp2,' ') prd_flagbkp2,
				   CASE WHEN NVL(prd_flagbkp1,'x')||NVL(prd_flagbkp2,'x') = 'YY' THEN 'BKP'
				   WHEN NVL(prd_flagbkp1,'x')||NVL(prd_flagbkp2,'x') = 'xN' THEN 'Non BKP'
				   WHEN NVL(prd_flagbkp1,'x')||NVL(prd_flagbkp2,'x') = 'xC' THEN 'Kena Cukai'
				   END stat_brg
			FROM TBMASTER_freeplu, TBMASTER_PRODMAST, tbmaster_barang, tbmaster_divisi, tbmaster_kategori
			WHERE fpl_pluigr = prd_prdcd (+)
			  AND fpl_pluigr = brg_prdcd (+)
			  AND prd_kodedivisi = div_kodedivisi (+)
			  AND prd_kodedepartement = kat_kodedepartement (+)
			  AND prd_kodekategoribarang = kat_kodekategori (+)
			  AND fpl_recordid is null"
        );

        return DataTables::of($data)->make(true);
    }

    public function simpan(Request $request)
    {
        $in_pluigr = $request->data['pluigr'];
        $in_pluomi = $request->data['pluomi'];
        $temp = DB::connection(Session::get('connection'))->select("SELECT COUNT (1) count
        FROM tbmaster_prodmast
       WHERE     prd_prdcd = SUBSTR ('" . $in_pluigr . "' , 1, 6) || '1'
        AND prd_kodetag IN ('N', 'H', 'X')")[0]->count;

        if ($temp > 0) {
            $message = 'Tag N / H / X ';
            $status = 'warning';
            return compact(['message', 'status']);
        }
        $tempigr = DB::connection(Session::get('connection'))->select("SELECT COUNT (1) count
        FROM tbmaster_prodmast
       WHERE     prd_prdcd = '" . $in_pluigr . "'")[0]->count;

        if ($tempigr != 0) {
            $temp_prodcrm = DB::connection(Session::get('connection'))->select("SELECT COUNT (1) count
        FROM tbmaster_prodmast
       WHERE     prd_prdcd = '" . $in_pluigr . "' AND prd_group = 'O'")[0]->count;

            if ($temp_prodcrm > 0) {
                $message = 'PLU sudah ada di Master_prodcrm..';
                $status = 'warning';
                return compact(['message', 'status']);
            }

            $temp_fpl = DB::connection(Session::get('connection'))->select("SELECT COUNT (1) count
                        FROM TBMASTER_FREEPLU
                       WHERE     FPL_PLUIGR = '" . $in_pluigr . "'")[0]->count;
            $temp_prc = DB::connection(Session::get('connection'))->select("SELECT COUNT (1) count
                            FROM TBMASTER_PRODCRM
                           WHERE     PRC_PLUIGR = '" . $in_pluigr . "' AND prc_group = 'F'")[0]->count;

            if ($temp_fpl != 0 && $temp_prc != 0) {
                $message = 'PLU sudah ada di Master_prodcrm..';
                $status = 'warning';
                return compact(['message', 'status']);
            } else {
                if ($temp_prc == 0) {
                    $v_minj = DB::connection(Session::get('connection'))->select("SELECT PRD_MINJUAL FROM TBMASTER_PRODMAST
                           WHERE     PRD_KODEIGR = '" . Session::get('kdigr') . "' AND PRD_prdcd = '" . $in_pluigr . "'")[0]->prd_minjual;

                    $temp = DB::connection(Session::get('connection'))->select("SELECT COUNT (1) count
                        FROM TBMASTER_PRODMAST
                     WHERE PRD_KODEIGR =  '" . Session::get('kdigr') . "'
                       AND PRD_PRDCD = SUBSTR ('" . $in_pluigr . "', 1, 6) || '1'")[0]->count;

                    $v_tag = null;
                    $v_frac = 0;
                    if ($temp > 0) {
                        $res = DB::connection(Session::get('connection'))->select("SELECT PRD_KODETAG, PRD_FRAC
                        FROM TBMASTER_PRODMAST
                     WHERE PRD_KODEIGR =  '" . Session::get('kdigr') . "'
                       AND PRD_PRDCD = SUBSTR ('" . $in_pluigr . "', 1, 6) || '1'")[0];
                        $v_tag = $res->prd_kodetag;
                        $v_frac = $res->prd_frac;
                    }

                    DB::connection(Session::get('connection'))->insert("INSERT INTO TBMASTER_PRODCRM
                                (PRC_KODEIGR, PRC_GROUP, PRC_PLUIGR,
                                 PRC_PLUOMI, PRC_CREATE_BY, PRC_CREATE_DT, PRC_MINORDER,
                                 PRC_HRGJUAL, PRC_PRICEB, PRC_PRICEK, PRC_PRICER, PRC_PRICEN,
                                 PRC_MARGINMARKUP, PRC_MAXORDEROMI, PRC_MINORDEROMI, PRC_KODETAG,
                                 PRC_SATUANRENCENG
                                )
                         VALUES ('" . Session::get('kdigr') . "', 'F', '" . $in_pluigr . "',
                                 SUBSTR ('" . $in_pluomi . "', 2, 6) || '0', '" . Session::get('usid') . "', SYSDATE, '" . $v_minj . "',
                                 0, 0, 0, 0, 0,
                                 0, 0, 0, '" . $v_tag . "',
                                 '" . $v_frac . "'
                                )");

                    if ($temp_fpl == 0) {
                        DB::connection(Session::get('connection'))->insert("INSERT INTO TBMASTER_FREEPLU
                                    (FPL_KODEIGR, FPL_PLUIGR, FPL_FREEPLUOMI, FPL_CREATE_BY,
                                     FPL_CREATE_DT)
                             VALUES ('" . Session::get('kdigr') . "', '" . $in_pluigr . "', '" . $in_pluomi . "', '" . Session::get('usid') . "',
                                     SYSDATE)");
                    } else {
                        DB::connection(Session::get('connection'))->update("UPDATE TBMASTER_FREEPLU
                           SET FPL_FREEPLUOMI = '" . $in_pluomi . "',
                               FPL_MODIFY_BY = '" . Session::get('usid') . "',
                               FPL_MODIFY_DT = SYSDATE,
                               FPL_RECORDID = NULL
                         WHERE FPL_PLUIGR = '" . $in_pluigr . "'");
                    }
                    $message = 'Data Berhasil ditambah.';
                    $status = 'success';
                    return compact(['message', 'status']);

                }
            }


        } else {
            $message = 'PLU tidak dtemukan dalam prodmast.';
            $status = 'warning';
            return compact(['message', 'status']);
        }
    }

    public function hapus(Request $request){
        $in_pluigr = $request->data['pluigr'];
        $in_pluomi = $request->data['pluomi'];
        $tempomi = DB::connection(Session::get('connection'))->select("SELECT NVL (COUNT (1), 0) count
                             FROM tbmaster_prodcrm
                            WHERE prc_pluigr ='" . $in_pluigr . "' and prc_group = 'F'")[0]->count;
        if($tempomi!=0){
            DB::connection(Session::get('connection'))->delete("DELETE FROM tbmaster_prodcrm
               WHERE prc_pluigr = '" . $in_pluigr . "'AND prc_group = 'F'");

            DB::connection(Session::get('connection'))->update("UPDATE tbmaster_freeplu
            SET fpl_freepluomi = '" . $in_pluomi . "',
                fpl_MODIFY_BY = '" . Session::get('usid') . "',
                fpl_MODIFY_DT = SYSDATE,
                fpl_recordid = '1'
          WHERE fpl_pluigr ='" . $in_pluigr . "'");

            $message = 'Data Berhasil dihapus';
            $status = 'success';
            return compact(['message', 'status']);
        }else{
            $message = 'PLU tidak terdaftar dalam freeplu';
            $status = 'warning';
            return compact(['message', 'status']);
        }
    }
}
