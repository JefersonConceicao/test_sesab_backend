<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $nomeRotaAtual = explode('.', Route::currentRouteName());

        switch (end($nomeRotaAtual)) {
            case 'save':
                return [
                    'name' => 'required',
                    'cpf' => 'required|unique:users',
                    'email' => 'required|email|unique:users',
                    'perfil_id' => 'required',
                    'enderecos.*.cep' => 'required',
                    'enderecos.*.nome_logradouro' => 'required',
                    'enderecos.*.bairro' => 'required',
                    'enderecos.*.municipio' => 'required',
                ];

            case 'update':
                return [
                    'name' => 'required',
                    'cpf' => [
                        'required',
                        Rule::unique('users')->ignore($this->user->id)
                    ],
                    'email' => [
                        'required',
                        'email',
                        Rule::unique('users')->ignore($this->user->id)
                    ],
                    'perfil_id' => 'required',
                    'enderecos.*.cep' => 'required',
                    'enderecos.*.nome_logradouro' => 'required',
                    'enderecos.*.bairro' => 'required',
                    'enderecos.*.municipio' => 'required',

                ];

            case 'adicionarEndereco':
                return [
                    'enderecos.*.cep' => 'required',
                    'enderecos.*.nome_logradouro' => 'required',
                    'enderecos.*.bairro' => 'required',
                    'enderecos.*.municipio' => 'required',
                ];
        }
    }

    public function messages(): array
    {
        return [
            'required' => 'Campo obrigatório',
            'email' => 'Informe um e-mail válido',
            'unique' => ':attribute já existe em nossa base'
        ];
    }
}
