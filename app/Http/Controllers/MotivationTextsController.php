<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateMotivationTextRequest;

class MotivationTextsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('motivations.texts.index');
    }
    public function indexData(){
         $motivations=\App\MotivationText::all();
         return response()->json($motivations);
    }
    public function store(CreateMotivationTextRequest $request){         
        $motivation=new \App\MotivationText();
        $motivation->name=$request->get('name');
        $motivation->description=$request->get('description');
        $motivation->save();
        return response()->json($motivation);
    }
    public function destroy($id)
    {
        $motivation=\App\MotivationText::findOrFail($id);
        $motivation->delete();
        return "Usuario eliminado";
    }
    public function update(Request $request, $id)
    {
         $validatedData = $request->validate([
         'name'=>'required|max:255|string|unique:motivation_texts,name,'.$id,            
        'description'=>'max:255'
        ]);
       $motivation=\App\MotivationText::findOrFail($id)->update($request->all());
       return response()->json($motivation);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
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
}
