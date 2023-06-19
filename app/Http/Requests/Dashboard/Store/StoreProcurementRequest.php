<?php

namespace App\Http\Requests\Dashboard\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreProcurementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'string|required|unique:procurements',
            'provider_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Un approvisionnement portant ce nom existe déjà.',
            'provider_id.required' => 'Affectez un fournisseur à l\'approvisionnement',
        ];
    }
}
