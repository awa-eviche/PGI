<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Bulletin de note</title>
    <style>
        body {
            font-family: "ExoRegular", sans-serif !important;
            margin: 10px;
            padding: 0;
            font-size: 12px;
            box-sizing: border-box;
        }
        .bold-exo {
            font-family: ExoBold, sans-serif !important;
            font-weight: bold;
        }
        .border-td {
            border: 1px solid black;
            padding: 4px;
        }
        .bg-grey {
            background-color: grey;
            color: black;
        }
        .full-table {
            width: 100%;
            border-collapse: collapse;
        }
        .centered {
            text-align: center;
        }
        .dotted-line {
            width: 15%;
            height: 1px;
            border-bottom: 1px dotted black;
            margin: 5px auto;
        }
        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 10px;
        }
        .half-table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <!-- En-tête -->
    <div class="centered">
        <strong>MINISTERE DE LA FORMATION PROFESSIONNELLE ET TECHNIQUE</strong>
    </div>
    <div class="dotted-line"></div>
    <div class="centered">
        <strong class="bold-exo">[EFPT]</strong><br>
        <strong>TEL :</strong> <strong class="bold-exo">[EFPTTEL]</strong>
    </div>
    <div class="dotted-line"></div>
    <div class="centered">
        Classe : <strong class="bold-exo">[CLASSE]</strong>
    </div>
    <div class="dotted-line"></div>
    <div class="border-td bg-grey bold-exo centered">
        Relevé de Notes - Semestre <strong>[SEMESTRE]</strong><br>
        Année Scolaire : <strong>[ANNEESCOLAIRE]</strong>
    </div>
    <div>
        <strong class="bold-exo">Prénom & Nom :</strong> <span>[USER]</span><br>
        <strong class="bold-exo">Date et Lieu de Naissance :</strong> <span>[DATENAISSANCE]</span> à <span>[LIEUNAISSANCE]</span><br>
        <strong class="bold-exo">Téléphone :</strong> <span>[TEL]</span><br>
        <strong class="bold-exo">Email :</strong> <span>[EMAIL]</span><br>
        <strong class="bold-exo">Matricule :</strong> <span>[MATRICULE]</span>
    </div>

    <!-- Tableau des matières -->
    <table class="full-table" cellspacing="0" style="margin-top: 10px;">
        <tr>
            <td class="border-td bg-grey bold-exo">Matières</td>
            <td class="border-td bg-grey bold-exo">Coefficient</td>
            <td class="border-td bg-grey bold-exo">Contrôle continu</td>
            <td class="border-td bg-grey bold-exo">Composition</td>
            <td class="border-td bg-grey bold-exo">Moyenne</td>
            <td class="border-td bg-grey bold-exo">Appréciation</td>
        </tr>
        [BODY]
       <tr>
    <td colspan="2" class="border-td bg-grey bold-exo" style="text-align: left;">
        Moyenne Semestrielle : [MOYENNE]
    </td>
    <td colspan="2" class="border-td bg-grey bold-exo" style="text-align: center;">
        Rang : [RANG]
    </td>
    <td colspan="2" class="border-td bg-grey bold-exo" style="text-align: right;">
        Moyenne de la classe : [MOYENNE_CLASSE]
    </td>
</tr>

       


    </table>
       [TABLE_MOYENNES]

    <!-- Bloc Absences + Appréciation dans une seule table -->
    <table class="full-table" cellspacing="0" style="margin-top: 10px;">
        <tr>
            <!-- Colonne Absences -->
            <td style="width: 50%; vertical-align: top;">
                <table class="half-table" cellspacing="0">
                    <tr>
                        <td class="border-td bg-grey bold-exo">Absences</td>
                        <td class="border-td"></td>
                    </tr>
                   
                    <tr>
                        <td class="border-td bg-grey bold-exo">Retards</td>
                        <td class="border-td"></td>
                    </tr>
                </table>
            </td>

            <!-- Colonne Appréciation -->
            <td style="width: 50%; vertical-align: top;">
                <table class="half-table" cellspacing="0">
                    
                     <tr>
                        <td class="border-td bg-grey bold-exo">Travail satisfaisant</td>
                        <td class="border-td"></td>
                    </tr>
                     <tr>
                        <td class="border-td bg-grey bold-exo">Admise en classe supérieur</td>
                        <td class="border-td"></td>
                    </tr>
                    <tr>
                        <td class="border-td bg-grey bold-exo">Doit redoubler</td>
                        <td class="border-td"></td>
                    </tr>
                     <tr>
                        <td class="border-td bg-grey bold-exo">Passable</td>
                        <td class="border-td"></td>
                    </tr>
                   
                </table>
            </td>
        </tr>
    </table>

    <!-- Signatures -->
    <table class="full-table" style="margin-top: 15px;">
        <tr>
            <td class="bold-exo" style="text-align: left;">Le [DATE]</td>
            <td class="bold-exo" style="text-align: right;">Le Chef d'Établissement</td>
        </tr>
    </table>

   
</body>
</html>
<?php /**PATH /Applications/MAMP/htdocs/PGI-1/resources/views/pdf/bulletin.blade.php ENDPATH**/ ?>