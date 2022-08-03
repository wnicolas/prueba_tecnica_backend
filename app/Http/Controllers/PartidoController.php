<?php

namespace App\Http\Controllers;

use App\Models\Partido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partidos = null;
        try {
            DB::transaction(function () use (&$partidos) {
                $partidos = Partido::all();
            });
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
        return response()->json(['message' => 'success', 'data' => $partidos], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Partido::create([
                    "id_local" => $request->id_local,
                    "id_visitante" => $request->id_visitante,
                    "goles_local" => $request->goles_local,
                    "goles_visitante" => $request->goles_visitante,
                    "fecha" => $request->fecha,
                    "id_cuadrangular" => $request->id_cuadrangular
                ]);
            });
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        try {
            DB::transaction(function () use ($request, $id) {
                $partido = Partido::find($id);
                $partido->update([
                    "goles_local" => $request->goles_local,
                    "goles_visitante" => $request->goles_visitante,
                ]);
            });
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
