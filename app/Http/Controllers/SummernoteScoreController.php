<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class SummernoteScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit');
        $summernotes=\App\Summernote::calificationReport($limit);
        $arraySummernotes = [];
        foreach ($summernotes as $summer)  {
            $summernote = \App\Summernote::find($summer->summernote_id);
            if($summernote){
                $summernote['prom'] = $summer->prom;
                $summernote['totalScore'] = $summer->totalCalifications;
                $summernote->genre;
                $summernote->user;
                $arraySummernotes [] = $summernote;
            }
        }
        return json_encode($arraySummernotes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //crea la calificacion de un libro
    {
        $idSummernote=$request->get('idSummernote');
        $score=$request->get('score');
        $user=Auth::user();
        $summernote=\App\Summernote::findOrFail($idSummernote);
        $userSum = \App\User::findOrFail($summernote->user_id);
        $this->authorize('different',$userSum);
        $summernote->scores_summernotes()->attach($user->id, ['score' => $score]);
        return json_encode($summernote);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idSummernote) ///calificacion del usuario que esta viendo el libro
    {
        $summernote=\App\Summernote::findOrFail($idSummernote);
        $user_summernote = \App\User::findOrFail($summernote->user_id);
        $user=Auth::user();
        // $this->authorize('different',$user_summernote); // solo autor pued editar
        $score=$summernote->scores_summernotes()->where('user_id',$user->id)->get();
        return json_encode($score);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404);
    }
}
