<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ART;
use App\Models\CLI;
use App\Models\ARTBYRERF;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ARTController extends Controller
{
    public function GetByFamCli(Request $request, $cli)
    { 
        $client= CLI::where('TIERS',$cli)->where('DOS',$request->DOS )->select('TIERS')->first(); 
        if($client)
        {   $tiers = str_replace(' ', '', $client->TIERS);
           $Article=  DB::select("SELECT dbo.ART.REF, dbo.ART.DES,dbo.ART.LGTYP, dbo.ART.FAM_0001, dbo.T012.FAM, dbo.ART.REFAMRX, dbo.ART.REFAMR, SCK.QTE, SCK.COMPOSE, 
            dbo.ART.MEDIA, dbo.ART.TVAART, dbo.ART.SREF1, dbo.ART.SREF2,dbo.ART.USIM_ETB,     ISNULL(((SELECT PUB
                    FROM      dbo.TAR
                    WHERE   (dbo.ART.REF = REF) AND (TACOD =
                                          (SELECT TACOD
                                           FROM      dbo.CLI
                                           WHERE   (dbo.TAR.TADT IS NULL) AND (TIERS = '".$tiers."'))))),0) AS PRIX
             FROM     dbo.ART LEFT OUTER JOIN
                (SELECT REF, QTE, COMPOSE
                 FROM      (SELECT derivedtbl_1.REF, SUM(derivedtbl_1.QTE) AS QTE, '' AS COMPOSE
                         FROM      (SELECT SUM(STQTE) AS QTE, REF
                                            FROM      dbo.MVTL
                                            WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                            GROUP BY REF
                                            UNION ALL
                                            SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                            FROM     dbo.MVTL AS MVTL_1
                                            WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                            GROUP BY REF) AS derivedtbl_1 LEFT OUTER JOIN
                                           dbo.ART AS ART_1 ON derivedtbl_1.REF = ART_1.REF
                         GROUP BY derivedtbl_1.REF, ART_1.LGTYP
                         HAVING  (ART_1.LGTYP <> 2)
                         UNION ALL
                         SELECT REF, MIN(QTESCK) AS QTE, 'COMPOSE' AS COMPOSE
                         FROM     (SELECT TOP (100) PERCENT dbo.DAR.REF, dbo.DAR.REFCO, ISNULL(STCK.QTE / dbo.DAR.QTE, 0) AS QTESCK
                                          FROM     dbo.DAR LEFT OUTER JOIN
                         dbo.ART ON dbo.DAR.REF = dbo.ART.REF AND dbo.DAR.DOS = dbo.ART.DOS LEFT OUTER JOIN
                                                                 (SELECT REF, SUM(QTE) AS QTE
                                                                  FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                                                     FROM      dbo.MVTL AS MVTL_2
                                                                                     WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                                                     GROUP BY REF
                                                                                     UNION ALL
                                                                                     SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                                                     FROM     dbo.MVTL AS MVTL_1
                                                                                     WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                                                     GROUP BY REF) AS derivedtbl_1_1
                                                                  GROUP BY REF) AS STCK ON dbo.DAR.REFCO = STCK.REF
             WHERE  (dbo.DAR.DOS = '".$request->DOS."') AND (dbo.ART.LGTYP = 2) AND (dbo.DAR.QTE > 0)
                                           ORDER BY dbo.DAR.REF) AS derivedtbl_2
                         GROUP BY REF) AS derivedtbl_3) AS SCK ON dbo.ART.REF = SCK.REF LEFT OUTER JOIN
             dbo.T012 ON dbo.ART.FAM_0001 = dbo.T012.FAM AND dbo.ART.DOS = dbo.T012.DOS
        WHERE  (dbo.ART.FAM_0001 = '".$request->ref."') AND (dbo.ART.FAM_0001 LIKE 'P%')");    
            if($request->ETB == '-1') return response($Article);
            else {
                return collect($Article)->where('USIM_ETB', $request->ETB)->all();
            }
        }
        else return 'null';
    } 


    public function GetByCli( $cli, Request $request)
    {
        $client= CLI::where('TIERS',$cli)->where('DOS',$request->DOS)->select('TIERS')->first(); 
        
        if($client)
        { 
            $tiers = str_replace(' ', '', $client->TIERS);
            if($request->ETB == '-1') {
                
           return DB::select("SELECT dbo.ART.REF, dbo.ART.USIM_ETB,dbo.ART.DOS,dbo.ART.DES, dbo.ART.LGTYP,
                dbo.ART.FAM_0001, dbo.T012.FAM, dbo.ART.REFAMRX, dbo.ART.REFAMR, 
                SCK.QTE, SCK.COMPOSE,dbo.ART.MEDIA, ISNULL
                ((SELECT PUB
                    FROM      dbo.TAR
                    WHERE   (dbo.ART.REF = REF) AND (TACOD =
                                        (SELECT TACOD
                                            FROM      dbo.CLI
                                            WHERE   (dbo.TAR.TADT IS NULL) AND (TIERS = '".$tiers."')))), 0) AS PRIX
                    FROM     dbo.ART LEFT OUTER JOIN
                    (SELECT REF, QTE, COMPOSE
                    FROM      (SELECT derivedtbl_1.REF, SUM(derivedtbl_1.QTE) AS QTE, '' AS COMPOSE
                                    FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                        FROM      dbo.MVTL
                                                        WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                        GROUP BY REF
                                                        UNION ALL
                                                        SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                        FROM     dbo.MVTL AS MVTL_1
                                                        WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                        GROUP BY REF) AS derivedtbl_1 LEFT OUTER JOIN
                                                        dbo.ART AS ART_1 ON derivedtbl_1.REF = ART_1.REF
                                    GROUP BY derivedtbl_1.REF, ART_1.LGTYP
                                    HAVING  (ART_1.LGTYP <> 2)
                                    UNION ALL
                                    SELECT REF, MIN(QTESCK) AS QTE, 'COMPOSE' AS COMPOSE
                                    FROM     (SELECT TOP (100) PERCENT dbo.DAR.REF, dbo.DAR.REFCO, ISNULL(STCK.QTE / dbo.DAR.QTE, 0) AS QTESCK
                                                    FROM     dbo.DAR LEFT OUTER JOIN
                                    dbo.ART ON dbo.DAR.REF = dbo.ART.REF AND dbo.DAR.DOS = dbo.ART.DOS LEFT OUTER JOIN
                    
                                                                            (SELECT REF, SUM(QTE) AS QTE
                                                                            FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                                                                FROM      dbo.MVTL AS MVTL_2
                                                                                                WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                                                                GROUP BY REF
                                                                                                UNION ALL
                                                                                                SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                                                                FROM     dbo.MVTL AS MVTL_1
                                                                                                WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                                                                GROUP BY REF) AS derivedtbl_1_1
                                                                            GROUP BY REF) AS STCK ON dbo.DAR.REFCO = STCK.REF
                    WHERE  (dbo.DAR.DOS = '".$request->DOS."') AND (dbo.ART.LGTYP = 2) AND (dbo.DAR.QTE > 0)
                                                        ORDER BY dbo.DAR.REF) AS derivedtbl_2
                                    GROUP BY REF) AS derivedtbl_3) AS SCK ON dbo.ART.REF = SCK.REF LEFT OUTER JOIN
                    dbo.T012 ON dbo.ART.FAM_0001 = dbo.T012.FAM AND dbo.ART.DOS = dbo.T012.DOS
                    WHERE  (dbo.ART.FAM_0001 LIKE 'P%') 
                    and dbo.ART.DOS='".$request->DOS."' 
                    and dbo.ART.PRODNAT='2PF'
                    order by REF ");    
                    return response($Article);
            }
              else {
            
            return  DB::select("SELECT dbo.ART.REF, dbo.ART.USIM_ETB,dbo.ART.DOS,dbo.ART.DES, dbo.ART.LGTYP,
                dbo.ART.FAM_0001, dbo.T012.FAM, dbo.ART.REFAMRX, dbo.ART.REFAMR, 
                SCK.QTE, SCK.COMPOSE,dbo.ART.MEDIA, ISNULL
                ((SELECT PUB
                    FROM      dbo.TAR
                    WHERE   (dbo.ART.REF = REF) AND (TACOD =
                                        (SELECT TACOD
                                            FROM      dbo.CLI
                                            WHERE   (dbo.TAR.TADT IS NULL) AND (TIERS = '".$tiers."')))), 0) AS PRIX
                    FROM     dbo.ART LEFT OUTER JOIN
                    (SELECT REF, QTE, COMPOSE
                    FROM      (SELECT derivedtbl_1.REF, SUM(derivedtbl_1.QTE) AS QTE, '' AS COMPOSE
                                    FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                        FROM      dbo.MVTL
                                                        WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                        GROUP BY REF
                                                        UNION ALL
                                                        SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                        FROM     dbo.MVTL AS MVTL_1
                                                        WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                        GROUP BY REF) AS derivedtbl_1 LEFT OUTER JOIN
                                                        dbo.ART AS ART_1 ON derivedtbl_1.REF = ART_1.REF
                                    GROUP BY derivedtbl_1.REF, ART_1.LGTYP
                                    HAVING  (ART_1.LGTYP <> 2)
                                    UNION ALL
                                    SELECT REF, MIN(QTESCK) AS QTE, 'COMPOSE' AS COMPOSE
                                    FROM     (SELECT TOP (100) PERCENT dbo.DAR.REF, dbo.DAR.REFCO, ISNULL(STCK.QTE / dbo.DAR.QTE, 0) AS QTESCK
                                                    FROM     dbo.DAR LEFT OUTER JOIN
                                    dbo.ART ON dbo.DAR.REF = dbo.ART.REF AND dbo.DAR.DOS = dbo.ART.DOS LEFT OUTER JOIN
                    
                                                                            (SELECT REF, SUM(QTE) AS QTE
                                                                            FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                                                                FROM      dbo.MVTL AS MVTL_2
                                                                                                WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                                                                GROUP BY REF
                                                                                                UNION ALL
                                                                                                SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                                                                FROM     dbo.MVTL AS MVTL_1
                                                                                                WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                                                                GROUP BY REF) AS derivedtbl_1_1
                                                                            GROUP BY REF) AS STCK ON dbo.DAR.REFCO = STCK.REF
                    WHERE  (dbo.DAR.DOS = '".$request->DOS."') AND (dbo.ART.LGTYP = 2) AND (dbo.DAR.QTE > 0)
                                                        ORDER BY dbo.DAR.REF) AS derivedtbl_2
                                    GROUP BY REF) AS derivedtbl_3) AS SCK ON dbo.ART.REF = SCK.REF LEFT OUTER JOIN
                    dbo.T012 ON dbo.ART.FAM_0001 = dbo.T012.FAM AND dbo.ART.DOS = dbo.T012.DOS
                    WHERE  (dbo.ART.FAM_0001 LIKE 'P%') and dbo.ART.USIM_ETB='".$request->ETB."' 
                    and dbo.ART.DOS='".$request->DOS."' and dbo.ART.PRODNAT='2PF'  order by REF ");    
                 
              }

          
                    //   if($request->ETB == '-1') return response($Article);
                    //   else {
                    
                    //       return    collect($Article)->where('USIM_ETB', $request->ETB )->all();
                    //   }
        }
        else return 'null';
    }
    public function getArtPF( Request $request)
    {                
       
         if($request->ETB == '-1') {
            return DB::connection('sqlsrv')->table('ART')->select( 
                'ART_ID',
                'DOS',
                'DES',
                'REF',
                'FAM_0001',
                'PRODNAT',
                'USIM_PRIX_BASE AS PRIX',
                'SREF1',
                'SREF2', 
                'MEDIA',
                'TVAART',
                'USIM_ETB',
                'LGTYP')
                ->where('DOS',$request->DOS)
                ->where('PRODNAT',"2PF")
                ->get(); 
         }
         else {
            return  DB::connection('sqlsrv')->table('ART')->select( 
                'ART_ID',
                'DOS',
                'DES',
                'REF',
                'FAM_0001',
                'PRODNAT',
                'USIM_PRIX_BASE AS PRIX',
                'SREF1',
                'SREF2', 
                'MEDIA',
                'TVAART',
                'USIM_ETB',
                'LGTYP')
                ->where('DOS',$request->DOS)
                ->where('PRODNAT',"2PF")
                ->where('USIM_ETB',$request->ETB)
                ->get(); 
         }
        
    } 
    public function GetByFam(Request $request)
    {     
         
         if($request->ETB == '-1') {
           return  DB::select("SELECT dbo.ART.REF,dbo.ART.USIM_ETB, dbo.ART.DES, dbo.ART.FAM_0001,dbo.ART.LGTYP, dbo.T012.FAM, dbo.ART.REFAMRX, dbo.ART.REFAMR, SCK.QTE, SCK.COMPOSE, 
                dbo.ART.MEDIA, dbo.ART.TVAART, dbo.ART.SREF1, dbo.ART.SREF2,    dbo.ART.USIM_PRIX_BASE
                FROM     dbo.ART  LEFT OUTER JOIN
                (SELECT REF, QTE, COMPOSE
                FROM      (SELECT derivedtbl_1.REF, SUM(derivedtbl_1.QTE) AS QTE, '' AS COMPOSE
                                FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                    FROM      dbo.MVTL
                                                    WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                    GROUP BY REF
                                                    UNION ALL
                                                    SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                    FROM     dbo.MVTL AS MVTL_1
                                                    WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                    GROUP BY REF) AS derivedtbl_1 LEFT OUTER JOIN
                                                    dbo.ART AS ART_1 ON derivedtbl_1.REF = ART_1.REF
                                GROUP BY derivedtbl_1.REF, ART_1.LGTYP
                                HAVING  (ART_1.LGTYP <> 2)
                                UNION ALL
                                SELECT REF, MIN(QTESCK) AS QTE, 'COMPOSE' AS COMPOSE
                                FROM     (SELECT TOP (100) PERCENT dbo.DAR.REF, dbo.DAR.REFCO, ISNULL(STCK.QTE / dbo.DAR.QTE, 0) AS QTESCK
                                                FROM     dbo.DAR LEFT OUTER JOIN
                                dbo.ART ON dbo.DAR.REF = dbo.ART.REF AND dbo.DAR.DOS = dbo.ART.DOS LEFT OUTER JOIN

                                                                        (SELECT REF, SUM(QTE) AS QTE
                                                                        FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                                                            FROM      dbo.MVTL AS MVTL_2
                                                                                            WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                                                            GROUP BY REF
                                                                                            UNION ALL
                                                                                            SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                                                            FROM     dbo.MVTL AS MVTL_1
                                                                                            WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                                                            GROUP BY REF) AS derivedtbl_1_1
                                                                        GROUP BY REF) AS STCK ON dbo.DAR.REFCO = STCK.REF
                WHERE  (dbo.DAR.DOS = '".$request->DOS."') AND (dbo.ART.LGTYP = 2) AND (dbo.DAR.QTE > 0)
                                    ORDER BY dbo.DAR.REF) AS derivedtbl_2
                GROUP BY REF) AS derivedtbl_3) AS SCK ON dbo.ART.REF = SCK.REF LEFT OUTER JOIN
                    dbo.T012 ON dbo.ART.FAM_0001 = dbo.T012.FAM AND dbo.ART.DOS = dbo.T012.DOS
                    WHERE  (dbo.ART.FAM_0001 = '".$request->ref."') 
                    and dbo.ART.DOS='".$request->DOS."' 
                    and dbo.ART.PRODNAT='2PF'  order by REF");
         }
         else {
           return DB::select("SELECT dbo.ART.REF,dbo.ART.USIM_ETB, dbo.ART.DES, dbo.ART.FAM_0001,dbo.ART.LGTYP, dbo.T012.FAM, dbo.ART.REFAMRX, dbo.ART.REFAMR, SCK.QTE, SCK.COMPOSE, 
            dbo.ART.MEDIA, dbo.ART.TVAART, dbo.ART.SREF1, dbo.ART.SREF2,    dbo.ART.USIM_PRIX_BASE
            FROM     dbo.ART  LEFT OUTER JOIN
                    (SELECT REF, QTE, COMPOSE
                    FROM      (SELECT derivedtbl_1.REF, SUM(derivedtbl_1.QTE) AS QTE, '' AS COMPOSE
                                    FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                        FROM      dbo.MVTL
                                                        WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                        GROUP BY REF
                                                        UNION ALL
                                                        SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                        FROM     dbo.MVTL AS MVTL_1
                                                        WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                        GROUP BY REF) AS derivedtbl_1 LEFT OUTER JOIN
                                                        dbo.ART AS ART_1 ON derivedtbl_1.REF = ART_1.REF
                                    GROUP BY derivedtbl_1.REF, ART_1.LGTYP
                                    HAVING  (ART_1.LGTYP <> 2)
                                    UNION ALL
                                    SELECT REF, MIN(QTESCK) AS QTE, 'COMPOSE' AS COMPOSE
                                    FROM     (SELECT TOP (100) PERCENT dbo.DAR.REF, dbo.DAR.REFCO, ISNULL(STCK.QTE / dbo.DAR.QTE, 0) AS QTESCK
                                                    FROM     dbo.DAR LEFT OUTER JOIN
                                    dbo.ART ON dbo.DAR.REF = dbo.ART.REF AND dbo.DAR.DOS = dbo.ART.DOS LEFT OUTER JOIN

                                                                            (SELECT REF, SUM(QTE) AS QTE
                                                                            FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                                                                FROM      dbo.MVTL AS MVTL_2
                                                                                                WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                                                                GROUP BY REF
                                                                                                UNION ALL
                                                                                                SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                                                                FROM     dbo.MVTL AS MVTL_1
                                                                                                WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                                                                GROUP BY REF) AS derivedtbl_1_1
                                                                            GROUP BY REF) AS STCK ON dbo.DAR.REFCO = STCK.REF
                    WHERE  (dbo.DAR.DOS = '".$request->DOS."') AND (dbo.ART.LGTYP = 2) AND (dbo.DAR.QTE > 0)
                                        ORDER BY dbo.DAR.REF) AS derivedtbl_2
                    GROUP BY REF) AS derivedtbl_3) AS SCK ON dbo.ART.REF = SCK.REF LEFT OUTER JOIN
                        dbo.T012 ON dbo.ART.FAM_0001 = dbo.T012.FAM AND dbo.ART.DOS = dbo.T012.DOS
                        WHERE  (dbo.ART.FAM_0001 = '".$request->ref."') and dbo.ART.USIM_ETB='".$request->ETB."' 
                        and dbo.ART.DOS='".$request->DOS."' and dbo.ART.PRODNAT='2PF'  order by REF");
         }
    }

    public function articleByRef(Request $request){                  
        return DB::select("SELECT dbo.ART.REF, dbo.ART.DES, dbo.ART.FAM_0001, dbo.T012.FAM, dbo.ART.REFAMRX, dbo.ART.REFAMR, SCK.QTE, SCK.COMPOSE, 
                            dbo.ART.MEDIA, dbo.ART.TVAART,dbo.ART.LGTYP, dbo.ART.SREF1, dbo.ART.SREF2,    dbo.ART.USIM_PRIX_BASE AS PRIX
                            FROM     dbo.ART  LEFT OUTER JOIN
                (SELECT REF, QTE, COMPOSE
                FROM      (SELECT derivedtbl_1.REF, SUM(derivedtbl_1.QTE) AS QTE, '' AS COMPOSE
                                FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                    FROM      dbo.MVTL
                                                    WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                    GROUP BY REF
                                                    UNION ALL
                                                    SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                    FROM     dbo.MVTL AS MVTL_1
                                                    WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                    GROUP BY REF) AS derivedtbl_1 LEFT OUTER JOIN
                                                    dbo.ART AS ART_1 ON derivedtbl_1.REF = ART_1.REF
                                GROUP BY derivedtbl_1.REF, ART_1.LGTYP
                                HAVING  (ART_1.LGTYP <> 2)
                                UNION ALL
                                SELECT REF, MIN(QTESCK) AS QTE, 'COMPOSE' AS COMPOSE
                                FROM     (SELECT TOP (100) PERCENT dbo.DAR.REF, dbo.DAR.REFCO, ISNULL(STCK.QTE / dbo.DAR.QTE, 0) AS QTESCK
                                                FROM     dbo.DAR LEFT OUTER JOIN
                                dbo.ART ON dbo.DAR.REF = dbo.ART.REF AND dbo.DAR.DOS = dbo.ART.DOS LEFT OUTER JOIN

                                                                        (SELECT REF, SUM(QTE) AS QTE
                                                                        FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                                                            FROM      dbo.MVTL AS MVTL_2
                                                                                            WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                                                            GROUP BY REF
                                                                                            UNION ALL
                                                                                            SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                                                            FROM     dbo.MVTL AS MVTL_1
                                                                                            WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                                                            GROUP BY REF) AS derivedtbl_1_1
                                                                        GROUP BY REF) AS STCK ON dbo.DAR.REFCO = STCK.REF
                WHERE  (dbo.DAR.DOS = '".$request->DOS."') AND (dbo.ART.LGTYP = 2) AND (dbo.DAR.QTE > 0)
                                    ORDER BY dbo.DAR.REF) AS derivedtbl_2
                  GROUP BY REF) AS derivedtbl_3) AS SCK ON dbo.ART.REF = SCK.REF LEFT OUTER JOIN
                    dbo.T012 ON dbo.ART.FAM_0001 = dbo.T012.FAM AND dbo.ART.DOS = dbo.T012.DOS
                    WHERE  (dbo.ART.REF = '".$request->ref."')  order by REF")[0];       
    }

    public function GetFamille($dos)
    {
        return  DB::connection('sqlsrv')->table('T012')
            ->where('DOS',$dos)->select([
            'DOS',
            'FAM',
            'T012_ID', 
            'LIB'      
        ])->where('FAM',  'like', 'P'.'%')
        ->where('FAMNO', 1)
        ->where('DOS', 1)->get();
        
    
    }

    public function GetByFamStock($id, Request $request)

    {       
             return DB::select("SELECT dbo.ART.REF, dbo.ART.DES, dbo.ART.DOS,dbo.ART.FAM_0001, dbo.ART.LGTYP,dbo.T012.FAM, dbo.ART.REFAMRX,
              dbo.ART.REFAMR,
              SCK.QTE, SCK.COMPOSE, 
            dbo.ART.MEDIA, dbo.ART.TVAART, dbo.ART.SREF1, dbo.ART.SREF2,    dbo.ART.USIM_PRIX_BASE
                    FROM     dbo.ART  LEFT OUTER JOIN
                (SELECT REF, QTE, COMPOSE
                FROM      (SELECT derivedtbl_1.REF, SUM(derivedtbl_1.QTE) AS QTE, '' AS COMPOSE
                  FROM      (SELECT SUM(STQTE) AS QTE, REF
                                     FROM      dbo.MVTL
                                     WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                     GROUP BY REF
                                     UNION ALL
                                     SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                     FROM     dbo.MVTL AS MVTL_1
                                     WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                     GROUP BY REF) AS derivedtbl_1 LEFT OUTER JOIN
                                    dbo.ART AS ART_1 ON derivedtbl_1.REF = ART_1.REF
                  GROUP BY derivedtbl_1.REF, ART_1.LGTYP
                  HAVING  (ART_1.LGTYP <> 2)
                  UNION ALL
                  SELECT REF, MIN(QTESCK) AS QTE, 'COMPOSE' AS COMPOSE
                  FROM     (SELECT TOP (100) PERCENT dbo.DAR.REF, dbo.DAR.REFCO, ISNULL(STCK.QTE / dbo.DAR.QTE, 0) AS QTESCK
                                   FROM     dbo.DAR LEFT OUTER JOIN
                  dbo.ART ON dbo.DAR.REF = dbo.ART.REF AND dbo.DAR.DOS = dbo.ART.DOS LEFT OUTER JOIN

                                                          (SELECT REF, SUM(QTE) AS QTE
                                                           FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                                              FROM      dbo.MVTL AS MVTL_2
                                                                              WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                                              GROUP BY REF
                                                                              UNION ALL
                                                                              SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                                              FROM     dbo.MVTL AS MVTL_1
                                                                              WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                                              GROUP BY REF) AS derivedtbl_1_1
                                                           GROUP BY REF) AS STCK ON dbo.DAR.REFCO = STCK.REF
            WHERE  (dbo.DAR.DOS = '".$request->DOS."') AND (dbo.ART.LGTYP = 2) AND (dbo.DAR.QTE > 0)
                                    ORDER BY dbo.DAR.REF) AS derivedtbl_2
                  GROUP BY REF) AS derivedtbl_3) AS SCK ON dbo.ART.REF = SCK.REF LEFT OUTER JOIN
        dbo.T012 ON dbo.ART.FAM_0001 = dbo.T012.FAM AND dbo.ART.DOS = dbo.T012.DOS
        WHERE  (dbo.ART.USIM_TYPFAM = '".$id."') AND (dbo.ART.PRODNAT='2PF') ");
 
    }

    public function GetTypeFamille()
    {
        return  DB::select(" select  REPLACE(CODE_TYP, '   ', '') AS CODE_TYP,DES from TYPE_FAM");
        
    
    }
   
    public function GetDepo(Request $ref)
    {
        return  DB::connection('sqlsrv')->table('MVTL')->where('REF',$ref->ref)->get(['QTE'])->first();       
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    

    
  
   

  
   
    public function getByRef(Request $request, $cli)
    { 
        $client= CLI::where('TIERS',$cli)->where('DOS',$request->DOS)->select('TIERS')->first(); 
        
        if($client)
        { 
           $tiers = str_replace(' ', '', $client->TIERS);
           $Article=  DB::select("SELECT dbo.ART.REF, dbo.ART.DES,dbo.ART.TPFR_0001, dbo.ART.LGTYP ,  dbo.ART.FAM_0001, dbo.T012.FAM, dbo.ART.REFAMRX, dbo.ART.REFAMR, SCK.QTE, SCK.COMPOSE,
                dbo.ART.MEDIA, dbo.ART.TVAART, dbo.ART.SREF1, dbo.ART.SREF2,         
                ISNULL((SELECT PUB
                                  FROM      dbo.TAR
                                  WHERE   (dbo.ART.REF = REF) AND (TACOD =
                                                        (SELECT TACOD
                                                         FROM      dbo.CLI
                                                         WHERE   (dbo.TAR.TADT IS NULL) AND (TIERS = '".$tiers."')))), 0) AS PRIX
                         FROM     dbo.ART  LEFT OUTER JOIN
                         (SELECT REF, QTE, COMPOSE
                         FROM      (SELECT derivedtbl_1.REF, SUM(derivedtbl_1.QTE) AS QTE, '' AS COMPOSE
                                           FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                              FROM      dbo.MVTL
                                                              WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                              GROUP BY REF
                                                              UNION ALL
                                                              SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                              FROM     dbo.MVTL AS MVTL_1
                                                              WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                              GROUP BY REF) AS derivedtbl_1 LEFT OUTER JOIN
                                                             dbo.ART AS ART_1 ON derivedtbl_1.REF = ART_1.REF
                                           GROUP BY derivedtbl_1.REF, ART_1.LGTYP
                                           HAVING  (ART_1.LGTYP <> 2)
                                           UNION ALL
                                           SELECT REF, MIN(QTESCK) AS QTE, 'COMPOSE' AS COMPOSE
                                           FROM     (SELECT TOP (100) PERCENT dbo.DAR.REF, dbo.DAR.REFCO, ISNULL(STCK.QTE / dbo.DAR.QTE, 0) AS QTESCK
                                                            FROM     dbo.DAR LEFT OUTER JOIN
                                           dbo.ART ON dbo.DAR.REF = dbo.ART.REF AND dbo.DAR.DOS = dbo.ART.DOS LEFT OUTER JOIN
                         
                                                                                   (SELECT REF, SUM(QTE) AS QTE
                                                                                    FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                                                                       FROM      dbo.MVTL AS MVTL_2
                                                                                                       WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                                                                       GROUP BY REF
                                                                                                       UNION ALL
                                                                                                       SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                                                                       FROM     dbo.MVTL AS MVTL_1
                                                                                                       WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                                                                       GROUP BY REF) AS derivedtbl_1_1
                                                                                    GROUP BY REF) AS STCK ON dbo.DAR.REFCO = STCK.REF
                         WHERE  (dbo.DAR.DOS = '".$request->DOS."') AND (dbo.ART.LGTYP = 2) AND (dbo.DAR.QTE > 0)
                                                             ORDER BY dbo.DAR.REF) AS derivedtbl_2
                                           GROUP BY REF) AS derivedtbl_3) AS SCK ON dbo.ART.REF = SCK.REF LEFT OUTER JOIN
                            dbo.T012 ON dbo.ART.FAM_0001 = dbo.T012.FAM AND dbo.ART.DOS = dbo.T012.DOS
        WHERE   (dbo.ART.REF ='".$request->ref."')")[0];
 
            if($Article->REFAMRX != '        ')  {
                return   DB::select("SELECT dbo.ART.REF,dbo.ART.DOS, dbo.ART.DES, dbo.ART.FAM_0001, dbo.ART.LGTYP , dbo.ART.TPFR_0001, dbo.T012.FAM, dbo.ART.REFAMRX, dbo.ART.REFAMR, SCK.QTE, SCK.COMPOSE,
                    dbo.ART.MEDIA, dbo.ART.TVAART, dbo.ART.SREF1, dbo.ART.SREF2,         
                        ISNULL((SELECT PUB
                                        FROM      dbo.TAR
                                    WHERE   (dbo.ART.REF = REF) AND (TACOD =
                                                        (SELECT TACOD
                                                            FROM      dbo.CLI
                                                            WHERE   (dbo.TAR.TADT IS NULL) AND (TIERS = '".$client->TIERS."')))), 0) AS PRIX, 
                
                
                        
                        (SELECT TRE.REM_0001  from TRE where 
                            (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
                            and TRE.REMCOD='".$Article->REFAMRX."') AS REM_0001,
                        (SELECT TRE.REM_0002  from TRE where 
                                (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
                            and TRE.REMCOD='".$Article->REFAMRX."') AS REM_0002,
                        (SELECT TRE.REM_0003  from TRE where 
                            (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
                            and TRE.REMCOD='".$Article->REFAMRX."') AS REM_0003	 ,
                        (SELECT TRE.REMTYP_0001  from TRE where 
                            (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
                            and TRE.REMCOD='".$Article->REFAMRX."') AS REMTYP_0001	, 
                        (SELECT TRE.REMTYP_0002  from TRE where 
                                (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
                            and TRE.REMCOD='".$Article->REFAMRX."') AS REMTYP_0002	,
                        (SELECT TRE.REMTYP_0003  from TRE where 
                            (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
                            and TRE.REMCOD='".$Article->REFAMRX."') AS REMTYP_0003,
                        (SELECT TRE.REMCOD  from TRE where 
                            (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
                            and TRE.REMCOD='".$Article->REFAMRX."') AS REMCOD,
                        (SELECT TRE.QTE   from TRE where 
                                (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
                            and TRE.REMCOD='".$Article->REFAMRX."') AS REMQTE
                        
                
                            FROM     dbo.ART LEFT OUTER JOIN
                                (SELECT REF, QTE, COMPOSE
                                    FROM      (SELECT derivedtbl_1.REF, SUM(derivedtbl_1.QTE) AS QTE, '' AS COMPOSE
                                                    FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                                        FROM      dbo.MVTL
                                                                        WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                                        GROUP BY REF
                                                                        UNION ALL
                                                                        SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                                        FROM     dbo.MVTL AS MVTL_1
                                                                        WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                                        GROUP BY REF) AS derivedtbl_1 LEFT OUTER JOIN
                                                                        dbo.ART AS ART_1 ON derivedtbl_1.REF = ART_1.REF
                                                    GROUP BY derivedtbl_1.REF, ART_1.LGTYP
                                                    HAVING  (ART_1.LGTYP <> 2)
                                                    UNION ALL
                                                    SELECT REF, MIN(QTESCK) AS QTE, 'COMPOSE' AS COMPOSE
                                                    FROM     (SELECT TOP (100) PERCENT dbo.DAR.REF, dbo.DAR.REFCO, ISNULL(STCK.QTE / dbo.DAR.QTE, 0) AS QTESCK
                                                                        FROM      dbo.DAR LEFT OUTER JOIN
                                                                                            (SELECT REF, SUM(QTE) AS QTE
                                                                                                FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                                                                                FROM      dbo.MVTL AS MVTL_2
                                                                                                                WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                                                                                GROUP BY REF
                                                                                                                UNION ALL
                                                                                                                SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                                                                                FROM     dbo.MVTL AS MVTL_1
                                                                                                                WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                                                                                GROUP BY REF) AS derivedtbl_1_1
                                                                                                GROUP BY REF) AS STCK ON dbo.DAR.REFCO = STCK.REF
                                                                        WHERE   (dbo.DAR.DOS = '".$request->DOS."')
                                                                        ORDER BY dbo.DAR.REF) AS derivedtbl_2
                                                    GROUP BY REF) AS derivedtbl_3) AS SCK ON dbo.ART.REF = SCK.REF LEFT OUTER JOIN
                            dbo.T012 ON dbo.ART.FAM_0001 = dbo.T012.FAM AND dbo.ART.DOS = dbo.T012.DOS
            WHERE   (dbo.ART.REF ='".$Article->REF."')")[0];
            }
            else if($Article->REFAMR != '        ') { 
                return   DB::select("SELECT dbo.ART.REF, dbo.ART.DES, dbo.ART.DOS, dbo.ART.FAM_0001,dbo.ART.LGTYP , dbo.ART.TPFR_0001, dbo.T012.FAM, dbo.ART.REFAMRX, dbo.ART.REFAMR, SCK.QTE, SCK.COMPOSE,
                    dbo.ART.MEDIA, dbo.ART.TVAART, dbo.ART.SREF1, dbo.ART.SREF2,         
                    ISNULL((SELECT PUB
                                    FROM      dbo.TAR
                                WHERE   (dbo.ART.REF = REF) AND (TACOD =
                                                    (SELECT TACOD
                                                        FROM      dbo.CLI
                                                        WHERE   (dbo.TAR.TADT IS NULL) AND (TIERS = '".$client->TIERS."')))), 0) AS PRIX, 
            
            
                    
                    (SELECT TRE.REM_0001  from TRE where 
                        (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
                        and TRE.REMCOD='".$Article->REFAMR."') AS REM_0001,
                    (SELECT TRE.REM_0002  from TRE where 
                            (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
                        and TRE.REMCOD='".$Article->REFAMR."') AS REM_0002,
                    (SELECT TRE.REM_0003  from TRE where 
                        (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
                        and TRE.REMCOD='".$Article->REFAMR."') AS REM_0003	 ,
                    (SELECT TRE.REMTYP_0001  from TRE where 
                        (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
                        and TRE.REMCOD='".$Article->REFAMR."') AS REMTYP_0001	, 
                    (SELECT TRE.REMTYP_0002  from TRE where 
                            (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
                        and TRE.REMCOD='".$Article->REFAMR."') AS REMTYP_0002	,
                    (SELECT TRE.REMTYP_0003  from TRE where 
                        (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
                        and TRE.REMCOD='".$Article->REFAMR."') AS REMTYP_0003,
                    (SELECT TRE.REMCOD  from TRE where 
                        (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
                        and TRE.REMCOD='".$Article->REFAMR."') AS REMCOD,
                    (SELECT TRE.QTE   from TRE where 
                            (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
                        and TRE.REMCOD='".$Article->REFAMR."') AS REMQTE
                    
        
                    FROM     dbo.ART LEFT OUTER JOIN
                        (SELECT REF, QTE, COMPOSE
                            FROM      (SELECT derivedtbl_1.REF, SUM(derivedtbl_1.QTE) AS QTE, '' AS COMPOSE
                                            FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                                FROM      dbo.MVTL
                                                                WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                                GROUP BY REF
                                                                UNION ALL
                                                                SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                                FROM     dbo.MVTL AS MVTL_1
                                                                WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                                GROUP BY REF) AS derivedtbl_1 LEFT OUTER JOIN
                                                                dbo.ART AS ART_1 ON derivedtbl_1.REF = ART_1.REF
                                            GROUP BY derivedtbl_1.REF, ART_1.LGTYP
                                            HAVING  (ART_1.LGTYP <> 2)
                                            UNION ALL
                                            SELECT REF, MIN(QTESCK) AS QTE, 'COMPOSE' AS COMPOSE
                                            FROM     (SELECT TOP (100) PERCENT dbo.DAR.REF, dbo.DAR.REFCO, ISNULL(STCK.QTE / dbo.DAR.QTE, 0) AS QTESCK
                                                                FROM      dbo.DAR LEFT OUTER JOIN
                                                                                    (SELECT REF, SUM(QTE) AS QTE
                                                                                        FROM      (SELECT SUM(STQTE) AS QTE, REF
                                                                                                        FROM      dbo.MVTL AS MVTL_2
                                                                                                        WHERE   (DOS = '".$request->DOS."') AND (DEPO = '2')
                                                                                                        GROUP BY REF
                                                                                                        UNION ALL
                                                                                                        SELECT SUM(REFQTE) * - 1 AS Expr1, REF
                                                                                                        FROM     dbo.MVTL AS MVTL_1
                                                                                                        WHERE  (DOS = '".$request->DOS."') AND (DEPO = '2') AND (OP = '999')
                                                                                                        GROUP BY REF) AS derivedtbl_1_1
                                                                                        GROUP BY REF) AS STCK ON dbo.DAR.REFCO = STCK.REF
                                                                WHERE   (dbo.DAR.DOS = '".$request->DOS."')
                                                                ORDER BY dbo.DAR.REF) AS derivedtbl_2
                                            GROUP BY REF) AS derivedtbl_3) AS SCK ON dbo.ART.REF = SCK.REF LEFT OUTER JOIN
                    dbo.T012 ON dbo.ART.FAM_0001 = dbo.T012.FAM AND dbo.ART.DOS = dbo.T012.DOS
            WHERE   (dbo.ART.REF ='".$Article->REF."')")[0];
            } 
            else  {
                $Article->REM_0001=0.00;
                $Article->REM_0002=0.00;
                $Article->REM_0003=0.00;
                $Article->REMTYP_0001="";
                $Article->REMTYP_0002="";
                $Article->REMTYP_0003="";
                $Article->REMCOD="        ";
                $Article->REMQTE=0.00;
                return  $Article; }
            }
      return NULL;
     
      
    
    }

    public function VerifStock($Article)
    {
        foreach ($Article as $key => $value) {        
            if($value->LGTYP != 2){
                $Qte=0; 
                $MVTL=DB::connection('sqlsrv')->table('MVTL')->select(
                    'REF' , 'QTE', 'STQTE', 'REFQTE', 'OP', 'DEPO')
                ->where('DOS',"1")
                ->where('DEPO',"2") 
                ->where('REF',$value->REF)
                ->get();                 
                foreach ($MVTL as $key => $val) {
                    $Qte= $Qte+$val->STQTE;                  
                    if($val->OP=="999"){
                        $Qte=$Qte-$val->REFQTE;
                    }                    
                } 
                $value->QTE= $Qte;           
            }
            else{
                $nb_kit=0;
                $DAR=DB::connection('sqlsrv')->table('DAR')->select('REFCO', 'DAR_ID', 'QTE')
                    ->where('DOS',"1") 
                    ->where('REF',$value->REF)
                    ->get(); 
                foreach ($DAR as $keys => $DarValue) {  
                    $Qte=0;      
                        if($DarValue){
                            $MVTL=DB::connection('sqlsrv')->table('MVTL')->select(
                                'REF' , 'QTE', 'STQTE', 'REFQTE', 'OP', 'DEPO' )
                            ->where('DOS',"1")
                            ->where('DEPO',"2") 
                            ->where('REF',$DarValue->REFCO)
                            ->get();             
                            foreach ($MVTL as $key => $val) {
                                $Qte= $Qte+$val->STQTE;
                                if($val->OP=="999"){
                                    $Qte=$Qte-$val->REFQTE;
                                }                    
                            }  
                            if($keys=0){
                                $nb_kit= $Qte/$DarValue->QTE;
                            }          
                            if($Qte/$DarValue->QTE < $nb_kit){
                                $nb_kit= $Qte/$DarValue->QTE;
                            }
                        }          
                        }  
                    $value->QTE= $nb_kit;
            }
        }
        return $Article; 
    }
 
    public function ARTBYREF($ref, $cli)
    {
        return DB::select("  SELECT ART.ART_ID, ART.REF, ART.DES, ART.TIERS, ART.FAM_0001, ART.REFAMRX, ART.REFAMR, 
        ISNULL( ARTTAR".$cli.".USIM_PRIX_BASE, ART.USIM_PRIX_BASE) AS USIM_PRIX_BASE, ART.FAM_0002, ART.FAM_0003, 
        ART.PRODNAT, 
        ART.MEDIA, ART.TVAART, ART.SREF1, ART.SREF2, ART.PREFDVNO, ART.DVNO, ART.QTE, ART.LGTYP ,ART.TPFR_0001
        FROM     ARTTAR".$cli." RIGHT OUTER JOIN
        ART ON ARTTAR".$cli.".ART_ID = ART.ART_ID
        WHERE  (ART.DOS = '1') AND (ART.PRODNAT = '2PF') AND (ART.REF='".$ref."') 
        ORDER BY ART.ART_ID  ")[0];
    }
     
    // public function update(Request $request, $id)
    // {        ART::where('ART_ID',$id)->update([ 
    //         'DOS'=>request('DOS'),
    //         'DES'=>request('DES'),
    //         'REF'=>request('REF'), 
    //     ]);
    //     return  ART::where('ART_ID',$id)->first();
    // }
    
  
    // public function delete(Request $request,$id)
    // {
    //     $article= ART::where('ART_ID',$id);
    //     $article->delete();
    //     return response(ART::get(["ART_ID",
    //     'ART_ID',
    //     'DOS',
    //     'DES',
    //     'REF',  
    //     ]));
    // }
    // public function ARTBYREFwithRem1($art, $cli ){
    //     return DB::select("SELECT dbo.ART.REF, dbo.ART.DES, dbo.ART.FAM_0001, dbo.T012.FAM, dbo.ART.LGTYP,dbo.ART.REFAMRX, dbo.ART.REFAMR, SCK.QTE, SCK.COMPOSE,
    //             dbo.ART.MEDIA, dbo.ART.TVAART, dbo.ART.SREF1, dbo.ART.SREF2,         
    //             ISNULL((SELECT PUB
    //                                 FROM      dbo.TAR
    //                            WHERE   (dbo.ART.REF = REF) AND (TACOD =
    //                                                  (SELECT TACOD
    //                                                   FROM      dbo.CLI
    //                                                   WHERE   (dbo.TAR.TADT IS NULL) AND (TIERS = '".$cli."')))), 0) AS PRIX, 
    //                 (SELECT TRE.REM_0001  from TRE where 
    //                     (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
    //                     and TRE.REMCOD='".$art->REFAMRX."') AS REM_0001,
    //                 (SELECT TRE.REM_0002  from TRE where 
    //                         (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
    //                     and TRE.REMCOD='".$art->REFAMRX."') AS REM_0002,
    //                 (SELECT TRE.REM_0003  from TRE where 
    //                     (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
    //                     and TRE.REMCOD='".$art->REFAMRX."') AS REM_0003	 ,
    //                 (SELECT TRE.REMTYP_0001  from TRE where 
    //                     (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
    //                     and TRE.REMCOD='".$art->REFAMRX."') AS REMTYP_0001	, 
    //                 (SELECT TRE.REMTYP_0002  from TRE where 
    //                         (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
    //                     and TRE.REMCOD='".$art->REFAMRX."') AS REMTYP_0002	,
    //                 (SELECT TRE.REMTYP_0003  from TRE where 
    //                     (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
    //                     and TRE.REMCOD='".$art->REFAMRX."') AS REMTYP_0003,
    //                 (SELECT TRE.REMCOD  from TRE where 
    //                     (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
    //                     and TRE.REMCOD='".$art->REFAMRX."') AS REMCOD,
    //                 (SELECT TRE.QTE   from TRE where 
    //                         (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
    //                     and TRE.REMCOD='".$art->REFAMRX."') AS REMQTE
    //                  FROM     dbo.ART  LEFT OUTER JOIN
    //                   (SELECT REF, QTE, COMPOSE
    //                   FROM      (SELECT derivedtbl_1.REF, SUM(derivedtbl_1.QTE) AS QTE, '' AS COMPOSE
    //                                     FROM      (SELECT SUM(STQTE) AS QTE, REF
    //                                                        FROM      dbo.MVTL
    //                                                        WHERE   (DOS = '1') AND (DEPO = '2')
    //                                                        GROUP BY REF
    //                                                        UNION ALL
    //                                                        SELECT SUM(REFQTE) * - 1 AS Expr1, REF
    //                                                        FROM     dbo.MVTL AS MVTL_1
    //                                                        WHERE  (DOS = '1') AND (DEPO = '2') AND (OP = '999')
    //                                                        GROUP BY REF) AS derivedtbl_1 LEFT OUTER JOIN
    //                                                       dbo.ART AS ART_1 ON derivedtbl_1.REF = ART_1.REF
    //                                     GROUP BY derivedtbl_1.REF, ART_1.LGTYP
    //                                     HAVING  (ART_1.LGTYP <> 2)
    //                                     UNION ALL
    //                                     SELECT REF, MIN(QTESCK) AS QTE, 'COMPOSE' AS COMPOSE
    //                                     FROM     (SELECT TOP (100) PERCENT dbo.DAR.REF, dbo.DAR.REFCO, ISNULL(STCK.QTE / dbo.DAR.QTE, 0) AS QTESCK
    //                                                      FROM     dbo.DAR LEFT OUTER JOIN
    //                                     dbo.ART ON dbo.DAR.REF = dbo.ART.REF AND dbo.DAR.DOS = dbo.ART.DOS LEFT OUTER JOIN
                      
    //                                                                             (SELECT REF, SUM(QTE) AS QTE
    //                                                                              FROM      (SELECT SUM(STQTE) AS QTE, REF
    //                                                                                                 FROM      dbo.MVTL AS MVTL_2
    //                                                                                                 WHERE   (DOS = '1') AND (DEPO = '2')
    //                                                                                                 GROUP BY REF
    //                                                                                                 UNION ALL
    //                                                                                                 SELECT SUM(REFQTE) * - 1 AS Expr1, REF
    //                                                                                                 FROM     dbo.MVTL AS MVTL_1
    //                                                                                                 WHERE  (DOS = '1') AND (DEPO = '2') AND (OP = '999')
    //                                                                                                 GROUP BY REF) AS derivedtbl_1_1
    //                                                                              GROUP BY REF) AS STCK ON dbo.DAR.REFCO = STCK.REF
    //                   WHERE  (dbo.DAR.DOS = '1') AND (dbo.ART.LGTYP = 2) AND (dbo.DAR.QTE > 0)
    //                                                       ORDER BY dbo.DAR.REF) AS derivedtbl_2
    //                                     GROUP BY REF) AS derivedtbl_3) AS SCK ON dbo.ART.REF = SCK.REF LEFT OUTER JOIN
    //                      dbo.T012 ON dbo.ART.FAM_0001 = dbo.T012.FAM AND dbo.ART.DOS = dbo.T012.DOS
    //  WHERE   (dbo.ART.REF ='".$art->REF."')")[0]; 
       
    // }
    // public function ARTBYREFwithRem2($art, $cli ){
    //    return DB::select("SELECT dbo.ART.REF, dbo.ART.DES, dbo.ART.FAM_0001, dbo.T012.FAM, dbo.ART.LGTYP,dbo.ART.REFAMRX, dbo.ART.REFAMR, SCK.QTE, SCK.COMPOSE,
    //             dbo.ART.MEDIA, dbo.ART.TVAART, dbo.ART.SREF1, dbo.ART.SREF2,         
    //             ISNULL((SELECT PUB
    //                                     FROM      dbo.TAR
    //                                     WHERE   (dbo.ART.REF = REF) AND (TACOD =
    //                                                             (SELECT TACOD
    //                                                             FROM      dbo.CLI
    //                                                             WHERE   (dbo.TAR.TADT IS NULL) AND (TIERS = '".$cli."')))), 0) AS PRIX, 



    //         (SELECT TRE.REM_0001  from TRE where 
    //             (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
    //             and TRE.REMCOD='".$art->REFAMRX."') AS REM_0001,
    //         (SELECT TRE.REM_0002  from TRE where 
    //             (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
    //             and TRE.REMCOD='".$art->REFAMRX."') AS REM_0002,
    //         (SELECT TRE.REM_0003  from TRE where 
    //             (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
    //             and TRE.REMCOD='".$art->REFAMRX."') AS REM_0003	 ,
    //         (SELECT TRE.REMTYP_0001  from TRE where 
    //             (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
    //             and TRE.REMCOD='".$art->REFAMRX."') AS REMTYP_0001	, 
    //         (SELECT TRE.REMTYP_0002  from TRE where 
    //             (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
    //             and TRE.REMCOD='".$art->REFAMRX."') AS REMTYP_0002	,
    //         (SELECT TRE.REMTYP_0003  from TRE where 
    //             (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
    //             and TRE.REMCOD='".$art->REFAMRX."') AS REMTYP_0003,
    //         (SELECT TRE.REMCOD  from TRE where 
    //             (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
    //             and TRE.REMCOD='".$art->REFAMRX."') AS REMCOD,
    //         (SELECT TRE.QTE   from TRE where 
    //             (TRE.REMDT <= GETDATE() OR    TRE.REMDT IS NULL) and (TRE.HSDT >= GETDATE() OR TRE.HSDT IS NULL) 
    //             and TRE.REMCOD='".$art->REFAMRX."') AS REMQTE


    //                  FROM     dbo.ART  LEFT OUTER JOIN
    //                  (SELECT REF, QTE, COMPOSE
    //                  FROM      (SELECT derivedtbl_1.REF, SUM(derivedtbl_1.QTE) AS QTE, '' AS COMPOSE
    //                                    FROM      (SELECT SUM(STQTE) AS QTE, REF
    //                                                       FROM      dbo.MVTL
    //                                                       WHERE   (DOS = '1') AND (DEPO = '2')
    //                                                       GROUP BY REF
    //                                                       UNION ALL
    //                                                       SELECT SUM(REFQTE) * - 1 AS Expr1, REF
    //                                                       FROM     dbo.MVTL AS MVTL_1
    //                                                       WHERE  (DOS = '1') AND (DEPO = '2') AND (OP = '999')
    //                                                       GROUP BY REF) AS derivedtbl_1 LEFT OUTER JOIN
    //                                                      dbo.ART AS ART_1 ON derivedtbl_1.REF = ART_1.REF
    //                                    GROUP BY derivedtbl_1.REF, ART_1.LGTYP
    //                                    HAVING  (ART_1.LGTYP <> 2)
    //                                    UNION ALL
    //                                    SELECT REF, MIN(QTESCK) AS QTE, 'COMPOSE' AS COMPOSE
    //                                    FROM     (SELECT TOP (100) PERCENT dbo.DAR.REF, dbo.DAR.REFCO, ISNULL(STCK.QTE / dbo.DAR.QTE, 0) AS QTESCK
    //                                                     FROM     dbo.DAR LEFT OUTER JOIN
    //                                    dbo.ART ON dbo.DAR.REF = dbo.ART.REF AND dbo.DAR.DOS = dbo.ART.DOS LEFT OUTER JOIN
                     
    //                                                                            (SELECT REF, SUM(QTE) AS QTE
    //                                                                             FROM      (SELECT SUM(STQTE) AS QTE, REF
    //                                                                                                FROM      dbo.MVTL AS MVTL_2
    //                                                                                                WHERE   (DOS = '1') AND (DEPO = '2')
    //                                                                                                GROUP BY REF
    //                                                                                                UNION ALL
    //                                                                                                SELECT SUM(REFQTE) * - 1 AS Expr1, REF
    //                                                                                                FROM     dbo.MVTL AS MVTL_1
    //                                                                                                WHERE  (DOS = '1') AND (DEPO = '2') AND (OP = '999')
    //                                                                                                GROUP BY REF) AS derivedtbl_1_1
    //                                                                             GROUP BY REF) AS STCK ON dbo.DAR.REFCO = STCK.REF
    //                  WHERE  (dbo.DAR.DOS = '1') AND (dbo.ART.LGTYP = 2) AND (dbo.DAR.QTE > 0)
    //                                                      ORDER BY dbo.DAR.REF) AS derivedtbl_2
    //                                    GROUP BY REF) AS derivedtbl_3) AS SCK ON dbo.ART.REF = SCK.REF LEFT OUTER JOIN
    //                     dbo.T012 ON dbo.ART.FAM_0001 = dbo.T012.FAM AND dbo.ART.DOS = dbo.T012.DOS
    //          WHERE   (dbo.ART.REF ='".$art->REF."')")[0]; 
    // }
   

    }
 
