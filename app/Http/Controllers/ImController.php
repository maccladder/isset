<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;

class ImController extends Controller


{
    
    public function index()
    
    {
   
   return view('imhome');
    }
 
    public function upload(Request $request){
 
        $image = $request->file('image');
        $filename= date('YmdHi').$image->getClientOriginalName();
        $image-> move(public_path('Ocr'), $filename);
    
        $ocr = new TesseractOCR(public_path("Ocr/$filename"));
   
        $ocr->allowlist(range(0, 9),'/');
        
        $text = $ocr->run();
    
        return redirect()->back()->with('text',$text);

     
    
 
     
 
    }

}
