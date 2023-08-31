<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfis';
    protected $fillable = [
        'nome_perfil',
        'flg_perfil_ativo'
    ];

    public $timestamps = true;

    public function getOptionsPerfis()
    {
        return $this->where('flg_perfil_ativo', '=', 1)->get();
    }
}
