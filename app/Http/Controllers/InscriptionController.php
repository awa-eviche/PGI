<?php

namespace App\Http\Controllers;
use App\Models\Competence;
use App\Models\Evalute;
use App\Models\Inscription;
use App\Models\Classe;
use App\Models\Apprenant;
use App\Models\AnneeAcademique;
use App\Models\Etablissement;
use App\Models\Matiere;
use Illuminate\Http\Request;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;
use Dompdf\Dompdf;

class InscriptionController extends Controller
{
    protected $logUserRepository;

    public function __construct(LogUserRepository $logUserRepository)
    {
        $this->middleware('auth');
        $this->logUserRepository = $logUserRepository;
       

    }

    public function index()
    {
     
        $userName = auth()->user()->nom;

        if (auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
            $etablissementId = auth()->user()->personnel->etablissement_id;

            if (!$etablissementId) {
                return abort(403, "L'établissement de l'utilisateur actuel n'est pas valide.");
            }
            $classesIds = Classe::where('etablissement_id', $etablissementId)->pluck('id');
        } else {
            // Récupérer les IDs des classes de toutes les classes
            $classesIds = Classe::all()->pluck('id');
        }
        // Récupérer les IDs des apprenants associés à ces classes
        $apprenantsIds = Inscription::whereIn('classe_id', $classesIds)->pluck('apprenant_id');

        $classe = session()->has('currentClasse') ? session()->get('currentClasse') : '';
        $currentClasse = $classe ? Classe::find($classe) : null;
        $classes = [$currentClasse];
        $matieres = $classe ? Matiere::where('niveau_etude_id', $currentClasse->niveau_etude->id)->get() : [];

        // Récupérer les apprenants associés à ces IDs
        $apprenants = Apprenant::whereIn('id', $apprenantsIds)->get();

        return view('inscription.index', compact('apprenants', 'matieres'));
    }

   
    public function create()
    {
        $annee_academiques = AnneeAcademique::all();

        // Récupérer le nom de l'utilisateur
        $userName = auth()->user()->nom;

        if (auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
            
           
            $etablissementId = auth()->user()->personnel->etablissement_id;

            // Vérifiez si l'établissement est valide
            if (!$etablissementId) {
                return abort(403, "L'établissement de l'utilisateur actuel n'est pas valide.");
            }
            // Récupérer les classes associées à l'établissement actuel
            $classes = Classe::where('etablissement_id', $etablissementId)->get();

            // Récupérer les apprenants associés à l'établissement actuel
            $apprenants = Apprenant::where('etablissement_id', $etablissementId)->get();
        } else {
            // Récupérer toutes les classes 
            $classes = Classe::all();
            $classesIds = Classe::all()->pluck('id');

            // Récupérer les apprenants associés à l'établissement actuel
            $apprenantsIds = Inscription::whereIn('classe_id', $classesIds)->pluck('apprenant_id');
            $apprenants = Apprenant::whereIn('apprenant_id', $apprenantsIds)->get();
        }

        return view('inscription.create', compact('classes', 'apprenants','annee_academiques'));
    }

    
    public function store(Request $request)
    {
        $request->validate([

            'apprenant_id' => 'required|string',
            'classe_id' => 'required|string',
            'annee_academique_id' => 'required|exists:annee_academiques,id',

        ]);


        $inscription = Inscription::create($request->all());
        $this->logUserRepository->store(['action' => UserAction::AddInscription, 'model' => Model::Inscription, 'new_object' => json_encode($inscription)]);


        return redirect()->route('inscription.index')

            ->withMessage('Inscription créé avec succès.');
    }

   
     public function show(Inscription $inscription)
    {
        $classeId = session('currentClasse');
        $currentClasse = $classeId ? Classe::find($classeId) : null;
        $matieres = collect();
        $competences = collect();
        $apprenants = $classeId ? Inscription::where('classe_id', $classeId)->get() : collect();
    
        if ($currentClasse && $currentClasse->niveau_etude) {
            if ($currentClasse->modalite === 'PPO') {
                $matieres = Matiere::where('niveau_etude_id', $currentClasse->niveau_etude->id)->get();
            } elseif ($currentClasse->modalite === 'APC') {
                $competences = Competence::where('niveau_etude_id', $currentClasse->niveau_etude->id)->get();
            }
        }
    
        return view('inscription.show', [
            "inscription" => $inscription,
            "apprenants" => $apprenants,
            "classe" => $classeId,
            'matieres' => $matieres,
            'competences' => $competences,
            'currentClasse' => $currentClasse,
        ]);
    }
    

   
    public function edit(Inscription $inscription)
    {

        $classes = Classe::all();
        $apprenants = Apprenant::all();
        return view('inscription.edit', compact('inscription', 'classes', 'apprenants'));
    }


