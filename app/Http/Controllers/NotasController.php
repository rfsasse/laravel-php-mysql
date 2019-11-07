<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aluno;
use App\Nota;
class NotasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request, $id)
    {
        $aluno = Aluno::with('notas')->find($id);
        return $aluno;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        if(!$aluno = Aluno::find($id))
            return response()->json(['error'=>'Aluno informado não encontrado!'], 404);

        return $aluno->notas()->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($aluno_id,$nota_id)
    {
        $aluno = Aluno::With(['notas'=> function ($query) use ($nota_id){
            $query->where('id',$nota_id);
        }])->find($aluno_id);
        return $aluno;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $aluno_id,$nota_id)
    {
        if(!$aluno = Aluno::find($aluno_id))
            return response()->json(['error'=>'Aluno informado não encontrado!'], 404);

        if(!$nota = $aluno->notas()->find($nota_id))
            return response()->json(['error'=>'Aluno informado não encontrado!'], 404);

        $nota->update($request->only('materia','nota'));

        return $nota;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($aluno_id,$nota_id)
    {
        if(!$aluno = Aluno::find($aluno_id))
            return response()->json(['error'=>'Aluno informado não encontrado!'], 404);

        if(!$nota = $aluno->notas()->find($nota_id))
            return response()->json(['error'=>'Aluno informado não encontrado!'], 404);

        $nota->delete();


    }
}
