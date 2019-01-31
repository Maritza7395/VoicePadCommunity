<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Contracts\Routing\ResponseFactory;
use DOMDocument;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\User;

class ExportsController extends Controller
{
	public function pdf($idSummernote){
         
	 	$summernote = \App\Summernote::findOrFail($idSummernote);
        $user = \App\User::findOrFail($summernote->user_id);
        $this->authorize('equal',$user);
	 	$papers = $summernote->papers;
	 	$content ='<style>
					.page-break {
					    page-break-after: always;
					}
					</style>';
	 	foreach ($papers as $paper) {	 		
	 		$content .= $paper->content;
	 		$content .= '<div class="page-break"></div>';
	 	}
	    $pdf = PDF::loadHTML($content);
	    return $pdf->download($summernote->name.'.pdf');
	}
    public function selectOptionUser($users){
        $data = [];
        if(!empty($users[0]['followCount'])){
            $data [] = 'Seguidores';
            $data [] = 'followCount';
        }
        elseif (!empty($users[0]['countSummernotes'] )) {
            $data [] = 'Libros';
            $data [] = 'countSummernotes';
        }
        return $data;
    }
    public function excelGenres(Request $request){
        $user=Auth::user();
        $title = $request->get('title');
        $nameExcel=$title.'_'.$user->name_user;
        Excel::create($nameExcel, function($excel) use ($request) {
            $genres = $request->get('genres');
            $title = $request->get('title');
            $excel->sheet('Generos', function($sheet) use ( $genres , $title){
                $sheet->row(2,['','','',$title]);
                $sheet->row(4, [
                    'Número', 'Nombre', 'Descripcion', (!empty($genres[0]['countGenre']) ? 'Utilizado' : ' '),'Fecha de Creación', 'Fecha de Actualización'
                ]); 
                foreach($genres as $index => $genre) {
                    $sheet->row($index+5, [
                        $genre['id'], $genre['name'],$genre['description'], (!empty($genre['countGenre']) ? $genre['countGenre'] : ' '), $genre['created_at'], $genre['updated_at']
                    ]); 
                }         
                // $sheet->fromArray($arrayUsers);
                $sheet->setOrientation('landscape');
            });
        })->store('xls', false, true);
        return response()->json($nameExcel);        

    }
    public function excelComplaintUsers(Request $request){
        $user=Auth::user();
        $title = $request->get('title');
        $nameExcel=$title.'_'.$user->name_user;
        Excel::create($nameExcel, function($excel) use ($request) {
            $users = $request->get('users');
            $title = $request->get('title');
            $arrayUsers=[];
            foreach ($users as $user ) {            
                unset($user['route']);
                $arrayUsers [] = $user;
            }   
            $excel->sheet('Denuncias Usuarios', function($sheet) use ($users, $arrayUsers , $title){
                $data = $this->selectOptionUser($arrayUsers);
                 $sheet->row(2,['','','',$title]);
                $sheet->row(4, [
                    'Número', 'Nombre', 'Nombre de Usuario', 'Denuncias', 'Email', 'Rol', 'Fecha de Creación', 'Fecha de Actualización'
                ]); 
                foreach($arrayUsers as $index => $user) {
                    $sheet->row($index+5, [
                        $user['id'], $user['name'],$user['name_user'], $user['motivations_count'] , $user['email'],($user['role_id'] == 1 ? 'Administrador' : 'Escritor '), $user['created_at'], $user['updated_at']
                    ]); 
                }         
                // $sheet->fromArray($arrayUsers);
                $sheet->setOrientation('landscape');
            });
        })->store('xls', false, true);
        return response()->json($nameExcel);        
    }
    public function excelComplaintSummernotes(Request $request){
        $user=Auth::user();
        $title = $request->get('title');
        $nameExcel=$title.'_'.$user->name_user;
        Excel::create($nameExcel, function($excel) use ($request) {
            $summernotes = $request->get('summernotes');
            $title = $request->get('title');            
            $excel->sheet('Denuncias Libros', function($sheet) use ( $summernotes , $title){          
                $data = $this->selectOptionSummernote($summernotes);
                $sheet->row(2,['','','',$title]);
                $sheet->row(4, [
                'Número', 'Titulo', 'Denuncias' ,'Sinopsis','Estado', 'Mayor +18', 'publico', 'genero','Fecha de Creación', 'Fecha de Actualización'
                ]); 
                foreach($summernotes as $index => $summernote) {
                    $sheet->row($index+5, [
                        $summernote['id'], $summernote['name'],$summernote['motivations_count'],$summernote['abstract'] ,($summernote['status'] == 0 ? 'En Proceso' : 'Terminado '),($summernote['rating'] == 0 ? 'No' : 'Si '), ($summernote['private'] == 0 ? 'Si' : 'No '),$summernote['genre']['name'],$summernote['created_at'], $summernote['updated_at']
                    ]); 
                } 
            });        
        })->store('xls', false, true);
        return response()->json($nameExcel);        
    }
    public function excelCategories(Request $request){
        $user=Auth::user();
        $title = $request->get('title');
        $nameExcel=$title.'_'.$user->name_user;
        Excel::create($nameExcel, function($excel) use ($request) {
            $categories = $request->get('categories');
            $title = $request->get('title');
            $excel->sheet('Categorias', function($sheet) use ( $categories , $title ){
                $sheet->row(2,['','','',$title]);
                $sheet->row(4, [
                    'Número', 'Nombre', 'Descripcion', (!empty($categories[0]['countGenre']) ? 'Utilizada' : ' '),'Fecha de Creación', 'Fecha de Actualización'
                ]); 
                foreach($categories as $index => $category) {
                    $sheet->row($index+5, [
                        $category['id'], $category['name'],$category['description'], (!empty($category['countGenre']) ? $category['countGenre'] : ' '), $category['created_at'], $category['updated_at']
                    ]); 
                }         
                // $sheet->fromArray($arrayUsers);
                $sheet->setOrientation('landscape');
            });
        })->store('xls', false, true);
        return response()->json($nameExcel);        

    }
	public function excelUser(Request $request){
	 	$user=Auth::user();
	 	$title = $request->get('title');
        $nameExcel=$title.'_'.$user->name_user;
        Excel::create($nameExcel, function($excel) use ($request) {
            $users = $request->get('users');
            $title = $request->get('title');
            $arrayUsers=[];
            foreach ($users as $user ) {            
	            unset($user['route']);
	            $arrayUsers [] = $user;
        	}   
            $excel->sheet('Usuarios', function($sheet) use ($users, $arrayUsers , $title ){
                $data = $this->selectOptionUser($arrayUsers);
                $sheet->row(2,['','','',$title]);
                $sheet->row(4, [
                    'Número', 'Nombre', 'Nombre de Usuario', (!empty($data[0]) ? $data[0] : ' '), 'Email', 'Rol', 'Fecha de Creación', 'Fecha de Actualización'
                ]); 
                foreach($arrayUsers as $index => $user) {
                    $sheet->row($index+5, [
                        $user['id'], $user['name'],$user['name_user'], (!empty($data[1]) ? $user[$data[1]] : ' ') , $user['email'],($user['role_id'] == 1 ? 'Administrador' : 'Escritor '), $user['created_at'], $user['updated_at']
                    ]); 
                }         
                // $sheet->fromArray($arrayUsers);
                $sheet->setOrientation('landscape');
            });
        })->store('xls', false, true);
        return response()->json($nameExcel);        
    }
    public function selectOptionSummernote($summernotes){
        $data = [];
        if(!empty($summernotes[0]['views'])){
            $data [] = 'visitas';
            $data [] = 'views';
        }
        elseif (!empty($summernotes[0]['prom'] )) {
            $data [] = 'calificacion';
            $data [] = 'calificaciones';
            $data [] = 'prom';
            $data [] = 'totalScore';
        }
        elseif (!empty($summernotes[0]['papers'] )) {
            $data [] = 'Hojas';
            $data [] = 'papers';
        }
        elseif (!empty($summernotes[0]['favorites'] )) {
            $data [] = 'Favoritos';
            $data [] = 'favorites';
        }
        return $data;
    }
     public function excelSummernote(Request $request){
	 	$user=Auth::user();
	 	$title = $request->get('title');
        $nameExcel=$title.'_'.$user->name_user;
        Excel::create($nameExcel, function($excel) use ($request) {
            $summernotes = $request->get('summernotes');
            $title = $request->get('title');
            $excel->sheet('Libros', function($sheet) use ( $summernotes , $title){          
                $data = $this->selectOptionSummernote($summernotes);
                $sheet->row(2,['','','',$title]);
                if(!empty($summernotes[0]['prom'] )){
                    $sheet->row(4, [
                    'Número', 'Titulo', (!empty($data[0]) ? $data[0] : ' '),(!empty($data[1]) ? $data[1] : ' '),'Sinopsis','Estado', 'Mayor +18', 'publico','Autor', 'genero','Fecha de Creación', 'Fecha de Actualización'
                    ]); 
                    foreach($summernotes as $index => $summernote) {
                        $sheet->row($index+5, [
                            $summernote['id'], $summernote['name'],$summernote['prom'],$summernote['totalScore'],$summernote['abstract'] ,($summernote['status'] == 0 ? 'En Proceso' : 'Terminado '),($summernote['rating'] == 0 ? 'No' : 'Si '), ($summernote['private'] == 0 ? 'Si' : 'No '),$summernote['user']['name_user'],$summernote['genre']['name'],$summernote['created_at'], $summernote['updated_at']
                        ]); 
                    }       
                }
                else{
                    $sheet->row(4, [
                    'Número', 'Titulo', (!empty($data[0]) ? $data[0] : ' '),'Sinopsis','Estado', 'Mayor +18', 'publico','Autor', 'genero','Fecha de Creación', 'Fecha de Actualización'
                    ]); 
                    foreach($summernotes as $index => $summernote) {
                        $sheet->row($index+5, [
                            $summernote['id'], $summernote['name'], (!empty($data[1]) ? $summernote[$data[1]] : ' '),$summernote['abstract'] ,($summernote['status'] == 0 ? 'En Proceso' : 'Terminado '),($summernote['rating'] == 0 ? 'No' : 'Si '), ($summernote['private'] == 0 ? 'Si' : 'No '),$summernote['user']['name_user'],$summernote['genre']['name'],$summernote['created_at'], $summernote['updated_at']
                        ]); 
                    } 
                }

                  
            });
        
        })->store('xls', false, true);
        return response()->json($nameExcel);        
    }
    public function excelDownload($nameExcel){
        return response()->download(storage_path('/exports/'.$nameExcel.'.xls'))->deleteFileAfterSend(true);
    }

}
