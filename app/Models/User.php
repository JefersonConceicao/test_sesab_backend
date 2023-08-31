<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;
use App\Models\Endereco;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'cpf', 'email_verified_at', 'perfil_id'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }

    public function enderecos(){
        return $this->belongsToMany(Endereco::class, 'enderecos_users', 'user_id', 'endereco_id');
    }

    public function getUsuarios(array $request = [])
    {
        $conditions = [];

        return $this
            ->with('perfil')
            ->orderBy('id', 'DESC')
            ->paginate(15);
    }

    public function saveUser(array $request = [])
    {
        DB::beginTransaction();

        try{
            if(!$this->fill($request)->save()){
                throw new \Exception();
            }

            if(isset($request['enderecos']) && !empty($request['enderecos'])){

                foreach ($request['enderecos'] as $requestEndereco){
                    $endereco = Endereco::where('cep', '=', $requestEndereco['cep'])->first();

                    if(empty($endereco)){
                        $endereco = Endereco::create($requestEndereco);
                    }

                    if(!$endereco){
                        throw new \Exception();
                    }

                    $this->enderecos()->attach([$endereco->id]);
                }
            }

            DB::commit();
            return $this;
        }catch(\Exception $error){
            DB::rollback();
            return false;
        }
    }

    public function updateUser(User $user, array $request = [])
    {
        return $user->fill($request)->save();
    }
}
