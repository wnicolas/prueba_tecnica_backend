<?php

namespace App\Http\Controllers;

use App\Models\Cuadrangular;
use App\Models\Equipo;
use App\Models\Partido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuadrangularController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cuadrangulares = null;
        try {
            DB::transaction(function () use (&$cuadrangulares) {
                $cuadrangulares = Cuadrangular::all();
            });
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
        return response()->json(['message' => 'success', 'data' => $cuadrangulares], 200);
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
        $cuadrangular = null;

        try {
            DB::transaction(function () use (&$cuadrangular, $request) {
                $cuadrangular = Cuadrangular::create();

                // Registra los equipos en la base de datos
                $equipos = json_decode($request["equipos"]);
                $teams = array();
                foreach ($equipos as $equipo) {
                    $eq = DB::select('SELECT * FROM equipos WHERE nombre=?', [$equipo->nombre]);
                    if (!$eq) {
                        $eq = Equipo::create([
                            "nombre" => $equipo->nombre
                        ]);
                    }
                    $p = DB::select('SELECT * FROM equipos WHERE nombre=?', [$equipo->nombre]);
                    array_push($teams, $p[0]->id);
                }

                //Crea los partidos
                for ($i = 0; $i < count($teams) - 1; $i++) {
                    for ($j = $i + 1; $j < count($teams); $j++) {
                        Partido::create([
                            "id_local" => $teams[$i],
                            "id_visitante" => $teams[$j],
                            "goles_local" => 0,
                            "goles_visitante" => 0,
                            "fecha" => '2022-08-07',
                            "id_cuadrangular" => $cuadrangular->id
                        ]);
                    }
                }
            });
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
        return response()->json(['message' => 'success', 'data' => $cuadrangular], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $partidos = null;
        try {
            DB::transaction(function () use ($id, &$partidos) {
                $partidos = DB::select('SELECT *,p.id "id_partido" FROM partidos p,cuadrangulares c WHERE p.id_cuadrangular=c.id AND c.id=?', [$id]);
            });
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
        return response()->json(['message' => 'success', 'data' => $partidos], 200);
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
        //
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
