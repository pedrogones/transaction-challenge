<?php

namespace App\Http\Requests\Tenant;

use App\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateTenantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $tenantParam = $this->route('tenant');
        $tenant = $tenantParam instanceof Tenant ? $tenantParam : Tenant::find($tenantParam);
        return [
            'id' => [ 'nullable', 'string', 'max:50', 'regex:/^[a-zA-Z0-9\-]+$/', Rule::unique('tenants', 'id')->ignore($tenant?->id, 'id')],
            'name' => ['required', 'string', 'max:120'],
            'domain' => ['required', 'string', 'max:255', Rule::unique('domains', 'domain')->ignore($tenant?->id, 'tenant_id')],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string'   => 'O nome deve ser um texto válido.',
            'name.max'      => 'O nome deve ter no máximo 120 caracteres.',

            'id.string' => 'O identificador do tenant deve ser um texto.',
            'id.max'    => 'O identificador do tenant deve ter no máximo 50 caracteres.',
            'id.regex'  => 'O identificador do tenant deve conter apenas letras, números e hífen.',
            'id.unique' => 'Este identificador de tenant já está em uso, altere o Nome do Tenant ou Ajuste o Identificador.',

            'domain.required' => 'O domínio é obrigatório.',
            'domain.string'   => 'O domínio deve ser um texto válido.',
            'domain.max'      => 'O domínio deve ter no máximo 255 caracteres.',
            'domain.unique'   => 'Este domínio já está cadastrado.',

            'is_active.required' => 'O status ativo é obrigatório.',
            'is_active.boolean'  => 'O status ativo deve ser verdadeiro ou falso.',
        ];
    }
}
