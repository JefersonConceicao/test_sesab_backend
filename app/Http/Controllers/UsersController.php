<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Endereco;
use DB;

class UsersController extends Controller
{
    /**
     * Listagem de usuários.
     *
     * @return \Illuminate\Http\Response
     */

    private $user;
    private $endereco;

    public function __construct(User $user, Endereco $endereco){
        $this->user = $user;
        $this->endereco = $endereco;
    }

    public function index(Request $request)
    {
        $data = $this->user->getUsuarios($request->all());
        return response()->json($data);
    }

    /**
     * Método responsável por armazenar os usuários.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $novoUsuario = $this->user->saveUser($request->all());

        if(!$novoUsuario){
            return response([
                'error' => true,
                'msg' => 'Não foi possível adicionar o registro, tente novamente mais tarde'
            ]);
        }

        return response(['error' => false, 'msg' => 'Registro adicionado com sucesso!']);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $usuarioAtualizado = $this->user->updateUser($user, $request->all());

        if(!$usuarioAtualizado){
            return response([
                'error' => true,
                'msg' => 'Não foi possível atualizar o registro, tente novamente mais tarde'
            ]);
        }

        return response(['error' => false, 'msg' => 'Registro atualizado com sucesso!']);
    }

    /**
     * Detalhar Informações de um usuárioe especifico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $detalhesUser = $user;

        $detalhesUser['perfil'] = $user->perfil;
        $detalhesUser['enderecos'] = $user->enderecos;

        return response()->json($detalhesUser);
    }

    public function adicionarEndereco(User $user, UserRequest $request)
    {
        $enderecoAdicionado = $this->endereco->salvaEnderecoDoUsuario($user, $request->all());

        if(!$enderecoAdicionado){
            return response([
                'error' => true,
                'msg' => 'Não foi possível adicionar o registro, tente novamente mais tarde'
            ]);
        }

        return response(['error' => false, 'msg' => 'Registro adicionado com sucesso!']);
    }

    public function removerEndereco(User $user, Endereco $endereco)
    {
        $enderecoRemovido = $this->endereco->removeEnderecoDoUsuario($user, $endereco);

        if(!$enderecoRemovido){
            return response([
                'error' => true,
                'msg' => 'Não foi possível remover o registro, tente novamente mais tarde'
            ]);
        }

        return response(['error' => false, 'msg' => 'Registro removido com sucesso!']);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function excluirUsuario(User $user)
    {
        DB::beginTransaction();

        try{
            $deletePivot = DB::table('enderecos_users')->where('user_id', $user->id)->delete();

            if(!$deletePivot){
                throw new \Exception();
            }

            if(!$user->delete()){
               throw new \Exception();
            }

            DB::commit();
            return response(['error' => false, 'msg' => 'Registro removido com sucesso!']);

        }catch(\Exception $error){
            DB::rollback();
            return [
                'error' => true,
                'msg' => 'Ocorreu um erro interno, tente novamente mais tarde'
            ];
        }
    }
}
