<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Summernote;
use Carbon\Carbon;

class SearchFiltersController extends Controller
{
   public function index()
   {
   	 return view('search');
   }
   public function show($data ){
   		return view('searchCategory',compact('data'));   	
   }
   public function indexData(){
      $summernotes=Summernote::all()->where('private', 0);
        $arraySummernotes=$this->summernotes($summernotes);         
        return response()->json($arraySummernotes);
    }
    public function filter(Request $request){
      //item
      // {id: 1, name: 'Autores y Libros'},
      // {id: 4, name: 'Frases'},
      $item  = $request->get('selectedItem_id');
      $input  = $request->get('inputSearch');
      $category  = $request->get('category_id');
      $genre  = $request->get('genre_id');  
        $users=[];     
      switch ($item) {
          case 1:
              $users=$this->filterUser($input);
            $summernotes=$this->filterSummernote($input , $category, $genre);                
              break;
          default:
              $summernotes= $this->filterPaper($input);
              break;
      } 
         
        $filterResult['Users']=$users;
        $filterResult['Summernotes']=$summernotes;
        return $filterResult;

    }
    //filtrar Autores
    function filterUser ($input){
      $users = \App\User::name($input)->orderBy('name')->get();
        $arrayUsers=[];
        foreach ($users as $user ) {            
            $user['route']=$user->existPicturePerfil($user->name_user,$user->sex);
            array_push($arrayUsers, $user);
        } 
      return $arrayUsers;
    }
    public function filterPaper($input){
        $arrayWords= explode(" ",$input);
        $inputModified = "";
        foreach ($arrayWords as $key => $word) {
          if($key == 0 && $word != ""){
             $inputModified .= "+".$word;
          }
          elseif ($word != ""){
            $inputModified .= " +".$word;
          }
        }
        $papers = \App\Paper::content($inputModified)->get();
        $arrayIdsSummernotes=[];
        $objects=[];
        if($papers){
            foreach ($papers as $paper) {
               // if(array_search('verde', $array))
                if(!in_array($paper->summernote_id, $arrayIdsSummernotes)){
                    $object=[
                        'idSummernote'=>$paper->summernote_id,
                        'idPaper'=>$paper->id,
                        'content'=>$paper->content
                    ];
                    array_push($objects, $object);
                    array_push($arrayIdsSummernotes, $paper->summernote_id);
                }
            }
        
        }
        $arraySummernotes=[];
        foreach ($objects as $object) {
            $summernote=\App\Summernote::find($object['idSummernote']);
            $papers= $summernote->papers;
            if($papers){
                for ($i=0; $i < count($papers); $i++) { 
                   if($papers[$i]['id'] == $object['idPaper']){
                         
                        $content= $object['idPaper'];
                         $summernote['paper'] = [
                            'number' => $i+1,
                            'id' => $object['idPaper'],
                            'content' => $object['content']
                         ]; 
                   }
                }
                unset($summernote['papers']);
            }
            
            if($summernote->existPictureSummernote($object['idSummernote'])){
                $route=asset('storage/coverText/'.$object['idSummernote']);
            }else{
                $route=asset('storage/coverText/default');
            }
            $summernote->categories;
            $genre = $summernote->genre;
             $summernote['genre']=$genre;
             $scores = $summernote->scores_summernotes;
            if(count($scores)){
                $average = $scores->avg(function ($score) {
                    return $score->pivot->score;
                });
            }
            else{
                $average = 0;
            }        
            $summernote['score'] = $average;
            $summernote['route']=$route;           
            $date=Carbon::parse($summernote->updated_at)->diffForHumans(); //calcular tiempo
            $summernote['date']=$date;

            // $summernote['paper']=$object['idPaper'];

            array_push($arraySummernotes, $summernote->toArray());
        }        
        return $arraySummernotes;
    }
    public function filterSummernote ($input , $category, $genre){
        $summernotes = \App\Summernote::
                name($input)->
                genre($genre)->
                categories($category)->                
                where('private', 0)->
                orderBy('name')->get(); 

        $arraySummernotes=$this->summernotes($summernotes); 
        return $arraySummernotes;
    }
    public function summernotes($summernotes){
         $arraySummernotes=[];
            foreach ($summernotes as $summernote ) {
                $idSummernote=$summernote['id'];   
                if($summernote->existPictureSummernote($idSummernote)){
                    $route=asset('storage/coverText/'.$idSummernote);
                }else{
                    $route=asset('storage/coverText/default');
                }
                $scores = $summernote->scores_summernotes;
              if(count($scores)){
                  $average = $scores->avg(function ($score) {
                      return $score->pivot->score;
                  });
              }
              else{
                  $average = 0;
              }        
              $summernote['score'] = $average;
                $categories=$summernote->categories;
                $summernote['route']=$route;
                $date=Carbon::parse($summernote->updated_at)->diffForHumans(); //calcular tiempo
                $summernote['date']=$date;
                $genre = $summernote->genre;
                $summernote['genre']=$genre;
                array_push($arraySummernotes, $summernote);
            }
        return $arraySummernotes;

    }
}
