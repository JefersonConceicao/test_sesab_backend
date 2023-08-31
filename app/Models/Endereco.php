<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $table = 'enderecos';
    protected $fillable = [
        'cep',
        'nome_logradouro',
        'bairro',
        'municipio',
        'user_id'
    ];

    public $timestamps = true;

    public function salvaEnderecoDoUsuario(User $user, array $request = [])
    {
        try{
            $endereco = self::where('cep', '=', $request['cep'])->first();

            if(empty($endereco)){
                $endereco = $this;
            }

            if(!$endereco->fill($request)->save()){
                throw new \Exception();
            }

            if(!$user->enderecos()->where('endereco_id', $endereco->id)->exists()){
                $user->enderecos()->attach([$endereco->id]);
            }

            return true;
        }catch(Exception $error){
            return false;
        }
    }

    public function removeEnderecoDoUsuario(User $user, Endereco $endereco)
    {
        return $user->enderecos()->detach([$endereco->id]);
    }
}
