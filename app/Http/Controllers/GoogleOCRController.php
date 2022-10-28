<?php



namespace App\Http\Controllers;

require 'C:\wamp64\www\Projet-Isset\isset\vendor\autoload.php';

// require 'C:\wamp64\www\Projet-Isset\isset\vendor\google\auth\autoload.php';

use Illuminate\Http\Request;
use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Likelihood;







class GoogleOCRController extends Controller
{
    
    public function index()
    {
        return view('googleOcr');
    }

    public function submit(Request $request)
    {
        if($request->file('image')) 
        
        {

            

            putenv("GOOGLE_APPLICATION_CREDENTIALS=C:\wamp64\www\Projet-Isset\ocrproject-363112-a29fab502542.json");

            // convert to base64
            $image = base64_encode(file_get_contents($request->file('image')));

            $client = new ImageAnnotatorClient();
            $client->Likelihood($image);
            $client->setImage($image);
            $client->setFeature("TEXT_DETECTION");

            $google_request = new GoogleCloudVision([$client],  env('GOOGLE_CLOUD_KEY'));

            $response = $google_request->annotate();

            dd($response);
        }
    }
}

