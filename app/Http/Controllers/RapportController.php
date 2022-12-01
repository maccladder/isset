<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rapport;
use App\Models\Agent;
use App\Models\History;
use App\Models\Total;
use DataTables;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use thiagoalessio\TesseractOCR\TesseractOCR;
// use App\Parser\PDF2Text;
use Smalot\PdfParser\Parser;
use Validator;

class RapportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        if(request()->ajax()) {

            $query =Rapport::query();

               $query->select([
                    'rapports.id',
                    'rapports.date',
                    'rapports.id_agent',
                    'rapports.nomcomplet',
                    'rapports.nbre_tf_impactes',
                    'rapports.nbre_inscription',
                    'rapports.nbre_tf_crees',
                    'is_matched'
                ]);

               /* $query->select([
                    'rapports.id',
                    'rapports.date',
                    'agents.name',
                    'rapports.nbre_tf_impactes',
                    'rapports.nbre_inscription',
                    'rapports.nbre_tf_crees',

                ])->join('agents', 'rapports.id_agent', '=', 'agents.id');*/



            return datatables()->of($query)
                ->addColumn('action', 'action_datatable')
                ->editColumn('action', 'rapport.actionTable')
                ->editColumn('date', 'rapport.actionDateAgent')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('rapport.list');
    }


    public function rapport_directeur(Request $request)
    {
 /*
        $search_agent = $request->get('search_id_agent');
        $search_date = explode(' - ', $request->input('search_id_date'));
*/


        if(request()->ajax()) {

            $query ="";

            $idagent = $request->id_agent;

            $optradio = $request->optradio;

            if ( $optradio == "day") {
                $from = $request->date;
                $to = $request->date;
            }else {
                $date = explode(' - ', $request->date);

                if(!empty($date[0])){

                    $from = $date[0];
                    $to = $date[1];
                }
                else{
                    $from = "";
                    $to = "";
                }
            }

            // if(empty($idagent)){
            //         $query =Rapport::query();
            //         //@dd($idagent);
            //         $query->select([
            //             'rapports.id',
            //             'rapports.date',
            //             'rapports.id_agent',
            //             'rapports.nomcomplet',
            //             'rapports.nbre_tf_impactes',
            //             'rapports.nbre_inscription',
            //             'rapports.nbre_tf_crees',
            //             'rapports.is_matched'
            //         ]);
            // }

            // if(!empty($idagent) && empty($from) && empty($to)){

            //     $query =Rapport::query();
            //     //@dd($idagent);
            //     $query->select([
            //         'rapports.id',
            //         'rapports.date',
            //         'rapports.id_agent',
            //         'rapports.nomcomplet',
            //         'rapports.nbre_tf_impactes',
            //         'rapports.nbre_inscription',
            //         'rapports.nbre_tf_crees',
            //         'rapports.is_matched'
            //     ])->where('id_agent',$idagent);
            // }

            // if(empty($idagent) && !empty($from) && !empty($to)){

            //     $query =Rapport::query();
            //     $query->select([
            //         'rapports.id',
            //         'rapports.date',
            //         'rapports.id_agent',
            //         'rapports.nomcomplet',
            //         'rapports.nbre_tf_impactes',
            //         'rapports.nbre_inscription',
            //         'rapports.nbre_tf_crees',
            //         'rapports.is_matched'
            //     ])->whereBetween('date', [date("Y-m-d",strtotime($from)), date("Y-m-d",strtotime($to))]);
            // }

            // if(!empty($idagent) && !empty($from) && !empty($to)){

            //     $query =Rapport::query();
            //     $query->select([
            //         'rapports.id',
            //         'rapports.date',
            //         'rapports.id_agent',
            //         'rapports.nomcomplet',
            //         'rapports.nbre_tf_impactes',
            //         'rapports.nbre_inscription',
            //         'rapports.nbre_tf_crees',
            //         'rapports.is_matched'                  
            //     ])->where('id_agent',$idagent)->whereBetween('date', [date("Y-m-d",strtotime($from)), date("Y-m-d",strtotime($to))]);
            // }

            $query =Rapport::query();
            $query->select([
                        'rapports.id',
                        'rapports.date',
                        'rapports.id_agent',
                        'rapports.nomcomplet',
                        'rapports.nbre_tf_impactes',
                        'rapports.nbre_inscription',
                        'rapports.nbre_tf_crees',
                        'rapports.is_matched'                  
            ]);

            if(!empty($from) && !empty($to)){
                $query = $query->whereBetween('date', [date("Y-m-d",strtotime($from)), date("Y-m-d",strtotime($to))]);
            }

            if ( empty($from) )
                $from = now();

            $getData = DB::table('agents')                
                ->leftjoinSub($query, 'services', 'services.id_agent', '=', 'agents.id')
                ->select('services.id', DB::raw("COALESCE(services.date, '$from') as date"),'services.id_agent', DB::raw('concat(agents.name, " ", agents.prenom) as name'), DB::raw('COALESCE(services.nbre_tf_impactes, 0) as nbre_tf_impactes'), DB::raw('COALESCE(services.nbre_inscription, 0) as nbre_inscription'), DB::raw('COALESCE(services.nbre_tf_crees, 0) as nbre_tf_crees'), 'services.is_matched');

                if(!empty($idagent)){
                    $getData = $getData->where('agents.id', $idagent);
                }
            
            return datatables()->of($getData->get())
                ->editColumn('date', 'rapport-directeur.actionDateAgent')
                ->addIndexColumn()
                ->make(true);
        }
        return view('rapport-directeur.list');
    }



    public function rapport_export(Request $request)
    {

            $id_agent_export = $request->input('search_id_agent');
            $optradio = $request->input('optradio');
            if ( $optradio == "day" ) {
                $from = $request->input('search_id_date');
                $to = $request->input('search_id_date');
            }else {
                $date_export = explode(' - ', $request->input('search_id_date'));
                
                if(!empty($date_export[0])){

                    $from = $date_export[0];
                    $to = $date_export[1];
                }
                else{
                    $from = "";
                    $to = "";
                }
            }
            
            $nom_agent_complet = "";
            $nom_agent = "";
            $prenom_agent = "";

            

            $rapport_export = new Rapport();

            if(!empty($id_agent_export) && !empty($from) && !empty($to) ){

                $data_export = $rapport_export::where('id_agent',$id_agent_export)->whereBetween('date', [date("Y-m-d",strtotime($from)), date("Y-m-d",strtotime($to))])->orderBy('date', 'DESC')->get();
                $nom_agent = Agent::where('id', $id_agent_export)->pluck('name');
                $prenom_agent = Agent::where('id', $id_agent_export)->pluck('prenom');

                $nom_agent_complet = $nom_agent[0].' '.$prenom_agent[0];

            }
            elseif(!empty($id_agent_export) && empty($from) && empty($to)){


                $data_export = $rapport_export::where('id_agent',$id_agent_export)->orderBy('date', 'DESC')->get();
                $nom_agent = Agent::where('id', $id_agent_export)->pluck('name');
                $prenom_agent = Agent::where('id', $id_agent_export)->pluck('prenom');

                $nom_agent_complet = $nom_agent[0].' '.$prenom_agent[0];


            }
            elseif(empty($id_agent_export) && !empty($from) && !empty($to)){


                $data_export = $rapport_export::whereBetween('date', [date("Y-m-d",strtotime($from)), date("Y-m-d",strtotime($to))])->orderBy('date', 'DESC')->get();


            }
            elseif(empty($id_agent_export) && empty($from) && empty($to)){


                $data_export = $rapport_export::orderBy('date', 'DESC')->get();


            }

        return view('rapport-directeur.excel', compact('data_export'))->with('from',$from)->with('to',$to)->with('nom_agent_complet',$nom_agent_complet);
    }



    public function details(Request $request){

        $list_rapport = Rapport::find($request->id);
        return view('rapport.details', compact('list_rapport'));

    }


    public function modifier(Request $request){

        $modifier_rapport = Rapport::find($request->input('id_rapport'));

        list($nbre_tf_impactes, $nbre_inscription, $nbre_tf_crees, $is_matched, $is_sameOCR) = $this->ocr_values($request, $modifier_rapport->screenshot);

        $nom_agent = Agent::where('id', $request->input('id_agent'))->pluck('name');
        $prenom_agent = Agent::where('id', $request->input('id_agent'))->pluck('prenom');

        $nom_agent_complet = $nom_agent[0].' '.$prenom_agent[0];

        // $this->addHistory(1, $request->input('date')." | ".$request->input('id_agent')." | ".$nbre_tf_impactes." | ".$nbre_inscription." | ".$nbre_tf_crees);
        $this->addHistory(1, "modification de rapport");

        $modifier_rapport->update([
            'date' => date("Y-m-d", strtotime($request->input('date'))),
            'id_agent' => $request->input('id_agent'),
            'nomcomplet' => $nom_agent_complet,
            'nbre_tf_impactes' => $nbre_tf_impactes,
            'nbre_inscription' => $nbre_inscription,
            'nbre_tf_crees' => $nbre_tf_crees,
            'is_matched' => $is_matched
        ]);

        return redirect()->back();//redirect('/rapports')->with('success','Informations modifiés avec succes');

    }

    protected function extractFromPDF($filename) {

        $pdfParser = new Parser();
        $pdf = $pdfParser->parseFile(public_path("Image/$filename"));
        $content = str_replace("\t", "", $pdf->getText());

        $pattern = "/[0-9]+/";
        preg_match_all($pattern, $content, $matches);

        // dd($matches);

        $len = count($matches[0]);

        if ( $len == 0 )
            return array(0,0,0);

        if ( $len == 7 ) {
            return array($matches[0][0].'-'.$matches[0][1].'-'.$matches[0][2], $matches[0][3], $matches[0][4], $matches[0][5], $matches[0][6]);
        }else if ( $len == 6 ){
            return array($matches[0][0].'-'.$matches[0][1].'-'.$matches[0][2], $matches[0][3], $matches[0][4], $matches[0][5]);
        }else {
            return array($matches[0][0], $matches[0][1], $matches[0][2]);
        }
    }

    protected function extractFromImage($filename) {
        $ocr = new TesseractOCR(public_path("Image/$filename"));
        $ocr->setOutputFile(public_path("output.txt"))->allowlist(range(0, 9),'-');
        $ocr_text = $ocr->run();
        
        return preg_split('/[\s]+/', $ocr_text);
    }

    protected function isAvailableRecognizedFile($filename) {
        return $this->isPDF($filename) || $this->isImage($filename);
    }

    protected function isPDF($filename) {
        $ext = $this->getExtensionFrom($filename);
        return strcmp('pdf', $ext) == 0;
    }

    protected function isImage($filename) {
        $ext = $this->getExtensionFrom($filename);

        return strcmp('png', $ext) == 0 || strcmp('jpg', $ext) == 0;
    }

    protected function getExtensionFrom($filename) {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        return strtolower($ext);
    }

    //image ocr
    protected function ocr_values($request, $filename)
    {
        $id_agent = $request->input('id_agent');
        $save_date = $request->input('date');
        $nbre_tf_impactes = $request->input('nbre_tf_impactes');
        $nbre_inscription = $request->input('nbre_inscription');
        $nbre_tf_crees = $request->input('nbre_tf_crees');

        try {            
            $segments = $this->isPDF($filename) ? $this->extractFromPDF($filename) :$this->extractFromImage($filename);

            $isSameDate = false;
            $isSameScreenshot = false;
            
            $lengthOfOCR = count($segments);

            if ( $lengthOfOCR > 3 ){
                $input_date =  date("d-m-Y", strtotime($save_date)); 
                $ocr_date =  date("d-m-Y",strtotime($segments[0]));

                $isSameDate = $input_date == $ocr_date;
            }

            if ( $lengthOfOCR == 5 ) {                
                $query = Rapport::where('date', date("Y-m-d", strtotime($segments[0])))
                    ->where('id_agent', $segments[1])
                    ->where('nbre_tf_impactes', $segments[2])
                    ->where('nbre_inscription', $segments[3])
                    ->where('nbre_tf_crees', $segments[4])
                    ->first();

                $isSameScreenshot = is_null($query) ? false: true;
                $is_matched = $isSameDate == true && $id_agent == $segments[1] && $nbre_tf_impactes == $segments[2] && $nbre_inscription == $segments[3] && $nbre_tf_crees == $segments[4];
            }else if ( $lengthOfOCR == 4 ){

                $query = Rapport::where('date', date("Y-m-d", strtotime($segments[0])))
                ->where('nbre_tf_impactes', $segments[1])
                ->where('nbre_inscription', $segments[2])
                ->where('nbre_tf_crees', $segments[3])
                ->first();

                $isSameScreenshot = is_null($query) ? false: true;
                $is_matched = $isSameDate == true && $nbre_tf_impactes == $segments[1] && $nbre_inscription == $segments[2] && $nbre_tf_crees == $segments[3];
            }else{

                $query = Rapport::where('nbre_tf_impactes', $segments[0])
                ->where('nbre_inscription', $segments[1])
                ->where('nbre_tf_crees', $segments[2])
                ->first();
                $isSameScreenshot = is_null($query) ? false: true;
                $is_matched = $nbre_tf_impactes == $segments[0] && $nbre_inscription == $segments[1] && $nbre_tf_crees == $segments[2];
            }

            // dd($id_agent,$segments[1]);

            return array($nbre_tf_impactes, $nbre_inscription, $nbre_tf_crees, $is_matched, $isSameScreenshot);

        }catch (Exception $e){}

        return array($nbre_tf_impactes, $nbre_inscription, $nbre_tf_crees, 0, $isSameScreenshot);
    }

    protected function register_rapport(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required'],
            'id_agent' => ['required'],
            'nbre_tf_impactes' => ['required'],
            'nbre_inscription' => ['required'],
            'nbre_tf_crees' => ['required'],
        ],
            [
                'date.required' => 'Le champ date est obligatoire.',
                'id_agent.required' => 'Ce champ obligatoire.',
                'nbre_tf_impactes.required' => 'Ce champ obligatoire.',
                'nbre_inscription.required' => 'Ce champ obligatoire.',
                'nbre_tf_crees.required' => 'Ce champ obligatoire.',
            ]);

        $rapport_verif = new Rapport();
        $verif = $rapport_verif::where('date',date("Y-m-d",strtotime($request->input('date'))))->where('id_agent',$request->input('id_agent'))->get();

        if(count($verif) > 0 ){

            return redirect('/rapports')->with('error','Vous avez déja enregistrer un rapport pour cet agent a cette date');

        }elseif(date("Y-m-d",strtotime($request->input('date'))) > date("Y-m-d",time())){

            return redirect('/rapports')->with('error','Imposssible d\'ajouter un rapport pour la date selectionner');

        }else{

            // $val1=$request->input('nbre_tf_impactes');
            // $val2=$request->input('nbre_inscription');
            // $val3=$request->input('nbre_tf_crees');

            // if(empty($request->input('nbre_tf_impactes'))){
            //     $val1=0;
            // }

            // if(empty($request->input('nbre_inscription'))){
            //     $val2=0;
            // }

            // if(empty($request->input('nbre_tf_crees'))){
            //     $val3=0;
            // }

            $nom_agent = Agent::where('id', $request->input('id_agent'))->pluck('name');
            $prenom_agent = Agent::where('id', $request->input('id_agent'))->pluck('prenom');

            $nom_agent_complet = $nom_agent[0].' '.$prenom_agent[0];

            //$data= new Rapport();

        $filename = "";
        if($request->file('screenshot'))
        {
            $file= $request->file('screenshot');
            $filename= date('YmdHi').$file->getClientOriginalName();

            if ( !$this->isAvailableRecognizedFile($filename) )
                return redirect('/rapports')->with("error","Uploaded data is incorrect(.pdf, .png, .jpg only)!");

            $file-> move(public_path('Image'), $filename);
            //$data['screenshot']= $filename;
        }

        //compare numbers : screenshot
        list($nbre_tf_impactes, $nbre_inscription, $nbre_tf_crees, $is_matched, $is_sameOCR) = $this->ocr_values($request, $filename);

        if ( $is_sameOCR ){

            //remove uploaded file when its same
            if ( file_exists(public_path('Image/'.$filename)))
                unlink(public_path('Image/'.$filename));

            return redirect('/rapports')->with("error","Capture d'écran déjà existante dans le système!Echec d'enregistrement du rapport!");
        }
        // $this->addHistory(0, $request->input('date')." | ".$request->input('id_agent')." | ".$nbre_tf_impactes." | ".$nbre_inscription." | ".$nbre_tf_crees);
        $this->addHistory(0, " Création de nouveau rapport");

        $create =  Rapport::create([
            'date' => date("Y-m-d", strtotime($request->input('date'))),
            'id_agent' => $request->input('id_agent'),
            'id_user' => $request->input('id_user'),
            'nomcomplet' => $nom_agent_complet,
            'nbre_tf_impactes' => $nbre_tf_impactes,
            'nbre_inscription' => $nbre_inscription,
            'nbre_tf_crees' => $nbre_tf_crees,
            'date_save' => date("Y-m-d", strtotime($request->input('date_save'))),
            'screenshot'=> $filename,
            'is_matched' => $is_matched
        ]);

            // $data->save();

            return redirect('/rapports')->with('success','Rapport enregistré avec succes');
        }

    }

    public function delete(Request $request)
    {
        $agent = Rapport::where('id',$request->id);

        $this->addHistory(2, " Suppression de rapport");
        
        $agent->delete();

        return Response()->json($agent);
    }


    public function notifications()    
    {
        if(request()->ajax()) {

            $query =Rapport::query();

               $query->select([
                    'rapports.id',
                    'rapports.date',
                    'rapports.id_agent',
                    'rapports.nomcomplet',
                    'rapports.nbre_tf_impactes',
                    'rapports.nbre_inscription',
                    'rapports.nbre_tf_crees',
                    'is_matched'
                ])->where('is_matched',0);

              
            return datatables()->of($query)
                ->addColumn('action', 'action_datatable')
                ->editColumn('action', 'rapport.actionTable')
                ->editColumn('date', 'rapport.actionDateAgent')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('notification');
    }

    public function histories(Request $request) {

        if(request()->ajax()) {
            $fileds = ['id', 'name','type','log', 'created_at'];
            $type = $request->id_agent;
            $date = explode(' - ', $request->date);

            $from = "";
            $to = "";

            $query = History::query();

            if(!empty($date[0])){
                
                $from = $date[0];
                $to = $date[1];

                if ( !is_null($type) ){
                    $query->select($fileds)->whereBetween('created_at', [date("Y-m-d 00:00:00",strtotime($from)), date("Y-m-d 23:59:59",strtotime($to))])->where('type', $type);
                }else {
                    $query->select($fileds)->whereBetween('created_at', [date("Y-m-d 00:00:00",strtotime($from)), date("Y-m-d 23:59:59",strtotime($to))]);
                }
            }else {
                
                if ( !is_null($type) ){                    
                    $query->select($fileds)->where('type', $type);
                }else {
                    $query->select($fileds);
                }
            }

            return datatables()->of($query)
                ->addColumn('action', function($q){
                    return "<a style='color:red' href=\"javascript:void(0);\" onclick=\"deleteFuncHistory($q->id)\"><i class=\"fa fa-close\"></i></a>";
                })
                ->make(true);
        }
        return view('history');
    }

    // type : 0 => new, 1 => edit, 2 => delete
    private function addHistory($type, $msg) {        
        History::create([
            'name' => Auth::user()->name,
            'type' => $type,
            'log' => $msg
        ]);
    }

    public function del_history(Request $request) {
        $his = History::find($request->id);
        $his->delete();
        return Response()->json($his);
    }   
    
    public function totalPdfs(Request $request) {
        if(request()->ajax()) {

            $query =Total::query();

               $query->select([
                    'id',
                    'time',
                    'nbre_tf_impactes',
                    'nbre_inscription',
                    'nbre_tf_crees',
                ])->where('time', Carbon::now()->format('Y-m-d'));
              
            return datatables()->of($query)
                ->addColumn('action', function($q){
                    return "<a href='total/$q->id/screenshot' class='btn-success link-padding' data-toggle='popover' data-trigger='hover' data-placement ='right' title='Cliquez pour voir la capture'><i class='fa fa-camera'></i></a>";
                })
                ->addIndexColumn()
                ->make(true);
        }

        $nbre_tf_impactes = Rapport::where('date', '<=', Carbon::now()->format('Y-m-d'))->sum('nbre_tf_impactes');
        $nbre_inscription = Rapport::where('date', '<=', Carbon::now()->format('Y-m-d'))->sum('nbre_inscription');
        $nbre_tf_crees = Rapport::where('date', '<=', Carbon::now()->format('Y-m-d'))->sum('nbre_tf_crees');

        return view('totals', [
                                'nbre_tf_impactes' => $nbre_tf_impactes,
                                'nbre_inscription' => $nbre_inscription,
                                'nbre_tf_crees' => $nbre_tf_crees,
                            ]);
    }

    public function uploadTotalFile(Request $request){
        $data = array();

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:pdf|max:2048'
         ]);
   
         if ($validator->fails()) {
            $data['success'] = 0;
            $data['message'] = " Please upload only PDF file";// Error response
        }else {
            if($request->file('file')) {
                $file = $request->file('file');
                $filename= date('YmdHi').$file->getClientOriginalName();

                $file-> move(public_path('Image'), $filename);

                $segments = $this->extractFromPDF($filename);
                
                $isSameDate = false;
                $isSameScreenshot = false;
                
                $lengthOfOCR = count($segments);

                if ( $lengthOfOCR > 3 ){
                    
                    $ocr_date =  date("d-m-Y",strtotime($segments[0]));
                    $today = Carbon::now();

                    if ( !$today->isSameDay(Carbon::parse($segments[0]))){

                        if ( file_exists(public_path('Image/'.$filename)))
                            unlink(public_path('Image/'.$filename));

                        $data['success'] = 2;
                        $data['message'] = ' The PDF date is incorrect. Not today!!! '; 

                        return response()->json($data);
                    }

                    $query = Total::where('time', date("Y-m-d", strtotime($segments[0])))->first();
                    if ( !is_null($query) ){
                        $data['success'] = 2;
                        $data['message'] = ' You already uploaded '; 

                        if ( file_exists(public_path('Image/'.$filename)))
                            unlink(public_path('Image/'.$filename));
                    }else {
                        Total::create([
                            'time'=> date("Y-m-d", strtotime($segments[0])),
                            'nbre_tf_impactes'=>$segments[1],
                            'nbre_inscription'=>$segments[2],
                            'nbre_tf_crees'=>$segments[3],
                            'screenshot'=>$filename
                        ]);

                        $data['success'] = 1;
                        $data['message'] = 'Uploaded Successfully!';
                    }
                }else {
                    $data['success'] = 2;
                    $data['message'] = ' Incorrect PDF! '; 
                }
            }else {
                $data['success'] = 0;
                $data['message'] = 'File not uploaded.'; 
            }
        }

        return response()->json($data);
    }
}




