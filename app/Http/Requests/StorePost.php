<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|unique:posts|max:255',
            'description' => 'required|max:255',
        ];
        // Adding to rules the thumbnail if exist
        if( $this->file('thumbnail') ) {
            $rules['thumbnail'] = 'image';
        }
        return $rules;
    }
}
