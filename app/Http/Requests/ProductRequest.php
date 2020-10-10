<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'supplier_id' => 'required',
            'name' => 'required',
            'minimum_stock' => 'required',
            'buy' => 'required',
            'sell' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'supplier_id.required' => 'Wajib untuk memilih supplier produk',
            'name.required' => 'Nama produk harus diisi',
            'minimum_stock.required' => 'Minimal stok produk harus diisi',
            'buy.required' => 'Harga beli produk harus diisi',
            'sell.required' => 'Harga jual produk harus diisi',
        ];
    }
}
