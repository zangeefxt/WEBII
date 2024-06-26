<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EixoRepository;
use App\Models\Eixo;

class EixoController extends Controller
{
    
    protected $repository;
   
    public function __construct(){
        $this->repository = new EixoRepository();

    
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->repository->selectAll();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $Eixo = new Eixo();
        $Eixo->nome = mb_strtoupper($request->nome, "UTF8");
        $this->repository->save($Eixo);

        return "OK - STORE";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->repository->findById($id);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $objEixo = $this->repository->findById($id);

        if(isset($objEixo)){
            $objEixo->nome = mb_strtoupper($request->nome, "UTF8");
            $this->repository->save($objEixo);

            return "OK - UPDATE";
        }

        return "ERRO - UPDATE";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($this->repository->delete($id)){
            return "OK - DELETE";
        }

        return "NO - DELETE";
    }
}
