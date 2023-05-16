<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class reglementController extends Controller
{
    public function getFactureNonPayee($tiers){
        $request= DB::select("SELECT        REPR_0001, NOMREP, ETB, TIERS, NOM, FADT, PREFFANO, FANO, [MTFC], [MTFC] - MT AS PAYE, MT AS RESTE, REPLACE(ADRCPL1, '  ', '') + ' ' + REPLACE(ADRCPL2, '  ', '') + ' ' + REPLACE(RUE, '  ', '') 
        + ' ' + REPLACE(VIL, '  ', '') AS ADRESSE, Controle
FROM            (SELECT        dbo.R2.R2_ID, dbo.R2.CE1, dbo.R2.CE3, dbo.R2.CE5, dbo.R2.DOS, dbo.R2.ETB, dbo.R2.G3CE1, dbo.R2.EFF, dbo.R2.TRANSAC, dbo.R2.TIERS, dbo.R2.ETAT, dbo.R2.ECHDT, dbo.R2.EMIDT, dbo.R2.EFFDT, 
                                   dbo.R2.MT, LIENFACTURE.PREFFANO, LIENFACTURE.FANO, FACTURE.FADT, FACTURE.MT AS [MTFC], dbo.CLI.NOM, dbo.CLI.REPR_0001, dbo.VRP.NOM AS NOMREP, dbo.CLI.ADRCPL1, dbo.CLI.ADRCPL2, 
                                   dbo.CLI.RUE, dbo.CLI.LOC, dbo.CLI.VIL, CASE dbo.CLI.FEU WHEN 3 THEN 'Bloqué' WHEN 2 THEN 'A Surveiller' ELSE '' END AS Controle
         FROM            dbo.VRP RIGHT OUTER JOIN
                                   dbo.CLI ON dbo.VRP.TIERS = dbo.CLI.REPR_0001 AND dbo.VRP.DOS = dbo.CLI.DOS RIGHT OUTER JOIN
                                   dbo.R2 ON dbo.CLI.DOS = dbo.R2.DOS AND dbo.CLI.TIERS = dbo.R2.TIERS LEFT OUTER JOIN
                                   dbo.RA AS ETAT ON ETAT.ETAT = dbo.R2.ETAT LEFT OUTER JOIN
                                   dbo.R3 AS LIENFACTURE ON LIENFACTURE.R3_ID =
                                       (SELECT        TOP (1) R3_ID
                                         FROM            dbo.R3 AS R3FANO
                                         WHERE        (CE1 = '3') AND (dbo.R2.DOS = DOS) AND (G3CE1 = dbo.R2.G3CE1) AND (EFF = dbo.R2.EFF) AND (TIERS IS NOT NULL) AND (FANO IS NOT NULL)
                                         ORDER BY PREFFANO, FANO) LEFT OUTER JOIN
                                   dbo.R1 AS FACTURE ON FACTURE.DOS = LIENFACTURE.DOS AND FACTURE.G3CE1 = LIENFACTURE.G3CE1 AND FACTURE.TIERS = LIENFACTURE.TIERS AND FACTURE.PREFPIECE = LIENFACTURE.PREFFANO AND
                                    FACTURE.PIECE = LIENFACTURE.FANO
         WHERE        (dbo.R2.DOS = 1) AND (dbo.R2.CE1 = '2') AND (dbo.R2.CE5 = '1') AND (dbo.R2.CE3 = '1' OR
                                   dbo.R2.CE3 = '2' OR
                                   dbo.R2.CE3 = '3') AND (dbo.R2.G3CE1 = 3) AND (dbo.R2.ETAT LIKE '%10')) AS derivedtbl_1

WHERE TIERS='".$tiers."'
ORDER BY TIERS,FADT DESC");
        return $request;
    }

    public function accompte($tiers){
        return DB::select("SELECT        derivedtbl_1.TIERS, dbo.CLI.NOM, SUM(derivedtbl_1.MTACOMPTE) AS MTACOMPTE, dbo.CLI.REPR_0001, dbo.VRP.NOM AS NOMREP, 
        CASE dbo.CLI.FEU WHEN 3 THEN 'Bloqué' WHEN 2 THEN 'A Surveiller' ELSE '' END AS Controle
FROM            dbo.VRP RIGHT OUTER JOIN
        dbo.CLI ON dbo.VRP.TIERS = dbo.CLI.REPR_0001 AND dbo.VRP.DOS = dbo.CLI.DOS RIGHT OUTER JOIN
            (SELECT        dbo.R2.R2_ID, dbo.R2.CE1, dbo.R2.CE3, dbo.R2.CE5, dbo.R2.DOS, dbo.R2.ETB, dbo.R2.G3CE1, dbo.R2.EFF, dbo.R2.TRANSAC, dbo.R2.TIERS, dbo.R2.ETAT, dbo.R2.ECHDT, dbo.R2.EMIDT, dbo.R2.EFFDT, 
                                        - dbo.R2.MT AS MTACOMPTE
              FROM            dbo.R2 LEFT OUTER JOIN
                                        dbo.RA AS ETAT ON ETAT.ETAT = dbo.R2.ETAT
              WHERE        (dbo.R2.DOS = 1) AND (dbo.R2.CE1 = '2') AND (dbo.R2.CE5 = '1') AND (dbo.R2.CE3 = '1' OR
                                        dbo.R2.CE3 = '2' OR
                                        dbo.R2.CE3 = '3') AND (dbo.R2.G3CE1 = 3) AND (dbo.R2.ETAT = 'WAR')) AS derivedtbl_1 ON dbo.CLI.TIERS = derivedtbl_1.TIERS AND dbo.CLI.DOS = derivedtbl_1.DOS
WHERE CLI.TIERS='".$tiers."'
GROUP BY derivedtbl_1.TIERS, dbo.CLI.NOM, dbo.CLI.REPR_0001, dbo.VRP.NOM, dbo.CLI.FEU");
    }
}
