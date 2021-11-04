<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/12/2021
 * Time: 3:25 PM
 */

namespace App\Http\Controllers\BACKOFFICE\LAPORAN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;

class KunjunganBKLController extends Controller
{

    public function index()
    {
        return view('BACKOFFICE.LAPORAN.KunjunganBKL');
    }
    public function CheckData(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $date = $request->date;
        $theDate = DateTime::createFromFormat('m-Y', $date)->format('m-Y');
        $parameter_hari = '';

        $p_hari = DB::connection($_SESSION['connection'])->select("SELECT     LEVEL,
                    CASE
                        WHEN (TRIM
                                  (TO_CHAR
                                       (TO_DATE
                                            (   TO_CHAR (LEVEL, '09')
                                             || TO_CHAR (EXTRACT (MONTH FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '09'
                                                        )
                                             || TO_CHAR (EXTRACT (YEAR FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '9999'
                                                        ),
                                             'dd.mm.yyyy'
                                            ),
                                        'DAY'
                                       )
                                  )
                             ) = 'MONDAY'
                            THEN 'Sn'
                        ELSE CASE
                        WHEN (TRIM
                                  (TO_CHAR
                                       (TO_DATE
                                            (   TO_CHAR (LEVEL, '09')
                                             || TO_CHAR (EXTRACT (MONTH FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '09'
                                                        )
                                             || TO_CHAR (EXTRACT (YEAR FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '9999'
                                                        ),
                                             'dd.mm.yyyy'
                                            ),
                                        'DAY'
                                       )
                                  )
                             ) = 'TUESDAY'
                            THEN 'Sl'
                        ELSE CASE
                        WHEN (TRIM
                                  (TO_CHAR
                                       (TO_DATE
                                            (   TO_CHAR (LEVEL, '09')
                                             || TO_CHAR (EXTRACT (MONTH FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '09'
                                                        )
                                             || TO_CHAR (EXTRACT (YEAR FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '9999'
                                                        ),
                                             'dd.mm.yyyy'
                                            ),
                                        'DAY'
                                       )
                                  )
                             ) = 'WEDNESDAY'
                            THEN 'Rb'
                        ELSE CASE
                        WHEN (TRIM
                                  (TO_CHAR
                                       (TO_DATE
                                            (   TO_CHAR (LEVEL, '09')
                                             || TO_CHAR (EXTRACT (MONTH FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '09'
                                                        )
                                             || TO_CHAR (EXTRACT (YEAR FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '9999'
                                                        ),
                                             'dd.mm.yyyy'
                                            ),
                                        'DAY'
                                       )
                                  )
                             ) = 'THURSDAY'
                            THEN 'Km'
                        ELSE CASE
                        WHEN (TRIM
                                  (TO_CHAR
                                       (TO_DATE
                                            (   TO_CHAR (LEVEL, '09')
                                             || TO_CHAR (EXTRACT (MONTH FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '09'
                                                        )
                                             || TO_CHAR (EXTRACT (YEAR FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '9999'
                                                        ),
                                             'dd.mm.yyyy'
                                            ),
                                        'DAY'
                                       )
                                  )
                             ) = 'FRIDAY'
                            THEN 'Jm'
                        ELSE CASE
                        WHEN (TRIM
                                  (TO_CHAR
                                       (TO_DATE
                                            (   TO_CHAR (LEVEL, '09')
                                             || TO_CHAR (EXTRACT (MONTH FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '09'
                                                        )
                                             || TO_CHAR (EXTRACT (YEAR FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '9999'
                                                        ),
                                             'dd.mm.yyyy'
                                            ),
                                        'DAY'
                                       )
                                  )
                             ) = 'SATURDAY'
                            THEN 'Sb'
                        ELSE 'Mg'
                    END
                    END
                    END
                    END
                    END
                    END HARI
               FROM dual
              WHERE ROWNUM <= EXTRACT (DAY FROM LAST_DAY (TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )))
         CONNECT BY LEVEL = ROWNUM");
        //dd($p_hari);
        for($i=0;$i<sizeof($p_hari);$i++){
            $parameter_hari = $parameter_hari.TRIM($p_hari[$i]->hari).'  ';
        }

        $cursor = DB::connection($_SESSION['connection'])->select("SELECT hasil2.*,  (((nilai1 + nilai2 + nilai3 + nilai4 + nilai5 + nilai6 + nilai7) / dtg) * 100) sskunj,
(nilai1 + nilai2 + nilai3 + nilai4 + nilai5 + nilai6 + nilai7) jml, (hari1 + hari2 + hari3 + hari4 + hari5 + hari6 + hari7) haridtg,
(((nilai1 + nilai2 + nilai3 + nilai4 + nilai5 + nilai6 + nilai7) / (hari1 + hari2 + hari3 + hari4 + hari5 + hari6 + hari7)) * 100) ssdtg FROM (
SELECT hasil.*, CASE WHEN minggu = 'Y' THEN (LENGTH(REPLACE(hari, ',')) - nvl(LENGTH(REPLACE(REPLACE(hari, ','), 'su')),0)) / 2 ELSE 0 END nilai1,
CASE WHEN senin = 'Y' THEN (LENGTH(REPLACE(hari, ',')) - nvl(LENGTH(REPLACE(REPLACE(hari, ','), 'mo')),0)) / 2  ELSE 0 END nilai2,
CASE WHEN selasa = 'Y' THEN (LENGTH(REPLACE(hari, ',')) - nvl(LENGTH(REPLACE(REPLACE(hari, ','), 'tu')),0)) / 2  ELSE 0 END nilai3,
CASE WHEN rabu = 'Y' THEN (LENGTH(REPLACE(hari, ',')) - nvl(LENGTH(REPLACE(REPLACE(hari, ','), 'we')),0)) / 2  ELSE 0 END nilai4,
CASE WHEN kamis = 'Y' THEN (LENGTH(REPLACE(hari, ',')) - nvl(LENGTH(REPLACE(REPLACE(hari, ','), 'th')),0)) / 2  ELSE 0 END nilai5,
CASE WHEN jumat = 'Y' THEN (LENGTH(REPLACE(hari, ',')) - nvl(LENGTH(REPLACE(REPLACE(hari, ','), 'fr')),0)) / 2  ELSE 0 END nilai6,
CASE WHEN sabtu = 'Y' THEN (LENGTH(REPLACE(hari, ',')) - nvl(LENGTH(REPLACE(REPLACE(hari, ','), 'sa')),0)) / 2  ELSE 0 END nilai7,
CASE WHEN senin = 'Y' THEN (LENGTH(REPLACE('$parameter_hari', '  ')) - LENGTH(REPLACE(REPLACE('$parameter_hari', '  '), 'Sn'))) / 2 ELSE 0 END hari1,
CASE WHEN selasa = 'Y' THEN (LENGTH(REPLACE('$parameter_hari', '  ')) - LENGTH(REPLACE(REPLACE('$parameter_hari', '  '), 'Sl'))) / 2 ELSE 0 END hari2,
CASE WHEN rabu = 'Y' THEN (LENGTH(REPLACE('$parameter_hari', '  ')) - LENGTH(REPLACE(REPLACE('$parameter_hari', '  '), 'Rb'))) / 2 ELSE 0 END hari3,
CASE WHEN kamis = 'Y' THEN (LENGTH(REPLACE('$parameter_hari', '  ')) - LENGTH(REPLACE(REPLACE('$parameter_hari', '  '), 'Km'))) / 2 ELSE 0 END hari4,
CASE WHEN jumat = 'Y' THEN (LENGTH(REPLACE('$parameter_hari', '  ')) - LENGTH(REPLACE(REPLACE('$parameter_hari', '  '), 'Jm'))) / 2 ELSE 0 END hari5,
CASE WHEN sabtu = 'Y' THEN (LENGTH(REPLACE('$parameter_hari', '  ')) - LENGTH(REPLACE(REPLACE('$parameter_hari', '  '), 'Sb'))) / 2 ELSE 0 END hari6,
CASE WHEN minggu = 'Y' THEN (LENGTH(REPLACE('$parameter_hari', '  ')) - LENGTH(REPLACE(REPLACE('$parameter_hari', '  '), 'Mg'))) / 2 ELSE 0 END hari7 FROM (
SELECT DISTINCT prs_namaperusahaan, prs_namacabang, mstd_kodesupplier, sup_namasupplier,
CASE WHEN SUBSTR(sup_harikunjungan,1,1) = 'Y' THEN 'Y' ELSE ' ' END minggu,
CASE WHEN SUBSTR(sup_harikunjungan,2,1) = 'Y' THEN 'Y' ELSE ' ' END senin,
CASE WHEN SUBSTR(sup_harikunjungan,3,1) = 'Y' THEN 'Y' ELSE ' ' END selasa,
CASE WHEN SUBSTR(sup_harikunjungan,4,1) = 'Y' THEN 'Y' ELSE ' ' END rabu,
CASE WHEN SUBSTR(sup_harikunjungan,5,1) = 'Y' THEN 'Y' ELSE ' ' END kamis,
CASE WHEN SUBSTR(sup_harikunjungan,6,1) = 'Y' THEN 'Y' ELSE ' ' END jumat,
CASE WHEN SUBSTR(sup_harikunjungan,7,1) = 'Y' THEN 'Y' ELSE ' ' END sabtu,
sup_top, sup_leadtime, sup_jangkawaktukirimbarang,
tgl,  (LENGTH(tgl) - LENGTH(REPLACE(tgl, ','))) + 1 dtg, hari
FROM TBMASTER_PERUSAHAAN, TBTR_MSTRAN_D, TBMASTER_SUPPLIER, TBMASTER_PRODMAST,
(SELECT mstd_kodesupplier supp, listagg(tgl,',') WITHIN GROUP (ORDER BY ROWNUM) AS tgl FROM (
SELECT DISTINCT mstd_kodesupplier, TO_CHAR(mstd_tgldoc, 'dd') tgl
FROM TBTR_MSTRAN_D
WHERE TO_CHAR(mstd_tgldoc, 'yyyyMM') = TO_CHAR(TO_DATE('$theDate','MM-YYYY'), 'yyyyMM')
AND mstd_typetrn = 'B'  AND MSTD_CREATE_BY <> 'BKL' and nvl(mstd_recordid, '0') <> '1'
ORDER BY mstd_kodesupplier, tgl ) b
GROUP BY mstd_kodesupplier ) c,
(
SELECT mstd_kodesupplier supp1, listagg(hari,',') WITHIN GROUP (ORDER BY ROWNUM) AS hari FROM (
SELECT mstd_kodesupplier, SUBSTR(TO_CHAR(mstd_tgldoc, 'day'),1 ,2) hari
FROM (SELECT DISTINCT mstd_kodesupplier, TRUNC(mstd_tgldoc) mstd_tgldoc FROM TBTR_MSTRAN_D
WHERE TO_CHAR(mstd_tgldoc, 'yyyyMM') = TO_CHAR(TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') AND mstd_typetrn = 'B'  AND MSTD_CREATE_BY <> 'BKL' and nvl(mstd_recordid, '0') <> '1'
ORDER BY mstd_kodesupplier, mstd_tgldoc) aa ) d
GROUP BY mstd_kodesupplier ) e
WHERE prs_kodeigr = '$kodeigr' AND TO_CHAR(mstd_tgldoc, 'yyyyMM') = TO_CHAR(TO_DATE('$theDate','MM-YYYY'), 'yyyyMM')
AND sup_kodesupplier = mstd_kodesupplier
AND prd_prdcd = mstd_prdcd AND NVL(prd_flagbarangordertoko, 'N') = 'Y'
AND supp = mstd_kodesupplier
AND supp1 = supp
ORDER BY mstd_kodesupplier ) hasil
) hasil2");

        if(sizeof($cursor)>0){
            return response()->json(['kode' => 1]);
        }else{
            return response()->json(['kode' => 0]);
        }
    }

    public function printDocument(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $date = $request->date;
        $today = date('d-m-Y');
        $theDate = DateTime::createFromFormat('m-Y', $date)->format('m-Y');
        $periode = DateTime::createFromFormat('m-Y', $date)->format('m-Y');
        $parameter_hari = '';

        $p_hari = DB::connection($_SESSION['connection'])->select("SELECT     LEVEL,
                    CASE
                        WHEN (TRIM
                                  (TO_CHAR
                                       (TO_DATE
                                            (   TO_CHAR (LEVEL, '09')
                                             || TO_CHAR (EXTRACT (MONTH FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '09'
                                                        )
                                             || TO_CHAR (EXTRACT (YEAR FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '9999'
                                                        ),
                                             'dd.mm.yyyy'
                                            ),
                                        'DAY'
                                       )
                                  )
                             ) = 'MONDAY'
                            THEN 'Sn'
                        ELSE CASE
                        WHEN (TRIM
                                  (TO_CHAR
                                       (TO_DATE
                                            (   TO_CHAR (LEVEL, '09')
                                             || TO_CHAR (EXTRACT (MONTH FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '09'
                                                        )
                                             || TO_CHAR (EXTRACT (YEAR FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '9999'
                                                        ),
                                             'dd.mm.yyyy'
                                            ),
                                        'DAY'
                                       )
                                  )
                             ) = 'TUESDAY'
                            THEN 'Sl'
                        ELSE CASE
                        WHEN (TRIM
                                  (TO_CHAR
                                       (TO_DATE
                                            (   TO_CHAR (LEVEL, '09')
                                             || TO_CHAR (EXTRACT (MONTH FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '09'
                                                        )
                                             || TO_CHAR (EXTRACT (YEAR FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '9999'
                                                        ),
                                             'dd.mm.yyyy'
                                            ),
                                        'DAY'
                                       )
                                  )
                             ) = 'WEDNESDAY'
                            THEN 'Rb'
                        ELSE CASE
                        WHEN (TRIM
                                  (TO_CHAR
                                       (TO_DATE
                                            (   TO_CHAR (LEVEL, '09')
                                             || TO_CHAR (EXTRACT (MONTH FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '09'
                                                        )
                                             || TO_CHAR (EXTRACT (YEAR FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '9999'
                                                        ),
                                             'dd.mm.yyyy'
                                            ),
                                        'DAY'
                                       )
                                  )
                             ) = 'THURSDAY'
                            THEN 'Km'
                        ELSE CASE
                        WHEN (TRIM
                                  (TO_CHAR
                                       (TO_DATE
                                            (   TO_CHAR (LEVEL, '09')
                                             || TO_CHAR (EXTRACT (MONTH FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '09'
                                                        )
                                             || TO_CHAR (EXTRACT (YEAR FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '9999'
                                                        ),
                                             'dd.mm.yyyy'
                                            ),
                                        'DAY'
                                       )
                                  )
                             ) = 'FRIDAY'
                            THEN 'Jm'
                        ELSE CASE
                        WHEN (TRIM
                                  (TO_CHAR
                                       (TO_DATE
                                            (   TO_CHAR (LEVEL, '09')
                                             || TO_CHAR (EXTRACT (MONTH FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '09'
                                                        )
                                             || TO_CHAR (EXTRACT (YEAR FROM TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )
                                                                 ),
                                                         '9999'
                                                        ),
                                             'dd.mm.yyyy'
                                            ),
                                        'DAY'
                                       )
                                  )
                             ) = 'SATURDAY'
                            THEN 'Sb'
                        ELSE 'Mg'
                    END
                    END
                    END
                    END
                    END
                    END HARI
               FROM dual
              WHERE ROWNUM <= EXTRACT (DAY FROM LAST_DAY (TO_DATE (TO_CHAR (TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') || '01',
                                                                                      'yyyyMMdd'
                                                                                     )))
         CONNECT BY LEVEL = ROWNUM");

        for($i=0;$i<sizeof($p_hari);$i++){
            $parameter_hari = $parameter_hari.TRIM($p_hari[$i]->hari).'  ';
        }

        $datas = DB::connection($_SESSION['connection'])->select("SELECT hasil2.*,  (((nilai1 + nilai2 + nilai3 + nilai4 + nilai5 + nilai6 + nilai7) / dtg) * 100) sskunj,
(nilai1 + nilai2 + nilai3 + nilai4 + nilai5 + nilai6 + nilai7) jml, (hari1 + hari2 + hari3 + hari4 + hari5 + hari6 + hari7) haridtg,
(((nilai1 + nilai2 + nilai3 + nilai4 + nilai5 + nilai6 + nilai7) / (hari1 + hari2 + hari3 + hari4 + hari5 + hari6 + hari7)) * 100) ssdtg FROM (
SELECT hasil.*, CASE WHEN minggu = 'Y' THEN (LENGTH(REPLACE(hari, ',')) - nvl(LENGTH(REPLACE(REPLACE(hari, ','), 'su')),0)) / 2 ELSE 0 END nilai1,
CASE WHEN senin = 'Y' THEN (LENGTH(REPLACE(hari, ',')) - nvl(LENGTH(REPLACE(REPLACE(hari, ','), 'mo')),0)) / 2  ELSE 0 END nilai2,
CASE WHEN selasa = 'Y' THEN (LENGTH(REPLACE(hari, ',')) - nvl(LENGTH(REPLACE(REPLACE(hari, ','), 'tu')),0)) / 2  ELSE 0 END nilai3,
CASE WHEN rabu = 'Y' THEN (LENGTH(REPLACE(hari, ',')) - nvl(LENGTH(REPLACE(REPLACE(hari, ','), 'we')),0)) / 2  ELSE 0 END nilai4,
CASE WHEN kamis = 'Y' THEN (LENGTH(REPLACE(hari, ',')) - nvl(LENGTH(REPLACE(REPLACE(hari, ','), 'th')),0)) / 2  ELSE 0 END nilai5,
CASE WHEN jumat = 'Y' THEN (LENGTH(REPLACE(hari, ',')) - nvl(LENGTH(REPLACE(REPLACE(hari, ','), 'fr')),0)) / 2  ELSE 0 END nilai6,
CASE WHEN sabtu = 'Y' THEN (LENGTH(REPLACE(hari, ',')) - nvl(LENGTH(REPLACE(REPLACE(hari, ','), 'sa')),0)) / 2  ELSE 0 END nilai7,
CASE WHEN senin = 'Y' THEN (LENGTH(REPLACE('$parameter_hari', '  ')) - LENGTH(REPLACE(REPLACE('$parameter_hari', '  '), 'Sn'))) / 2 ELSE 0 END hari1,
CASE WHEN selasa = 'Y' THEN (LENGTH(REPLACE('$parameter_hari', '  ')) - LENGTH(REPLACE(REPLACE('$parameter_hari', '  '), 'Sl'))) / 2 ELSE 0 END hari2,
CASE WHEN rabu = 'Y' THEN (LENGTH(REPLACE('$parameter_hari', '  ')) - LENGTH(REPLACE(REPLACE('$parameter_hari', '  '), 'Rb'))) / 2 ELSE 0 END hari3,
CASE WHEN kamis = 'Y' THEN (LENGTH(REPLACE('$parameter_hari', '  ')) - LENGTH(REPLACE(REPLACE('$parameter_hari', '  '), 'Km'))) / 2 ELSE 0 END hari4,
CASE WHEN jumat = 'Y' THEN (LENGTH(REPLACE('$parameter_hari', '  ')) - LENGTH(REPLACE(REPLACE('$parameter_hari', '  '), 'Jm'))) / 2 ELSE 0 END hari5,
CASE WHEN sabtu = 'Y' THEN (LENGTH(REPLACE('$parameter_hari', '  ')) - LENGTH(REPLACE(REPLACE('$parameter_hari', '  '), 'Sb'))) / 2 ELSE 0 END hari6,
CASE WHEN minggu = 'Y' THEN (LENGTH(REPLACE('$parameter_hari', '  ')) - LENGTH(REPLACE(REPLACE('$parameter_hari', '  '), 'Mg'))) / 2 ELSE 0 END hari7 FROM (
SELECT DISTINCT prs_namaperusahaan, prs_namacabang, mstd_kodesupplier, sup_namasupplier,
CASE WHEN SUBSTR(sup_harikunjungan,1,1) = 'Y' THEN 'Y' ELSE ' ' END minggu,
CASE WHEN SUBSTR(sup_harikunjungan,2,1) = 'Y' THEN 'Y' ELSE ' ' END senin,
CASE WHEN SUBSTR(sup_harikunjungan,3,1) = 'Y' THEN 'Y' ELSE ' ' END selasa,
CASE WHEN SUBSTR(sup_harikunjungan,4,1) = 'Y' THEN 'Y' ELSE ' ' END rabu,
CASE WHEN SUBSTR(sup_harikunjungan,5,1) = 'Y' THEN 'Y' ELSE ' ' END kamis,
CASE WHEN SUBSTR(sup_harikunjungan,6,1) = 'Y' THEN 'Y' ELSE ' ' END jumat,
CASE WHEN SUBSTR(sup_harikunjungan,7,1) = 'Y' THEN 'Y' ELSE ' ' END sabtu,
sup_top, sup_leadtime, sup_jangkawaktukirimbarang,
tgl,  (LENGTH(tgl) - LENGTH(REPLACE(tgl, ','))) + 1 dtg, hari
FROM TBMASTER_PERUSAHAAN, TBTR_MSTRAN_D, TBMASTER_SUPPLIER, TBMASTER_PRODMAST,
(SELECT mstd_kodesupplier supp, listagg(tgl,',') WITHIN GROUP (ORDER BY ROWNUM) AS tgl FROM (
SELECT DISTINCT mstd_kodesupplier, TO_CHAR(mstd_tgldoc, 'dd') tgl
FROM TBTR_MSTRAN_D
WHERE TO_CHAR(mstd_tgldoc, 'yyyyMM') = TO_CHAR(TO_DATE('$theDate','MM-YYYY'), 'yyyyMM')
AND mstd_typetrn = 'B'  AND MSTD_CREATE_BY <> 'BKL' and nvl(mstd_recordid, '0') <> '1'
ORDER BY mstd_kodesupplier, tgl ) b
GROUP BY mstd_kodesupplier ) c,
(
SELECT mstd_kodesupplier supp1, listagg(hari,',') WITHIN GROUP (ORDER BY ROWNUM) AS hari FROM (
SELECT mstd_kodesupplier, SUBSTR(TO_CHAR(mstd_tgldoc, 'day'),1 ,2) hari
FROM (SELECT DISTINCT mstd_kodesupplier, TRUNC(mstd_tgldoc) mstd_tgldoc FROM TBTR_MSTRAN_D
WHERE TO_CHAR(mstd_tgldoc, 'yyyyMM') = TO_CHAR(TO_DATE('$theDate','MM-YYYY'), 'yyyyMM') AND mstd_typetrn = 'B'  AND MSTD_CREATE_BY <> 'BKL' and nvl(mstd_recordid, '0') <> '1'
ORDER BY mstd_kodesupplier, mstd_tgldoc) aa ) d
GROUP BY mstd_kodesupplier ) e
WHERE prs_kodeigr = '$kodeigr' AND TO_CHAR(mstd_tgldoc, 'yyyyMM') = TO_CHAR(TO_DATE('$theDate','MM-YYYY'), 'yyyyMM')
AND sup_kodesupplier = mstd_kodesupplier
AND prd_prdcd = mstd_prdcd AND NVL(prd_flagbarangordertoko, 'N') = 'Y'
AND supp = mstd_kodesupplier
AND supp1 = supp
ORDER BY mstd_kodesupplier ) hasil
) hasil2");
        //PRINT
        $pdf = PDF::loadview('BACKOFFICE.LAPORAN.KunjunganBKL-pdf',
            ['kodeigr' => $kodeigr, 'date' => $periode, 'datas' => $datas,'hari' =>$p_hari ,'today' => $today]);
        $pdf->setPaper('A4', 'landscape');
        $pdf->output();
        $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

        $canvas = $dompdf ->get_canvas();
        $canvas->page_text(780, 24, "PAGE {PAGE_NUM} of {PAGE_COUNT}", null, 8, array(0, 0, 0));

        return $pdf->stream('KunjunganBKL.pdf');
    }
}
