<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfil;

class PerfisController extends Controller
{
    private $perfil;

    public function __construct(Perfil $perfil){
        $this->perfil = $perfil;
    }

    public function listPerfis(){
        return response()->json($this->perfil->getOptionsPerfis());
    }
}
