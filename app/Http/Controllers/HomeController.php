<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index ()
    {
        return view('home');
    }
    public function indexData(){
        $count = $this->verifyResults(1);
        $limit = 10 + $count;
        $califications = \App\Summernote::calification($limit);
        $summernotesCalifications=$this->summernotes($califications, 1);

        $count = $this->verifyResults(2);
        $limit = 10 + $count;
        $globalViews = \App\Summernote::globalViews($limit);
        $summernotesGlobalViews=$this->summernotes($globalViews, 2);

        $count = $this->verifyResults(3);
        $limit = 10 + $count;
        $weekViews = \App\Summernote::weekViews($limit);
        $summernotesWeekViews=$this->summernotes($weekViews, 3);

        $results=[
            'califications' => $summernotesCalifications,
            'globalViews' => $summernotesGlobalViews,
            'weekViews' => $summernotesWeekViews,
        ];
        return json_encode($results);
    }
     
    public function verifyResults($item){
        $results = [];
        switch ($item) {
            case 1:
                $results = \App\Summernote::calification(10);
                break;
            case 2:
               $results = \App\Summernote::globalViews(10);
                break;
            case 2:
                $results = \App\Summernote::weekViews(10);
        }
        $cont = 0;
        foreach ($results as $result ) {
            $summernote = \App\Summernote::find($result->idSummernote);
            if(count($summernote) == 0 || $summernote->private == 1){
                $cont ++;
            }
        }
        return $cont;
    }
    public function summernotes($summernotes ,$item ){
        $arraySummernotes=[];
        foreach ($summernotes as $summernoteData) {
            $summernote = \App\Summernote::find($summernoteData->idSummernote);
            if(count($summernote) != 0 && $summernote->private == 0){
                switch ($item) {
                    case 1:
                        $summernote['califications']=$summernoteData->totalCalifications;
                        $summernote['calification']=$summernoteData->prom; 
                        break;
                    default:
                        $summernote['views']=$summernoteData->totalViews;
                        break;
                }
                $summernote->genre;
                $summernote->categories;        
                if($summernote->existPictureSummernote($summernoteData->idSummernote)){
                    $route=asset('storage/coverText/'.$summernoteData->idSummernote);
                }else{
                    $route=asset('storage/coverText/default');
                }
                $summernote['route']=$route;
                array_push($arraySummernotes, $summernote);

                }
            
        }
        return  $arraySummernotes;
    }

   
}
