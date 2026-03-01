<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isCreate = $this->isMethod('post');

        return [
            'cpf' => [
                'required',
                'regex:/^\d{3}\.?\d{3}\.?\d{3}\-?\d{2}$/',
            ],
            'value' => ['required', 'numeric', 'min:0.01'],
            'status' => ['required', Rule::in(['Em processamento', 'Aprovada', 'Negada'])],

            'archive' => ['nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.regex' => 'Informe um CPF válido.',

            'value.required' => 'O valor é obrigatório.',
            'value.numeric' => 'O valor deve ser numérico.',
            'value.min' => 'O valor deve ser maior que zero.',

            'status.required' => 'O status é obrigatório.',
            'status.in' => "Status inválido. Status Aceito: 'Em processamento', 'Aprovada', 'Negada'",

            'archive.required' => 'O arquivo é obrigatório.',
            'archive.file' => 'Arquivo inválido.',
            'archive.mimes' => 'O arquivo deve ser PDF, JPG ou PNG.',
            'archive.max' => 'O arquivo deve ter no máximo 5MB.',

            'archive_id.required' => 'O arquivo atual é obrigatório quando nenhum novo arquivo for enviado.',
            'archive_id.exists' => 'Arquivo atual inválido.',
        ];
    }

    /**
     * @throws HttpResponseException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Erro de validação',
            'errors' => $validator->errors(),
        ], 422));
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Não autorizado',
        ], 403));
    }
}
