<?php

namespace CodeDelivery\Http\Requests;

use CodeDelivery\Http\Requests\Request;

class AdminProductRequest extends Request
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
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required'
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Informe o nome da Categoria',
            'name.min' => 'O nome da categoria deve conter no mínimo 3 caracteres',
            'description.required' => 'Preencha a descrição do produto',
            'price.required' => 'Informe o preço do produto'
        ];
    }

}