    public function update(Request $request, Inscription $inscription)
    {
        $request->validate([
            'apprenant_id' => 'required|string',
            'classe_id' => 'required|string',

        ]);

        $inscription->update($request->all());

        return redirect()->route('inscription.index')
            ->withMessage('Inscription mise à jour avec succès.');
    }

    public function destroy(Inscription $inscription)
    {

        $this->logUserRepository->store([
            'action' => UserAction::DeleteInscription, 'model' => Model::Inscription,
            'old_object' => json_encode($inscription)
        ]);
        $inscription->delete();

        return redirect()->route('inscription.index')
            ->withMessage('Inscription supprimé avec succès.');
    }

 function generateCompetenceClassePdf(string $id)
    {
        $inscriptions = Inscription::where('classe_id', $id)->get();
        $totalCompetence = Competence::where('niveau_etude_id', $inscriptions[0]->classe->niveau_etude_id)->get()->count();

        $legendes = [];
        array_push($legendes, '<li><span class="bold-exo">A</span> : Acquis</li>');
        array_push($legendes, '<li><span class="bold-exo">NA</span> : Non Acquis</li>');

        //Initialiser les compteurs et le output
        $cleCritere = 0;
        $ecKey = 0;
        $cptKey = 0;
        $start = 0;
        $end = 3;
        $body = '';
        $enteteKey = 0;

        while ($totalCompetence > $start) {
            $competences = Competence::where('niveau_etude_id', $inscriptions[0]->classe->niveau_etude_id)->offset($start)->limit($end)->get();

            $criteres = [];
            $rowspans = [];
            $labelsCompetences = '';
            foreach ($competences as $keyRow => $competence) {
                $labelsCompetences .= 'C' . ($enteteKey + 1);
                if ((sizeof($competences) - 1) > $keyRow) {
                    $labelsCompetences .= ' - ';
                }

                $rowspan = 0;
                foreach ($competence->elementCompetences as $ec) {
                    $rowspan += sizeof($ec->criteres);
                    $criteres = [...$criteres, ...$ec->criteres->toArray()];
                }
                $rowspans[$keyRow] = $rowspan;
                $enteteKey++;
            }

            $body .= '
            <p class="c-dispay">Compétences : ' . $labelsCompetences . '</p>
            <table class="full-table mb-1" style="margin-top: 1rem;font-size:80%" cellspacing="0">
            <tr style="page-break-before: avoid;">
                <td rowspan="3" align="center" class="border-td">Apprenants</td>';

            //Afficher la ligne des compétences
            foreach ($competences as $cptCompetence => $competence) {
                $body .= '
                        <td align="center" colspan="' . $rowspans[$cptCompetence] . '" class="border-td">C' . ($cptKey + 1) . '</td>
                ';
                array_push($legendes, '<li><span class="bold-exo">C' . ($cptKey + 1) . '</span> : ' . $competence->nom . '</li>');
                $cptKey++;
            }
            $body .= '
            </tr>
            ';

            $body .= '
            <tr style="page-break-before: avoid;">
            ';

            foreach ($competences as $key => $competence) {
                foreach ($competence->elementCompetences as $ec) {
                    $body .= '<td align="center" colspan="' . sizeof($ec->criteres) . '" class="border-td">EC' . ($ecKey + 1) . '</td>';
                    array_push($legendes, '<li><span class="bold-exo">EC' . ($ecKey + 1) . '</span> : ' . $ec->nom . '</li>');
                    $ecKey++;
                }

            }
            $body .= '
            </tr>
            ';

            $body .= '
            <tr style="page-break-before: avoid;">
            ';

            //Afficher la ligne des critères
            foreach ($competences as $key => $competence) {
                foreach ($competence->elementCompetences as $ec) {
                    foreach ($ec->criteres as $critereKey => $critere) {
                        $body .= '<td class="border-td">CRI' . ($cleCritere + 1) . '</td>';
                        array_push($legendes, '<li><span class="bold-exo">CRI' . ($cleCritere + 1) . '</span> : ' . $critere->libelle . '</li>');
                        $cleCritere++;
                    }
                }
            }
            $body .= '
            </tr>
            ';

            foreach ($inscriptions as $cleInscription => $inscription) {
                $rowspanCount = 0;
                $output = '';
                $evaluations = Evalute::where('inscription_id', $inscription->id)->get()->keyBy('id')->toArray();

                $body .= '
                <tr>
                    <td class="border-td">' . $inscription->apprenant->user->nom . ' ' . $inscription->apprenant->user->prenom . '</td>
                ';
                foreach ($competences as $key => $competence) {
                    foreach ($competence->elementCompetences as $ec) {
                        foreach ($ec->criteres as $critereKey => $critere) {
                            $findRow = null;
                            foreach ($evaluations as $evaluation) {
                                if ($evaluation['inscription_id'] == $inscription->id && $evaluation['critere_id'] == $critere->id) {
                                    $findRow = $evaluation;
                                    break;
                                }
                            }
                            if ($findRow) {
                                if ($findRow['acquis'])
                                    $body .= '<td class="border-td" align="center">A</td>';
                                elseif ($findRow['nonAcquis'])
                                    $body .= '<td class="border-td" align="center">NA</td>';
                            } else {
                                $body .= '<td class="border-td"></td>';
                            }
                        }
                    }
                }
                $body .= '
                </tr>
                ';
            }

            $body .= '
            </table>
            ';

            $start += 3;
        }

        $legende = '
        <div class="main-legend break" >
            <p align="center" class="bold-exo font-md">Légende</p><hr>
            <div class="legend-col" >
                <ul class="legende">';
        //Determiner la moyenne par colonne
        $limitBreak = intdiv(sizeof($legendes), 3);
        foreach ($legendes as $cleLegend => $legend) {
            $legende .= $legend;

            // Faire vérification pour passer à la deuxième colonne si nécessaire
            if ($cleLegend == ($limitBreak - 1)) {
                $legende .= '
                </ul>
                </div>
                <div class="legend-col">
                <ul class="legende">
                ';
            }

            // Faire vérification pour passer à la troisième colonne si nécessaire
            if ($cleLegend == ((2 * $limitBreak) - 1)) {
                $legende .= '
                </ul>
                </div>
                <div class="legend-col">
                <ul class="legende">
                ';
            }
        }
        $legende .= '</ul>
        </div><hr>';

        $entete = "Classe : " . $inscriptions[0]->classe->libelle .
            "<br><span>Niveau d'étude : " . $inscriptions[0]->classe->niveau_etude->libelle . "</span>
        <br><span>Métier : " . $inscriptions[0]->classe->niveau_etude->metier->libelle . "</span>
        <br><span>Année académique : " . $inscriptions[0]->classe->annee_academique->annee1 . " - " . $inscriptions[0]->classe->annee_academique->annee2 . "</span>";
        $template = file_get_contents('classe_competence.html');
        $template = str_replace('[BODY]', $body, $template);
        $template = str_replace('[LEGENDE]', $legende, $template);
        $template = str_replace('[DATE]', date('d/m/Y'), $template);
        $template = str_replace('[USER]', $entete, $template);
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->setFontCache(storage_path('fonts'));
        $options->set('isRemoteEnabled', true);
        $options->set('pdfBackend', 'CPDF');
        $options->setChroot([
            '/',
            storage_path('fonts'),
        ]);

        $dompdf->loadHTML($template);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $nom = 'Carnet_de_competence_classe.pdf';
        $dompdf->stream($nom, array("Attachment" => false));

    }

public function generateCompetencePdf(string $id)
{
    $semestre = session()->get('selectedsemestre');

    $inscription = Inscription::with(
        'apprenant',
        'classe.niveau_etude',
        'classe.annee_academique',
        'classe.etablissement'
    )->findOrFail($id);

    // Charger toutes les évaluations avec relations
    $evaluations = Evalute::with('critere.elementCompetence.competence')
        ->where('inscription_id', $inscription->id)
        ->when($semestre, fn($query) => $query->where('semestre', $semestre))
        ->get()
        ->keyBy('critere_id');

    $competencesGenerales = Competence::where('niveau_etude_id', $inscription->classe->niveau_etude_id)
        ->where('type', 'generale')
        ->with('elementCompetences.criteres')
        ->get();

    $competencesParticulieres = Competence::where('niveau_etude_id', $inscription->classe->niveau_etude_id)
        ->where('type', 'particuliere')
        ->with('elementCompetences.criteres')
        ->get();

    // Génération du tableau
    $generateTable = function($competencesType, $evaluations) {
        $html = '';

        foreach ($competencesType as $competence) {
            // Premier critère unique par compétence
            $critere = $competence->elementCompetences
                                  ->flatMap->criteres
                                  ->unique('id')
                                  ->first();

            if ($critere) {
                $evaluation = $evaluations[$critere->id] ?? null;

                $note = $evaluation?->note ?? null;
                $date = $evaluation?->date ? date('d-m-Y', strtotime($evaluation->date)) : '-';

                // 👉 Attribution automatique des observations
                $obs = '-';
                if ($note !== null) {
                    if ($note >= 0 && $note <= 10) {
                        $obs = 'Passable';
                    } elseif ($note >= 12 && $note <= 13) {
                        $obs = 'Assez bien';
                    } elseif ($note >= 14 && $note <= 16) {
                        $obs = 'Bien';
                    } elseif ($note >= 17 && $note <= 18) {
                        $obs = 'Très bien';
                    }
                }

                $html .= '<tr>';
                $html .= '<td class="border-td">'.htmlspecialchars($competence->nom).'</td>';
                $html .= '<td class="border-td">'.htmlspecialchars($critere->libelle).'</td>';
                $html .= '<td class="border-td" align="center">'.($note ?? '-').'</td>';
                $html .= '<td class="border-td" align="center">'.$date.'</td>';
                $html .= '<td class="border-td">'.htmlspecialchars($obs).'</td>';
                $html .= '</tr>';
            }
        }

        return $html;
    };

    $tableGenerale = '
    <tr>
        <td colspan="6" class="bold-exo" 
            style="background-color:#e0e0e0; text-align:center;">
            Compétences Générales
        </td>
    </tr>'
    . $generateTable($competencesGenerales, $evaluations);

    $tableParticulier = '
    <tr>
        <td colspan="6" class="bold-exo" 
            style="background-color:#e0e0e0; text-align:center;">
            Compétences Particulières
        </td>
    </tr>'
    . $generateTable($competencesParticulieres, $evaluations);

    // Injection dans le template
    $template = file_get_contents('competence.html');
    $template = str_replace('[BODY]', $tableGenerale . $tableParticulier, $template);

    setlocale(LC_TIME, 'fr_FR.UTF-8');
    $date = strftime('%e %B %Y');
    $template = str_replace('[DATE]', $date, $template);
    $template = str_replace('[USER]', $inscription->apprenant->nom . ' ' . $inscription->apprenant->prenom, $template);
    $template = str_replace('[DATENAISSANCE]', $inscription->apprenant->date_naissance, $template);
    $template = str_replace('[LIEUNAISSANCE]', $inscription->apprenant->lieu_naissance, $template);
    $template = str_replace('[TEL]', $inscription->apprenant->telephone, $template);
    $template = str_replace('[EMAIL]', $inscription->apprenant->email, $template);
    $template = str_replace('[SEMESTRE]', $semestre ? ($semestre == 1 ? '1' : '2') : 'Tous les semestres', $template);
    $template = str_replace('[MATRICULE]', $inscription->apprenant->matricule, $template);
    $template = str_replace('[CLASSE]', $inscription->classe->libelle ?? '', $template);
    $template = str_replace('[ANNEE]', $inscription->classe->niveau_etude->nom ?? '', $template);
    $template = str_replace('[ANNEESCOLAIRE]', $inscription->classe->annee_academique->code ?? '', $template);
    $template = str_replace('[EFPT]', $inscription->classe->etablissement->nom ?? '', $template);
    $template = str_replace('[EFPTTEL]', $inscription->classe->etablissement->telephone ?? '', $template);

    $dompdf = new Dompdf();
    $dompdf->getOptions()->set('isRemoteEnabled', true);
    $dompdf->loadHTML($template);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return response($dompdf->output(), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="Carnet_de_Competence.pdf"');
}













}
