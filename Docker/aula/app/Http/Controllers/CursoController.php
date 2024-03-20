<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CursoRepository;
use App\Repositories\EixoRepository;
use App\Repositories\NivelRepository;
use App\Models\Curso;

class CursoController extends Controller {

    protected $repository;
   
    public function __construct(){
       $this->repository = new CursoRepository();
    }

    public function index() {
        $data = $this->repository->selectAllWith(['eixo', 'nivel']);
        return view('cursos.index', compact('data'));
        // return $data;
    }

    public function create() {

        $eixos = (new EixoRepository())->selectAll();
        $niveis = (new NivelRepository())->selectAll();
        return view('cursos.create', compact(['eixos', 'niveis']));
    }

    public function store(Request $request) {

        $objEixo = (new EixoRepository())->findById($request->eixo_id);
        $objNivel = (new NivelRepository())->findById($request->nivel_id);

        if(isset($objEixo) && isset($objNivel)) {
            $obj = new Curso();
            $obj->nome = mb_strtoupper($request->nome, 'UTF-8');
            $obj->sigla = mb_strtoupper($request->sigla, 'UTF-8');
            $obj->total_horas = $request->horas;
            $obj->eixo()->associate($objEixo);
            $obj->nivel()->associate($objNivel);
            $this->repository->save($obj);
            return redirect()->route('cursos.index');
        }
        
        return view('message')
                    ->with('template', "main")
                    ->with('type', "danger")
                    ->with('titulo', "OPERAÇÃO INVÁLIDA")
                    ->with('message', "Não foi possível efetuar o registro!")
                    ->with('link', "cursos.index");
    }

    public function show(string $id) {
        $data = $this->repository->findByIdWith(['eixo', 'nivel'], $id);
        return view('cursos.show', compact('data'));
        // return $data;
    }   

    public function edit(string $id) {
        $data = $this->repository->findById($id);
        $eixos = (new EixoRepository())->selectAll();
        $niveis = (new NivelRepository())->selectAll();
        return view('cursos.edit', compact(['data', 'eixos', 'niveis']));
    }

    public function update(Request $request, string $id) {
        
        $obj = $this->repository->findById($id);
        $objEixo = (new EixoRepository())->findById($request->eixo_id);
        $objNivel = (new NivelRepository())->findById($request->nivel_id);
        
        if(isset($obj) && isset($objEixo) && isset($objNivel)) {
            $obj->nome = mb_strtoupper($request->nome, 'UTF-8');
            $obj->sigla = mb_strtoupper($request->sigla, 'UTF-8');
            $obj->total_horas = $request->horas;
            $obj->eixo()->associate($objEixo);
            $obj->nivel()->associate($objNivel);
            $this->repository->save($obj);
            return redirect()->route('cursos.index');
        }

        return view('message')
                    ->with('template', "main")
                    ->with('type', "danger")
                    ->with('titulo', "OPERAÇÃO INVÁLIDA")
                    ->with('message', "Não foi possível efetuar o registro!")
                    ->with('link', "cursos.index");
    }

    public function destroy(string $id) {
        if($this->repository->delete($id))  {
            return redirect()->route('cursos.index');
        }
        
        return view('message')
                    ->with('template', "main")
                    ->with('type', "danger")
                    ->with('titulo', "OPERAÇÃO INVÁLIDA")
                    ->with('message', "Não foi possível efetuar o registro!")
                    ->with('link', "cursos.index");
    }
}
