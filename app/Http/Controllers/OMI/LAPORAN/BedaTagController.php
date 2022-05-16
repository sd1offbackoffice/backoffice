<?php


namespace App\Http\Controllers\OMI\LAPORAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Http\Controllers\Auth\loginController;

class BedaTagController extends Controller
{

    public function index()
    {
        return view('BACKOFFICE.bedatagomi');
    }

    public function getLovDivisi()
    {
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_divisi')
            ->selectRaw('div_namadivisi')
            ->selectRaw('trim(div_kodedivisi) div_kodedivisi')
            ->where('div_kodeigr', '=', $kodeigr)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovDepartemen()
    {
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_departement')
            ->selectRaw('dep_namadepartement')
            ->selectRaw('dep_kodedepartement')
            ->selectRaw('dep_kodedivisi')
            ->where('dep_kodeigr', '=', $kodeigr)
            ->orderByRaw("dep_kodedivisi, dep_kodedepartement")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function getLovKategori()
    {
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table('tbmaster_kategori')
            ->selectRaw('kat_namakategori')
            ->selectRaw('kat_kodekategori')
            ->selectRaw('kat_kodedepartement')
            ->where('kat_kodeigr', '=', $kodeigr)
            ->orderByRaw("kat_kodedepartement, kat_kodekategori")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function validateTag(Request $request){
        
        $errflag = 0;
        $kodeigr = Session::get('kdigr');
        $tag = $request->tag;

        $temp = DB::connection(Session::get('connection'))
        ->select("SELECT COUNT(1) AS temp
                    FROM tbmaster_tag
                    WHERE tag_kodetag = '$tag'");
        
        if($temp[0]->temp == 0){
            $errflag = 1;
            return response()->json(['temp' => $temp[0]->temp, 'message' => 'Kode Tag tidak terdaftar', 'errflag' => $errflag, 'status' => 'error']);
        }

        return response()->json(['temp' => $temp[0]->temp, 'message' => 'Kode Tag tidak terdaftar', 'errflag' => $errflag, 'status' => 'info']);
    }


    // ### FUNGSI-FUNGSI PRINT/CETAK ###
    public function printLaporan(Request $request)
    {
        $kodeigr = Session::get('kdigr');
        $div1 = $request->div1;
        if ($div1 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_divisi")
                ->selectRaw("min(div_kodedivisi) as result")
                ->where("div_kodeigr", '=', $kodeigr)
                ->first();
            $div1 = $temp->result;
        }
        $div2 = $request->div2;
        if ($div2 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_divisi")
                ->selectRaw("max(div_kodedivisi) as result")
                ->where("div_kodeigr", '=', $kodeigr)
                ->first();
            $div2 = $temp->result;
        }
        $dep1 = $request->dep1;
        if ($dep1 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("min(dep_kodedepartement) as result")
                ->where("dep_kodeigr", '=', $kodeigr)
                ->where("dep_kodedivisi", '=', $div1)
                ->first();
            $dep1 = $temp->result;
        }
        $dep2 = $request->dep2;
        if ($dep2 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_departement")
                ->selectRaw("max(dep_kodedepartement) as result")
                ->where("dep_kodeigr", '=', $kodeigr)
                ->where("dep_kodedivisi", '=', $div2)
                ->first();
            $dep2 = $temp->result;
        }
        $kat1 = $request->kat1;
        if ($kat1 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("min(kat_kodekategori) as result")
                ->where("kat_kodeigr", '=', $kodeigr)
                ->where("kat_kodedepartement", '=', $dep1)
                ->first();
            $kat1 = $temp->result;
        }
        $kat2 = $request->kat2;
        if ($kat2 == '') {
            $temp = DB::connection(Session::get('connection'))->table("tbmaster_kategori")
                ->selectRaw("max(kat_kodekategori) as result")
                ->where("kat_kodeigr", '=', $kodeigr)
                ->where("kat_kodedepartement", '=', $dep2)
                ->first();
            $kat2 = $temp->result;
        }
        // $ptag = $request->ptag;
        // $p_tagq = "";

        // if ($ptag != '') {
        //     $p_tagq = "and NVL(prd_kodetag,'b') in (" . $ptag . ")";
        // }
        // $produkbaru = $request->produkbaru;
        // $chp = $request->chp;

        $sort = $request->sort;
        $date = $request->date;
        $date = DateTime::createFromFormat('d-m-Y', $date)->format('d-M-Y');

        $tag = $request->tag;
        $wheretag = "";
        if ($tag != ''){
            $wheretag = " AND NVL(TRIM(PRD_KODETAG),'_') = '$tag' "; 
        }

        
        // if ((int)$produkbaru == 1) {
        //     $judul = "LAPORAN PERBEDAAN KODE TAG IGR-OMI";
        //     $temp = DB::connection(Session::get('connection'))->table("dual")
        //         ->selectRaw("nvl(TO_DATE('$date','DD-MON-YYYY'),sysdate)-91 as result")
        //         ->first();
        //     $tgla = $temp->result;
        //     $tgla = DateTime::createFromFormat('Y-m-d H:i:s', $tgla)->format('d-M-Y');
        //     $p_periodtgl = " and prd_tglaktif >= to_date('$tgla','dd-MON-yy') ";
        // } else {
            $judul = "LAPORAN PERBEDAAN KODE TAG IGR-OMI";
            // $p_periodtgl = $date;
        // }
        if ((int)$sort == 1) {
            $datas = DB::connection(Session::get('connection'))->select("SELECT TGL,
            PRS_NAMAPERUSAHAAN,
            PRS_NAMACABANG,
            PRD_PRDCD,
            PRC_PLUIGR,
            PRC_PLUOMI,
            PRD_DESKRIPSIPENDEK,
            divisi || ' - ' || departement || ' - ' || kategori DDK,
            PRD_SATUAN,
            PRD_FLAGOMI,
            PRD_KODETAG,
            PRC_KODETAG,
            TAG_IGR,
            TAG_OMI,
            LOKASI
    FROM (SELECT TO_CHAR (SYSDATE, 'dd MON yyyy hh24:mi:ss') TGL,
                    PRS_NAMAPERUSAHAAN,
                    PRS_NAMACABANG,
                    PRD_PRDCD,
                    PRC_PLUIGR,
                    PRC_PLUOMI,
                    PRD_DESKRIPSIPENDEK,
            div_kodedivisi || ' ' || div_namadivisi divisi,
            dep_kodedepartement || ' ' || dep_namadepartement DEPARTEMENT,
            kat_kodekategori || ' ' || kat_namakategori KATEGORI,
                    PRD_UNIT || '/' || PRD_FRAC PRD_SATUAN,
                    PRD_FLAGOMI,
                    PRD_KODETAG,
                    PRC_KODETAG,
                    CASE
                    WHEN NVL (REPLACE (prd_kodetag, ' ', '_'), '_') IN ('E',
                                                                        'D',
                                                                        'S',
                                                                        'L',
                                                                        'C',
                                                                        'Z',
                                                                        '_')
                    THEN
                        'TAG_AKTIF'
                    WHEN NVL (REPLACE (prd_kodetag, ' ', '_'), '_') IN ('H',
                                                                        'A',
                                                                        'N',
                                                                        'O',
                                                                        'X',
                                                                        'T',
                                                                        'Q',
                                                                        'U',
                                                                        'G',
                                                                        'B')
                    THEN
                        'TAG_NONAKTIF'
                    END
                    TAG_IGR,
                    CASE
                    WHEN NVL (REPLACE (prc_kodetag, ' ', '_'), '_') IN ('E',
                                                                        'D',
                                                                        'S',
                                                                        'L',
                                                                        '_')
                    THEN
                        'TAG_AKTIF'
                    WHEN NVL (REPLACE (prc_kodetag, ' ', '_'), '_') IN ('H',
                                                                        'N',
                                                                        'O',
                                                                        'X',
                                                                        'T')
                    THEN
                        'TAG_NONAKTIF'
                    END
                    TAG_OMI
            --select *
            FROM TBMASTER_PRODCRM,
                    TBMASTER_PRODMAST,
                    TBMASTER_PERUSAHAAN,
                    (SELECT div_kodedivisi,
                            div_namadivisi,
                            dep_kodedepartement,
                            dep_namadepartement,
                            kat_kodekategori,
                            kat_namakategori
                    FROM tbmaster_kategori,
                            tbmaster_departement,
                            tbmaster_divisi
                    WHERE     kat_kodedepartement = dep_kodedepartement
                            AND dep_kodedivisi = div_kodedivisi)
            --WHERE SUBSTR (prc_pluigr, 1, 6) = SUBSTR (PRD_PRDCD(+), 1, 6)
            WHERE     prc_pluigr = PRD_PRDCD--(+)
    AND PRD_FLAGOMI = 'Y'
                    AND prc_group ='O'
                    AND prd_kodedivisi = div_kodedivisi
                    AND prd_kodedepartement = dep_kodedepartement
                    AND prd_kodekategoribarang = kat_kodekategori
    AND div_kodedivisi between '$div1' and '$div2'
    AND dep_kodedepartement between '$dep1' and '$dep2'
    AND kat_kodekategori between '$kat1' and '$kat2'
                    ". $wheretag ."
            ),
            (SELECT lks_prdcd,
                    LKS_KODERAK
                    || '.'
                    || LKS_KODESUBRAK
                    || '.'
                    || LKS_TIPERAK
                    || '.'
                    || LKS_SHELVINGRAK
                    || '.'
                    || LKS_NOURUT
                    lokasi
            FROM tbmaster_lokasi
            WHERE lks_jenisrak IN ('D', 'N'))
    WHERE tag_igr <> tag_omi AND prd_prdcd = lks_prdcd --(+)
    --and rownum < 100
    ORDER BY NVL (TRIM (PRD_PRDCD), 'zzzzzzz'), PRC_PLUOMI, lokasi");
        } 
        else {
            $datas = DB::connection(Session::get('connection'))->select("SELECT TGL,
                   PRS_NAMAPERUSAHAAN,
                   PRS_NAMACABANG,
                   PRD_PRDCD,
                   PRC_PLUIGR,
                   PRC_PLUOMI,
                   PRD_DESKRIPSIPENDEK,
                   divisi || ' - ' || departement || ' - ' || kategori DDK,
                   PRD_SATUAN,
                   PRD_FLAGOMI,
                   PRD_KODETAG,
                   PRC_KODETAG,
                   TAG_IGR,
                   TAG_OMI,
                   LOKASI
              FROM (SELECT TO_CHAR (SYSDATE, 'dd MON yyyy hh24:mi:ss') TGL,
                           PRS_NAMAPERUSAHAAN,
                           PRS_NAMACABANG,
                           PRD_PRDCD,
                           PRC_PLUIGR,
                           PRC_PLUOMI,
                           PRD_DESKRIPSIPENDEK,
                   div_kodedivisi || ' ' || div_namadivisi divisi,
                   dep_kodedepartement || ' ' || dep_namadepartement DEPARTEMENT,
                   kat_kodekategori || ' ' || kat_namakategori KATEGORI,
                           PRD_UNIT || '/' || PRD_FRAC PRD_SATUAN,
                           PRD_FLAGOMI,
                           PRD_KODETAG,
                           PRC_KODETAG,
                           CASE
                              WHEN NVL (REPLACE (prd_kodetag, ' ', '_'), '_') IN ('E',
                                                                                  'D',
                                                                                  'S',
                                                                                  'L',
                                                                                  'C',
                                                                                  'Z',
                                                                                  '_')
                              THEN
                                 'TAG_AKTIF'
                              WHEN NVL (REPLACE (prd_kodetag, ' ', '_'), '_') IN ('H',
                                                                                  'A',
                                                                                  'N',
                                                                                  'O',
                                                                                  'X',
                                                                                  'T',
                                                                                  'Q',
                                                                                  'U',
                                                                                  'G',
                                                                                  'B')
                              THEN
                                 'TAG_NONAKTIF'
                           END
                              TAG_IGR,
                           CASE
                              WHEN NVL (REPLACE (prc_kodetag, ' ', '_'), '_') IN ('E',
                                                                                  'D',
                                                                                  'S',
                                                                                  'L',
                                                                                  '_')
                              THEN
                                 'TAG_AKTIF'
                              WHEN NVL (REPLACE (prc_kodetag, ' ', '_'), '_') IN ('H',
                                                                                  'N',
                                                                                  'O',
                                                                                  'X',
                                                                                  'T')
                              THEN
                                 'TAG_NONAKTIF'
                           END
                              TAG_OMI
                      --select *
                      FROM TBMASTER_PRODCRM,
                           TBMASTER_PRODMAST,
                           TBMASTER_PERUSAHAAN,
                           (SELECT div_kodedivisi,
                                   div_namadivisi,
                                   dep_kodedepartement,
                                   dep_namadepartement,
                                   kat_kodekategori,
                                   kat_namakategori
                              FROM tbmaster_kategori,
                                   tbmaster_departement,
                                   tbmaster_divisi
                             WHERE     kat_kodedepartement = dep_kodedepartement
                                   AND dep_kodedivisi = div_kodedivisi)
                     --WHERE SUBSTR (prc_pluigr, 1, 6) = SUBSTR (PRD_PRDCD(+), 1, 6)
                     WHERE     prc_pluigr = PRD_PRDCD--(+)
          AND PRD_FLAGOMI = 'Y'
                           AND prc_group ='O'
                           AND prd_kodedivisi = div_kodedivisi
                           AND prd_kodedepartement = dep_kodedepartement
                           AND prd_kodekategoribarang = kat_kodekategori
    AND div_kodedivisi between '$div1' and '$div2'
    AND dep_kodedepartement between '$dep1' and '$dep2'
    AND kat_kodekategori between '$kat1' and '$kat2'
                           ". $wheretag ."
                   ),
                   (SELECT lks_prdcd,
                              LKS_KODERAK
                           || '.'
                           || LKS_KODESUBRAK
                           || '.'
                           || LKS_TIPERAK
                           || '.'
                           || LKS_SHELVINGRAK
                           || '.'
                           || LKS_NOURUT
                              lokasi
                      FROM tbmaster_lokasi
                     WHERE lks_jenisrak IN ('D', 'N'))
             WHERE tag_igr <> tag_omi AND prd_prdcd = lks_prdcd --(+)
          --and rownum < 100
          ORDER BY NVL (TRIM (PRD_PRDCD), 'zzzzzzz'), PRC_PLUOMI, lokasi");
        }


        //PRINT
        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();
        // if ((int)$sort < 3) {
            //CETAK_DAFTARPRODUK (IGR_BO_DAFTARPRODUK.jsp)
            // dd($datas);

            $tanggal = sizeof($datas) > 0 ? $datas[0]->tgl : '';
            return view('BACKOFFICE.bedatagomi-pdf',
                ['kodeigr' => $kodeigr, 'data' => $datas, 'tanggal' => $tanggal, 'perusahaan' => $perusahaan,
                    'judul' => $judul
                    ]);
        // } else {
        //     //CETAK_DAFTARPRDNAMA (IGR_BO_DAFTARPRDNM.jsp)
        //     return view('BACKOFFICE.LISTMASTERASSET.LAPORAN.daftar-produk-nama-pdf',
        //         ['kodeigr' => $kodeigr, 'data' => $datas, 'perusahaan' => $perusahaan,
        //             'judul' => $judul, 'p_hpp' => $chp,
        //             'cf_nmargin' => $cf_nmargin]);
        // }
    }

}
